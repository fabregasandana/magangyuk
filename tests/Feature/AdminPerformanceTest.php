<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminPageController;
use App\Models\Absensi;
use App\Models\ActivityLog;
use App\Models\DataMagang;
use App\Models\Institusi;
use App\Models\KriteriaPenilaian;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPerformanceTest extends TestCase
{
    use RefreshDatabase;

    private array $loadedDetailRatings = [];

    private array $loadedRatings = [];

    private array $criteria = [];

    protected function beforeRefreshingDatabase(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->assertEmpty(config('database.connections.sqlite.url'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-11-05 00:00:00'));
        Event::listen('eloquent.retrieved: '.PenilaianDetail::class, function (PenilaianDetail $detail): void {
            $this->loadedDetailRatings[] = $detail->penilaian_id;
        });
        Event::listen('eloquent.retrieved: '.Penilaian::class, function (Penilaian $rating): void {
            $this->loadedRatings[] = $rating->id;
        });
    }

    public static function scales(): array
    {
        return ['small' => [1], 'scaled' => [12]];
    }

    public static function ratingScales(): array
    {
        return ['small' => [1], 'over_page_limit' => [35]];
    }

    #[DataProvider('scales')]
    public function test_supporting_features_batch_counts_without_changing_totals(int $size): void
    {
        $expectedPeriods = [];
        $expectedInstitutions = [];
        for ($i = 0; $i < $size; $i++) {
            $suffix = sprintf('%02d', $i);
            $period = $this->period($suffix);
            $period->update([
                'tanggal_mulai' => now()->subDays(3 + $i * 7),
                'tanggal_selesai' => now()->subDays($i * 7),
                'status' => $i === 0 ? 'aktif' : 'selesai',
            ]);
            $institution = $this->institution($suffix);
            $this->participant('A'.$suffix, institution: $institution, period: $period);
            $inactive = $this->participant('B'.$suffix, institution: $institution, period: $period);
            $inactive->update(['status' => 'nonaktif']);
            $expectedPeriods[(string) $period->id] = 2;
            $expectedInstitutions[(string) $institution->id] = 2;
        }
        $emptyPeriod = $this->period('empty');
        $emptyPeriod->update(['tanggal_mulai' => '2025-01-01', 'tanggal_selesai' => '2025-01-04', 'status' => 'selesai']);
        $emptyInstitution = $this->institution('empty');
        $expectedPeriods[(string) $emptyPeriod->id] = 0;
        $expectedInstitutions[(string) $emptyInstitution->id] = 0;
        $unlinked = $this->participant('unlinked');
        ActivityLog::create(['user_id' => $unlinked->id, 'role' => 'peserta', 'aksi' => 'login', 'deskripsi' => 'Masuk']);

        [$data, $queries] = $this->page('featurePendukung');

        $this->assertCount(10, $queries, implode("\n", $queries));
        $this->assertSame($expectedPeriods, array_column($data['periode'], 'peserta', 'id'));
        $this->assertSame($expectedInstitutions, array_column($data['institusi'], 'peserta', 'id'));
        $this->assertSame(['total' => $size + 1, 'aktif' => 1, 'peserta' => $size * 2 + 1, 'progress' => '100%'], $data['periodeStats']);
        $this->assertSame('Aktif', $data['periode'][0]['status']);
        $this->assertSame('Selesai', $data['periode'][$size]['status']);
        $this->assertSame(['ditampilkan' => 1, 'total' => 1], $data['logMeta']);
        $this->assertSame($unlinked->name, $data['logs'][0]['user']);
    }

    #[DataProvider('ratingScales')]
    public function test_rating_list_batches_internship_codes_and_preserves_latest_thirty(int $size): void
    {
        $this->period('active');
        $mentor = $this->user('Mentor', User::ROLE_PEMBIMBING);
        $expected = [];
        for ($i = 0; $i < $size; $i++) {
            $suffix = sprintf('%02d', $i);
            $participant = $this->participant($suffix);
            $rating = $this->rating($participant, 80, [4, 5], $mentor);
            $expected[] = [
                'id' => sprintf('PNL-%03d', $rating->id),
                'kode' => 'MKD-'.$suffix,
                'nama' => $participant->name,
            ];
        }

        [$data, $queries] = $this->page('kelolaPenilaian');

        $this->assertCount(10, $queries, implode("\n", $queries));
        $this->assertCount(min(30, $size), $data['penilaian']);
        foreach (array_slice(array_reverse($expected), 0, 30) as $index => $row) {
            $actual = $data['penilaian'][$index];
            $this->assertSame($row, array_intersect_key($actual, $row));
            $this->assertSame('4.5', $actual['nilai']);
            $this->assertSame(80, $actual['skor']);
            $this->assertSame('Mentor', $actual['pembimbing']);
            $this->assertSame([
                ['kriteria' => 'Kriteria 0', 'nilai' => 4.0],
                ['kriteria' => 'Kriteria 1', 'nilai' => 5.0],
            ], $actual['rincian']);
        }
        $this->assertSame(100, $data['totalBobot']);
        $this->assertSame($size, $data['pagination']['total']);
        $this->assertSame(min(30, $size), $data['pagination']['sampai']);
    }

    #[DataProvider('scales')]
    public function test_mentor_management_uses_lightweight_participants_and_latest_preview_scores(int $size): void
    {
        $period = $this->period('active');
        $expectedParticipants = [];
        $expectedMentors = [];
        $latestRatingIds = [];
        for ($i = 0; $i < $size; $i++) {
            $suffix = sprintf('%02d', $i);
            $mentor = $this->user('Mentor '.$suffix, User::ROLE_PEMBIMBING, $i % 2 === 0 ? 'aktif' : 'nonaktif');
            $institution = $this->institution($suffix);
            $rated = $this->participant('Z'.$suffix, $mentor, $institution, $period);
            $fallback = $this->participant('F'.$suffix, $mentor, attributes: ['id_kode' => null]);
            $fallback->update(['status' => 'nonaktif']);
            $zero = $this->participant('M'.$suffix, $mentor, $institution, $period);
            $fourth = $this->participant('N'.$suffix, $mentor, $institution, $period);
            $unassigned = $this->participant('A'.$suffix);
            $unassigned->update(['status' => 'selesai']);
            $this->rating($rated, 20, [1], $mentor);
            $latestRatingIds[] = $this->rating($rated, 80, [4, 5], $mentor)->id;
            $this->rating($rated, 99, [5], $mentor, '2026-11-01');
            $latestRatingIds[] = $this->rating($fallback, 78, [], $mentor)->id;
            $latestRatingIds[] = $this->rating($zero, 100, [0], $mentor)->id;
            $this->rating($fourth, 60, [3], $mentor);

            foreach ([$rated, $fallback, $zero, $fourth, $unassigned] as $participant) {
                $magang = $participant->dataMagang;
                $expectedParticipants[] = [
                    'id' => $magang->id_kode ?: 'MKD-'.$participant->id,
                    'nama' => $participant->name,
                    'institusi' => $magang->institusi_id === null ? 'Kampus Lama' : $institution->kode,
                    'sort' => $magang->id_kode ?? '',
                ];
            }
            $expectedMentors[$mentor->id] = [
                'assigned' => ['MKD-Z'.$suffix, '-', 'MKD-M'.$suffix, 'MKD-N'.$suffix],
                'institution' => $institution->singkat,
                'preview' => [
                    ['initial' => $rated->inisial, 'nama' => $rated->name, 'skor' => '4.5'],
                    ['initial' => $fallback->inisial, 'nama' => $fallback->name, 'skor' => '3.9'],
                    ['initial' => $zero->inisial, 'nama' => $zero->name, 'skor' => '0.0'],
                ],
            ];
        }
        $excluded = $this->participant('excluded');
        $excluded->update(['role' => User::ROLE_ADMIN]);
        $this->user('Without internship');
        usort($expectedParticipants, fn (array $a, array $b) => $a['sort'] <=> $b['sort']);
        $expectedParticipants = array_map(function (array $row): array {
            unset($row['sort']);

            return $row;
        }, $expectedParticipants);

        [$data, $queries] = $this->page('manajemenPembimbing');

        $this->assertCount(14, $queries, implode("\n", $queries));
        $this->assertSame($expectedParticipants, $data['pesertaTersedia']);
        $this->assertSame(array_slice($expectedParticipants, 0, 2), $data['pesertaTerassign']);
        $this->assertSame($size * 5, $data['pembimbingStats']['peserta_dibimbing']);
        $this->assertSame($size, $data['pembimbingStats']['total']);
        $this->assertSame((int) ceil($size / 2), $data['pembimbingStats']['aktif']);
        foreach ($data['pembimbing'] as $row) {
            $expected = $expectedMentors[$row['uid']];
            $this->assertSame(4, $row['jumlah_peserta']);
            $this->assertSame(73, $row['skor_persen']);
            $this->assertSame('3.7', $row['skor']);
            $this->assertSame($expected['preview'], $row['bimbingan']);
            $this->assertSame($expected['assigned'], array_column($row['terassign'], 'id'));
            $this->assertSame($expected['institution'], $row['terassign'][0]['institusi']);
            $this->assertSame('Kampus Lama', $row['terassign'][1]['institusi']);
            $this->assertSame(array_values(array_filter(
                $expectedParticipants,
                fn (array $participant) => ! in_array($participant['id'], $expected['assigned'], true),
            )), $row['tersedia']);
        }
        $this->assertEqualsCanonicalizing($latestRatingIds, $this->loadedRatings);
        $this->assertCount($size * 3, $this->loadedDetailRatings);
        foreach (['absensi', 'laporan', 'logbook'] as $table) {
            $this->assertStringNotContainsString('from "'.$table.'"', implode("\n", $queries));
        }
    }

    #[DataProvider('scales')]
    public function test_recap_loads_only_latest_details_and_keeps_history_counts_and_calculations(int $size): void
    {
        $period = $this->period('active');
        $institution = $this->institution('active');
        $mentor = $this->user('Mentor', User::ROLE_PEMBIMBING);
        $expected = [];
        $expectedDetails = [];
        for ($i = 0; $i < $size; $i++) {
            $suffix = sprintf('%02d', $i);
            $rated = $this->participant('rated'.$suffix, $mentor, $institution, $period);
            $fallback = $this->participant('fallback'.$suffix, $mentor, $institution, $period);
            $zero = $this->participant('zero'.$suffix, $mentor, $institution, $period);
            $unrated = $this->participant('unrated'.$suffix, $mentor, $institution, $period);
            $this->rating($rated, 100, [5], $mentor, '2026-11-01');
            $this->rating($rated, 40, [1], $mentor);
            $latest = $this->rating($rated, 80, [4, 5], $mentor);
            $this->rating($rated, 99, [1], $mentor, '2026-11-02');
            $this->rating($fallback, 78, [], $mentor);
            $zeroRating = $this->rating($zero, 100, [0], $mentor);
            $expectedDetails = [...$expectedDetails, $latest->id, $latest->id, $zeroRating->id];
            $expected[$rated->id] = ['skor' => 80.0, 'penilaian' => '4.5', 'jumlah_penilaian' => 4];
            $expected[$fallback->id] = ['skor' => 78.0, 'penilaian' => '3.9', 'jumlah_penilaian' => 1];
            $expected[$zero->id] = ['skor' => 100.0, 'penilaian' => '0.0', 'jumlah_penilaian' => 1];
            $expected[$unrated->id] = ['skor' => 0.0, 'penilaian' => '0.0', 'jumlah_penilaian' => 0];
            foreach (['2026-10-29' => 'hadir', '2026-11-02' => 'hadir', '2026-11-03' => 'terlambat', '2026-11-04' => 'izin'] as $date => $status) {
                Absensi::create(['user_id' => $rated->id, 'tanggal' => $date, 'status' => $status]);
            }
            Laporan::create(['user_id' => $rated->id, 'tipe' => 'mingguan', 'status' => 'disetujui']);
            Laporan::create(['user_id' => $rated->id, 'tipe' => 'mingguan', 'status' => 'draft']);
            Laporan::create(['user_id' => $rated->id, 'tipe' => 'akhir', 'status' => 'disetujui']);
        }

        [$data, $queries] = $this->page('manajemenPeserta');

        $this->assertCount(14, $queries, implode("\n", $queries));
        $this->assertSame($size * 4, $data['pesertaStats']['total']);
        $this->assertEqualsCanonicalizing($expectedDetails, $this->loadedDetailRatings);
        foreach ($data['peserta'] as $row) {
            $this->assertSame($expected[$row['uid']], array_intersect_key($row, $expected[$row['uid']]));
            $this->assertSame($institution->kode, $row['institusi_key']);
            $this->assertSame($period->kode, $row['periode_key']);
            $this->assertSame($mentor->name, $row['pembimbing']);
            if ($row['jumlah_penilaian'] === 4) {
                $this->assertSame(50, $row['hadir']);
                $this->assertSame(2, $row['hadir_hari']);
                $this->assertSame(1, $row['terlambat']);
                $this->assertSame(1, $row['izin_hari']);
                $this->assertSame(1, $row['alpha']);
                $this->assertSame('1/2', $row['laporan']);
            }
        }
    }

    public function test_empty_admin_lists_and_unrated_participants_keep_their_defaults(): void
    {
        [$support] = $this->page('featurePendukung');
        [$ratings] = $this->page('kelolaPenilaian');
        [$mentors] = $this->page('manajemenPembimbing');
        [$participants] = $this->page('manajemenPeserta');
        $this->assertSame([], $support['periode']);
        $this->assertSame([], $support['institusi']);
        $this->assertSame([], $ratings['penilaian']);
        $this->assertSame([], $mentors['pesertaTersedia']);
        $this->assertSame([], $participants['peserta']);
        $this->participant('unrated');

        [$participants] = $this->page('manajemenPeserta');

        $this->assertSame('0.0', $participants['peserta'][0]['penilaian']);
        $this->assertSame(0, $participants['peserta'][0]['jumlah_penilaian']);
    }

    public function test_optimized_admin_routes_still_require_an_admin(): void
    {
        $routes = ['admin.feature-pendukung', 'admin.kelola-penilaian', 'admin.manajemen-pembimbing', 'admin.manajemen-peserta'];
        foreach ($routes as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
        foreach ([User::ROLE_PESERTA, User::ROLE_PEMBIMBING] as $role) {
            $this->actingAs($this->user($role, $role));
            foreach ($routes as $route) {
                $this->get(route($route))->assertForbidden();
            }
        }
    }

    /** Measure controller data queries, excluding fixtures and Blade rendering. */
    private function page(string $method): array
    {
        $this->loadedRatings = [];
        $this->loadedDetailRatings = [];
        DB::flushQueryLog();
        DB::enableQueryLog();
        try {
            $data = (new AdminPageController)->{$method}()->getData();
            $queries = array_column(DB::getQueryLog(), 'query');
        } finally {
            DB::disableQueryLog();
        }

        return [$data, $queries];
    }

    private function user(string $name, string $role = User::ROLE_PESERTA, string $status = 'aktif'): User
    {
        return User::factory()->create(['nama_lengkap' => $name, 'role' => $role, 'status' => $status]);
    }

    private function period(string $suffix): Periode
    {
        return Periode::create([
            'kode' => 'PER-'.$suffix, 'nama' => 'Periode '.$suffix,
            'tanggal_mulai' => '2026-11-02', 'tanggal_selesai' => '2026-11-05', 'status' => 'aktif',
        ]);
    }

    private function institution(string $suffix): Institusi
    {
        return Institusi::create(['kode' => 'INS-'.$suffix, 'nama' => 'Institusi '.$suffix, 'singkat' => 'I'.$suffix]);
    }

    private function participant(string $suffix, ?User $mentor = null, ?Institusi $institution = null, ?Periode $period = null, array $attributes = []): User
    {
        $user = $this->user('Peserta '.$suffix);
        DataMagang::create(array_replace([
            'user_id' => $user->id, 'id_kode' => 'MKD-'.$suffix, 'nis_nim' => $suffix,
            'institusi' => 'Kampus Lama', 'institusi_id' => $institution?->id,
            'prodi' => 'Informatika', 'penempatan' => 'Medan', 'bidang' => 'TI',
            'periode' => 'Periode Lama', 'periode_id' => $period?->id,
            'status' => 'aktif', 'pembimbing_id' => $mentor?->id,
        ], $attributes));

        return $user;
    }

    private function rating(User $participant, float $score, array $values = [], ?User $mentor = null, string $date = '2026-11-04'): Penilaian
    {
        $rating = Penilaian::create([
            'peserta_id' => $participant->id, 'pembimbing_id' => $mentor?->id,
            'total_skor' => $score, 'tanggal' => $date, 'jenis' => 'mingguan',
        ]);
        foreach ($values as $index => $value) {
            $criterion = $this->criteria[$index] ??= KriteriaPenilaian::create([
                'kode' => 'KRT-'.$index, 'nama' => 'Kriteria '.$index, 'bobot' => 50, 'urutan' => $index + 1,
            ]);
            $rating->detail()->create(['kriteria_penilaian_id' => $criterion->id, 'nilai' => $value]);
        }

        return $rating;
    }
}

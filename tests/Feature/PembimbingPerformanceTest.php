<?php

namespace Tests\Feature;

use App\Http\Controllers\PembimbingPageController;
use App\Models\Absensi;
use App\Models\DataDiri;
use App\Models\DataMagang;
use App\Models\KriteriaPenilaian;
use App\Models\Logbook;
use App\Models\Pengaturan;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use ReflectionMethod;
use Tests\TestCase;

class PembimbingPerformanceTest extends TestCase
{
    use RefreshDatabase;

    private User $mentor;

    protected function beforeRefreshingDatabase(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->assertEmpty(config('database.connections.sqlite.url'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-11-18 12:00:00'));
        $this->withoutVite();
        $this->mentor = $this->user('Mentor Utama', User::ROLE_PEMBIMBING);
        DataDiri::create([
            'user_id' => $this->mentor->id,
            'nik' => '1234567890123456',
            'nama_lengkap' => $this->mentor->nama_lengkap,
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Medan',
            'jenis_kelamin' => 'L',
            'email' => $this->mentor->email,
            'no_hp' => '08123456789',
        ]);
        $this->actingAs($this->mentor);
    }

    public function test_participant_page_queries_stay_constant_as_participants_grow(): void
    {
        $periode = $this->periode('2026-11-16', '2026-11-26');
        $this->participant($periode);
        $this->participant($periode);
        $this->mentor->load('dataDiri');
        Pengaturan::ambil('min_skor', 75);
        Pengaturan::ambil('min_kehadiran', 80);

        [$small, $smallQueries] = $this->capture(fn () => (new PembimbingPageController)->peserta()->getData());
        for ($i = 0; $i < 20; $i++) {
            $participant = $this->participant($periode);
            $this->attendance($participant, ['2026-11-16' => 'hadir']);
            $this->score($participant, 81, '2026-11-17');
            $this->logbook($participant, 1);
        }
        [$large, $largeQueries] = $this->capture(fn () => (new PembimbingPageController)->peserta()->getData());

        $this->assertCount(2, $small['peserta']);
        $this->assertCount(22, $large['peserta']);
        $this->assertCount(count($smallQueries), $largeQueries);
        $this->assertLessThanOrEqual(8, count($largeQueries));
        $attendanceQueries = $this->queriesContaining($largeQueries, 'from "absensi"');
        $this->assertCount(1, $attendanceQueries);
        $this->assertStringContainsString('"user_id" in', $attendanceQueries[0]['query']);
        $this->assertStringContainsString('select "user_id", "tanggal", "status"', $attendanceQueries[0]['query']);
    }

    public function test_cards_preserve_period_boundaries_latest_score_ties_and_weekly_lateness(): void
    {
        $past = $this->periode('2026-11-02', '2026-11-05');
        $current = $this->periode('2026-11-16', '2026-11-26');
        $first = $this->participant($past, 'Zeta Peserta');
        $second = $this->participant($current, 'Alfa Peserta');
        $this->attendance($first, [
            '2026-11-01' => 'hadir', '2026-11-02' => 'hadir', '2026-11-03' => 'terlambat',
            '2026-11-04' => 'hadir', '2026-11-05' => 'hadir', '2026-11-16' => 'terlambat',
            '2026-11-19' => 'terlambat',
        ]);
        $this->attendance($second, [
            '2026-11-15' => 'hadir', '2026-11-16' => 'hadir', '2026-11-17' => 'izin',
            '2026-11-18' => 'terlambat', '2026-11-19' => 'hadir', '2026-11-26' => 'hadir',
        ]);
        $this->score($first, 90, '2026-11-17');
        $this->score($first, 70.4, '2026-11-17');
        $this->score($first, 99, '2026-11-10');
        $this->logbook($first, 1);
        $this->logbook($first, 2, Logbook::STATUS_DISETUJUI);
        $outsider = $this->participant($past, mentor: $this->user('Mentor Lain', User::ROLE_PEMBIMBING));
        $this->score($outsider, 100, '2026-11-18');
        $this->attendance($outsider, ['2026-11-18' => 'hadir']);
        $this->logbook($outsider, 1);

        $data = (new PembimbingPageController)->peserta()->getData();
        [$a, $b] = $data['peserta'];
        $this->assertSame([$first->id, $second->id], array_column($data['peserta'], 'id'));
        $this->assertSame([
            'id', 'nama', 'inisial', 'id_peserta', 'institusi', 'skor', 'kehadiran',
            'logbook_terisi', 'logbook_total', 'logbook_kosong', 'jumlah_penilaian', 'status',
            'avatar', 'bar', 'catatan', 'catatan_badge', 'unit_kerja', 'periode', 'periode_key',
            'logbook_persen', 'skor_color', 'hadir_color', 'logbook_color', 'card_border', 'gaya',
        ], array_keys($a));
        $this->assertSame(70, $a['skor']);
        $this->assertSame(3, $a['jumlah_penilaian']);
        $this->assertSame(100, $a['kehadiran']);
        $this->assertSame(2, $a['logbook_terisi']);
        $this->assertSame(1, $a['logbook_total']);
        $this->assertSame(0, $a['logbook_kosong']);
        $this->assertSame(100, $a['logbook_persen']);
        $this->assertSame('perhatian', $a['status']);
        $this->assertSame('1x Terlambat minggu ini', $a['catatan']);
        $this->assertSame('bg-amber-100 text-amber-700', $a['catatan_badge']);
        $this->assertSame('ZP', $a['inisial']);
        $this->assertSame('MKD-'.$first->id, $a['id_peserta']);
        $this->assertSame('Kampus Uji', $a['institusi']);
        $this->assertSame($past->rentang, $a['periode']);
        $this->assertSame('bg-gradient-to-br from-indigo-500 to-purple-500', $a['avatar']);
        $this->assertSame(0, $b['skor']);
        $this->assertSame(0, $b['jumlah_penilaian']);
        $this->assertSame(67, $b['kehadiran']);
        $this->assertSame(2, $b['logbook_kosong']);
        $this->assertSame('Kehadiran 67%', $b['catatan']);
        $this->assertSame('text-rose-400', $b['hadir_color']);
        $this->assertSame(1, $data['ringkasan']['logbook_pending']);
    }

    public function test_missing_future_and_completed_period_cards_keep_status_precedence(): void
    {
        $past = $this->periode('2026-11-16', '2026-11-16');
        $future = $this->periode('2026-11-23', '2026-11-26');
        $active = $this->participant($past);
        $disabled = $this->participant($past, status: 'nonaktif');
        $finished = $this->participant(null, status: 'selesai');
        $finished->update(['status' => 'nonaktif']);
        $userFinished = $this->participant(null, status: 'nonaktif');
        $userFinished->update(['status' => 'selesai']);
        $upcoming = $this->participant($future);
        $missing = $this->participant(null);
        $this->attendance($active, ['2026-11-16' => 'hadir']);
        $this->attendance($disabled, ['2026-11-16' => 'hadir']);
        $this->attendance($upcoming, ['2026-11-24' => 'hadir']);
        $this->attendance($missing, ['2026-11-24' => 'hadir']);

        $cards = (new PembimbingPageController)->peserta()->getData()['peserta'];
        $this->assertSame(['aktif', 'perhatian', 'selesai', 'selesai', 'perhatian', 'perhatian'], array_column($cards, 'status'));
        $this->assertSame([100, 100, 0, 0, 0, 0], array_column($cards, 'kehadiran'));
        $this->assertNull($cards[0]['catatan']);
        $this->assertNull($cards[2]['catatan']);
        $this->assertSame('all', $cards[5]['periode_key']);
        $this->assertSame('Periode lama', $cards[5]['periode']);
        $this->assertSame(1, $cards[5]['logbook_total']);
    }

    public function test_non_statistics_bimbingan_does_not_query_statistics(): void
    {
        $this->participant($this->periode('2026-11-16', '2026-11-26'));
        [$rows, $queries] = $this->capture(fn () => $this->invoke('bimbingan'));

        $this->assertCount(1, $rows);
        foreach (['penilaian', 'logbook', 'absensi'] as $table) {
            $this->assertSame([], $this->queriesContaining($queries, '"'.$table.'"'));
        }
    }

    public function test_weekly_chart_uses_one_query_and_preserves_full_week_numerators(): void
    {
        $periode = $this->periode('2026-09-14', '2026-11-22');
        $participant = $this->participant($periode);
        $this->attendance($participant, [
            '2026-09-21' => 'hadir', '2026-09-28' => 'hadir', '2026-11-02' => 'terlambat',
            '2026-11-08' => 'hadir', '2026-11-09' => 'hadir', '2026-11-16' => 'izin',
            '2026-11-18' => 'hadir', '2026-11-20' => 'hadir',
        ]);
        $this->attendance($this->participant($periode), ['2026-11-17' => 'hadir']);

        [$chart, $queries] = $this->capture(fn () => $this->invoke('kehadiranMingguan', $participant, $periode));
        $this->assertSame([
            'labels' => ['Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6', 'Minggu 7', 'Minggu 8', 'Minggu 9', 'Minggu 10'],
            'data' => [25, 0, 0, 0, 0, 50, 25, 67],
        ], $chart);
        $this->assertCount(1, $queries);

        $short = $this->periode('2026-11-16', '2026-11-22');
        [$oneWeek, $shortQueries] = $this->capture(fn () => $this->invoke('kehadiranMingguan', $participant, $short));
        $this->assertSame(['labels' => ['Minggu 1'], 'data' => [67]], $oneWeek);
        $this->assertCount(1, $shortQueries);
        $this->assertSame(['labels' => [], 'data' => []], $this->invoke('kehadiranMingguan', $participant, null));
        $future = $this->periode('2026-11-23', '2026-11-26');
        $this->assertSame(['labels' => [], 'data' => []], $this->invoke('kehadiranMingguan', $participant, $future));
    }

    public function test_dashboard_limits_pending_logbooks_in_sql_but_logbook_page_keeps_all(): void
    {
        $periode = $this->periode('2026-10-01', '2026-11-30');
        $first = $this->participant($periode);
        $second = $this->participant($periode);
        $old = $this->logbook($first, 8, submitted: '2026-11-16 10:00:00');
        $weekOne = $this->logbook($first, 1);
        $weekTwo = $this->logbook($first, 2);
        $tie = $this->logbook($second, 2);
        $newest = $this->logbook($first, 3, submitted: '2026-11-18 11:00:00');
        $this->logbook($first, 4, Logbook::STATUS_DISETUJUI);
        $outsider = $this->participant($periode, mentor: $this->user('Mentor Lain', User::ROLE_PEMBIMBING));
        $this->logbook($outsider, 9, submitted: '2026-11-18 12:00:00');

        [$dashboard, $queries] = $this->capture(fn () => (new PembimbingPageController)->dashboard()->getData());
        $this->assertSame([$newest->id, $tie->id, $weekTwo->id], array_column($dashboard['logbookPending'], 'id'));
        $pendingQueries = $this->queriesContaining($queries, 'select * from "logbook"');
        $this->assertCount(1, $pendingQueries);
        $this->assertStringContainsString('limit 3', $pendingQueries[0]['query']);
        $this->assertSame(5, $dashboard['ringkasan']['logbook_pending']);

        $page = (new PembimbingPageController)->logbook()->getData();
        $this->assertSame(5, $page['jumlahPending']);
        $this->assertSame([$newest->id, $tie->id, $weekTwo->id, $weekOne->id, $old->id], array_column($page['logbook'], 'id'));
        $this->assertSame($dashboard['logbookPending'], array_slice($page['logbook'], 0, 3));
    }

    public function test_assessment_details_are_batched_and_updates_preserve_scores_timestamps_and_cleanup(): void
    {
        $participant = $this->participant($this->periode('2026-11-16', '2026-11-26'));
        $first = $this->criterion(1);
        $second = $this->criterion(3);
        $values = [$first->id => 80, $second->id => 60];
        [$response, $queries] = $this->capture(fn () => $this->post(route('pembimbing.penilaian.store'), $this->assessment($participant, $values)));
        $response->assertRedirect(route('pembimbing.penilaianpeserta', ['peserta' => $participant->id]))->assertSessionHasNoErrors();
        $this->assertCount(2, $this->queriesContaining($queries, '"penilaian_detail"'));
        $rating = Penilaian::sole();
        $this->assertSame(65.0, $rating->total_skor);
        $this->assertSame('Kurang', $rating->grade);
        $this->assertFalse($rating->di_override_admin);
        $this->assertSame('2026-11-18', $rating->tanggal->toDateString());
        $detail = $rating->detail()->where('kriteria_penilaian_id', $first->id)->sole();
        $this->assertSame(4.0, $detail->nilai);
        $createdAt = $detail->created_at->toDateTimeString();
        $rating->update(['di_override_admin' => true]);

        for ($i = 0; $i < 6; $i++) {
            $extra = $this->criterion(1);
            $values[$extra->id] = 80;
        }
        $this->travel(1)->minutes();
        [$response, $queries] = $this->capture(fn () => $this->post(route('pembimbing.penilaian.store'), $this->assessment($participant, $values)));
        $response->assertSessionHasNoErrors()->assertRedirect();
        $this->assertCount(2, $this->queriesContaining($queries, '"penilaian_detail"'));
        $this->assertSame(8, $rating->detail()->count());
        $this->assertSame(74.0, $rating->fresh()->total_skor);

        $second->update(['aktif' => false]);
        $this->post(route('pembimbing.penilaian.store'), $this->assessment($participant, [
            $first->id => 93, $extra->id => 40, $second->id => 100, 99999 => 100,
        ]))->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseCount('penilaian', 1);
        $this->assertDatabaseCount('penilaian_detail', 2);
        $this->assertSame(67.0, $rating->fresh()->total_skor);
        $this->assertTrue($rating->fresh()->di_override_admin);
        $this->assertSame(4.7, $detail->fresh()->nilai);
        $this->assertSame($createdAt, $detail->fresh()->created_at->toDateTimeString());
        $this->assertTrue($detail->fresh()->updated_at->greaterThan($detail->updated_at));
        $this->assertDatabaseMissing('penilaian_detail', ['kriteria_penilaian_id' => $second->id]);
        $this->assertDatabaseCount('activity_log', 3);
    }

    public function test_assessment_and_detail_access_remain_mentor_scoped_and_validated(): void
    {
        $periode = $this->periode('2026-11-16', '2026-11-26');
        $own = $this->participant($periode);
        $outsider = $this->participant($periode, mentor: $this->user('Mentor Lain', User::ROLE_PEMBIMBING));
        $criterion = $this->criterion(1);
        $this->post(route('pembimbing.penilaian.store'), $this->assessment($outsider, [$criterion->id => 80]))->assertForbidden();
        $this->get(route('pembimbing.detailpeserta', $outsider))->assertNotFound();
        $this->get(route('pembimbing.penilaianpeserta', ['peserta' => $outsider->id]))->assertNotFound();
        $this->post(route('pembimbing.penilaian.store'), $this->assessment($own, [$criterion->id => 101]))->assertSessionHasErrors('kriteria.'.$criterion->id);
        $this->post(route('pembimbing.penilaian.store'), array_replace($this->assessment($own, [$criterion->id => 80]), ['periode' => 'w99']))->assertUnprocessable();
        $this->post(route('pembimbing.penilaian.store'), $this->assessment($own, [99999 => 80]))->assertUnprocessable();
        $this->assertDatabaseCount('penilaian', 0);
        $this->assertDatabaseCount('penilaian_detail', 0);
        $this->assertDatabaseCount('activity_log', 0);
    }

    public function test_failed_detail_write_rolls_back_the_parent_assessment(): void
    {
        $participant = $this->participant($this->periode('2026-11-16', '2026-11-26'));
        $criterion = $this->criterion(1);
        DB::unprepared("CREATE TEMP TRIGGER fail_detail_insert BEFORE INSERT ON penilaian_detail BEGIN SELECT RAISE(ABORT, 'detail write failed'); END");
        $this->withoutExceptionHandling();

        try {
            $this->post(route('pembimbing.penilaian.store'), $this->assessment($participant, [$criterion->id => 80]));
            $this->fail('The detail insert should fail.');
        } catch (QueryException $exception) {
            $this->assertStringContainsString('detail write failed', $exception->getMessage());
        } finally {
            DB::unprepared('DROP TRIGGER fail_detail_insert');
        }

        $this->assertDatabaseCount('penilaian', 0);
        $this->assertDatabaseCount('penilaian_detail', 0);
        $this->assertDatabaseCount('activity_log', 0);
    }

    private function user(string $name, string $role = User::ROLE_PESERTA): User
    {
        return User::factory()->create(['nama_lengkap' => $name, 'role' => $role, 'status' => 'aktif']);
    }

    private function periode(string $start, string $end): Periode
    {
        return Periode::create([
            'kode' => 'p-'.fake()->unique()->numerify('######').'-2026',
            'nama' => 'Periode Uji',
            'tanggal_mulai' => $start,
            'tanggal_selesai' => $end,
            'status' => 'aktif',
        ]);
    }

    private function participant(?Periode $periode, string $name = 'Peserta Uji', ?User $mentor = null, string $status = 'aktif'): User
    {
        $user = $this->user($name);
        DataMagang::create([
            'user_id' => $user->id, 'pembimbing_id' => ($mentor ?? $this->mentor)->id,
            'periode_id' => $periode?->id, 'nis_nim' => (string) $user->id,
            'institusi' => 'Kampus Uji', 'prodi' => 'Informatika', 'penempatan' => 'Teknologi',
            'bidang' => 'Teknologi', 'periode' => 'Periode lama', 'status' => $status,
        ]);

        return $user;
    }

    /** @param array<string, string> $dates */
    private function attendance(User $participant, array $dates): void
    {
        foreach ($dates as $date => $status) {
            Absensi::query()->insert(['user_id' => $participant->id, 'tanggal' => $date, 'status' => $status]);
        }
    }

    private function score(User $participant, float $score, string $date): Penilaian
    {
        return Penilaian::create([
            'peserta_id' => $participant->id, 'pembimbing_id' => $this->mentor->id,
            'jenis' => 'mingguan', 'periode_key' => 'w1', 'total_skor' => $score, 'tanggal' => $date,
        ]);
    }

    private function logbook(User $participant, int $week, string $status = Logbook::STATUS_MENUNGGU, string $submitted = '2026-11-17 10:00:00'): Logbook
    {
        return Logbook::create([
            'user_id' => $participant->id, 'minggu_ke' => $week,
            'status' => $status, 'submitted_at' => $submitted, 'uraian' => 'Kegiatan pengujian',
        ]);
    }

    private function criterion(int $weight): KriteriaPenilaian
    {
        return KriteriaPenilaian::create([
            'kode' => fake()->unique()->numerify('K######'), 'nama' => 'Kriteria Uji',
            'bobot' => $weight, 'aktif' => true, 'urutan' => 1,
        ]);
    }

    /** @param array<int, int> $values */
    private function assessment(User $participant, array $values): array
    {
        return [
            'peserta_id' => $participant->id, 'jenis_periode' => 'mingguan', 'periode' => 'w1',
            'kriteria' => $values, 'total_skor' => 100, 'komentar' => 'Penilaian berdasarkan kinerja peserta.',
        ];
    }

    private function invoke(string $method, mixed ...$arguments): mixed
    {
        return (new ReflectionMethod(PembimbingPageController::class, $method))
            ->invoke(new PembimbingPageController, ...$arguments);
    }

    /** @return array{0: mixed, 1: array<int, array<string, mixed>>} */
    private function capture(callable $callback): array
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            $result = $callback();

            return [$result, DB::getQueryLog()];
        } finally {
            DB::disableQueryLog();
            DB::flushQueryLog();
        }
    }

    private function queriesContaining(array $queries, string $fragment): array
    {
        return array_values(array_filter($queries, fn (array $query) => str_contains(strtolower($query['query']), $fragment)));
    }
}

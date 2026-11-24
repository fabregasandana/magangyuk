<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\KriteriaPenilaian;
use App\Models\Pengaturan;
use App\Models\Penilaian;
use App\Models\User;
use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BackendPerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->travelTo(now()->setDate(2026, 11, 18)->setTime(10, 0));
    }

    public function test_settings_use_one_query_and_preserve_value_types_and_defaults(): void
    {
        Pengaturan::simpan('min_skor', 75);
        Pengaturan::simpan('notifikasi', false);
        Pengaturan::simpan('hari_kerja', ['Senin', 'Selasa']);
        Pengaturan::simpan('kosong', null);
        Pengaturan::create(['key' => 'null_json', 'value' => null, 'grup' => 'umum']);

        $queries = $this->queriesDuring(function (): void {
            $this->assertSame(75, Pengaturan::ambil('min_skor'));
            $this->assertFalse(Pengaturan::ambil('notifikasi', true));
            $this->assertSame(['Senin', 'Selasa'], Pengaturan::ambil('hari_kerja'));
            $this->assertNull(Pengaturan::ambil('kosong', 'default'));
            $this->assertSame('default', Pengaturan::ambil('null_json', 'default'));
            $this->assertSame('first', Pengaturan::ambil('missing', 'first'));
            $this->assertSame('second', Pengaturan::ambil('missing', 'second'));
        });

        $this->assertCount(1, $queries);
    }

    public function test_settings_refresh_after_writes_deletes_and_new_request_scope(): void
    {
        Pengaturan::simpan('min_skor', 75);
        $this->assertSame(75, Pengaturan::ambil('min_skor'));

        Pengaturan::simpan('min_skor', 80);
        $this->assertSame(80, Pengaturan::ambil('min_skor'));

        $setting = Pengaturan::where('key', 'min_skor')->firstOrFail();
        $setting->update(['value' => ['value' => 85]]);
        $this->assertSame(85, Pengaturan::ambil('min_skor'));

        $setting->delete();
        $this->assertSame(0, Pengaturan::ambil('min_skor', 0));

        Pengaturan::simpan('min_skor', 90);
        $this->assertSame(90, Pengaturan::ambil('min_skor'));
        $this->app->forgetScopedInstances();
        $queries = $this->queriesDuring(fn () => $this->assertSame(90, Pengaturan::ambil('min_skor')));
        $this->assertCount(1, $queries);
    }

    public function test_weighted_score_fetches_all_weights_once(): void
    {
        $first = KriteriaPenilaian::create(['kode' => 'A', 'nama' => 'Disiplin', 'bobot' => 30]);
        $second = KriteriaPenilaian::create(['kode' => 'B', 'nama' => 'Kinerja', 'bobot' => 70]);

        $queries = $this->queriesDuring(function () use ($first, $second): void {
            $this->assertSame(94.0, Penilaian::hitungSkorBerbobot([
                $first->id => 4,
                $second->id => 5,
                999999 => 0,
            ]));
        });

        $this->assertCount(1, $queries);
        $this->assertSame(0.0, Penilaian::hitungSkorBerbobot([999999 => 5]));
        $this->assertCount(0, $this->queriesDuring(fn () => $this->assertSame(0.0, Penilaian::hitungSkorBerbobot([]))));

        $first->update(['bobot' => 0]);
        $this->assertSame(0.0, Penilaian::hitungSkorBerbobot([$first->id => 5]));
    }

    public function test_attendance_page_reads_settings_only_once(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PESERTA, 'status' => 'aktif']);
        Pengaturan::simpan('radius_absensi', 500);
        $this->actingAs($peserta);

        $queries = $this->queriesDuring(function (): void {
            $this->get(route('peserta.absensi'))
                ->assertOk()
                ->assertViewHas('areaAbsensi', fn (array $area): bool => $area['radius'] === '500 meter');
        });

        $this->assertCount(1, array_filter($queries, fn (array $query): bool => str_contains($query['query'], 'from "pengaturan"')));
    }

    public function test_rating_history_batches_details_and_keeps_participant_isolation(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PESERTA, 'status' => 'aktif']);
        $other = User::factory()->create(['role' => User::ROLE_PESERTA]);
        $criterion = KriteriaPenilaian::create(['kode' => 'A', 'nama' => 'Disiplin', 'bobot' => 100]);

        foreach (range(1, 6) as $week) {
            $rating = Penilaian::create([
                'peserta_id' => $peserta->id,
                'jenis' => 'mingguan',
                'periode_key' => 'w'.$week,
                'tanggal' => '2026-11-'.str_pad((string) $week, 2, '0', STR_PAD_LEFT),
                'total_skor' => 80,
            ]);
            $rating->detail()->create(['kriteria_penilaian_id' => $criterion->id, 'nilai' => 4]);
        }
        Penilaian::create(['peserta_id' => $other->id, 'jenis' => 'akhir', 'tanggal' => '2026-11-18', 'total_skor' => 100]);
        $this->actingAs($peserta);

        $queries = $this->queriesDuring(function (): void {
            $this->get(route('peserta.penilaian'))
                ->assertOk()
                ->assertViewHas('riwayat', function (array $history): bool {
                    $this->assertCount(6, $history);
                    $this->assertSame(['4.0'], array_values(array_unique(array_column($history, 'nilai'))));

                    return $history[0]['judul'] === 'Evaluasi Minggu 6';
                });
        });

        $this->assertCount(2, array_filter($queries, fn (array $query): bool => str_contains($query['query'], 'from "penilaian_detail"')));
    }

    public function test_leave_history_avoids_per_row_queries_and_preserves_cross_month_deduplication(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PESERTA, 'status' => 'aktif']);
        $other = User::factory()->create(['role' => User::ROLE_PESERTA]);
        $reviewer = User::factory()->create(['role' => User::ROLE_PEMBIMBING, 'nama_lengkap' => 'Reviewer Test']);
        Absensi::create(['user_id' => $peserta->id, 'tanggal' => '2026-10-30', 'status' => 'izin']);
        Absensi::create(['user_id' => $peserta->id, 'tanggal' => '2026-11-03', 'status' => 'hadir']);
        Absensi::create(['user_id' => $other->id, 'tanggal' => '2026-11-02', 'status' => 'hadir']);

        foreach ([['2026-10-30', '2026-11-02'], ['2026-11-02', '2026-11-02'], ['2026-11-03', '2026-11-03']] as [$start, $end]) {
            Izin::create([
                'user_id' => $peserta->id, 'jenis' => 'izin', 'tanggal_mulai' => $start,
                'tanggal_selesai' => $end, 'alasan' => 'Keperluan keluarga',
                'reviewed_by' => $reviewer->id, 'status' => 'disetujui',
            ]);
        }
        Izin::create([
            'user_id' => $other->id, 'jenis' => 'izin', 'tanggal_mulai' => '2026-11-05',
            'tanggal_selesai' => '2026-11-05', 'alasan' => 'Private',
        ]);
        $this->actingAs($peserta);

        $before = $this->queriesDuring(function (): void {
            $this->get(route('peserta.riwayat', ['bulan' => 'November 2026']))
                ->assertOk()
                ->assertViewHas('items', function (array $items): bool {
                    $this->assertSame(['03', '02'], array_column($items, 'tgl'));

                    return str_contains($items[1]['detail'], 'Reviewer Test');
                });
        });

        foreach (range(6, 15) as $day) {
            Izin::create([
                'user_id' => $peserta->id, 'jenis' => 'izin',
                'tanggal_mulai' => '2026-11-'.str_pad((string) $day, 2, '0', STR_PAD_LEFT),
                'tanggal_selesai' => '2026-11-'.str_pad((string) $day, 2, '0', STR_PAD_LEFT),
                'alasan' => 'Keperluan keluarga', 'reviewed_by' => $reviewer->id,
            ]);
        }

        $after = $this->queriesDuring(function (): void {
            $this->get(route('peserta.riwayat', ['bulan' => 'November 2026']))
                ->assertOk()
                ->assertViewHas('items', fn (array $items): bool => count($items) === 12);
        });
        $this->assertLessThanOrEqual(count($before), count($after));
    }

    /** @return array<int, array{query: string, bindings: array, time: float}> */
    private function queriesDuring(Closure $callback): array
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            $callback();

            return DB::getQueryLog();
        } finally {
            DB::disableQueryLog();
        }
    }
}

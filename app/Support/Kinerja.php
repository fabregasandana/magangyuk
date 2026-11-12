<?php

namespace App\Support;

use App\Models\Absensi;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * Perhitungan kinerja bersama (kehadiran & skor).
 *
 * Dipakai panel admin; logikanya identik dengan yang ada di
 * PembimbingPageController supaya angka yang dilihat admin dan pembimbing
 * untuk peserta yang sama selalu sama.
 */
class Kinerja
{
    /** Ambang kinerja (persen) — di bawah ini peserta masuk kategori "perhatian". */
    public const AMBANG_PERHATIAN = 80;

    /** Ambang kritis — di bawah ini peserta masuk kategori "bermasalah". */
    public const AMBANG_BERMASALAH = 70;

    /**
     * Jumlah hari kerja (Senin–Kamis, mengikuti hari kerja magang) dari awal
     * periode sampai batas: tanggal selesai periode bila sudah lewat, atau
     * hari ini bila periode masih berjalan.
     */
    public static function hariKerja(?Periode $periode): int
    {
        if (! $periode?->tanggal_mulai) {
            return 0;
        }

        return self::hitungHariKerja($periode->tanggal_mulai->copy(), self::batas($periode));
    }

    /** Batas akhir penghitungan: tanggal selesai periode atau hari ini. */
    public static function batas(?Periode $periode): Carbon
    {
        if ($periode?->tanggal_selesai && $periode->tanggal_selesai->lessThan(Carbon::today())) {
            return $periode->tanggal_selesai->copy();
        }

        return Carbon::today();
    }

    private static function hitungHariKerja(Carbon $mulai, Carbon $selesai): int
    {
        $tanggal = $mulai->copy()->startOfDay();
        $akhir = $selesai->copy()->startOfDay();
        $total = 0;

        while ($tanggal->lessThanOrEqualTo($akhir)) {
            if ($tanggal->dayOfWeekIso <= 4) {
                $total++;
            }
            $tanggal->addDay();
        }

        return $total;
    }

    /**
     * Rekap status absensi peserta dalam rentang periode.
     *
     * @return array<string,int>
     */
    public static function ringkasanKehadiran(User $user, ?Periode $periode): array
    {
        $ringkas = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'cuti' => 0, 'alpha' => 0, 'menunggu' => 0];

        $query = Absensi::where('user_id', $user->id);

        if ($periode?->tanggal_mulai) {
            $query->whereBetween('tanggal', [
                $periode->tanggal_mulai->toDateString(),
                self::batas($periode)->toDateString(),
            ]);
        }

        foreach ($query->pluck('status') as $status) {
            $ringkas[$status] = ($ringkas[$status] ?? 0) + 1;
        }

        return $ringkas;
    }

    /** Persentase kehadiran 0–100. Terlambat tetap dihitung masuk. */
    public static function persenKehadiran(array $ringkas, int $totalHariKerja): int
    {
        if ($totalHariKerja <= 0) {
            return 0;
        }

        $masuk = ($ringkas['hadir'] ?? 0) + ($ringkas['terlambat'] ?? 0);

        return (int) min(100, round($masuk / $totalHariKerja * 100));
    }

    /** Skor 0–100 dari penilaian terbaru peserta (0 bila belum dinilai). */
    public static function skorTerakhir(User $user): float
    {
        return (float) (Penilaian::where('peserta_id', $user->id)->terbaru()->value('total_skor') ?? 0);
    }

    /** Rata-rata nilai 0–5 dari penilaian terbaru, sebagai string 1 desimal. */
    public static function nilaiTerakhir(User $user): string
    {
        $penilaian = Penilaian::with('detail')->where('peserta_id', $user->id)->terbaru()->first();

        if (! $penilaian) {
            return '0.0';
        }

        return $penilaian->nilai_rata_rata;
    }

    /**
     * Rata-rata skor seluruh peserta (0–100) sebagai string 1 desimal.
     * Nilai 0 (belum pernah dinilai) tidak ikut dirata-rata.
     *
     * @param  array<int,float>  $skor
     */
    public static function rataSkor(array $skor): string
    {
        $daftar = array_values(array_filter($skor, fn ($v) => $v > 0));

        if ($daftar === []) {
            return '0.0';
        }

        return number_format(array_sum($daftar) / count($daftar), 1);
    }

    /** Kategori kinerja: baik / perhatian / bermasalah berdasarkan skor & kehadiran. */
    public static function kelasKinerja(float $skor, int $hadir): string
    {
        return match (true) {
            ($skor > 0 && $skor < self::AMBANG_BERMASALAH) || $hadir < self::AMBANG_BERMASALAH => 'bermasalah',
            ($skor > 0 && $skor < self::AMBANG_PERHATIAN) || $hadir < self::AMBANG_PERHATIAN => 'perhatian',
            default => 'baik',
        };
    }

    public static function labelKinerja(string $kelas): string
    {
        return match ($kelas) {
            'bermasalah' => 'Bermasalah',
            'perhatian' => 'Perlu Perhatian',
            default => 'Baik',
        };
    }
}

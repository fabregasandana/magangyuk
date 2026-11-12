<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\KriteriaPenilaian;
use App\Models\Laporan;
use App\Models\Logbook;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Periode;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Data aktivitas peserta: absensi, izin, laporan, logbook, penilaian, sertifikat.
 *
 * Semua rentang minggu diturunkan dari model Periode (bukan tanggal hardcoded)
 * agar konsisten dengan perhitungan di controller. Angka kinerja diambil dari
 * AkunSeeder::spesifikasiPeserta() supaya skor & kehadiran seragam di semua halaman.
 */
class AktivitasSeeder extends Seeder
{
    private Carbon $hariIni;

    public function run(): void
    {
        $this->hariIni = Carbon::today();

        foreach (AkunSeeder::spesifikasiPeserta() as $spec) {
            $user = User::where('email', $spec['email'])->first();
            if (! $user) {
                continue;
            }

            $periode = $user->dataMagang?->periodeRel;
            if (! $periode) {
                continue;
            }

            // Random deterministik per user agar seed ulang menghasilkan data sama.
            mt_srand($user->id * 7919);

            $konteks = [
                'periode' => $periode,
                'total_minggu' => $periode->total_minggu,
                // Minggu yang sudah fully berlalu; peserta "selesai" dianggap tuntas semua.
                'minggu_selesai' => ($spec['status_magang'] ?? 'aktif') === 'selesai'
                    ? $periode->total_minggu
                    : max(0, $periode->mingguAktif($this->hariIni) - 1),
                'tuntas' => ($spec['status_magang'] ?? 'aktif') === 'selesai',
            ];

            $this->absensi($user, $spec, $konteks);
            $this->izin($user, $spec, $konteks);
            $this->laporan($user, $spec, $konteks);
            $this->logbook($user, $spec, $konteks);
            $this->penilaian($user, $spec, $konteks);
            $this->sertifikat($user, $spec, $konteks);
        }

        mt_srand();
    }

    /* ============================ ABSENSI ============================ */

    private function absensi(User $user, array $spec, array $ctx): void
    {
        $periode = $ctx['periode'];
        $tanggal = $periode->tanggal_mulai->copy()->startOfDay();
        // Hari ini sengaja dikosongkan agar fitur "Absen Masuk" bisa diuji.
        $batas = $this->earliest($this->hariIni->copy()->subDay(), $periode->tanggal_selesai);

        while ($tanggal->lessThanOrEqualTo($batas)) {
            // Hari kerja: Senin (1) – Kamis (4).
            if ($tanggal->dayOfWeekIso <= 4) {
                $this->buatAbsensi($user, $tanggal->copy(), $spec);
            }
            $tanggal->addDay();
        }
    }

    private function buatAbsensi(User $user, Carbon $tanggal, array $spec): void
    {
        $roll = mt_rand(1, 100);
        $kehadiran = (int) $spec['kehadiran'];

        // Peluang tidak hadir = 100 - kehadiran, dibagi ke izin & alpha.
        if ($roll > $kehadiran) {
            $status = $roll % 2 === 0 ? 'izin' : 'alpha';
            Absensi::updateOrCreate(
                ['user_id' => $user->id, 'tanggal' => $tanggal->toDateString()],
                [
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'status' => $status,
                    'keterangan' => $status === 'izin'
                        ? 'Izin — sudah dikonfirmasi pembimbing'
                        : 'Tidak hadir tanpa keterangan',
                ],
            );

            return;
        }

        $terlambat = mt_rand(1, 100) > (int) round($kehadiran * 0.9);
        $jamMasuk = $terlambat
            ? sprintf('08:%02d:00', mt_rand(16, 40))
            : sprintf('07:%02d:00', mt_rand(40, 59));
        $jamPulang = sprintf('16:%02d:00', mt_rand(0, 25));

        Absensi::updateOrCreate(
            ['user_id' => $user->id, 'tanggal' => $tanggal->toDateString()],
            [
                'jam_masuk' => $jamMasuk,
                'jam_pulang' => $jamPulang,
                'status' => Absensi::statusDariJamMasuk($jamMasuk),
                'lokasi' => 'Dinas Kominfo Provinsi Sumatera Utara',
                'latitude' => 3.5951956 + (mt_rand(-300, 300) / 1000000),
                'longitude' => 98.6722227 + (mt_rand(-300, 300) / 1000000),
            ],
        );
    }

    /* ============================== IZIN ============================== */

    private function izin(User $user, array $spec, array $ctx): void
    {
        $periode = $ctx['periode'];
        $jenis = ['sakit', 'izin'];
        $jumlah = (int) $spec['kehadiran'] >= 90 ? 1 : 2;

        for ($i = 0; $i < $jumlah; $i++) {
            $minggu = min($i + 2, max(1, $ctx['minggu_selesai']));
            $mulai = $periode->mulaiMinggu($minggu)?->copy()->addDays(mt_rand(1, 4));
            if (! $mulai || $mulai->greaterThan($this->hariIni)) {
                continue;
            }

            Izin::updateOrCreate(
                ['user_id' => $user->id, 'tanggal_mulai' => $mulai->toDateString(), 'jenis' => $jenis[$i]],
                [
                    'tanggal_selesai' => $mulai->copy()->addDays($i === 1 ? 1 : 0)->toDateString(),
                    'alasan' => $i === 0
                        ? 'Demam dan perlu beristirahat sesuai anjuran dokter.'
                        : 'Ada keperluan keluarga yang tidak dapat ditinggalkan.',
                    'status' => $i === 0 ? 'disetujui' : 'menunggu',
                    'reviewed_by' => $i === 0 ? $user->dataMagang?->pembimbing_id : null,
                    'catatan_review' => $i === 0 ? 'Semoga lekas sembuh. Silakan susul materi yang tertinggal.' : null,
                    'reviewed_at' => $i === 0 ? $mulai->copy()->addDay()->startOfDay() : null,
                ],
            );
        }
    }

    /* ============================= LAPORAN ============================= */

    private function laporan(User $user, array $spec, array $ctx): void
    {
        $periode = $ctx['periode'];

        foreach (range(1, max(1, $ctx['minggu_selesai'])) as $minggu) {
            $isTerakhir = $minggu === $ctx['minggu_selesai'] && ! $ctx['tuntas'];

            Laporan::updateOrCreate(
                ['user_id' => $user->id, 'tipe' => Laporan::TIPE_MINGGUAN, 'minggu_ke' => $minggu],
                [
                    'judul' => 'Laporan Mingguan — Minggu ke-' . $minggu,
                    'isi' => "Ringkasan kegiatan minggu ke-{$minggu} (" . $periode->rentangMinggu($minggu) . "):\n"
                        . "1. Mengerjakan tugas pada bidang {$spec['bidang']}.\n"
                        . "2. Mengikuti rapat koordinasi unit.\n"
                        . "3. Menyusun dokumentasi hasil pekerjaan.\n",
                    'status' => $isTerakhir ? 'menunggu' : 'disetujui',
                    'submitted_at' => $periode->selesaiMinggu($minggu)?->endOfDay(),
                    'reviewed_by' => $isTerakhir ? null : $user->dataMagang?->pembimbing_id,
                    'catatan' => $isTerakhir ? null : 'Laporan sudah baik, pertahankan.',
                    'reviewed_at' => $isTerakhir ? null : $periode->selesaiMinggu($minggu)?->addDay(),
                ],
            );
        }

        // Laporan akhir: sudah disetujui untuk peserta yang selesai, draft untuk lainnya.
        Laporan::updateOrCreate(
            ['user_id' => $user->id, 'tipe' => Laporan::TIPE_AKHIR, 'minggu_ke' => null],
            $ctx['tuntas'] ? [
                'judul' => 'Laporan Akhir Magang',
                'isi' => "Laporan akhir magang pada bidang {$spec['bidang']}. Seluruh target kegiatan tercapai "
                    . 'dan dokumentasi telah diverifikasi pembimbing.',
                'status' => 'disetujui',
                'submitted_at' => $periode->tanggal_selesai,
                'reviewed_by' => $user->dataMagang?->pembimbing_id,
                'catatan' => 'Laporan akhir disetujui. Terima kasih atas kontribusinya.',
                'reviewed_at' => $periode->tanggal_selesai,
            ] : [
                'judul' => 'Laporan Akhir Magang',
                'isi' => null,
                'status' => 'draft',
            ],
        );
    }

    /* ============================= LOGBOOK ============================= */

    private function logbook(User $user, array $spec, array $ctx): void
    {
        $periode = $ctx['periode'];
        $skor = (int) $spec['skor'];
        $mingguSelesai = max(1, $ctx['minggu_selesai']);

        foreach (range(1, $mingguSelesai) as $minggu) {
            // Peserta berkinerja rendah menyisakan beberapa logbook kosong.
            if ($skor < 75 && ! $ctx['tuntas'] && $minggu % 3 === 0) {
                continue;
            }

            $status = match (true) {
                $minggu === $mingguSelesai && ! $ctx['tuntas'] => Logbook::STATUS_MENUNGGU,
                $skor < 75 && $minggu === $mingguSelesai - 1 => Logbook::STATUS_DITOLAK,
                default => Logbook::STATUS_DISETUJUI,
            };

            Logbook::updateOrCreate(
                ['user_id' => $user->id, 'minggu_ke' => $minggu],
                [
                    'rentang' => $periode->rentangMinggu($minggu),
                    'uraian' => 'Aktivitas magang minggu ke-' . $minggu . ' pada bidang ' . $spec['bidang'] . '.',
                    'kegiatan' => [
                        'Mendampingi tim pada pekerjaan ' . strtolower($spec['bidang']),
                        'Mengikuti apel pagi dan rapat koordinasi',
                        'Menyusun dokumentasi hasil pekerjaan',
                    ],
                    'hasil' => 'Tugas minggu ke-' . $minggu . ' selesai sesuai target dan sudah diverifikasi pembimbing.',
                    'kendala' => $minggu % 2 === 0
                        ? 'Terkendala akses data yang belum lengkap dari unit terkait.'
                        : null,
                    'rencana' => [
                        'Melanjutkan pengerjaan modul berikutnya',
                        'Melengkapi dokumentasi teknis',
                    ],
                    'status' => $status,
                    'reviewed_by' => $status === Logbook::STATUS_MENUNGGU ? null : $user->dataMagang?->pembimbing_id,
                    'catatan_review' => match ($status) {
                        Logbook::STATUS_DISETUJUI => 'Logbook lengkap dan jelas. Pertahankan.',
                        Logbook::STATUS_DITOLAK => 'Uraian kegiatan terlalu singkat. Mohon dilengkapi lalu ajukan ulang.',
                        default => null,
                    },
                    'submitted_at' => $periode->selesaiMinggu($minggu)?->endOfDay(),
                ],
            );
        }
    }

    /* ============================ PENILAIAN ============================ */

    private function penilaian(User $user, array $spec, array $ctx): void
    {
        $kriteria = KriteriaPenilaian::aktif()->terurut()->get();
        if ($kriteria->isEmpty()) {
            return;
        }

        $periode = $ctx['periode'];
        $pembimbingId = $user->dataMagang?->pembimbing_id;
        $skorAkhir = (int) $spec['skor'];
        $mingguSelesai = max(1, $ctx['minggu_selesai']);

        foreach (range(1, $mingguSelesai) as $minggu) {
            // Skor menanjak dari (akhir - 13) menuju skor akhir.
            $pembagi = max(1, $mingguSelesai - 1);
            $skorMinggu = max(40, min(99, (int) round($skorAkhir - ($mingguSelesai - $minggu) * (13 / $pembagi))));

            $penilaian = $this->buatPenilaian(
                $user, $pembimbingId, $kriteria, $minggu, $skorMinggu,
                $periode->rentangMinggu($minggu), $periode->selesaiMinggu($minggu),
                'mingguan', 'w' . $minggu,
            );

            $this->simpanDetail($penilaian, $kriteria, $skorMinggu);
        }

        // Penilaian akhir hanya untuk peserta yang sudah selesai.
        if ($ctx['tuntas']) {
            $penilaian = $this->buatPenilaian(
                $user, $pembimbingId, $kriteria, $mingguSelesai, $skorAkhir,
                'Penilaian Akhir Periode', $periode->tanggal_selesai,
                'akhir', 'final',
            );

            $this->simpanDetail($penilaian, $kriteria, $skorAkhir);
        }
    }

    private function buatPenilaian(
        User $user,
        ?int $pembimbingId,
        $kriteria,
        int $minggu,
        int $skorTarget,
        string $label,
        ?Carbon $tanggal,
        string $jenis,
        string $periodeKey,
    ): Penilaian {
        return Penilaian::firstOrCreate(
            ['peserta_id' => $user->id, 'jenis' => $jenis, 'periode_key' => $periodeKey],
            [
                'pembimbing_id' => $pembimbingId,
                'periode_label' => $jenis === 'akhir' ? $label : 'Minggu ke-' . $minggu . ' (' . $label . ')',
                'total_skor' => $skorTarget,
                'grade' => Penilaian::gradeDariSkor($skorTarget),
                'komentar' => $this->komentarPenilaian($skorTarget, $minggu, $jenis),
                'tanggal' => $tanggal,
                'status' => 'final',
            ],
        );
    }

    private function simpanDetail(Penilaian $penilaian, $kriteria, int $skorTarget): void
    {
        foreach ($kriteria as $k) {
            // Konversi skor 0–100 menjadi nilai 0–5 per kriteria + variasi kecil.
            $nilai = round(max(1, min(5, $skorTarget / 20 + mt_rand(-20, 20) / 100)), 1);

            PenilaianDetail::updateOrCreate(
                ['penilaian_id' => $penilaian->id, 'kriteria_penilaian_id' => $k->id],
                ['nilai' => $nilai],
            );
        }

        // Selaraskan total_skor dengan nilai berbobot yang benar-benar tersimpan.
        $nilaiPerKriteria = $penilaian->detail()->pluck('nilai', 'kriteria_penilaian_id')->all();
        $penilaian->update([
            'total_skor' => Penilaian::hitungSkorBerbobot($nilaiPerKriteria),
            'grade' => Penilaian::gradeDariSkor((float) $penilaian->total_skor),
        ]);
    }

    private function komentarPenilaian(float $skor, int $minggu, string $jenis): string
    {
        $prefix = $jenis === 'akhir' ? 'Penilaian akhir periode' : "Minggu ke-{$minggu}";

        return match (true) {
            $skor >= 88 => "{$prefix}: performa sangat baik, inisiatif tinggi dan hasil kerja konsisten.",
            $skor >= 80 => "{$prefix}: performa baik. Pertahankan kedisiplinan dan kualitas pekerjaan.",
            $skor >= 75 => "{$prefix}: cukup baik. Perlu lebih proaktif bertanya dan melengkapi dokumentasi.",
            default => "{$prefix}: perlu perhatian. Kehadiran dan ketepatan waktu harus ditingkatkan.",
        };
    }

    /* ============================ SERTIFIKAT ============================ */

    private function sertifikat(User $user, array $spec, array $ctx): void
    {
        $periode = $ctx['periode'];
        $totalMinggu = $periode->total_minggu;

        $totalHariKerja = $this->hitungHariKerja($periode, $ctx);
        $hadir = Absensi::where('user_id', $user->id)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();
        $hadirPersen = $totalHariKerja > 0 ? (int) round($hadir / $totalHariKerja * 100) : 0;

        $syarat = [
            $hadirPersen >= 80,
            Laporan::where('user_id', $user->id)->mingguan()->disetujui()->count() >= $totalMinggu,
            Laporan::where('user_id', $user->id)->where('tipe', Laporan::TIPE_AKHIR)->where('status', 'disetujui')->exists(),
            Penilaian::where('peserta_id', $user->id)->where('jenis', 'akhir')->exists(),
        ];

        $progress = (int) round(count(array_filter($syarat)) / count($syarat) * 100);

        Sertifikat::updateOrCreate(['user_id' => $user->id], [
            'nomor' => $progress >= 100
                ? 'SRT/MKD/' . $periode->tanggal_selesai->format('Y') . '/' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT)
                : null,
            'progress' => $progress,
            'status' => $progress >= 100 ? 'terbit' : 'proses',
            'issued_at' => $progress >= 100 ? $periode->tanggal_selesai : null,
        ]);
    }

    private function hitungHariKerja(Periode $periode, array $ctx): int
    {
        $tanggal = $periode->tanggal_mulai->copy()->startOfDay();
        $batas = $ctx['tuntas']
            ? $periode->tanggal_selesai->copy()
            : $this->earliest($this->hariIni->copy()->subDay(), $periode->tanggal_selesai);
        $total = 0;

        while ($tanggal->lessThanOrEqualTo($batas)) {
            if ($tanggal->dayOfWeekIso <= 4) {
                $total++;
            }
            $tanggal->addDay();
        }

        return $total;
    }

    /** Tanggal paling awal dari dua Carbon (null-safe). */
    private function earliest(?Carbon $a, ?Carbon $b): Carbon
    {
        if (! $a) {
            return $b ?? Carbon::today();
        }
        if (! $b) {
            return $a;
        }

        return $a->lessThanOrEqualTo($b) ? $a : $b;
    }
}

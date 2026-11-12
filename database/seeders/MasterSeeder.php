<?php

namespace Database\Seeders;

use App\Models\Institusi;
use App\Models\KriteriaPenilaian;
use App\Models\Pengaturan;
use App\Models\Periode;
use Illuminate\Database\Seeder;

/**
 * Data master: institusi, periode magang, kriteria penilaian, dan pengaturan sistem.
 */
class MasterSeeder extends Seeder
{
    public function run(): void
    {
        $this->institusi();
        $this->periode();
        $this->kriteria();
        $this->pengaturan();
    }

    private function institusi(): void
    {
        $data = [
            ['kode' => 'USU', 'nama' => 'Universitas Sumatera Utara', 'singkat' => 'USU', 'jenis' => 'Universitas', 'kota' => 'Medan'],
            ['kode' => 'UNIMED', 'nama' => 'Universitas Negeri Medan', 'singkat' => 'UNIMED', 'jenis' => 'Universitas', 'kota' => 'Medan'],
            ['kode' => 'POLMED', 'nama' => 'Politeknik Negeri Medan', 'singkat' => 'POLMED', 'jenis' => 'Politeknik', 'kota' => 'Medan'],
            ['kode' => 'ITM', 'nama' => 'Institut Teknologi Medan', 'singkat' => 'ITM', 'jenis' => 'Institut', 'kota' => 'Medan'],
            ['kode' => 'UISU', 'nama' => 'Universitas Islam Sumatera Utara', 'singkat' => 'UISU', 'jenis' => 'Universitas', 'kota' => 'Medan'],
            ['kode' => 'STMIK-TD', 'nama' => 'STMIK Triguna Dharma', 'singkat' => 'STMIK TD', 'jenis' => 'Sekolah Tinggi', 'kota' => 'Medan'],
        ];

        foreach ($data as $baris) {
            Institusi::updateOrCreate(['kode' => $baris['kode']], $baris + ['status' => 'aktif']);
        }
    }

    private function periode(): void
    {
        $data = [
            [
                'kode' => 'okt-des-2026', 'nama' => 'Okt – Des 2026',
                'tanggal_mulai' => '2026-10-01', 'tanggal_selesai' => '2026-12-19',
                'status' => 'aktif', 'maks_peserta' => 50,
            ],
            [
                'kode' => 'jul-sep-2026', 'nama' => 'Jul – Sep 2026',
                'tanggal_mulai' => '2026-07-01', 'tanggal_selesai' => '2026-09-18',
                'status' => 'selesai', 'maks_peserta' => 40,
            ],
        ];

        foreach ($data as $baris) {
            Periode::updateOrCreate(['kode' => $baris['kode']], $baris);
        }
    }

    private function kriteria(): void
    {
        $data = [
            ['kode' => 'KRT-1', 'nama' => 'Disiplin & Kehadiran', 'bobot' => 25, 'deskripsi' => 'Ketepatan waktu dan kehadiran selama magang', 'urutan' => 1],
            ['kode' => 'KRT-2', 'nama' => 'Kerjasama Tim', 'bobot' => 20, 'deskripsi' => 'Kemampuan berkolaborasi dan komunikasi', 'urutan' => 2],
            ['kode' => 'KRT-3', 'nama' => 'Kompetensi Teknis', 'bobot' => 30, 'deskripsi' => 'Penguasaan skill teknis sesuai bidang', 'urutan' => 3],
            ['kode' => 'KRT-4', 'nama' => 'Inisiatif & Kreativitas', 'bobot' => 25, 'deskripsi' => 'Kemampuan memberikan ide dan solusi', 'urutan' => 4],
        ];

        foreach ($data as $baris) {
            KriteriaPenilaian::updateOrCreate(['kode' => $baris['kode']], $baris + ['aktif' => true]);
        }
    }

    private function pengaturan(): void
    {
        Pengaturan::simpan('nama_sistem', 'MagangYuk', 'umum', 'Nama sistem');
        Pengaturan::simpan('email_admin', 'admin@magangyuk.test', 'umum', 'Email administrator');
        Pengaturan::simpan('maks_peserta_per_pembimbing', 8, 'umum', 'Maks peserta per pembimbing');

        Pengaturan::simpan('min_skor', 75, 'penilaian', 'Skor minimal kelulusan');
        Pengaturan::simpan('min_kehadiran', 80, 'penilaian', 'Persentase kehadiran minimal sertifikat');
        Pengaturan::simpan('bobot', [
            'kehadiran' => 25, 'kerjasama' => 20, 'teknis' => 30, 'inisiatif' => 25,
        ], 'penilaian', 'Bobot kriteria penilaian');

        Pengaturan::simpan('notif_logbook', true, 'notifikasi', 'Notifikasi logbook baru');
        Pengaturan::simpan('notif_penilaian', true, 'notifikasi', 'Notifikasi penilaian dirilis');
        Pengaturan::simpan('notif_izin', true, 'notifikasi', 'Notifikasi pengajuan izin');

        Pengaturan::simpan('session_timeout', 120, 'keamanan', 'Timeout sesi (menit)');
        Pengaturan::simpan('maks_login_gagal', 5, 'keamanan', 'Maks percobaan login gagal');
        Pengaturan::simpan('radius_absensi', 2000, 'keamanan', 'Radius absensi GPS (meter)');
        Pengaturan::simpan('jam_masuk', '08:00', 'keamanan', 'Jam masuk kerja');
        Pengaturan::simpan('jam_pulang', '16:00', 'keamanan', 'Jam pulang kerja');
        Pengaturan::simpan('hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis'], 'keamanan', 'Hari kerja magang');
    }
}

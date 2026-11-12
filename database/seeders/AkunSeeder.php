<?php

namespace Database\Seeders;

use App\Models\DataDiri;
use App\Models\DataMagang;
use App\Models\Institusi;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Akun demo: admin, pembimbing, peserta + data diri & data magang mereka.
 *
 * Akun milik pengguna asli (Alip / Nabila / Azam) dipertahankan agar login
 * lama tetap berfungsi; sisanya memakai domain @magangyuk.test.
 */
class AkunSeeder extends Seeder
{
    /** Password default untuk seluruh akun demo selain akun asli. */
    public const PASSWORD_DEMO = 'magangyuk123';

    public function run(): void
    {
        $this->buatAdmin();
        $pembimbing = $this->buatPembimbing();
        $this->buatPeserta($pembimbing);
    }

    private function buatAdmin(): void
    {
        $admins = [
            ['nama' => 'Azam Darmansyah', 'email' => 'pakucup@gmail.com', 'password' => 'pakucup123', 'nip' => '198501102010011001', 'jabatan' => 'Kepala Bidang Aplikasi Informatika'],
            ['nama' => 'Admin MagangYuk', 'email' => 'admin@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nip' => '199001012015011002', 'jabatan' => 'Administrator Sistem'],
        ];

        foreach ($admins as $a) {
            $user = User::updateOrCreate(
                ['email' => $a['email']],
                ['nama_lengkap' => $a['nama'], 'password' => $a['password'], 'role' => User::ROLE_ADMIN, 'status' => 'aktif'],
            );

            DataDiri::updateOrCreate(['user_id' => $user->id], [
                'nik' => '1271' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT),
                'nama_lengkap' => $a['nama'],
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '1985-01-10',
                'alamat' => 'Jl. Diponegoro No. 21, Medan',
                'jenis_kelamin' => 'L',
                'email' => $a['email'],
                'no_hp' => '0811000' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
                'nip' => $a['nip'],
                'jabatan' => $a['jabatan'],
                'unit_kerja' => 'Bidang Aplikasi Informatika',
                'instansi' => 'Dinas Komunikasi dan Informatika Provinsi Sumatera Utara',
            ]);
        }
    }

    private function buatPembimbing(): array
    {
        $pembimbing = [
            ['nama' => 'Nabila Amriyanti, S.Kom', 'email' => 'makucup@gmail.com', 'password' => 'makucup123', 'nip' => '199203152015042001', 'jabatan' => 'Pranata Komputer Ahli Pertama', 'unit' => 'Bidang Aplikasi Informatika'],
            ['nama' => 'Budi Santoso, S.Kom', 'email' => 'budi.santoso@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nip' => '198705152012031002', 'jabatan' => 'Analis Aplikasi Informatika', 'unit' => 'Bidang Aplikasi Informatika'],
            ['nama' => 'Sari Dewi, M.Kom', 'email' => 'sari.dewi@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nip' => '198203102008012003', 'jabatan' => 'Pranata Komputer Ahli Muda', 'unit' => 'Bidang Infrastruktur'],
            ['nama' => 'Andi Pratama, S.T', 'email' => 'andi.pratama@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nip' => '199001202015011005', 'jabatan' => 'Teknisi Jaringan', 'unit' => 'Bidang Infrastruktur'],
            ['nama' => 'Rina Wulandari, S.Sos', 'email' => 'rina.wulandari@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nip' => '198506152010012004', 'jabatan' => 'Analis Kepegawaian', 'unit' => 'Sekretariat', 'status' => 'nonaktif'],
        ];

        $hasil = [];

        foreach ($pembimbing as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'nama_lengkap' => $p['nama'],
                    'password' => $p['password'],
                    'role' => User::ROLE_PEMBIMBING,
                    'status' => $p['status'] ?? 'aktif',
                ],
            );

            DataDiri::updateOrCreate(['user_id' => $user->id], [
                'nik' => '1272' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT),
                'nama_lengkap' => $p['nama'],
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '1987-05-15',
                'alamat' => 'Jl. Setia Budi No. 88, Medan',
                'jenis_kelamin' => str_contains($p['nama'], 'Sari') || str_contains($p['nama'], 'Rina') || str_contains($p['nama'], 'Nabila') ? 'P' : 'L',
                'email' => $p['email'],
                'no_hp' => '0812000' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
                'nip' => $p['nip'],
                'jabatan' => $p['jabatan'],
                'unit_kerja' => $p['unit'],
                'instansi' => 'Dinas Komunikasi dan Informatika Provinsi Sumatera Utara',
            ]);

            $hasil[$p['email']] = $user;
        }

        return $hasil;
    }

    /**
     * Spesifikasi peserta demo — dipakai juga oleh AktivitasSeeder agar
     * angka kinerja (skor/kehadiran) konsisten antar tabel.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function spesifikasiPeserta(): array
    {
        return [
            ['nama' => 'Alip Hidayat', 'email' => 'alip@gmail.com', 'password' => 'alip123', 'nim' => '210401099', 'institusi' => 'USU', 'prodi' => 'Ilmu Komputer', 'bidang' => 'Pengembangan Aplikasi', 'skor' => 86, 'kehadiran' => 94, 'pembimbing' => 'budi.santoso@magangyuk.test'],
            ['nama' => 'Nisa Ramadani', 'email' => 'nisa.ramadani@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210401023', 'institusi' => 'USU', 'prodi' => 'Ilmu Komputer', 'bidang' => 'Pengembangan Aplikasi', 'skor' => 85, 'kehadiran' => 92, 'pembimbing' => 'budi.santoso@magangyuk.test'],
            ['nama' => 'Salwa Rameyza', 'email' => 'salwa.rameyza@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210401047', 'institusi' => 'USU', 'prodi' => 'Teknologi Informasi', 'bidang' => 'Data & Analitik', 'skor' => 88, 'kehadiran' => 96, 'pembimbing' => 'budi.santoso@magangyuk.test'],
            ['nama' => 'Fajar Aditya', 'email' => 'fajar.aditya@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210501011', 'institusi' => 'UNIMED', 'prodi' => 'Pendidikan Teknik Informatika', 'bidang' => 'Infrastruktur Jaringan', 'skor' => 87, 'kehadiran' => 96, 'pembimbing' => 'sari.dewi@magangyuk.test'],
            ['nama' => 'Dina Nurhaliza', 'email' => 'dina.nurhaliza@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210501033', 'institusi' => 'UNIMED', 'prodi' => 'Sistem Informasi', 'bidang' => 'Data & Analitik', 'skor' => 79, 'kehadiran' => 88, 'pembimbing' => 'sari.dewi@magangyuk.test'],
            ['nama' => 'Aulia Rahma', 'email' => 'aulia.rahma@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '220301008', 'institusi' => 'ITM', 'prodi' => 'Teknik Informatika', 'bidang' => 'Pengembangan Aplikasi', 'skor' => 71, 'kehadiran' => 68, 'pembimbing' => 'sari.dewi@magangyuk.test'],
            ['nama' => 'Rizky Pratama', 'email' => 'rizky.pratama@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210701021', 'institusi' => 'POLMED', 'prodi' => 'Teknik Komputer', 'bidang' => 'Infrastruktur Jaringan', 'skor' => 83, 'kehadiran' => 90, 'pembimbing' => 'andi.pratama@magangyuk.test'],
            ['nama' => 'Rizky Fauzan', 'email' => 'rizky.fauzan@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210701044', 'institusi' => 'POLMED', 'prodi' => 'Manajemen Informatika', 'bidang' => 'Data & Analitik', 'skor' => 74, 'kehadiran' => 72, 'pembimbing' => 'andi.pratama@magangyuk.test'],
            ['nama' => 'Nadia Putri', 'email' => 'nadia.putri@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '220401015', 'institusi' => 'UISU', 'prodi' => 'Sistem Informasi', 'bidang' => 'Pengembangan Aplikasi', 'skor' => 86, 'kehadiran' => 94, 'pembimbing' => 'nabila@placeholder'],
            ['nama' => 'Andi Wijaya', 'email' => 'andi.wijaya@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210601029', 'institusi' => 'STMIK-TD', 'prodi' => 'Teknik Informatika', 'bidang' => 'Infrastruktur Jaringan', 'skor' => 90, 'kehadiran' => 98, 'pembimbing' => 'nabila@placeholder', 'status_user' => 'selesai', 'status_magang' => 'selesai', 'periode' => 'jul-sep-2026'],
            ['nama' => 'Reza Maulana', 'email' => 'reza.maulana@magangyuk.test', 'password' => self::PASSWORD_DEMO, 'nim' => '210701033', 'institusi' => 'UISU', 'prodi' => 'Sistem Informasi', 'bidang' => 'Data & Analitik', 'skor' => 58, 'kehadiran' => 62, 'pembimbing' => 'budi.santoso@magangyuk.test', 'status_user' => 'nonaktif', 'status_magang' => 'nonaktif'],
        ];
    }

    private function buatPeserta(array $pembimbing): void
    {
        $periodeModel = Periode::all()->keyBy('kode');
        $institusi = Institusi::all()->keyBy('kode');
        $urut = 847;

        foreach (self::spesifikasiPeserta() as $s) {
            // "nabila@placeholder" menunjuk akun pembimbing asli milik pengguna.
            $emailPembimbing = $s['pembimbing'] === 'nabila@placeholder'
                ? 'makucup@gmail.com'
                : $s['pembimbing'];

            $user = User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'nama_lengkap' => $s['nama'],
                    'password' => $s['password'],
                    'role' => User::ROLE_PESERTA,
                    'status' => $s['status_user'] ?? 'aktif',
                ],
            );

            DataDiri::updateOrCreate(['user_id' => $user->id], [
                'nik' => '1273' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT),
                'nama_lengkap' => $s['nama'],
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2003-03-12',
                'alamat' => 'Jl. Dr. Mansyur No. 12, Medan Selayang, Kota Medan',
                'jenis_kelamin' => $this->jenisKelamin($s['nama']),
                'email' => $s['email'],
                'no_hp' => '0813000' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
            ]);

            $inst = $institusi[$s['institusi']] ?? null;
            $per = $periodeModel[$s['periode'] ?? 'okt-des-2026'] ?? null;

            DataMagang::updateOrCreate(['user_id' => $user->id], [
                'id_kode' => 'MKD-2026-0' . $urut,
                'nis_nim' => $s['nim'],
                'institusi' => $inst?->nama,
                'institusi_id' => $inst?->id,
                'prodi' => $s['prodi'],
                'penempatan' => 'Dinas Kominfo Provinsi Sumatera Utara',
                'bidang' => $s['bidang'],
                'periode' => $per?->nama,
                'periode_id' => $per?->id,
                'status' => $s['status_magang'] ?? 'aktif',
                'pembimbing_id' => $pembimbing[$emailPembimbing]?->id,
            ]);

            $urut++;
        }
    }

    private function jenisKelamin(string $nama): string
    {
        $perempuan = ['Nisa', 'Salwa', 'Dina', 'Aulia', 'Nadia', 'Sari', 'Rina', 'Nabila'];

        foreach ($perempuan as $p) {
            if (str_starts_with($nama, $p)) {
                return 'P';
            }
        }

        return 'L';
    }
}

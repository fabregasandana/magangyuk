<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\CmsKonten;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Konten CMS landing page + contoh log aktivitas sistem.
 *
 * Semua baris memakai slug unik ber-prefix jenis agar tidak bentrok
 * dengan judul yang sama antar jenis konten.
 */
class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        $this->hero($admin);
        $this->kegiatan($admin);
        $this->dokumentasi($admin);
        $this->anggota($admin);
        $this->halaman($admin);
        $this->pengumuman($admin);
        $this->menu($admin);
        $this->dokumen($admin);
        $this->faq($admin);
        $this->logAktivitas($admin);
    }

    private function simpan(string $jenis, string $judul, array $atribut, ?User $admin, int $urutan = 0): void
    {
        CmsKonten::updateOrCreate(
            ['jenis' => $jenis, 'slug' => $jenis . '-' . Str::slug($judul)],
            // $atribut di kiri agar override (status draft, published_at) menang.
            $atribut + [
                'judul' => $judul,
                'user_id' => $admin?->id,
                'urutan' => $urutan,
                'status' => 'aktif',
                'published_at' => now(),
            ],
        );
    }

    private function hero(?User $admin): void
    {
        $this->simpan('hero', 'Magang Komdigi 2026', [
            'isi' => 'Program magang bersertifikat dari Kementerian Komunikasi dan Digital untuk mahasiswa seluruh Indonesia.',
            'payload' => [
                'judul' => 'Magang Komdigi 2026',
                'subjudul' => 'Program magang bersertifikat dari Kementerian Komunikasi dan Digital untuk mahasiswa seluruh Indonesia.',
                'tombol1' => 'Lihat Kegiatan',
                'link1' => '#kegiatan',
                'tombol2' => 'Galeri Dokumentasi',
                'link2' => '#dokumentasi',
                'tanggal_mulai' => '2026-10-01',
                'tanggal_selesai' => '2026-12-31',
                'status_periode' => 'Sedang Berjalan',
            ],
        ], $admin);
    }

    private function kegiatan(?User $admin): void
    {
        $data = [
            ['Menjadi announcer lagu Indonesia Raya', 'Pribadi', '2026-10-15', 'NR', 'from-blue-400 to-indigo-500', 'https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?w=600&h=400&fit=crop'],
            ['Mengikuti apel pagi', 'Semua User', '2026-10-19', 'SA', 'from-emerald-400 to-green-500', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop'],
            ['Menjadi announcer barang kehilangan', 'Pribadi', '2026-10-19', 'NR', 'from-blue-400 to-indigo-500', 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&h=400&fit=crop'],
        ];

        foreach ($data as $i => [$judul, $kategori, $tanggal, $inisial, $avatar, $img]) {
            $penulis = User::where('nama_lengkap', 'like', '%' . $inisial . '%')->first();

            $this->simpan('kegiatan', $judul, [
                'kategori' => $kategori,
                'gambar_path' => $img,
                'isi' => 'Dokumentasi kegiatan peserta magang: ' . $judul . '.',
                'payload' => [
                    'inisial' => $inisial,
                    'avatarClass' => $avatar,
                    'penulis' => trim(($penulis?->nama_lengkap ?? 'Peserta Magang') . ' · ' . Carbon::parse($tanggal)->translatedFormat('j F Y')),
                ],
                'published_at' => Carbon::parse($tanggal),
            ], $admin, $i + 1);
        }
    }

    private function dokumentasi(?User $admin): void
    {
        $data = [
            ['Dokumentasi Apel Pagi', 'images/alip5.jpeg'],
            ['Dokumentasi Kegiatan Tim', 'images/alip2.jpg'],
            ['Dokumentasi Workshop', 'images/alip3.jpg'],
            ['Dokumentasi Penutupan', 'images/alip4.jpeg'],
        ];

        foreach ($data as $i => [$judul, $img]) {
            $this->simpan('dokumentasi', $judul, [
                'gambar_path' => $img,
                'kategori' => 'Galeri',
            ], $admin, $i + 1);
        }
    }

    private function anggota(?User $admin): void
    {
        $data = [
            ['Budi Santoso S.Kom', '@budisantoso', 'Koordinator', 'Komdigi RI', 'aktif', 'BS', 'from-amber-500 to-orange-500'],
            ['Sari Dewi M.Kom', '@saridewi', 'Pembimbing', 'Komdigi RI', 'aktif', 'SD', 'from-violet-500 to-purple-500'],
            ['Nisa Ramadani', '@nisaramadani', 'Peserta', 'Universitas Sumatera Utara', 'aktif', 'NR', 'from-komdigi-blue to-komdigi-cerulean'],
            ['Dewi Lestari', '@dewilestari', 'Peserta', 'Institut Teknologi Medan', 'aktif', 'DL', 'from-teal-500 to-cyan-500'],
            ['Ahmad Fauzi', '@ahmadfauzi', 'Peserta', 'Universitas Negeri Medan', 'nonaktif', 'AF', 'from-slate-500 to-slate-600'],
        ];

        foreach ($data as $i => [$nama, $username, $posisi, $instansi, $status, $inisial, $gradient]) {
            $this->simpan('anggota', $nama, [
                'kategori' => $posisi,
                'status' => $status,
                'payload' => [
                    'username' => $username,
                    'posisi' => $posisi,
                    'institusi' => $instansi,
                    'initial' => $inisial,
                    'gradient' => $gradient,
                ],
            ], $admin, $i + 1);
        }
    }

    private function halaman(?User $admin): void
    {
        $data = [
            ['Tentang Kami', 'Profil program Magang Komdigi, visi, misi, dan tujuan.', 'aktif'],
            ['Panduan Magang', 'Petunjuk lengkap alur magang dan mekanisme penilaian.', 'aktif'],
            ['FAQ', 'Pertanyaan yang sering diajukan seputar program magang.', 'aktif'],
            ['Kebijakan Privasi', 'Draft kebijakan privasi dan perlindungan data peserta.', 'draft'],
        ];

        foreach ($data as $i => [$judul, $deskripsi, $status]) {
            $this->simpan('halaman', $judul, [
                'isi' => $deskripsi,
                'status' => $status,
                'payload' => ['deskripsi' => $deskripsi],
            ], $admin, $i + 1);
        }
    }

    private function pengumuman(?User $admin): void
    {
        $data = [
            ['Pendaftaran Magang Batch 2 Dibuka!', 'Hero', 'Semua', '2026-11-01', '2026-11-30', '/daftar', 'aktif', 'Daftarkan diri Anda untuk periode magang November–Desember 2026. Kuota terbatas.'],
            ['Batas Submit Logbook Minggu 5', 'Popup', 'Peserta', '2026-11-05', '2026-11-10', '/logbook', 'aktif', 'Mohon segera unggah logbook minggu ke-5 sebelum 10 November 2026 pukul 23:59 WIB.'],
            ['Workshop UI/UX Design Dasar', 'Running Text', 'Peserta', '2026-11-15', '2026-11-15', '/kegiatan', 'nonaktif', 'Kuota masih tersedia untuk workshop Design Thinking.'],
        ];

        foreach ($data as $i => [$judul, $posisi, $target, $mulai, $selesai, $link, $status, $deskripsi]) {
            $this->simpan('pengumuman', $judul, [
                'isi' => $deskripsi,
                'kategori' => $posisi,
                'status' => $status,
                'payload' => [
                    'posisi' => $posisi,
                    'target' => $target,
                    'tanggal_mulai' => $mulai,
                    'tanggal_selesai' => $selesai,
                    'link' => $link,
                    'deskripsi' => $deskripsi,
                ],
            ], $admin, $i + 1);
        }
    }

    private function menu(?User $admin): void
    {
        $data = [
            ['Beranda', '#home', 'Default', 'aktif'],
            ['Kegiatan', '#kegiatan', 'Default', 'aktif'],
            ['Dokumentasi', '#dokumentasi', 'Default', 'aktif'],
            ['Profil Tim', '#profil', 'Default', 'aktif'],
            ['Tentang', '/tentang-kami', 'Halaman', 'aktif'],
            ['Blog', '/blog', 'Custom', 'nonaktif'],
        ];

        foreach ($data as $i => [$label, $url, $tipe, $status]) {
            $this->simpan('menu', $label, [
                'kategori' => $tipe,
                'status' => $status,
                'payload' => ['url' => $url, 'tipe' => $tipe],
            ], $admin, $i + 1);
        }
    }

    private function dokumen(?User $admin): void
    {
        $data = [
            ['Panduan Magang Komdigi 2026', 'panduan-magang-2026.pdf', 'Panduan', 'Publik', '2.4 MB'],
            ['Template Logbook Mingguan', 'template-logbook.docx', 'Template', 'Login saja', '156 KB'],
            ['Form Penilaian Pembimbing', 'form-penilaian.xlsx', 'Form', 'Login saja', '98 KB'],
        ];

        foreach ($data as $i => [$nama, $file, $kategori, $akses, $ukuran]) {
            $this->simpan('dokumen', $nama, [
                'kategori' => $kategori,
                'payload' => [
                    'file' => $file,
                    'tipe' => strtoupper(pathinfo($file, PATHINFO_EXTENSION)),
                    'akses' => $akses,
                    'ukuran' => $ukuran,
                ],
            ], $admin, $i + 1);
        }
    }

    private function faq(?User $admin): void
    {
        $data = [
            ['Siapa yang bisa mendaftar magang?', 'Mahasiswa aktif D3/D4/S1 semua jurusan yang telah menempuh minimal semester 5.'],
            ['Berapa lama periode magang?', 'Satu periode berlangsung sekitar 12 minggu, mengikuti kalender periode yang dibuka admin.'],
            ['Apakah magang ini bersertifikat?', 'Ya. Sertifikat terbit otomatis setelah absensi minimal 80%, laporan lengkap, dan penilaian final disetujui pembimbing.'],
            ['Bagaimana mekanisme penilaian?', 'Pembimbing menilai empat kriteria berbobot setiap minggu; nilai akhir adalah rata-rata terbobot seluruh periode.'],
        ];

        foreach ($data as $i => [$pertanyaan, $jawaban]) {
            $this->simpan('faq', $pertanyaan, [
                'isi' => $jawaban,
                'payload' => ['jawaban' => $jawaban],
            ], $admin, $i + 1);
        }
    }

    private function logAktivitas(?User $admin): void
    {
        if (! $admin || ActivityLog::where('aksi', 'seed')->exists()) {
            return;
        }

        $contoh = [
            ['login', 'Masuk ke sistem sebagai admin'],
            ['tambah_peserta', 'Menambahkan peserta baru MKD-2026-0847'],
            ['ubah_periode', 'Memperbarui periode Okt – Des 2026'],
            ['export_laporan', 'Mengunduh rekap monitoring kinerja'],
        ];

        foreach ($contoh as $i => [$aksi, $deskripsi]) {
            ActivityLog::create([
                'user_id' => $admin->id,
                'role' => $admin->role,
                'aksi' => $aksi,
                'deskripsi' => $deskripsi,
                'ip' => '127.0.0.1',
                'created_at' => now()->subHours($i + 1),
            ]);
        }

        ActivityLog::create([
            'user_id' => $admin->id,
            'role' => $admin->role,
            'aksi' => 'seed',
            'deskripsi' => 'Data demo dibuat oleh DatabaseSeeder.',
            'ip' => '127.0.0.1',
        ]);
    }
}

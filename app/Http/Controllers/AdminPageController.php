<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\ActivityLog;
use App\Models\CmsKonten;
use App\Models\DataDiri;
use App\Models\DataMagang;
use App\Models\Institusi;
use App\Models\Izin;
use App\Models\KriteriaPenilaian;
use App\Models\Laporan;
use App\Models\Logbook;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Pengaturan;
use App\Models\Periode;
use App\Models\Sertifikat;
use App\Models\User;
use App\Support\Kinerja;
use App\Support\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

/**
 * AdminPageController
 *
 * Seluruh halaman & aksi admin terhubung ke database (PostgreSQL/Supabase).
 *
 * Konvensi penting:
 *  - Semua class Tailwind berasal dari konstanta statis di bawah; dilarang
 *    merakit class secara dinamis (Tailwind JIT akan memangkasnya).
 *  - Skala nilai: penilaian_detail.nilai = 0–5, penilaian.total_skor = 0–100.
 *  - Kode tampilan (MKD-…, PMB-…, PNL-…) dipakai view sebagai identitas baris.
 *    Controller menerjemahkannya kembali ke id numerik lewat helper cari*().
 *  - Setiap aksi menulis ActivityLog::catat().
 */
class AdminPageController extends Controller
{
    /* ================================================================== */
    /* KONSTANTA TAMPILAN                                                  */
    /* ================================================================== */

    /** Gradien avatar (tanpa prefix bg-gradient-to-br; view sudah menuliskannya). */
    private const GRADIENT = [
        'from-komdigi-blue to-komdigi-cerulean',
        'from-indigo-500 to-purple-500',
        'from-teal-500 to-cyan-500',
        'from-pink-500 to-rose-500',
        'from-amber-500 to-orange-400',
        'from-emerald-500 to-teal-400',
        'from-violet-500 to-purple-500',
        'from-sky-500 to-blue-500',
    ];

    private const GRADIENT_NONAKTIF = 'from-slate-500 to-slate-600';

    /** Gaya kartu kriteria penilaian (siklus berdasar urutan). */
    private const GAYA_KRITERIA = [
        ['icon' => 'bg-komdigi-blue/20 text-komdigi-cerulean', 'nomor' => 'bg-komdigi-blue text-white', 'bar' => 'from-komdigi-blue to-komdigi-cerulean'],
        ['icon' => 'bg-indigo-500/20 text-indigo-400', 'nomor' => 'bg-indigo-500 text-white', 'bar' => 'from-indigo-500 to-violet-500'],
        ['icon' => 'bg-emerald-500/20 text-emerald-400', 'nomor' => 'bg-emerald-500 text-white', 'bar' => 'from-emerald-500 to-teal-400'],
        ['icon' => 'bg-amber-500/20 text-amber-400', 'nomor' => 'bg-amber-500 text-white', 'bar' => 'from-amber-500 to-orange-400'],
        ['icon' => 'bg-pink-500/20 text-pink-400', 'nomor' => 'bg-pink-500 text-white', 'bar' => 'from-pink-500 to-rose-500'],
    ];

    private const GAYA_HALAMAN = [
        'bg-sky-500/20 text-sky-400',
        'bg-emerald-500/20 text-emerald-400',
        'bg-amber-500/20 text-amber-400',
        'bg-violet-500/20 text-violet-400',
        'bg-pink-500/20 text-pink-400',
        'bg-slate-500/20 text-slate-400',
    ];

    /** posisi pengumuman (lowercase) => [class badge, class ikon]. */
    private const GAYA_PENGUMUMAN = [
        'hero' => ['kat-hero', 'bg-pink-500/20 text-pink-400'],
        'popup' => ['kat-popup', 'bg-amber-500/20 text-amber-400'],
        'running text' => ['kat-running', 'bg-sky-500/20 text-sky-400'],
    ];

    /** label tipe dokumen => class badge. */
    private const GAYA_DOKUMEN = [
        'PDF' => 'bg-rose-500/20 text-rose-400',
        'DOC' => 'bg-emerald-500/20 text-emerald-400',
        'XLS' => 'bg-violet-500/20 text-violet-400',
        'PPT' => 'bg-amber-500/20 text-amber-400',
        'LAIN' => 'bg-sky-500/20 text-sky-400',
    ];

    /** kategori CMS (lowercase) => class badge (.kat-*). */
    private const KELAS_KATEGORI = [
        'pribadi' => 'kat-pribadi',
        'semua user' => 'kat-semua',
        'semua' => 'kat-semua',
        'tim' => 'kat-tim',
        'peserta' => 'kat-peserta',
        'pembimbing' => 'kat-pembimbing',
        'koordinator' => 'kat-koordinator',
        'publik' => 'kat-semua',
        'login saja' => 'kat-pribadi',
        'umum' => 'kat-semua',
        'teknis' => 'kat-tim',
        'galeri' => 'kat-tim',
        'panduan' => 'kat-semua',
        'template' => 'kat-tim',
        'form' => 'kat-pembimbing',
    ];

    /** aksi activity_log => label badge di log sistem. */
    private const LABEL_AKSI = [
        'login' => 'LOGIN',
        'logout' => 'LOGOUT',
        'login_gagal' => 'REJECT',
        'tambah_peserta' => 'CREATE',
        'ubah_peserta' => 'UPDATE',
        'hapus_peserta' => 'DELETE',
        'toggle_peserta' => 'UPDATE',
        'assign_peserta' => 'UPDATE',
        'import_peserta' => 'IMPORT',
        'export_peserta' => 'EXPORT',
        'tambah_pembimbing' => 'CREATE',
        'ubah_pembimbing' => 'UPDATE',
        'hapus_pembimbing' => 'DELETE',
        'toggle_pembimbing' => 'UPDATE',
        'assign_pembimbing' => 'UPDATE',
        'unassign_pembimbing' => 'UPDATE',
        'export_laporan' => 'EXPORT',
        'export_log' => 'EXPORT',
        'tambah_kriteria' => 'CREATE',
        'ubah_kriteria' => 'UPDATE',
        'hapus_kriteria' => 'UPDATE',
        'koreksi_penilaian' => 'UPDATE',
        'penilaian' => 'CREATE',
        'tambah_cms' => 'CREATE',
        'ubah_cms' => 'UPDATE',
        'hapus_cms' => 'DELETE',
        'tambah_periode' => 'CREATE',
        'ubah_periode' => 'UPDATE',
        'toggle_periode' => 'UPDATE',
        'hapus_periode' => 'DELETE',
        'tambah_institusi' => 'CREATE',
        'ubah_institusi' => 'UPDATE',
        'hapus_institusi' => 'DELETE',
        'ubah_pengaturan' => 'UPDATE',
        'ubah_permission' => 'UPDATE',
        'ubah_role' => 'UPDATE',
        'tambah_role' => 'CREATE',
        'ubah_bobot' => 'UPDATE',
        'absen' => 'CREATE',
        'absen_masuk' => 'CREATE',
        'absen_pulang' => 'UPDATE',
        'izin' => 'CREATE',
        'approve' => 'APPROVE',
        'approve_izin' => 'APPROVE',
        'approve_logbook' => 'APPROVE',
        'approve_laporan' => 'APPROVE',
        'reject' => 'REJECT',
        'tolak_izin' => 'REJECT',
        'tolak_logbook' => 'REJECT',
        'tolak_laporan' => 'REJECT',
        'logbook' => 'CREATE',
        'laporan' => 'CREATE',
        'sertifikat' => 'SYSTEM',
        'seed' => 'SYSTEM',
    ];

    private const KELAS_AKSI = [
        'LOGIN' => 'bg-slate-500/15 text-slate-300',
        'LOGOUT' => 'bg-slate-500/15 text-slate-300',
        'CREATE' => 'bg-sky-500/15 text-sky-400',
        'UPDATE' => 'bg-amber-500/15 text-amber-400',
        'APPROVE' => 'bg-emerald-500/15 text-emerald-400',
        'REJECT' => 'bg-rose-500/15 text-rose-400',
        'EXPORT' => 'bg-violet-500/15 text-violet-400',
        'IMPORT' => 'bg-teal-500/15 text-teal-400',
        'DELETE' => 'bg-rose-500/15 text-rose-400',
        'SYSTEM' => 'bg-slate-500/15 text-slate-400',
    ];

    /** kelas baris tabel monitoring (statis, sesuai admin.css). */
    private const KELAS_BARIS = [
        'baik' => '',
        'perhatian' => 'row-warning',
        'bermasalah' => 'row-alert',
    ];

    private const KELAS_STATUS_KINERJA = [
        'baik' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
        'perhatian' => 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
        'bermasalah' => 'bg-rose-500/20 text-rose-400 border border-rose-500/30',
    ];

    /** warna kartu "perlu perhatian" di dashboard. */
    private const WARNA_LOW = [
        'from-amber-500 to-orange-400',
        'from-orange-500 to-red-400',
        'from-rose-500 to-pink-400',
        'from-violet-500 to-purple-400',
    ];

    /** Matriks permission default (grup => daftar item). */
    private const PERMISSION_DEFAULT = [
        ['grup' => 'Dashboard', 'items' => [
            ['label' => 'Lihat Dashboard Admin', 'admin' => true, 'pembimbing' => false, 'peserta' => false],
            ['label' => 'Lihat Dashboard Pembimbing', 'admin' => true, 'pembimbing' => true, 'peserta' => false],
        ]],
        ['grup' => 'Logbook', 'items' => [
            ['label' => 'Isi logbook sendiri', 'admin' => false, 'pembimbing' => false, 'peserta' => true],
            ['label' => 'Approve / Reject logbook', 'admin' => true, 'pembimbing' => true, 'peserta' => false],
        ]],
        ['grup' => 'Penilaian', 'items' => [
            ['label' => 'Memberi penilaian', 'admin' => true, 'pembimbing' => true, 'peserta' => false],
            ['label' => 'Atur bobot penilaian', 'admin' => true, 'pembimbing' => false, 'peserta' => false],
        ]],
        ['grup' => 'Sistem', 'items' => [
            ['label' => 'Manajemen periode & institusi', 'admin' => true, 'pembimbing' => false, 'peserta' => false],
            ['label' => 'Pengaturan sistem & role', 'admin' => true, 'pembimbing' => false, 'peserta' => false],
        ]],
    ];

    /** Definisi role bawaan sistem. */
    private const ROLE_DEFAULT = [
        'admin' => [
            'nama' => 'Admin', 'initial' => 'A', 'gradient' => 'from-amber-500 to-orange-400',
            'deskripsi' => 'Akses penuh ke seluruh fitur sistem',
        ],
        'pembimbing' => [
            'nama' => 'Pembimbing', 'initial' => 'P', 'gradient' => 'from-komdigi-blue to-komdigi-cerulean',
            'deskripsi' => 'Membimbing, menilai, dan menyetujui logbook',
        ],
        'peserta' => [
            'nama' => 'Peserta', 'initial' => 'S', 'gradient' => 'from-emerald-500 to-teal-400',
            'deskripsi' => 'Absensi, isi logbook, lihat penilaian',
        ],
    ];

    private const NOTIF_KEY = [
        'notif_logbook' => ['label' => 'Logbook Pending', 'deskripsi' => 'Pengingat jika logbook menunggu > 3 hari'],
        'notif_penilaian' => ['label' => 'Penilaian Baru', 'deskripsi' => 'Notifikasi saat pembimbing memberi nilai'],
        'notif_izin' => ['label' => 'Pengajuan Izin', 'deskripsi' => 'Notifikasi pengajuan izin / sakit peserta'],
        'notif_ringkasan' => ['label' => 'Email Ringkasan Mingguan', 'deskripsi' => 'Dikirim setiap Senin pagi'],
    ];

    private const KEAMANAN_KEY = [
        'two_factor' => ['label' => 'Two-Factor Authentication', 'deskripsi' => 'Wajibkan 2FA untuk Admin'],
        'force_password' => ['label' => 'Force Password Change', 'deskripsi' => 'Wajib ganti sandi setiap 90 hari'],
    ];

    /** Label session_timeout (view) => menit (database). */
    private const TIMEOUT = ['30 menit' => 30, '1 jam' => 60, '2 jam' => 120];

    private const JENIS_INSTITUSI = ['Universitas', 'Institut', 'Politeknik', 'Sekolah Tinggi', 'Akademi', 'SMK'];

    private const PASSWORD_AWAL = 'magangyuk123';

    /** Cache rekap peserta per-request agar halaman tidak query berulang. */
    private ?array $rekapCache = null;

    /** Cache periode aktif per-request (periodeAktif() dipanggil berkali-kali). */
    private ?Periode $periodeCache = null;

    private bool $periodeSudahDiambil = false;

    /* ================================================================== */
    /* HALAMAN                                                             */
    /* ================================================================== */

    public function dashboard()
    {
        $rekap = $this->rekapPeserta();
        $aktif = array_values(array_filter($rekap, fn (array $r) => $r['status'] === 'aktif'));
        $totalAktif = count($aktif);
        $logbookPending = Logbook::menunggu()->count();
        $periode = $this->periodeAktif();

        return view('dashboard/admin', [
            'stats' => [
                'total_peserta_aktif' => $totalAktif,
                'rata_kehadiran' => $totalAktif > 0
                    ? number_format(array_sum(array_column($aktif, 'hadir')) / $totalAktif, 1)
                    : '0.0',
                'rata_skor' => Kinerja::rataSkor(array_column($aktif, 'skor')),
                'logbook_pending' => $logbookPending,
            ],
            'lowPerformers' => $this->lowPerformers($rekap),
            'notifications' => $this->notifikasiSistem($rekap, $logbookPending, $periode),
            'recentLogbook' => $this->aktivitasLogbook(),
            'recentPenilaian' => $this->aktivitasPenilaian(),
            'recentPendaftaran' => $this->aktivitasPendaftaran(),
            'trendChart' => $this->trendChartConfig($periode),
            'institusiChart' => $this->institusiChartConfig($rekap),
            'periodeProgress' => $periode?->progress ?? 0,
        ]);
    }

    public function manajemenPeserta()
    {
        $rekap = $this->rekapPeserta();

        return view('fitur_admin/manajemenpeserta', [
            'pesertaStats' => [
                'total' => count($rekap),
                'aktif' => count(array_filter($rekap, fn (array $r) => $r['status'] === 'aktif')),
                'nonaktif' => count(array_filter($rekap, fn (array $r) => $r['status'] === 'nonaktif')),
                'selesai' => count(array_filter($rekap, fn (array $r) => $r['status'] === 'selesai')),
            ],
            'peserta' => $rekap,
            'institusiOptions' => $this->opsiInstitusi(),
            'pembimbingOptions' => $this->opsiPembimbing(),
            'periodeOptions' => $this->opsiPeriode(),
            'pagination' => $this->paginationMeta(count($rekap), count($rekap)),
            'periodeProgress' => $this->periodeAktif()?->progress ?? 0,
        ]);
    }

    public function manajemenPembimbing()
    {
        $pembimbing = User::where('role', User::ROLE_PEMBIMBING)
            ->with(['dataDiri', 'pesertaBimbingan.user'])
            ->orderBy('nama_lengkap')
            ->get();

        // Rata-rata skor yang diberikan tiap pembimbing (satu query tergrup).
        $rataSkor = Penilaian::whereNotNull('pembimbing_id')
            ->selectRaw('pembimbing_id, AVG(total_skor) as rata')
            ->groupBy('pembimbing_id')
            ->pluck('rata', 'pembimbing_id');

        $maks = (int) Pengaturan::ambil('maks_peserta_per_pembimbing', 8);
        $semuaPeserta = $this->rekapPeserta();
        $ringkasPeserta = array_map(
            fn (array $r) => ['id' => $r['id'], 'nama' => $r['nama'], 'institusi' => $r['institusi_key']],
            $semuaPeserta,
        );

        $baris = [];
        foreach ($pembimbing as $i => $user) {
            $kode = $this->kodePembimbing($user->id);
            $skorPersen = (int) round((float) ($rataSkor[$user->id] ?? 0));

            $terassign = [];
            foreach ($user->pesertaBimbingan as $magang) {
                $terassign[] = [
                    'id' => $magang->id_kode ?: '-',
                    'nama' => $magang->user?->name ?: '-',
                    'institusi' => $magang->institusi_singkat ?: '-',
                ];
            }

            $kodeTerassign = array_column($terassign, 'id');
            $tersedia = array_values(array_filter(
                $ringkasPeserta,
                fn (array $r) => ! in_array($r['id'], $kodeTerassign, true),
            ));

            $jumlah = $user->pesertaBimbingan->count();

            $baris[] = [
                'id' => $kode,
                'uid' => $user->id,
                'nama' => $user->name,
                'nip' => $user->dataDiri?->nip ?: '-',
                'email' => $user->email,
                'hp' => $user->dataDiri?->no_hp ?: '-',
                'unit' => $user->dataDiri?->unit_kerja ?: '-',
                'unit_key' => Str::slug($user->dataDiri?->unit_kerja ?: '-'),
                'jabatan' => $user->dataDiri?->jabatan ?: '-',
                'jumlah_peserta' => $jumlah,
                'skor' => $skorPersen > 0 ? number_format($skorPersen / 20, 1) : '—',
                'skor_persen' => $skorPersen,
                'beban' => $this->labelBeban($jumlah, $maks),
                'beban_key' => $this->kunciBeban($jumlah, $maks),
                'status' => $user->status,
                'initial' => $user->inisial,
                'gradient' => $this->gradientUntuk($i, $user->status),
                'bimbingan' => $this->bimbinganSingkat($user->pesertaBimbingan),
                'terassign' => $terassign,
                'tersedia' => $tersedia,
                'form' => [
                    'id' => $kode,
                    'nama' => $user->nama_lengkap,
                    'nip' => $user->dataDiri?->nip ?? '',
                    'email' => $user->email,
                    'hp' => $user->dataDiri?->no_hp ?? '',
                    'unit' => $user->dataDiri?->unit_kerja ?? '',
                    'jabatan' => $user->dataDiri?->jabatan ?? '',
                    'status' => $user->status,
                ],
            ];
        }

        return view('fitur_admin/manajemenpembimbing', [
            'pembimbingStats' => [
                'total' => count($baris),
                'aktif' => count(array_filter($baris, fn (array $b) => $b['status'] === 'aktif')),
                'peserta_dibimbing' => count($semuaPeserta),
                'rata_skor' => Kinerja::rataSkor(array_column($baris, 'skor_persen')),
            ],
            'pembimbing' => $baris,
            'unitOptions' => $this->opsiUnit(),
            'pesertaTerassign' => array_slice($ringkasPeserta, 0, 2),
            'pesertaTersedia' => $ringkasPeserta,
            'pagination' => $this->paginationMeta(count($baris), count($baris)),
            'periodeProgress' => $this->periodeAktif()?->progress ?? 0,
        ]);
    }

    public function monitoring()
    {
        $rekap = $this->rekapPeserta();

        // Deret skor mingguan (periode_key "w1", "w2", …) untuk sparkline modal detail.
        $mingguan = Penilaian::whereIn('peserta_id', array_column($rekap, 'uid'))
            ->where('periode_key', 'like', 'w%')
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get(['peserta_id', 'periode_key', 'total_skor'])
            ->groupBy('peserta_id');

        $kinerja = [];
        foreach ($rekap as $r) {
            $kelas = Kinerja::kelasKinerja((float) $r['skor'], (int) $r['hadir']);
            $bars = [];
            foreach (($mingguan[$r['uid']] ?? collect()) as $p) {
                $bars[(int) substr((string) $p->periode_key, 1)] = (int) round($p->total_skor);
            }
            ksort($bars);
            $bars = array_values(array_slice($bars, -6));
            if ($bars === [] || end($bars) !== (int) round($r['skor'])) {
                $bars[] = (int) round($r['skor']);
            }
            while (count($bars) < 5) {
                array_unshift($bars, $bars[0]);
            }

            $kinerja[] = [
                'id' => $r['id'],
                'uid' => $r['uid'],
                'nama' => $r['nama'],
                'skor' => (int) round($r['skor']),
                'pembimbing' => $this->namaPendek($r['pembimbing']),
                'pembimbing_full' => $r['pembimbing'],
                'hadir' => (int) $r['hadir'],
                'penilaian' => $r['penilaian'],
                'kinerja' => $kelas,
                'kinerja_label' => Kinerja::labelKinerja($kelas),
                'status' => $r['status'],
                'periode' => $r['periode'],
                'periode_key' => $r['periode_key'],
                'initial' => $r['initial'],
                'gradient' => $r['gradient'],
                'row_class' => self::KELAS_BARIS[$kelas] ?? '',
                'status_class' => self::KELAS_STATUS_KINERJA[$kelas] ?? self::KELAS_STATUS_KINERJA['baik'],
                'hadir_hari' => $r['hadir_hari'],
                'terlambat' => $r['terlambat'],
                'alpha' => $r['alpha'],
                'laporan' => $r['laporan'],
                'weekly_bars' => $bars,
                'penilaian_label' => match ($kelas) {
                    'baik' => 'Performa Baik',
                    'perhatian' => 'Performa Cukup',
                    default => 'Perlu Tindakan',
                },
            ];
        }

        // Urutkan: bermasalah lebih dulu agar yang perlu tindakan tampil di atas.
        usort($kinerja, function (array $a, array $b) {
            $urutan = ['bermasalah' => 0, 'perhatian' => 1, 'baik' => 2];

            return [$urutan[$a['kinerja']] ?? 3, -$a['skor']] <=> [$urutan[$b['kinerja']] ?? 3, -$b['skor']];
        });

        return view('fitur_admin/monitoringkinerja', [
            'kinerjaStats' => [
                'total' => count($kinerja),
                'baik' => count(array_filter($kinerja, fn (array $k) => $k['kinerja'] === 'baik')),
                'perhatian' => count(array_filter($kinerja, fn (array $k) => $k['kinerja'] === 'perhatian')),
                'bermasalah' => count(array_filter($kinerja, fn (array $k) => $k['kinerja'] === 'bermasalah')),
                'rata_skor' => Kinerja::rataSkor(array_column($kinerja, 'skor')),
            ],
            'kinerja' => $kinerja,
            'periodeOptions' => $this->opsiPeriode(),
            'pagination' => $this->paginationMeta(count($kinerja), count($kinerja)),
            'periodeProgress' => $this->periodeAktif()?->progress ?? 0,
        ]);
    }

    public function kelolaPenilaian()
    {
        $kriteriaModel = KriteriaPenilaian::terurut()->get();

        $kriteria = [];
        foreach ($kriteriaModel->values() as $i => $k) {
            $gaya = self::GAYA_KRITERIA[$i % count(self::GAYA_KRITERIA)];
            $kriteria[] = [
                'id' => $k->kode,
                'nomor' => $i + 1,
                'nama' => $k->nama,
                'bobot' => (int) $k->bobot,
                'deskripsi' => $k->deskripsi ?: '-',
                'icon_class' => $gaya['icon'],
                'number_class' => $gaya['nomor'],
                'bar_class' => $gaya['bar'],
                'aktif' => (bool) $k->aktif,
                'form' => [
                    'id' => $k->kode,
                    'nama' => $k->nama,
                    'bobot' => (string) (int) $k->bobot,
                    'deskripsi' => $k->deskripsi ?? '',
                    'urutan' => (string) (int) $k->urutan,
                ],
            ];
        }

        $penilaianModel = Penilaian::with(['peserta', 'pembimbing', 'detail.kriteria'])
            ->terbaru()
            ->limit(30)
            ->get();

        $penilaian = [];
        foreach ($penilaianModel as $i => $p) {
            $nilai = (float) $p->nilai_rata_rata;
            $penilaian[] = [
                'id' => sprintf('PNL-%03d', $p->id),
                'kode' => $p->peserta?->dataMagang?->id_kode ?: '-',
                'nama' => $p->peserta?->name ?: 'Peserta (terhapus)',
                'initial' => $p->peserta?->inisial ?: '??',
                'gradient' => $this->gradientUntuk($i, $p->peserta?->status ?? 'aktif'),
                'nilai' => number_format($nilai, 1),
                'nilai_class' => $nilai >= 4.0
                    ? 'text-komdigi-cerulean'
                    : ($nilai >= 3.5 ? 'text-amber-400' : 'text-rose-400'),
                'pembimbing' => $p->pembimbing?->name ?: '-',
                'tanggal' => $p->tanggal_format ?: ($p->created_at?->translatedFormat('j M Y') ?? '-'),
                'periode_label' => $p->periode_label ?: '-',
                'jenis' => $p->jenis,
                'skor' => (int) round($p->total_skor),
                'di_override' => (bool) $p->di_override_admin,
                'rincian' => $p->detail->map(fn (PenilaianDetail $d) => [
                    'kriteria' => $d->kriteria?->nama ?: 'Kriteria',
                    'nilai' => round((float) $d->nilai, 1),
                ])->all(),
                'catatan' => $p->komentar ?: 'Tidak ada catatan dari pembimbing.',
            ];
        }

        $auditLog = [];
        $logs = ActivityLog::with('user')
            ->whereIn('aksi', ['koreksi_penilaian', 'penilaian', 'ubah_kriteria', 'tambah_kriteria', 'hapus_kriteria'])
            ->terbaru()
            ->limit(8)
            ->get();

        foreach ($logs as $i => $log) {
            $jenis = match (true) {
                $log->aksi === 'koreksi_penilaian' => 'koreksi',
                str_contains($log->aksi, 'kriteria') => 'bobot',
                default => 'tambah',
            };
            $auditLog[] = [
                'jenis' => $jenis,
                'user' => $log->user_nama,
                'aksi' => $log->deskripsi ?: $log->aksi,
                'waktu' => $log->waktu,
                'initial' => $log->user?->inisial ?: 'SY',
                'gradient' => $this->gradientUntuk($i, 'aktif'),
            ];
        }

        return view('fitur_admin/kelolapenilaian', [
            'kriteria' => $kriteria,
            'totalBobot' => (int) $kriteriaModel->where('aktif', true)->sum('bobot'),
            'penilaian' => $penilaian,
            'auditLog' => $auditLog,
            'pagination' => $this->paginationMeta(count($penilaian), Penilaian::count()),
            'periodeProgress' => $this->periodeAktif()?->progress ?? 0,
        ]);
    }

    public function cms()
    {
        $grup = CmsKonten::terurut()->get()->groupBy('jenis');

        $kegiatan = $grup->get('kegiatan', collect());
        $dokumentasi = $grup->get('dokumentasi', collect());
        $anggota = $grup->get('anggota', collect());

        return view('fitur_admin/cms', [
            'kegiatanStats' => [
                'total' => $kegiatan->count(),
                'published' => $kegiatan->where('status', 'aktif')->count(),
                'draft' => $kegiatan->where('status', '!=', 'aktif')->count(),
                'pinned' => $kegiatan->filter(fn (CmsKonten $c) => (bool) ($c->payload['pin'] ?? false))->count(),
            ],
            'dokumentasiStats' => [
                'total' => $dokumentasi->count(),
                'published' => $dokumentasi->where('status', 'aktif')->count(),
                'unpublished' => $dokumentasi->where('status', '!=', 'aktif')->count(),
                'kategori' => $dokumentasi->pluck('kategori')->filter()->unique()->count(),
            ],
            'anggotaStats' => [
                'total' => $anggota->count(),
                'peserta' => $anggota->filter(fn (CmsKonten $c) => str_contains(strtolower((string) ($c->payload['posisi'] ?? $c->kategori)), 'peserta'))->count(),
                'pembimbing' => $anggota->filter(fn (CmsKonten $c) => str_contains(strtolower((string) ($c->payload['posisi'] ?? $c->kategori)), 'pembimbing'))->count(),
                'aktif' => $anggota->where('status', 'aktif')->count(),
            ],
            'kegiatan' => $this->barisKegiatan($kegiatan),
            'dokumentasi' => $this->barisDokumentasi($dokumentasi),
            'anggota' => $this->barisAnggota($anggota),
            'halaman' => $this->barisHalaman($grup->get('halaman', collect())),
            'pengumuman' => $this->barisPengumuman($grup->get('pengumuman', collect())),
            'hero' => $this->dataHero($grup->get('hero', collect())->first()),
            'menu' => $this->barisMenu($grup->get('menu', collect())),
            'dokumen' => $this->barisDokumen($grup->get('dokumen', collect())),
            'faq' => $this->barisFaq($grup->get('faq', collect())),
            'periodeProgress' => $this->periodeAktif()?->progress ?? 0,
        ]);
    }

    public function featurePendukung()
    {
        $periode = Periode::orderByDesc('tanggal_mulai')->get();
        $jumlahPeserta = DataMagang::count();
        $aktif = $this->periodeAktif();

        $barisPeriode = [];
        foreach ($periode as $p) {
            $barisPeriode[] = [
                'id' => (string) $p->id,
                'kode' => $p->kode,
                'nama' => $p->nama,
                'mulai' => $p->tanggal_mulai?->translatedFormat('j M Y') ?? '-',
                'selesai' => $p->tanggal_selesai?->translatedFormat('j M Y') ?? '-',
                'peserta' => $p->dataMagang()->count(),
                'status' => $p->status === 'aktif' ? 'Aktif' : 'Selesai',
                'progress' => $p->progress,
                'maks_peserta' => (int) $p->maks_peserta,
                'form' => [
                    'id' => (string) $p->id,
                    'nama' => $p->nama,
                    'tanggal_mulai' => $p->tanggal_mulai?->format('Y-m-d') ?? '',
                    'tanggal_selesai' => $p->tanggal_selesai?->format('Y-m-d') ?? '',
                    'maks_peserta' => (string) (int) $p->maks_peserta,
                ],
            ];
        }

        $barisInstitusi = [];
        foreach (Institusi::orderBy('nama')->get() as $i => $ins) {
            $barisInstitusi[] = [
                'id' => (string) $ins->id,
                'kode' => $ins->kode,
                'nama' => $ins->nama,
                'singkat' => $ins->singkat ?: Str::upper(Str::substr($ins->nama, 0, 4)),
                'jenis' => $ins->jenis ?: '-',
                'kota' => $ins->kota ?: '-',
                'peserta' => $ins->dataMagang()->count(),
                'status' => $ins->status,
                'gradient' => $this->gradientUntuk($i, $ins->status),
                'form' => [
                    'id' => (string) $ins->id,
                    'nama' => $ins->nama,
                    'singkat' => $ins->singkat ?? '',
                    'jenis_institusi' => $ins->jenis ?? '',
                    'kota' => $ins->kota ?? '',
                    'status' => $ins->status,
                ],
            ];
        }

        $totalLog = ActivityLog::count();
        $logs = [];
        foreach (ActivityLog::with('user')->terbaru()->limit(25)->get() as $log) {
            $label = self::LABEL_AKSI[$log->aksi] ?? 'SYSTEM';
            $logs[] = [
                'waktu' => $log->waktu,
                'user' => $log->user_nama,
                'role' => ucfirst($log->role ?: 'sistem'),
                'aksi' => $label,
                'aksi_class' => self::KELAS_AKSI[$label] ?? self::KELAS_AKSI['SYSTEM'],
                'deskripsi' => $log->deskripsi ?: '-',
                'ip' => $log->ip ?: '-',
            ];
        }

        return view('fitur_admin/featurependukung', [
            'sectionTitles' => [
                'periode' => 'Manajemen Periode Magang',
                'institusi' => 'Manajemen Institusi / Kampus',
                'log' => 'Log Aktivitas Sistem',
                'role' => 'Role & Permission',
                'pengaturan' => 'Pengaturan Sistem',
            ],
            'periodeStats' => [
                'total' => $periode->count(),
                'aktif' => $periode->where('status', 'aktif')->count(),
                'peserta' => $jumlahPeserta,
                'progress' => ($aktif?->progress ?? 0) . '%',
            ],
            'periode' => $barisPeriode,
            'institusi' => $barisInstitusi,
            'jenisInstitusiOptions' => self::JENIS_INSTITUSI,
            'logs' => $logs,
            'logMeta' => ['ditampilkan' => count($logs), 'total' => $totalLog],
            'roles' => $this->daftarRole(),
            'permissionMatrix' => $this->matriksPermission(),
            'pengaturan' => $this->dataPengaturan(),
            'periodeProgress' => $aktif?->progress ?? 0,
        ]);
    }

    /* ================================================================== */
    /* AKSI: PESERTA                                                       */
    /* ================================================================== */

    /**
     * Simpan peserta (buat baru bila id kosong, perbarui bila terisi).
     * Akun dibuat admin — tidak ada registrasi mandiri.
     */
    public function storePeserta(Request $request)
    {
        $kode = trim((string) $request->input('id', ''));
        $magang = $kode !== '' ? DataMagang::where('id_kode', $kode)->first() : null;
        $user = $magang?->user;

        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:30'],
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:50'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
                Rule::unique('data_diri', 'email')->ignore($user?->dataDiri?->id),
            ],
            'hp' => [
                'nullable', 'string', 'max:20',
                Rule::unique('data_diri', 'no_hp')->ignore($user?->dataDiri?->id),
            ],
            'nik' => ['nullable', 'string', 'max:20'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'institusi' => ['required', 'string', 'max:100'],
            'prodi' => ['required', 'string', 'max:120'],
            'pembimbing' => ['nullable', 'string', 'max:30'],
            'periode' => ['required', 'string', 'max:30'],
            'status' => ['required', Rule::in(User::STATUSES)],
        ], [], ['nim' => 'NIM', 'hp' => 'No. HP', 'nik' => 'NIK']);

        $institusi = $this->cariInstitusi($data['institusi']);
        if ($institusi === null) {
            return back()->withInput()->with('error', 'Institusi tidak ditemukan. Tambahkan lebih dulu di Fitur Pendukung.');
        }

        $periode = Periode::where('kode', $data['periode'])->first();
        if ($periode === null) {
            return back()->withInput()->with('error', 'Periode tidak ditemukan.');
        }

        $pembimbing = $this->cariPembimbing($data['pembimbing'] ?? '');
        if (($data['pembimbing'] ?? '') !== '' && $pembimbing === null) {
            return back()->withInput()->with('error', 'Pembimbing tidak ditemukan.');
        }

        $baru = $user === null;

        DB::transaction(function () use (&$user, &$magang, $data, $institusi, $periode, $pembimbing, $baru) {
            if ($baru) {
                $this->pastikanKapasitas($pembimbing);

                $user = User::create([
                    'nama_lengkap' => $data['nama'],
                    'email' => $data['email'],
                    'role' => User::ROLE_PESERTA,
                    'status' => $data['status'],
                    'password' => self::PASSWORD_AWAL,
                ]);
            } else {
                $user->update([
                    'nama_lengkap' => $data['nama'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                ]);
            }

            $hp = $this->normalisasiHp($data['hp'] ?? '');
            if ($hp === '') {
                $hp = '0811' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT);
            }

            DataDiri::updateOrCreate(['user_id' => $user->id], [
                'nik' => $this->normalisasiNik($data['nik'] ?? '', $user->id),
                'nama_lengkap' => $data['nama'],
                'tempat_lahir' => $data['tempat_lahir'] ?? '-',
                'tanggal_lahir' => $data['tanggal_lahir'] ?? '2000-01-01',
                'alamat' => $data['alamat'] ?? '-',
                'jenis_kelamin' => $data['jenis_kelamin'],
                'email' => $data['email'],
                'no_hp' => $hp,
            ]);

            $atributMagang = [
                'nis_nim' => $data['nim'],
                'institusi' => $institusi->nama,
                'institusi_id' => $institusi->id,
                'prodi' => $data['prodi'],
                'penempatan' => $magang?->penempatan ?: 'Dinas Kominfo Sumut',
                'bidang' => $magang?->bidang ?: 'Teknologi Informasi',
                'periode' => $periode->nama,
                'periode_id' => $periode->id,
                'status' => $data['status'],
                'pembimbing_id' => $pembimbing?->id,
            ];

            if ($baru) {
                $magang = DataMagang::create(['user_id' => $user->id, 'id_kode' => $this->kodePesertaBaru()] + $atributMagang);
                Sertifikat::firstOrCreate(['user_id' => $user->id], [
                    'nomor' => null, 'progress' => 0, 'status' => 'proses',
                ]);
            } else {
                $magang->update($atributMagang);
            }
        });

        ActivityLog::catat(
            $baru ? 'tambah_peserta' : 'ubah_peserta',
            ($baru ? 'Menambahkan peserta baru ' : 'Memperbarui data peserta ') . ($magang->id_kode ?: $data['nama']),
        );

        return back()->with('success', "Peserta {$data['nama']} berhasil disimpan!"
            . ($baru ? ' Sandi awal: ' . self::PASSWORD_AWAL : ''));
    }

    public function updatePeserta(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        return $this->storePeserta($request);
    }

    public function togglePeserta(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        $magang = DataMagang::where('id_kode', $request->input('id'))->first();
        abort_if($magang === null, 404, 'Peserta tidak ditemukan.');

        $baru = $magang->user->status === 'aktif' ? 'nonaktif' : 'aktif';

        DB::transaction(function () use ($magang, $baru) {
            $magang->user->update(['status' => $baru]);
            $magang->update(['status' => $baru]);
        });

        ActivityLog::catat('toggle_peserta', "Mengubah status {$magang->user->name} menjadi {$baru}");

        return back()->with('success', "Status {$magang->user->name} diubah menjadi {$baru}.");
    }

    public function destroyPeserta(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        $magang = DataMagang::where('id_kode', $request->input('id'))->first();
        abort_if($magang === null, 404, 'Peserta tidak ditemukan.');

        $nama = $magang->user->name;
        $kode = $magang->id_kode;

        // FK user_id memakai cascadeOnDelete di seluruh tabel turunan.
        DB::transaction(function () use ($magang) {
            PenilaianDetail::whereIn('penilaian_id', Penilaian::where('peserta_id', $magang->user_id)->pluck('id'))->delete();
            $magang->user->delete();
        });

        ActivityLog::catat('hapus_peserta', "Menghapus peserta {$nama} ({$kode}) beserta seluruh datanya");

        return back()->with('success', "Peserta {$nama} berhasil dihapus.");
    }

    public function assignPeserta(Request $request)
    {
        $data = $request->validate([
            'peserta_id' => ['required', 'string', 'max:30'],
            'pembimbing' => ['required', 'string', 'max:30'],
        ]);

        $magang = DataMagang::where('id_kode', $data['peserta_id'])->first();
        abort_if($magang === null, 404, 'Peserta tidak ditemukan.');

        $pembimbing = $this->cariPembimbing($data['pembimbing']);
        abort_if($pembimbing === null, 404, 'Pembimbing tidak ditemukan.');

        $this->pastikanKapasitas($pembimbing, $magang->user_id);
        $magang->update(['pembimbing_id' => $pembimbing->id]);

        ActivityLog::catat('assign_peserta', "Menugaskan {$magang->user->name} ke pembimbing {$pembimbing->name}");

        return back()->with('success', "{$magang->user->name} kini dibimbing oleh {$pembimbing->name}.");
    }

    /**
     * Impor peserta massal dari CSV atau XLSX.
     */
    public function importPeserta(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:10240']]);

        $file = $request->file('file');
        $baris = str_ends_with(strtolower($file->getClientOriginalExtension()), 'csv') || $file->getMimeType() === 'text/plain'
            ? $this->bacaCsv($file->getRealPath())
            : $this->bacaXlsx($file->getRealPath());

        if ($baris === []) {
            return back()->with('error', 'Berkas kosong atau format tidak dikenali.');
        }

        $kepala = $this->petakanKepala(array_shift($baris));
        if (! isset($kepala['nama']) || ! isset($kepala['email'])) {
            return back()->with('error', 'Kolom wajib "nama" dan "email" tidak ditemukan pada baris header.');
        }

        $berhasil = 0;
        $gagal = [];

        foreach ($baris as $i => $barisData) {
            $nomor = $i + 2;
            $ambil = fn (string $kunci, $default = '') => trim((string) ($barisData[$kepala[$kunci]] ?? $default));

            $nama = $ambil('nama');
            $email = strtolower($ambil('email'));
            if ($nama === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $gagal[] = "baris {$nomor} (nama/email tidak valid)";
                continue;
            }

            if ($this->simpanHasilImpor($nama, $email, $ambil, $gagal, $nomor)) {
                $berhasil++;
            }
        }

        ActivityLog::catat('import_peserta', "Impor peserta: {$berhasil} berhasil, " . count($gagal) . ' gagal');

        $pesan = "Impor selesai: {$berhasil} peserta ditambahkan.";
        if ($gagal !== []) {
            return back()->with('warning', $pesan . ' Gagal: ' . implode(', ', array_slice($gagal, 0, 5)) . (count($gagal) > 5 ? ', …' : ''));
        }

        return back()->with('success', $pesan . ' Sandi awal semua akun: ' . self::PASSWORD_AWAL);
    }

    public function exportPeserta(): StreamedResponse
    {
        ActivityLog::catat('export_peserta', 'Mengunduh rekap data peserta (CSV)');

        $rekap = $this->rekapPeserta();
        $baris = array_map(fn (array $r) => [
            $r['id'], $r['nama'], $r['nim'], $r['email'], $r['hp'],
            $r['institusi'], $r['prodi'], $r['pembimbing'], $r['periode'],
            $r['hadir'] . '%', (string) round($r['skor']), $r['penilaian'], ucfirst($r['status']),
        ], $rekap);

        array_unshift($baris, ['ID Peserta', 'Nama', 'NIM', 'Email', 'No. HP', 'Institusi', 'Prodi', 'Pembimbing', 'Periode', 'Kehadiran', 'Skor', 'Nilai', 'Status']);

        return $this->unduhCsv('data-peserta-' . now()->format('Ymd-His') . '.csv', $baris);
    }

    /* ================================================================== */
    /* AKSI: PEMBIMBING                                                    */
    /* ================================================================== */

    public function storePembimbing(Request $request)
    {
        $kode = trim((string) $request->input('id', ''));
        $user = $kode !== '' ? $this->cariPembimbing($kode) : null;

        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:30'],
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
                Rule::unique('data_diri', 'email')->ignore($user?->dataDiri?->id),
            ],
            'hp' => [
                'nullable', 'string', 'max:20',
                Rule::unique('data_diri', 'no_hp')->ignore($user?->dataDiri?->id),
            ],
            'unit' => ['required', 'string', 'max:120'],
            'jabatan' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [], ['nip' => 'NIP', 'hp' => 'No. HP']);

        $baru = $user === null;

        DB::transaction(function () use (&$user, $data, $baru) {
            if ($baru) {
                $user = User::create([
                    'nama_lengkap' => $data['nama'],
                    'email' => $data['email'],
                    'role' => User::ROLE_PEMBIMBING,
                    'status' => $data['status'],
                    'password' => self::PASSWORD_AWAL,
                ]);
            } else {
                $user->update([
                    'nama_lengkap' => $data['nama'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                ]);
            }

            $hp = $this->normalisasiHp($data['hp'] ?? '');
            if ($hp === '') {
                $hp = '0812' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT);
            }

            DataDiri::updateOrCreate(['user_id' => $user->id], [
                'nik' => $this->normalisasiNik('', $user->id),
                'nama_lengkap' => $data['nama'],
                'tempat_lahir' => '-',
                'tanggal_lahir' => '1990-01-01',
                'alamat' => '-',
                'jenis_kelamin' => 'L',
                'email' => $data['email'],
                'no_hp' => $hp,
                'nip' => $data['nip'],
                'jabatan' => $data['jabatan'] ?? '-',
                'unit_kerja' => $data['unit'],
                'instansi' => $data['unit'],
            ]);
        });

        ActivityLog::catat(
            $baru ? 'tambah_pembimbing' : 'ubah_pembimbing',
            ($baru ? 'Menambahkan pembimbing ' : 'Memperbarui data pembimbing ') . $data['nama'],
        );

        return back()->with('success', "Pembimbing {$data['nama']} berhasil disimpan!"
            . ($baru ? ' Sandi awal: ' . self::PASSWORD_AWAL : ''));
    }

    public function updatePembimbing(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        return $this->storePembimbing($request);
    }

    public function togglePembimbing(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        $user = $this->cariPembimbing($request->input('id'));
        abort_if($user === null, 404, 'Pembimbing tidak ditemukan.');

        $baru = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $baru]);

        ActivityLog::catat('toggle_pembimbing', "Mengubah status pembimbing {$user->name} menjadi {$baru}");

        return back()->with('success', "Status {$user->name} diubah menjadi {$baru}.");
    }

    public function destroyPembimbing(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:30']]);

        $user = $this->cariPembimbing($request->input('id'));
        abort_if($user === null, 404, 'Pembimbing tidak ditemukan.');

        $jumlah = DataMagang::where('pembimbing_id', $user->id)->count();
        if ($jumlah > 0) {
            return back()->with('error', "{$user->name} masih membimbing {$jumlah} peserta. Pindahkan lebih dulu sebelum menghapus.");
        }

        $nama = $user->name;
        // reviewed_by & penilaian.pembimbing_id memakai nullOnDelete.
        $user->delete();

        ActivityLog::catat('hapus_pembimbing', "Menghapus pembimbing {$nama}");

        return back()->with('success', "Pembimbing {$nama} berhasil dihapus.");
    }

    /**
     * Assign peserta ke pembimbing (dari halaman manajemen pembimbing).
     */
    public function assignPembimbing(Request $request)
    {
        $data = $request->validate([
            'pembimbing_id' => ['required', 'string', 'max:30'],
            'peserta_id' => ['required', 'string', 'max:30'],
        ]);

        $user = $this->cariPembimbing($data['pembimbing_id']);
        abort_if($user === null, 404, 'Pembimbing tidak ditemukan.');

        $magang = DataMagang::where('id_kode', $data['peserta_id'])->first();
        abort_if($magang === null, 404, 'Peserta tidak ditemukan.');

        $this->pastikanKapasitas($user, $magang->user_id);
        $magang->update(['pembimbing_id' => $user->id]);

        ActivityLog::catat('assign_pembimbing', "Menugaskan {$magang->user->name} ke {$user->name}");

        return back()->with('success', "{$magang->user->name} ditugaskan ke {$user->name}.");
    }

    public function unassignPembimbing(Request $request)
    {
        $data = $request->validate([
            'pembimbing_id' => ['required', 'string', 'max:30'],
            'peserta_id' => ['required', 'string', 'max:30'],
        ]);

        $user = $this->cariPembimbing($data['pembimbing_id']);
        abort_if($user === null, 404, 'Pembimbing tidak ditemukan.');

        $magang = DataMagang::where('id_kode', $data['peserta_id'])
            ->where('pembimbing_id', $user->id)
            ->first();
        abort_if($magang === null, 404, 'Peserta tidak berada dalam bimbingan pembimbing tersebut.');

        $nama = $magang->user->name;
        $magang->update(['pembimbing_id' => null]);

        ActivityLog::catat('unassign_pembimbing', "Melepas {$nama} dari bimbingan {$user->name}");

        return back()->with('success', "{$nama} dilepas dari bimbingan {$user->name}.");
    }

    /* ================================================================== */
    /* AKSI: MONITORING & PENILAIAN                                        */
    /* ================================================================== */

    public function exportLaporan(): StreamedResponse
    {
        ActivityLog::catat('export_laporan', 'Mengunduh rekap monitoring kinerja (CSV)');

        $kinerja = [];
        foreach ($this->rekapPeserta() as $r) {
            $kelas = Kinerja::kelasKinerja((float) $r['skor'], (int) $r['hadir']);
            $kinerja[] = [
                $r['id'], $r['nama'], $r['pembimbing'], $r['institusi'], $r['periode'],
                (string) round($r['skor']), $r['hadir'] . '%', $r['penilaian'],
                Kinerja::labelKinerja($kelas), ucfirst($r['status']),
                (string) $r['hadir_hari'], (string) $r['terlambat'], (string) $r['alpha'], $r['laporan'],
            ];
        }

        array_unshift($kinerja, ['ID', 'Nama', 'Pembimbing', 'Institusi', 'Periode', 'Skor', 'Kehadiran', 'Nilai', 'Kategori Kinerja', 'Status', 'Hadir (hari)', 'Terlambat', 'Alpha', 'Laporan']);

        return $this->unduhCsv('monitoring-kinerja-' . now()->format('Ymd-His') . '.csv', $kinerja);
    }

    /**
     * Simpan kriteria penilaian (buat baru bila id kosong).
     * Bila total bobot ≠ 100, seluruh bobot dinormalisasi otomatis.
     */
    public function storeKriteria(Request $request)
    {
        $kode = trim((string) $request->input('id', ''));
        $kriteria = $kode !== '' ? KriteriaPenilaian::where('kode', $kode)->first() : null;

        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'bobot' => ['required', 'integer', 'min:1', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:1', 'max:99'],
        ], [], ['id' => 'Kode kriteria']);

        $baru = $kriteria === null;

        DB::transaction(function () use (&$kriteria, $data, $baru) {
            $atribut = [
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'bobot' => (int) $data['bobot'],
                'urutan' => (int) ($data['urutan'] ?? ($baru ? KriteriaPenilaian::max('urutan') + 1 : $kriteria->urutan)),
                'aktif' => true,
            ];

            if ($baru) {
                $kriteria = KriteriaPenilaian::create(['kode' => $this->kodeKriteriaBaru()] + $atribut);
            } else {
                $kriteria->update($atribut);
            }

            $this->normalisasiBobot();
        });

        ActivityLog::catat(
            $baru ? 'tambah_kriteria' : 'ubah_kriteria',
            ($baru ? 'Menambah kriteria penilaian ' : 'Memperbarui kriteria penilaian ')
                . "{$data['nama']} (bobot {$data['bobot']}%)",
        );

        return back()->with('success', "Kriteria {$data['nama']} berhasil disimpan!");
    }

    /**
     * Hapus kriteria. Bila sudah dipakai penilaian, cukup dinonaktifkan agar
     * riwayat nilai tetap utuh (penilaian_detail punya FK cascadeOnDelete).
     */
    public function destroyKriteria(Request $request)
    {
        $request->validate(['id' => ['required', 'string', 'max:20']]);

        $kriteria = KriteriaPenilaian::where('kode', $request->input('id'))->first();
        abort_if($kriteria === null, 404, 'Kriteria tidak ditemukan.');

        if ($kriteria->detail()->exists()) {
            $kriteria->update(['aktif' => false]);
            $this->normalisasiBobot();
            ActivityLog::catat('hapus_kriteria', "Menonaktifkan kriteria {$kriteria->nama} (sudah dipakai penilaian)");

            return back()->with('warning', "Kriteria {$kriteria->nama} dinonaktifkan karena sudah dipakai pada riwayat penilaian.");
        }

        $nama = $kriteria->nama;
        $kriteria->delete();
        $this->normalisasiBobot();

        ActivityLog::catat('hapus_kriteria', "Menghapus kriteria penilaian {$nama}");

        return back()->with('success', "Kriteria {$nama} berhasil dihapus.");
    }

    /**
     * Koreksi nilai oleh admin: nilai_baru berskala 0–5 (rata-rata target).
     * Detail per-kriteria diskalakan proporsional, total_skor dihitung ulang
     * di server memakai bobot kriteria — bukan dari input klien.
     */
    public function overridePenilaian(Request $request)
    {
        $data = $request->validate([
            'penilaian_id' => ['required', 'string', 'max:30'],
            'nilai_baru' => ['required', 'numeric', 'min:0', 'max:5'],
            'alasan' => ['required', 'string', 'min:10', 'max:500'],
        ], [], ['penilaian_id' => 'Penilaian', 'nilai_baru' => 'Nilai baru']);

        $id = (int) substr($data['penilaian_id'], 4);
        $penilaian = Penilaian::with('detail')->find($id);
        abort_if($penilaian === null, 404, 'Penilaian tidak ditemukan.');

        $target = round((float) $data['nilai_baru'], 1);
        $lama = (float) $penilaian->nilai_rata_rata;

        DB::transaction(function () use ($penilaian, $target, $lama) {
            $faktor = $lama > 0 ? $target / $lama : 0;

            foreach ($penilaian->detail as $detail) {
                $nilai = $faktor > 0
                    ? round(min(5, max(0, (float) $detail->nilai * $faktor)), 2)
                    : round($target, 2);
                $detail->update(['nilai' => $nilai]);
            }

            $penilaian->refresh();

            $skor = Penilaian::hitungSkorBerbobot(
                $penilaian->detail->pluck('nilai', 'kriteria_penilaian_id')->all(),
            );

            $catatan = trim((string) $penilaian->komentar);
            $tambahan = '[Koreksi admin ' . now()->translatedFormat('j M Y') . ': ' . $this->teksBersih(request('alasan')) . ']';

            $penilaian->update([
                'total_skor' => $skor,
                'grade' => Penilaian::gradeDariSkor($skor),
                'di_override_admin' => true,
                'komentar' => $catatan === '' ? $tambahan : $catatan . ' ' . $tambahan,
            ]);
        });

        ActivityLog::catat(
            'koreksi_penilaian',
            sprintf('Koreksi nilai %s: %s → %s', $penilaian->peserta?->name ?? 'peserta', number_format($lama, 1), number_format($target, 1)),
        );

        return back()->with('success', 'Koreksi penilaian berhasil disimpan.');
    }

    /* ================================================================== */
    /* AKSI: CMS                                                           */
    /* ================================================================== */

    public function storeCms(Request $request)
    {
        $jenis = (string) $request->input('jenis', '');

        $rules = match ($jenis) {
            'hero' => [
                'judul' => ['required', 'string', 'max:255'],
                'subjudul' => ['nullable', 'string', 'max:500'],
                'tombol1' => ['nullable', 'string', 'max:60'],
                'link1' => ['nullable', 'string', 'max:255'],
                'tombol2' => ['nullable', 'string', 'max:60'],
                'link2' => ['nullable', 'string', 'max:255'],
                'tanggal_mulai' => ['nullable', 'date'],
                'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
                'status_periode' => ['nullable', 'string', 'max:60'],
                'gambar' => ['nullable', 'image', 'max:4096'],
            ],
            'kegiatan' => [
                'id' => ['nullable', 'integer'],
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string', 'max:1000'],
                'tanggal' => ['nullable', 'date'],
                'kategori' => ['required', 'string', 'max:60'],
                'cover' => ['nullable', 'image', 'max:4096'],
                'status' => ['required', 'in:publish,draft'],
            ],
            'dokumentasi' => [
                'id' => ['nullable', 'integer'],
                'judul' => ['required', 'string', 'max:255'],
                'kategori' => ['nullable', 'string', 'max:60'],
                'tanggal' => ['nullable', 'date'],
                'foto' => ['required', 'array', 'min:1'],
                'foto.*' => ['image', 'max:4096'],
            ],
            'anggota' => [
                'id' => ['nullable', 'integer'],
                'nama' => ['required', 'string', 'max:255'],
                'posisi' => ['required', 'string', 'max:60'],
                'status' => ['required', 'in:aktif,nonaktif'],
                'institusi' => ['nullable', 'string', 'max:255'],
                'bio' => ['nullable', 'string', 'max:1000'],
                'instagram' => ['nullable', 'string', 'max:100'],
                'linkedin' => ['nullable', 'string', 'max:100'],
                'urutan' => ['nullable', 'integer', 'min:0', 'max:999'],
                'foto' => ['nullable', 'image', 'max:4096'],
            ],
            'halaman' => [
                'id' => ['nullable', 'integer'],
                'judul' => ['required', 'string', 'max:255'],
                'slug' => ['nullable', 'string', 'max:255'],
                'konten' => ['nullable', 'string'],
                'gambar' => ['nullable', 'image', 'max:4096'],
                'status' => ['required', 'in:publish,draft'],
                'seo_title' => ['nullable', 'string', 'max:255'],
                'seo_description' => ['nullable', 'string', 'max:500'],
            ],
            'pengumuman' => [
                'id' => ['nullable', 'integer'],
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string', 'max:1000'],
                'link' => ['nullable', 'string', 'max:255'],
                'tanggal_mulai' => ['nullable', 'date'],
                'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
                'target' => ['required', 'string', 'max:60'],
                'posisi' => ['required', 'string', 'max:60'],
                'status' => ['required', 'in:aktif,nonaktif'],
            ],
            'menu' => [
                'id' => ['nullable', 'integer'],
                'label' => ['required', 'string', 'max:100'],
                'url' => ['nullable', 'string', 'max:255'],
                'status' => ['required', 'in:aktif,nonaktif'],
                'urutan' => ['nullable', 'integer', 'min:0', 'max:999'],
            ],
            'dokumen' => [
                'id' => ['nullable', 'integer'],
                'nama' => ['required', 'string', 'max:255'],
                'file' => ['nullable', 'file', 'max:20480'],
                'kategori' => ['required', 'string', 'max:60'],
                'akses' => ['required', 'string', 'max:60'],
            ],
            'faq' => [
                'id' => ['nullable', 'integer'],
                'pertanyaan' => ['required', 'string', 'max:255'],
                'jawaban' => ['required', 'string', 'max:2000'],
                'kategori' => ['required', 'string', 'max:60'],
                'urutan' => ['nullable', 'integer', 'min:0', 'max:999'],
            ],
            default => [],
        };

        if ($rules === []) {
            return back()->with('error', 'Jenis konten tidak dikenali.');
        }

        $request->validate($rules);

        $label = match ($jenis) {
            'hero' => 'Pengaturan Hero & Countdown',
            'kegiatan' => 'Kegiatan',
            'dokumentasi' => 'Foto dokumentasi',
            'anggota' => 'Anggota',
            'halaman' => 'Halaman',
            'pengumuman' => 'Pengumuman',
            'menu' => 'Menu',
            'dokumen' => 'Dokumen',
            'faq' => 'FAQ',
            default => 'Konten',
        };

        $hasil = DB::transaction(fn () => match ($jenis) {
            'hero' => $this->simpanHero($request),
            'kegiatan' => $this->simpanKegiatan($request),
            'dokumentasi' => $this->simpanDokumentasi($request),
            'anggota' => $this->simpanAnggota($request),
            'halaman' => $this->simpanHalaman($request),
            'pengumuman' => $this->simpanPengumuman($request),
            'menu' => $this->simpanMenu($request),
            'dokumen' => $this->simpanDokumen($request),
            'faq' => $this->simpanFaq($request),
        });

        ActivityLog::catat(
            $hasil['baru'] ? 'tambah_cms' : 'ubah_cms',
            ($hasil['baru'] ? 'Menambah ' : 'Memperbarui ') . strtolower($label) . ': ' . $hasil['judul'],
        );

        return back()->with('success', $label . ' berhasil disimpan!');
    }

    public function destroyCms(Request $request)
    {
        $request->validate([
            'jenis' => ['required', 'string', 'max:40'],
            'id' => ['required', 'integer'],
        ]);

        $konten = CmsKonten::where('jenis', $request->input('jenis'))
            ->find($request->integer('id'));
        abort_if($konten === null, 404, 'Konten tidak ditemukan.');

        $judul = $konten->judul;
        $this->hapusBerkas($konten->gambar_path);
        $this->hapusBerkas($konten->file_path);
        $konten->delete();

        ActivityLog::catat('hapus_cms', "Menghapus konten {$request->input('jenis')}: {$judul}");

        return back()->with('success', 'Item berhasil dihapus.');
    }

    /* ================================================================== */
    /* AKSI: FITUR PENDUKUNG & PENGATURAN                                  */
    /* ================================================================== */

    public function storeFeature(Request $request)
    {
        $jenis = (string) $request->input('jenis', 'umum');

        $rules = match ($jenis) {
            'periode' => [
                'id' => ['nullable', 'integer'],
                'nama' => ['required', 'string', 'max:80'],
                'tanggal_mulai' => ['required', 'date'],
                'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
                'maks_peserta' => ['nullable', 'integer', 'min:1', 'max:10000'],
                'set_aktif' => ['nullable', 'in:1'],
            ],
            'periode_status' => ['id' => ['required', 'integer']],
            'institusi' => [
                'id' => ['nullable', 'integer'],
                'nama' => ['required', 'string', 'max:255'],
                'singkat' => ['required', 'string', 'max:30'],
                'jenis_institusi' => ['required', 'string', 'max:50'],
                'kota' => ['nullable', 'string', 'max:80'],
                'status' => ['required', 'in:aktif,nonaktif'],
            ],
            'role' => [
                'id' => ['nullable', 'string', 'max:20'],
                'nama' => ['required', 'string', 'max:100'],
                'slug' => ['nullable', 'string', 'max:100'],
                'deskripsi' => ['nullable', 'string', 'max:255'],
            ],
            'permission' => ['permission' => ['nullable', 'array']],
            'bobot' => ['bobot' => ['required', 'array']],
            'notif' => ['notif' => ['nullable', 'array']],
            'keamanan' => ['keamanan' => ['nullable', 'array'], 'session_timeout' => ['required', Rule::in(array_keys(self::TIMEOUT))]],
            default => [
                'nama_sistem' => ['required', 'string', 'max:255'],
                'email_admin' => ['required', 'email', 'max:255'],
                'min_skor' => ['required', 'integer', 'min:0', 'max:100'],
                'min_kehadiran' => ['required', 'integer', 'min:0', 'max:100'],
                'maks_peserta_per_pembimbing' => ['required', 'integer', 'min:1', 'max:100'],
            ],
        };

        $request->validate($rules, [], [
            'jenis_institusi' => 'Jenis institusi',
            'min_skor' => 'Skor minimum',
            'min_kehadiran' => 'Kehadiran minimum',
            'maks_peserta_per_pembimbing' => 'Maks. peserta per pembimbing',
            'session_timeout' => 'Session timeout',
        ]);

        $hasil = match ($jenis) {
            'periode' => $this->simpanPeriode($request),
            'periode_status' => $this->togglePeriode($request),
            'institusi' => $this->simpanInstitusi($request),
            'role' => $this->simpanRole($request),
            'permission' => $this->simpanPermission($request),
            'bobot' => $this->simpanBobot($request),
            'notif' => $this->simpanNotif($request),
            'keamanan' => $this->simpanKeamanan($request),
            default => $this->simpanUmum($request),
        };

        ActivityLog::catat($hasil[0], $hasil[1]);

        return back()->with('success', $hasil[1]);
    }

    public function destroyFeature(Request $request)
    {
        $request->validate([
            'jenis' => ['required', 'string', 'max:40'],
            'id' => ['required', 'integer'],
        ]);

        $jenis = $request->input('jenis');

        if ($jenis === 'institusi') {
            $institusi = Institusi::find($request->integer('id'));
            abort_if($institusi === null, 404, 'Institusi tidak ditemukan.');

            $dipakai = DataMagang::where('institusi_id', $institusi->id)->count();
            if ($dipakai > 0) {
                return back()->with('error', "{$institusi->nama} masih dipakai {$dipakai} peserta. Nonaktifkan saja alih-alih menghapus.");
            }

            $nama = $institusi->nama;
            $institusi->delete();
            ActivityLog::catat('hapus_institusi', "Menghapus institusi {$nama}");

            return back()->with('success', "Institusi {$nama} berhasil dihapus.");
        }

        if ($jenis === 'periode') {
            $periode = Periode::find($request->integer('id'));
            abort_if($periode === null, 404, 'Periode tidak ditemukan.');

            $dipakai = DataMagang::where('periode_id', $periode->id)->count();
            if ($dipakai > 0) {
                return back()->with('error', "Periode {$periode->nama} masih dipakai {$dipakai} peserta dan tidak bisa dihapus.");
            }

            $nama = $periode->nama;
            $periode->delete();
            ActivityLog::catat('hapus_periode', "Menghapus periode {$nama}");

            return back()->with('success', "Periode {$nama} berhasil dihapus.");
        }

        return back()->with('error', 'Jenis data tidak dikenali.');
    }

    public function exportLog(): StreamedResponse
    {
        ActivityLog::catat('export_log', 'Mengunduh log aktivitas sistem (CSV)');

        $baris = [];
        foreach (ActivityLog::with('user')->terbaru()->limit(2000)->get() as $log) {
            $baris[] = [
                $log->created_at?->format('Y-m-d H:i:s') ?? '',
                $log->user_nama,
                ucfirst($log->role ?: 'sistem'),
                self::LABEL_AKSI[$log->aksi] ?? strtoupper($log->aksi),
                $log->aksi,
                $log->deskripsi ?: '',
                $log->ip ?: '',
            ];
        }

        array_unshift($baris, ['Waktu', 'User', 'Role', 'Label Aksi', 'Aksi (mentah)', 'Deskripsi', 'IP']);

        return $this->unduhCsv('log-aktivitas-' . now()->format('Ymd-His') . '.csv', $baris);
    }

    /**
     * Simpan satu key pengaturan secara generik (dipakai bila ada form tambahan).
     */
    public function storePengaturan(Request $request)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:100', 'alpha_dash'],
            'value' => ['nullable'],
            'grup' => ['nullable', 'string', 'max:50'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        Pengaturan::simpan(
            $data['key'],
            $data['value'] ?? null,
            $data['grup'] ?? 'umum',
            $data['label'] ?? null,
        );

        ActivityLog::catat('ubah_pengaturan', "Memperbarui pengaturan {$data['key']}");

        return back()->with('success', "Pengaturan {$data['key']} berhasil disimpan.");
    }

    /* ================================================================== */
    /* HELPER: REKAP PESERTA                                               */
    /* ================================================================== */

    /**
     * Rekap seluruh peserta (identitas + kehadiran + skor) dengan query
     * terbatch: 1 query data_magang, 1 penilaian, 1 absensi, 1 laporan.
     * Hasil di-cache per-request karena dipakai banyak halaman/aksi.
     */
    private function rekapPeserta(): array
    {
        if ($this->rekapCache !== null) {
            return $this->rekapCache;
        }

        $magangList = DataMagang::with(['user.dataDiri', 'pembimbing', 'institusiRel', 'periodeRel'])
            ->whereHas('user', fn ($q) => $q->where('role', User::ROLE_PESERTA))
            ->orderBy('id_kode')
            ->get();

        $userIds = $magangList->pluck('user_id')->filter()->values()->all();
        if ($userIds === []) {
            return $this->rekapCache = [];
        }

        $penilaian = Penilaian::with('detail')
            ->whereIn('peserta_id', $userIds)
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get()
            ->groupBy('peserta_id');

        $absensi = Absensi::whereIn('user_id', $userIds)
            ->get(['user_id', 'tanggal', 'status'])
            ->groupBy('user_id');

        $laporan = Laporan::whereIn('user_id', $userIds)
            ->where('tipe', Laporan::TIPE_MINGGUAN)
            ->get(['user_id', 'status'])
            ->groupBy('user_id');

        $hasil = [];
        foreach ($magangList as $i => $m) {
            $user = $m->user;
            if ($user === null) {
                continue;
            }

            $periode = $m->periodeRel;
            $totalHari = $periode !== null ? Kinerja::hariKerja($periode) : 0;
            $mulai = $periode?->tanggal_mulai;
            $selesai = $periode !== null ? Kinerja::batas($periode) : null;

            $ringkas = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'cuti' => 0, 'alpha' => 0, 'menunggu' => 0];
            foreach (($absensi[$user->id] ?? collect()) as $a) {
                $tanggal = $a->tanggal instanceof Carbon ? $a->tanggal : Carbon::parse($a->tanggal);
                if ($mulai !== null && $selesai !== null && ! $tanggal->betweenIncluded($mulai, $selesai)) {
                    continue;
                }
                $kunci = array_key_exists($a->status, $ringkas) ? $a->status : 'menunggu';
                $ringkas[$kunci]++;
            }

            $hadirHari = $ringkas['hadir'] + $ringkas['terlambat'];
            $ringkas['alpha'] = max(0, $totalHari - $hadirHari - $ringkas['izin'] - $ringkas['sakit'] - $ringkas['cuti']);
            $persen = $totalHari > 0 ? (int) round($hadirHari / $totalHari * 100) : 0;

            $daftarNilai = $penilaian[$user->id] ?? collect();
            $terakhir = $daftarNilai->last();
            $skor = (float) ($terakhir->total_skor ?? 0);

            $laporanUser = $laporan[$user->id] ?? collect();
            $totalMinggu = $periode?->total_minggu ?? 0;

            $institusi = $m->institusiRel;
            $kodeInstitusi = $institusi?->kode ?: ($m->institusi_singkat ?: '-');

            $hasil[] = [
                'id' => $m->id_kode ?: ('MKD-' . $user->id),
                'uid' => $user->id,
                'nama' => $user->name,
                'nim' => $m->nis_nim,
                'email' => $user->email,
                'hp' => $user->dataDiri?->no_hp ?: '-',
                'institusi' => $institusi?->nama ?: $m->institusi,
                'institusi_key' => $kodeInstitusi,
                'prodi' => $m->prodi,
                'pembimbing' => $m->pembimbing?->name ?: 'Belum ditugaskan',
                'pembimbing_key' => $m->pembimbing_id !== null ? $this->kodePembimbing($m->pembimbing_id) : '',
                'periode' => $periode?->nama ?: $m->periode,
                'periode_key' => $periode?->kode ?: '-',
                'status' => $user->status,
                'initial' => $user->inisial,
                'gradient' => $this->gradientUntuk($i, $user->status),
                'hadir' => $persen,
                'skor' => $skor,
                'penilaian' => $terakhir !== null ? $terakhir->nilai_rata_rata : '0.0',
                'hadir_hari' => $hadirHari,
                'terlambat' => $ringkas['terlambat'],
                'izin_hari' => $ringkas['izin'] + $ringkas['sakit'] + $ringkas['cuti'],
                'alpha' => $ringkas['alpha'],
                'laporan' => $laporanUser->where('status', 'disetujui')->count() . '/' . max($totalMinggu, $laporanUser->count()),
                'jumlah_penilaian' => $daftarNilai->count(),
                'form' => [
                    'id' => $m->id_kode ?: '',
                    'nama' => $user->nama_lengkap,
                    'nim' => $m->nis_nim,
                    'email' => $user->email,
                    'hp' => $user->dataDiri?->no_hp ?? '',
                    'nik' => $user->dataDiri?->nik ?? '',
                    'tempat_lahir' => ($user->dataDiri?->tempat_lahir === '-' ? '' : $user->dataDiri?->tempat_lahir) ?? '',
                    'tanggal_lahir' => $user->dataDiri?->tanggal_lahir?->format('Y-m-d') ?? '',
                    'jenis_kelamin' => $user->dataDiri?->jenis_kelamin ?? 'L',
                    'alamat' => ($user->dataDiri?->alamat === '-' ? '' : $user->dataDiri?->alamat) ?? '',
                    'institusi' => $kodeInstitusi,
                    'prodi' => $m->prodi,
                    'pembimbing' => $m->pembimbing_id !== null ? $this->kodePembimbing($m->pembimbing_id) : '',
                    'periode' => $periode?->kode ?? '',
                    'status' => $user->status,
                ],
            ];
        }

        return $this->rekapCache = $hasil;
    }

    /* ================================================================== */
    /* HELPER: DASHBOARD                                                   */
    /* ================================================================== */

    /** Empat peserta dengan kinerja terendah (skor naik, lalu kehadiran naik). */
    private function lowPerformers(array $rekap): array
    {
        $aktif = array_values(array_filter($rekap, fn (array $r) => $r['status'] === 'aktif'));

        usort($aktif, fn (array $a, array $b) => [$a['skor'], $a['hadir']] <=> [$b['skor'], $b['hadir']]);

        $ambil = array_slice($aktif, 0, 4);

        return array_map(
            fn (array $r, int $i) => [
                'nama' => $r['nama'],
                'id' => $r['id'],
                'skor' => (int) round($r['skor']),
                'hadir' => (int) $r['hadir'],
                'pembimbing' => $this->namaPendek($r['pembimbing']),
                'initial' => $r['initial'],
                'color' => self::WARNA_LOW[$i % count(self::WARNA_LOW)],
            ],
            $ambil,
            array_keys($ambil),
        );
    }

    /** Notifikasi sistem yang diturunkan dari kondisi data nyata. */
    private function notifikasiSistem(array $rekap, int $logbookPending, ?Periode $periode): array
    {
        $minSkor = (int) Pengaturan::ambil('min_skor', 75);
        $minKehadiran = (int) Pengaturan::ambil('min_kehadiran', 80);

        $rendah = array_filter(
            $rekap,
            fn (array $r) => $r['status'] === 'aktif' && ($r['skor'] > 0 && $r['skor'] < $minSkor || $r['hadir'] < $minKehadiran),
        );

        $izinPending = Izin::menunggu()->count();
        $waktuIzin = Izin::menunggu()->max('created_at');
        $waktuLogbook = Logbook::menunggu()->max('submitted_at');
        $pesertaBaru = User::where('role', User::ROLE_PESERTA)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $notifikasi = [];

        if ($logbookPending > 0) {
            $notifikasi[] = [
                'type' => 'danger',
                'title' => "{$logbookPending} Logbook menunggu approval",
                'desc' => 'Beberapa pembimbing belum meninjau logbook minggu ini',
                'time' => $this->waktuTerbaru($waktuLogbook !== null ? Carbon::parse($waktuLogbook) : null),
            ];
        }

        if (count($rendah) > 0) {
            $notifikasi[] = [
                'type' => 'warning',
                'title' => count($rendah) . " peserta di bawah ambang (skor < {$minSkor} / hadir < {$minKehadiran}%)",
                'desc' => 'Perlu monitoring dan tindakan pembimbing',
                'time' => 'Hari ini',
            ];
        }

        if ($izinPending > 0) {
            $notifikasi[] = [
                'type' => 'warning',
                'title' => "{$izinPending} pengajuan izin menunggu",
                'desc' => 'Menunggu persetujuan pembimbing',
                'time' => $this->waktuTerbaru($waktuIzin !== null ? Carbon::parse($waktuIzin) : null),
            ];
        }

        if ($periode !== null) {
            $notifikasi[] = [
                'type' => 'info',
                'title' => "Periode {$periode->nama} {$periode->progress}% berjalan",
                'desc' => $periode->sisa_hari > 0
                    ? "Sisa {$periode->sisa_hari} hari hingga akhir periode"
                    : 'Periode telah berakhir',
                'time' => '1 hari lalu',
            ];
        }

        $notifikasi[] = [
            'type' => 'success',
            'title' => $pesertaBaru > 0 ? "{$pesertaBaru} peserta baru minggu ini" : 'Belum ada peserta baru minggu ini',
            'desc' => 'Total ' . count($rekap) . ' peserta terdaftar di sistem',
            'time' => '2 hari lalu',
        ];

        return array_slice($notifikasi, 0, 5);
    }

    private function aktivitasLogbook(): array
    {
        $aksi = [
            Logbook::STATUS_MENUNGGU => 'mengirim logbook minggu ke-',
            Logbook::STATUS_DISETUJUI => 'logbook minggu ke-%d disetujui pembimbing',
            Logbook::STATUS_DITOLAK => 'logbook minggu ke-%d ditolak — perlu revisi',
        ];

        $hasil = [];
        $logbook = Logbook::with('user')
            ->orderByDesc('submitted_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        foreach ($logbook as $l) {
            $hasil[] = [
                'user' => $l->user?->name ?: 'Peserta',
                'action' => match ($l->status) {
                    Logbook::STATUS_DISETUJUI => "logbook minggu ke-{$l->minggu_ke} disetujui pembimbing",
                    Logbook::STATUS_DITOLAK => "logbook minggu ke-{$l->minggu_ke} ditolak — perlu revisi",
                    default => "mengirim logbook minggu ke-{$l->minggu_ke}",
                },
                'time' => $this->waktuTerbaru($l->submitted_at ?? $l->updated_at),
            ];
        }

        unset($aksi);

        return $hasil;
    }

    private function aktivitasPenilaian(): array
    {
        $hasil = [];
        $penilaian = Penilaian::with(['pembimbing', 'peserta'])
            ->terbaru()
            ->limit(3)
            ->get();

        foreach ($penilaian as $p) {
            $hasil[] = [
                'user' => $p->pembimbing?->name ?: 'Sistem',
                'action' => 'menilai ' . ($p->peserta?->name ?: 'peserta') . ' (skor ' . (int) round($p->total_skor) . ')',
                'time' => $this->waktuTerbaru($p->tanggal ?? $p->created_at),
            ];
        }

        return $hasil;
    }

    private function aktivitasPendaftaran(): array
    {
        $hasil = [];
        $peserta = User::with('dataMagang.institusiRel')
            ->where('role', User::ROLE_PESERTA)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        foreach ($peserta as $u) {
            $institusi = $u->dataMagang?->institusi_singkat ?: '-';
            $hasil[] = [
                'user' => $u->name,
                'action' => 'terdaftar — ' . $institusi . ', ' . ucfirst($u->status),
                'time' => $this->waktuTerbaru($u->created_at),
            ];
        }

        return $hasil;
    }

    /** "2 jam yang lalu" — fallback "Baru saja" bila waktu null. */
    private function waktuTerbaru(?Carbon $waktu): string
    {
        return $waktu !== null ? $waktu->diffForHumans() : 'Baru saja';
    }

    private function trendChartConfig(?Periode $periode): array
    {
        $ticks = ['color' => '#94a3b8', 'font' => ['size' => 11]];
        $grid = ['color' => 'rgba(255,255,255,0.05)'];

        $jumlahMinggu = $periode !== null ? min($periode->total_minggu, 12) : 6;
        $jumlahMinggu = max(1, $jumlahMinggu);

        $labels = [];
        $dataPeserta = [];
        $dataSkor = [];

        // Jumlah peserta kumulatif berdasar tanggal pembuatan akun.
        $pesertaBaru = User::where('role', User::ROLE_PESERTA)
            ->orderBy('created_at')
            ->pluck('created_at');

        $skorMingguan = Penilaian::where('periode_key', 'like', 'w%')
            ->selectRaw("periode_key, AVG(total_skor) as rata")
            ->groupBy('periode_key')
            ->pluck('rata', 'periode_key');

        $totalPeserta = $pesertaBaru->count();

        for ($m = 1; $m <= $jumlahMinggu; $m++) {
            $labels[] = 'Minggu ' . $m;

            $batas = $periode !== null
                ? ($periode->selesaiMinggu($m)?->endOfDay() ?? now())
                : now()->subWeeks($jumlahMinggu - $m)->endOfWeek();

            $kumulatif = $pesertaBaru->filter(fn ($t) => $t !== null && $t->lessThanOrEqualTo($batas))->count();
            $dataPeserta[] = $kumulatif > 0 ? $kumulatif : $totalPeserta;

            $rata = $skorMingguan['w' . $m] ?? null;
            $dataSkor[] = $rata !== null ? round((float) $rata, 1) : null;
        }

        // Isi celah minggu tanpa penilaian agar garis chart tidak putus.
        $isi = null;
        foreach ($dataSkor as $k => $v) {
            if ($v === null) {
                $dataSkor[$k] = $isi;
            } else {
                $isi = $v;
            }
        }
        $dataSkor = array_map(fn ($v) => $v ?? 0, $dataSkor);

        return [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Peserta Aktif',
                        'data' => $dataPeserta,
                        'borderColor' => '#38bdf8',
                        'backgroundColor' => 'rgba(56, 189, 248, 0.1)',
                        'fill' => true,
                        'tension' => 0.35,
                        'pointRadius' => 4,
                        'pointBackgroundColor' => '#38bdf8',
                    ],
                    [
                        'label' => 'Rata-rata Skor',
                        'data' => $dataSkor,
                        'borderColor' => '#f59e0b',
                        'backgroundColor' => 'transparent',
                        'tension' => 0.35,
                        'pointRadius' => 4,
                        'pointBackgroundColor' => '#f59e0b',
                        'yAxisID' => 'y1',
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'interaction' => ['mode' => 'index', 'intersect' => false],
                'plugins' => ['legend' => ['labels' => ['color' => '#94a3b8', 'font' => ['size' => 11]]]],
                'scales' => [
                    'x' => ['ticks' => $ticks, 'grid' => $grid],
                    'y' => ['ticks' => $ticks, 'grid' => $grid],
                    'y1' => ['position' => 'right', 'min' => 0, 'max' => 100, 'ticks' => $ticks, 'grid' => ['drawOnChartArea' => false]],
                ],
            ],
        ];
    }

    private function institusiChartConfig(array $rekap): array
    {
        $hitung = [];
        foreach ($rekap as $r) {
            $kunci = $r['institusi_key'] ?: 'Lainnya';
            $hitung[$kunci] = ($hitung[$kunci] ?? 0) + 1;
        }

        arsort($hitung);

        $atas = array_slice($hitung, 0, 5, true);
        $sisa = array_sum(array_slice($hitung, 5));

        $labels = array_keys($atas);
        $data = array_values($atas);
        $warna = ['#0055FF', '#0093DD', '#38bdf8', '#10b981', '#f59e0b'];

        if ($sisa > 0) {
            $labels[] = 'Lainnya';
            $data[] = $sisa;
            $warna[] = '#a78bfa';
        }

        if ($data === []) {
            $labels = ['Belum ada data'];
            $data = [1];
            $warna = ['#475569'];
        }

        return [
            'type' => 'doughnut',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => $warna,
                    'borderWidth' => 0,
                    'hoverOffset' => 6,
                ]],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => ['legend' => ['position' => 'bottom', 'labels' => ['color' => '#94a3b8', 'font' => ['size' => 11], 'padding' => 14]]],
                'cutout' => '58%',
            ],
        ];
    }

    /* ================================================================== */
    /* HELPER: BARIS CMS                                                   */
    /* ================================================================== */

    private function dataHero(?CmsKonten $hero): array
    {
        $payload = $hero?->payload ?? [];
        $periode = $this->periodeAktif();

        $selesai = $payload['tanggal_selesai'] ?? $periode?->tanggal_selesai?->format('Y-m-d');
        $mulai = $payload['tanggal_mulai'] ?? $periode?->tanggal_mulai?->format('Y-m-d');

        $target = $selesai !== null ? Carbon::parse($selesai)->endOfDay() : null;
        $diff = $target !== null ? now()->diff($target, false) : null;

        return [
            'id' => (string) ($hero?->id ?? ''),
            'judul' => $payload['judul'] ?? $hero?->judul ?? ($periode?->nama ?? 'Magang Komdigi'),
            'subjudul' => $payload['subjudul'] ?? 'Program magang bersertifikat untuk mahasiswa seluruh Indonesia.',
            'tombol1' => $payload['tombol1'] ?? 'Lihat Kegiatan',
            'link1' => $payload['link1'] ?? '#kegiatan',
            'tombol2' => $payload['tombol2'] ?? 'Galeri Dokumentasi',
            'link2' => $payload['link2'] ?? '#dokumentasi',
            'tanggal_mulai' => (string) ($mulai ?? ''),
            'tanggal_selesai' => (string) ($selesai ?? ''),
            'status_periode' => $payload['status_periode'] ?? ($periode !== null && $periode->progress < 100 ? 'Sedang Berjalan' : 'Selesai'),
            'countdown' => [
                'hari' => max(0, (int) ($diff->days ?? 0)),
                'jam' => max(0, (int) ($diff->h ?? 0)),
                'menit' => max(0, (int) ($diff->i ?? 0)),
                'detik' => max(0, (int) ($diff->s ?? 0)),
            ],
            'progress' => $periode?->progress ?? 0,
        ];
    }

    /** Baris tab Kegiatan: judul, deskripsi, tanggal, kategori, cover, status, pin. */
    private function barisKegiatan($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $kategori = $payload['kategori'] ?? ($c->kategori ?: 'Semua');
            $status = in_array($c->status, ['publish', 'aktif'], true) ? 'publish' : 'draft';
            $tanggal = $payload['tanggal'] ?? $c->published_at?->format('Y-m-d');

            $hasil[] = [
                'id' => (string) $c->id,
                'judul' => $c->judul,
                'slug' => '/' . ltrim((string) ($c->slug ?: Str::slug($c->judul)), '/'),
                'deskripsi' => $payload['deskripsi'] ?? Str::limit(Sanitizer::teks($c->isi), 120),
                'tanggal' => $tanggal !== null ? Carbon::parse($tanggal)->translatedFormat('j M Y') : '-',
                'kategori' => $kategori,
                'kategori_class' => self::KELAS_KATEGORI[Str::lower($kategori)] ?? 'kat-semua',
                'cover' => $this->urlBerkas($c->gambar_path),
                'status' => $status,
                'pin' => (bool) ($payload['pin'] ?? ($c->urutan === 0)),
                'urutan' => (int) $c->urutan,
                'form' => [
                    'id' => (string) $c->id,
                    'judul' => $c->judul,
                    'deskripsi' => $payload['deskripsi'] ?? (string) ($c->isi ?? ''),
                    'tanggal' => (string) ($tanggal ?? ''),
                    'kategori' => $kategori,
                    'status' => $status,
                    'pin' => (bool) ($payload['pin'] ?? ($c->urutan === 0)) ? '1' : '',
                ],
            ];
        }

        return $hasil;
    }

    /** Baris tab Dokumentasi: satu baris per foto (simpanDokumentasi membuat satu record per berkas). */
    private function barisDokumentasi($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $kategori = $c->kategori ?: 'Umum';
            $tanggal = $payload['tanggal'] ?? $c->published_at?->format('Y-m-d');

            $hasil[] = [
                'id' => (string) $c->id,
                'judul' => $c->judul,
                'kategori' => $kategori,
                'kategori_class' => self::KELAS_KATEGORI[Str::lower($kategori)] ?? 'kat-tim',
                'foto' => $this->urlBerkas($c->gambar_path),
                'tanggal' => $tanggal !== null ? Carbon::parse($tanggal)->translatedFormat('j M Y') : '-',
                'status' => $c->status === 'aktif' ? 'publish' : 'draft',
                // Dokumentasi tidak punya jalur edit (tiap unggahan = record baru),
                // jadi hanya id yang diperlukan untuk konfirmasi hapus.
                'form' => ['id' => (string) $c->id],
            ];
        }

        return $hasil;
    }

    private function barisAnggota($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $i => $c) {
            $payload = $c->payload;
            $posisi = $payload['posisi'] ?? $c->kategori ?? 'Anggota';
            $hasil[] = [
                'id' => (string) $c->id,
                'nama' => $c->judul,
                'username' => $payload['username'] ?? '@' . Str::slug($c->judul, ''),
                'posisi' => $posisi,
                'posisi_key' => Str::lower($posisi),
                'institusi' => $payload['institusi'] ?? '-',
                'bio' => $payload['bio'] ?? '',
                'instagram' => $payload['instagram'] ?? '',
                'linkedin' => $payload['linkedin'] ?? '',
                'foto' => $this->urlBerkas($c->gambar_path),
                'status' => $c->status,
                'urutan' => (int) $c->urutan,
                'initial' => $payload['initial'] ?? Str::upper(Str::substr($c->judul, 0, 2)),
                'gradient' => $payload['gradient'] ?? $this->gradientUntuk($i, $c->status),
                'form' => [
                    'id' => (string) $c->id,
                    'nama' => $c->judul,
                    'posisi' => $posisi,
                    'status' => $c->status,
                    'institusi' => $payload['institusi'] ?? '',
                    'bio' => $payload['bio'] ?? '',
                    'instagram' => $payload['instagram'] ?? '',
                    'linkedin' => $payload['linkedin'] ?? '',
                    'urutan' => (string) (int) $c->urutan,
                ],
            ];
        }

        return $hasil;
    }

    private function barisHalaman($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $i => $c) {
            $payload = $c->payload;
            $status = in_array($c->status, ['publish', 'aktif'], true) ? 'publish' : 'draft';
            $hasil[] = [
                'id' => (string) $c->id,
                'judul' => $c->judul,
                'slug' => '/' . ltrim((string) ($c->slug ?: Str::slug($c->judul)), '/'),
                'status' => $status,
                'icon_class' => self::GAYA_HALAMAN[$i % count(self::GAYA_HALAMAN)],
                'deskripsi' => $payload['deskripsi'] ?? Str::limit(Sanitizer::teks($c->isi), 90),
                'form' => [
                    'id' => (string) $c->id,
                    'judul' => $c->judul,
                    'slug' => (string) ($c->slug ?? ''),
                    'konten' => (string) ($c->isi ?? ''),
                    'status' => $status,
                    'seo_title' => $payload['seo_title'] ?? '',
                    'seo_description' => $payload['seo_description'] ?? '',
                ],
            ];
        }

        return $hasil;
    }

    private function barisPengumuman($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $posisi = $payload['posisi'] ?? $c->kategori ?? 'Popup';
            $gaya = self::GAYA_PENGUMUMAN[Str::lower($posisi)] ?? self::GAYA_PENGUMUMAN['popup'];

            $mulai = $payload['tanggal_mulai'] ?? null;
            $selesai = $payload['tanggal_selesai'] ?? null;
            $tanggal = '-';
            if ($mulai !== null) {
                $tanggal = $selesai !== null && $selesai !== $mulai
                    ? Carbon::parse($mulai)->translatedFormat('j') . '–' . Carbon::parse($selesai)->translatedFormat('j M Y')
                    : Carbon::parse($mulai)->translatedFormat('j M Y');
            }

            $hasil[] = [
                'id' => (string) $c->id,
                'judul' => $c->judul,
                'posisi' => $posisi,
                'posisi_class' => $gaya[0],
                'icon_class' => $gaya[1],
                'target' => $payload['target'] ?? 'Semua',
                'tanggal' => $tanggal,
                'link' => $payload['link'] ?? '#',
                'status' => $c->status,
                'deskripsi' => $payload['deskripsi'] ?? (string) $c->isi,
                'form' => [
                    'id' => (string) $c->id,
                    'judul' => $c->judul,
                    'deskripsi' => $payload['deskripsi'] ?? (string) $c->isi,
                    'link' => $payload['link'] ?? '',
                    'tanggal_mulai' => (string) ($mulai ?? ''),
                    'tanggal_selesai' => (string) ($selesai ?? ''),
                    'target' => $payload['target'] ?? 'Semua',
                    'posisi' => $posisi,
                    'status' => $c->status,
                ],
            ];
        }

        return $hasil;
    }

    private function barisMenu($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $hasil[] = [
                'id' => (string) $c->id,
                'label' => $c->judul,
                'url' => $payload['url'] ?? '#',
                'tipe' => $payload['tipe'] ?? $c->kategori ?? 'Default',
                'status' => $c->status,
                'form' => [
                    'id' => (string) $c->id,
                    'label' => $c->judul,
                    'url' => $payload['url'] ?? '',
                    'status' => $c->status,
                    'urutan' => (string) (int) $c->urutan,
                ],
            ];
        }

        return $hasil;
    }

    private function barisDokumen($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $tipe = $payload['tipe'] ?? $this->tipeDokumen($c->file_path);
            $akses = $payload['akses'] ?? 'Login saja';
            $hasil[] = [
                'id' => (string) $c->id,
                'nama' => $c->judul,
                'file' => $payload['file'] ?? basename((string) $c->file_path),
                'file_url' => $this->urlBerkas($c->file_path),
                'tipe' => $tipe,
                'tipe_class' => self::GAYA_DOKUMEN[$tipe] ?? self::GAYA_DOKUMEN['LAIN'],
                'kategori' => $c->kategori ?: 'Umum',
                'akses' => $akses,
                'akses_class' => self::KELAS_KATEGORI[Str::lower($akses)] ?? 'kat-pribadi',
                'ukuran' => $payload['ukuran'] ?? '-',
                'form' => [
                    'id' => (string) $c->id,
                    'nama' => $c->judul,
                    'kategori' => $c->kategori ?? '',
                    'akses' => $akses,
                ],
            ];
        }

        return $hasil;
    }

    private function barisFaq($koleksi): array
    {
        $hasil = [];
        foreach ($koleksi->values() as $c) {
            $payload = $c->payload;
            $kategori = $c->kategori ?: 'Umum';
            $hasil[] = [
                'id' => (string) $c->id,
                'pertanyaan' => $c->judul,
                'jawaban' => $payload['jawaban'] ?? (string) $c->isi,
                'kategori' => $kategori,
                'kategori_class' => self::KELAS_KATEGORI[Str::lower($kategori)] ?? 'kat-semua',
                'form' => [
                    'id' => (string) $c->id,
                    'pertanyaan' => $c->judul,
                    'jawaban' => $payload['jawaban'] ?? (string) $c->isi,
                    'kategori' => $kategori,
                    'urutan' => (string) (int) $c->urutan,
                ],
            ];
        }

        return $hasil;
    }

    /* ================================================================== */
    /* HELPER: LOOKUP & FORMAT                                             */
    /* ================================================================== */

    /** Kode tampilan pembimbing diturunkan dari id user (tidak disimpan di DB). */
    private function kodePembimbing(int $userId): string
    {
        return sprintf('PMB-%03d', $userId);
    }

    /** Terjemahkan "PMB-001" (atau potongan nama) kembali ke model User. */
    private function cariPembimbing(mixed $kode): ?User
    {
        $kode = trim((string) $kode);
        if ($kode === '') {
            return null;
        }

        if (preg_match('/^PMB-0*(\d+)$/i', $kode, $cocok)) {
            return User::where('role', User::ROLE_PEMBIMBING)->find((int) $cocok[1]);
        }

        if (ctype_digit($kode)) {
            return User::where('role', User::ROLE_PEMBIMBING)->find((int) $kode);
        }

        return User::where('role', User::ROLE_PEMBIMBING)
            ->whereRaw('LOWER(nama_lengkap) LIKE ?', ['%' . Str::lower($kode) . '%'])
            ->orderBy('nama_lengkap')
            ->first();
    }

    /** Terima kode ("USU"), singkatan, atau nama institusi. */
    private function cariInstitusi(mixed $kodeAtauNama): ?Institusi
    {
        $nilai = trim((string) $kodeAtauNama);
        if ($nilai === '') {
            return null;
        }

        return Institusi::where('kode', $nilai)
            ->orWhere('singkat', $nilai)
            ->orWhere('nama', $nilai)
            ->orWhereRaw('LOWER(nama) LIKE ?', ['%' . Str::lower($nilai) . '%'])
            ->orderByRaw('CASE WHEN kode = ? THEN 0 WHEN singkat = ? THEN 1 ELSE 2 END', [$nilai, $nilai])
            ->first();
    }

    /** "Budi Santoso, S.Kom" -> "Budi Santoso" (gelar dibuang utk tabel sempit). */
    private function namaPendek(?string $nama): string
    {
        $nama = trim((string) $nama);

        return $nama === '' ? '-' : trim(Str::before($nama, ','));
    }

    private function gradientUntuk(int $i, ?string $status): string
    {
        return $status === 'nonaktif'
            ? self::GRADIENT_NONAKTIF
            : self::GRADIENT[$i % count(self::GRADIENT)];
    }

    /** Buang markup apa pun dari teks kiriman pengguna. */
    private function teksBersih(mixed $nilai): string
    {
        return Sanitizer::teks(is_scalar($nilai) ? (string) $nilai : null);
    }

    /* ================================================================== */
    /* HELPER: BEBAN PEMBIMBING & NORMALISASI                              */
    /* ================================================================== */

    private function labelBeban(int $jumlah, int $maks): string
    {
        if ($jumlah === 0) {
            return 'Rendah';
        }

        $maks = max(1, $maks);

        return match (true) {
            $jumlah >= $maks => 'Tinggi',
            $jumlah >= (int) ceil($maks * 0.6) => 'Sedang',
            default => 'Rendah',
        };
    }

    private function kunciBeban(int $jumlah, int $maks): string
    {
        return Str::lower($this->labelBeban($jumlah, $maks));
    }

    /** Ringkasan 3 peserta bimbingan utk kartu pembimbing. */
    private function bimbinganSingkat($magangCollection): array
    {
        $peta = [];
        foreach ($this->rekapPeserta() as $r) {
            $peta[$r['id']] = $r;
        }

        $hasil = [];
        foreach ($magangCollection as $magang) {
            $kode = $magang->id_kode ?: ('MKD-' . $magang->user_id);
            $hasil[] = [
                'initial' => $magang->user?->inisial ?: '??',
                'nama' => $magang->user?->name ?: '-',
                'skor' => $peta[$kode]['penilaian'] ?? '0.0',
            ];
        }

        return array_slice($hasil, 0, 3);
    }

    private function normalisasiHp(mixed $hp): string
    {
        return preg_replace('/\D+/', '', (string) $hp) ?? '';
    }

    /** NIK wajib terisi (kolom NOT NULL) — dibuat deterministik dari id user. */
    private function normalisasiNik(mixed $nik, int $userId): string
    {
        $bersih = preg_replace('/\D+/', '', (string) $nik) ?? '';

        return $bersih !== ''
            ? Str::limit($bersih, 20, '')
            : '1271' . str_pad((string) $userId, 12, '0', STR_PAD_LEFT);
    }

    /* ================================================================== */
    /* HELPER: GENERATOR KODE & PENJAGA KAPASITAS                          */
    /* ================================================================== */

    private function kodePesertaBaru(): string
    {
        $tahun = (int) now()->format('Y');
        $prefix = "MKD-{$tahun}-";
        $maks = 0;

        foreach (DataMagang::where('id_kode', 'like', $prefix . '%')->pluck('id_kode') as $kode) {
            $maks = max($maks, (int) substr((string) $kode, strlen($prefix)));
        }

        return sprintf('MKD-%d-%04d', $tahun, $maks + 1);
    }

    private function kodeKriteriaBaru(): string
    {
        $maks = 0;

        foreach (KriteriaPenilaian::pluck('kode') as $kode) {
            if (preg_match('/^KRT-0*(\d+)$/i', (string) $kode, $cocok)) {
                $maks = max($maks, (int) $cocok[1]);
            }
        }

        return sprintf('KRT-%d', $maks + 1);
    }

    private function kodeInstitusiBaru(string $singkat, string $nama): string
    {
        $bersih = preg_replace('/[^A-Za-z0-9]/', '', $singkat) ?: preg_replace('/[^A-Za-z0-9]/', '', $nama);
        $dasar = Str::limit(Str::upper($bersih !== '' ? $bersih : 'INS'), 14, '');

        $kode = $dasar;
        $i = 2;
        while (Institusi::where('kode', $kode)->exists()) {
            $kode = Str::limit($dasar, 12, '') . $i++;
        }

        return $kode;
    }

    private function kodePeriodeBaru(string $nama, ?Carbon $mulai): string
    {
        $dasar = Str::upper(Str::slug($nama, '-'));
        if ($dasar === '' || Str::length($dasar) > 20) {
            $dasar = 'PRD-' . ($mulai?->format('Y') ?? now()->format('Y'));
        }
        $dasar = Str::limit($dasar, 20, '');

        $kode = $dasar;
        $i = 2;
        while (Periode::where('kode', $kode)->exists()) {
            $kode = Str::limit($dasar, 16, '') . '-' . $i++;
        }

        return $kode;
    }

    /**
     * Tolak penugasan bila pembimbing sudah penuh. Dilempar sebagai
     * ValidationException agar kembali ke form dengan pesan, bukan halaman error.
     */
    private function pastikanKapasitas(?User $pembimbing, ?int $kecualikanPesertaUserId = null): void
    {
        if ($pembimbing === null) {
            return;
        }

        $maks = max(1, (int) Pengaturan::ambil('maks_peserta_per_pembimbing', 8));

        $jumlah = DataMagang::where('pembimbing_id', $pembimbing->id)
            ->when($kecualikanPesertaUserId !== null, fn ($q) => $q->where('user_id', '!=', $kecualikanPesertaUserId))
            ->count();

        if ($jumlah < $maks) {
            return;
        }

        throw ValidationException::withMessages([
            'pembimbing' => "Beban {$pembimbing->name} sudah {$jumlah}/{$maks} peserta. Pindahkan sebagian lebih dulu.",
        ]);
    }

    /**
     * Skalakan ulang bobot kriteria aktif agar jumlahnya persis 100%.
     * Selisih pembulatan diserap kriteria dengan bobot terbesar.
     */
    private function normalisasiBobot(): void
    {
        $kriteria = KriteriaPenilaian::where('aktif', true)->orderBy('urutan')->get();
        if ($kriteria->isEmpty()) {
            return;
        }

        $total = (int) $kriteria->sum('bobot');
        if ($total === 100) {
            return;
        }

        $jumlah = $kriteria->count();
        $baru = [];
        foreach ($kriteria as $k) {
            $baru[$k->id] = $total > 0
                ? max(1, (int) round((int) $k->bobot / $total * 100))
                : max(1, (int) floor(100 / $jumlah));
        }

        $selisih = 100 - array_sum($baru);
        if ($selisih !== 0) {
            $terbesar = array_keys($baru, max($baru))[0];
            $baru[$terbesar] = max(1, $baru[$terbesar] + $selisih);
        }

        foreach ($kriteria as $k) {
            if ((int) $k->bobot !== $baru[$k->id]) {
                $k->update(['bobot' => $baru[$k->id]]);
            }
        }
    }

    /* ================================================================== */
    /* HELPER: OPSI DROPDOWN & PAGINASI                                    */
    /* ================================================================== */

    /** kode institusi => nama (dipakai select peserta & filter tabel). */
    private function opsiInstitusi(): array
    {
        return Institusi::orderBy('nama')->pluck('nama', 'kode')->all();
    }

    /** PMB-xxx => nama pembimbing aktif. */
    private function opsiPembimbing(): array
    {
        $hasil = [];
        $pembimbing = User::where('role', User::ROLE_PEMBIMBING)
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'status']);

        foreach ($pembimbing as $u) {
            $hasil[$this->kodePembimbing($u->id)] = $u->nama_lengkap . ($u->status === 'nonaktif' ? ' (nonaktif)' : '');
        }

        return $hasil;
    }

    /** kode periode => nama. */
    private function opsiPeriode(): array
    {
        return Periode::orderByDesc('tanggal_mulai')->pluck('nama', 'kode')->all();
    }

    /** slug unit kerja => nama unit (dipakai select pembimbing & filter). */
    private function opsiUnit(): array
    {
        $hasil = [];
        $unit = DataDiri::whereNotNull('unit_kerja')
            ->whereNotIn('unit_kerja', ['', '-'])
            ->distinct()
            ->orderBy('unit_kerja')
            ->pluck('unit_kerja');

        foreach ($unit as $u) {
            $hasil[Str::slug($u)] = $u;
        }

        return $hasil;
    }

    private function periodeAktif(): ?Periode
    {
        if (! $this->periodeSudahDiambil) {
            $this->periodeCache = Periode::aktif()->orderByDesc('tanggal_mulai')->first()
                ?? Periode::orderByDesc('tanggal_mulai')->first();
            $this->periodeSudahDiambil = true;
        }

        return $this->periodeCache;
    }

    /**
     * Data tampil penuh dalam satu halaman (tanpa paginator), jadi meta
     * pagination diturunkan dari jumlah baris yang dikirim ke view.
     */
    private function paginationMeta(int $ditampilkan, int $total): array
    {
        $perHalaman = max(1, $ditampilkan);

        return [
            'dari' => $total === 0 ? 0 : 1,
            'sampai' => $ditampilkan,
            'total' => $total,
            'halaman_aktif' => 1,
            'jumlah_halaman' => max(1, (int) ceil($total / $perHalaman)),
        ];
    }

    /* ================================================================== */
    /* HELPER: PENYIMPAN FITUR PENDUKUNG (return [aksi_log, pesan])        */
    /* ================================================================== */

    private function simpanPeriode(Request $request): array
    {
        $id = (int) $request->input('id', 0);
        $periode = $id > 0 ? Periode::find($id) : null;
        $baru = $periode === null;

        $nama = trim((string) $request->input('nama'));
        $mulai = $request->date('tanggal_mulai');
        $selesai = $request->date('tanggal_selesai');
        $maks = (int) $request->input('maks_peserta', 0) ?: 50;
        $setAktif = $request->boolean('set_aktif');

        DB::transaction(function () use (&$periode, $baru, $nama, $mulai, $selesai, $maks, $setAktif) {
            // Hanya satu periode aktif pada satu waktu.
            if ($setAktif) {
                Periode::where('status', 'aktif')->update(['status' => 'selesai']);
            }

            $atribut = [
                'nama' => $nama,
                'tanggal_mulai' => $mulai,
                'tanggal_selesai' => $selesai,
                'maks_peserta' => $maks,
            ];

            if ($setAktif) {
                $atribut['status'] = 'aktif';
            }

            if ($baru) {
                $periode = Periode::create([
                    'kode' => $this->kodePeriodeBaru($nama, $mulai),
                    'status' => $setAktif ? 'aktif' : 'selesai',
                ] + $atribut);
            } else {
                $periode->update($atribut);
            }
        });

        return [
            $baru ? 'tambah_periode' : 'ubah_periode',
            "Periode {$nama} berhasil disimpan.",
        ];
    }

    private function togglePeriode(Request $request): array
    {
        $periode = Periode::find((int) $request->input('id'));
        abort_if($periode === null, 404, 'Periode tidak ditemukan.');

        if ($periode->status === 'aktif') {
            $periode->update(['status' => 'selesai']);

            return ['toggle_periode', "Periode {$periode->nama} dihentikan."];
        }

        Periode::where('status', 'aktif')->update(['status' => 'selesai']);
        $periode->update(['status' => 'aktif']);

        return ['toggle_periode', "Periode {$periode->nama} diaktifkan."];
    }

    private function simpanInstitusi(Request $request): array
    {
        $id = (int) $request->input('id', 0);
        $institusi = $id > 0 ? Institusi::find($id) : null;
        $baru = $institusi === null;

        $nama = trim((string) $request->input('nama'));
        $singkat = trim((string) $request->input('singkat')) ?: Str::upper(Str::substr($nama, 0, 4));

        $atribut = [
            'nama' => $nama,
            'singkat' => $singkat,
            'jenis' => (string) $request->input('jenis_institusi', ''),
            'kota' => $request->filled('kota') ? trim((string) $request->input('kota')) : null,
            'status' => (string) $request->input('status', 'aktif'),
        ];

        if ($baru) {
            Institusi::create(['kode' => $this->kodeInstitusiBaru($singkat, $nama)] + $atribut);
        } else {
            $institusi->update($atribut);
        }

        return [
            $baru ? 'tambah_institusi' : 'ubah_institusi',
            "Institusi {$nama} berhasil disimpan.",
        ];
    }

    /**
     * Role sistem (admin/pembimbing/peserta) adalah enum tetap di users.role,
     * jadi role bawaan hanya bisa diubah deskripsinya; role baru disimpan
     * sebagai pengaturan `role_tambahan`.
     */
    private function simpanRole(Request $request): array
    {
        $nama = trim((string) $request->input('nama'));
        $slug = Str::lower(trim((string) $request->input('slug'))) ?: Str::slug($nama, '-');
        $deskripsi = trim((string) $request->input('deskripsi', ''));
        $id = trim((string) $request->input('id', ''));

        if (array_key_exists($slug, self::ROLE_DEFAULT)) {
            $kustom = Pengaturan::ambil('role_deskripsi', []);
            $kustom = is_array($kustom) ? $kustom : [];
            $kustom[$slug] = $deskripsi !== '' ? $deskripsi : self::ROLE_DEFAULT[$slug]['deskripsi'];
            Pengaturan::simpan('role_deskripsi', $kustom, 'sistem', 'Deskripsi role bawaan');

            return ['ubah_role', "Role {$nama} berhasil diperbarui."];
        }

        $tambahan = Pengaturan::ambil('role_tambahan', []);
        $tambahan = is_array($tambahan) ? array_values($tambahan) : [];

        $baru = true;
        foreach ($tambahan as $k => $r) {
            if (($r['slug'] ?? '') === $slug || (string) ($r['id'] ?? '') === $id) {
                $tambahan[$k] = [
                    'id' => $r['id'] ?? $slug,
                    'nama' => $nama,
                    'slug' => $slug,
                    'deskripsi' => $deskripsi,
                ];
                $baru = false;
                break;
            }
        }

        if ($baru) {
            $tambahan[] = ['id' => $slug, 'nama' => $nama, 'slug' => $slug, 'deskripsi' => $deskripsi];
        }

        Pengaturan::simpan('role_tambahan', $tambahan, 'sistem', 'Role tambahan');

        return [$baru ? 'tambah_role' : 'ubah_role', "Role {$nama} berhasil disimpan."];
    }

    private function simpanPermission(Request $request): array
    {
        $kiriman = $request->input('permission', []);
        $kiriman = is_array($kiriman) ? $kiriman : [];
        $matriks = $this->matriksPermission();

        foreach ($matriks as $gi => &$grup) {
            foreach ($grup['items'] as $ii => &$item) {
                foreach (['admin', 'pembimbing', 'peserta'] as $role) {
                    $item[$role] = (bool) ($kiriman[$gi][$ii][$role] ?? false);
                }
            }
            unset($item);
        }
        unset($grup);

        Pengaturan::simpan('permission_matrix', $matriks, 'sistem', 'Matriks permission');

        return ['ubah_permission', 'Matriks permission berhasil diperbarui.'];
    }

    /** `bobot[i]` dipetakan posisional ke kriteria ke-i pada urutan tampilan. */
    private function simpanBobot(Request $request): array
    {
        $kriteria = KriteriaPenilaian::terurut()->get();
        $kiriman = $request->input('bobot', []);
        $kiriman = is_array($kiriman) ? $kiriman : [];

        DB::transaction(function () use ($kriteria, $kiriman) {
            foreach ($kriteria->values() as $i => $k) {
                if (! array_key_exists($i, $kiriman)) {
                    continue;
                }
                $k->update(['bobot' => max(0, min(100, (int) $kiriman[$i]))]);
            }

            $this->normalisasiBobot();
        });

        return ['ubah_bobot', 'Bobot penilaian berhasil disimpan dan dinormalisasi ke 100%.'];
    }

    private function simpanNotif(Request $request): array
    {
        $kiriman = $request->input('notif', []);
        $kiriman = is_array($kiriman) ? $kiriman : [];
        $aktif = 0;

        foreach (self::NOTIF_KEY as $key => $meta) {
            $nyala = (bool) ($kiriman[$key] ?? false);
            Pengaturan::simpan($key, $nyala, 'notifikasi', $meta['label']);
            if ($nyala) {
                $aktif++;
            }
        }

        return ['ubah_pengaturan', "Pengaturan notifikasi disimpan ({$aktif} aktif)."];
    }

    private function simpanKeamanan(Request $request): array
    {
        $kiriman = $request->input('keamanan', []);
        $kiriman = is_array($kiriman) ? $kiriman : [];

        foreach (self::KEAMANAN_KEY as $key => $meta) {
            Pengaturan::simpan($key, (bool) ($kiriman[$key] ?? false), 'keamanan', $meta['label']);
        }

        $label = (string) $request->input('session_timeout', '1 jam');
        if (! array_key_exists($label, self::TIMEOUT)) {
            $label = '1 jam';
        }

        Pengaturan::simpan('session_timeout', $label, 'keamanan', 'Session timeout');
        Pengaturan::simpan('session_timeout_menit', self::TIMEOUT[$label], 'keamanan', 'Session timeout (menit)');

        return ['ubah_pengaturan', "Pengaturan keamanan disimpan (timeout {$label})."];
    }

    private function simpanUmum(Request $request): array
    {
        Pengaturan::simpan('nama_sistem', trim((string) $request->input('nama_sistem')), 'umum', 'Nama sistem');
        Pengaturan::simpan('email_admin', trim((string) $request->input('email_admin')), 'umum', 'Email admin');
        Pengaturan::simpan('min_skor', (int) $request->input('min_skor'), 'penilaian', 'Skor minimum');
        Pengaturan::simpan('min_kehadiran', (int) $request->input('min_kehadiran'), 'penilaian', 'Kehadiran minimum (%)');
        Pengaturan::simpan('maks_peserta_per_pembimbing', (int) $request->input('maks_peserta_per_pembimbing'), 'pembimbing', 'Maks. peserta per pembimbing');

        return ['ubah_pengaturan', 'Pengaturan umum berhasil disimpan.'];
    }

    /* ================================================================== */
    /* HELPER: PEMBACA ROLE / PERMISSION / PENGATURAN                      */
    /* ================================================================== */

    private function daftarRole(): array
    {
        $jumlah = User::selectRaw('role, COUNT(*) as total')->groupBy('role')->pluck('total', 'role');
        $matriks = $this->matriksPermission();

        $deskripsiKustom = Pengaturan::ambil('role_deskripsi', []);
        $deskripsiKustom = is_array($deskripsiKustom) ? $deskripsiKustom : [];

        $hasil = [];
        foreach (self::ROLE_DEFAULT as $slug => $r) {
            $deskripsi = $deskripsiKustom[$slug] ?? $r['deskripsi'];
            $hasil[] = [
                'id' => $slug,
                'slug' => $slug,
                'nama' => $r['nama'],
                'initial' => $r['initial'],
                'gradient' => $r['gradient'],
                'pengguna' => (int) ($jumlah[$slug] ?? 0),
                'permissions' => $this->hitungPermission($matriks, $slug),
                'deskripsi' => $deskripsi,
                'bawaan' => true,
                'form' => ['id' => $slug, 'nama' => $r['nama'], 'slug' => $slug, 'deskripsi' => $deskripsi],
            ];
        }

        $tambahan = Pengaturan::ambil('role_tambahan', []);
        foreach (is_array($tambahan) ? $tambahan : [] as $t) {
            $slug = (string) ($t['slug'] ?? '');
            $nama = (string) ($t['nama'] ?? ucfirst($slug));
            $hasil[] = [
                'id' => (string) ($t['id'] ?? $slug),
                'slug' => $slug,
                'nama' => $nama,
                'initial' => Str::upper(Str::substr($nama, 0, 1)) ?: 'R',
                'gradient' => $this->gradientUntuk(count($hasil), 'aktif'),
                'pengguna' => (int) ($jumlah[$slug] ?? 0),
                'permissions' => $this->hitungPermission($matriks, $slug),
                'deskripsi' => (string) ($t['deskripsi'] ?? 'Role kustom'),
                'bawaan' => false,
                'form' => ['id' => (string) ($t['id'] ?? $slug), 'nama' => $nama, 'slug' => $slug, 'deskripsi' => (string) ($t['deskripsi'] ?? '')],
            ];
        }

        return $hasil;
    }

    private function hitungPermission(array $matriks, string $role): int
    {
        $total = 0;
        foreach ($matriks as $grup) {
            foreach ($grup['items'] ?? [] as $item) {
                if (! empty($item[$role])) {
                    $total++;
                }
            }
        }

        return $total;
    }

    private function matriksPermission(): array
    {
        $matriks = Pengaturan::ambil('permission_matrix', self::PERMISSION_DEFAULT);

        return is_array($matriks) && $matriks !== [] ? $matriks : self::PERMISSION_DEFAULT;
    }

    /**
     * Bentuk data yang dikonsumsi panel Pengaturan Sistem.
     * `bobot` diturunkan dari kriteria nyata; `keamanan` minimal 2 entri
     * karena view mengindeks $keamanan[0] dan $keamanan[1].
     */
    private function dataPengaturan(): array
    {
        $bobot = [];
        foreach (KriteriaPenilaian::terurut()->get() as $k) {
            $bobot[] = ['label' => $k->nama, 'nilai' => (int) $k->bobot];
        }
        if ($bobot === []) {
            $bobot[] = ['label' => 'Belum ada kriteria penilaian', 'nilai' => 100];
        }

        $notif = [];
        foreach (self::NOTIF_KEY as $key => $meta) {
            $notif[] = ['key' => $key, 'label' => $meta['label'], 'deskripsi' => $meta['deskripsi'], 'aktif' => (bool) Pengaturan::ambil($key, true)];
        }

        $keamanan = [];
        foreach (self::KEAMANAN_KEY as $key => $meta) {
            $keamanan[] = ['key' => $key, 'label' => $meta['label'], 'deskripsi' => $meta['deskripsi'], 'aktif' => (bool) Pengaturan::ambil($key, false)];
        }

        $timeout = (string) Pengaturan::ambil('session_timeout', '1 jam');
        if (! array_key_exists($timeout, self::TIMEOUT)) {
            $timeout = '1 jam';
        }

        return [
            'bobot' => $bobot,
            'notif' => $notif,
            'keamanan' => $keamanan,
            'nama_sistem' => (string) Pengaturan::ambil('nama_sistem', 'Magang Komdigi Sumut'),
            'email_admin' => (string) Pengaturan::ambil('email_admin', 'admin@magangyuk.test'),
            'min_skor' => (int) Pengaturan::ambil('min_skor', 75),
            'min_kehadiran' => (int) Pengaturan::ambil('min_kehadiran', 80),
            'maks_peserta_per_pembimbing' => (int) Pengaturan::ambil('maks_peserta_per_pembimbing', 8),
            'session_timeout' => $timeout,
        ];
    }

    /* ================================================================== */
    /* HELPER: PENYIMPAN CMS (return ['baru' => bool, 'judul' => string])  */
    /* ================================================================== */

    /** Ambil baris CMS lama (bila id valid) atau model baru yang belum disimpan. */
    private function cariAtauBaru(string $jenis, mixed $id, string $judul): CmsKonten
    {
        $id = (int) trim((string) $id);
        $konten = $id > 0 ? CmsKonten::where('jenis', $jenis)->find($id) : null;

        return $konten ?? new CmsKonten([
            'jenis' => $jenis,
            'judul' => $judul,
            'user_id' => auth()->id(),
            'published_at' => now(),
        ]);
    }

    private function slugUnik(string $jenis, string $judul, ?int $kecualikanId = null): string
    {
        $dasar = Str::slug($judul) ?: Str::slug($jenis) ?: 'konten';
        $slug = $dasar;
        $i = 2;

        while (CmsKonten::where('slug', $slug)
            ->when($kecualikanId !== null, fn ($q) => $q->where('id', '!=', $kecualikanId))
            ->exists()
        ) {
            $slug = $dasar . '-' . $i++;
        }

        return $slug;
    }

    private function simpanHero(Request $request): array
    {
        $hero = CmsKonten::where('jenis', 'hero')->orderBy('id')->first()
            ?? new CmsKonten(['jenis' => 'hero', 'urutan' => 0]);
        $baru = ! $hero->exists;

        $judul = trim((string) $request->input('judul'));
        $payload = [
            'judul' => $judul,
            'subjudul' => (string) $request->input('subjudul', ''),
            'tombol1' => (string) $request->input('tombol1', ''),
            'link1' => (string) $request->input('link1', '#'),
            'tombol2' => (string) $request->input('tombol2', ''),
            'link2' => (string) $request->input('link2', '#'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'status_periode' => (string) $request->input('status_periode', ''),
        ];

        $hero->fill([
            'judul' => $judul,
            'slug' => $this->slugUnik('hero', $judul, $hero->id),
            'payload' => $payload,
            'status' => 'aktif',
            'user_id' => $hero->user_id ?? auth()->id(),
            'published_at' => $hero->published_at ?? now(),
        ]);

        if ($request->hasFile('gambar')) {
            $this->hapusBerkas($hero->gambar_path);
            $hero->gambar_path = $this->simpanBerkas($request->file('gambar'), 'cms/hero');
        }

        $hero->save();

        return ['baru' => $baru, 'judul' => $judul];
    }

    private function simpanKegiatan(Request $request): array
    {
        $judul = trim((string) $request->input('judul'));
        $konten = $this->cariAtauBaru('kegiatan', $request->input('id'), $judul);
        $baru = ! $konten->exists;

        $deskripsi = $this->teksBersih($request->input('deskripsi'));
        $pin = $request->boolean('pin');

        $konten->fill([
            'judul' => $judul,
            'slug' => $this->slugUnik('kegiatan', $judul, $konten->id),
            'isi' => $deskripsi,
            'kategori' => (string) $request->input('kategori', 'Semua'),
            'status' => $request->input('status') === 'publish' ? 'aktif' : 'nonaktif',
            'urutan' => $pin ? 0 : (int) ($konten->urutan ?: 1),
            'published_at' => $request->input('tanggal') ?: ($konten->published_at ?? now()),
            'user_id' => $konten->user_id ?? auth()->id(),
            'payload' => [
                'deskripsi' => $deskripsi,
                'tanggal' => $request->input('tanggal'),
                'pin' => $pin,
                'status_form' => (string) $request->input('status'),
            ],
        ]);

        if ($request->hasFile('cover')) {
            $this->hapusBerkas($konten->gambar_path);
            $konten->gambar_path = $this->simpanBerkas($request->file('cover'), 'cms/kegiatan');
        }

        $konten->save();

        return ['baru' => $baru, 'judul' => $judul];
    }

    /** Setiap foto yang diunggah jadi satu baris galeri. */
    private function simpanDokumentasi(Request $request): array
    {
        $judul = trim((string) $request->input('judul')) ?: 'Dokumentasi';
        $kategori = (string) $request->input('kategori', 'Umum');
        $tanggal = $request->input('tanggal');

        $jumlah = 0;
        foreach ((array) $request->file('foto', []) as $foto) {
            if ($foto === null) {
                continue;
            }

            CmsKonten::create([
                'jenis' => 'dokumentasi',
                'judul' => $judul,
                'slug' => $this->slugUnik('dokumentasi', $judul),
                'kategori' => $kategori,
                'status' => 'aktif',
                'gambar_path' => $this->simpanBerkas($foto, 'cms/dokumentasi'),
                'published_at' => $tanggal ?: now(),
                'user_id' => auth()->id(),
                'payload' => ['tanggal' => $tanggal, 'nama_file' => $foto->hashName()],
            ]);

            $jumlah++;
        }

        return ['baru' => true, 'judul' => $jumlah > 1 ? "{$judul} ({$jumlah} foto)" : $judul];
    }

    private function simpanAnggota(Request $request): array
    {
        $nama = trim((string) $request->input('nama'));
        $konten = $this->cariAtauBaru('anggota', $request->input('id'), $nama);
        $baru = ! $konten->exists;

        $lama = $konten->payload ?? [];
        $posisi = Str::lower(trim((string) $request->input('posisi', 'peserta')));
        $bio = $this->teksBersih($request->input('bio'));

        $konten->fill([
            'judul' => $nama,
            'slug' => $this->slugUnik('anggota', $nama, $konten->id),
            'isi' => $bio,
            'kategori' => $posisi,
            'status' => (string) $request->input('status', 'aktif'),
            'urutan' => (int) $request->input('urutan', $konten->urutan ?: 1),
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $konten->published_at ?? now(),
            'payload' => [
                'posisi' => $posisi,
                'institusi' => (string) $request->input('institusi', ''),
                'bio' => $bio,
                'instagram' => (string) $request->input('instagram', ''),
                'linkedin' => (string) $request->input('linkedin', ''),
                'username' => $lama['username'] ?? '@' . Str::slug($nama, ''),
                'initial' => $lama['initial'] ?? Str::upper(Str::substr($nama, 0, 2)),
                'gradient' => $lama['gradient'] ?? $this->gradientUntuk($konten->urutan ?: 0, 'aktif'),
            ],
        ]);

        if ($request->hasFile('foto')) {
            $this->hapusBerkas($konten->gambar_path);
            $konten->gambar_path = $this->simpanBerkas($request->file('foto'), 'cms/anggota');
        }

        $konten->save();

        return ['baru' => $baru, 'judul' => $nama];
    }

    /**
     * HTML dari rich editor WAJIB disanitasi di server — konten ini
     * ditampilkan apa adanya di halaman publik (celah stored-XSS).
     */
    private function simpanHalaman(Request $request): array
    {
        $judul = trim((string) $request->input('judul'));
        $konten = $this->cariAtauBaru('halaman', $request->input('id'), $judul);
        $baru = ! $konten->exists;

        $isi = Sanitizer::html((string) $request->input('konten', ''));
        $slugInput = trim((string) $request->input('slug', ''));

        $konten->fill([
            'judul' => $judul,
            'slug' => $this->slugUnik('halaman', $slugInput !== '' ? $slugInput : $judul, $konten->id),
            'isi' => $isi,
            'status' => $request->input('status') === 'publish' ? 'publish' : 'draft',
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $konten->published_at ?? now(),
            'payload' => [
                'deskripsi' => Str::limit(Sanitizer::teks($isi), 160),
                'seo_title' => (string) $request->input('seo_title', ''),
                'seo_description' => (string) $request->input('seo_description', ''),
            ],
        ]);

        if ($request->hasFile('gambar')) {
            $this->hapusBerkas($konten->gambar_path);
            $konten->gambar_path = $this->simpanBerkas($request->file('gambar'), 'cms/halaman');
        }

        $konten->save();

        return ['baru' => $baru, 'judul' => $judul];
    }

    private function simpanPengumuman(Request $request): array
    {
        $judul = trim((string) $request->input('judul'));
        $konten = $this->cariAtauBaru('pengumuman', $request->input('id'), $judul);
        $baru = ! $konten->exists;

        $deskripsi = $this->teksBersih($request->input('deskripsi'));
        $posisi = (string) $request->input('posisi', 'Popup');

        $konten->fill([
            'judul' => $judul,
            'slug' => $this->slugUnik('pengumuman', $judul, $konten->id),
            'isi' => $deskripsi,
            'kategori' => $posisi,
            'status' => (string) $request->input('status', 'aktif'),
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $request->input('tanggal_mulai') ?: ($konten->published_at ?? now()),
            'payload' => [
                'posisi' => $posisi,
                'target' => (string) $request->input('target', 'Semua'),
                'link' => (string) $request->input('link', ''),
                'deskripsi' => $deskripsi,
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
            ],
        ]);

        $konten->save();

        return ['baru' => $baru, 'judul' => $judul];
    }

    private function simpanMenu(Request $request): array
    {
        $label = trim((string) $request->input('label'));
        $konten = $this->cariAtauBaru('menu', $request->input('id'), $label);
        $baru = ! $konten->exists;

        $tipe = (string) (($konten->payload['tipe'] ?? null) ?: ($konten->kategori ?: 'Default'));

        $konten->fill([
            'judul' => $label,
            'slug' => $this->slugUnik('menu', $label, $konten->id),
            'kategori' => $tipe,
            'status' => (string) $request->input('status', 'aktif'),
            'urutan' => (int) $request->input('urutan', $konten->urutan ?: 0),
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $konten->published_at ?? now(),
            'payload' => ['url' => (string) $request->input('url', '#'), 'tipe' => $tipe],
        ]);

        $konten->save();

        return ['baru' => $baru, 'judul' => $label];
    }

    private function simpanDokumen(Request $request): array
    {
        $nama = trim((string) $request->input('nama'));
        $konten = $this->cariAtauBaru('dokumen', $request->input('id'), $nama);
        $baru = ! $konten->exists;

        $lama = $konten->payload ?? [];
        $payload = [
            'kategori' => (string) $request->input('kategori', 'Umum'),
            'akses' => (string) $request->input('akses', 'Login saja'),
            'file' => $lama['file'] ?? null,
            'tipe' => $lama['tipe'] ?? null,
            'ukuran' => $lama['ukuran'] ?? null,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $this->hapusBerkas($konten->file_path);
            $konten->file_path = $this->simpanBerkas($file, 'cms/dokumen');
            $payload['file'] = $file->getClientOriginalName();
            $payload['tipe'] = $this->tipeDokumen($file->getClientOriginalName());
            $payload['ukuran'] = $this->ukuranBerkas($file);
        }

        $konten->fill([
            'judul' => $nama,
            'slug' => $this->slugUnik('dokumen', $nama, $konten->id),
            'kategori' => $payload['kategori'],
            'status' => 'aktif',
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $konten->published_at ?? now(),
            'payload' => $payload,
        ]);

        $konten->save();

        return ['baru' => $baru, 'judul' => $nama];
    }

    private function simpanFaq(Request $request): array
    {
        $pertanyaan = trim((string) $request->input('pertanyaan'));
        $konten = $this->cariAtauBaru('faq', $request->input('id'), $pertanyaan);
        $baru = ! $konten->exists;

        $jawaban = $this->teksBersih($request->input('jawaban'));

        $konten->fill([
            'judul' => $pertanyaan,
            'slug' => $this->slugUnik('faq', $pertanyaan, $konten->id),
            'isi' => $jawaban,
            'kategori' => (string) $request->input('kategori', 'Umum'),
            'status' => 'aktif',
            'urutan' => (int) $request->input('urutan', $konten->urutan ?: 0),
            'user_id' => $konten->user_id ?? auth()->id(),
            'published_at' => $konten->published_at ?? now(),
            'payload' => ['jawaban' => $jawaban],
        ]);

        $konten->save();

        return ['baru' => $baru, 'judul' => $pertanyaan];
    }

    /* ================================================================== */
    /* HELPER: BERKAS                                                      */
    /* ================================================================== */

    private function simpanBerkas($file, string $dir): string
    {
        return $file->store($dir, 'public');
    }

    private function urlBerkas(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : Storage::url($path);
    }

    private function hapusBerkas(?string $path): void
    {
        if ($path === null || $path === '' || str_starts_with($path, 'http')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    private function tipeDokumen(?string $path): string
    {
        $ext = Str::upper((string) pathinfo((string) $path, PATHINFO_EXTENSION));

        return match (true) {
            $ext === 'PDF' => 'PDF',
            in_array($ext, ['DOC', 'DOCX', 'ODT', 'RTF'], true) => 'DOC',
            in_array($ext, ['XLS', 'XLSX', 'CSV', 'ODS'], true) => 'XLS',
            in_array($ext, ['PPT', 'PPTX', 'ODP'], true) => 'PPT',
            default => 'LAIN',
        };
    }

    private function ukuranBerkas($file): string
    {
        $byte = (int) $file->getSize();

        return match (true) {
            $byte >= 1048576 => number_format($byte / 1048576, 1) . ' MB',
            $byte >= 1024 => number_format($byte / 1024, 0) . ' KB',
            default => $byte . ' B',
        };
    }

    /* ================================================================== */
    /* HELPER: IMPOR PESERTA                                               */
    /* ================================================================== */

    private function bacaCsv(string $path): array
    {
        $handle = @fopen($path, 'r');
        if ($handle === false) {
            return [];
        }

        $baris = [];
        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            if (! is_array($data) || $data === [null]) {
                continue;
            }
            $baris[] = array_map(fn ($v) => is_string($v) ? trim($v) : '', $data);
        }
        fclose($handle);

        if ($baris !== [] && isset($baris[0][0])) {
            // Buang BOM UTF-8 agar header pertama dikenali.
            $baris[0][0] = preg_replace('/^\xEF\xBB\xBF/', '', $baris[0][0]);
        }

        return $baris;
    }

    /**
     * Pembaca XLSX minimal (ZipArchive + SimpleXML) — cukup untuk berkas
     * ekspor Excel biasa tanpa perlu library eksternal.
     */
    private function bacaXlsx(string $path): array
    {
        $zip = new ZipArchive;
        if ($zip->open($path) !== true) {
            return [];
        }

        $shared = [];
        $stringXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($stringXml !== false) {
            $xml = @simplexml_load_string($stringXml, SimpleXMLElement::class, LIBXML_NOCDATA | LIBXML_NONET);
            if ($xml !== false) {
                foreach ($xml->si as $si) {
                    $shared[] = trim(strip_tags((string) $si->asXML()));
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            return [];
        }

        $xml = @simplexml_load_string($sheetXml, SimpleXMLElement::class, LIBXML_NOCDATA | LIBXML_NONET);
        if ($xml === false || ! isset($xml->sheetData)) {
            return [];
        }

        $baris = [];
        foreach ($xml->sheetData->row as $row) {
            $sel = [];
            $kolomTerakhir = -1;

            foreach ($row->c as $c) {
                $indeks = $this->indeksKolom((string) ($c['r'] ?? ''));
                for ($k = $kolomTerakhir + 1; $k < $indeks; $k++) {
                    $sel[$k] = '';
                }
                $kolomTerakhir = $indeks;

                $tipe = (string) ($c['t'] ?? '');
                $nilai = (string) ($c->v ?? '');

                if ($tipe === 's') {
                    $nilai = $shared[(int) $nilai] ?? '';
                } elseif ($tipe === 'inlineStr' && isset($c->is)) {
                    $nilai = trim(strip_tags((string) $c->is->asXML()));
                }

                $sel[$indeks] = trim($nilai);
            }

            $baris[] = $sel;
        }

        return $baris;
    }

    /** "C3" -> 2 (indeks kolom basis 0). */
    private function indeksKolom(string $ref): int
    {
        $huruf = Str::upper((string) preg_replace('/\d+/', '', $ref));
        if ($huruf === '') {
            return 0;
        }

        $indeks = 0;
        foreach (str_split($huruf) as $h) {
            $indeks = $indeks * 26 + (ord($h) - 64);
        }

        return max(0, $indeks - 1);
    }

    /** Petakan header berkas ke nama field internal (mendukung alias umum). */
    private function petakanKepala(array $headerRow): array
    {
        $alias = [
            'nama' => ['nama', 'nama lengkap', 'nama_lengkap', 'name', 'full name'],
            'nim' => ['nim', 'nis', 'nis/nim', 'nomor induk', 'student id'],
            'email' => ['email', 'e-mail', 'surel', 'mail'],
            'hp' => ['hp', 'no hp', 'no. hp', 'no_hp', 'telepon', 'phone', 'ponsel', 'kontak'],
            'institusi' => ['institusi', 'kampus', 'universitas', 'asal institusi', 'asal kampus', 'institution'],
            'prodi' => ['prodi', 'jurusan', 'program studi', 'study program'],
            'pembimbing' => ['pembimbing', 'mentor', 'supervisor'],
            'periode' => ['periode', 'periode magang', 'batch'],
            'status' => ['status'],
            'nik' => ['nik', 'no ktp', 'ktp'],
            'tempat_lahir' => ['tempat lahir', 'tempat_lahir', 'kota lahir'],
            'tanggal_lahir' => ['tanggal lahir', 'tanggal_lahir', 'tgl lahir', 'birth date'],
            'jenis_kelamin' => ['jenis kelamin', 'jenis_kelamin', 'jk', 'gender'],
            'alamat' => ['alamat', 'address'],
        ];

        $peta = [];
        foreach ($headerRow as $kolom => $judul) {
            $kunci = trim((string) preg_replace('/\s+/', ' ', Str::lower(trim((string) preg_replace('/[^A-Za-z0-9 _\/.]/', ' ', (string) $judul)))));

            foreach ($alias as $field => $daftar) {
                if (! isset($peta[$field]) && in_array($kunci, $daftar, true)) {
                    $peta[$field] = $kolom;
                    break;
                }
            }
        }

        return $peta;
    }

    /** Ubah teks/serial tanggal Excel jadi Y-m-d (kolom NOT NULL). */
    private function tanggalImpor(string $nilai): string
    {
        $nilai = trim($nilai);
        if ($nilai === '') {
            return '2000-01-01';
        }

        if (ctype_digit($nilai)) {
            // Serial tanggal Excel (basis 1899-12-30).
            return Carbon::createFromTimestamp(((int) $nilai - 25569) * 86400, 'UTC')->format('Y-m-d');
        }

        try {
            return Carbon::parse($nilai)->format('Y-m-d');
        } catch (\Throwable) {
            return '2000-01-01';
        }
    }

    /**
     * Simpan satu baris impor. Mengembalikan true bila berhasil; kegagalan
     * (validasi/unik/FK) dicatat ke $gagal dan tidak menghentikan baris lain.
     */
    private function simpanHasilImpor(string $nama, string $email, callable $ambil, array &$gagal, int $nomor): bool
    {
        try {
            $institusi = $this->cariInstitusi($ambil('institusi')) ?? Institusi::orderBy('id')->first();
            $periode = Periode::where('kode', $ambil('periode'))->first() ?? $this->periodeAktif();
            $pembimbing = $this->cariPembimbing($ambil('pembimbing'));

            if ($institusi === null || $periode === null) {
                $gagal[] = "baris {$nomor} (institusi/periode belum tersedia)";

                return false;
            }

            $status = Str::lower($ambil('status'));
            $status = in_array($status, User::STATUSES, true) ? $status : 'aktif';

            $jk = Str::upper(Str::substr($ambil('jenis_kelamin'), 0, 1));
            $jk = in_array($jk, ['L', 'P'], true) ? $jk : 'L';

            $user = User::where('email', $email)->first();

            DB::transaction(function () use (&$user, $nama, $email, $ambil, $institusi, $periode, $pembimbing, $status, $jk) {
                if ($user === null) {
                    $user = User::create([
                        'nama_lengkap' => $nama,
                        'email' => $email,
                        'role' => User::ROLE_PESERTA,
                        'status' => $status,
                        'password' => self::PASSWORD_AWAL,
                    ]);
                }

                $hp = $this->normalisasiHp($ambil('hp'));
                if ($hp === '' || DataDiri::where('no_hp', $hp)->where('user_id', '!=', $user->id)->exists()) {
                    $hp = '0811' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT);
                }

                DataDiri::updateOrCreate(['user_id' => $user->id], [
                    'nik' => $this->normalisasiNik($ambil('nik'), $user->id),
                    'nama_lengkap' => $nama,
                    'tempat_lahir' => $ambil('tempat_lahir') ?: '-',
                    'tanggal_lahir' => $this->tanggalImpor($ambil('tanggal_lahir')),
                    'alamat' => $ambil('alamat') ?: '-',
                    'jenis_kelamin' => $jk,
                    'email' => $email,
                    'no_hp' => $hp,
                ]);

                $magang = DataMagang::firstOrNew(['user_id' => $user->id]);
                $magang->fill([
                    'id_kode' => $magang->id_kode ?: $this->kodePesertaBaru(),
                    'nis_nim' => $ambil('nim') ?: '-',
                    'institusi' => $institusi->nama,
                    'institusi_id' => $institusi->id,
                    'prodi' => $ambil('prodi') ?: '-',
                    'penempatan' => $magang->penempatan ?: 'Dinas Kominfo Sumut',
                    'bidang' => $magang->bidang ?: 'Teknologi Informasi',
                    'periode' => $periode->nama,
                    'periode_id' => $periode->id,
                    'status' => $status,
                    'pembimbing_id' => $pembimbing?->id ?? $magang->pembimbing_id,
                ]);
                $magang->save();

                Sertifikat::firstOrCreate(['user_id' => $user->id], [
                    'nomor' => null, 'progress' => 0, 'status' => 'proses',
                ]);
            });

            return true;
        } catch (\Throwable $e) {
            $gagal[] = "baris {$nomor} (" . Str::limit($e->getMessage(), 60) . ')';

            return false;
        }
    }

    /* ================================================================== */
    /* HELPER: EKSPOR CSV                                                  */
    /* ================================================================== */

    private function unduhCsv(string $namaFile, array $baris): StreamedResponse
    {
        return response()->streamDownload(function () use ($baris) {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF"); // BOM UTF-8 agar Excel tidak merusak aksen.

            foreach ($baris as $b) {
                fputcsv($handle, array_map(
                    fn ($v) => is_scalar($v) || $v === null ? $v : json_encode($v, JSON_UNESCAPED_UNICODE),
                    $b,
                ));
            }

            fclose($handle);
        }, $namaFile, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

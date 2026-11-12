<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\ActivityLog;
use App\Models\DataDiri;
use App\Models\DataMagang;
use App\Models\Izin;
use App\Models\KriteriaPenilaian;
use App\Models\Laporan;
use App\Models\Logbook;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Pengaturan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Controller halaman role PEMBIMBING.
 *
 * Seluruh data dibaca dari database dan dibatasi pada peserta yang benar-benar
 * dibimbing oleh pembimbing yang sedang login (data_magang.pembimbing_id).
 * View hanya merender; semua kelas Tailwind dipetakan dari konstanta statis.
 */
class PembimbingPageController extends Controller
{
    /* ======================================================================
       KONSTANTA TAMPILAN (kelas Tailwind statis — dilarang dirakit dinamis)
       ====================================================================== */

    private const AVATAR = [
        'bg-gradient-to-br from-indigo-500 to-purple-500',
        'bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean',
        'bg-gradient-to-br from-emerald-500 to-teal-400',
        'bg-gradient-to-br from-sky-500 to-blue-500',
        'bg-gradient-to-br from-pink-500 to-rose-400',
        'bg-gradient-to-br from-amber-500 to-orange-400',
        'bg-gradient-to-br from-rose-500 to-orange-400',
        'bg-gradient-to-br from-slate-500 to-slate-600',
    ];

    private const BAR = [
        'bg-gradient-to-r from-indigo-500 to-purple-400',
        'bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean',
        'bg-gradient-to-r from-emerald-500 to-teal-400',
        'bg-gradient-to-r from-sky-500 to-blue-400',
        'bg-gradient-to-r from-pink-500 to-rose-400',
        'bg-gradient-to-r from-amber-500 to-orange-400',
        'bg-gradient-to-r from-rose-500 to-orange-400',
        'bg-gradient-to-r from-slate-500 to-slate-400',
    ];

    private const BAR_KRITERIA = [
        'bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean',
        'bg-gradient-to-r from-komdigi-blue to-sky-400',
        'bg-gradient-to-r from-blue-500 to-indigo-400',
        'bg-gradient-to-r from-komdigi-cerulean to-blue-300',
        'bg-gradient-to-r from-emerald-500 to-teal-400',
    ];

    private const BADGE_ABSENSI = [
        'hadir' => 'bg-emerald-100 text-emerald-700',
        'terlambat' => 'bg-amber-100 text-amber-700',
        'menunggu' => 'bg-amber-100 text-amber-700',
        'izin' => 'bg-sky-100 text-sky-400',
        'sakit' => 'bg-sky-100 text-sky-400',
        'cuti' => 'bg-sky-100 text-sky-400',
        'alpha' => 'bg-rose-100 text-rose-700',
    ];

    private const LABEL_ABSENSI = [
        'hadir' => 'Hadir',
        'terlambat' => 'Terlambat',
        'menunggu' => 'Belum absen',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'cuti' => 'Cuti',
        'alpha' => 'Alpha',
    ];

    private const LABEL_AKSI = [
        'login' => 'Masuk ke sistem',
        'logout' => 'Keluar dari sistem',
        'penilaian' => 'Memberikan penilaian',
        'logbook' => 'Meninjau logbook',
        'laporan' => 'Meninjau laporan',
        'izin' => 'Meninjau pengajuan izin',
        'profil' => 'Memperbarui profil',
        'keamanan' => 'Mengubah password',
    ];

    private const DOT_AKSI = [
        'login' => 'bg-emerald-400',
        'logout' => 'bg-slate-400',
        'penilaian' => 'bg-komdigi-cerulean',
        'logbook' => 'bg-amber-400',
        'laporan' => 'bg-sky-400',
        'izin' => 'bg-indigo-400',
        'profil' => 'bg-komdigi-cerulean',
        'keamanan' => 'bg-rose-400',
    ];

    /** Nilai slider default (0–100) saat kriteria belum pernah dinilai. */
    private const NILAI_DEFAULT = 80;

    /** Maksimal minggu yang ditampilkan pada chart. */
    private const MAKS_MINGGU_CHART = 8;

    private ?array $mentorCache = null;

    private ?array $pesertaCache = null;

    /* ======================================================================
       HALAMAN (GET)
       ====================================================================== */

    public function dashboard()
    {
        $peserta = $this->daftarPeserta();
        $pending = $this->logbookMenunggu();
        $ringkasan = $this->ringkasan($peserta);
        $tren = $this->trenSkor(array_column($peserta, 'id'));

        $jumlahTitik = count($tren['data']);
        $delta = $jumlahTitik >= 2
            ? $tren['data'][$jumlahTitik - 1] - $tren['data'][$jumlahTitik - 2]
            : 0;

        return view('dashboard.pembimbing', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($peserta),
            'ringkasan' => $ringkasan,
            'deltaSkor' => ($delta >= 0 ? '+' : '−') . number_format(abs($delta), 1, ',', '.') . ' dari minggu lalu',
            'perluPerhatian' => array_values(array_filter($peserta, fn (array $p) => $p['status'] === 'perhatian')),
            'pesertaSorot' => array_slice($peserta, 0, 4),
            'logbookPending' => array_slice($pending, 0, 3),
            'chartPerforma' => $this->chartLine($tren['labels'], $tren['data']),
        ]);
    }

    public function peserta()
    {
        $peserta = $this->daftarPeserta();

        return view('fitur_pembimbing.peserta', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($peserta),
            'peserta' => $peserta,
            'ringkasan' => $this->ringkasan($peserta),
        ]);
    }

    /**
     * Detail satu peserta bimbingan. Parameter opsional: tanpa id, peserta
     * pertama dipakai. Peserta di luar bimbingan otomatis 404.
     */
    public function detailPeserta(?User $peserta = null)
    {
        $daftar = $this->daftarPeserta();
        abort_if($daftar === [], 404, 'Belum ada peserta yang ditugaskan kepada Anda.');

        // Tanpa parameter: pakai peserta pertama. Dengan parameter: wajib milik
        // pembimbing yang login, selain itu 404 (bukan diam-diam pindah peserta).
        $kartu = $peserta
            ? collect($daftar)->firstWhere('id', $peserta->id)
            : $daftar[0];
        abort_if($kartu === null, 404, 'Peserta tidak ditemukan dalam bimbingan Anda.');

        $user = User::with(['dataDiri', 'dataMagang.periodeRel', 'dataMagang.institusiRel'])
            ->findOrFail($kartu['id']);
        $periode = $user->dataMagang?->periodeRel;
        $kehadiran = $this->ringkasanKehadiran($user, $periode);

        $penilaian = Penilaian::where('peserta_id', $user->id)->get();
        $rataDetail = PenilaianDetail::whereIn('penilaian_id', $penilaian->pluck('id'))->avg('nilai');
        $logbookPending = Logbook::where('user_id', $user->id)->menunggu()->count();

        return view('fitur_pembimbing.detailpeserta', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($daftar),
            'peserta' => $kartu,
            'statistik' => [
                [
                    'label' => 'Skor Kinerja',
                    'nilai' => (string) $kartu['skor'],
                    'warna' => $kartu['skor_color'],
                    'keterangan' => $kartu['skor'] > 0 ? Penilaian::gradeDariSkor((float) $kartu['skor']) : 'Belum dinilai',
                ],
                [
                    'label' => 'Kehadiran',
                    'nilai' => $kartu['kehadiran'] . '%',
                    'warna' => 'text-white',
                    'keterangan' => $kehadiran['hadir'] . ' Hadir • ' . $kehadiran['terlambat'] . ' Terlambat',
                ],
                [
                    'label' => 'Logbook',
                    'nilai' => $kartu['logbook_terisi'] . '/' . $kartu['logbook_total'],
                    'warna' => 'text-sky-400',
                    'keterangan' => $logbookPending > 0
                        ? $logbookPending . ' menunggu approval'
                        : 'Semua sudah direview',
                ],
                [
                    'label' => 'Penilaian',
                    'nilai' => $rataDetail ? number_format((float) $rataDetail, 1) : '—',
                    'warna' => 'text-amber-400',
                    'keterangan' => 'Rata-rata dari ' . $penilaian->count() . ' penilaian',
                ],
            ],
            'chartSkor' => (function () use ($user, $periode) {
                $mingguan = $this->skorMingguan($user);

                return $this->chartLine($mingguan['labels'], $mingguan['data'], 'Skor');
            })(),
            'chartKehadiran' => (function () use ($user, $periode) {
                $mingguan = $this->kehadiranMingguan($user, $periode);

                return $this->chartBar($mingguan['labels'], $mingguan['data']);
            })(),
            'absensi' => $this->tabelAbsensi($user),
            'logbookPeserta' => $this->logbookPeserta($user, $periode),
            'riwayatPenilaian' => $this->riwayatPenilaianDetail($user),
            'laporanPeserta' => $this->laporanPeserta($user),
            'izinPeserta' => $this->izinPeserta($user),
        ]);
    }

    public function penilaianPeserta(Request $request)
    {
        $daftar = $this->daftarPeserta();
        abort_if($daftar === [], 404, 'Belum ada peserta yang ditugaskan kepada Anda.');

        $idDiminta = (int) $request->query('peserta', 0) ?: (int) old('peserta_id', 0);
        // Id diminta tapi bukan bimbingan kita → 404, jangan diam-diam pindah peserta.
        $kartu = $idDiminta ? collect($daftar)->firstWhere('id', $idDiminta) : $daftar[0];
        abort_if($kartu === null, 404, 'Peserta tidak ditemukan dalam bimbingan Anda.');

        $user = User::with('dataMagang.periodeRel')->findOrFail($kartu['id']);
        $periode = $user->dataMagang?->periodeRel;
        $opsiPeriode = $this->opsiPeriode($periode);
        $keyDefault = $opsiPeriode['mingguan'][0]['value'] ?? 'w1';

        return view('fitur_pembimbing.penilaianpeserta', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($daftar),
            'pesertaTerpilih' => $kartu,
            'opsiPeserta' => $daftar,
            'kriteria' => $this->kriteriaForm($kartu['id'], $keyDefault),
            'opsiPeriode' => $opsiPeriode,
            'riwayat' => $this->riwayatPenilaian($kartu['id'], $periode),
        ]);
    }

    public function logbook()
    {
        $entries = $this->logbookMenunggu();

        $minggu = [];
        foreach ($entries as $entry) {
            $minggu[$entry['minggu_key']] = $entry['minggu_label'];
        }
        // Urutkan dari minggu terbaru.
        krsort($minggu);

        return view('fitur_pembimbing.logbook', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($this->daftarPeserta()),
            'logbook' => $entries,
            'jumlahPending' => count($entries),
            'opsiPeserta' => collect($entries)
                ->map(fn (array $e) => ['key' => $e['peserta_key'], 'nama' => $e['peserta_nama']])
                ->unique('key')
                ->values()
                ->all(),
            'opsiMinggu' => collect($minggu)
                ->map(fn (string $label, string $key) => ['value' => $key, 'label' => $label])
                ->values()
                ->all(),
        ]);
    }

    public function laporanBimbingan()
    {
        $peserta = $this->daftarPeserta();
        $ringkasan = $this->ringkasan($peserta);
        $tren = $this->trenSkor(array_column($peserta, 'id'));

        return view('fitur_pembimbing.laporanbimbingan', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($peserta),
            'peserta' => $peserta,
            'ringkasan' => $ringkasan,
            'chartDistribusi' => $this->chartDoughnut($ringkasan['distribusi']),
            'chartTren' => $this->chartLine($tren['labels'], $tren['data'], 'Rata-rata Skor', '#38bdf8', 'rgba(56, 189, 248, 0.12)'),
            'evaluasi' => $this->evaluasi($peserta, $ringkasan),
        ]);
    }

    public function profile()
    {
        $peserta = $this->daftarPeserta();
        $ringkasan = $this->ringkasan($peserta);

        return view('fitur_pembimbing.profile', [
            'mentor' => $this->mentor(),
            'jumlahPeserta' => count($peserta),
            'statistik' => [
                ['nilai' => (string) $ringkasan['total'], 'warna' => 'text-white', 'label' => 'Peserta Bimbingan'],
                ['nilai' => $ringkasan['rata_skor'], 'warna' => 'text-emerald-400', 'label' => 'Rata-rata Skor'],
                ['nilai' => (string) $ringkasan['penilaian_diberikan'], 'warna' => 'text-komdigi-cerulean', 'label' => 'Penilaian Diberikan'],
                ['nilai' => (string) $ringkasan['logbook_pending'], 'warna' => 'text-amber-400', 'label' => 'Logbook Pending'],
            ],
            'aktivitas' => ActivityLog::where('user_id', $this->user()->id)
                ->terbaru()
                ->take(6)
                ->get()
                ->map(fn (ActivityLog $log) => [
                    'aksi' => self::LABEL_AKSI[$log->aksi] ?? ucfirst((string) $log->aksi),
                    'detail' => trim(($log->deskripsi ?: self::LABEL_AKSI[$log->aksi] ?? '') . ' • '
                        . ($log->created_at?->translatedFormat('j M Y, H.i') ?? '')),
                    'dot' => self::DOT_AKSI[$log->aksi] ?? 'bg-slate-400',
                ])
                ->all(),
        ]);
    }

    /* ======================================================================
       AKSI FORM (POST)
       ====================================================================== */

    public function simpanPenilaian(Request $request)
    {
        $validated = $request->validate([
            'peserta_id' => ['required', 'integer'],
            'jenis_periode' => ['required', 'in:mingguan,bulanan'],
            'periode' => ['required', 'string', 'max:100'],
            'kriteria' => ['required', 'array'],
            'kriteria.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'total_skor' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'komentar' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'komentar.required' => 'Mohon isi komentar keseluruhan sebelum menyimpan.',
            'komentar.min' => 'Komentar keseluruhan minimal 5 karakter.',
            'kriteria.required' => 'Mohon isi nilai untuk setiap kriteria penilaian.',
        ]);

        $ids = $this->bimbingan()->pluck('user_id')->all();
        abort_unless(in_array((int) $validated['peserta_id'], $ids, true), 403, 'Peserta bukan bimbingan Anda.');

        $peserta = User::with('dataMagang.periodeRel')->findOrFail((int) $validated['peserta_id']);
        $periode = $peserta->dataMagang?->periodeRel;
        $jenis = $validated['jenis_periode'];
        $key = $validated['periode'];

        $opsi = $this->opsiPeriode($periode)[$jenis] ?? [];
        $opsiDipilih = collect($opsi)->firstWhere('value', $key);
        abort_if(! $opsiDipilih, 422, 'Periode penilaian tidak dikenali.');

        $kriteriaAktif = KriteriaPenilaian::aktif()->pluck('id')->all();
        $nilai = [];
        foreach ($validated['kriteria'] as $idKriteria => $skalaSeratus) {
            $id = (int) $idKriteria;
            if (! in_array($id, $kriteriaAktif, true)) {
                continue;
            }
            // Slider memakai skala 0–100, penyimpanan memakai skala 0–5.
            $nilai[$id] = round(max(0, min(100, (float) $skalaSeratus)) / 20, 1);
        }
        abort_if($nilai === [], 422, 'Kriteria penilaian tidak dikenali.');

        $penilaian = Penilaian::firstOrNew([
            'peserta_id' => $peserta->id,
            'jenis' => $jenis,
            'periode_key' => $key,
        ]);
        $baru = ! $penilaian->exists;

        $penilaian->pembimbing_id = $this->user()->id;
        $penilaian->periode_label = $this->labelPeriodePenilaian($jenis, $key, $opsiDipilih['label'], $periode);
        $penilaian->komentar = $validated['komentar'];
        $penilaian->tanggal = $this->tanggalPenilaian($key, $periode);
        $penilaian->status = 'final';
        if ($baru) {
            $penilaian->di_override_admin = false;
        }
        $penilaian->save();

        foreach ($nilai as $idKriteria => $skalaLima) {
            PenilaianDetail::updateOrCreate(
                ['penilaian_id' => $penilaian->id, 'kriteria_penilaian_id' => $idKriteria],
                ['nilai' => $skalaLima],
            );
        }
        // Buang detail kriteria yang sudah dinonaktifkan admin.
        $penilaian->detail()->whereNotIn('kriteria_penilaian_id', array_keys($nilai))->delete();

        $total = Penilaian::hitungSkorBerbobot($nilai);
        $penilaian->update([
            'total_skor' => $total,
            'grade' => Penilaian::gradeDariSkor($total),
        ]);

        $pesan = ($baru ? 'Penilaian' : 'Penilaian terbaru') . ' untuk ' . $peserta->nama_lengkap
            . ' (' . $opsiDipilih['label'] . ') tersimpan dengan skor '
            . number_format($total, 1, ',', '.') . ' — ' . $penilaian->grade . '.';

        ActivityLog::catat('penilaian', $pesan, $this->user());

        return redirect()
            ->route('pembimbing.penilaianpeserta', ['peserta' => $peserta->id])
            ->with('success', $pesan);
    }

    public function reviewLogbook(Request $request)
    {
        $validated = $request->validate([
            'logbook_id' => ['required', 'integer'],
            'keputusan' => ['required', 'in:approve,reject'],
            'komentar' => ['nullable', 'string', 'max:2000', 'required_if:keputusan,reject'],
        ], [
            'komentar.required_if' => 'Komentar wajib diisi jika menolak logbook.',
            'keputusan.in' => 'Keputusan tidak valid.',
        ]);

        $logbook = Logbook::with('user.dataMagang')->findOrFail((int) $validated['logbook_id']);
        $this->pastikanBimbingan($logbook->user?->dataMagang);

        $setuju = $validated['keputusan'] === 'approve';
        $logbook->update([
            'status' => $setuju ? Logbook::STATUS_DISETUJUI : Logbook::STATUS_DITOLAK,
            'reviewed_by' => $this->user()->id,
            'catatan_review' => $validated['komentar'] ?? ($setuju ? 'Logbook disetujui.' : null),
        ]);

        $nama = $logbook->user?->nama_lengkap ?? 'Peserta';
        $pesan = 'Logbook minggu ke-' . $logbook->minggu_ke . ' milik ' . $nama
            . ($setuju ? ' berhasil disetujui.' : ' ditolak. Peserta akan diberi notifikasi.');

        ActivityLog::catat('logbook', $pesan, $this->user());

        return redirect()->route('pembimbing.logbook')->with('success', $pesan);
    }

    public function reviewLaporan(Request $request)
    {
        $validated = $request->validate([
            'laporan_id' => ['required', 'integer'],
            'keputusan' => ['required', 'in:approve,reject'],
            'komentar' => ['nullable', 'string', 'max:2000', 'required_if:keputusan,reject'],
        ], [
            'komentar.required_if' => 'Catatan wajib diisi jika menolak laporan.',
        ]);

        $laporan = Laporan::with('user.dataMagang')->findOrFail((int) $validated['laporan_id']);
        $this->pastikanBimbingan($laporan->user?->dataMagang);

        $setuju = $validated['keputusan'] === 'approve';
        $laporan->update([
            'status' => $setuju ? 'disetujui' : 'ditolak',
            'reviewed_by' => $this->user()->id,
            'catatan' => $validated['komentar'] ?? ($setuju ? 'Laporan disetujui.' : null),
            'reviewed_at' => now(),
        ]);

        $nama = $laporan->user?->nama_lengkap ?? 'Peserta';
        $jenis = $laporan->tipe === Laporan::TIPE_AKHIR ? 'laporan akhir' : 'laporan minggu ke-' . $laporan->minggu_ke;
        $pesan = ucfirst($jenis) . ' milik ' . $nama . ($setuju ? ' disetujui.' : ' ditandai perlu revisi.');

        ActivityLog::catat('laporan', $pesan, $this->user());

        return back()->with('success', $pesan);
    }

    public function reviewIzin(Request $request)
    {
        $validated = $request->validate([
            'izin_id' => ['required', 'integer'],
            'keputusan' => ['required', 'in:approve,reject'],
            'catatan_review' => ['nullable', 'string', 'max:1000', 'required_if:keputusan,reject'],
        ], [
            'catatan_review.required_if' => 'Catatan wajib diisi jika menolak pengajuan.',
        ]);

        $izin = Izin::with('user.dataMagang')->findOrFail((int) $validated['izin_id']);
        $this->pastikanBimbingan($izin->user?->dataMagang);

        $setuju = $validated['keputusan'] === 'approve';
        $izin->update([
            'status' => $setuju ? 'disetujui' : 'ditolak',
            'reviewed_by' => $this->user()->id,
            'catatan_review' => $validated['catatan_review'] ?? ($setuju ? 'Pengajuan disetujui.' : null),
            'reviewed_at' => now(),
        ]);

        $nama = $izin->user?->nama_lengkap ?? 'Peserta';
        $pesan = 'Pengajuan ' . $izin->jenis_label . ' milik ' . $nama
            . ' (' . $izin->rentang . ')' . ($setuju ? ' disetujui.' : ' ditolak.');

        ActivityLog::catat('izin', $pesan, $this->user());

        return back()->with('success', $pesan);
    }

    public function simpanProfil(Request $request)
    {
        $user = $this->user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nip' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'telepon' => ['required', 'string', 'max:30'],
            'jabatan' => ['required', 'string', 'max:100'],
            'unit_kerja' => ['required', 'string', 'max:100'],
            'instansi' => ['required', 'string', 'max:150'],
        ], [
            'email.unique' => 'Email tersebut sudah dipakai akun lain.',
        ], [
            'unit_kerja' => 'unit kerja',
        ]);

        $user->update([
            'nama_lengkap' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        $diri = DataDiri::firstOrNew(['user_id' => $user->id]);
        if (! $diri->exists) {
            $diri->nik = '1272' . str_pad((string) $user->id, 12, '0', STR_PAD_LEFT);
        }
        $diri->fill([
            'nama_lengkap' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'no_hp' => $validated['telepon'],
            'jabatan' => $validated['jabatan'],
            'unit_kerja' => $validated['unit_kerja'],
            'instansi' => $validated['instansi'],
        ])->save();

        $this->mentorCache = null;
        ActivityLog::catat('profil', 'Memperbarui data profil pembimbing.', $user);

        return redirect()->route('pembimbing.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed', 'different:password_lama'],
        ], [
            'password_lama.required' => 'Mohon isi password saat ini.',
            'password_baru.required' => 'Mohon isi password baru.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_baru.different' => 'Password baru tidak boleh sama dengan password lama.',
        ]);

        $user = $this->user();

        if (! Hash::check($request->input('password_lama'), $user->password)) {
            return back()->withErrors(['password_lama' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        // Kolom password memakai cast "hashed", jadi cukup isi nilai mentahnya.
        $user->update(['password' => $request->input('password_baru')]);

        ActivityLog::catat('keamanan', 'Mengubah password akun.', $user);

        return redirect()->route('pembimbing.profile')->with('success', 'Password berhasil diubah!');
    }

    /* ======================================================================
       IDENTITAS PEMBIMBING & DAFTAR PESERTA BIMBINGAN
       ====================================================================== */

    private function user(): User
    {
        return auth()->user();
    }

    /** Semua data_magang yang menunjuk pembimbing yang sedang login. */
    private function bimbingan()
    {
        return DataMagang::with(['user', 'institusiRel', 'periodeRel'])
            ->where('pembimbing_id', $this->user()->id)
            ->whereHas('user')
            ->orderBy('id')
            ->get()
            ->values();
    }

    /** Kartu tampilan pembimbing (dipakai header, sidebar, dan halaman profil). */
    private function mentor(): array
    {
        if ($this->mentorCache !== null) {
            return $this->mentorCache;
        }

        $user = $this->user();
        $user->loadMissing('dataDiri');
        $diri = $user->dataDiri;
        $nama = (string) $user->nama_lengkap;
        $instansi = (string) ($diri->instansi ?: 'Dinas Komunikasi dan Informatika');
        $singkat = $this->instansiSingkat($instansi);

        return $this->mentorCache = [
            'nama' => $nama,
            'nama_gelar' => $nama,
            'nama_pendek' => trim(Str::before($nama, ',')),
            'inisial' => $user->inisial,
            'nip' => $diri->nip ?: '—',
            'id_pembimbing' => 'PB-' . ($user->created_at?->year ?? now()->year)
                . '-' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
            'email' => $user->email,
            'telepon' => $diri->no_hp ?: '—',
            'jabatan' => $diri->jabatan ?: '—',
            'unit_kerja' => $diri->unit_kerja ?: '—',
            'instansi' => $instansi,
            'instansi_singkat' => $singkat,
            'unit_penempatan' => $singkat,
            'role' => 'Pembimbing',
            'bergabung' => $user->created_at?->translatedFormat('j F Y') ?? '—',
            'periode_aktif' => $this->periodeAktif()?->nama ?? 'Belum ada periode aktif',
            'status_akun' => ucfirst((string) $user->status),
        ];
    }

    private function instansiSingkat(string $instansi): string
    {
        $singkat = str_replace(
            ['Komunikasi dan Informatika', 'Kabupaten', 'Republik Indonesia'],
            ['Kominfo', 'Kab.', 'RI'],
            $instansi,
        );

        return Str::limit($singkat, 60, '');
    }

    private function periodeAktif(): ?Periode
    {
        return Periode::query()->aktif()->orderByDesc('tanggal_mulai')->first()
            ?? Periode::query()->orderByDesc('tanggal_mulai')->first();
    }

    /** Daftar peserta bimbingan dalam bentuk array siap-render (di-cache per request). */
    private function daftarPeserta(): array
    {
        return $this->pesertaCache ??= $this->participants();
    }

    private function participants(): array
    {
        $bimbingan = $this->bimbingan();
        if ($bimbingan->isEmpty()) {
            return [];
        }

        $minSkor = (float) Pengaturan::ambil('min_skor', 75);
        $minKehadiran = (int) Pengaturan::ambil('min_kehadiran', 80);

        $kartu = [];
        foreach ($bimbingan->values() as $urut => $magang) {
            $kartu[] = $this->kartuPeserta($magang, (int) $urut, $minSkor, $minKehadiran);
        }

        return $kartu;
    }

    private function kartuPeserta(DataMagang $magang, int $urut, float $minSkor, int $minKehadiran): array
    {
        $user = $magang->user;
        $periode = $magang->periodeRel;
        $totalMinggu = max(1, (int) ($periode?->total_minggu ?? 1));

        $kehadiranRingkas = $this->ringkasanKehadiran($user, $periode);
        $kehadiran = $this->persenKehadiran($kehadiranRingkas, $this->totalHariKerja($periode));

        $skor = (int) round((float) (Penilaian::where('peserta_id', $user->id)
            ->terbaru()
            ->value('total_skor') ?? 0));
        $jumlahPenilaian = Penilaian::where('peserta_id', $user->id)->count();

        $logbookTerisi = Logbook::where('user_id', $user->id)->count();
        $logbookKosong = max(0, $totalMinggu - $logbookTerisi);

        $senin = Carbon::today()->startOfWeek();
        $terlambatMingguIni = Absensi::where('user_id', $user->id)
            ->where('status', 'terlambat')
            ->whereBetween('tanggal', [$senin->toDateString(), Carbon::today()->toDateString()])
            ->count();

        $status = match (true) {
            $magang->status === 'selesai', $user->status === 'selesai' => 'selesai',
            $magang->status === 'nonaktif', $user->status === 'nonaktif' => 'perhatian',
            $skor > 0 && $skor < $minSkor => 'perhatian',
            $kehadiran < $minKehadiran => 'perhatian',
            default => 'aktif',
        };

        [$catatan, $catatanBadge] = $this->catatanPeserta(
            $status, $kehadiran, $minKehadiran, $logbookKosong, $terlambatMingguIni, $skor, $minSkor,
        );

        $logbookPersen = (int) min(100, round($logbookTerisi / $totalMinggu * 100));

        return [
            'id' => $user->id,
            'nama' => $user->nama_lengkap,
            'inisial' => $user->inisial,
            'id_peserta' => $magang->id_kode ?: 'MKD-' . $user->id,
            'institusi' => $magang->institusi_label ?: '—',
            'skor' => $skor,
            'kehadiran' => $kehadiran,
            'logbook_terisi' => $logbookTerisi,
            'logbook_total' => $totalMinggu,
            'logbook_kosong' => $logbookKosong,
            'jumlah_penilaian' => $jumlahPenilaian,
            'status' => $status,
            'avatar' => self::AVATAR[$urut % count(self::AVATAR)],
            'bar' => self::BAR[$urut % count(self::BAR)],
            'catatan' => $catatan,
            'catatan_badge' => $catatanBadge,
            'unit_kerja' => $magang->penempatan ?: '—',
            'periode' => $periode?->rentang ?: ($magang->periode_label ?: '—'),
            'periode_key' => $this->periodeKey($periode),
            'logbook_persen' => $logbookPersen,
            'skor_color' => $skor >= 80 ? 'text-emerald-400' : ($skor >= 75 ? 'text-sky-400' : 'text-amber-400'),
            'hadir_color' => $kehadiran >= 80 ? 'text-white' : ($kehadiran >= 70 ? 'text-amber-400' : 'text-rose-400'),
            'logbook_color' => $logbookPersen < 50 ? 'text-rose-400' : 'text-slate-300',
            'card_border' => $status === 'perhatian' ? 'border-rose-500/30' : 'border-white/8',
            'gaya' => $this->statusGaya($status),
        ];
    }

    /**
     * @return array{0: string|null, 1: string|null}
     */
    private function catatanPeserta(
        string $status,
        int $kehadiran,
        int $minKehadiran,
        int $logbookKosong,
        int $terlambatMingguIni,
        int $skor,
        float $minSkor,
    ): array {
        if ($status !== 'perhatian') {
            return [null, null];
        }

        if ($kehadiran < $minKehadiran) {
            return ['Kehadiran ' . $kehadiran . '%', 'bg-rose-100 text-rose-700'];
        }
        if ($logbookKosong >= 3) {
            return [$logbookKosong . ' Logbook kosong', 'bg-rose-100 text-rose-700'];
        }
        if ($terlambatMingguIni > 0) {
            return [$terlambatMingguIni . 'x Terlambat minggu ini', 'bg-amber-100 text-amber-700'];
        }
        if ($skor > 0 && $skor < $minSkor) {
            return ['Skor di bawah ' . (int) $minSkor, 'bg-amber-100 text-amber-700'];
        }

        return ['Perlu pendampingan', 'bg-amber-100 text-amber-700'];
    }

    private function statusGaya(string $status): array
    {
        return match ($status) {
            'perhatian' => [
                'label' => 'Perhatian',
                'label_panjang' => 'Perlu Perhatian',
                'badge' => 'bg-amber-100 text-amber-700',
                'dot' => 'bg-amber-500',
                'badge_soft' => 'bg-amber-500/15 text-amber-400',
                'dot_soft' => 'bg-amber-400',
                'border_soft' => 'border-amber-500/30',
            ],
            'selesai' => [
                'label' => 'Selesai',
                'label_panjang' => 'Selesai',
                'badge' => 'bg-slate-100 text-slate-400',
                'dot' => 'bg-slate-400',
                'badge_soft' => 'bg-slate-500/20 text-slate-400',
                'dot_soft' => 'bg-slate-400',
                'border_soft' => 'border-slate-500/30',
            ],
            default => [
                'label' => 'Aktif',
                'label_panjang' => 'Aktif',
                'badge' => 'bg-emerald-100 text-emerald-700',
                'dot' => 'bg-emerald-500',
                'badge_soft' => 'bg-emerald-500/15 text-emerald-400',
                'dot_soft' => 'bg-emerald-400',
                'border_soft' => 'border-emerald-500/30',
            ],
        };
    }

    private function periodeKey(?Periode $periode): string
    {
        if (! $periode?->kode) {
            return 'all';
        }

        // "okt-des-2026" → "okt-des" (dipakai filter JS pada tabel peserta).
        return preg_replace('/-\d{4}$/', '', (string) $periode->kode) ?: 'all';
    }

    private function ringkasan(array $peserta): array
    {
        $total = count($peserta);
        $ids = array_column($peserta, 'id');
        $skor = array_column($peserta, 'skor');
        $skorTerisi = array_values(array_filter($skor, fn (int $s) => $s > 0));

        $distribusi = [
            count(array_filter($skor, fn (int $s) => $s >= 90)),
            count(array_filter($skor, fn (int $s) => $s >= 80 && $s < 90)),
            count(array_filter($skor, fn (int $s) => $s >= 70 && $s < 80)),
            count(array_filter($skor, fn (int $s) => $s < 70)),
        ];

        return [
            'total' => $total,
            'aktif' => count(array_filter($peserta, fn (array $p) => $p['status'] === 'aktif')),
            'perhatian' => count(array_filter($peserta, fn (array $p) => $p['status'] === 'perhatian')),
            'selesai' => count(array_filter($peserta, fn (array $p) => $p['status'] === 'selesai')),
            'rata_skor' => number_format($skorTerisi ? array_sum($skorTerisi) / count($skorTerisi) : 0, 1, ',', '.'),
            'rata_kehadiran' => (int) round($total ? array_sum(array_column($peserta, 'kehadiran')) / $total : 0),
            'penilaian_diberikan' => array_sum(array_column($peserta, 'jumlah_penilaian')),
            'logbook_pending' => $ids === [] ? 0 : Logbook::whereIn('user_id', $ids)->menunggu()->count(),
            'distribusi' => $distribusi,
        ];
    }

    /**
     * Pastikan data magang yang disentuh benar-benar dibimbing user login.
     */
    private function pastikanBimbingan(?DataMagang $magang): void
    {
        abort_unless(
            $magang !== null && (int) $magang->pembimbing_id === (int) $this->user()->id,
            403,
            'Data bukan milik peserta bimbingan Anda.',
        );
    }

    /* ======================================================================
       DATA PENDUKUNG HALAMAN
       ====================================================================== */

    /** Logbook berstatus menunggu milik seluruh peserta bimbingan (terbaru dulu). */
    private function logbookMenunggu(): array
    {
        $peserta = $this->daftarPeserta();
        $ids = array_column($peserta, 'id');
        if ($ids === []) {
            return [];
        }

        $avatar = array_column($peserta, 'avatar', 'id');

        return Logbook::with(['user.dataMagang.periodeRel'])
            ->whereIn('user_id', $ids)
            ->menunggu()
            ->orderByDesc('submitted_at')
            ->orderByDesc('minggu_ke')
            ->orderByDesc('id')
            ->get()
            ->map(function (Logbook $lb) use ($avatar) {
                $user = $lb->user;
                $magang = $user?->dataMagang;
                $periode = $magang?->periodeRel;
                $minggu = (int) $lb->minggu_ke;

                return [
                    'id' => $lb->id,
                    'peserta_key' => Str::slug((string) $user?->nama_lengkap, '-'),
                    'peserta_nama' => (string) $user?->nama_lengkap,
                    'peserta_inisial' => (string) $user?->inisial,
                    'peserta_id' => $magang?->id_kode ?: '—',
                    'avatar' => $avatar[$user?->id] ?? self::AVATAR[0],
                    'minggu_label' => 'Minggu ke-' . $minggu,
                    'minggu_key' => 'minggu' . $minggu,
                    'rentang' => $periode?->rentangMinggu($minggu) ?: (string) $lb->rentang,
                    'rentang_panjang' => $this->rentangPanjang($periode, $minggu, $lb->rentang),
                    'dikirim' => ($lb->submitted_at ?? $lb->updated_at)?->translatedFormat('j M Y, H.i') ?? '—',
                    'uraian' => (string) $lb->uraian,
                    'kegiatan' => $lb->kegiatan_list,
                    'hasil' => (string) $lb->hasil,
                    'kendala' => (string) $lb->kendala,
                    'rencana' => $lb->rencana_list,
                    'status' => (string) $lb->status,
                ];
            })
            ->all();
    }

    private function rentangPanjang(?Periode $periode, int $minggu, ?string $fallback): string
    {
        $mulai = $periode?->mulaiMinggu($minggu);
        $selesai = $periode?->selesaiMinggu($minggu);

        if (! $mulai || ! $selesai) {
            return (string) $fallback;
        }

        return $mulai->translatedFormat('j F Y') . ' – ' . $selesai->translatedFormat('j F Y');
    }

    /**
     * Opsi periode penilaian: minggu yang sudah berjalan + bulan yang sudah lewat.
     *
     * @return array{mingguan: array<int, array{value:string,label:string}>, bulanan: array<int, array{value:string,label:string}>}
     */
    private function opsiPeriode(?Periode $periode): array
    {
        $mingguan = [];
        $bulanan = [];

        if (! $periode?->tanggal_mulai) {
            return ['mingguan' => $mingguan, 'bulanan' => $bulanan];
        }

        $total = max(1, (int) $periode->total_minggu);
        $aktif = $periode->mingguAktif();

        for ($m = min($total, $aktif); $m >= 1; $m--) {
            $mingguan[] = [
                'value' => 'w' . $m,
                'label' => 'Minggu ke-' . $m . ' (' . $periode->rentangMinggu($m) . ')',
            ];
        }

        $batas = $periode->tanggal_selesai && $periode->tanggal_selesai->lessThan(Carbon::today())
            ? $periode->tanggal_selesai->copy()
            : Carbon::today();
        $bulan = $periode->tanggal_mulai->copy()->startOfMonth();

        while ($bulan->lessThanOrEqualTo($batas->copy()->startOfMonth())) {
            $bulanan[] = ['value' => 'b' . $bulan->format('Y-m'), 'label' => $bulan->translatedFormat('F Y')];
            $bulan->addMonth();
        }

        return ['mingguan' => $mingguan, 'bulanan' => array_reverse($bulanan)];
    }

    /**
     * Kriteria penilaian untuk form slider (skala 0–100 di layar, 0–5 di database).
     *
     * @return array<int, array{key:int,label:string,bobot:int,weight:float,nilai:int,deskripsi:string}>
     */
    private function kriteriaForm(int $pesertaId, string $periodeKey): array
    {
        $kriteria = KriteriaPenilaian::aktif()->terurut()->get();
        $totalBobot = max(1, (int) $kriteria->sum('bobot'));

        $tersimpan = PenilaianDetail::whereHas('penilaian', function ($q) use ($pesertaId, $periodeKey) {
            $q->where('peserta_id', $pesertaId)->where('periode_key', $periodeKey);
        })->pluck('nilai', 'kriteria_penilaian_id');

        return $kriteria->map(function (KriteriaPenilaian $k) use ($totalBobot, $tersimpan) {
            $nilai = isset($tersimpan[$k->id])
                ? (int) round(((float) $tersimpan[$k->id]) * 20)
                : self::NILAI_DEFAULT;

            return [
                'key' => (int) $k->id,
                'label' => $k->nama,
                'bobot' => (int) round($k->bobot / $totalBobot * 100),
                'weight' => round($k->bobot / $totalBobot, 4),
                'nilai' => (int) max(0, min(100, $nilai)),
                'deskripsi' => $k->deskripsi ?: 'Geser slider sesuai pengamatan Anda selama periode ini.',
            ];
        })->all();
    }

    /** Riwayat penilaian untuk panel kanan halaman Penilaian Peserta. */
    private function riwayatPenilaian(int $pesertaId, ?Periode $periode): array
    {
        return Penilaian::where('peserta_id', $pesertaId)
            ->terbaru()
            ->take(8)
            ->get()
            ->map(function (Penilaian $p) use ($periode) {
                [$label, $rentang] = $this->labelPeriode($p, $periode);
                $skor = (int) round((float) $p->total_skor);

                return [
                    'periode' => $label,
                    'rentang' => $rentang,
                    'skor' => $skor,
                    'grade' => $p->grade ?: Penilaian::gradeDariSkor((float) $skor),
                    'warna' => $skor >= 80 ? 'text-komdigi-cerulean' : ($skor >= 70 ? 'text-amber-400' : 'text-rose-400'),
                    'grade_color' => $skor >= 80 ? 'text-emerald-400' : ($skor >= 70 ? 'text-amber-400' : 'text-rose-400'),
                    'komentar' => (string) $p->komentar,
                ];
            })
            ->all();
    }

    /** Riwayat penilaian lengkap (dengan rincian kriteria) untuk tab Detail Peserta. */
    private function riwayatPenilaianDetail(User $user): array
    {
        return Penilaian::with('detail.kriteria')
            ->where('peserta_id', $user->id)
            ->terbaru()
            ->take(3)
            ->get()
            ->map(fn (Penilaian $p) => [
                'judul' => $p->jenis === 'akhir' ? 'Penilaian Akhir' : ($p->periode_label ?: 'Penilaian'),
                'tanggal' => $p->tanggal?->translatedFormat('j F Y') ?? '—',
                'skor' => $p->nilai_rata_rata,
                'kriteria' => $p->detail->values()->map(fn (PenilaianDetail $d, int $i) => [
                    'nama' => $d->kriteria?->nama ?? 'Kriteria',
                    'nilai' => number_format((float) $d->nilai, 1),
                    'persen' => (int) round((float) $d->nilai / 5 * 100),
                    'bar' => self::BAR_KRITERIA[$i % count(self::BAR_KRITERIA)],
                ])->all(),
                'komentar' => (string) $p->komentar,
            ])
            ->all();
    }

    /**
     * Pecah periode_key menjadi label + rentang untuk tampilan.
     *
     * @return array{0: string, 1: string}
     */
    private function labelPeriode(Penilaian $p, ?Periode $periode): array
    {
        $key = (string) $p->periode_key;

        if (preg_match('/^w(\d+)$/', $key, $m)) {
            $minggu = (int) $m[1];

            return [
                'Minggu ke-' . $minggu,
                $periode?->rentangMinggu($minggu) ?: ($p->tanggal?->translatedFormat('j M Y') ?? ''),
            ];
        }

        if (preg_match('/^b(\d{4})-(\d{2})$/', $key, $m)) {
            $bulan = Carbon::create((int) $m[1], (int) $m[2], 1);

            return [
                $bulan->translatedFormat('F Y'),
                $bulan->copy()->startOfMonth()->translatedFormat('j M')
                    . ' – ' . $bulan->copy()->endOfMonth()->translatedFormat('j M Y'),
            ];
        }

        return ['Penilaian Akhir', $p->tanggal?->translatedFormat('j M Y') ?? ''];
    }

    private function labelPeriodePenilaian(string $jenis, string $key, string $labelOpsi, ?Periode $periode): string
    {
        if ($jenis === 'bulanan') {
            return $labelOpsi;
        }

        if (preg_match('/^w(\d+)$/', $key, $m)) {
            $rentang = $periode?->rentangMinggu((int) $m[1]);

            return 'Minggu ke-' . $m[1] . ($rentang ? ' (' . $rentang . ')' : '');
        }

        return $labelOpsi;
    }

    private function tanggalPenilaian(string $key, ?Periode $periode): Carbon
    {
        $tanggal = null;

        if (preg_match('/^w(\d+)$/', $key, $m)) {
            $tanggal = $periode?->selesaiMinggu((int) $m[1]);
        } elseif (preg_match('/^b(\d{4})-(\d{2})$/', $key, $m)) {
            $tanggal = Carbon::create((int) $m[1], (int) $m[2], 1)->endOfMonth();
        }

        return $this->earliest($tanggal, Carbon::today());
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

    /** Skor mingguan satu peserta (ascending) untuk chart garis. */
    private function skorMingguan(User $user): array
    {
        $rows = Penilaian::where('peserta_id', $user->id)
            ->where('jenis', 'mingguan')
            ->get()
            ->mapWithKeys(function (Penilaian $p) {
                $minggu = (int) preg_replace('/\D/', '', (string) $p->periode_key);

                return $minggu > 0 ? [$minggu => (int) round((float) $p->total_skor)] : [];
            });

        $mingguTerakhir = (int) $rows->keys()->max();
        $rows = $rows->sortKeys()->reverse()->take(self::MAKS_MINGGU_CHART)->reverse()->sortKeys();

        $labels = [];
        $data = [];
        foreach ($rows as $minggu => $skor) {
            $labels[] = 'Minggu ' . $minggu;
            $data[] = $skor;
        }

        return ['labels' => $labels, 'data' => $data, 'minggu_terakhir' => $mingguTerakhir];
    }

    /** Persentase kehadiran per minggu untuk chart batang. */
    private function kehadiranMingguan(User $user, ?Periode $periode): array
    {
        $total = max(1, (int) ($periode?->total_minggu ?? 1));
        $aktif = $periode ? $periode->mingguAktif() : $total;
        $akhir = min($total, $aktif);
        $awal = max(1, $akhir - self::MAKS_MINGGU_CHART + 1);

        $labels = [];
        $data = [];

        for ($m = $awal; $m <= $akhir; $m++) {
            $mulai = $periode?->mulaiMinggu($m);
            $selesai = $periode?->selesaiMinggu($m);
            if (! $mulai || ! $selesai) {
                continue;
            }

            $batas = $this->earliest($selesai->copy(), Carbon::today());
            $hariKerja = $this->hitungHariKerja($mulai->copy(), $batas);
            if ($hariKerja <= 0) {
                continue;
            }

            $masuk = Absensi::where('user_id', $user->id)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->whereBetween('tanggal', [$mulai->toDateString(), $selesai->toDateString()])
                ->count();

            $labels[] = 'Minggu ' . $m;
            $data[] = (int) min(100, round($masuk / $hariKerja * 100));
        }

        return ['labels' => $labels, 'data' => $data];
    }

    /** Rata-rata skor mingguan seluruh peserta bimbingan. */
    private function trenSkor(array $ids): array
    {
        if ($ids === []) {
            return ['labels' => [], 'data' => []];
        }

        $grup = [];
        Penilaian::whereIn('peserta_id', $ids)
            ->where('jenis', 'mingguan')
            ->get(['periode_key', 'total_skor'])
            ->each(function (Penilaian $p) use (&$grup) {
                $minggu = (int) preg_replace('/\D/', '', (string) $p->periode_key);
                if ($minggu > 0) {
                    $grup[$minggu][] = (float) $p->total_skor;
                }
            });

        ksort($grup);
        $grup = array_slice($grup, -self::MAKS_MINGGU_CHART, null, true);

        $labels = [];
        $data = [];
        foreach ($grup as $minggu => $nilai) {
            $labels[] = 'Minggu ' . $minggu;
            $data[] = (int) round(array_sum($nilai) / count($nilai));
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function tabelAbsensi(User $user): array
    {
        return Absensi::where('user_id', $user->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->take(14)
            ->get()
            ->map(fn (Absensi $a) => [
                'tanggal' => $a->tanggal?->translatedFormat('D, j M Y') ?? '—',
                'masuk' => $a->jam_masuk ? $this->jamTitik($a->jam_masuk) : '—',
                'pulang' => $a->jam_pulang ? $this->jamTitik($a->jam_pulang) : '—',
                'durasi' => $a->durasi ?? '—',
                'status' => (string) $a->status,
                'label' => self::LABEL_ABSENSI[$a->status] ?? ucfirst((string) $a->status),
                'badge' => self::BADGE_ABSENSI[$a->status] ?? 'bg-slate-100 text-slate-400',
            ])
            ->all();
    }

    private function logbookPeserta(User $user, ?Periode $periode): array
    {
        return Logbook::where('user_id', $user->id)
            ->orderByDesc('minggu_ke')
            ->orderByDesc('id')
            ->get()
            ->map(function (Logbook $lb) use ($periode) {
                $minggu = (int) $lb->minggu_ke;

                return [
                    'minggu' => 'Minggu ke-' . $minggu,
                    'rentang' => $periode?->rentangMinggu($minggu) ?: (string) $lb->rentang,
                    'ringkasan' => Str::limit((string) $lb->uraian, 80),
                    'status' => (string) $lb->status,
                    'aksi' => $lb->status === Logbook::STATUS_MENUNGGU ? 'Review' : 'Lihat',
                ];
            })
            ->all();
    }

    /** Laporan (mingguan + akhir) milik satu peserta untuk ditinjau pembimbing. */
    private function laporanPeserta(User $user): array
    {
        $gaya = [
            'disetujui' => ['label' => 'Disetujui', 'badge' => 'bg-emerald-100 text-emerald-700'],
            'menunggu' => ['label' => 'Menunggu', 'badge' => 'bg-amber-100 text-amber-700'],
            'ditolak' => ['label' => 'Perlu Revisi', 'badge' => 'bg-rose-100 text-rose-700'],
            'draft' => ['label' => 'Draft', 'badge' => 'bg-slate-100 text-slate-400'],
        ];

        return Laporan::where('user_id', $user->id)
            ->orderByRaw("CASE WHEN tipe = 'akhir' THEN 0 ELSE 1 END")
            ->orderByDesc('minggu_ke')
            ->orderByDesc('id')
            ->get()
            ->map(function (Laporan $l) use ($gaya) {
                $status = (string) $l->status;

                return [
                    'id' => $l->id,
                    'judul' => $l->judul_label,
                    'tipe' => (string) $l->tipe,
                    'ringkasan' => Str::limit(strip_tags((string) $l->isi), 120),
                    'dikirim' => ($l->submitted_at ?? $l->created_at)?->translatedFormat('j M Y, H.i') ?? '—',
                    'status' => $status,
                    'label' => $gaya[$status]['label'] ?? ucfirst($status),
                    'badge' => $gaya[$status]['badge'] ?? 'bg-slate-100 text-slate-400',
                    'catatan' => (string) $l->catatan,
                    'boleh_review' => $status === 'menunggu' || $status === 'draft',
                ];
            })
            ->all();
    }

    /** Pengajuan izin milik satu peserta untuk ditinjau pembimbing. */
    private function izinPeserta(User $user): array
    {
        $gaya = [
            'disetujui' => ['label' => 'Disetujui', 'badge' => 'bg-emerald-100 text-emerald-700'],
            'menunggu' => ['label' => 'Menunggu', 'badge' => 'bg-amber-100 text-amber-700'],
            'ditolak' => ['label' => 'Ditolak', 'badge' => 'bg-rose-100 text-rose-700'],
        ];

        return Izin::where('user_id', $user->id)
            ->orderByDesc('tanggal_mulai')
            ->orderByDesc('id')
            ->get()
            ->map(function (Izin $i) use ($gaya) {
                $status = (string) $i->status;

                return [
                    'id' => $i->id,
                    'jenis' => $i->jenis_label,
                    'rentang' => $i->rentang,
                    'alasan' => Str::limit((string) $i->alasan, 100),
                    'bukti' => $i->bukti_path,
                    'bukti_url' => $i->bukti_path ? Storage::url($i->bukti_path) : null,
                    'status' => $status,
                    'label' => $gaya[$status]['label'] ?? ucfirst($status),
                    'badge' => $gaya[$status]['badge'] ?? 'bg-slate-100 text-slate-400',
                    'catatan' => (string) $i->catatan_review,
                    'boleh_review' => $status === 'menunggu',
                ];
            })
            ->all();
    }

    private function evaluasi(array $peserta, array $ringkasan): array
    {
        $perhatian = array_values(array_filter($peserta, fn (array $p) => $p['status'] === 'perhatian'));
        $namaPerhatian = implode(', ', array_map(fn (array $p) => $p['nama'], array_slice($perhatian, 0, 3)));
        $logbookKosong = array_sum(array_column($peserta, 'logbook_kosong'));
        $rataSkor = (float) str_replace(',', '.', $ringkasan['rata_skor']);

        $kekuatan = [
            $rataSkor >= 80
                ? 'Rata-rata skor kinerja ' . $ringkasan['rata_skor'] . ' (kategori Baik ke atas)'
                : ($rataSkor >= 70
                    ? 'Rata-rata skor kinerja ' . $ringkasan['rata_skor'] . ' (kategori Cukup Baik)'
                    : 'Rata-rata skor kinerja ' . $ringkasan['rata_skor'] . ' — masih perlu ditingkatkan'),
            'Tingkat kehadiran keseluruhan ' . $ringkasan['rata_kehadiran'] . '% dari total hari kerja',
            $ringkasan['aktif'] . ' dari ' . $ringkasan['total'] . ' peserta berstatus Aktif dengan performa stabil',
            $ringkasan['penilaian_diberikan'] . ' penilaian sudah diberikan selama periode berjalan',
        ];

        $perbaikan = [
            $perhatian === []
                ? 'Tidak ada peserta dengan status perlu perhatian'
                : count($perhatian) . ' peserta perlu perhatian' . ($namaPerhatian !== '' ? ': ' . $namaPerhatian : ''),
            $logbookKosong > 0
                ? 'Masih ada ' . $logbookKosong . ' logbook mingguan yang belum diisi peserta'
                : 'Seluruh logbook mingguan peserta sudah terisi',
            $ringkasan['logbook_pending'] . ' logbook menunggu persetujuan Anda',
        ];

        $rekomendasi = $perhatian === []
            ? 'Kinerja bimbingan berjalan baik dan merata. Pertahankan ritme penilaian mingguan serta persetujuan logbook tepat waktu agar progres peserta tetap terpantau hingga akhir periode magang.'
            : 'Secara umum bimbingan berjalan baik, namun ada peserta berstatus "Perlu Perhatian". Jadwalkan sesi mentoring tambahan, pantau kehadiran dan kelengkapan logbook mereka setiap minggu, dan berikan penilaian lebih sering agar perbaikan kinerja segera terlihat.';

        return [
            'kekuatan' => $kekuatan,
            'perbaikan' => $perbaikan,
            'rekomendasi' => $rekomendasi,
        ];
    }

    /* ======================================================================
       KEHADIRAN (logika sama dengan sisi peserta agar angka konsisten)
       ====================================================================== */

    /**
     * @return array<string, int>
     */
    private function ringkasanKehadiran(User $user, ?Periode $periode): array
    {
        $ringkas = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'cuti' => 0, 'alpha' => 0, 'menunggu' => 0];

        $query = Absensi::where('user_id', $user->id);

        if ($periode?->tanggal_mulai) {
            $batas = $periode->tanggal_selesai && $periode->tanggal_selesai->lessThan(Carbon::today())
                ? $periode->tanggal_selesai->copy()
                : Carbon::today();
            $query->whereBetween('tanggal', [$periode->tanggal_mulai->toDateString(), $batas->toDateString()]);
        }

        foreach ($query->pluck('status') as $status) {
            $ringkas[$status] = ($ringkas[$status] ?? 0) + 1;
        }

        return $ringkas;
    }

    private function persenKehadiran(array $ringkas, int $totalHariKerja): int
    {
        if ($totalHariKerja <= 0) {
            return 0;
        }

        // Terlambat tetap dihitung masuk.
        $masuk = ($ringkas['hadir'] ?? 0) + ($ringkas['terlambat'] ?? 0);

        return (int) min(100, round($masuk / $totalHariKerja * 100));
    }

    /** Hari kerja (Senin–Kamis) dari awal periode sampai hari ini/akhir periode. */
    private function totalHariKerja(?Periode $periode): int
    {
        if (! $periode?->tanggal_mulai) {
            return 0;
        }

        $batas = $periode->tanggal_selesai && $periode->tanggal_selesai->lessThan(Carbon::today())
            ? $periode->tanggal_selesai->copy()
            : Carbon::today();

        return $this->hitungHariKerja($periode->tanggal_mulai->copy(), $batas);
    }

    private function hitungHariKerja(Carbon $mulai, Carbon $selesai): int
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

    private function jamTitik(string $jam): string
    {
        return str_replace(':', '.', substr($jam, 0, 5));
    }

    /* ======================================================================
       KONFIGURASI CHART (dibaca JS via atribut data-chart pada canvas)
       ====================================================================== */

    private function chartLine(
        array $labels,
        array $data,
        string $label = 'Rata-rata Skor',
        string $border = '#0055FF',
        string $fill = 'rgba(0, 85, 255, 0.12)',
    ): array {
        $min = $data === [] ? 60 : max(0, (int) floor((min($data) - 10) / 10) * 10);

        return [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => $label,
                    'data' => $data,
                    'borderColor' => $border,
                    'backgroundColor' => $fill,
                    'borderWidth' => 3,
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => $border,
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2.5,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => false],
                    'tooltip' => [
                        'backgroundColor' => '#00336C',
                        'titleFont' => ['size' => 13, 'weight' => 'bold'],
                        'bodyFont' => ['size' => 12],
                        'padding' => 12,
                        'cornerRadius' => 10,
                        'displayColors' => false,
                    ],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => false,
                        'min' => $min,
                        'max' => 100,
                        'grid' => ['color' => 'rgba(0, 85, 255, 0.08)'],
                        'ticks' => ['color' => '#94a3b8', 'font' => ['size' => 11]],
                    ],
                    'x' => ['grid' => ['display' => false], 'ticks' => ['color' => '#94a3b8', 'font' => ['size' => 11]]],
                ],
            ],
        ];
    }

    private function chartBar(array $labels, array $data): array
    {
        return [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Kehadiran %',
                    'data' => $data,
                    'backgroundColor' => 'rgba(0, 147, 221, 0.5)',
                    'borderColor' => '#0093DD',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => false],
                    'tooltip' => ['backgroundColor' => '#00336C', 'cornerRadius' => 10, 'padding' => 12],
                ],
                'scales' => [
                    'y' => [
                        'min' => 0,
                        'max' => 100,
                        'grid' => ['color' => 'rgba(0, 85, 255, 0.08)'],
                        'ticks' => ['color' => '#94a3b8', 'font' => ['size' => 11]],
                    ],
                    'x' => ['grid' => ['display' => false], 'ticks' => ['color' => '#94a3b8', 'font' => ['size' => 11]]],
                ],
            ],
        ];
    }

    private function chartDoughnut(array $distribusi): array
    {
        return [
            'type' => 'doughnut',
            'data' => [
                'labels' => ['Sangat Baik (≥90)', 'Baik (80-89)', 'Cukup (70-79)', 'Perlu Perbaikan (<70)'],
                'datasets' => [[
                    'data' => $distribusi,
                    'backgroundColor' => ['#10b981', '#38bdf8', '#f59e0b', '#f43f5e'],
                    'borderWidth' => 0,
                    'hoverOffset' => 6,
                ]],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                        'labels' => ['color' => '#94a3b8', 'font' => ['size' => 11], 'padding' => 16],
                    ],
                ],
                'cutout' => '62%',
            ],
        ];
    }
}

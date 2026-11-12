<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\ActivityLog;
use App\Models\Izin;
use App\Models\Laporan;
use App\Models\Logbook;
use App\Models\Penilaian;
use App\Models\Pengaturan;
use App\Models\Periode;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Controller halaman peserta MagangYuk.
 *
 * Seluruh data dibaca dari database dan selalu dibatasi pada user yang sedang
 * login (tidak ada id peserta dari request). Aksi POST (absen, izin, laporan)
 * memvalidasi input lalu menyimpan ke tabel terkait.
 */
class PesertaPageController extends Controller
{
    /** Kelas Tailwind statis untuk bar progres aspek penilaian (dilarang merakit class dinamis). */
    private const BAR_GRADIENTS = [
        'from-komdigi-blue to-komdigi-cerulean',
        'from-komdigi-blue to-sky-400',
        'from-blue-500 to-indigo-400',
        'from-komdigi-cerulean to-blue-300',
        'from-emerald-500 to-teal-400',
    ];

    /** Peta nama bulan (Indonesia + Inggris) → nomor bulan. */
    private const NAMA_BULAN = [
        'januari' => 1, 'january' => 1,
        'februari' => 2, 'february' => 2,
        'maret' => 3, 'march' => 3,
        'april' => 4,
        'mei' => 5, 'may' => 5,
        'juni' => 6, 'june' => 6,
        'juli' => 7, 'july' => 7,
        'agustus' => 8, 'august' => 8,
        'september' => 9,
        'oktober' => 10, 'october' => 10,
        'november' => 11,
        'desember' => 12, 'december' => 12,
    ];

    /* ======================================================================
     * HALAMAN
     * ==================================================================== */

    public function dashboard()
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $kehadiran = $this->ringkasanKehadiran($user);
        $skorMingguan = $this->skorMingguan($user, $periode);
        $penilaian = $this->penilaianTerakhir($user);
        $totalHariKerja = $this->totalHariKerja($periode);
        $hadirPersen = $this->persenKehadiran($kehadiran, $totalHariKerja);

        $laporanMingguDisetujui = Laporan::where('user_id', $user->id)
            ->mingguan()->disetujui()->count();
        $laporanAkhir = Laporan::where('user_id', $user->id)
            ->where('tipe', Laporan::TIPE_AKHIR)->first();
        $logbookBelum = max(0, ($periode?->mingguAktif() ?? 1) - Logbook::where('user_id', $user->id)->count());
        $logbookMenunggu = Logbook::where('user_id', $user->id)->menunggu()->count();

        $skor = $penilaian ? (int) round($penilaian->total_skor) : 0;

        return view('dashboard.user', [
            'peserta' => $this->identitas($user),
            'kehadiran' => $kehadiran,
            'skor' => [
                'nilai' => $skor,
                'label' => $skor === 0 ? 'Belum ada' : Penilaian::gradeDariSkor($skor),
            ],
            'logbook' => [
                'belum_isi' => $logbookBelum,
                'menunggu' => $logbookMenunggu,
            ],
            'chartData' => $this->chartSkor($skorMingguan, 'light'),
            'absenHariIni' => $this->absenHariIni($user),
            'penilaian' => [
                'total' => $penilaian?->nilai_rata_rata ?? '—',
                'aspek' => $this->aspekPenilaian($penilaian),
                'komentar' => $penilaian?->komentar
                    ? '"' . $penilaian->komentar . '"'
                    : '"Belum ada komentar dari pembimbing."',
                'komentar_oleh' => $penilaian
                    ? trim(($penilaian->pembimbing?->nama_lengkap ?? 'Pembimbing') . ' • ' . $penilaian->tanggal_format)
                    : 'Menunggu penilaian pertama',
            ],
            'laporan' => [
                'status' => $this->statusLaporanAkhir($laporanAkhir),
                'batas' => $this->batasLaporan($periode),
                'checklist' => [
                    [
                        'label' => 'Laporan mingguan',
                        'detail' => '(' . $laporanMingguDisetujui . '/' . ($periode?->total_minggu ?? 8) . ')',
                        'done' => $laporanMingguDisetujui > 0,
                    ],
                    [
                        'label' => 'Draft laporan akhir',
                        'detail' => null,
                        'done' => (bool) $laporanAkhir && $laporanAkhir->status !== 'draft',
                    ],
                    [
                        'label' => 'Persetujuan pembimbing',
                        'detail' => null,
                        'done' => $laporanAkhir?->status === 'disetujui',
                    ],
                ],
            ],
            'sertifikat' => $this->dataSertifikat($user, $periode, $kehadiran, $hadirPersen, $laporanMingguDisetujui, $laporanAkhir),
            'areaAbsensi' => $this->areaAbsensi($user),
        ]);
    }

    public function absensi()
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $jamMasuk = (string) Pengaturan::ambil('jam_masuk', '08:00');
        $radius = (int) Pengaturan::ambil('radius_absensi', 2000);
        $hariKerja = (array) Pengaturan::ambil('hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis']);
        $hariIni = Carbon::today();
        $namaHari = $this->namaHari($hariIni->dayOfWeekIso);
        // Batas toleransi dalam format "H:i" agar bisa dibandingkan dengan jam sekarang.
        $batasMasuk = Carbon::createFromFormat('H:i', substr($jamMasuk, 0, 5))
            ->addMinutes(Absensi::TOLERANSI_MENIT)
            ->format('H:i');

        return view('fitur_peserta.absensi', [
            'peserta' => $this->identitas($user),
            'absenHariIni' => $this->absenHariIni($user),
            'areaAbsensi' => $this->areaAbsensi($user),
            'syarat' => [
                [
                    'judul' => 'Lokasi GPS aktif',
                    'detail' => 'Harus berada dalam radius ' . number_format($radius) . 'm',
                    'ok' => true,
                ],
                [
                    'judul' => 'Selfie wajah',
                    'detail' => 'Foto wajah jelas, tanpa masker',
                    'ok' => true,
                ],
                [
                    'judul' => 'Hari kerja aktif',
                    'detail' => implode(' – ', [$hariKerja[0] ?? 'Senin', end($hariKerja) ?: 'Kamis'])
                        . ' (hari ini ' . $namaHari . ')',
                    'ok' => in_array($namaHari, $hariKerja, true),
                ],
                [
                    'judul' => 'Jam masuk ideal',
                    'detail' => 'Sebelum ' . $this->jamTitik($batasMasuk) . ' (toleransi ' . Absensi::TOLERANSI_MENIT . ' menit)',
                    'ok' => now()->format('H:i') <= $batasMasuk,
                ],
            ],
            'riwayatMinggu' => $this->riwayatMinggu($user),
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = $this->user();

        $bulanOptions = Absensi::where('user_id', $user->id)
            ->orderByDesc('tanggal')
            ->get()
            ->groupBy(fn (Absensi $a) => $a->tanggal->translatedFormat('F Y'))
            ->keys()
            ->all();

        $bulanAktif = $request->query('bulan', $bulanOptions[0] ?? '');
        if (! in_array($bulanAktif, $bulanOptions, true)) {
            $bulanAktif = $bulanOptions[0] ?? '';
        }

        $items = $this->riwayatItems($user, $bulanAktif);

        return view('fitur_peserta.riwayat', [
            'peserta' => $this->identitas($user),
            'ringkasan' => $this->ringkasanKehadiran($user),
            'bulanOptions' => $bulanOptions,
            'bulanAktif' => $bulanAktif,
            'totalTercatat' => Absensi::where('user_id', $user->id)->count()
                + Izin::where('user_id', $user->id)->count(),
            'items' => $items,
        ]);
    }

    public function grafik()
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $skorMingguan = $this->skorMingguan($user, $periode);
        $mingguAktif = $periode?->mingguAktif() ?? 1;

        $skorAwal = $skorMingguan[0]['skor'] ?? 0;
        $skorTerakhir = end($skorMingguan)['skor'] ?? $skorAwal;
        $rata = $skorMingguan === [] ? 0 : array_sum(array_column($skorMingguan, 'skor')) / count($skorMingguan);
        $selisih = $skorTerakhir - $skorAwal;
        $persenNaik = $skorAwal > 0 ? round($selisih / $skorAwal * 100, 1) : 0;

        return view('fitur_peserta.grafik', [
            'peserta' => $this->identitas($user),
            'chartData' => $this->chartSkor($skorMingguan, 'dark'),
            'ringkasan' => [
                'skor_awal' => ['nilai' => (string) $skorAwal, 'ket' => 'Minggu ' . ($skorMingguan[0]['minggu'] ?? 1)],
                'skor_sekarang' => ['nilai' => (string) $skorTerakhir, 'ket' => 'Minggu ' . ($skorMingguan[count($skorMingguan) - 1]['minggu'] ?? $mingguAktif)],
                'peningkatan' => [
                    'nilai' => ($selisih >= 0 ? '+' : '−') . abs($selisih),
                    'ket' => ($selisih >= 0 ? '↑ ' : '↓ ') . abs($persenNaik) . '%',
                ],
                'rata_rata' => ['nilai' => number_format($rata, 1), 'ket' => count($skorMingguan) . ' minggu'],
            ],
            'mingguan' => array_map(fn (array $s) => [
                'minggu' => $s['minggu'],
                'rentang' => $s['rentang'],
                'skor' => $s['skor'],
                'current' => $s['minggu'] === $mingguAktif,
            ], $skorMingguan),
        ]);
    }

    public function laporan()
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $totalMinggu = $periode?->total_minggu ?? 8;

        $mingguan = Laporan::where('user_id', $user->id)
            ->mingguan()
            ->orderBy('minggu_ke')
            ->get()
            ->keyBy('minggu_ke');

        $laporanAkhir = Laporan::where('user_id', $user->id)
            ->where('tipe', Laporan::TIPE_AKHIR)
            ->first();

        $barisMingguan = [];
        foreach ($mingguan as $minggu => $laporan) {
            $barisMingguan[] = [
                'nomor' => (int) $minggu,
                'judul' => 'Minggu ' . $minggu . ' – ' . ($periode?->rentangMinggu((int) $minggu) ?? ''),
                'detail' => $laporan->submitted_at
                    ? 'Diserahkan ' . $laporan->submitted_at->translatedFormat('j M Y')
                    : 'Belum dikumpulkan',
                'status' => $laporan->status_label,
                'done' => $laporan->status === 'disetujui',
            ];
        }

        return view('fitur_peserta.laporan', [
            'peserta' => $this->identitas($user),
            'status' => [
                'label' => $this->statusLaporanAkhir($laporanAkhir),
                'badge' => $laporanAkhir && $laporanAkhir->status !== 'draft' ? 'Sudah diajukan' : 'Draft belum ada',
                'batas' => $periode?->tanggal_selesai?->translatedFormat('j F Y') ?? '—',
                'sisa' => ($periode?->sisa_hari ?? 0) . ' hari',
            ],
            'checklist' => [
                [
                    'label' => 'Laporan mingguan',
                    'detail' => '(' . $mingguan->where('status', 'disetujui')->count() . ' dari ' . $totalMinggu . ')',
                    'done' => $mingguan->where('status', 'disetujui')->count() > 0,
                ],
                ['label' => 'Draft laporan akhir', 'detail' => null, 'done' => (bool) $laporanAkhir && $laporanAkhir->status !== 'draft'],
                ['label' => 'Review pembimbing', 'detail' => null, 'done' => $laporanAkhir?->status === 'menunggu'],
                ['label' => 'Persetujuan final', 'detail' => null, 'done' => $laporanAkhir?->status === 'disetujui'],
            ],
            'mingguan' => $barisMingguan,
        ]);
    }

    public function penilaian()
    {
        $user = $this->user();
        $terakhir = $this->penilaianTerakhir($user);

        $riwayat = Penilaian::where('peserta_id', $user->id)
            ->terbaru()
            ->take(6)
            ->get();

        $barisRiwayat = $riwayat->values()->map(function (Penilaian $p, int $i) {
            return [
                'judul' => 'Evaluasi ' . ($p->jenis === 'akhir' ? 'Akhir' : 'Minggu ' . ltrim(str_replace('w', '', (string) $p->periode_key), 'w')),
                'tanggal' => $p->tanggal_format,
                'nilai' => $p->nilai_rata_rata,
                'badge' => $i === 0 ? 'Terbaru' : ($p->jenis === 'akhir' ? 'Akhir' : 'Sebelumnya'),
                'terbaru' => $i === 0,
            ];
        })->all();

        return view('fitur_peserta.penilaian', [
            'peserta' => $this->identitas($user),
            'nilai' => [
                'total' => $terakhir?->nilai_rata_rata ?? '—',
                'pembimbing' => $terakhir?->pembimbing?->nama_lengkap ?? 'Belum ada pembimbing',
                'diperbarui' => $terakhir?->tanggal_format ?: '—',
            ],
            'aspek' => $this->aspekPenilaian($terakhir),
            'komentar' => [
                'isi' => $terakhir?->komentar ? '"' . $terakhir->komentar . '"' : '"Belum ada komentar."',
                'oleh' => $terakhir
                    ? trim(($terakhir->pembimbing?->nama_lengkap ?? 'Pembimbing') . ' • ' . $terakhir->tanggal_format)
                    : '—',
            ],
            'riwayat' => $barisRiwayat,
        ]);
    }

    public function sertifikat()
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $kehadiran = $this->ringkasanKehadiran($user);
        $totalHariKerja = $this->totalHariKerja($periode);
        $hadirPersen = $this->persenKehadiran($kehadiran, $totalHariKerja);

        $laporanMinggu = Laporan::where('user_id', $user->id)->mingguan()->disetujui()->count();
        $laporanAkhir = Laporan::where('user_id', $user->id)->where('tipe', Laporan::TIPE_AKHIR)->first();
        $data = $this->dataSertifikat($user, $periode, $kehadiran, $hadirPersen, $laporanMinggu, $laporanAkhir);

        return view('fitur_peserta.sertifikat', [
            'peserta' => $this->identitas($user),
            'progress' => $data['progress'],
            'terkunci' => $data['terkunci'],
            'syarat' => $data['syarat'],
            'info' => 'Sertifikat akan diterbitkan otomatis setelah semua syarat terpenuhi dan disetujui oleh pembimbing. '
                . 'Pastikan laporan akhir dan penilaian final sudah lengkap sebelum periode magang berakhir.',
        ]);
    }

    public function izin()
    {
        return view('fitur_peserta.izin', [
            'peserta' => $this->identitas($this->user()),
            'jenisOptions' => collect(Izin::JENIS)
                ->mapWithKeys(fn (string $jenis) => [$jenis => ucfirst($jenis)])
                ->all(),
            'catatan' => 'Pengajuan akan ditinjau oleh pembimbing. Pastikan alasan jelas dan lampirkan bukti jika diperlukan '
                . '(misalnya surat dokter untuk sakit). Status pengajuan dapat dilihat di halaman Riwayat.',
        ]);
    }

    public function profil()
    {
        $user = $this->user();
        $diri = $user->dataDiri;
        $magang = $user->dataMagang;

        return view('fitur_peserta.profil', [
            'peserta' => $this->identitas($user),
            'pribadi' => [
                'nama' => $user->nama_lengkap,
                'nim' => $magang?->nis_nim ?? '—',
                'ttl' => $diri?->ttl ?: '—',
                'jenis_kelamin' => $diri?->jenis_kelamin_label ?? '—',
                'email' => $user->email,
                'hp' => $diri?->no_hp ?? '—',
                'alamat' => $diri?->alamat ?? '—',
            ],
            'magang' => [
                'institusi' => $magang?->institusi_label ?? '—',
                'prodi' => $magang?->prodi ?? '—',
                'unit_kerja' => $magang?->penempatan ?? '—',
                'pembimbing' => $magang?->pembimbing_nama ?? 'Belum ditentukan',
                'periode' => $this->periode($user)?->rentang ?? ($magang?->periode_label ?? '—'),
                'status' => ucfirst((string) $user->status),
            ],
        ]);
    }

    /* ======================================================================
     * AKSI (POST)
     * ==================================================================== */

    public function storeAbsen(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:masuk,pulang'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $user = $this->user();

        if ($this->magangSudahSelesai($user)) {
            return back()->with('error', 'Periode magang Anda sudah berakhir, absensi tidak dapat diisi lagi.');
        }

        $hariIni = Carbon::today();
        $hariKerja = (array) Pengaturan::ambil('hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis']);
        $namaHari = $this->namaHari($hariIni->dayOfWeekIso);

        if (! in_array($namaHari, $hariKerja, true)) {
            return back()->with('error', "Hari ini ({$namaHari}) bukan hari kerja magang. Absensi tidak dicatat.");
        }

        $absen = Absensi::firstOrNew([
            'user_id' => $user->id,
            'tanggal' => $hariIni->toDateString(),
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('absensi/' . $hariIni->format('Y-m'), 'public');
        }

        // Jam dinding saat ini (bukan $hariIni yang selalu tengah malam).
        $jamSekarang = Carbon::now()->format('H:i:s');

        if ($validated['jenis'] === 'masuk') {
            if ($absen->jam_masuk) {
                return back()->with('error', 'Anda sudah melakukan absen masuk pukul ' . substr($absen->jam_masuk, 0, 5) . '.');
            }
            if ($jamSekarang > '11:59:59') {
                return back()->with('error', 'Absen masuk hanya dapat dilakukan sebelum pukul 12.00 WIB.');
            }

            $absen->jam_masuk = $jamSekarang;
            $absen->status = Absensi::statusDariJamMasuk($jamSekarang);
            $absen->foto_masuk_path = $fotoPath ?? $absen->foto_masuk_path;
            $pesan = 'Absen masuk berhasil dicatat pukul ' . substr($jamSekarang, 0, 5)
                . ' WIB — status ' . ucfirst($absen->status) . '.';
        } else {
            if (! $absen->jam_masuk) {
                return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
            }
            if ($absen->jam_pulang) {
                return back()->with('error', 'Anda sudah melakukan absen pulang pukul ' . substr($absen->jam_pulang, 0, 5) . '.');
            }
            if ($jamSekarang < '12:00:00') {
                return back()->with('error', 'Absen pulang baru dapat dilakukan setelah pukul 12.00 WIB.');
            }

            $absen->jam_pulang = $jamSekarang;
            $absen->foto_pulang_path = $fotoPath ?? $absen->foto_pulang_path;
            $pesan = 'Absen pulang berhasil dicatat pukul ' . substr($jamSekarang, 0, 5) . ' WIB.';
        }

        $absen->latitude = $validated['latitude'] ?? $absen->latitude;
        $absen->longitude = $validated['longitude'] ?? $absen->longitude;
        $absen->lokasi ??= $user->dataMagang?->penempatan;
        $absen->save();

        ActivityLog::catat('absensi', $pesan, $user);

        return redirect()->route('peserta.absensi')->with('success', $pesan);
    }

    public function storeIzin(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:' . implode(',', Izin::JENIS)],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['required', 'string', 'min:10', 'max:1000'],
            'bukti' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'alasan.min' => 'Alasan minimal 10 karakter agar mudah ditinjau pembimbing.',
        ]);

        $user = $this->user();

        if ($this->magangSudahSelesai($user)) {
            return back()->with('error', 'Periode magang Anda sudah berakhir, pengajuan izin tidak dapat dikirim lagi.');
        }

        $buktiPath = $request->hasFile('bukti')
            ? $request->file('bukti')->store('izin', 'public')
            : null;

        $izin = Izin::create([
            'user_id' => $user->id,
            'jenis' => $validated['jenis'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'alasan' => $validated['alasan'],
            'bukti_path' => $buktiPath,
            'status' => 'menunggu',
        ]);

        // Tandai absensi pada rentang izin agar tidak terhitung alpha.
        $tanggal = Carbon::parse($validated['tanggal_mulai']);
        $selesai = Carbon::parse($validated['tanggal_selesai']);
        while ($tanggal->lessThanOrEqualTo($selesai)) {
            Absensi::firstOrCreate(
                ['user_id' => $user->id, 'tanggal' => $tanggal->toDateString()],
                [
                    'status' => 'izin',
                    'keterangan' => 'Pengajuan ' . $validated['jenis'] . ' — menunggu persetujuan',
                ],
            );
            $tanggal->addDay();
        }

        ActivityLog::catat('izin', 'Mengajukan ' . $validated['jenis'] . ' untuk ' . $izin->rentang, $user);

        return redirect()->route('peserta.izin')->with(
            'success',
            'Pengajuan ' . $validated['jenis'] . ' (' . $izin->rentang . ') berhasil dikirim. Status dapat dicek di halaman Riwayat.'
        );
    }

    public function storeLaporan(Request $request)
    {
        $user = $this->user();
        $periode = $this->periode($user);
        $totalMinggu = $periode?->total_minggu ?? 8;

        $disetujui = Laporan::where('user_id', $user->id)->mingguan()->disetujui()->count();
        $kehadiran = $this->ringkasanKehadiran($user);
        $totalHariKerja = $this->totalHariKerja($periode);
        $hadirPersen = $this->persenKehadiran($kehadiran, $totalHariKerja);
        $minKehadiran = (int) Pengaturan::ambil('min_kehadiran', 80);

        if ($disetujui < $totalMinggu) {
            return back()->with('error', "Laporan akhir belum dapat diajukan. Laporan mingguan yang disetujui baru {$disetujui} dari {$totalMinggu}.");
        }

        if ($hadirPersen < $minKehadiran) {
            return back()->with('error', "Kehadiran Anda {$hadirPersen}% — di bawah syarat minimal {$minKehadiran}% untuk mengajukan laporan akhir.");
        }

        $laporan = Laporan::firstOrNew([
            'user_id' => $user->id,
            'tipe' => Laporan::TIPE_AKHIR,
            'minggu_ke' => null,
        ]);

        if ($laporan->exists && in_array($laporan->status, ['menunggu', 'disetujui'], true)) {
            return back()->with('info', 'Laporan akhir sudah diajukan dan sedang menunggu review pembimbing.');
        }

        $laporan->judul = 'Laporan Akhir Magang';
        $laporan->status = 'menunggu';
        $laporan->submitted_at = now();
        $laporan->save();

        ActivityLog::catat('laporan', 'Mengajukan laporan akhir magang', $user);

        return back()->with('success', 'Laporan akhir berhasil diajukan. Menunggu review pembimbing.');
    }

    /* ======================================================================
     * HELPER DATA
     * ==================================================================== */

    private function user(): User
    {
        return auth()->user();
    }

    /**
     * Apakah magang peserta ini sudah tamat.
     *
     * Akun berstatus `selesai` tetap boleh login — mereka yang justru perlu
     * membuka /sertifikat dan /riwayat. Yang tidak boleh lagi adalah mengisi
     * absensi, mengajukan izin, atau mengirim laporan, karena periode magangnya
     * sudah ditutup. Admin menyimpan status ini di `users.status` sekaligus
     * `data_magang.status`, jadi salah satunya cukup untuk memutuskan.
     */
    private function magangSudahSelesai(User $user): bool
    {
        return $user->status === 'selesai'
            || $user->dataMagang?->status === 'selesai';
    }

    private function periode(User $user): ?Periode
    {
        return $user->dataMagang?->periodeRel;
    }

    /**
     * Peta status kehadiran → kelas Tailwind statis.
     */
    private function statusKehadiran(string $status): array
    {
        return match ($status) {
            'hadir' => [
                'label' => 'Hadir',
                'box' => 'bg-emerald-500/20',
                'boxText' => 'text-emerald-400',
                'boxTextSoft' => 'text-emerald-400/80',
                'badge' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
            ],
            'terlambat' => [
                'label' => 'Terlambat',
                'box' => 'bg-amber-500/20',
                'boxText' => 'text-amber-400',
                'boxTextSoft' => 'text-amber-400/80',
                'badge' => 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
            ],
            'izin' => [
                'label' => 'Izin',
                'box' => 'bg-sky-500/20',
                'boxText' => 'text-sky-400',
                'boxTextSoft' => 'text-sky-400/80',
                'badge' => 'bg-sky-500/20 text-sky-400 border border-sky-500/30',
            ],
            'alpha' => [
                'label' => 'Alpha',
                'box' => 'bg-rose-500/20',
                'boxText' => 'text-rose-400',
                'boxTextSoft' => 'text-rose-400/80',
                'badge' => 'bg-rose-500/20 text-rose-400 border border-rose-500/30',
            ],
            'kosong' => [
                'label' => '—',
                'box' => 'bg-white/5',
                'boxText' => 'text-slate-500',
                'boxTextSoft' => 'text-slate-500',
                'badge' => 'bg-white/5 text-slate-500',
            ],
            default => [
                'label' => 'Menunggu',
                'box' => 'bg-white/10',
                'boxText' => 'text-slate-400',
                'boxTextSoft' => 'text-slate-500',
                'badge' => 'bg-white/10 text-slate-400 border border-white/10',
            ],
        };
    }

    /**
     * Identitas peserta untuk header/sidebar dan seluruh halaman.
     */
    private function identitas(User $user): array
    {
        $magang = $user->dataMagang;
        $periode = $magang?->periodeRel;

        $periodePanjang = $periode?->tanggal_mulai && $periode?->tanggal_selesai
            ? $periode->tanggal_mulai->translatedFormat('j F') . ' – ' . $periode->tanggal_selesai->translatedFormat('j F Y')
            : ($magang?->periode_label ?? '—');

        return [
            'nama' => $user->nama_lengkap,
            'id_peserta' => $magang?->id_kode ?? 'PS-' . str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
            'institusi' => $magang?->institusi_label ?? '—',
            'program_studi' => $magang?->prodi ?? '—',
            'unit_kerja' => $magang?->penempatan ?? '—',
            'periode' => $periodePanjang,
            'periode_panjang' => $periodePanjang,
            'periode_label' => $periode?->nama ?? ($magang?->periode_label ?? '—'),
            'periode_progress' => $periode?->progress ?? 0,
            'pembimbing' => $magang?->pembimbing_nama ?? 'Belum ditentukan',
            'status' => ucfirst((string) $user->status),
        ];
    }

    private function areaAbsensi(User $user): array
    {
        $radius = (int) Pengaturan::ambil('radius_absensi', 2000);
        $jamMasuk = (string) Pengaturan::ambil('jam_masuk', '08:00');
        $jamPulang = (string) Pengaturan::ambil('jam_pulang', '16:00');
        $hariKerja = (array) Pengaturan::ambil('hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis']);

        return [
            'lokasi' => $user->dataMagang?->penempatan ?? 'Dinas Kominfo Provinsi Sumatera Utara',
            'alamat' => 'Jl. HM. Said No.27, Medan',
            'radius' => number_format($radius) . ' meter',
            'hari_kerja' => implode('–', [$hariKerja[0] ?? 'Senin', end($hariKerja) ?: 'Kamis']),
            'jam_kerja' => $this->jamTitik($jamMasuk) . ' – ' . $this->jamTitik($jamPulang) . ' WIB',
            'status_lokasi' => 'Dalam jangkauan',
        ];
    }

    private function ringkasanKehadiran(User $user): array
    {
        $hitung = Absensi::where('user_id', $user->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'hadir' => (int) ($hitung['hadir'] ?? 0),
            'terlambat' => (int) ($hitung['terlambat'] ?? 0),
            'izin' => (int) ($hitung['izin'] ?? 0),
            'alpha' => (int) ($hitung['alpha'] ?? 0),
        ];
    }

    /**
     * Persentase kehadiran. "Terlambat" tetap dihitung hadir karena peserta
     * datang dan absen — hanya izin/alpha yang mengurangi.
     */
    private function persenKehadiran(array $ringkasan, int $totalHariKerja): int
    {
        if ($totalHariKerja <= 0) {
            return 0;
        }

        $masuk = $ringkasan['hadir'] + $ringkasan['terlambat'];

        return (int) min(100, round($masuk / $totalHariKerja * 100));
    }

    /** Jumlah hari kerja (Senin–Kamis) dari awal periode hingga hari ini. */
    private function totalHariKerja(?Periode $periode): int
    {
        if (! $periode?->tanggal_mulai) {
            return 0;
        }

        $tanggal = $periode->tanggal_mulai->copy()->startOfDay();
        $batas = min($periode->tanggal_selesai->timestamp, Carbon::today()->timestamp);
        $total = 0;

        while ($tanggal->timestamp <= $batas) {
            if ($tanggal->dayOfWeekIso <= 4) {
                $total++;
            }
            $tanggal->addDay();
        }

        return $total;
    }

    private function absenHariIni(User $user): array
    {
        $absen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (! $absen || (! $absen->jam_masuk && ! $absen->jam_pulang)) {
            return [
                'masuk' => null,
                'pulang' => null,
                'durasi' => null,
                'status' => in_array($absen?->status, ['izin', 'alpha'], true)
                    ? ucfirst((string) $absen->status)
                    : 'Belum absen',
            ];
        }

        return [
            'masuk' => $absen->jam_masuk ? substr($absen->jam_masuk, 0, 5) : null,
            'pulang' => $absen->jam_pulang ? substr($absen->jam_pulang, 0, 5) : null,
            'durasi' => $absen->durasi,
            'status' => ucfirst($absen->status),
        ];
    }

    /**
     * Skor per minggu (ascending) dari tabel penilaian.
     *
     * @return array<int, array{minggu:int, rentang:string, skor:int}>
     */
    private function skorMingguan(User $user, ?Periode $periode): array
    {
        $rows = Penilaian::where('peserta_id', $user->id)
            ->where('jenis', 'mingguan')
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        return $rows->map(function (Penilaian $p) use ($periode) {
            $minggu = (int) preg_replace('/\D/', '', (string) $p->periode_key);

            return [
                'minggu' => $minggu,
                'rentang' => $periode ? $periode->rentangMinggu(max(1, $minggu)) : '',
                'skor' => (int) round($p->total_skor),
            ];
        })->values()->all();
    }

    private function chartSkor(array $skorMingguan, string $variant): array
    {
        return [
            'labels' => array_map(fn (array $s) => 'Minggu ' . $s['minggu'], $skorMingguan),
            'data' => array_map(fn (array $s) => $s['skor'], $skorMingguan),
            'variant' => $variant,
        ];
    }

    private function penilaianTerakhir(User $user): ?Penilaian
    {
        return Penilaian::with(['detail.kriteria', 'pembimbing'])
            ->where('peserta_id', $user->id)
            ->terbaru()
            ->first();
    }

    private function aspekPenilaian(?Penilaian $penilaian): array
    {
        if (! $penilaian) {
            return [];
        }

        return $penilaian->detail->values()->map(function ($detail, int $i) {
            $nilai = (float) $detail->nilai;

            return [
                'label' => $detail->kriteria?->nama ?? 'Kriteria',
                'nilai' => number_format($nilai, 1),
                'persen' => (int) round($nilai / 5 * 100),
                'bar' => self::BAR_GRADIENTS[$i % count(self::BAR_GRADIENTS)],
            ];
        })->all();
    }

    /**
     * Deret Senin–Kamis minggu berjalan untuk kartu riwayat mingguan.
     */
    private function riwayatMinggu(User $user): array
    {
        $hariIni = Carbon::today();
        $senin = $hariIni->copy()->startOfWeek();
        $rows = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$senin->toDateString(), $senin->copy()->addDays(3)->toDateString()])
            ->get()
            ->keyBy(fn (Absensi $a) => $a->tanggal->toDateString());

        $baris = [];
        for ($i = 0; $i < 4; $i++) {
            $tanggal = $senin->copy()->addDays($i);
            $absen = $rows->get($tanggal->toDateString());
            $masaDepan = $tanggal->greaterThan($hariIni);
            $status = $masaDepan ? 'kosong' : ($absen?->status ?? 'menunggu');

            $baris[] = [
                'hari' => strtoupper(substr($this->namaHari($tanggal->dayOfWeekIso), 0, 3)),
                'tanggal' => $tanggal->translatedFormat('j F Y'),
                'detail' => $masaDepan ? 'Belum dimulai' : ($absen?->detail ?? 'Belum absen'),
                'status' => $status,
                'hariIni' => $tanggal->equalTo($hariIni),
                'future' => $masaDepan,
            ] + $this->statusKehadiran($status);
        }

        return $baris;
    }

    /**
     * Gabungan absensi + izin untuk satu bulan tertentu.
     */
    private function riwayatItems(User $user, string $bulan): array
    {
        if ($bulan === '') {
            return [];
        }

        $awal = $this->parseBulan($bulan);
        if (! $awal) {
            return [];
        }
        $akhir = $awal->copy()->endOfMonth();

        $absensi = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$awal->toDateString(), $akhir->toDateString()])
            ->orderByDesc('tanggal')
            ->get()
            ->map(fn (Absensi $a) => [
                'sort' => $a->tanggal->timestamp,
                'bulan' => strtoupper(substr($a->tanggal->translatedFormat('M'), 0, 3)),
                'tgl' => $a->tanggal->format('d'),
                'judul' => $a->tanggal_panjang,
                'detail' => $a->detail,
                'status' => $a->status,
            ]);

        $izin = Izin::where('user_id', $user->id)
            ->where(function ($q) use ($awal, $akhir) {
                $q->whereBetween('tanggal_mulai', [$awal->toDateString(), $akhir->toDateString()])
                    ->orWhereBetween('tanggal_selesai', [$awal->toDateString(), $akhir->toDateString()]);
            })
            ->orderByDesc('tanggal_mulai')
            ->get()
            ->filter(fn (Izin $i) => ! Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $i->tanggal_mulai)->exists())
            ->map(fn (Izin $i) => [
                'sort' => $i->tanggal_mulai->timestamp,
                'bulan' => strtoupper(substr($i->tanggal_mulai->translatedFormat('M'), 0, 3)),
                'tgl' => $i->tanggal_mulai->format('d'),
                'judul' => $i->tanggal_mulai->translatedFormat('l, j F Y'),
                'detail' => $i->jenis_label . ' · ' . ucfirst($i->status)
                    . ($i->reviewer ? ' oleh ' . $i->reviewer->nama_lengkap : ''),
                'status' => 'izin',
            ]);

        return $absensi->concat($izin)
            ->sortByDesc('sort')
            ->values()
            ->map(function (array $item) {
                unset($item['sort']);

                return $item + $this->statusKehadiran($item['status']);
            })
            ->all();
    }

    private function statusLaporanAkhir(?Laporan $laporan): string
    {
        return match ($laporan?->status) {
            'disetujui' => 'Disetujui pembimbing',
            'ditolak' => 'Perlu revisi',
            'menunggu' => 'Menunggu review',
            default => 'Belum dikumpulkan',
        };
    }

    private function batasLaporan(?Periode $periode): string
    {
        if (! $periode?->tanggal_selesai) {
            return 'Belum ditentukan';
        }

        return $periode->tanggal_selesai->translatedFormat('j F Y')
            . ' (' . $periode->sisa_hari . ' hari lagi)';
    }

    /**
     * Progress + rincian syarat sertifikat.
     */
    private function dataSertifikat(User $user, ?Periode $periode, array $kehadiran, int $hadirPersen, int $laporanMinggu, ?Laporan $laporanAkhir): array
    {
        $minKehadiran = (int) Pengaturan::ambil('min_kehadiran', 80);
        $totalMinggu = $periode?->total_minggu ?? 8;
        $penilaianFinal = Penilaian::where('peserta_id', $user->id)->where('jenis', 'akhir')->first();
        $sertifikat = Sertifikat::where('user_id', $user->id)->first();

        $syarat = [
            [
                'label' => "Absensi minimal {$minKehadiran}%",
                'detail' => '(Saat ini ' . $hadirPersen . '%)',
                'done' => $hadirPersen >= $minKehadiran,
            ],
            [
                'label' => 'Laporan mingguan',
                'detail' => "({$laporanMinggu}/{$totalMinggu} disetujui)",
                'done' => $laporanMinggu >= $totalMinggu,
            ],
            [
                'label' => 'Laporan akhir disetujui',
                'detail' => $this->statusLaporanAkhir($laporanAkhir),
                'done' => $laporanAkhir?->status === 'disetujui',
            ],
            [
                'label' => 'Penilaian pembimbing final',
                'detail' => $penilaianFinal ? 'Skor ' . (int) round($penilaianFinal->total_skor) : 'Menunggu evaluasi akhir',
                'done' => (bool) $penilaianFinal,
            ],
        ];

        $terpenuhi = count(array_filter($syarat, fn (array $s) => $s['done']));
        $progress = (int) round($terpenuhi / count($syarat) * 100);

        // Simpan progres terbaru agar admin/pembimbing melihat angka yang sama.
        $status = $progress >= 100 ? 'terbit' : 'proses';
        $data = Sertifikat::updateOrCreate(
            ['user_id' => $user->id],
            [
                'progress' => $progress,
                'status' => $status,
                'nomor' => $progress >= 100
                    ? ($sertifikat?->nomor ?? 'SRT/MKD/' . now()->format('Y') . '/' . str_pad((string) $user->id, 4, '0', STR_PAD_LEFT))
                    : null,
                'issued_at' => $progress >= 100 ? ($sertifikat?->issued_at ?? now()) : null,
            ],
        );

        return [
            'progress' => $data->progress,
            'terkunci' => $data->terkunci,
            'syarat' => $syarat,
        ];
    }

    /**
     * Ubah label bulan (mis. "Oktober 2026") menjadi tanggal awal bulan.
     * Tidak bergantung pada tabel terjemahan Carbon — peta nama bulan ditulis
     * eksplisit (Indonesia + Inggris) agar tahan perubahan locale.
     */
    private function parseBulan(string $bulan): ?Carbon
    {
        $bulan = trim($bulan);

        if (preg_match('/^(\d{4})-(\d{1,2})$/', $bulan, $m)) {
            return Carbon::create((int) $m[1], (int) $m[2], 1)->startOfMonth();
        }

        if (preg_match('/^([A-Za-z]+)\s+(\d{4})$/', $bulan, $m)) {
            $nomor = self::NAMA_BULAN[strtolower($m[1])] ?? null;
            if ($nomor) {
                return Carbon::create((int) $m[2], $nomor, 1)->startOfMonth();
            }
        }

        return null;
    }

    private function namaHari(int $iso): string
    {
        return [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'][$iso] ?? '—';
    }

    /** "08:00" → "08.00". */
    private function jamTitik(string $jam): string
    {
        return str_replace(':', '.', substr($jam, 0, 5));
    }
}

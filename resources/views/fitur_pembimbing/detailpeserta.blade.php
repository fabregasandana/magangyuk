@extends('layouts.pembimbing')

@section('title', 'Detail Peserta')

@section('content')
    @php
        // Status peserta → badge terang di kartu profil (kelas Tailwind statis).
        $badgeHero = match ($peserta['status']) {
            'perhatian' => ['box' => 'bg-amber-50 text-amber-700 border-amber-100', 'dot' => 'bg-amber-500'],
            'selesai' => ['box' => 'bg-slate-100 text-slate-500 border-slate-200', 'dot' => 'bg-slate-400'],
            default => ['box' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot' => 'bg-emerald-500'],
        };
        // Status logbook peserta → border, ikon, dan badge (kelas Tailwind statis).
        $gayaLogbook = [
            'disetujui' => [
                'border' => 'border-white/8',
                'ikon' => 'bg-emerald-500/20',
                'label' => 'Disetujui',
                'badge' => 'bg-emerald-100 text-emerald-700',
            ],
            'menunggu' => [
                'border' => 'border-amber-500/30',
                'ikon' => 'bg-amber-500/20',
                'label' => 'Menunggu',
                'badge' => 'bg-amber-100 text-amber-700',
            ],
            'ditolak' => [
                'border' => 'border-rose-500/30',
                'ikon' => 'bg-rose-500/20',
                'label' => 'Ditolak',
                'badge' => 'bg-rose-100 text-rose-700',
            ],
        ];
    @endphp

    <!-- Breadcrumb + Back -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('pembimbing.peserta') }}" class="text-blue-200/70 hover:text-white transition font-medium">Daftar Peserta</a>
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-white font-semibold">Detail Peserta</span>
    </div>

    <!-- PROFILE CARD -->
    <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-56 h-56 bg-komdigi-blue/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col lg:flex-row gap-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 flex-1">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 rounded-2xl {{ $peserta['avatar'] }} flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/40">
                        {{ $peserta['inisial'] }}
                    </div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                        <div>
                            <h1 class="text-2xl font-black text-white">{{ $peserta['nama'] }}</h1>
                            <p class="text-sm text-slate-400 font-medium">Peserta Magang • ID: <span class="text-komdigi-blue font-semibold">{{ $peserta['id_peserta'] }}</span></p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 {{ $badgeHero['box'] }} text-xs font-bold rounded-full self-center sm:self-auto border">
                            <span class="w-2 h-2 {{ $badgeHero['dot'] }} rounded-full animate-pulse"></span>
                            {{ $peserta['gaya']['label_panjang'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Institusi</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $peserta['institusi'] }}</p>
                        </div>
                        <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Unit Kerja</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $peserta['unit_kerja'] }}</p>
                        </div>
                        <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Periode</p>
                            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $peserta['periode'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick actions -->
            <div class="flex lg:flex-col gap-2 shrink-0 justify-center">
                <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $peserta['id']]) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Beri Penilaian
                </a>
                <a href="{{ route('pembimbing.logbook') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/5 border border-white/10 text-slate-200 text-sm font-bold rounded-xl hover:bg-white/10 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Lihat Logbook
                </a>
            </div>
        </div>
    </div>

    <!-- STATS ROW -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($statistik as $stat)
            <div class="glass-card rounded-3xl p-5 text-center">
                <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">{{ $stat['label'] }}</p>
                <p class="text-3xl font-black {{ $stat['warna'] }}">{{ $stat['nilai'] }}</p>
                <p class="text-[10px] text-slate-400 mt-1">{{ $stat['keterangan'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- TABS -->
    <div class="flex flex-wrap gap-2" data-tab-group>
        <button type="button" class="tab-btn active px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="grafik">Grafik Performa</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="absensi">Riwayat Absensi</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="logbook">Daftar Logbook</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="penilaian">Riwayat Penilaian</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="laporan">Laporan &amp; Izin</button>
    </div>

    <!-- TAB: GRAFIK -->
    <div id="tab-grafik" class="tab-content active space-y-5">
        <div class="grid lg:grid-cols-2 gap-5">
            <div class="glass-card rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-white">Skor Kinerja Mingguan</h3>
                    <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                </div>
                <div class="h-56">
                    <canvas id="scoreChart" data-chart='@json($chartSkor)'></canvas>
                </div>
            </div>
            <div class="glass-card rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-white">Kehadiran Mingguan</h3>
                    <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                </div>
                <div class="h-56">
                    <canvas id="attendChart" data-chart='@json($chartKehadiran)'></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: RIWAYAT ABSENSI -->
    <div id="tab-absensi" class="tab-content">
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="font-bold text-white">Riwayat Absensi</h3>
                <div class="flex gap-2">
                    <select id="filterBulan" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                        <option value="all" selected>Semua Bulan</option>
                        <option value="nov">November 2026</option>
                        <option value="okt">Oktober 2026</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[700px]">
                    <thead>
                        <tr class="border-b border-white/8">
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Masuk</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Pulang</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Durasi</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody id="absensiTable">
                        @foreach ($absensi as $a)
                            <tr class="{{ $loop->last ? '' : 'border-b border-white/5' }} hover:bg-white/[0.03]" data-bulan="{{ str_contains($a['tanggal'], 'Nov') ? 'nov' : 'okt' }}">
                                <td class="px-5 py-3.5 text-sm text-white font-medium">{{ $a['tanggal'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-slate-300">{{ $a['masuk'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-slate-300">{{ $a['pulang'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-slate-300">{{ $a['durasi'] }}</td>
                                <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full {{ $a['badge'] }} text-[11px] font-bold">{{ $a['label'] }}</span></td>
                            </tr>
                        @endforeach
                        <tr id="absensiEmpty" class="hidden">
                            <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada data absensi untuk bulan ini.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: LOGBOOK -->
    <div id="tab-logbook" class="tab-content">
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Daftar Logbook Peserta</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">{{ $peserta['logbook_terisi'] }} / {{ $peserta['logbook_total'] }} terisi</span>
            </div>
            <div class="space-y-3">
                @forelse ($logbookPeserta as $lb)
                    @php $gaya = $gayaLogbook[$lb['status']] ?? $gayaLogbook['disetujui']; @endphp
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border {{ $gaya['border'] }}">
                        <div class="w-10 h-10 rounded-xl {{ $gaya['ikon'] }} flex items-center justify-center shrink-0">
                            @if ($lb['status'] === 'menunggu')
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif ($lb['status'] === 'ditolak')
                                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            @else
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white">{{ $lb['minggu'] }} • {{ $lb['rentang'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $lb['ringkasan'] }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full {{ $gaya['badge'] }} text-[11px] font-bold shrink-0">{{ $gaya['label'] }}</span>
                        <a href="{{ route('pembimbing.logbook') }}" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">{{ $lb['aksi'] }}</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-6">Belum ada logbook yang diisi peserta.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB: RIWAYAT PENILAIAN -->
    <div id="tab-penilaian" class="tab-content">
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Riwayat Penilaian</h3>
                <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $peserta['id']]) }}" class="text-sm font-bold text-komdigi-blue hover:underline">+ Beri Penilaian Baru</a>
            </div>
            <div class="space-y-4">
                @forelse ($riwayatPenilaian as $rp)
                    <div class="p-5 rounded-2xl bg-white/[0.04] border border-white/8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                            <div>
                                <p class="text-sm font-bold text-white">{{ $rp['judul'] }}</p>
                                <p class="text-xs text-slate-400">{{ $rp['tanggal'] }} • oleh {{ $mentor['nama_gelar'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-amber-400">{{ $rp['skor'] }}</span>
                                <span class="text-xs text-slate-400">/ 5.0</span>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3 mb-4">
                            @foreach ($rp['kriteria'] as $k)
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-slate-400">{{ $k['nama'] }}</span>
                                        <span class="font-bold text-white">{{ $k['nilai'] }}</span>
                                    </div>
                                    <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full {{ $k['bar'] }} rounded-full" style="width:{{ $k['persen'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="p-3.5 rounded-xl bg-white/[0.04] border border-white/8">
                            <p class="text-xs text-slate-300 italic leading-relaxed">"{{ $rp['komentar'] }}"</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-6">Belum ada riwayat penilaian untuk peserta ini.</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- TAB: LAPORAN & IZIN -->
    <div id="tab-laporan" class="tab-content space-y-5">
        {{-- Laporan --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Laporan Peserta</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">
                    {{ collect($laporanPeserta)->where('status', 'disetujui')->count() }} / {{ count($laporanPeserta) }} disetujui
                </span>
            </div>
            <div class="space-y-4">
                @forelse ($laporanPeserta as $lp)
                    <div class="p-5 rounded-2xl bg-white/[0.04] border {{ $lp['boleh_review'] ? 'border-amber-500/30' : 'border-white/8' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white">{{ $lp['judul'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Dikirim {{ $lp['dikirim'] }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full {{ $lp['badge'] }} text-[11px] font-bold shrink-0">{{ $lp['label'] }}</span>
                        </div>
                        <p class="text-sm text-slate-300 leading-relaxed">{{ $lp['ringkasan'] }}</p>

                        @if ($lp['catatan'])
                            <div class="mt-3 p-3.5 rounded-xl bg-white/[0.04] border border-white/8">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan Pembimbing</p>
                                <p class="text-xs text-slate-300 italic leading-relaxed">"{{ $lp['catatan'] }}"</p>
                            </div>
                        @endif

                        @if ($lp['boleh_review'])
                            <form method="POST" action="{{ route('pembimbing.laporan.review') }}" class="mt-4 space-y-3 pt-4 border-t border-white/8">
                                @csrf
                                <input type="hidden" name="laporan_id" value="{{ $lp['id'] }}">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 block" for="komentar-laporan-{{ $lp['id'] }}">Catatan Review</label>
                                    <textarea id="komentar-laporan-{{ $lp['id'] }}" name="komentar" rows="2" placeholder="Wajib diisi jika menolak laporan..." class="w-full px-4 py-3 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-komdigi-cerulean resize-none"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2.5">
                                    <button type="submit" name="keputusan" value="approve" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Setujui
                                    </button>
                                    <button type="submit" name="keputusan" value="reject" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-rose-500 to-red-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Perlu Revisi
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-6">Peserta belum mengajukan laporan apa pun.</p>
                @endforelse
            </div>
        </div>

        {{-- Izin --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Pengajuan Izin</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">
                    {{ collect($izinPeserta)->where('status', 'menunggu')->count() }} menunggu review
                </span>
            </div>
            <div class="space-y-4">
                @forelse ($izinPeserta as $iz)
                    <div class="p-5 rounded-2xl bg-white/[0.04] border {{ $iz['boleh_review'] ? 'border-amber-500/30' : 'border-white/8' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white">{{ $iz['jenis'] }} • {{ $iz['rentang'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $iz['alasan'] }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full {{ $iz['badge'] }} text-[11px] font-bold shrink-0">{{ $iz['label'] }}</span>
                        </div>

                        @if ($iz['bukti_url'])
                            <a href="{{ $iz['bukti_url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-bold text-komdigi-blue hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Lihat Bukti Pendukung
                            </a>
                        @endif

                        @if ($iz['catatan'])
                            <div class="mt-3 p-3.5 rounded-xl bg-white/[0.04] border border-white/8">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan Review</p>
                                <p class="text-xs text-slate-300 italic leading-relaxed">"{{ $iz['catatan'] }}"</p>
                            </div>
                        @endif

                        @if ($iz['boleh_review'])
                            <form method="POST" action="{{ route('pembimbing.izin.review') }}" class="mt-4 space-y-3 pt-4 border-t border-white/8">
                                @csrf
                                <input type="hidden" name="izin_id" value="{{ $iz['id'] }}">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 block" for="catatan-izin-{{ $iz['id'] }}">Catatan Review</label>
                                    <textarea id="catatan-izin-{{ $iz['id'] }}" name="catatan_review" rows="2" placeholder="Wajib diisi jika menolak pengajuan..." class="w-full px-4 py-3 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-komdigi-cerulean resize-none"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2.5">
                                    <button type="submit" name="keputusan" value="approve" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Setujui
                                    </button>
                                    <button type="submit" name="keputusan" value="reject" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-gradient-to-r from-rose-500 to-red-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-6">Peserta belum pernah mengajukan izin.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@extends('layouts.pembimbing')

@section('title', 'Dashboard Pembimbing')

@section('content')

    {{-- Welcome Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Selamat datang kembali</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ $mentor['nama_gelar'] }} 👋</h1>
            <p class="text-sm text-blue-200/70 mt-1">Pembimbing Magang • {{ $mentor['unit_penempatan'] }}</p>
        </div>
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.07.44 WIB</p>
            </div>
        </div>
    </div>

    {{-- RINGKASAN STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide">Peserta Bimbingan</p>
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-white">{{ $jumlahPeserta }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $ringkasan['aktif'] }} Aktif • {{ $ringkasan['selesai'] }} Selesai</p>
        </div>

        <div class="glass-card rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[11px] font-bold text-amber-400 uppercase tracking-wide">Logbook Pending</p>
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-amber-400">{{ $ringkasan['logbook_pending'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Menunggu persetujuan</p>
        </div>

        <div class="glass-card rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[11px] font-bold text-rose-400 uppercase tracking-wide">Perlu Perhatian</p>
                <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-rose-400">{{ $ringkasan['perhatian'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Kehadiran / logbook rendah</p>
        </div>

        <div class="glass-card rounded-3xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-wide">Rata-rata Skor</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-emerald-400">{{ $ringkasan['rata_skor'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $deltaSkor }}</p>
        </div>
    </div>

    {{-- PESERTA PERLU PERHATIAN --}}
    <div class="glass-card rounded-3xl p-6">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-rose-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-komdigi-dark">Peserta Perlu Perhatian</h3>
                    <p class="text-xs text-slate-500">Kehadiran rendah atau jarang isi logbook</p>
                </div>
            </div>
            <span class="px-3 py-1.5 bg-rose-50 text-rose-700 text-[11px] font-bold rounded-full border border-rose-100">{{ count($perluPerhatian) }} Peserta</span>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            @forelse ($perluPerhatian as $p)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                    <div class="w-12 h-12 rounded-xl {{ $p['avatar'] }} flex items-center justify-center text-white font-black text-sm shrink-0">
                        {{ $p['inisial'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-white text-sm">{{ $p['nama'] }}</p>
                        <p class="text-xs text-slate-400">{{ $p['id_peserta'] }} • Kehadiran {{ $p['kehadiran'] }}%</p>
                        @if ($p['catatan'])
                            <div class="flex gap-2 mt-1.5">
                                <span class="text-[10px] px-2 py-0.5 rounded-full {{ $p['catatan_badge'] }} font-semibold">{{ $p['catatan'] }}</span>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Detail →</a>
                </div>
            @empty
                <p class="text-sm text-slate-400 col-span-2">Tidak ada peserta yang perlu perhatian. Kerja bagus! 🎉</p>
            @endforelse
        </div>
    </div>

    {{-- DAFTAR PESERTA BIMBINGAN --}}
    <div class="glass-card rounded-3xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-komdigi-dark">Daftar Peserta Bimbingan</h3>
                    <p class="text-xs text-slate-500">Kartu ringkas performa peserta</p>
                </div>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ($pesertaSorot as $p)
                <div class="rounded-2xl p-4 bg-white/[0.04] border {{ $p['card_border'] }} hover:bg-white/[0.07] transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-11 h-11 rounded-xl {{ $p['avatar'] }} flex items-center justify-center text-white font-black text-sm">
                            {{ $p['inisial'] }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-white text-sm truncate">{{ $p['nama'] }}</p>
                            <p class="text-[10px] text-slate-400">{{ $p['id_peserta'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-semibold text-slate-400">Skor</span>
                        <span class="text-sm font-black {{ $p['skor_color'] }}">{{ $p['skor'] }}</span>
                    </div>
                    <div class="h-1.5 bg-white/10 rounded-full overflow-hidden mb-3">
                        <div class="h-full {{ $p['bar'] }} rounded-full" style="width: {{ $p['skor'] }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-400">Kehadiran <span class="{{ $p['hadir_color'] }} font-semibold">{{ $p['kehadiran'] }}%</span></span>
                        <span class="px-2 py-0.5 rounded-full {{ $p['gaya']['badge'] }} font-bold text-[10px]">{{ $p['gaya']['label'] }}</span>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-komdigi-blue/20 text-komdigi-blue hover:bg-komdigi-blue/30 transition">Detail</a>
                        <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $p['id']]) }}" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-white/5 text-slate-300 hover:bg-white/10 transition">Nilai</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('pembimbing.peserta') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-komdigi-blue hover:text-white transition">
                Lihat semua peserta
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    {{-- TWO COL: Logbook Pending + Ringkasan Performa --}}
    <div class="grid lg:grid-cols-2 gap-5">

        {{-- Logbook Menunggu Approval --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-komdigi-dark">Logbook Menunggu</h3>
                        <p class="text-xs text-slate-500">Butuh review & approval</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-100">{{ $ringkasan['logbook_pending'] }}</span>
            </div>

            <div class="space-y-3">
                @forelse ($logbookPending as $lb)
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.04] border border-white/8">
                        <div class="w-9 h-9 rounded-lg {{ $lb['avatar'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $lb['peserta_inisial'] }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ $lb['peserta_nama'] }}</p>
                            <p class="text-[11px] text-slate-400">{{ $lb['minggu_label'] }} • {{ \Illuminate\Support\Str::before($lb['dikirim'], ',') }}</p>
                        </div>
                        <a href="{{ route('pembimbing.logbook') }}" class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 transition">Review</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Tidak ada logbook yang menunggu approval.</p>
                @endforelse
            </div>

            <a href="{{ route('pembimbing.logbook') }}" class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 text-sm font-bold text-komdigi-blue hover:text-white border border-white/10 rounded-2xl hover:bg-white/5 transition">
                Lihat semua logbook
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Ringkasan Performa --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-komdigi-dark">Ringkasan Performa</h3>
                        <p class="text-xs text-slate-500">Rata-rata skor bimbingan</p>
                    </div>
                </div>
                <span class="px-3 py-1.5 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
            </div>
            <div class="h-52">
                <canvas id="perfChart" data-chart='@json($chartPerforma)'></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('pembimbing.peserta') }}" class="glass-card group rounded-3xl p-5 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-sm font-bold text-slate-800">Daftar Peserta</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Kelola peserta</p>
        </a>
        <a href="{{ route('pembimbing.logbook') }}" class="glass-card group rounded-3xl p-5 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-bold text-slate-800">Approval</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Review logbook</p>
        </a>
        <a href="{{ route('pembimbing.penilaianpeserta') }}" class="glass-card group rounded-3xl p-5 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <p class="text-sm font-bold text-slate-800">Penilaian</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Beri nilai peserta</p>
        </a>
        <a href="{{ route('pembimbing.laporanbimbingan') }}" class="glass-card group rounded-3xl p-5 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition">
                <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-bold text-slate-800">Laporan</p>
            <p class="text-[11px] text-slate-500 mt-0.5">Export & rekap</p>
        </a>
    </div>

@endsection

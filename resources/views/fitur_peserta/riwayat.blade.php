@extends('layouts.dashboardUser')

@section('title', 'Riwayat Absen')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Riwayat Absen</h1>
                <p class="text-sm text-blue-100/80 font-medium mt-0.5">Catatan kehadiran selama periode magang</p>
            </div>
            <form method="GET" action="{{ route('peserta.riwayat') }}" class="flex items-center gap-3">
                <select name="bulan" data-action="auto-submit"
                        class="glass px-4 py-2.5 rounded-xl text-sm font-semibold text-white border border-white/10 focus:outline-none focus:ring-2 focus:ring-komdigi-cerulean/50 appearance-none cursor-pointer bg-transparent">
                    @foreach ($bulanOptions as $bulan)
                        <option class="bg-slate-900" value="{{ $bulan }}" @selected($bulan === $bulanAktif)>{{ $bulan }}</option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="btn-shine px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean shadow-md shadow-blue-500/30">Filter</button>
                </noscript>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card rounded-3xl p-5 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-3xl font-black text-emerald-400">{{ $ringkasan['hadir'] }}</p>
                <p class="text-xs font-semibold text-slate-400 mt-1">Hadir</p>
            </div>
            <div class="glass-card rounded-3xl p-5 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-3xl font-black text-amber-400">{{ $ringkasan['terlambat'] }}</p>
                <p class="text-xs font-semibold text-slate-400 mt-1">Terlambat</p>
            </div>
            <div class="glass-card rounded-3xl p-5 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-sky-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-3xl font-black text-sky-400">{{ $ringkasan['izin'] }}</p>
                <p class="text-xs font-semibold text-slate-400 mt-1">Izin</p>
            </div>
            <div class="glass-card rounded-3xl p-5 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-rose-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <p class="text-3xl font-black text-rose-400">{{ $ringkasan['alpha'] }}</p>
                <p class="text-xs font-semibold text-slate-400 mt-1">Alpha</p>
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-2">
            <button type="button" class="filter-btn active px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-white" data-filter="all">Semua</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="hadir">Hadir</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="terlambat">Terlambat</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="izin">Izin</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="alpha">Alpha</button>
        </div>

        <!-- Daftar Kehadiran -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                <h3 class="font-bold text-white">Daftar Kehadiran</h3>
                <span class="text-xs font-medium text-slate-400">{{ $totalTercatat }} hari tercatat</span>
            </div>
            <div class="divide-y divide-white/5" id="attendance-list">
                @forelse ($items as $item)
                    <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="{{ $item['status'] }}">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 rounded-2xl {{ $item['box'] }} flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-bold {{ $item['boxTextSoft'] }} uppercase">{{ $item['bulan'] }}</span>
                                <span class="text-sm font-black {{ $item['boxText'] }}">{{ $item['tgl'] }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white">{{ $item['judul'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-3 py-1 {{ $item['badge'] }} text-[11px] font-bold rounded-full">{{ $item['label'] }}</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-slate-400">Belum ada catatan kehadiran.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@extends('layouts.pembimbing')

@section('title', 'Laporan Bimbingan')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Manajemen Bimbingan</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Laporan Bimbingan</h1>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-right">
                    <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                    <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">11.50.00 WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export & Filter Bar -->
    <div class="glass-card rounded-3xl p-5">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            <div class="flex flex-wrap items-center gap-2.5 flex-1">
                <select id="filterPeriode" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Periode</option>
                    <option value="okt">Oktober 2026</option>
                    <option value="nov" selected>November 2026</option>
                    <option value="des">Desember 2026</option>
                </select>
                <select id="filterStatus" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" data-action="export-pdf" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-rose-600 to-rose-500 rounded-xl shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export PDF
                </button>
                <button type="button" data-action="export-excel" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </button>
            </div>
        </div>
        <p id="exportStatus" class="hidden mt-3 text-xs font-medium text-slate-300"></p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-komdigi-cerulean/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-white">{{ $ringkasan['total'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Total Peserta Bimbingan</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-emerald-400">{{ $ringkasan['rata_skor'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Rata-rata Skor Kinerja</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-amber-400">{{ $ringkasan['rata_kehadiran'] }}%</p>
            <p class="text-xs text-slate-400 mt-1">Rata-rata Kehadiran</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-rose-400">{{ $ringkasan['perhatian'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Perlu Perhatian</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="glass-card rounded-3xl p-5 sm:p-6">
            <h3 class="text-sm font-bold text-white mb-4">Distribusi Skor Kinerja</h3>
            <div class="h-56">
                <canvas id="scoreChart" data-chart='@json($chartDistribusi)'></canvas>
            </div>
        </div>
        <div class="glass-card rounded-3xl p-5 sm:p-6">
            <h3 class="text-sm font-bold text-white mb-4">Tren Rata-rata Skor Mingguan</h3>
            <div class="h-56">
                <canvas id="trendChart" data-chart='@json($chartTren)'></canvas>
            </div>
        </div>
    </div>

    <!-- Rekap Kinerja Table -->
    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="px-5 py-4 border-b border-white/8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-white">Rekap Kinerja Peserta Bimbingan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Data kinerja seluruh peserta yang dibimbing</p>
            </div>
            <p class="text-xs text-slate-400">Periode: <span class="text-white font-semibold">November 2026</span></p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
                        <th class="px-5 py-3.5 font-semibold">Peserta</th>
                        <th class="px-4 py-3.5 font-semibold">ID</th>
                        <th class="px-4 py-3.5 font-semibold text-center">Skor</th>
                        <th class="px-4 py-3.5 font-semibold text-center">Kehadiran</th>
                        <th class="px-4 py-3.5 font-semibold text-center">Logbook</th>
                        <th class="px-4 py-3.5 font-semibold text-center">Penilaian</th>
                        <th class="px-4 py-3.5 font-semibold">Status</th>
                        <th class="px-4 py-3.5 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="rekapTable">
                    @foreach ($peserta as $p)
                        <tr class="table-row {{ $loop->last ? '' : 'border-b border-white/5' }}" data-status="{{ $p['status'] }}" data-periode="nov" data-skor="{{ $p['skor'] }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $p['avatar'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['inisial'] }}</div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $p['institusi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-300 font-medium">{{ $p['id_peserta'] }}</td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-black {{ $p['skor_color'] }}">{{ $p['skor'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold {{ $p['hadir_color'] }}">{{ $p['kehadiran'] }}%</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold {{ $p['logbook_color'] }}">{{ $p['logbook_terisi'] }}/{{ $p['logbook_total'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">{{ $p['jumlah_penilaian'] }}</span></td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $p['gaya']['badge_soft'] }} text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $p['gaya']['dot_soft'] }}"></span> {{ $p['gaya']['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="rekapEmpty" class="hidden">
                        <td colspan="8" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada peserta untuk filter ini.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan Evaluasi -->
    <div class="glass-card rounded-3xl p-5 sm:p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-base font-bold text-white">Ringkasan untuk Evaluasi</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wide mb-2">Kekuatan</p>
                <ul class="space-y-1.5 text-sm text-slate-300">
                    @foreach ($evaluasi['kekuatan'] as $item)
                        <li class="flex items-start gap-2"><span class="text-emerald-400 mt-0.5">•</span> {{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Area Perbaikan</p>
                <ul class="space-y-1.5 text-sm text-slate-300">
                    @foreach ($evaluasi['perbaikan'] as $item)
                        <li class="flex items-start gap-2"><span class="text-amber-400 mt-0.5">•</span> {{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-4 p-4 rounded-2xl bg-komdigi-blue/10 border border-komdigi-cerulean/20">
            <p class="text-xs font-semibold text-komdigi-cerulean uppercase tracking-wide mb-2">Rekomendasi Pembimbing</p>
            <p class="text-sm text-slate-300 leading-relaxed">{{ $evaluasi['rekomendasi'] }}</p>
        </div>
    </div>
@endsection

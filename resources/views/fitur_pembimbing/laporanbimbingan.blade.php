@extends('layouts.pembimbing')

@section('title', 'Laporan Bimbingan')

@section('content')
    <x-page-header eyebrow="Manajemen bimbingan" title="Laporan Bimbingan" description="Rekap aktivitas bimbingan dan ekspor laporan">
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-foreground" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-muted font-medium tabular-nums" id="current-time">11.50.00 WIB</p>
            </div>
        </div>
    </x-page-header>

    <!-- Export & Filter Bar -->
    <div class="glass-card rounded-2xl p-5">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            <div class="flex flex-wrap items-center gap-2.5 flex-1">
                <select id="filterPeriode" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Periode</option>
                    <option value="okt">Oktober 2026</option>
                    <option value="nov" selected>November 2026</option>
                    <option value="des">Desember 2026</option>
                </select>
                <select id="filterStatus" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" data-action="export-pdf" class="ui-button-secondary inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                    <i data-lucide="file" class="w-4 h-4" aria-hidden="true"></i>
                    Export PDF
                </button>
                <button type="button" data-action="export-excel" class="ui-button-secondary inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                    <i data-lucide="file-down" class="w-4 h-4" aria-hidden="true"></i>
                    Export Excel
                </button>
            </div>
        </div>
        <p id="exportStatus" class="hidden mt-3 text-xs font-medium text-foreground"></p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stat-card label="Total Peserta Bimbingan" :value="$ringkasan['total']" icon="users" />
        <x-stat-card label="Rata-rata Skor Kinerja" :value="$ringkasan['rata_skor']" icon="circle-check" />
        <x-stat-card label="Rata-rata Kehadiran" :value="$ringkasan['rata_kehadiran'].'%'" icon="clock-3" />
        <x-stat-card label="Perlu Perhatian" :value="$ringkasan['perhatian']" icon="triangle-alert" />
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="glass-card rounded-2xl p-5 sm:p-6">
            <h3 class="text-sm font-bold text-foreground mb-4">Distribusi Skor Kinerja</h3>
            <div class="h-56">
                <canvas id="scoreChart" data-chart='@json($chartDistribusi)'></canvas>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-5 sm:p-6">
            <h3 class="text-sm font-bold text-foreground mb-4">Tren Rata-rata Skor Mingguan</h3>
            <div class="h-56">
                <canvas id="trendChart" data-chart='@json($chartTren)'></canvas>
            </div>
        </div>
    </div>

    <!-- Rekap Kinerja Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-subtle flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-foreground">Rekap Kinerja Peserta Bimbingan</h3>
                <p class="text-xs text-muted mt-0.5">Data kinerja seluruh peserta yang dibimbing</p>
            </div>
            <p class="text-xs text-muted">Periode: <span class="text-foreground font-semibold">November 2026</span></p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-subtle text-[11px] uppercase tracking-wider text-muted">
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
                        <tr class="table-row {{ $loop->last ? '' : 'border-b border-subtle' }}" data-status="{{ $p['status'] }}" data-periode="nov" data-skor="{{ $p['skor'] }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $p['avatar'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['inisial'] }}</div>
                                    <div>
                                        <p class="text-sm font-bold text-foreground">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-muted">{{ $p['institusi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-foreground font-medium">{{ $p['id_peserta'] }}</td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-black {{ $p['skor_color'] }}">{{ $p['skor'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold {{ $p['hadir_color'] }}">{{ $p['kehadiran'] }}%</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold {{ $p['logbook_color'] }}">{{ $p['logbook_terisi'] }}/{{ $p['logbook_total'] }}</span></td>
                            <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-foreground">{{ $p['jumlah_penilaian'] }}</span></td>
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
                        <td colspan="8" class="px-5 py-10 text-center text-sm text-muted">Tidak ada peserta untuk filter ini.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan Evaluasi -->
    <div class="glass-card rounded-2xl p-5 sm:p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                <i data-lucide="file-text" class="w-4 h-4 text-komdigi-cerulean" aria-hidden="true"></i>
            </div>
            <h3 class="text-base font-bold text-foreground">Ringkasan untuk Evaluasi</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 rounded-2xl bg-surface border border-subtle">
                <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wide mb-2">Kekuatan</p>
                <ul class="space-y-1.5 text-sm text-foreground">
                    @foreach ($evaluasi['kekuatan'] as $item)
                        <li class="flex items-start gap-2"><span class="text-emerald-400 mt-0.5">•</span> {{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="p-4 rounded-2xl bg-surface border border-subtle">
                <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Area Perbaikan</p>
                <ul class="space-y-1.5 text-sm text-foreground">
                    @foreach ($evaluasi['perbaikan'] as $item)
                        <li class="flex items-start gap-2"><span class="text-amber-400 mt-0.5">•</span> {{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-4 p-4 rounded-2xl bg-komdigi-blue/10 border border-komdigi-cerulean/20">
            <p class="text-xs font-semibold text-komdigi-cerulean uppercase tracking-wide mb-2">Rekomendasi Pembimbing</p>
            <p class="text-sm text-foreground leading-relaxed">{{ $evaluasi['rekomendasi'] }}</p>
        </div>
    </div>
@endsection

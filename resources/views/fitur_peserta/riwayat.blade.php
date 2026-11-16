@extends('layouts.dashboardUser')

@section('title', 'Riwayat Absen')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Kehadiran harian" title="Riwayat Absen" description="Catatan kehadiran selama periode magang">
            <form method="GET" action="{{ route('peserta.riwayat') }}" class="flex items-center gap-3">
                <select name="bulan" data-action="auto-submit"
                        class="glass px-4 py-2.5 rounded-xl text-sm font-semibold text-foreground border border-subtle focus:outline-none focus:ring-2 focus:ring-komdigi-cerulean/50 appearance-none cursor-pointer bg-transparent">
                    @foreach ($bulanOptions as $bulan)
                        <option class="bg-surface" value="{{ $bulan }}" @selected($bulan === $bulanAktif)>{{ $bulan }}</option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="ui-button px-4 py-2.5 text-sm">Filter</button>
                </noscript>
            </form>
        </x-page-header>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Hadir" :value="$ringkasan['hadir']" icon="circle-check" />
            <x-stat-card label="Terlambat" :value="$ringkasan['terlambat']" icon="clock-3" />
            <x-stat-card label="Izin" :value="$ringkasan['izin']" icon="calendar-days" />
            <x-stat-card label="Alpha" :value="$ringkasan['alpha']" icon="x" />
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-2">
            <button type="button" class="filter-btn active px-4 py-2 text-sm font-semibold rounded-full border border-subtle text-white" data-filter="all">Semua</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-subtle text-foreground hover:bg-elevated" data-filter="hadir">Hadir</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-subtle text-foreground hover:bg-elevated" data-filter="terlambat">Terlambat</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-subtle text-foreground hover:bg-elevated" data-filter="izin">Izin</button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-subtle text-foreground hover:bg-elevated" data-filter="alpha">Alpha</button>
        </div>

        <!-- Daftar Kehadiran -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle flex items-center justify-between">
                <h3 class="font-bold text-foreground">Daftar Kehadiran</h3>
                <span class="text-xs font-medium text-muted">{{ $totalTercatat }} hari tercatat</span>
            </div>
            <div class="divide-y divide-subtle" id="attendance-list">
                @forelse ($items as $item)
                    <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="{{ $item['status'] }}">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 rounded-2xl {{ $item['box'] }} flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-bold {{ $item['boxTextSoft'] }} uppercase">{{ $item['bulan'] }}</span>
                                <span class="text-sm font-black {{ $item['boxText'] }}">{{ $item['tgl'] }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-foreground">{{ $item['judul'] }}</p>
                                <p class="text-xs text-muted mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-3 py-1 {{ $item['badge'] }} text-[11px] font-bold rounded-full">{{ $item['label'] }}</span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-muted" aria-hidden="true"></i>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-muted">Belum ada catatan kehadiran.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

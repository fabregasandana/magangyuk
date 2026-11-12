@extends('layouts.dashboardUser')

@section('title', 'Grafik Perkembangan')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Grafik Perkembangan</h1>
                <p class="text-sm text-blue-100/80 font-medium mt-0.5">Tren skor kinerja selama periode magang</p>
            </div>
        </div>

        <!-- Chart Card -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white">Skor Kinerja Mingguan</h3>
                        <p class="text-xs text-slate-400">Perkembangan {{ count($chartData['labels']) }} minggu terakhir</p>
                    </div>
                </div>
                <span class="px-3 py-1.5 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">{{ count($chartData['labels']) }} minggu terakhir</span>
            </div>
            <div class="h-72 sm:h-80">
                <canvas id="progressChart" data-chart='@json($chartData)'></canvas>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="glass-card rounded-3xl p-6">
            <h3 class="font-bold text-white mb-5">Ringkasan</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 text-center">
                    <p class="text-xs font-semibold text-slate-400 mb-1">Skor awal</p>
                    <p class="text-2xl font-black text-white">{{ $ringkasan['skor_awal']['nilai'] }}</p>
                    <p class="text-[10px] text-slate-500 mt-1">{{ $ringkasan['skor_awal']['ket'] }}</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 text-center">
                    <p class="text-xs font-semibold text-slate-400 mb-1">Skor saat ini</p>
                    <p class="text-2xl font-black text-komdigi-cerulean">{{ $ringkasan['skor_sekarang']['nilai'] }}</p>
                    <p class="text-[10px] text-slate-500 mt-1">{{ $ringkasan['skor_sekarang']['ket'] }}</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 text-center">
                    <p class="text-xs font-semibold text-slate-400 mb-1">Peningkatan</p>
                    <p class="text-2xl font-black text-emerald-400">{{ $ringkasan['peningkatan']['nilai'] }}</p>
                    <p class="text-[10px] text-emerald-400/80 mt-1">{{ $ringkasan['peningkatan']['ket'] }}</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-4 border border-white/10 text-center">
                    <p class="text-xs font-semibold text-slate-400 mb-1">Rata-rata</p>
                    <p class="text-2xl font-black text-white">{{ $ringkasan['rata_rata']['nilai'] }}</p>
                    <p class="text-[10px] text-slate-500 mt-1">{{ $ringkasan['rata_rata']['ket'] }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Mingguan -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h3 class="font-bold text-white">Detail Mingguan</h3>
            </div>
            <div class="divide-y divide-white/5">
                @foreach ($mingguan as $row)
                    <div class="px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['current'] ? 'bg-emerald-500/20' : 'bg-komdigi-blue/20' }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['current'] ? 'text-emerald-400' : 'text-komdigi-cerulean' }}">{{ $row['minggu'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Minggu {{ $row['minggu'] }}
                                    @if ($row['current'])
                                        <span class="text-emerald-400 text-xs">(saat ini)</span>
                                    @endif
                                </p>
                                <p class="text-xs text-slate-400">{{ $row['rentang'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-24 h-2 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r {{ $row['current'] ? 'from-emerald-500 to-emerald-400' : 'from-komdigi-blue to-komdigi-cerulean' }} rounded-full" style="width: {{ $row['skor'] }}%"></div>
                            </div>
                            <span class="text-sm font-bold {{ $row['current'] ? 'text-emerald-400' : 'text-white' }} w-8 text-right">{{ $row['skor'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

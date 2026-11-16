@extends('layouts.dashboardUser')

@section('title', 'Grafik Perkembangan')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Perkembangan" title="Grafik Perkembangan" description="Tren skor kinerja selama periode magang" />

        <!-- Chart Card -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/20 flex items-center justify-center">
                        <i data-lucide="chart-no-axes-combined" class="w-5 h-5 text-komdigi-cerulean" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-foreground">Skor Kinerja Mingguan</h3>
                        <p class="text-xs text-muted">Perkembangan {{ count($chartData['labels']) }} minggu terakhir</p>
                    </div>
                </div>
                <span class="px-3 py-1.5 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">{{ count($chartData['labels']) }} minggu terakhir</span>
            </div>
            <div class="h-72 sm:h-80">
                <canvas id="progressChart" data-chart='@json($chartData)'></canvas>
            </div>
        </div>

        <!-- Ringkasan -->
        <section class="space-y-3" aria-labelledby="ringkasan-heading">
            <h2 id="ringkasan-heading" class="text-base font-semibold">Ringkasan</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-stat-card label="Skor awal" :value="$ringkasan['skor_awal']['nilai']" icon="target" :caption="$ringkasan['skor_awal']['ket']" />
                <x-stat-card label="Skor saat ini" :value="$ringkasan['skor_sekarang']['nilai']" icon="chart-column" :caption="$ringkasan['skor_sekarang']['ket']" />
                <x-stat-card label="Peningkatan" :value="$ringkasan['peningkatan']['nilai']" icon="trending-up" :caption="$ringkasan['peningkatan']['ket']" />
                <x-stat-card label="Rata-rata" :value="$ringkasan['rata_rata']['nilai']" icon="activity" :caption="$ringkasan['rata_rata']['ket']" />
            </div>
        </section>

        <!-- Detail Mingguan -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle">
                <h3 class="font-bold text-foreground">Detail Mingguan</h3>
            </div>
            <div class="divide-y divide-subtle">
                @foreach ($mingguan as $row)
                    <div class="px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['current'] ? 'bg-emerald-500/20' : 'bg-komdigi-blue/20' }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['current'] ? 'text-emerald-400' : 'text-komdigi-cerulean' }}">{{ $row['minggu'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">Minggu {{ $row['minggu'] }}
                                    @if ($row['current'])
                                        <span class="text-emerald-400 text-xs">(saat ini)</span>
                                    @endif
                                </p>
                                <p class="text-xs text-muted">{{ $row['rentang'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-24 h-2 bg-elevated rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r {{ $row['current'] ? 'from-emerald-500 to-emerald-400' : 'from-komdigi-blue to-komdigi-cerulean' }} rounded-full" style="width: {{ $row['skor'] }}%"></div>
                            </div>
                            <span class="text-sm font-bold {{ $row['current'] ? 'text-emerald-400' : 'text-foreground' }} w-8 text-right">{{ $row['skor'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

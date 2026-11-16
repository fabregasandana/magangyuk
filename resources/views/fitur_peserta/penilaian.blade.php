@extends('layouts.dashboardUser')

@section('title', 'Penilaian Pembimbing')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Evaluasi" title="Penilaian Pembimbing" description="Hasil evaluasi dari pembimbing lapangan" />

        <!-- Overall Score Card -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-1">Nilai keseluruhan</p>
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black text-komdigi-cerulean">{{ $nilai['total'] }}</span>
                        <span class="text-xl font-bold text-muted mb-1">/ 5.0</span>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-xs font-semibold text-muted mb-1">Pembimbing</p>
                    <p class="text-sm font-bold text-foreground">{{ $nilai['pembimbing'] }}</p>
                    <p class="text-xs text-muted mt-0.5">Diperbarui {{ $nilai['diperbarui'] }}</p>
                </div>
            </div>

            <!-- Progress Bars -->
            <div class="space-y-5">
                @foreach ($aspek as $item)
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-foreground">{{ $item['label'] }}</span>
                            <span class="font-bold text-foreground">{{ $item['nilai'] }}</span>
                        </div>
                        <div class="h-2.5 bg-elevated rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r {{ $item['bar'] }} rounded-full" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Komentar Pembimbing -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-5 h-5 text-indigo-400" aria-hidden="true"></i>
                </div>
                <h3 class="font-bold text-foreground">Komentar Pembimbing</h3>
            </div>
            <div class="bg-surface rounded-2xl p-5 border border-subtle">
                <p class="text-sm text-foreground italic leading-relaxed">{{ $komentar['isi'] }}</p>
                <p class="text-xs text-komdigi-cerulean mt-3 font-medium">— {{ $komentar['oleh'] }}</p>
            </div>
        </div>

        <!-- Riwayat Penilaian -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle">
                <h3 class="font-bold text-foreground">Riwayat Penilaian</h3>
            </div>
            <div class="divide-y divide-subtle">
                @foreach ($riwayat as $row)
                    <div class="px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['terbaru'] ? 'bg-emerald-500/20' : 'bg-komdigi-blue/20' }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['terbaru'] ? 'text-emerald-400' : 'text-komdigi-cerulean' }}">{{ $row['nilai'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">{{ $row['judul'] }}</p>
                                <p class="text-xs text-muted">{{ $row['tanggal'] }}</p>
                            </div>
                        </div>
                        @if ($row['terbaru'])
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">{{ $row['badge'] }}</span>
                        @else
                            <span class="px-2.5 py-1 bg-elevated text-muted text-[11px] font-bold rounded-full">{{ $row['badge'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

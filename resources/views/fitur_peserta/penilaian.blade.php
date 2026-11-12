@extends('layouts.dashboardUser')

@section('title', 'Penilaian Pembimbing')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Penilaian Pembimbing</h1>
            <p class="text-sm text-blue-100/80 font-medium mt-0.5">Hasil evaluasi dari pembimbing lapangan</p>
        </div>

        <!-- Overall Score Card -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Nilai keseluruhan</p>
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black text-komdigi-cerulean">{{ $nilai['total'] }}</span>
                        <span class="text-xl font-bold text-slate-400 mb-1">/ 5.0</span>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-xs font-semibold text-slate-400 mb-1">Pembimbing</p>
                    <p class="text-sm font-bold text-white">{{ $nilai['pembimbing'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Diperbarui {{ $nilai['diperbarui'] }}</p>
                </div>
            </div>

            <!-- Progress Bars -->
            <div class="space-y-5">
                @foreach ($aspek as $item)
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-slate-300">{{ $item['label'] }}</span>
                            <span class="font-bold text-white">{{ $item['nilai'] }}</span>
                        </div>
                        <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r {{ $item['bar'] }} rounded-full" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Komentar Pembimbing -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="font-bold text-white">Komentar Pembimbing</h3>
            </div>
            <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                <p class="text-sm text-slate-300 italic leading-relaxed">{{ $komentar['isi'] }}</p>
                <p class="text-xs text-komdigi-cerulean mt-3 font-medium">— {{ $komentar['oleh'] }}</p>
            </div>
        </div>

        <!-- Riwayat Penilaian -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h3 class="font-bold text-white">Riwayat Penilaian</h3>
            </div>
            <div class="divide-y divide-white/5">
                @foreach ($riwayat as $row)
                    <div class="px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['terbaru'] ? 'bg-emerald-500/20' : 'bg-komdigi-blue/20' }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['terbaru'] ? 'text-emerald-400' : 'text-komdigi-cerulean' }}">{{ $row['nilai'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $row['judul'] }}</p>
                                <p class="text-xs text-slate-400">{{ $row['tanggal'] }}</p>
                            </div>
                        </div>
                        @if ($row['terbaru'])
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">{{ $row['badge'] }}</span>
                        @else
                            <span class="px-2.5 py-1 bg-white/10 text-slate-400 text-[11px] font-bold rounded-full">{{ $row['badge'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@extends('layouts.dashboardUser')

@section('title', 'Laporan Akhir')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Laporan Akhir</h1>
            <p class="text-sm text-blue-100/80 font-medium mt-0.5">Status pengumpulan laporan akhir magang</p>
        </div>

        <!-- Status Card -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Status</p>
                    <p class="text-xl font-black text-amber-400">{{ $status['label'] }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 bg-amber-500/20 text-amber-400 text-xs font-bold rounded-full border border-amber-500/30 self-start">
                    {{ $status['badge'] }}
                </span>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white/5 rounded-2xl px-4 py-3 border border-white/10">
                    <p class="text-xs font-medium text-slate-400 mb-0.5">Batas pengumpulan</p>
                    <p class="text-sm font-bold text-white">{{ $status['batas'] }}</p>
                </div>
                <div class="bg-white/5 rounded-2xl px-4 py-3 border border-white/10">
                    <p class="text-xs font-medium text-slate-400 mb-0.5">Sisa waktu</p>
                    <p class="text-sm font-bold text-amber-400">{{ $status['sisa'] }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('peserta.laporan.store') }}">
                @csrf
                <button type="submit" class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Mulai Buat Laporan Akhir
                </button>
            </form>
        </div>

        <!-- Checklist -->
        <div class="glass-card rounded-3xl p-6">
            <h3 class="font-bold text-white mb-5">Checklist</h3>
            <div class="space-y-4">
                @foreach ($checklist as $item)
                    @if ($item['done'])
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-emerald-400">{{ $item['label'] }}
                                @if ($item['detail'])
                                    <span class="text-emerald-300">{{ $item['detail'] }}</span>
                                @endif
                            </span>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center shrink-0 border border-white/15">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                            </div>
                            <span class="text-sm font-medium text-slate-400">{{ $item['label'] }}
                                @if ($item['detail'])
                                    <span class="text-slate-500">{{ $item['detail'] }}</span>
                                @endif
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Laporan Mingguan Terakhir -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h3 class="font-bold text-white">Laporan Mingguan Terakhir</h3>
            </div>
            <div class="divide-y divide-white/5">
                @foreach ($mingguan as $row)
                    @if ($row['done'])
                        <div class="px-5 py-4 flex items-center justify-between hover:bg-white/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-400">{{ $row['nomor'] }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $row['judul'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $row['detail'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">{{ $row['status'] }}</span>
                        </div>
                    @else
                        <div class="px-5 py-4 flex items-center justify-between opacity-60">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                    <span class="text-xs font-bold text-slate-400">{{ $row['nomor'] }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-300">{{ $row['judul'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $row['detail'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-white/10 text-slate-400 text-[11px] font-bold rounded-full">{{ $row['status'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@extends('layouts.dashboardUser')

@section('title', 'Laporan Akhir')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Laporan akhir" title="Laporan Akhir" description="Status pengumpulan laporan akhir magang" />

        <!-- Status Card -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-1">Status</p>
                    <p class="text-xl font-black text-amber-400">{{ $status['label'] }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 bg-amber-500/20 text-amber-400 text-xs font-bold rounded-full border border-amber-500/30 self-start">
                    {{ $status['badge'] }}
                </span>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-surface rounded-2xl px-4 py-3 border border-subtle">
                    <p class="text-xs font-medium text-muted mb-0.5">Batas pengumpulan</p>
                    <p class="text-sm font-bold text-foreground">{{ $status['batas'] }}</p>
                </div>
                <div class="bg-surface rounded-2xl px-4 py-3 border border-subtle">
                    <p class="text-xs font-medium text-muted mb-0.5">Sisa waktu</p>
                    <p class="text-sm font-bold text-amber-400">{{ $status['sisa'] }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('peserta.laporan.store') }}">
                @csrf
                <button type="submit" class="ui-button w-full py-3.5 transition text-sm flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5" aria-hidden="true"></i>
                    Mulai Buat Laporan Akhir
                </button>
            </form>
        </div>

        <!-- Checklist -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="font-bold text-foreground mb-5">Checklist</h3>
            <div class="space-y-4">
                @foreach ($checklist as $item)
                    @if ($item['done'])
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400" aria-hidden="true"></i>
                            </div>
                            <span class="text-sm font-medium text-emerald-400">{{ $item['label'] }}
                                @if ($item['detail'])
                                    <span class="text-emerald-700">{{ $item['detail'] }}</span>
                                @endif
                            </span>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-elevated flex items-center justify-center shrink-0 border border-subtle">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                            </div>
                            <span class="text-sm font-medium text-muted">{{ $item['label'] }}
                                @if ($item['detail'])
                                    <span class="text-muted">{{ $item['detail'] }}</span>
                                @endif
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Laporan Mingguan Terakhir -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle">
                <h3 class="font-bold text-foreground">Laporan Mingguan Terakhir</h3>
            </div>
            <div class="divide-y divide-subtle">
                @foreach ($mingguan as $row)
                    @if ($row['done'])
                        <div class="px-5 py-4 flex items-center justify-between hover:bg-elevated transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-400">{{ $row['nomor'] }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">{{ $row['judul'] }}</p>
                                    <p class="text-xs text-muted">{{ $row['detail'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">{{ $row['status'] }}</span>
                        </div>
                    @else
                        <div class="px-5 py-4 flex items-center justify-between opacity-60">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-elevated flex items-center justify-center">
                                    <span class="text-xs font-bold text-muted">{{ $row['nomor'] }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">{{ $row['judul'] }}</p>
                                    <p class="text-xs text-muted">{{ $row['detail'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-elevated text-muted text-[11px] font-bold rounded-full">{{ $row['status'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

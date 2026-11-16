@extends('layouts.dashboardUser')

@section('title', 'Sertifikat Magang')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Sertifikat" title="Sertifikat Magang" description="Kelengkapan syarat penerbitan sertifikat" />

        <!-- Progress Card -->
        <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-amber-400/10 rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-1">Progress kelengkapan</p>
                        <p class="text-5xl font-black text-amber-400">{{ $progress }}%</p>
                    </div>
                    <div class="w-full sm:w-48">
                        <div class="h-3 bg-elevated rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Certificate Area -->
                <div class="bg-surface rounded-2xl p-6 border border-subtle flex flex-col items-center justify-center text-center">
                    @if ($terkunci)
                        <div class="w-16 h-16 rounded-2xl bg-elevated flex items-center justify-center mb-4 border border-subtle">
                            <i data-lucide="lock-keyhole" class="w-8 h-8 text-amber-400/80" aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-bold text-foreground mb-1">Sertifikat masih terkunci</p>
                        <p class="text-xs text-muted mb-4">Lengkapi semua syarat untuk membuka</p>
                        <button type="button" disabled class="px-5 py-2.5 bg-elevated text-muted text-xs font-bold rounded-xl cursor-not-allowed border border-subtle">
                            Unduh Sertifikat
                        </button>
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 flex items-center justify-center mb-4 border border-emerald-500/30">
                            <i data-lucide="badge-check" class="w-8 h-8 text-emerald-400" aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-bold text-foreground mb-1">Sertifikat siap diunduh</p>
                        <p class="text-xs text-muted mb-4">Semua syarat penerbitan telah terpenuhi</p>
                        <button type="button" class="ui-button px-5 py-2.5 text-white text-xs/30 transition">
                            Unduh Sertifikat
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Syarat Penerbitan -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="font-bold text-foreground mb-5">Syarat Penerbitan</h3>
            <div class="space-y-4">
                @foreach ($syarat as $item)
                    @if ($item['done'])
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-emerald-400">{{ $item['label'] }}</p>
                                <p class="text-xs text-muted mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-elevated flex items-center justify-center shrink-0 mt-0.5 border border-subtle">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-muted">{{ $item['label'] }}</p>
                                <p class="text-xs text-muted mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/20 flex items-center justify-center shrink-0">
                    <i data-lucide="info" class="w-5 h-5 text-komdigi-cerulean" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="font-bold text-foreground mb-1">Informasi Sertifikat</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $info }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

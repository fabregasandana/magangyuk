@extends('layouts.dashboardUser')

@section('title', 'Sertifikat Magang')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Sertifikat Magang</h1>
            <p class="text-sm text-blue-100/80 font-medium mt-0.5">Kelengkapan syarat penerbitan sertifikat</p>
        </div>

        <!-- Progress Card -->
        <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-amber-400/10 rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Progress kelengkapan</p>
                        <p class="text-5xl font-black text-amber-400">{{ $progress }}%</p>
                    </div>
                    <div class="w-full sm:w-48">
                        <div class="h-3 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Certificate Area -->
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10 flex flex-col items-center justify-center text-center">
                    @if ($terkunci)
                        <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-4 border border-white/10">
                            <svg class="w-8 h-8 text-amber-400/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-white mb-1">Sertifikat masih terkunci</p>
                        <p class="text-xs text-slate-400 mb-4">Lengkapi semua syarat untuk membuka</p>
                        <button type="button" disabled class="px-5 py-2.5 bg-white/10 text-slate-500 text-xs font-bold rounded-xl cursor-not-allowed border border-white/10">
                            Unduh Sertifikat
                        </button>
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 flex items-center justify-center mb-4 border border-emerald-500/30">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-white mb-1">Sertifikat siap diunduh</p>
                        <p class="text-xs text-slate-400 mb-4">Semua syarat penerbitan telah terpenuhi</p>
                        <button type="button" class="btn-shine px-5 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                            Unduh Sertifikat
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Syarat Penerbitan -->
        <div class="glass-card rounded-3xl p-6">
            <h3 class="font-bold text-white mb-5">Syarat Penerbitan</h3>
            <div class="space-y-4">
                @foreach ($syarat as $item)
                    @if ($item['done'])
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-emerald-400">{{ $item['label'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center shrink-0 mt-0.5 border border-white/15">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-400">{{ $item['label'] }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-1">Informasi Sertifikat</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ $info }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

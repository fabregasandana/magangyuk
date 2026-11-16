@extends('layouts.dashboardUser')

@section('title', 'Profil Peserta')

@php
    $namaProfil = auth()->check() ? auth()->user()->name : ($peserta['nama'] ?? 'Peserta Magang');
    $idProfil = auth()->check() ? auth()->user()->id : ($peserta['id_peserta'] ?? '—');
    // Email: pakai akun yang login bila ada, fallback ke data dummy controller.
    $emailProfil = auth()->user()?->email ?? ($pribadi['email'] ?? '—');

    $inisialProfil = collect(explode(' ', trim($namaProfil)))
        ->filter()
        ->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
        ->implode('') ?: 'P';
@endphp

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Data pribadi" title="Profil Peserta" description="Data diri dan informasi magang">
            <a href="{{ route('peserta.dashboard') }}" class="ui-button-secondary inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                Kembali ke dashboard
            </a>
        </x-page-header>

        <!-- Profile Header Card -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black/40">
                        {{ $inisialProfil }}
                    </div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-subtle flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-white" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                                <h2 class="text-xl font-black text-foreground">{{ $namaProfil }}</h2>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                    {{ $peserta['status'] }}
                                </span>
                            </div>
                            <p class="text-sm text-muted">ID Peserta: <span class="text-komdigi-cerulean font-semibold">{{ $idProfil }}</span></p>
                            <p class="text-sm text-muted mt-0.5">Peserta Magang · {{ $peserta['unit_kerja'] }}</p>
                        </div>
                        <button type="button" class="px-4 py-2 bg-elevated text-foreground text-sm font-semibold rounded-xl hover:bg-elevated transition border border-subtle">
                            Ubah Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pribadi -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Data Pribadi</h3>
                <button type="button" class="text-sm font-semibold text-komdigi-cerulean hover:text-foreground transition">Edit</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['nama'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">NIM / NIS</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['nim'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['ttl'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['jenis_kelamin'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Email</p>
                    <p class="text-sm font-semibold text-foreground">{{ $emailProfil }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">No. HP / WhatsApp</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['hp'] }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium text-muted mb-1">Alamat</p>
                    <p class="text-sm font-semibold text-foreground">{{ $pribadi['alamat'] }}</p>
                </div>
            </div>
        </div>

        <!-- Data Magang -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Data Magang</h3>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Institusi</p>
                    <p class="text-sm font-semibold text-foreground">{{ $magang['institusi'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Program Studi</p>
                    <p class="text-sm font-semibold text-foreground">{{ $magang['prodi'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Unit Kerja</p>
                    <p class="text-sm font-semibold text-foreground">{{ $magang['unit_kerja'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Pembimbing</p>
                    <p class="text-sm font-semibold text-foreground">{{ $magang['pembimbing'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Periode Magang</p>
                    <p class="text-sm font-semibold text-foreground">{{ $magang['periode'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted mb-1">Status</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/30">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        {{ $magang['status'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

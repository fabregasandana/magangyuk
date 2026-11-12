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
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Profil Peserta</h1>
                <p class="text-sm text-blue-100/80 font-medium mt-0.5">Data diri dan informasi magang</p>
            </div>
            <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-komdigi-cerulean hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Profile Header Card -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/40">
                        {{ $inisialProfil }}
                    </div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-slate-900 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                                <h2 class="text-xl font-black text-white">{{ $namaProfil }}</h2>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                    {{ $peserta['status'] }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-400">ID Peserta: <span class="text-komdigi-cerulean font-semibold">{{ $idProfil }}</span></p>
                            <p class="text-sm text-slate-400 mt-0.5">Peserta Magang · {{ $peserta['unit_kerja'] }}</p>
                        </div>
                        <button type="button" class="px-4 py-2 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 transition border border-white/10">
                            Ubah Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pribadi -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Data Pribadi</h3>
                <button type="button" class="text-sm font-semibold text-komdigi-cerulean hover:text-white transition">Edit</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['nama'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">NIM / NIS</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['nim'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['ttl'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['jenis_kelamin'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Email</p>
                    <p class="text-sm font-semibold text-white">{{ $emailProfil }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">No. HP / WhatsApp</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['hp'] }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium text-slate-400 mb-1">Alamat</p>
                    <p class="text-sm font-semibold text-white">{{ $pribadi['alamat'] }}</p>
                </div>
            </div>
        </div>

        <!-- Data Magang -->
        <div class="glass-card rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-white">Data Magang</h3>
            </div>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Institusi</p>
                    <p class="text-sm font-semibold text-white">{{ $magang['institusi'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Program Studi</p>
                    <p class="text-sm font-semibold text-white">{{ $magang['prodi'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Unit Kerja</p>
                    <p class="text-sm font-semibold text-white">{{ $magang['unit_kerja'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Pembimbing</p>
                    <p class="text-sm font-semibold text-white">{{ $magang['pembimbing'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Periode Magang</p>
                    <p class="text-sm font-semibold text-white">{{ $magang['periode'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 mb-1">Status</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/30">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        {{ $magang['status'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

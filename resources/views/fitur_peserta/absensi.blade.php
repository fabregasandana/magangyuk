@extends('layouts.dashboardUser')
@section('title', 'Absensi')
@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Title -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Absensi</h1>
                <p class="text-sm text-blue-100/80 font-medium mt-0.5">Catat kehadiran harian magang Anda</p>
            </div>
            <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-right">
                    <p class="text-sm font-bold text-white" id="current-date">—</p>
                    <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">—</p>
                </div>
            </div>
        </div>

        <!-- Status Hari Ini -->
        <div class="relative overflow-hidden rounded-3xl glass-card">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-komdigi-blue/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-komdigi-cerulean/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4">
            </div>
            <div class="relative p-6 sm:p-7">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-blue-100/80 text-sm font-medium mb-1">Status Hari Ini</p>
                        <div class="flex items-center gap-2.5">
                            <span id="status-badge"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/90 text-amber-900 text-xs font-bold rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 bg-amber-900 rounded-full animate-pulse"></span>
                                {{ $absenHariIni['status'] }}
                            </span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-blue-100/70 text-xs font-medium">Jam kerja</p>
                        <p class="text-white text-sm font-bold">{{ $areaAbsensi['jam_kerja'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Masuk</p>
                        <p class="text-white text-xl font-black" id="time-masuk">{{ $absenHariIni['masuk'] ?? '—' }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Pulang</p>
                        <p class="text-white text-xl font-black" id="time-pulang">{{ $absenHariIni['pulang'] ?? '—' }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Durasi</p>
                        <p class="text-white text-xl font-black" id="time-durasi">{{ $absenHariIni['durasi'] ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Absen -->
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="glass-card rounded-3xl p-6 text-center">
                <div class="relative inline-flex mb-4">
                    <div class="absolute inset-0 bg-komdigi-blue/30 rounded-full pulse-ring"></div>
                    <div
                        class="relative w-20 h-20 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white shadow-lg shadow-blue-500/40">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-bold text-white text-lg mb-1">Absen Masuk</h3>
                <p class="text-sm text-slate-400 mb-5">Wajib selfie + lokasi dalam radius</p>
                <button type="button" data-action="absen-open" data-jenis="masuk" id="btn-masuk"
                    class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm cursor-pointer">
                    Absen Masuk Sekarang
                </button>
            </div>
            <div class="glass-card rounded-3xl p-6 text-center {{ $absenHariIni['masuk'] ? '' : 'opacity-60' }}"
                id="card-pulang">
                <div class="relative inline-flex mb-4">
                    <div
                        class="relative w-20 h-20 rounded-full bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white shadow-lg">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-bold text-white text-lg mb-1">Absen Pulang</h3>
                <p class="text-sm text-slate-400 mb-5">Tersedia setelah absen masuk</p>
                <button type="button" data-action="absen-open" data-jenis="pulang" id="btn-pulang"
                    @disabled(! $absenHariIni['masuk'])
                    class="w-full py-3.5 text-sm font-bold rounded-2xl {{ $absenHariIni['masuk'] ? 'btn-shine bg-gradient-to-r from-komdigi-dark to-komdigi-blue text-white shadow-lg shadow-blue-500/30 hover:shadow-xl transition cursor-pointer' : 'bg-white/10 text-slate-400 cursor-not-allowed border border-white/10' }}">
                    {{ $absenHariIni['masuk'] ? 'Absen Pulang Sekarang' : 'Belum Bisa Absen Pulang' }}
                </button>
            </div>
        </div>

        <!-- Info Lokasi & Syarat -->
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                    <h3 class="font-bold text-white">Area Absensi</h3>
                    <span
                        class="px-2.5 py-1 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">{{ $areaAbsensi['hari_kerja'] }}</span>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-sm text-slate-400 font-medium shrink-0">Lokasi</span>
                        <span class="text-sm font-semibold text-slate-200 text-right">{{ $areaAbsensi['lokasi'] }}</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Alamat</span>
                        <span class="text-sm font-semibold text-slate-200 text-right">{{ $areaAbsensi['alamat'] }}</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Radius</span>
                        <span class="text-sm font-semibold text-komdigi-cerulean">{{ $areaAbsensi['radius'] }}</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Status Lokasi</span>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            {{ $areaAbsensi['status_lokasi'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-5 py-4 border-b border-white/10">
                    <h3 class="font-bold text-white">Syarat Absensi</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    @foreach ($syarat as $item)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $item['ok'] ? 'bg-emerald-500/20' : 'bg-amber-500/20' }}">
                                @if ($item['ok'])
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-200">{{ $item['judul'] }}</p>
                                <p class="text-xs text-slate-400">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Riwayat Minggu Ini -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                <h3 class="font-bold text-white">Riwayat Minggu Ini</h3>
                <a href="{{ route('peserta.riwayat') }}"
                    class="text-sm font-semibold text-komdigi-cerulean hover:text-white transition">Lihat
                    semua →</a>
            </div>
            <div class="divide-y divide-white/5">
                @foreach ($riwayatMinggu as $row)
                    <div
                        class="px-5 py-3.5 flex items-center justify-between hover:bg-white/5 transition {{ $row['future'] ? 'opacity-50' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['box'] }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['boxText'] }}">{{ $row['hari'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold {{ $row['future'] ? 'text-slate-400' : 'text-slate-200' }}">
                                    {{ $row['tanggal'] }}
                                    @if ($row['hariIni'])
                                        <span class="text-komdigi-cerulean text-xs font-bold">(Hari ini)</span>
                                    @endif
                                </p>
                                <p class="text-xs {{ $row['future'] ? 'text-slate-500' : 'text-slate-400' }}">{{ $row['detail'] }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $row['badge'] }}">{{ $row['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Absen -->
    <div id="modal-absen" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-action="absen-close"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" id="modal-title">Absen Masuk</h3>
                    <button type="button" data-action="absen-close"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition cursor-pointer">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div
                    class="relative aspect-[4/3] bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl mb-5 overflow-hidden flex items-center justify-center border border-white/10">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-white/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-300">Kamera siap</p>
                        <p class="text-xs text-slate-500 mt-0.5">Posisikan wajah di dalam frame</p>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-40 h-48 border-2 border-dashed border-komdigi-cerulean/50 rounded-full"></div>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 px-3 py-2.5 bg-emerald-500/15 rounded-xl mb-5 border border-emerald-500/20">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-xs font-semibold text-emerald-300">Lokasi terverifikasi · Dalam radius {{ $areaAbsensi['radius'] }}</p>
                </div>
                <form method="POST" action="{{ route('peserta.absen.store') }}" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="jenis" value="masuk">
                    <button type="button" data-action="absen-close"
                        class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm cursor-pointer">Ambil
                        & Kirim</button>
                </form>
            </div>
        </div>
    </div>
@endsection

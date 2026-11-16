@extends('layouts.dashboardUser')
@section('title', 'Absensi')
@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Kehadiran harian" title="Absensi" description="Catat kehadiran harian magang Anda">
            <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-right">
                    <p class="text-sm font-bold text-foreground" id="current-date">—</p>
                    <p class="text-xs text-muted font-medium tabular-nums" id="current-time">—</p>
                </div>
            </div>
        </x-page-header>

        <!-- Status Hari Ini -->
        <div class="relative overflow-hidden rounded-2xl glass-card">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-komdigi-blue/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-komdigi-cerulean/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4">
            </div>
            <div class="relative p-6 sm:p-7">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <p class="text-muted text-sm font-medium mb-1">Status Hari Ini</p>
                        <div class="flex items-center gap-2.5">
                            <span id="status-badge"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/90 text-amber-900 text-xs font-bold rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 bg-amber-900 rounded-full animate-pulse"></span>
                                {{ $absenHariIni['status'] }}
                            </span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-muted text-xs font-medium">Jam kerja</p>
                        <p class="text-foreground text-sm font-bold">{{ $areaAbsensi['jam_kerja'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-elevated backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-subtle">
                        <p class="text-muted text-xs font-medium mb-1">Masuk</p>
                        <p class="text-foreground text-xl font-black" id="time-masuk">{{ $absenHariIni['masuk'] ?? '—' }}</p>
                    </div>
                    <div class="bg-elevated backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-subtle">
                        <p class="text-muted text-xs font-medium mb-1">Pulang</p>
                        <p class="text-foreground text-xl font-black" id="time-pulang">{{ $absenHariIni['pulang'] ?? '—' }}</p>
                    </div>
                    <div class="bg-elevated backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-subtle">
                        <p class="text-muted text-xs font-medium mb-1">Durasi</p>
                        <p class="text-foreground text-xl font-black" id="time-durasi">{{ $absenHariIni['durasi'] ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Absen -->
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="glass-card rounded-2xl p-6 text-center">
                <div class="relative inline-flex mb-4">
                    <div class="absolute inset-0 bg-komdigi-blue/30 rounded-full pulse-ring"></div>
                    <div
                        class="relative w-20 h-20 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white">
                        <i data-lucide="log-in" class="w-9 h-9" aria-hidden="true"></i>
                    </div>
                </div>
                <h3 class="font-bold text-foreground text-lg mb-1">Absen Masuk</h3>
                <p class="text-sm text-muted mb-5">Wajib selfie + lokasi dalam radius</p>
                <button type="button" data-action="absen-open" data-jenis="masuk" id="btn-masuk"
                    class="ui-button w-full py-3.5 transition text-sm cursor-pointer">
                    Absen Masuk Sekarang
                </button>
            </div>
            <div class="glass-card rounded-2xl p-6 text-center {{ $absenHariIni['masuk'] ? '' : 'opacity-60' }}"
                id="card-pulang">
                <div class="relative inline-flex mb-4">
                    <div
                        class="relative w-20 h-20 rounded-full bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white shadow-lg">
                        <i data-lucide="log-out" class="w-9 h-9" aria-hidden="true"></i>
                    </div>
                </div>
                <h3 class="font-bold text-foreground text-lg mb-1">Absen Pulang</h3>
                <p class="text-sm text-muted mb-5">Tersedia setelah absen masuk</p>
                <button type="button" data-action="absen-open" data-jenis="pulang" id="btn-pulang"
                    @disabled(! $absenHariIni['masuk'])
                    class="w-full py-3.5 text-sm {{ $absenHariIni['masuk'] ? 'ui-button transition cursor-pointer' : 'bg-elevated text-muted cursor-not-allowed border border-subtle' }}">
                    {{ $absenHariIni['masuk'] ? 'Absen Pulang Sekarang' : 'Belum Bisa Absen Pulang' }}
                </button>
            </div>
        </div>

        <!-- Info Lokasi & Syarat -->
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-subtle flex items-center justify-between">
                    <h3 class="font-bold text-foreground">Area Absensi</h3>
                    <span
                        class="px-2.5 py-1 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">{{ $areaAbsensi['hari_kerja'] }}</span>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-sm text-muted font-medium shrink-0">Lokasi</span>
                        <span class="text-sm font-semibold text-foreground text-right">{{ $areaAbsensi['lokasi'] }}</span>
                    </div>
                    <div class="h-px bg-elevated"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-muted font-medium">Alamat</span>
                        <span class="text-sm font-semibold text-foreground text-right">{{ $areaAbsensi['alamat'] }}</span>
                    </div>
                    <div class="h-px bg-elevated"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-muted font-medium">Radius</span>
                        <span class="text-sm font-semibold text-komdigi-cerulean">{{ $areaAbsensi['radius'] }}</span>
                    </div>
                    <div class="h-px bg-elevated"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-muted font-medium">Status Lokasi</span>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            {{ $areaAbsensi['status_lokasi'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-subtle">
                    <h3 class="font-bold text-foreground">Syarat Absensi</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    @foreach ($syarat as $item)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $item['ok'] ? 'bg-emerald-500/20' : 'bg-amber-500/20' }}">
                                @if ($item['ok'])
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-400" aria-hidden="true"></i>
                                @else
                                    <i data-lucide="clock-3" class="w-4 h-4 text-amber-400" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-foreground">{{ $item['judul'] }}</p>
                                <p class="text-xs text-muted">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Riwayat Minggu Ini -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle flex items-center justify-between">
                <h3 class="font-bold text-foreground">Riwayat Minggu Ini</h3>
                <a href="{{ route('peserta.riwayat') }}"
                    class="text-sm font-semibold text-komdigi-cerulean hover:text-foreground transition">Lihat
                    semua <i data-lucide="arrow-right" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></a>
            </div>
            <div class="divide-y divide-subtle">
                @foreach ($riwayatMinggu as $row)
                    <div
                        class="px-5 py-3.5 flex items-center justify-between hover:bg-elevated transition {{ $row['future'] ? 'opacity-50' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $row['box'] }} flex items-center justify-center">
                                <span class="text-xs font-bold {{ $row['boxText'] }}">{{ $row['hari'] }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold {{ $row['future'] ? 'text-muted' : 'text-foreground' }}">
                                    {{ $row['tanggal'] }}
                                    @if ($row['hariIni'])
                                        <span class="text-komdigi-cerulean text-xs font-bold">(Hari ini)</span>
                                    @endif
                                </p>
                                <p class="text-xs {{ $row['future'] ? 'text-muted' : 'text-muted' }}">{{ $row['detail'] }}</p>
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
        <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-subtle">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-foreground" id="modal-title">Absen Masuk</h3>
                    <button type="button" data-action="absen-close"
                        class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                    </button>
                </div>
                <div
                    class="relative aspect-[4/3] bg-gradient-to-br from-surface to-elevated rounded-2xl mb-5 overflow-hidden flex items-center justify-center border border-subtle">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-elevated flex items-center justify-center">
                            <i data-lucide="camera" class="w-8 h-8 text-muted" aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-semibold text-foreground">Kamera siap</p>
                        <p class="text-xs text-muted mt-0.5">Posisikan wajah di dalam frame</p>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-40 h-48 border-2 border-dashed border-komdigi-cerulean/50 rounded-full"></div>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 px-3 py-2.5 bg-emerald-500/15 rounded-xl mb-5 border border-emerald-500/20">
                    <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400 shrink-0" aria-hidden="true"></i>
                    <p class="text-xs font-semibold text-emerald-700">Lokasi terverifikasi · Dalam radius {{ $areaAbsensi['radius'] }}</p>
                </div>
                <form method="POST" action="{{ route('peserta.absen.store') }}" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="jenis" value="masuk">
                    <button type="button" data-action="absen-close"
                        class="flex-1 py-3 ui-button-secondary text-sm cursor-pointer">Batal</button>
                    <button type="submit"
                        class="ui-button flex-1 py-3 text-sm cursor-pointer">Ambil
                        & Kirim</button>
                </form>
            </div>
        </div>
    </div>
@endsection

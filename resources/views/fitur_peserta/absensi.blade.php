@extends('layouts.dashboardUser')
@section('title', 'Absensi')
@section('absensi')
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
                    <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                    <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.27.00 WIB</p>
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
                                Belum Absen
                            </span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-blue-100/70 text-xs font-medium">Jam kerja</p>
                        <p class="text-white text-sm font-bold">08.00 – 16.00 WIB</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Masuk</p>
                        <p class="text-white text-xl font-black" id="time-masuk">—</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Pulang</p>
                        <p class="text-white text-xl font-black" id="time-pulang">—</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3.5 text-center border border-white/10">
                        <p class="text-blue-100/80 text-xs font-medium mb-1">Durasi</p>
                        <p class="text-white text-xl font-black" id="time-durasi">—</p>
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
                <button onclick="handleAbsen('masuk')" id="btn-masuk"
                    class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm">
                    Absen Masuk Sekarang
                </button>
            </div>
            <div class="glass-card rounded-3xl p-6 text-center opacity-60" id="card-pulang">
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
                <button id="btn-pulang" disabled
                    class="w-full py-3.5 bg-white/10 text-slate-400 font-bold rounded-2xl cursor-not-allowed text-sm border border-white/10">
                    Belum Bisa Absen Pulang
                </button>
            </div>
        </div>

        <!-- Info Lokasi & Syarat -->
        <div class="grid sm:grid-cols-2 gap-5">
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                    <h3 class="font-bold text-white">Area Absensi</h3>
                    <span
                        class="px-2.5 py-1 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">Senin–Kamis</span>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-sm text-slate-400 font-medium shrink-0">Lokasi</span>
                        <span class="text-sm font-semibold text-slate-200 text-right">Dinas Kominfo Provinsi Sumatera
                            Utara</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Alamat</span>
                        <span class="text-sm font-semibold text-slate-200 text-right">Jl. HM. Said No.27, Medan</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Radius</span>
                        <span class="text-sm font-semibold text-komdigi-cerulean">2000 meter</span>
                    </div>
                    <div class="h-px bg-white/10"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400 font-medium">Status Lokasi</span>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            Dalam jangkauan
                        </span>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-5 py-4 border-b border-white/10">
                    <h3 class="font-bold text-white">Syarat Absensi</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">Lokasi GPS aktif</p>
                            <p class="text-xs text-slate-400">Harus berada dalam radius 2000m</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">Selfie wajah</p>
                            <p class="text-xs text-slate-400">Foto wajah jelas, tanpa masker</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">Hari kerja aktif</p>
                            <p class="text-xs text-slate-400">Senin – Kamis (hari ini valid)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">Jam masuk ideal</p>
                            <p class="text-xs text-slate-400">Sebelum 08.15 (toleransi 15 menit)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Minggu Ini -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                <h3 class="font-bold text-white">Riwayat Minggu Ini</h3>
                <a href="#" class="text-sm font-semibold text-komdigi-cerulean hover:text-white transition">Lihat
                    semua →</a>
            </div>
            <div class="divide-y divide-white/5">
                <div class="px-5 py-3.5 flex items-center justify-between hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                            <span class="text-xs font-bold text-emerald-400">SEN</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">3 November 2026</p>
                            <p class="text-xs text-slate-400">Masuk 07.58 · Pulang 16.05</p>
                        </div>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
                </div>
                <div class="px-5 py-3.5 flex items-center justify-between hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                            <span class="text-xs font-bold text-amber-400">SEL</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">4 November 2026</p>
                            <p class="text-xs text-slate-400">Masuk 08.22 · Pulang 16.10</p>
                        </div>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-amber-500/20 text-amber-400 text-[11px] font-bold rounded-full border border-amber-500/30">Terlambat</span>
                </div>
                <div class="px-5 py-3.5 flex items-center justify-between hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                            <span class="text-xs font-bold text-komdigi-cerulean">RAB</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">5 November 2026 <span
                                    class="text-komdigi-cerulean text-xs font-bold">(Hari ini)</span></p>
                            <p class="text-xs text-slate-400">Belum absen</p>
                        </div>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-white/10 text-slate-400 text-[11px] font-bold rounded-full border border-white/10">Menunggu</span>
                </div>
                <div class="px-5 py-3.5 flex items-center justify-between opacity-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center">
                            <span class="text-xs font-bold text-slate-500">KAM</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-400">6 November 2026</p>
                            <p class="text-xs text-slate-500">Belum dimulai</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-white/5 text-slate-500 text-[11px] font-bold rounded-full">—</span>
                </div>
            </div>
        </div>

        <!-- Mobile Bottom Nav -->
        <div
            class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-white/10 px-4 py-2.5 flex justify-around z-40">
            <a href="dashboard.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="absensi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
                <div class="w-8 h-8 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-semibold">Absen</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>
        <div class="h-20 lg:hidden"></div>
    </div>

    <!-- Modal Absen -->
    <div id="modal-absen" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" id="modal-title">Absen Masuk</h3>
                    <button onclick="closeModal()"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
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
                    <p class="text-xs font-semibold text-emerald-300">Lokasi terverifikasi · Dalam radius 2000m</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeModal()"
                        class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="confirmAbsen()"
                        class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Ambil
                        & Kirim</button>
                </div>
            </div>
        </div>
    </div>
@endsection

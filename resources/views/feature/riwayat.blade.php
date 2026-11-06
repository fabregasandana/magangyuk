<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen | Magang Komdigi 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'komdigi-blue': '#0055FF',
                        'komdigi-dark': '#00336C',
                        'komdigi-cerulean': '#0093DD',
                        'komdigi-gold': '#FFB700',
                        'komdigi-red': '#C41E3A',
                        'komdigi-light': '#E8F1FF',
                        'komdigi-soft': '#E0EDFF',
                        'komdigi-mid': '#C5DBFF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { overflow-x: hidden; }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -12px rgba(0, 51, 108, 0.12);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50/40 to-slate-50 font-sans text-gray-800 antialiased min-h-screen">
    @include('layouts.header')
    <div class="flex min-h-[calc(100vh-80px)]">
        @include('layouts.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto space-y-5">

        <!-- Page Title -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Riwayat Absen</h1>
                <p class="text-sm text-gray-500 mt-0.5">Catatan kehadiran selama periode magang</p>
            </div>
            <div class="flex items-center gap-2">
                <select id="filter-bulan" class="px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 outline-none focus:border-komdigi-blue focus:ring-2 focus:ring-komdigi-blue/20 transition">
                    <option value="2026-11">November 2026</option>
                    <option value="2026-10">Oktober 2026</option>
                    <option value="2026-09">September 2026</option>
                </select>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center">
                <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-black text-emerald-600">22</p>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">Hadir</p>
            </div>
            <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center">
                <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-black text-amber-500">3</p>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">Terlambat</p>
            </div>
            <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center">
                <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-2xl font-black text-komdigi-blue">1</p>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">Izin</p>
            </div>
            <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center">
                <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-red-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <p class="text-2xl font-black text-red-500">0</p>
                <p class="text-xs font-semibold text-gray-500 mt-0.5">Alpha</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2">
            <button class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold bg-white border border-gray-200 text-gray-600 transition" data-filter="semua">Semua</button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-white border border-gray-200 text-gray-600 transition" data-filter="hadir">Hadir</button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-white border border-gray-200 text-gray-600 transition" data-filter="terlambat">Terlambat</button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-white border border-gray-200 text-gray-600 transition" data-filter="izin">Izin</button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-white border border-gray-200 text-gray-600 transition" data-filter="alpha">Alpha</button>
        </div>

        <!-- Daftar Riwayat -->
        <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Daftar Kehadiran</h3>
                <span class="text-xs font-semibold text-gray-400">26 hari tercatat</span>
            </div>

            <div class="divide-y divide-gray-50" id="riwayat-list">

                <!-- Item: Hadir -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="hadir">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-emerald-600 leading-none">NOV</span>
                            <span class="text-lg font-black text-emerald-700 leading-none">03</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Senin, 3 November 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Masuk <strong class="text-gray-700">07.58</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Pulang <strong class="text-gray-700">16.05</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Durasi <strong class="text-gray-700">8j 7m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">Hadir</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Item: Terlambat -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="terlambat">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-amber-600 leading-none">NOV</span>
                            <span class="text-lg font-black text-amber-700 leading-none">04</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Selasa, 4 November 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Masuk <strong class="text-amber-600">08.22</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Pulang <strong class="text-gray-700">16.10</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Durasi <strong class="text-gray-700">7j 48m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">Terlambat</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Item: Hari ini - Belum -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="menunggu">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-komdigi-blue leading-none">NOV</span>
                            <span class="text-lg font-black text-komdigi-blue leading-none">05</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Rabu, 5 November 2026 <span class="text-komdigi-blue text-xs font-bold">(Hari ini)</span></p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-400">Belum absen masuk</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[11px] font-bold rounded-full">Menunggu</span>
                        <a href="absensi-komdigi.html" class="w-8 h-8 rounded-lg bg-komdigi-light hover:bg-blue-100 flex items-center justify-center transition" title="Absen sekarang">
                            <svg class="w-4 h-4 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Item: Izin -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="izin">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-blue-500 leading-none">OKT</span>
                            <span class="text-lg font-black text-blue-600 leading-none">31</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Jumat, 31 Oktober 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Izin sakit · Disetujui pembimbing</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[11px] font-bold rounded-full">Izin</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Item: Hadir -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="hadir">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-emerald-600 leading-none">OKT</span>
                            <span class="text-lg font-black text-emerald-700 leading-none">30</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Kamis, 30 Oktober 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Masuk <strong class="text-gray-700">07.55</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Pulang <strong class="text-gray-700">16.00</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Durasi <strong class="text-gray-700">8j 5m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">Hadir</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Item: Terlambat -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="terlambat">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-amber-600 leading-none">OKT</span>
                            <span class="text-lg font-black text-amber-700 leading-none">29</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Rabu, 29 Oktober 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Masuk <strong class="text-amber-600">08.18</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Pulang <strong class="text-gray-700">16.02</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Durasi <strong class="text-gray-700">7j 44m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">Terlambat</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Item: Hadir -->
                <div class="riwayat-item px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-blue-50/40 transition" data-status="hadir">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold text-emerald-600 leading-none">OKT</span>
                            <span class="text-lg font-black text-emerald-700 leading-none">28</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Selasa, 28 Oktober 2026</p>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                <span class="text-xs text-gray-500">Masuk <strong class="text-gray-700">07.50</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Pulang <strong class="text-gray-700">16.08</strong></span>
                                <span class="text-xs text-gray-300">·</span>
                                <span class="text-xs text-gray-500">Durasi <strong class="text-gray-700">8j 18m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:pl-0 pl-[60px]">
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">Hadir</span>
                        <button class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition" title="Detail">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Load more -->
            <div class="px-5 py-4 border-t border-gray-100 text-center">
                <button class="text-sm font-semibold text-komdigi-blue hover:text-komdigi-dark transition">
                    Muat lebih banyak →
                </button>
            </div>
        </div>

        <!-- Mobile Bottom Nav -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 flex justify-around z-40 shadow-lg">
            <a href="dashboard-komdigi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="absensi-komdigi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-medium">Absen</span>
            </a>
            <a href="riwayat-absen-komdigi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-semibold">Riwayat</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>
        <div class="h-16 lg:hidden"></div>

            </div><!-- end max-w-5xl -->
        </main>
    </div><!-- end flex layout -->
</body>
</html>
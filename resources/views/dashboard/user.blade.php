<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Magang Komdigi 2026</title>
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
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 51, 108, 0.15);
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
            transition: 0.5s;
        }
        .btn-shine:hover::after { left: 120%; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50/40 to-slate-50 font-sans text-gray-800 antialiased min-h-screen">

    <!-- TOP BAR - Floating Rounded Navbar (sama seperti landing page) -->
    <header class="sticky top-0 z-50 pt-4 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between gap-3 px-3 sm:px-4 py-2.5 bg-white/90 backdrop-blur-xl rounded-full shadow-lg shadow-black/5 border border-white/80">
                
                <!-- Logo -->
                <div class="flex items-center gap-2.5 shrink-0 pl-1">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl blur opacity-50"></div>
                        <div class="relative w-9 h-9 bg-gradient-to-br from-komdigi-blue via-komdigi-cerulean to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-md">
                            K
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-extrabold text-komdigi-dark text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-bold bg-gradient-to-r from-komdigi-cerulean to-komdigi-gold bg-clip-text text-transparent">2026</div>
                    </div>
                </div>

                <!-- Nav Links -->
                <nav class="hidden lg:flex items-center gap-0.5">
                    <a href="#" class="px-3.5 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-sm">Beranda</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Absen</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Riwayat</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Profil</a>
                </nav>

                <!-- User + Buttons -->
                <div class="flex items-center gap-2 shrink-0">
                    <div class="hidden sm:flex items-center gap-2 pr-1">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-[11px] font-bold shadow-md">
                            NR
                        </div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-gray-800 leading-tight">Nisa Ramadani</div>
                            <div class="text-[10px] text-gray-500">Peserta Magang</div>
                        </div>
                    </div>
                    <a href="login-komdigi.html" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md">
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-80px)]">
    @include('layouts.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto space-y-5">

                <!-- Welcome Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Selamat datang kembali,</p>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Nisa Ramadani 👋</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800" id="current-date">Rabu, 4 November 2026</p>
                            <p class="text-xs text-gray-500 font-medium tabular-nums" id="current-time">09.28.46 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- RINGKASAN ATAS: Kehadiran + Skor + Status + Logbook -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Ringkasan Kehadiran -->
                    <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 col-span-2 lg:col-span-1">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-3">Ringkasan Kehadiran</p>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="text-center">
                                <p class="text-xl font-black text-emerald-600">22</p>
                                <p class="text-[10px] font-semibold text-gray-500 mt-0.5">Hadir</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-black text-amber-500">3</p>
                                <p class="text-[10px] font-semibold text-gray-500 mt-0.5">Terlambat</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-black text-blue-500">1</p>
                                <p class="text-[10px] font-semibold text-gray-500 mt-0.5">Izin</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-black text-red-500">0</p>
                                <p class="text-[10px] font-semibold text-gray-500 mt-0.5">Alpha</p>
                            </div>
                        </div>
                    </div>

                    <!-- Skor Kinerja -->
                    <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-2">Skor Kinerja</p>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.5" fill="none" stroke="#E5E7EB" stroke-width="3"/>
                                <circle cx="18" cy="18" r="15.5" fill="none" stroke="url(#scoreGrad)" stroke-width="3" stroke-dasharray="85 100" stroke-linecap="round"/>
                                <defs>
                                    <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#0055FF"/>
                                        <stop offset="100%" stop-color="#0093DD"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-lg font-black text-komdigi-blue">85</span>
                            </div>
                        </div>
                        <p class="text-[10px] font-semibold text-emerald-600 mt-1">Baik</p>
                    </div>

                    <!-- Status Magang -->
                    <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-2">Status Magang</p>
                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-1.5">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Aktif</span>
                        <p class="text-[10px] text-gray-400 mt-1">Berjalan lancar</p>
                    </div>

                    <!-- Logbook Pending -->
                    <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-2">Logbook</p>
                        <div class="flex items-end gap-3">
                            <div class="text-center">
                                <p class="text-2xl font-black text-amber-500">2</p>
                                <p class="text-[10px] font-semibold text-gray-500">Belum isi</p>
                            </div>
                            <div class="w-px h-8 bg-gray-200"></div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-komdigi-blue">1</p>
                                <p class="text-[10px] font-semibold text-gray-500">Menunggu</p>
                            </div>
                        </div>
                        <a href="#" class="text-[11px] font-semibold text-komdigi-blue hover:underline mt-2">Isi logbook →</a>
                    </div>
                </div>

                <!-- 4 FEATURE CARDS -->
                <div class="grid sm:grid-cols-2 gap-4">

                    <!-- 1. Status Magang Detail -->
                    <div class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-komdigi-blue/10 to-transparent rounded-bl-full"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900">Detail Magang</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">Aktif</span>
                            </div>
                            <div class="space-y-2.5">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Periode</span>
                                    <span class="font-semibold text-gray-800">1 Okt – 19 Des 2026</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Unit Kerja</span>
                                    <span class="font-semibold text-gray-800">Dinas Kominfo Sumut</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Pembimbing</span>
                                    <span class="font-semibold text-gray-800">Budi Santoso, S.Kom</span>
                                </div>
                                <div class="pt-2">
                                    <div class="flex justify-between text-xs font-semibold text-gray-500 mb-1.5">
                                        <span>Progress Periode</span>
                                        <span class="text-komdigi-blue">42%</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width: 42%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Absensi Hari Ini -->
                    <div class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-amber-400/10 to-transparent rounded-bl-full"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-md shadow-amber-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900">Absensi Hari Ini</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                    Belum absen
                                </span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="bg-blue-50 rounded-xl p-3 text-center">
                                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Masuk</p>
                                    <p class="text-sm font-bold text-gray-800">—</p>
                                </div>
                                <div class="bg-blue-50 rounded-xl p-3 text-center">
                                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Pulang</p>
                                    <p class="text-sm font-bold text-gray-800">—</p>
                                </div>
                                <div class="bg-blue-50 rounded-xl p-3 text-center">
                                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Durasi</p>
                                    <p class="text-sm font-bold text-gray-800">—</p>
                                </div>
                            </div>
                            <a href="#" class="btn-shine flex items-center justify-center gap-2 w-full py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Absen Masuk Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- 3. Laporan Terakhir -->
                    <div class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-400/10 to-transparent rounded-bl-full"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900">Laporan Terakhir</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 text-[11px] font-bold rounded-full">Disetujui</span>
                            </div>
                            <div class="space-y-2.5">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 leading-snug">Laporan Mingguan Minggu ke-5</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Dikirim 28 Oktober 2026</p>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Diperiksa oleh Budi Santoso, S.Kom</span>
                                </div>
                                <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-komdigi-blue hover:text-komdigi-dark transition mt-1">
                                    Lihat laporan
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Progress Sertifikat -->
                    <div class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-komdigi-gold/15 to-transparent rounded-bl-full"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-komdigi-gold to-amber-500 flex items-center justify-center text-white shadow-md shadow-amber-500/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900">Progress Sertifikat</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">68%</span>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-xs font-semibold text-gray-500 mb-1.5">
                                        <span>Kelengkapan syarat</span>
                                        <span class="text-komdigi-gold">68%</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-komdigi-gold to-amber-400 rounded-full" style="width: 68%"></div>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2 text-xs">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-gray-600">Absensi minimal 80%</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-gray-600">Laporan mingguan (5/8)</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs">
                                        <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-gray-400">Laporan akhir</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs">
                                        <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-gray-400">Penilaian pembimbing</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="#" class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center hover:border-blue-200">
                        <div class="w-11 h-11 mx-auto mb-2.5 rounded-xl bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-800">Riwayat</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Catatan kehadiran</p>
                    </a>
                    <a href="#" class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center hover:border-blue-200">
                        <div class="w-11 h-11 mx-auto mb-2.5 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-800">Laporan</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Harian & mingguan</p>
                    </a>
                    <a href="#" class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center hover:border-blue-200">
                        <div class="w-11 h-11 mx-auto mb-2.5 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-800">Izin / Sakit</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Ajukan ketidakhadiran</p>
                    </a>
                    <a href="#" class="card-hover bg-white rounded-2xl border border-blue-100/80 shadow-sm p-4 text-center hover:border-blue-200">
                        <div class="w-11 h-11 mx-auto mb-2.5 rounded-xl bg-pink-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-gray-800">Profil</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Data peserta</p>
                    </a>
                </div>

                <!-- Area Absensi -->
                <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Area Absensi</h3>
                        <span class="px-2.5 py-1 bg-komdigi-light text-komdigi-blue text-[11px] font-bold rounded-full">Senin–Kamis</span>
                    </div>
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-medium">Lokasi</span>
                            <span class="text-sm font-semibold text-gray-800 text-right">Dinas Kominfo Provinsi Sumatera Utara</span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-medium">Radius</span>
                            <span class="text-sm font-semibold text-gray-800">2000 meter</span>
                        </div>
                    </div>
                </div>

                <!-- Mobile Bottom Nav -->
                <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 flex justify-around z-40 shadow-lg">
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-[10px] font-semibold">Beranda</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-medium">Absen</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-medium">Riwayat</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="text-[10px] font-medium">Profil</span>
                    </a>
                </div>

                <div class="h-16 lg:hidden"></div>
            </div>
        </main>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const dateStr = `${dayName}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const timeStr = `${h}.${m}.${s} WIB`;
            
            document.getElementById('current-date').textContent = dateStr;
            document.getElementById('current-time').textContent = timeStr;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>
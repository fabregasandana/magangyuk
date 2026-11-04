<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi | Magang Komdigi 2026</title>
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
        .pulse-ring {
            animation: pulse-ring 2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(1.4); opacity: 0; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50/40 to-slate-50 font-sans text-gray-800 antialiased min-h-screen">

    <!-- FLOATING ROUNDED NAVBAR -->
    <header class="sticky top-0 z-50 pt-4 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between gap-3 px-3 sm:px-4 py-2.5 bg-white/90 backdrop-blur-xl rounded-full shadow-lg shadow-black/5 border border-white/80">
                
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

                <nav class="hidden lg:flex items-center gap-0.5">
                    <a href="dashboard-komdigi.html" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Beranda</a>
                    <a href="absensi-komdigi.html" class="px-3.5 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-sm">Absen</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Riwayat</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                    <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Profil</a>
                </nav>

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
        <!-- MAIN -->
        <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-5">


            <!-- Page Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Absensi</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Catat kehadiran harian magang Anda</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800" id="current-date">Rabu, 4 November 2026</p>
                    <p class="text-xs text-gray-500 font-medium tabular-nums" id="current-time">11.58.00 WIB</p>
                </div>
            </div>

            <!-- Status Hari Ini -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-komdigi-dark via-komdigi-blue to-komdigi-cerulean shadow-xl shadow-blue-500/20">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-komdigi-gold/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
                
                <div class="relative p-6 sm:p-7">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Status Hari Ini</p>
                            <div class="flex items-center gap-2.5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/90 text-amber-900 text-xs font-bold rounded-full shadow-sm">
                                    <span class="w-1.5 h-1.5 bg-amber-900 rounded-full animate-pulse"></span>
                                    Belum Absen
                                </span>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-blue-100/80 text-xs font-medium">Jam kerja</p>
                            <p class="text-white text-sm font-bold">08.00 – 16.00 WIB</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-white/15 backdrop-blur rounded-xl px-4 py-3.5 text-center border border-white/10">
                            <p class="text-blue-100 text-xs font-medium mb-1">Masuk</p>
                            <p class="text-white text-xl font-black" id="time-masuk">—</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur rounded-xl px-4 py-3.5 text-center border border-white/10">
                            <p class="text-blue-100 text-xs font-medium mb-1">Pulang</p>
                            <p class="text-white text-xl font-black" id="time-pulang">—</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur rounded-xl px-4 py-3.5 text-center border border-white/10">
                            <p class="text-blue-100 text-xs font-medium mb-1">Durasi</p>
                            <p class="text-white text-xl font-black" id="time-durasi">—</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Absen -->
            <div class="grid sm:grid-cols-2 gap-4">
                <!-- Absen Masuk -->
                <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-6 text-center">
                    <div class="relative inline-flex mb-4">
                        <div class="absolute inset-0 bg-komdigi-blue/30 rounded-full pulse-ring"></div>
                        <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-1">Absen Masuk</h3>
                    <p class="text-sm text-gray-500 mb-5">Wajib selfie + lokasi dalam radius</p>
                    <button onclick="handleAbsen('masuk')" id="btn-masuk" class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm">
                        Absen Masuk Sekarang
                    </button>
                </div>

                <!-- Absen Pulang -->
                <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm p-6 text-center opacity-60">
                    <div class="relative inline-flex mb-4">
                        <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-1">Absen Pulang</h3>
                    <p class="text-sm text-gray-500 mb-5">Tersedia setelah absen masuk</p>
                    <button id="btn-pulang" disabled class="w-full py-3.5 bg-gray-200 text-gray-500 font-bold rounded-xl cursor-not-allowed text-sm">
                        Belum Bisa Absen Pulang
                    </button>
                </div>
            </div>

            <!-- Info Lokasi & Syarat -->
            <div class="grid sm:grid-cols-2 gap-4">
                <!-- Area Absensi -->
                <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Area Absensi</h3>
                        <span class="px-2.5 py-1 bg-komdigi-light text-komdigi-blue text-[11px] font-bold rounded-full">Senin–Kamis</span>
                    </div>
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <span class="text-sm text-gray-500 font-medium shrink-0">Lokasi</span>
                            <span class="text-sm font-semibold text-gray-800 text-right">Dinas Kominfo Provinsi Sumatera Utara</span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-medium">Alamat</span>
                            <span class="text-sm font-semibold text-gray-800 text-right">Jl. HM. Said No.27, Medan</span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-medium">Radius</span>
                            <span class="text-sm font-semibold text-gray-800">2000 meter</span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 font-medium">Status Lokasi</span>
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-600">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                Dalam jangkauan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Syarat Absensi -->
                <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Syarat Absensi</h3>
                    </div>
                    <div class="px-5 py-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Lokasi GPS aktif</p>
                                <p class="text-xs text-gray-500">Harus berada dalam radius 2000m</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Selfie wajah</p>
                                <p class="text-xs text-gray-500">Foto wajah jelas, tanpa masker</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Hari kerja aktif</p>
                                <p class="text-xs text-gray-500">Senin – Kamis (hari ini valid)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Jam masuk ideal</p>
                                <p class="text-xs text-gray-500">Sebelum 08.15 (toleransi 15 menit)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Absensi Minggu Ini -->
            <div class="bg-white rounded-2xl border border-blue-100/80 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900">Riwayat Minggu Ini</h3>
                    <a href="#" class="text-sm font-semibold text-komdigi-blue hover:text-komdigi-dark transition">Lihat semua →</a>
                </div>
                <div class="divide-y divide-gray-50">
                    <!-- Senin -->
                    <div class="px-5 py-3.5 flex items-center justify-between hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <span class="text-xs font-bold text-emerald-600">SEN</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">3 November 2026</p>
                                <p class="text-xs text-gray-500">Masuk 07.58 · Pulang 16.05</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">Hadir</span>
                    </div>
                    <!-- Selasa -->
                    <div class="px-5 py-3.5 flex items-center justify-between hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                <span class="text-xs font-bold text-amber-600">SEL</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">4 November 2026</p>
                                <p class="text-xs text-gray-500">Masuk 08.22 · Pulang 16.10</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">Terlambat</span>
                    </div>
                    <!-- Rabu (hari ini) -->
                    <div class="px-5 py-3.5 flex items-center justify-between hover:bg-blue-50/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                <span class="text-xs font-bold text-komdigi-blue">RAB</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">5 November 2026 <span class="text-komdigi-blue text-xs font-bold">(Hari ini)</span></p>
                                <p class="text-xs text-gray-500">Belum absen</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[11px] font-bold rounded-full">Menunggu</span>
                    </div>
                    <!-- Kamis -->
                    <div class="px-5 py-3.5 flex items-center justify-between opacity-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center">
                                <span class="text-xs font-bold text-gray-400">KAM</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500">6 November 2026</p>
                                <p class="text-xs text-gray-400">Belum dimulai</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-gray-50 text-gray-400 text-[11px] font-bold rounded-full">—</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Bottom Nav -->
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 flex justify-around z-40 shadow-lg">
                <a href="dashboard-komdigi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>
                <a href="absensi-komdigi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[10px] font-semibold">Absen</span>
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
        </main>
    </div>

    <!-- Modal Absen (Selfie + Konfirmasi) -->
    <div id="modal-absen" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-gray-900" id="modal-title">Absen Masuk</h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Camera Preview Placeholder -->
                <div class="relative aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl mb-5 overflow-hidden flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-white/80 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">Kamera siap</p>
                        <p class="text-xs text-gray-400 mt-0.5">Posisikan wajah di dalam frame</p>
                    </div>
                    <!-- Face guide -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-40 h-48 border-2 border-dashed border-komdigi-blue/40 rounded-full"></div>
                    </div>
                </div>

                <!-- Location info -->
                <div class="flex items-center gap-2 px-3 py-2.5 bg-emerald-50 rounded-xl mb-5">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-xs font-semibold text-emerald-700">Lokasi terverifikasi · Dalam radius 2000m</p>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition text-sm">
                        Batal
                    </button>
                    <button onclick="confirmAbsen()" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">
                        Ambil & Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let absenType = 'masuk';
        let sudahMasuk = false;

        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            document.getElementById('current-date').textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${h}.${m}.${s} WIB`;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        function handleAbsen(type) {
            absenType = type;
            document.getElementById('modal-title').textContent = type === 'masuk' ? 'Absen Masuk' : 'Absen Pulang';
            document.getElementById('modal-absen').classList.remove('hidden');
            document.getElementById('modal-absen').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal-absen').classList.add('hidden');
            document.getElementById('modal-absen').classList.remove('flex');
        }

        function confirmAbsen() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const timeStr = `${h}.${m}`;

            if (absenType === 'masuk') {
                document.getElementById('time-masuk').textContent = timeStr;
                sudahMasuk = true;

                // Enable pulang button
                const btnPulang = document.getElementById('btn-pulang');
                btnPulang.disabled = false;
                btnPulang.className = 'btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-dark to-komdigi-blue text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm';
                btnPulang.textContent = 'Absen Pulang Sekarang';
                btnPulang.onclick = () => handleAbsen('pulang');

                // Update masuk card parent opacity
                btnPulang.closest('.bg-white').classList.remove('opacity-60');

                // Disable masuk button
                const btnMasuk = document.getElementById('btn-masuk');
                btnMasuk.disabled = true;
                btnMasuk.className = 'w-full py-3.5 bg-emerald-100 text-emerald-700 font-bold rounded-xl cursor-default text-sm';
                btnMasuk.textContent = '✓ Sudah Absen Masuk';

                // Update status badge
                document.querySelector('.bg-amber-400\\/90')?.classList.replace('bg-amber-400/90', 'bg-emerald-400/90');
            } else {
                document.getElementById('time-pulang').textContent = timeStr;
                // Calculate duration
                const masukText = document.getElementById('time-masuk').textContent;
                if (masukText !== '—') {
                    const [mh, mm] = masukText.split('.').map(Number);
                    const masukMin = mh * 60 + mm;
                    const pulangMin = now.getHours() * 60 + now.getMinutes();
                    const diff = pulangMin - masukMin;
                    const dh = Math.floor(diff / 60);
                    const dm = diff % 60;
                    document.getElementById('time-durasi').textContent = `${dh}j ${dm}m`;
                }
                const btnPulang = document.getElementById('btn-pulang');
                btnPulang.disabled = true;
                btnPulang.className = 'w-full py-3.5 bg-emerald-100 text-emerald-700 font-bold rounded-xl cursor-default text-sm';
                btnPulang.textContent = '✓ Sudah Absen Pulang';
            }

            closeModal();
        }
    </script>
</body>
</html>
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
                        'komdigi-navy': '#001B3D',
                        'komdigi-soft': '#E0EDFF',
                        'komdigi-light': '#F0F7FF',
                        'komdigi-mid': '#B8D4FF',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            overflow-x: hidden;
            background: linear-gradient(160deg, #001B3D 0%, #00336C 28%, #0055FF 65%, #0093DD 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse 90% 60% at 10% 20%, rgba(0, 147, 221, 0.35) 0%, transparent 55%),
                radial-gradient(ellipse 70% 50% at 90% 10%, rgba(0, 85, 255, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse 60% 40% at 50% 90%, rgba(0, 51, 108, 0.4) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        .glass {
            background: rgba(15, 23, 42, 0.32);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        }
        .glass-strong {
            background: rgba(15, 23, 42, 0.38);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.26);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(125, 211, 252, 0.45);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.14),
                0 0 14px rgba(56, 189, 248, 0.4),
                0 0 32px rgba(0, 147, 221, 0.32),
                0 0 56px rgba(0, 85, 255, 0.18),
                0 6px 24px rgba(0, 0, 0, 0.16),
                inset 0 1px 1px rgba(255, 255, 255, 0.2),
                inset 0 -1px 1px rgba(56, 189, 248, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #e2e8f0;
        }
        .glass-card:hover {
            background: rgba(15, 23, 42, 0.42);
            border-color: rgba(125, 211, 252, 0.75);
            transform: translateY(-3px);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.22),
                0 0 18px rgba(56, 189, 248, 0.6),
                0 0 40px rgba(0, 147, 221, 0.45),
                0 0 70px rgba(0, 85, 255, 0.25),
                0 12px 36px rgba(0, 0, 0, 0.22),
                inset 0 1px 1px rgba(255, 255, 255, 0.28),
                inset 0 -1px 1px rgba(56, 189, 248, 0.15);
        }
        .glass-panel {
            background: rgba(8, 12, 24, 0.35);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(125, 211, 252, 0.28);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.08),
                0 0 24px rgba(0, 147, 221, 0.22),
                0 0 48px rgba(0, 85, 255, 0.1),
                0 12px 48px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.12);
            border-radius: 1.5rem;
        }
        .glass-sidebar {
            background: rgba(8, 12, 24, 0.35);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 68px;
            transition: width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            z-index: 40;
        }
        .glass-sidebar::-webkit-scrollbar { display: none; }
        .glass-sidebar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-sidebar:hover { width: 228px; background: rgba(8, 12, 24, 0.5); }
        .glass-sidebar .sidebar-label {
            opacity: 0; white-space: nowrap; transition: opacity 0.18s ease 0.04s;
            pointer-events: none; font-size: 0.8125rem; letter-spacing: 0.01em;
        }
        .glass-sidebar:hover .sidebar-label { opacity: 1; pointer-events: auto; }
        .glass-sidebar .sidebar-section-title {
            opacity: 0; max-height: 0; margin: 0; padding: 0; overflow: hidden; transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-section-title {
            opacity: 1; max-height: 2rem; margin-bottom: 0.75rem; padding: 0 0.5rem;
        }
        .glass-sidebar .sidebar-footer-text {
            opacity: 0; max-width: 0; overflow: hidden; transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-footer-text { opacity: 1; max-width: 150px; }
        .glass-card h2, .glass-card h3, .glass-card .font-black, .glass-card .font-bold { color: #f8fafc !important; }
        .glass-card .text-slate-500, .glass-card .text-slate-400, .glass-card .text-gray-500 { color: #94a3b8 !important; }
        .glass-card .text-slate-700, .glass-card .text-slate-800, .glass-card .text-gray-800, .glass-card .text-gray-900, .glass-card .text-komdigi-dark { color: #e2e8f0 !important; }
        .glass-card .bg-blue-50, .glass-card .bg-emerald-50, .glass-card .bg-amber-50, .glass-card .bg-white, .glass-card .bg-gray-50, .glass-card .bg-gray-100 {
            background: rgba(255, 255, 255, 0.06) !important; border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .border-blue-100, .glass-card .border-emerald-100, .glass-card .border-amber-100, .glass-card .border-gray-100 { border-color: rgba(255, 255, 255, 0.08) !important; }
        .glass-card .bg-emerald-100 { background: rgba(16, 185, 129, 0.2) !important; }
        .glass-card .text-emerald-700 { color: #6ee7b7 !important; }
        .glass-card .bg-amber-100 { background: rgba(245, 158, 11, 0.2) !important; }
        .glass-card .text-amber-700 { color: #fcd34d !important; }
        .glass-card .text-komdigi-blue, .glass-card .text-komdigi-cerulean { color: #38bdf8 !important; }
        .glass-card .border-b, .glass-card .h-px { border-color: rgba(255, 255, 255, 0.08) !important; background: rgba(255, 255, 255, 0.08) !important; }
        .glass-strong .text-slate-800, .glass .text-slate-800 { color: #f1f5f9 !important; }
        .glass-strong .text-slate-600, .glass .text-slate-600, .glass-strong .text-slate-500, .glass .text-slate-500 { color: #94a3b8 !important; }
        .glass-strong .text-komdigi-dark, .glass .text-komdigi-dark { color: #f8fafc !important; }
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent); transition: 0.5s;
        }
        .btn-shine:hover::after { left: 120%; }
        .sidebar-link {
            transition: all 0.2s ease; color: rgba(186, 198, 214, 0.95); font-weight: 500;
            display: flex; align-items: center; gap: 0.7rem; padding: 0.55rem 0.7rem;
            border-radius: 0.7rem; position: relative; margin: 0 0.2rem;
        }
        .sidebar-link:hover { background: rgba(255, 255, 255, 0.07); color: #f8fafc; }
        .sidebar-link.active { background: rgba(0, 147, 221, 0.18); color: #ffffff; font-weight: 600; }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 55%; background: #38bdf8; border-radius: 0 3px 3px 0;
        }
        .sidebar-link .sidebar-icon {
            width: 1.85rem; height: 1.85rem; border-radius: 0.5rem; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
            background: rgba(255, 255, 255, 0.05); transition: background 0.2s ease;
        }
        .sidebar-link:hover .sidebar-icon { background: rgba(255, 255, 255, 0.1); }
        .sidebar-link.active .sidebar-icon { background: rgba(0, 147, 221, 0.3); }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(1.4); opacity: 0; }
        }
    </style>
</head>
<body class="font-sans text-slate-800 antialiased">

    <!-- TOP BAR -->
    <header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
        <div class="w-full">
            <div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">
                <div class="flex items-center gap-3 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-komdigi-blue rounded-xl blur-md opacity-40"></div>
                        <div class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">K</div>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-extrabold text-komdigi-dark text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Digital Generation</div>
                    </div>
                </div>
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard.html" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Beranda</a>
                    <a href="absensi.html" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Absen</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Riwayat</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Profil</a>
                </nav>
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white shadow-md">NR</div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-slate-800 leading-tight">Nisa Ramadani</div>
                            <div class="text-[10px] text-emerald-600 font-medium">● Online</div>
                        </div>
                    </div>
                    <a href="login-komdigi.html" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md">Keluar</a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">
        <!-- SIDEBAR -->
        <aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
            <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Utama</p>
                <nav class="space-y-0.5" id="sidebar-nav">
                    <a href="dashboard.html" class="sidebar-link text-sm" title="Beranda">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="absensi.html" class="sidebar-link active text-sm" title="Absen">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <span class="sidebar-label">Absen</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Riwayat">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <span class="sidebar-label">Riwayat</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Grafik">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg></div>
                        <span class="sidebar-label">Grafik Perkembangan</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Penilaian">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                        <span class="sidebar-label">Penilaian & Feedback</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Laporan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan Akhir</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Sertifikat">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg></div>
                        <span class="sidebar-label">Sertifikat</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Izin">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="sidebar-label">Ajukan Ketidakhadiran</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Profil">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        <span class="sidebar-label">Profil</span>
                    </a>
                </nav>
            </div>
            <div class="p-2 border-t border-white/8">
                <div class="rounded-xl p-2 border border-white/8 bg-white/[0.03]">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/15 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="sidebar-footer-text min-w-0">
                            <p class="text-[10px] font-semibold text-blue-200/70">Periode Magang</p>
                            <p class="text-xs font-bold text-white truncate">Okt – Des 2026</p>
                            <div class="mt-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width: 42%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
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
                    <div class="absolute top-0 right-0 w-64 h-64 bg-komdigi-blue/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-komdigi-cerulean/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
                    <div class="relative p-6 sm:p-7">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <p class="text-blue-100/80 text-sm font-medium mb-1">Status Hari Ini</p>
                                <div class="flex items-center gap-2.5">
                                    <span id="status-badge" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-400/90 text-amber-900 text-xs font-bold rounded-full shadow-sm">
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
                            <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white shadow-lg shadow-blue-500/40">
                                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-white text-lg mb-1">Absen Masuk</h3>
                        <p class="text-sm text-slate-400 mb-5">Wajib selfie + lokasi dalam radius</p>
                        <button onclick="handleAbsen('masuk')" id="btn-masuk" class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm">
                            Absen Masuk Sekarang
                        </button>
                    </div>
                    <div class="glass-card rounded-3xl p-6 text-center opacity-60" id="card-pulang">
                        <div class="relative inline-flex mb-4">
                            <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white shadow-lg">
                                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-white text-lg mb-1">Absen Pulang</h3>
                        <p class="text-sm text-slate-400 mb-5">Tersedia setelah absen masuk</p>
                        <button id="btn-pulang" disabled class="w-full py-3.5 bg-white/10 text-slate-400 font-bold rounded-2xl cursor-not-allowed text-sm border border-white/10">
                            Belum Bisa Absen Pulang
                        </button>
                    </div>
                </div>

                <!-- Info Lokasi & Syarat -->
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="glass-card rounded-3xl overflow-hidden">
                        <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                            <h3 class="font-bold text-white">Area Absensi</h3>
                            <span class="px-2.5 py-1 bg-komdigi-blue/20 text-komdigi-cerulean text-[11px] font-bold rounded-full border border-komdigi-blue/30">Senin–Kamis</span>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <span class="text-sm text-slate-400 font-medium shrink-0">Lokasi</span>
                                <span class="text-sm font-semibold text-slate-200 text-right">Dinas Kominfo Provinsi Sumatera Utara</span>
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
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-200">Lokasi GPS aktif</p>
                                    <p class="text-xs text-slate-400">Harus berada dalam radius 2000m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-200">Selfie wajah</p>
                                    <p class="text-xs text-slate-400">Foto wajah jelas, tanpa masker</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-200">Hari kerja aktif</p>
                                    <p class="text-xs text-slate-400">Senin – Kamis (hari ini valid)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                        <a href="#" class="text-sm font-semibold text-komdigi-cerulean hover:text-white transition">Lihat semua →</a>
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
                            <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
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
                            <span class="px-2.5 py-1 bg-amber-500/20 text-amber-400 text-[11px] font-bold rounded-full border border-amber-500/30">Terlambat</span>
                        </div>
                        <div class="px-5 py-3.5 flex items-center justify-between hover:bg-white/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                                    <span class="text-xs font-bold text-komdigi-cerulean">RAB</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-200">5 November 2026 <span class="text-komdigi-cerulean text-xs font-bold">(Hari ini)</span></p>
                                    <p class="text-xs text-slate-400">Belum absen</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-white/10 text-slate-400 text-[11px] font-bold rounded-full border border-white/10">Menunggu</span>
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
                <div class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-white/10 px-4 py-2.5 flex justify-around z-40">
                    <a href="dashboard.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Beranda</span>
                    </a>
                    <a href="absensi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
                        <div class="w-8 h-8 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold">Absen</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Riwayat</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Profil</span>
                    </a>
                </div>
                <div class="h-20 lg:hidden"></div>
            </div>
        </main>
    </div>

    <!-- Modal Absen -->
    <div id="modal-absen" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" id="modal-title">Absen Masuk</h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="relative aspect-[4/3] bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl mb-5 overflow-hidden flex items-center justify-center border border-white/10">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-white/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-300">Kamera siap</p>
                        <p class="text-xs text-slate-500 mt-0.5">Posisikan wajah di dalam frame</p>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-40 h-48 border-2 border-dashed border-komdigi-cerulean/50 rounded-full"></div>
                    </div>
                </div>
                <div class="flex items-center gap-2 px-3 py-2.5 bg-emerald-500/15 rounded-xl mb-5 border border-emerald-500/20">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-xs font-semibold text-emerald-300">Lokasi terverifikasi · Dalam radius 2000m</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="confirmAbsen()" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Ambil & Kirim</button>
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
                const btnPulang = document.getElementById('btn-pulang');
                btnPulang.disabled = false;
                btnPulang.className = 'btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-dark to-komdigi-blue text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm';
                btnPulang.textContent = 'Absen Pulang Sekarang';
                btnPulang.onclick = () => handleAbsen('pulang');
                document.getElementById('card-pulang').classList.remove('opacity-60');
                const btnMasuk = document.getElementById('btn-masuk');
                btnMasuk.disabled = true;
                btnMasuk.className = 'w-full py-3.5 bg-emerald-500/20 text-emerald-300 font-bold rounded-2xl cursor-default text-sm border border-emerald-500/30';
                btnMasuk.textContent = '✓ Sudah Absen Masuk';
                const badge = document.getElementById('status-badge');
                if (badge) {
                    badge.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/90 text-emerald-900 text-xs font-bold rounded-full shadow-sm';
                    badge.innerHTML = '<span class="w-1.5 h-1.5 bg-emerald-900 rounded-full"></span> Sudah Absen Masuk';
                }
            } else {
                document.getElementById('time-pulang').textContent = timeStr;
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
                btnPulang.className = 'w-full py-3.5 bg-emerald-500/20 text-emerald-300 font-bold rounded-2xl cursor-default text-sm border border-emerald-500/30';
                btnPulang.textContent = '✓ Sudah Absen Pulang';
            }
            closeModal();
        }

        document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>

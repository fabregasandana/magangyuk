<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta | Magang Komdigi 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .glass-sidebar:hover {
            width: 240px;
            background: rgba(8, 12, 24, 0.5);
        }
        .glass-sidebar .sidebar-label {
            opacity: 0;
            white-space: nowrap;
            transition: opacity 0.18s ease 0.04s;
            pointer-events: none;
            font-size: 0.8125rem;
            letter-spacing: 0.01em;
        }
        .glass-sidebar:hover .sidebar-label {
            opacity: 1;
            pointer-events: auto;
        }
        .glass-sidebar .sidebar-section-title {
            opacity: 0;
            max-height: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-section-title {
            opacity: 1;
            max-height: 2rem;
            margin-bottom: 0.75rem;
            padding: 0 0.5rem;
        }
        .glass-sidebar .sidebar-footer-text {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-footer-text {
            opacity: 1;
            max-width: 160px;
        }

        .glass-card h2,
        .glass-card h3,
        .glass-card .font-black,
        .glass-card .font-bold {
            color: #f8fafc !important;
        }
        .glass-card .text-slate-500,
        .glass-card .text-slate-400 {
            color: #94a3b8 !important;
        }
        .glass-card .text-slate-700,
        .glass-card .text-slate-800,
        .glass-card .text-komdigi-dark {
            color: #e2e8f0 !important;
        }
        .glass-card .bg-blue-50,
        .glass-card .bg-blue-50\/80,
        .glass-card .bg-blue-50\/60,
        .glass-card .bg-emerald-50,
        .glass-card .bg-amber-50,
        .glass-card .bg-indigo-50,
        .glass-card .bg-sky-50,
        .glass-card .bg-slate-50,
        .glass-card .bg-slate-100,
        .glass-card .bg-white,
        .glass-card .bg-rose-50 {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .border-blue-100,
        .glass-card .border-emerald-100,
        .glass-card .border-amber-100,
        .glass-card .border-slate-200,
        .glass-card .border-white,
        .glass-card .border-rose-100 {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .bg-emerald-100 { background: rgba(16, 185, 129, 0.2) !important; }
        .glass-card .text-emerald-700 { color: #6ee7b7 !important; }
        .glass-card .bg-amber-100 { background: rgba(245, 158, 11, 0.2) !important; }
        .glass-card .text-amber-700 { color: #fcd34d !important; }
        .glass-card .bg-blue-100 { background: rgba(0, 147, 221, 0.2) !important; }
        .glass-card .bg-rose-100 { background: rgba(244, 63, 94, 0.2) !important; }
        .glass-card .text-rose-700 { color: #fda4af !important; }
        .glass-card .text-komdigi-blue { color: #38bdf8 !important; }
        .glass-card .text-komdigi-cerulean { color: #38bdf8 !important; }
        .glass-card .border-b { border-color: rgba(255, 255, 255, 0.08) !important; }
        .glass-card .h-px { background: rgba(255, 255, 255, 0.08) !important; }

        .glass-strong .text-slate-800,
        .glass .text-slate-800 {
            color: #f1f5f9 !important;
        }
        .glass-strong .text-slate-600,
        .glass .text-slate-600,
        .glass-strong .text-slate-500,
        .glass .text-slate-500 {
            color: #94a3b8 !important;
        }
        .glass-strong .text-komdigi-dark,
        .glass .text-komdigi-dark {
            color: #f8fafc !important;
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

        .sidebar-link {
            transition: all 0.2s ease;
            color: rgba(186, 198, 214, 0.95);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.55rem 0.7rem;
            border-radius: 0.7rem;
            position: relative;
            margin: 0 0.2rem;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #f8fafc;
        }
        .sidebar-link.active {
            background: rgba(0, 147, 221, 0.18);
            color: #ffffff;
            font-weight: 600;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 55%;
            background: #38bdf8;
            border-radius: 0 3px 3px 0;
        }
        .sidebar-link .sidebar-icon {
            width: 1.85rem;
            height: 1.85rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.05);
            transition: background 0.2s ease;
        }
        .sidebar-link:hover .sidebar-icon {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar-link.active .sidebar-icon {
            background: rgba(0, 147, 221, 0.3);
        }

        /* Table styles */
        .table-row {
            transition: background 0.2s ease;
        }
        .table-row:hover {
            background: rgba(255, 255, 255, 0.04);
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
                        <div class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">
                            K
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-extrabold text-komdigi-dark text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Beranda</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Logbook</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Penilaian</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                </nav>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white shadow-md">
                            BS
                        </div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-slate-800 leading-tight">Budi Santoso</div>
                            <div class="text-[10px] text-emerald-600 font-medium">● Online</div>
                        </div>
                    </div>
                    <a href="login-komdigi.html" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md">
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">
        
        <!-- SIDEBAR -->
        <aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
            <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Pembimbing</p>
                
                <nav class="space-y-0.5" id="sidebar-nav">
                    <a href="dashboard-pembimbing.html" class="sidebar-link text-sm" title="Beranda">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="daftar-peserta-pembimbing.html" class="sidebar-link active text-sm" title="Daftar Peserta">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="sidebar-label">Daftar Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Approval Logbook">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Approval Logbook</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Penilaian Peserta">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <span class="sidebar-label">Penilaian Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Laporan Bimbingan">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Laporan Bimbingan</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Profil">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="sidebar-label">Profil</span>
                    </a>
                </nav>
            </div>

            <div class="p-2 border-t border-white/8">
                <div class="rounded-xl p-2 border border-white/8 bg-white/[0.03]">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/15 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="sidebar-footer-text min-w-0">
                            <p class="text-[10px] font-semibold text-blue-200/70">Peserta Bimbingan</p>
                            <p class="text-xs font-bold text-white truncate">8 Peserta Aktif</p>
                            <div class="mt-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-blue-100/80 font-medium">Manajemen Bimbingan</p>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Daftar Peserta Bimbingan</h1>
                    </div>
                    <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                            <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.30.00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search -->
                <div class="glass-card rounded-3xl p-5">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Search -->
                        <div class="relative flex-1">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" id="searchInput" placeholder="Cari nama atau ID peserta..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-komdigi-cerulean focus:ring-1 focus:ring-komdigi-cerulean/40">
                        </div>

                        <!-- Filters -->
                        <div class="flex flex-wrap items-center gap-2.5">
                            <select id="filterStatus" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="all">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="perhatian">Perlu Perhatian</option>
                                <option value="selesai">Selesai</option>
                            </select>
                            <select id="filterPeriode" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="all">Semua Periode</option>
                                <option value="okt-des">Okt – Des 2026</option>
                                <option value="jul-sep">Jul – Sep 2026</option>
                            </select>
                            <select id="filterSort" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="skor-desc">Skor Tertinggi</option>
                                <option value="skor-asc">Skor Terendah</option>
                                <option value="hadir-desc">Kehadiran Tertinggi</option>
                                <option value="hadir-asc">Kehadiran Terendah</option>
                                <option value="nama">Nama A–Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Summary chips -->
                <div class="flex flex-wrap gap-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        Aktif: <span class="text-white font-bold">7</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Perlu Perhatian: <span class="text-white font-bold">2</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        Selesai: <span class="text-white font-bold">1</span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
                        Total: <span class="text-white font-bold">8</span>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[900px]">
                            <thead>
                                <tr class="border-b border-white/10">
                                    <th class="px-5 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Skor</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Kehadiran</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Logbook</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pesertaTable">
                                <!-- Row 1 -->
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="88" data-hadir="96" data-nama="Fajar Aditya">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0">FA</div>
                                            <div>
                                                <a href="/detailpeserta" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Fajar Aditya</a>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0621</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-emerald-400">88</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">96%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">7/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="85" data-hadir="92" data-nama="Salwa Rameyza">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">SR</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Salwa Rameyza</a>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0847</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-emerald-400">85</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">92%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">5/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="79" data-hadir="88" data-nama="Dina Nurhaliza">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xs font-bold shrink-0">DN</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Dina Nurhaliza</a>
                                                <p class="text-[11px] text-slate-400">Universitas Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0533</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-sky-400">79</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">88%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">6/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 - Perlu perhatian -->
                                <tr class="table-row border-b border-white/5" data-status="perhatian" data-skor="71" data-hadir="68" data-nama="Aulia Rahma">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold shrink-0">AR</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Aulia Rahma</a>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0912</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-amber-400">71</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-rose-400">68%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-rose-400">3/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Perhatian
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="83" data-hadir="90" data-nama="Rizky Pratama">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-blue-500 flex items-center justify-center text-white text-xs font-bold shrink-0">RP</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Rizky Pratama</a>
                                                <p class="text-[11px] text-slate-400">Politeknik Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0718</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-emerald-400">83</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">90%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">6/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 - Perlu perhatian -->
                                <tr class="table-row border-b border-white/5" data-status="perhatian" data-skor="74" data-hadir="72" data-nama="Rizky Fauzan">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold shrink-0">RF</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Rizky Fauzan</a>
                                                <p class="text-[11px] text-slate-400">Universitas Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0755</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-amber-400">74</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-amber-400">72%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">4/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Perhatian
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="86" data-hadir="94" data-nama="Nadia Putri">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-400 flex items-center justify-center text-white text-xs font-bold shrink-0">NP</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Nadia Putri</a>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0689</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-emerald-400">86</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">94%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">7/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 8 - Selesai -->
                                <tr class="table-row" data-status="selesai" data-skor="90" data-hadir="98" data-nama="Andi Wijaya">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold shrink-0">AW</div>
                                            <div>
                                                <a href="detail-peserta-pembimbing.html" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">Andi Wijaya</a>
                                                <p class="text-[11px] text-slate-400">Politeknik Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0412</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-black text-emerald-400">90</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-white">98%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-300">8/8</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Selesai
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="detail-peserta-pembimbing.html" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <a href="#" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            </a>
                                            <a href="#" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-white/8">
                        <p class="text-xs text-slate-400">Menampilkan <span class="text-white font-semibold">1–8</span> dari <span class="text-white font-semibold">8</span> peserta</p>
                        <div class="flex items-center gap-1.5">
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10 transition disabled:opacity-40" disabled>‹</button>
                            <button class="w-8 h-8 rounded-lg bg-komdigi-blue text-white text-xs font-bold">1</button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10 transition disabled:opacity-40" disabled>›</button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Bottom Nav -->
                <div class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-blue-100 px-4 py-2.5 flex justify-around z-40">
                    <a href="dashboard-pembimbing.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Beranda</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                        <div class="w-8 h-8 rounded-xl bg-komdigi-blue/10 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold">Peserta</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Logbook</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Profil</span>
                    </a>
                </div>

                <div class="h-20 lg:hidden"></div>
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

        // Simple filter & search
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filterStatus');
        const filterSort = document.getElementById('filterSort');
        const tbody = document.getElementById('pesertaTable');

        function applyFilters() {
            const q = searchInput.value.toLowerCase();
            const status = filterStatus.value;
            const sort = filterSort.value;

            let rows = Array.from(tbody.querySelectorAll('tr'));

            rows.forEach(row => {
                const nama = row.dataset.nama.toLowerCase();
                const rowStatus = row.dataset.status;
                const matchSearch = nama.includes(q) || row.querySelector('td:nth-child(2)').textContent.toLowerCase().includes(q);
                const matchStatus = status === 'all' || rowStatus === status;
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });

            // Sort visible rows
            rows = rows.filter(r => r.style.display !== 'none');
            rows.sort((a, b) => {
                if (sort === 'skor-desc') return Number(b.dataset.skor) - Number(a.dataset.skor);
                if (sort === 'skor-asc') return Number(a.dataset.skor) - Number(b.dataset.skor);
                if (sort === 'hadir-desc') return Number(b.dataset.hadir) - Number(a.dataset.hadir);
                if (sort === 'hadir-asc') return Number(a.dataset.hadir) - Number(b.dataset.hadir);
                if (sort === 'nama') return a.dataset.nama.localeCompare(b.dataset.nama);
                return 0;
            });
            rows.forEach(r => tbody.appendChild(r));
        }

        searchInput.addEventListener('input', applyFilters);
        filterStatus.addEventListener('change', applyFilters);
        filterSort.addEventListener('change', applyFilters);
    </script>
</body>
</html>
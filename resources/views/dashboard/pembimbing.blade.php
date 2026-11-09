<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembimbing | Magang Komdigi 2026</title>
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
    </style>
</head>
<body class="font-sans text-slate-800 antialiased">

    <!-- TOP BAR -->
    <header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
        <div class="w-full">
            <div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">
                
                <!-- Logo -->
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

                <!-- Nav Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Beranda</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Logbook</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Penilaian</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                </nav>

                <!-- User + Logout -->
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
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md cursor-pointer">
                            Keluar
                        </button>
                    </form>
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
                    <a href="/dashboard-pembimbing" class="sidebar-link active text-sm" title="Beranda">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="/peserta" class="sidebar-link text-sm" title="Daftar Peserta">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="sidebar-label">Daftar Peserta</span>
                    </a>
                    <a href="/approval-logbook" class="sidebar-link text-sm" title="Approval Logbook">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Approval Logbook</span>
                    </a>
                    <a href="/penilaian" class="sidebar-link text-sm" title="Penilaian Peserta">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <span class="sidebar-label">Penilaian Peserta</span>
                    </a>
                    <a href="/laporan" class="sidebar-link text-sm" title="Laporan Bimbingan">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Laporan Bimbingan</span>
                    </a>
                    <a href="/profil" class="sidebar-link text-sm" title="Profil">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="sidebar-label">Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer -->
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

                <!-- Welcome Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-blue-100/80 font-medium">Selamat datang kembali</p>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Budi Santoso, S.Kom 👋</h1>
                        <p class="text-sm text-blue-200/70 mt-1">Pembimbing Magang • Dinas Kominfo Sumut</p>
                    </div>
                    <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                            <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.07.44 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- RINGKASAN STATS -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-3xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide">Peserta Bimbingan</p>
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-white">8</p>
                        <p class="text-[11px] text-slate-400 mt-1">7 Aktif • 1 Selesai</p>
                    </div>

                    <div class="glass-card rounded-3xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] font-bold text-amber-400 uppercase tracking-wide">Logbook Pending</p>
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-amber-400">5</p>
                        <p class="text-[11px] text-slate-400 mt-1">Menunggu persetujuan</p>
                    </div>

                    <div class="glass-card rounded-3xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] font-bold text-rose-400 uppercase tracking-wide">Perlu Perhatian</p>
                            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-rose-400">2</p>
                        <p class="text-[11px] text-slate-400 mt-1">Kehadiran / logbook rendah</p>
                    </div>

                    <div class="glass-card rounded-3xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-wide">Rata-rata Skor</p>
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-black text-emerald-400">82.4</p>
                        <p class="text-[11px] text-slate-400 mt-1">+2.1 dari minggu lalu</p>
                    </div>
                </div>

                <!-- PESERTA PERLU PERHATIAN -->
                <div class="glass-card rounded-3xl p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-rose-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-komdigi-dark">Peserta Perlu Perhatian</h3>
                                <p class="text-xs text-slate-500">Kehadiran rendah atau jarang isi logbook</p>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 bg-rose-50 text-rose-700 text-[11px] font-bold rounded-full border border-rose-100">2 Peserta</span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-orange-400 flex items-center justify-center text-white font-black text-sm shrink-0">
                                AR
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-white text-sm">Aulia Rahma</p>
                                <p class="text-xs text-slate-400">MKD-2026-0912 • Kehadiran 68%</p>
                                <div class="flex gap-2 mt-1.5">
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 font-semibold">3 Logbook kosong</span>
                                </div>
                            </div>
                            <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Detail →</a>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white font-black text-sm shrink-0">
                                RF
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-white text-sm">Rizky Fauzan</p>
                                <p class="text-xs text-slate-400">MKD-2026-0755 • Kehadiran 72%</p>
                                <div class="flex gap-2 mt-1.5">
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-semibold">2x Terlambat minggu ini</span>
                                </div>
                            </div>
                            <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Detail →</a>
                        </div>
                    </div>
                </div>

                <!-- DAFTAR PESERTA BIMBINGAN -->
                <div class="glass-card rounded-3xl p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-komdigi-dark">Daftar Peserta Bimbingan</h3>
                                <p class="text-xs text-slate-500">Kartu ringkas performa peserta</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <select class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Selesai</option>
                            </select>
                            <select class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                                <option>Skor Tertinggi</option>
                                <option>Skor Terendah</option>
                                <option>Kehadiran Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
                        <!-- Peserta 1 -->
                        <div class="rounded-2xl p-4 bg-white/[0.04] border border-white/8 hover:bg-white/[0.07] transition">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white font-black text-sm">
                                    SR
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-white text-sm truncate">Salwa Rameyza</p>
                                    <p class="text-[10px] text-slate-400">MKD-2026-0847</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-semibold text-slate-400">Skor</span>
                                <span class="text-sm font-black text-emerald-400">85</span>
                            </div>
                            <div class="h-1.5 bg-white/10 rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width: 85%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">Kehadiran <span class="text-white font-semibold">92%</span></span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]">Aktif</span>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-komdigi-blue/20 text-komdigi-blue hover:bg-komdigi-blue/30 transition">Detail</a>
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-white/5 text-slate-300 hover:bg-white/10 transition">Nilai</a>
                            </div>
                        </div>

                        <!-- Peserta 2 -->
                        <div class="rounded-2xl p-4 bg-white/[0.04] border border-white/8 hover:bg-white/[0.07] transition">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-black text-sm">
                                    FA
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-white text-sm truncate">Fajar Aditya</p>
                                    <p class="text-[10px] text-slate-400">MKD-2026-0621</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-semibold text-slate-400">Skor</span>
                                <span class="text-sm font-black text-emerald-400">88</span>
                            </div>
                            <div class="h-1.5 bg-white/10 rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-400 rounded-full" style="width: 88%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">Kehadiran <span class="text-white font-semibold">96%</span></span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]">Aktif</span>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-komdigi-blue/20 text-komdigi-blue hover:bg-komdigi-blue/30 transition">Detail</a>
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-white/5 text-slate-300 hover:bg-white/10 transition">Nilai</a>
                            </div>
                        </div>

                        <!-- Peserta 3 -->
                        <div class="rounded-2xl p-4 bg-white/[0.04] border border-white/8 hover:bg-white/[0.07] transition">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white font-black text-sm">
                                    DN
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-white text-sm truncate">Dina Nurhaliza</p>
                                    <p class="text-[10px] text-slate-400">MKD-2026-0533</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-semibold text-slate-400">Skor</span>
                                <span class="text-sm font-black text-sky-400">79</span>
                            </div>
                            <div class="h-1.5 bg-white/10 rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: 79%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">Kehadiran <span class="text-white font-semibold">88%</span></span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]">Aktif</span>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-komdigi-blue/20 text-komdigi-blue hover:bg-komdigi-blue/30 transition">Detail</a>
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-white/5 text-slate-300 hover:bg-white/10 transition">Nilai</a>
                            </div>
                        </div>

                        <!-- Peserta 4 - Perlu perhatian -->
                        <div class="rounded-2xl p-4 bg-white/[0.04] border border-rose-500/30 hover:bg-white/[0.07] transition">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-rose-500 to-orange-400 flex items-center justify-center text-white font-black text-sm">
                                    AR
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-white text-sm truncate">Aulia Rahma</p>
                                    <p class="text-[10px] text-slate-400">MKD-2026-0912</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-semibold text-slate-400">Skor</span>
                                <span class="text-sm font-black text-amber-400">71</span>
                            </div>
                            <div class="h-1.5 bg-white/10 rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-gradient-to-r from-amber-500 to-orange-400 rounded-full" style="width: 71%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-400">Kehadiran <span class="text-rose-400 font-semibold">68%</span></span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-bold text-[10px]">Perhatian</span>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-komdigi-blue/20 text-komdigi-blue hover:bg-komdigi-blue/30 transition">Detail</a>
                                <a href="#" class="flex-1 text-center text-[11px] font-bold py-1.5 rounded-lg bg-white/5 text-slate-300 hover:bg-white/10 transition">Nilai</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="#" class="inline-flex items-center gap-1.5 text-sm font-bold text-komdigi-blue hover:text-white transition">
                            Lihat semua peserta
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <!-- TWO COL: Logbook Pending + Ringkasan Performa -->
                <div class="grid lg:grid-cols-2 gap-5">

                    <!-- Logbook Menunggu Approval -->
                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-amber-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-komdigi-dark">Logbook Menunggu</h3>
                                    <p class="text-xs text-slate-500">Butuh review & approval</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-100">5</span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">SR</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">Salwa Rameyza</p>
                                    <p class="text-[11px] text-slate-400">Minggu ke-5 • 3 Nov 2026</p>
                                </div>
                                <a href="#" class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 transition">Review</a>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0">FA</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">Fajar Aditya</p>
                                    <p class="text-[11px] text-slate-400">Minggu ke-5 • 2 Nov 2026</p>
                                </div>
                                <a href="#" class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 transition">Review</a>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xs font-bold shrink-0">DN</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">Dina Nurhaliza</p>
                                    <p class="text-[11px] text-slate-400">Minggu ke-4 • 28 Okt 2026</p>
                                </div>
                                <a href="#" class="text-[11px] font-bold px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 transition">Review</a>
                            </div>
                        </div>

                        <a href="#" class="mt-4 flex items-center justify-center gap-1.5 w-full py-2.5 text-sm font-bold text-komdigi-blue hover:text-white border border-white/10 rounded-2xl hover:bg-white/5 transition">
                            Lihat semua logbook
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Ringkasan Performa -->
                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-komdigi-dark">Ringkasan Performa</h3>
                                    <p class="text-xs text-slate-500">Rata-rata skor bimbingan</p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                        </div>
                        <div class="h-52">
                            <canvas id="perfChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                            <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Daftar Peserta</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Kelola peserta</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Approval</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Review logbook</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Penilaian</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Beri nilai peserta</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Laporan</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Export & rekap</p>
                    </a>
                </div>

                <!-- Mobile Bottom Nav -->
                <div class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-blue-100 px-4 py-2.5 flex justify-around z-40">
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                        <div class="w-8 h-8 rounded-xl bg-komdigi-blue/10 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold">Beranda</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Peserta</span>
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

        const ctx = document.getElementById('perfChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: [76, 78, 80, 81, 82.4],
                    borderColor: '#0055FF',
                    backgroundColor: 'rgba(0, 85, 255, 0.12)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0055FF',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2.5,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#00336C',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 60,
                        max: 100,
                        grid: { color: 'rgba(0, 85, 255, 0.08)' },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    }
                }
            }
        });

        document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
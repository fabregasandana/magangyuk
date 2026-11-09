<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bimbingan | Magang Komdigi 2026</title>
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
            transform: translateY(-2px);
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
        .table-row {
            transition: background 0.2s ease;
        }
        .table-row:hover {
            background: rgba(255, 255, 255, 0.04);
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
                        <div class="font-extrabold text-white text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Beranda</a>
                    <a href="daftar-peserta-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Logbook</a>
                    <a href="penilaian-peserta.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Penilaian</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Laporan</a>
                </nav>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20 shadow-md">BS</div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-white leading-tight">Budi Santoso</div>
                            <div class="text-[10px] text-emerald-400 font-medium">● Online</div>
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
                <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Pembimbing</p>
                <nav class="space-y-0.5">
                    <a href="dashboard-pembimbing.html" class="sidebar-link text-sm" title="Beranda">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="daftar-peserta-pembimbing.html" class="sidebar-link text-sm" title="Daftar Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <span class="sidebar-label">Daftar Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Approval Logbook">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Approval Logbook</span>
                    </a>
                    <a href="penilaian-peserta.html" class="sidebar-link text-sm" title="Penilaian Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                        <span class="sidebar-label">Penilaian Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link active text-sm" title="Laporan Bimbingan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan Bimbingan</span>
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
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Laporan Bimbingan</h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">11.50.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export & Filter Bar -->
                <div class="glass-card rounded-3xl p-5">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <div class="flex flex-wrap items-center gap-2.5 flex-1">
                            <select id="filterPeriode" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="all">Semua Periode</option>
                                <option value="okt">Oktober 2026</option>
                                <option value="nov" selected>November 2026</option>
                                <option value="des">Desember 2026</option>
                            </select>
                            <select id="filterStatus" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="all">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="perhatian">Perlu Perhatian</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="flex flex-wrap items-center gap-2.5">
                            <button onclick="exportPDF()" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-rose-600 to-rose-500 rounded-xl shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Export PDF
                            </button>
                            <button onclick="exportExcel()" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-komdigi-cerulean/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-black text-white">8</p>
                        <p class="text-xs text-slate-400 mt-1">Total Peserta Bimbingan</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-black text-emerald-400">84.6</p>
                        <p class="text-xs text-slate-400 mt-1">Rata-rata Skor Kinerja</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-black text-amber-400">91%</p>
                        <p class="text-xs text-slate-400 mt-1">Rata-rata Kehadiran</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                        </div>
                        <p class="text-2xl font-black text-rose-400">2</p>
                        <p class="text-xs text-slate-400 mt-1">Perlu Perhatian</p>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div class="glass-card rounded-3xl p-5 sm:p-6">
                        <h3 class="text-sm font-bold text-white mb-4">Distribusi Skor Kinerja</h3>
                        <div class="h-56">
                            <canvas id="scoreChart"></canvas>
                        </div>
                    </div>
                    <div class="glass-card rounded-3xl p-5 sm:p-6">
                        <h3 class="text-sm font-bold text-white mb-4">Tren Rata-rata Skor Mingguan</h3>
                        <div class="h-56">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Rekap Kinerja Table -->
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-white/8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-base font-bold text-white">Rekap Kinerja Peserta Bimbingan</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Data kinerja seluruh peserta yang dibimbing</p>
                        </div>
                        <p class="text-xs text-slate-400">Periode: <span class="text-white font-semibold">November 2026</span></p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
                                    <th class="px-5 py-3.5 font-semibold">Peserta</th>
                                    <th class="px-4 py-3.5 font-semibold">ID</th>
                                    <th class="px-4 py-3.5 font-semibold text-center">Skor</th>
                                    <th class="px-4 py-3.5 font-semibold text-center">Kehadiran</th>
                                    <th class="px-4 py-3.5 font-semibold text-center">Logbook</th>
                                    <th class="px-4 py-3.5 font-semibold text-center">Penilaian</th>
                                    <th class="px-4 py-3.5 font-semibold">Status</th>
                                    <th class="px-4 py-3.5 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="rekapTable">
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="88">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">SR</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Salwa Rameyza</p>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0847</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">88</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">96%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">7/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">4</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="86">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-500 to-rose-400 flex items-center justify-center text-white text-xs font-bold shrink-0">NP</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Nadia Putri</p>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0689</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">86</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">94%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">7/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">4</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="90">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-purple-400 flex items-center justify-center text-white text-xs font-bold shrink-0">FA</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Fajar Aditya</p>
                                                <p class="text-[11px] text-slate-400">Institut Teknologi Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0712</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">90</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">98%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">8/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">5</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="perhatian" data-skor="74">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold shrink-0">RF</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Rizky Fauzan</p>
                                                <p class="text-[11px] text-slate-400">Universitas Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0755</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-amber-400">74</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-amber-400">72%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">4/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">2</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/15 text-amber-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Perhatian
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="85">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-blue-400 flex items-center justify-center text-white text-xs font-bold shrink-0">DH</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Dina Harahap</p>
                                                <p class="text-[11px] text-slate-400">Politeknik Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0621</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">85</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">92%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">6/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">3</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="perhatian" data-skor="71">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-red-400 flex items-center justify-center text-white text-xs font-bold shrink-0">AS</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Ahmad Syahputra</p>
                                                <p class="text-[11px] text-slate-400">Universitas Muhammadiyah Sumut</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0798</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-amber-400">71</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-amber-400">68%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">3/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">1</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/15 text-amber-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Perhatian
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row border-b border-white/5" data-status="aktif" data-skor="87">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold shrink-0">ML</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Maya Lestari</p>
                                                <p class="text-[11px] text-slate-400">Universitas Sumatera Utara</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0654</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">87</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">95%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">8/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">4</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                                <tr class="table-row" data-status="selesai" data-skor="90">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold shrink-0">AW</div>
                                            <div>
                                                <p class="text-sm font-bold text-white">Andi Wijaya</p>
                                                <p class="text-[11px] text-slate-400">Politeknik Negeri Medan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-300 font-medium">MKD-2026-0412</td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-black text-emerald-400">90</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-white">98%</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">8/8</span></td>
                                    <td class="px-4 py-4 text-center"><span class="text-sm font-semibold text-slate-300">5</span></td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-400 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Selesai
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="penilaian-peserta.html" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Detail</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Ringkasan Evaluasi -->
                <div class="glass-card rounded-3xl p-5 sm:p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Ringkasan untuk Evaluasi</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                            <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wide mb-2">Kekuatan</p>
                            <ul class="space-y-1.5 text-sm text-slate-300">
                                <li class="flex items-start gap-2"><span class="text-emerald-400 mt-0.5">•</span> Rata-rata skor kinerja di atas 80 (Baik)</li>
                                <li class="flex items-start gap-2"><span class="text-emerald-400 mt-0.5">•</span> Tingkat kehadiran keseluruhan tinggi (91%)</li>
                                <li class="flex items-start gap-2"><span class="text-emerald-400 mt-0.5">•</span> 6 dari 8 peserta berstatus Aktif dengan performa stabil</li>
                            </ul>
                        </div>
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                            <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Area Perbaikan</p>
                            <ul class="space-y-1.5 text-sm text-slate-300">
                                <li class="flex items-start gap-2"><span class="text-amber-400 mt-0.5">•</span> 2 peserta perlu perhatian (skor &lt; 75, kehadiran rendah)</li>
                                <li class="flex items-start gap-2"><span class="text-amber-400 mt-0.5">•</span> Pengisian logbook masih belum konsisten pada beberapa peserta</li>
                                <li class="flex items-start gap-2"><span class="text-amber-400 mt-0.5">•</span> Perlu monitoring lebih intensif untuk Rizky Fauzan & Ahmad Syahputra</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4 p-4 rounded-2xl bg-komdigi-blue/10 border border-komdigi-cerulean/20">
                        <p class="text-xs font-semibold text-komdigi-cerulean uppercase tracking-wide mb-2">Rekomendasi Pembimbing</p>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Secara keseluruhan, kinerja bimbingan berjalan baik. Fokuskan perhatian pada peserta dengan status “Perhatian” melalui sesi mentoring tambahan dan monitoring logbook mingguan. Pertahankan kualitas bimbingan untuk peserta berperforma tinggi agar skor tetap stabil hingga akhir periode magang.
                        </p>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Mobile Bottom Nav -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-white/10 px-4 py-2.5 flex justify-around z-40">
        <a href="dashboard-pembimbing.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
            <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>
        <a href="daftar-peserta-pembimbing.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
            <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <span class="text-[10px] font-medium">Peserta</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
            <div class="w-8 h-8 rounded-xl bg-komdigi-cerulean/15 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <span class="text-[10px] font-semibold">Laporan</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
            <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>
    <div class="h-20 lg:hidden"></div>

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
            document.getElementById('current-date').textContent = dateStr;
            document.getElementById('current-time').textContent = `${h}.${m}.${s} WIB`;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Charts
        const scoreCtx = document.getElementById('scoreChart').getContext('2d');
        new Chart(scoreCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sangat Baik (≥90)', 'Baik (80-89)', 'Cukup (70-79)', 'Perlu Perbaikan (<70)'],
                datasets: [{
                    data: [2, 4, 2, 0],
                    backgroundColor: ['#10b981', '#38bdf8', '#f59e0b', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8', font: { size: 11 }, padding: 16 }
                    }
                },
                cutout: '62%'
            }
        });

        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: [78, 81, 83, 85, 86],
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.12)',
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#38bdf8',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8', font: { size: 11 } },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    y: {
                        min: 60,
                        max: 100,
                        ticks: { color: '#94a3b8', font: { size: 11 } },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    }
                }
            }
        });

        function exportPDF() {
            alert('Mengunduh Laporan Bimbingan (PDF)...\n\nFile: Laporan_Bimbingan_November_2026.pdf\n\n(Fitur export akan terhubung ke backend)');
        }
        function exportExcel() {
            alert('Mengunduh Laporan Bimbingan (Excel)...\n\nFile: Laporan_Bimbingan_November_2026.xlsx\n\n(Fitur export akan terhubung ke backend)');
        }
    </script>
</body>
</html>

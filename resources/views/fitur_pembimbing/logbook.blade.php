<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Logbook | Magang Komdigi 2026</title>
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
        .glass-sidebar:hover { width: 240px; background: rgba(8, 12, 24, 0.5); }
        .glass-sidebar .sidebar-label {
            opacity: 0; white-space: nowrap;
            transition: opacity 0.18s ease 0.04s;
            pointer-events: none; font-size: 0.8125rem;
        }
        .glass-sidebar:hover .sidebar-label { opacity: 1; pointer-events: auto; }
        .glass-sidebar .sidebar-section-title {
            opacity: 0; max-height: 0; margin: 0; padding: 0; overflow: hidden;
            transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-section-title {
            opacity: 1; max-height: 2rem; margin-bottom: 0.75rem; padding: 0 0.5rem;
        }
        .glass-sidebar .sidebar-footer-text {
            opacity: 0; max-width: 0; overflow: hidden; transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-footer-text { opacity: 1; max-width: 160px; }

        .glass-card h2, .glass-card h3, .glass-card .font-black, .glass-card .font-bold { color: #f8fafc !important; }
        .glass-card .text-slate-500, .glass-card .text-slate-400 { color: #94a3b8 !important; }
        .glass-card .text-slate-700, .glass-card .text-slate-800, .glass-card .text-komdigi-dark { color: #e2e8f0 !important; }
        .glass-card .bg-blue-50, .glass-card .bg-blue-50\/80, .glass-card .bg-emerald-50,
        .glass-card .bg-amber-50, .glass-card .bg-indigo-50, .glass-card .bg-sky-50,
        .glass-card .bg-slate-50, .glass-card .bg-slate-100, .glass-card .bg-white, .glass-card .bg-rose-50 {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .border-blue-100, .glass-card .border-emerald-100, .glass-card .border-amber-100,
        .glass-card .border-slate-200, .glass-card .border-white, .glass-card .border-rose-100 {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .bg-emerald-100 { background: rgba(16, 185, 129, 0.2) !important; }
        .glass-card .text-emerald-700 { color: #6ee7b7 !important; }
        .glass-card .bg-amber-100 { background: rgba(245, 158, 11, 0.2) !important; }
        .glass-card .text-amber-700 { color: #fcd34d !important; }
        .glass-card .bg-blue-100 { background: rgba(0, 147, 221, 0.2) !important; }
        .glass-card .bg-rose-100 { background: rgba(244, 63, 94, 0.2) !important; }
        .glass-card .text-rose-700 { color: #fda4af !important; }
        .glass-card .text-komdigi-blue, .glass-card .text-komdigi-cerulean { color: #38bdf8 !important; }
        .glass-card .border-b { border-color: rgba(255, 255, 255, 0.08) !important; }

        .glass-strong .text-slate-800, .glass .text-slate-800 { color: #f1f5f9 !important; }
        .glass-strong .text-slate-600, .glass .text-slate-600,
        .glass-strong .text-slate-500, .glass .text-slate-500 { color: #94a3b8 !important; }
        .glass-strong .text-komdigi-dark, .glass .text-komdigi-dark { color: #f8fafc !important; }

        .sidebar-link {
            transition: all 0.2s ease;
            color: rgba(186, 198, 214, 0.95);
            font-weight: 500;
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.55rem 0.7rem; border-radius: 0.7rem;
            position: relative; margin: 0 0.2rem;
        }
        .sidebar-link:hover { background: rgba(255, 255, 255, 0.07); color: #f8fafc; }
        .sidebar-link.active {
            background: rgba(0, 147, 221, 0.18); color: #ffffff; font-weight: 600;
        }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 50%;
            transform: translateY(-50%); width: 3px; height: 55%;
            background: #38bdf8; border-radius: 0 3px 3px 0;
        }
        .sidebar-link .sidebar-icon {
            width: 1.85rem; height: 1.85rem; border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; background: rgba(255, 255, 255, 0.05);
            transition: background 0.2s ease;
        }
        .sidebar-link:hover .sidebar-icon { background: rgba(255, 255, 255, 0.1); }
        .sidebar-link.active .sidebar-icon { background: rgba(0, 147, 221, 0.3); }

        .logbook-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .logbook-item:hover, .logbook-item.active {
            background: rgba(0, 147, 221, 0.12);
            border-color: rgba(56, 189, 248, 0.35);
        }
        .logbook-item.active {
            box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.3);
        }

        .preview-panel {
            max-height: calc(100vh - 220px);
            overflow-y: auto;
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
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                    </div>
                </div>
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Beranda</a>
                    <a href="daftar-peserta-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Logbook</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Penilaian</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                </nav>
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white shadow-md">BS</div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-slate-800 leading-tight">Budi Santoso</div>
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
                    <a href="approval-logbook-pembimbing.html" class="sidebar-link active text-sm" title="Approval Logbook">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Approval Logbook</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Penilaian Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                        <span class="sidebar-label">Penilaian Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Laporan Bimbingan">
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
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="sidebar-footer-text min-w-0">
                            <p class="text-[10px] font-semibold text-blue-200/70">Menunggu Review</p>
                            <p class="text-xs font-bold text-white truncate">5 Logbook</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-5 min-h-[calc(100vh-120px)]">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-blue-100/80 font-medium">Review & Persetujuan</p>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Approval Logbook</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-xs font-bold text-amber-300">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            5 Menunggu
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="glass-card rounded-3xl p-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" id="searchLogbook" placeholder="Cari nama peserta..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-komdigi-cerulean">
                        </div>
                        <select id="filterPeserta" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                            <option value="all">Semua Peserta</option>
                            <option value="sr">Salwa Rameyza</option>
                            <option value="fa">Fajar Aditya</option>
                            <option value="dn">Dina Nurhaliza</option>
                            <option value="ar">Aulia Rahma</option>
                            <option value="rf">Rizky Fauzan</option>
                        </select>
                        <select id="filterTanggal" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                            <option value="all">Semua Tanggal</option>
                            <option value="minggu5">Minggu ke-5</option>
                            <option value="minggu4">Minggu ke-4</option>
                            <option value="minggu3">Minggu ke-3</option>
                        </select>
                        <select id="filterStatus" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                            <option value="pending">Menunggu</option>
                            <option value="all">Semua Status</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </div>

                <!-- Split: List + Preview -->
                <div class="grid lg:grid-cols-5 gap-5">

                    <!-- LEFT: List Logbook -->
                    <div class="lg:col-span-2 space-y-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider px-1">Daftar Logbook</p>

                        <!-- Item 1 - Active -->
                        <div class="logbook-item active glass-card rounded-2xl p-4" data-id="1" data-peserta="sr" data-minggu="minggu5">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">SR</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-white truncate">Salwa Rameyza</p>
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Minggu ke-5 • 27 Okt – 2 Nov 2026</p>
                                    <p class="text-[11px] text-slate-500 mt-1 truncate">Dikirim: 3 Nov 2026, 14.22</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="logbook-item glass-card rounded-2xl p-4" data-id="2" data-peserta="fa" data-minggu="minggu5">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0">FA</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-white truncate">Fajar Aditya</p>
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Minggu ke-5 • 27 Okt – 2 Nov 2026</p>
                                    <p class="text-[11px] text-slate-500 mt-1 truncate">Dikirim: 2 Nov 2026, 16.45</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="logbook-item glass-card rounded-2xl p-4" data-id="3" data-peserta="dn" data-minggu="minggu4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xs font-bold shrink-0">DN</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-white truncate">Dina Nurhaliza</p>
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Minggu ke-4 • 20 – 26 Okt 2026</p>
                                    <p class="text-[11px] text-slate-500 mt-1 truncate">Dikirim: 28 Okt 2026, 09.10</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="logbook-item glass-card rounded-2xl p-4" data-id="4" data-peserta="ar" data-minggu="minggu4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold shrink-0">AR</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-white truncate">Aulia Rahma</p>
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Minggu ke-4 • 20 – 26 Okt 2026</p>
                                    <p class="text-[11px] text-slate-500 mt-1 truncate">Dikirim: 27 Okt 2026, 11.30</p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 5 -->
                        <div class="logbook-item glass-card rounded-2xl p-4" data-id="5" data-peserta="rf" data-minggu="minggu3">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold shrink-0">RF</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-bold text-white truncate">Rizky Fauzan</p>
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold shrink-0">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Minggu ke-3 • 13 – 19 Okt 2026</p>
                                    <p class="text-[11px] text-slate-500 mt-1 truncate">Dikirim: 20 Okt 2026, 15.05</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Preview + Action -->
                    <div class="lg:col-span-3">
                        <div class="glass-card rounded-3xl overflow-hidden sticky top-[100px]">
                            <div class="px-5 py-4 border-b border-white/8 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-white text-base">Preview Logbook</h3>
                                    <p class="text-xs text-slate-400 mt-0.5" id="previewMeta">Salwa Rameyza • Minggu ke-5</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">Menunggu Approval</span>
                            </div>

                            <div class="p-5 preview-panel space-y-5" id="previewContent">
                                <!-- Info -->
                                <div class="grid sm:grid-cols-2 gap-3">
                                    <div class="bg-white/[0.04] rounded-xl px-4 py-3 border border-white/8">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">Peserta</p>
                                        <p class="text-sm font-semibold text-white mt-0.5">Salwa Rameyza</p>
                                        <p class="text-[11px] text-slate-400">MKD-2026-0847</p>
                                    </div>
                                    <div class="bg-white/[0.04] rounded-xl px-4 py-3 border border-white/8">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">Periode</p>
                                        <p class="text-sm font-semibold text-white mt-0.5">Minggu ke-5</p>
                                        <p class="text-[11px] text-slate-400">27 Oktober – 2 November 2026</p>
                                    </div>
                                </div>

                                <!-- Kegiatan -->
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Uraian Kegiatan</p>
                                    <div class="bg-white/[0.04] rounded-xl p-4 border border-white/8 text-sm text-slate-200 leading-relaxed space-y-3">
                                        <p>Minggu ini fokus fokus pada pengembangan fitur absensi dan pengujian unit test pada modul dashboard peserta.</p>
                                        <ul class="list-disc list-inside space-y-1.5 text-slate-300">
                                            <li>Menyelesaikan integrasi validasi lokasi (geofencing) dengan radius 2000 meter.</li>
                                            <li>Membuat unit test untuk endpoint absen masuk dan absen pulang.</li>
                                            <li>Memperbaiki bug pada tampilan riwayat kehadiran di mobile view.</li>
                                            <li>Diskusi dengan pembimbing terkait alur approval logbook.</li>
                                            <li>Dokumentasi API yang sudah dibuat di Notion internal.</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Hasil / Output -->
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Hasil / Output</p>
                                    <div class="bg-white/[0.04] rounded-xl p-4 border border-white/8 text-sm text-slate-200 leading-relaxed">
                                        <p>Fitur absensi sudah bisa digunakan di environment staging. Unit test coverage untuk modul absensi mencapai 78%. Bug mobile view sudah diperbaiki dan di-deploy ke staging.</p>
                                    </div>
                                </div>

                                <!-- Kendala -->
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kendala</p>
                                    <div class="bg-white/[0.04] rounded-xl p-4 border border-white/8 text-sm text-slate-200 leading-relaxed">
                                        <p>Perbedaan perilaku browser pada permission lokasi (Chrome vs Safari). Sudah dicari workaround dengan fallback ke manual check-in jika permission ditolak.</p>
                                    </div>
                                </div>

                                <!-- Rencana Minggu Depan -->
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Rencana Minggu Depan</p>
                                    <div class="bg-white/[0.04] rounded-xl p-4 border border-white/8 text-sm text-slate-200 leading-relaxed">
                                        <ul class="list-disc list-inside space-y-1.5 text-slate-300">
                                            <li>Implementasi notifikasi real-time saat logbook di-approve/tolak.</li>
                                            <li>Mulai kerjakan modul laporan akhir (draft struktur).</li>
                                            <li>Code review bersama mentor.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Area -->
                            <div class="px-5 py-4 border-t border-white/8 space-y-3 bg-white/[0.02]">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5 block">Komentar Pembimbing</label>
                                    <textarea id="komentar" rows="3" placeholder="Tulis komentar atau catatan untuk peserta (opsional)..." class="w-full px-4 py-3 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-komdigi-cerulean resize-none"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2.5">
                                    <button id="btnApprove" class="flex-1 inline-flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Setujui Logbook
                                    </button>
                                    <button id="btnReject" class="flex-1 inline-flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-rose-500 to-red-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak Logbook
                                    </button>
                                </div>
                            </div>
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
                    <a href="daftar-peserta-pembimbing.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Peserta</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
                        <div class="w-8 h-8 rounded-xl bg-komdigi-blue/10 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold">Logbook</span>
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
        // Select logbook item
        document.querySelectorAll('.logbook-item').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.logbook-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                const name = item.querySelector('.text-sm.font-bold').textContent;
                const periode = item.querySelector('.text-xs.text-slate-400').textContent;
                document.getElementById('previewMeta').textContent = name + ' • ' + periode.split('•')[0].trim();
            });
        });

        // Approve / Reject feedback
        document.getElementById('btnApprove').addEventListener('click', () => {
            const btn = document.getElementById('btnApprove');
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Disetujui!';
            btn.classList.add('opacity-80');
            setTimeout(() => {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Setujui Logbook';
                btn.classList.remove('opacity-80');
                // mark active item as approved visually
                const active = document.querySelector('.logbook-item.active');
                if (active) {
                    const badge = active.querySelector('span.rounded-full');
                    if (badge) {
                        badge.className = 'px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold shrink-0';
                        badge.textContent = 'Disetujui';
                    }
                }
            }, 1200);
        });

        document.getElementById('btnReject').addEventListener('click', () => {
            const komentar = document.getElementById('komentar').value.trim();
            if (!komentar) {
                document.getElementById('komentar').focus();
                document.getElementById('komentar').placeholder = 'Komentar wajib diisi jika menolak logbook...';
                return;
            }
            const btn = document.getElementById('btnReject');
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> Ditolak';
            btn.classList.add('opacity-80');
            setTimeout(() => {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> Tolak Logbook';
                btn.classList.remove('opacity-80');
                const active = document.querySelector('.logbook-item.active');
                if (active) {
                    const badge = active.querySelector('span.rounded-full');
                    if (badge) {
                        badge.className = 'px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold shrink-0';
                        badge.textContent = 'Ditolak';
                    }
                }
            }, 1200);
        });
    </script>
</body>
</html>
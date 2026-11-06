<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta | Magang Komdigi 2026</title>
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
        .glass-card .bg-blue-50, .glass-card .bg-blue-50\/80, .glass-card .bg-blue-50\/60,
        .glass-card .bg-emerald-50, .glass-card .bg-amber-50, .glass-card .bg-indigo-50,
        .glass-card .bg-sky-50, .glass-card .bg-slate-50, .glass-card .bg-slate-100,
        .glass-card .bg-white, .glass-card .bg-rose-50 {
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
        .glass-card .h-px { background: rgba(255, 255, 255, 0.08) !important; }

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

        .tab-btn {
            transition: all 0.2s ease;
            color: #94a3b8;
            font-weight: 500;
        }
        .tab-btn.active {
            color: #38bdf8;
            background: rgba(0, 147, 221, 0.15);
            border-color: rgba(56, 189, 248, 0.4);
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
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
                    <a href="daftar-peserta-pembimbing.html" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Logbook</a>
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
                <nav class="space-y-0.5" id="sidebar-nav">
                    <a href="dashboard-pembimbing.html" class="sidebar-link text-sm" title="Beranda">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="/peserta" class="sidebar-link active text-sm" title="Daftar Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <span class="sidebar-label">Daftar Peserta</span>
                    </a>
                    <a href="/logbook" class="sidebar-link text-sm" title="Approval Logbook">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Approval Logbook</span>
                    </a>
                    <a href="/penilaian peserta" class="sidebar-link text-sm" title="Penilaian Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                        <span class="sidebar-label">Penilaian Peserta</span>
                    </a>
                    <a href="/laporan bimbingan" class="sidebar-link text-sm" title="Laporan Bimbingan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan Bimbingan</span>
                    </a>
                    <a href="/profil" class="sidebar-link text-sm" title="Profil">
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
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                <!-- Breadcrumb + Back -->
                <div class="flex items-center gap-2 text-sm">
                    <a href="daftar-peserta-pembimbing.html" class="text-blue-200/70 hover:text-white transition font-medium">Daftar Peserta</a>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-white font-semibold">Detail Peserta</span>
                </div>

                <!-- PROFILE CARD -->
                <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-56 h-56 bg-komdigi-blue/10 rounded-full blur-3xl"></div>
                    <div class="relative flex flex-col lg:flex-row gap-6">
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 flex-1">
                            <div class="relative shrink-0">
                                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/40">
                                    SR
                                </div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                    <div>
                                        <h1 class="text-2xl font-black text-white">Salwa Rameyza</h1>
                                        <p class="text-sm text-slate-400 font-medium">Peserta Magang • ID: <span class="text-komdigi-blue font-semibold">MKD-2026-0847</span></p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full self-center sm:self-auto border border-emerald-100">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                        Aktif
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                                        <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Institusi</p>
                                        <p class="text-sm font-semibold text-slate-800 mt-0.5">Universitas Sumatera Utara</p>
                                    </div>
                                    <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                                        <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Unit Kerja</p>
                                        <p class="text-sm font-semibold text-slate-800 mt-0.5">Dinas Kominfo Sumut</p>
                                    </div>
                                    <div class="bg-blue-50/80 rounded-2xl px-4 py-3 border border-blue-100">
                                        <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Periode</p>
                                        <p class="text-sm font-semibold text-slate-800 mt-0.5">1 Okt – 19 Des 2026</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quick actions -->
                        <div class="flex lg:flex-col gap-2 shrink-0 justify-center">
                            <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Beri Penilaian
                            </a>
                            <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/5 border border-white/10 text-slate-200 text-sm font-bold rounded-xl hover:bg-white/10 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Lihat Logbook
                            </a>
                        </div>
                    </div>
                </div>

                <!-- STATS ROW -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Skor Kinerja</p>
                        <p class="text-3xl font-black text-emerald-400">85</p>
                        <p class="text-[10px] text-slate-400 mt-1">Baik</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Kehadiran</p>
                        <p class="text-3xl font-black text-white">92%</p>
                        <p class="text-[10px] text-slate-400 mt-1">22 Hadir • 3 Terlambat</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Logbook</p>
                        <p class="text-3xl font-black text-sky-400">5/8</p>
                        <p class="text-[10px] text-slate-400 mt-1">1 menunggu approval</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Penilaian</p>
                        <p class="text-3xl font-black text-amber-400">4.3</p>
                        <p class="text-[10px] text-slate-400 mt-1">Rata-rata dari 3 penilaian</p>
                    </div>
                </div>

                <!-- TABS -->
                <div class="flex flex-wrap gap-2">
                    <button class="tab-btn active px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="grafik">Grafik Performa</button>
                    <button class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="absensi">Riwayat Absensi</button>
                    <button class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="logbook">Daftar Logbook</button>
                    <button class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="penilaian">Riwayat Penilaian</button>
                </div>

                <!-- TAB: GRAFIK -->
                <div id="tab-grafik" class="tab-content active space-y-5">
                    <div class="grid lg:grid-cols-2 gap-5">
                        <div class="glass-card rounded-3xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-white">Skor Kinerja Mingguan</h3>
                                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                            </div>
                            <div class="h-56">
                                <canvas id="scoreChart"></canvas>
                            </div>
                        </div>
                        <div class="glass-card rounded-3xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-white">Kehadiran Mingguan</h3>
                                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                            </div>
                            <div class="h-56">
                                <canvas id="attendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: RIWAYAT ABSENSI -->
                <div id="tab-absensi" class="tab-content">
                    <div class="glass-card rounded-3xl overflow-hidden">
                        <div class="px-5 py-4 border-b border-white/8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <h3 class="font-bold text-white">Riwayat Absensi</h3>
                            <div class="flex gap-2">
                                <select class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                                    <option>November 2026</option>
                                    <option>Oktober 2026</option>
                                </select>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left min-w-[700px]">
                                <thead>
                                    <tr class="border-b border-white/8">
                                        <th class="px-5 py-3 text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Masuk</th>
                                        <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Pulang</th>
                                        <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Durasi</th>
                                        <th class="px-4 py-3 text-[11px] font-bold text-slate-400 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Jum, 6 Nov 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">Belum absen</span></td>
                                    </tr>
                                    <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Kam, 5 Nov 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">07.52</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">16.08</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">8j 16m</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">Hadir</span></td>
                                    </tr>
                                    <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Rab, 4 Nov 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">08.15</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">16.02</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">7j 47m</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold">Terlambat</span></td>
                                    </tr>
                                    <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Sel, 3 Nov 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">07.48</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">16.10</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">8j 22m</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">Hadir</span></td>
                                    </tr>
                                    <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Sen, 2 Nov 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">07.55</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">16.05</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">8j 10m</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold">Hadir</span></td>
                                    </tr>
                                    <tr class="hover:bg-white/[0.03]">
                                        <td class="px-5 py-3.5 text-sm text-white font-medium">Kam, 30 Okt 2026</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5 text-sm text-slate-300">—</td>
                                        <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full bg-sky-100 text-sky-400 text-[11px] font-bold">Izin</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB: LOGBOOK -->
                <div id="tab-logbook" class="tab-content">
                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-white">Daftar Logbook Peserta</h3>
                            <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 / 8 terisi</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white">Minggu ke-5 • 27 Okt – 2 Nov 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">Mengerjakan fitur absensi & pengujian unit test pada modul dashboard...</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold shrink-0">Disetujui</span>
                                <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Lihat</a>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-amber-500/30">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white">Minggu ke-4 • 20 – 26 Okt 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">Integrasi API absensi dengan validasi lokasi (geofencing)...</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] font-bold shrink-0">Menunggu</span>
                                <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Review</a>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white">Minggu ke-3 • 13 – 19 Okt 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">Desain UI dashboard peserta & implementasi komponen glassmorphism...</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold shrink-0">Disetujui</span>
                                <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Lihat</a>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white">Minggu ke-2 • 6 – 12 Okt 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">Setup project, konfigurasi Tailwind, dan struktur folder aplikasi...</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold shrink-0">Disetujui</span>
                                <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Lihat</a>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white">Minggu ke-1 • 29 Sep – 5 Okt 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">Orientasi, pengenalan unit kerja, dan briefing proyek digitalisasi...</p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-bold shrink-0">Disetujui</span>
                                <a href="#" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: RIWAYAT PENILAIAN -->
                <div id="tab-penilaian" class="tab-content">
                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-white">Riwayat Penilaian</h3>
                            <a href="#" class="text-sm font-bold text-komdigi-blue hover:underline">+ Beri Penilaian Baru</a>
                        </div>
                        <div class="space-y-4">
                            <!-- Penilaian 1 -->
                            <div class="p-5 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                    <div>
                                        <p class="text-sm font-bold text-white">Penilaian Minggu ke-4</p>
                                        <p class="text-xs text-slate-400">28 Oktober 2026 • oleh Budi Santoso, S.Kom</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black text-amber-400">4.3</span>
                                        <span class="text-xs text-slate-400">/ 5.0</span>
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Disiplin & Kehadiran</span>
                                            <span class="font-bold text-white">4.5</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width:90%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Kerjasama Tim</span>
                                            <span class="font-bold text-white">4.2</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-blue to-sky-400 rounded-full" style="width:84%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Kompetensi Teknis</span>
                                            <span class="font-bold text-white">4.0</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-400 rounded-full" style="width:80%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Inisiatif & Kreativitas</span>
                                            <span class="font-bold text-white">4.5</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width:90%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3.5 rounded-xl bg-white/[0.04] border border-white/8">
                                    <p class="text-xs text-slate-300 italic leading-relaxed">"Peserta menunjukkan progres yang baik dan aktif berkontribusi dalam proyek digitalisasi."</p>
                                </div>
                            </div>

                            <!-- Penilaian 2 -->
                            <div class="p-5 rounded-2xl bg-white/[0.04] border border-white/8">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                    <div>
                                        <p class="text-sm font-bold text-white">Penilaian Minggu ke-2</p>
                                        <p class="text-xs text-slate-400">14 Oktober 2026 • oleh Budi Santoso, S.Kom</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black text-amber-400">4.1</span>
                                        <span class="text-xs text-slate-400">/ 5.0</span>
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Disiplin & Kehadiran</span>
                                            <span class="font-bold text-white">4.3</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width:86%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Kerjasama Tim</span>
                                            <span class="font-bold text-white">4.0</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-blue to-sky-400 rounded-full" style="width:80%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Kompetensi Teknis</span>
                                            <span class="font-bold text-white">3.8</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-400 rounded-full" style="width:76%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-slate-400">Inisiatif & Kreativitas</span>
                                            <span class="font-bold text-white">4.3</span>
                                        </div>
                                        <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width:86%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3.5 rounded-xl bg-white/[0.04] border border-white/8">
                                    <p class="text-xs text-slate-300 italic leading-relaxed">"Mulai adaptif dengan lingkungan kerja. Perlu ditingkatkan ketelitian pada detail teknis."</p>
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
                    <a href="daftar-peserta-pembimbing.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-blue">
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
        // Tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
            });
        });

        // Charts
        const scoreCtx = document.getElementById('scoreChart').getContext('2d');
        new Chart(scoreCtx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Skor',
                    data: [72, 78, 81, 83, 85],
                    borderColor: '#0055FF',
                    backgroundColor: 'rgba(0, 85, 255, 0.12)',
                    borderWidth: 3, fill: true, tension: 0.4,
                    pointBackgroundColor: '#0055FF', pointBorderColor: '#fff',
                    pointBorderWidth: 2.5, pointRadius: 5, pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#00336C', cornerRadius: 10, padding: 12 } },
                scales: {
                    y: { min: 60, max: 100, grid: { color: 'rgba(0,85,255,0.08)' }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
                }
            }
        });

        const attendCtx = document.getElementById('attendChart').getContext('2d');
        new Chart(attendCtx, {
            type: 'bar',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Kehadiran %',
                    data: [100, 80, 100, 80, 100],
                    backgroundColor: 'rgba(0, 147, 221, 0.5)',
                    borderColor: '#0093DD',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#00336C', cornerRadius: 10, padding: 12 } },
                scales: {
                    y: { min: 0, max: 100, grid: { color: 'rgba(0,85,255,0.08)' }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
                }
            }
        });
    </script>
</body>
</html>
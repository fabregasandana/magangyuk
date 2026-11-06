<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Magang Komdigi 2026</title>
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
        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.7rem 1rem;
            color: #f1f5f9;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            border-color: #0093DD;
            box-shadow: 0 0 0 2px rgba(0, 147, 221, 0.2);
        }
        .form-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 0.4rem;
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
                        <div class="font-extrabold text-white text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Beranda</a>
                    <a href="daftar-peserta-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Logbook</a>
                    <a href="penilaian-peserta.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Penilaian</a>
                    <a href="laporan-bimbingan.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Laporan</a>
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
                    <a href="laporan-bimbingan.html" class="sidebar-link text-sm" title="Laporan Bimbingan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan Bimbingan</span>
                    </a>
                    <a href="#" class="sidebar-link active text-sm" title="Profil">
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
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Profil Saya</h1>
                    </div>
                    <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                            <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">12.00.00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Hero -->
                <div class="glass-card rounded-3xl p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="relative shrink-0">
                            <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/30">
                                BS
                            </div>
                            <button class="absolute -bottom-2 -right-2 w-9 h-9 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition" title="Ubah foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3 mb-1">
                                <h2 class="text-2xl font-black text-white">Budi Santoso, S.Kom., M.T.</h2>
                                <span class="inline-flex self-center md:self-auto items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                                </span>
                            </div>
                            <p class="text-sm text-komdigi-cerulean font-semibold mb-3">Pembimbing Magang • Dinas Kominfo Provinsi Sumatera Utara</p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-2">
                                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                                    <span class="text-slate-500">NIP:</span> 19870515 201203 1 002
                                </span>
                                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                                    <span class="text-slate-500">ID:</span> PB-2026-0014
                                </span>
                                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                                    <span class="text-slate-500">Unit:</span> Bidang Aplikasi Informatika
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <p class="text-2xl font-black text-white">8</p>
                        <p class="text-xs text-slate-400 mt-1">Peserta Bimbingan</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <p class="text-2xl font-black text-emerald-400">84.6</p>
                        <p class="text-xs text-slate-400 mt-1">Rata-rata Skor</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <p class="text-2xl font-black text-komdigi-cerulean">32</p>
                        <p class="text-xs text-slate-400 mt-1">Penilaian Diberikan</p>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <p class="text-2xl font-black text-amber-400">12</p>
                        <p class="text-xs text-slate-400 mt-1">Logbook Pending</p>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

                    <!-- Left: Data Pribadi + Keamanan -->
                    <div class="xl:col-span-3 space-y-5">
                        <!-- Data Pribadi -->
                        <div class="glass-card rounded-3xl p-5 sm:p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <h3 class="text-base font-bold text-white">Data Pribadi</h3>
                                </div>
                                <button id="btnEditProfile" onclick="toggleEdit()" class="text-xs font-semibold text-komdigi-cerulean hover:underline">Edit</button>
                            </div>

                            <form id="profileForm" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-input" id="nama" value="Budi Santoso, S.Kom., M.T." disabled>
                                </div>
                                <div>
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-input" id="nip" value="19870515 201203 1 002" disabled>
                                </div>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-input" id="email" value="budi.santoso@sumutprov.go.id" disabled>
                                </div>
                                <div>
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" class="form-input" id="telepon" value="0812-3456-7890" disabled>
                                </div>
                                <div>
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-input" id="jabatan" value="Analis Aplikasi Informatika" disabled>
                                </div>
                                <div>
                                    <label class="form-label">Unit Kerja</label>
                                    <input type="text" class="form-input" id="unit" value="Bidang Aplikasi Informatika" disabled>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-input" id="instansi" value="Dinas Komunikasi dan Informatika Provinsi Sumatera Utara" disabled>
                                </div>
                                <div class="sm:col-span-2" id="editActions" style="display:none;">
                                    <div class="flex justify-end gap-3 mt-2">
                                        <button type="button" onclick="cancelEdit()" class="px-4 py-2 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition">Batal</button>
                                        <button type="button" onclick="saveProfile()" class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 transition">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Ubah Password -->
                        <div class="glass-card rounded-3xl p-5 sm:p-6">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Keamanan Akun</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-input" id="oldPass" placeholder="Masukkan password saat ini">
                                </div>
                                <div>
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-input" id="newPass" placeholder="Minimal 8 karakter">
                                </div>
                                <div>
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-input" id="confirmPass" placeholder="Ulangi password baru">
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="button" onclick="changePassword()" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition">
                                    Ubah Password
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Info Tambahan -->
                    <div class="xl:col-span-2 space-y-5">
                        <!-- Info Akun -->
                        <div class="glass-card rounded-3xl p-5 sm:p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Informasi Akun</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-white/5">
                                    <span class="text-xs text-slate-400">Role</span>
                                    <span class="text-sm font-semibold text-white">Pembimbing</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/5">
                                    <span class="text-xs text-slate-400">ID Pembimbing</span>
                                    <span class="text-sm font-semibold text-white">PB-2026-0014</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/5">
                                    <span class="text-xs text-slate-400">Bergabung</span>
                                    <span class="text-sm font-semibold text-white">1 Oktober 2026</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-white/5">
                                    <span class="text-xs text-slate-400">Periode Aktif</span>
                                    <span class="text-sm font-semibold text-white">Okt – Des 2026</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-xs text-slate-400">Status Akun</span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Aktivitas Terakhir -->
                        <div class="glass-card rounded-3xl p-5 sm:p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Aktivitas Terakhir</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex gap-3">
                                    <div class="w-2 h-2 rounded-full bg-komdigi-cerulean mt-1.5 shrink-0"></div>
                                    <div>
                                        <p class="text-sm text-white font-medium">Memberikan penilaian</p>
                                        <p class="text-[11px] text-slate-400">Salwa Rameyza • 5 Nov 2026, 14.20</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-400 mt-1.5 shrink-0"></div>
                                    <div>
                                        <p class="text-sm text-white font-medium">Menyetujui logbook</p>
                                        <p class="text-[11px] text-slate-400">Nadia Putri • 5 Nov 2026, 11.05</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-2 h-2 rounded-full bg-amber-400 mt-1.5 shrink-0"></div>
                                    <div>
                                        <p class="text-sm text-white font-medium">Menolak logbook</p>
                                        <p class="text-[11px] text-slate-400">Rizky Fauzan • 4 Nov 2026, 16.40</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-2 h-2 rounded-full bg-komdigi-cerulean mt-1.5 shrink-0"></div>
                                    <div>
                                        <p class="text-sm text-white font-medium">Export laporan</p>
                                        <p class="text-[11px] text-slate-400">Laporan Oktober 2026 • 3 Nov 2026</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <a href="laporan-bimbingan.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
            <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <span class="text-[10px] font-medium">Laporan</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
            <div class="w-8 h-8 rounded-xl bg-komdigi-cerulean/15 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-[10px] font-semibold">Profil</span>
        </a>
    </div>
    <div class="h-20 lg:hidden"></div>

    <script>
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

        let isEditing = false;
        const fields = ['nama', 'nip', 'email', 'telepon', 'jabatan', 'unit', 'instansi'];

        function toggleEdit() {
            isEditing = true;
            fields.forEach(id => document.getElementById(id).disabled = false);
            document.getElementById('editActions').style.display = 'block';
            document.getElementById('btnEditProfile').style.display = 'none';
        }

        function cancelEdit() {
            isEditing = false;
            fields.forEach(id => document.getElementById(id).disabled = true);
            document.getElementById('editActions').style.display = 'none';
            document.getElementById('btnEditProfile').style.display = 'block';
            // Reset values if needed
            document.getElementById('nama').value = 'Budi Santoso, S.Kom., M.T.';
            document.getElementById('nip').value = '19870515 201203 1 002';
            document.getElementById('email').value = 'budi.santoso@sumutprov.go.id';
            document.getElementById('telepon').value = '0812-3456-7890';
            document.getElementById('jabatan').value = 'Analis Aplikasi Informatika';
            document.getElementById('unit').value = 'Bidang Aplikasi Informatika';
            document.getElementById('instansi').value = 'Dinas Komunikasi dan Informatika Provinsi Sumatera Utara';
        }

        function saveProfile() {
            isEditing = false;
            fields.forEach(id => document.getElementById(id).disabled = true);
            document.getElementById('editActions').style.display = 'none';
            document.getElementById('btnEditProfile').style.display = 'block';
            alert('Profil berhasil diperbarui!');
        }

        function changePassword() {
            const oldP = document.getElementById('oldPass').value;
            const newP = document.getElementById('newPass').value;
            const confP = document.getElementById('confirmPass').value;
            if (!oldP || !newP || !confP) {
                alert('Mohon lengkapi semua field password.');
                return;
            }
            if (newP.length < 8) {
                alert('Password baru minimal 8 karakter.');
                return;
            }
            if (newP !== confP) {
                alert('Konfirmasi password tidak cocok.');
                return;
            }
            alert('Password berhasil diubah!');
            document.getElementById('oldPass').value = '';
            document.getElementById('newPass').value = '';
            document.getElementById('confirmPass').value = '';
        }
    </script>
</body>
</html>
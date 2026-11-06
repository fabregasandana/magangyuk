<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Peserta | Magang Komdigi 2026</title>
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

        .score-slider {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            outline: none;
        }
        .score-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #0055FF, #0093DD);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 12px rgba(0, 147, 221, 0.6);
            border: 2px solid white;
        }
        .score-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #0055FF, #0093DD);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid white;
        }

        .period-btn.active {
            background: linear-gradient(135deg, rgba(0, 85, 255, 0.35), rgba(0, 147, 221, 0.25));
            border-color: rgba(56, 189, 248, 0.6);
            color: #fff;
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
                        <div class="font-extrabold text-white text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-1">
                    <a href="dashboard-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Beranda</a>
                    <a href="daftar-peserta-pembimbing.html" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Peserta</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Logbook</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Penilaian</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Laporan</a>
                </nav>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20 shadow-md">
                            BS
                        </div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-white leading-tight">Budi Santoso</div>
                            <div class="text-[10px] text-emerald-400 font-medium">● Online</div>
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
                    <a href="daftar-peserta-pembimbing.html" class="sidebar-link text-sm" title="Daftar Peserta">
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
                    <a href="#" class="sidebar-link active text-sm" title="Penilaian Peserta">
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
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Penilaian Peserta</h1>
                    </div>
                    <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                            <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">11.40.00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Participant Selector Card -->
                <div class="glass-card rounded-3xl p-5 sm:p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xl font-black shadow-lg shadow-blue-500/30 shrink-0 relative">
                                SR
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center border-2 border-[#0a1628]">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Salwa Rameyza</h2>
                                <p class="text-sm text-slate-400 mt-0.5">Peserta Magang • ID: <span class="text-komdigi-cerulean font-medium">MKD-2026-0847</span></p>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                        <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Institusi</span>
                                        <span class="text-white font-medium">Universitas Sumatera Utara</span>
                                    </div>
                                    <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                        <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Unit Kerja</span>
                                        <span class="text-white font-medium">Dinas Kominfo Sumut</span>
                                    </div>
                                    <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                        <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Periode</span>
                                        <span class="text-white font-medium">1 Okt – 19 Des 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                            </span>
                            <select id="pesertaSelect" class="text-sm bg-white/5 border border-white/10 text-white rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                                <option value="sr">Salwa Rameyza</option>
                                <option value="np">Nadia Putri</option>
                                <option value="rf">Rizky Fauzan</option>
                                <option value="aw">Andi Wijaya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

                    <!-- LEFT: Form Penilaian (3 cols) -->
                    <div class="xl:col-span-3 space-y-5">
                        <div class="glass-card rounded-3xl p-5 sm:p-6">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Form Penilaian</h3>
                            </div>

                            <!-- Period Type -->
                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                <button type="button" class="period-btn active px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300 transition" data-type="mingguan">Mingguan</button>
                                <button type="button" class="period-btn px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300 transition hover:border-white/20" data-type="bulanan">Bulanan</button>
                            </div>

                            <div class="mb-5">
                                <select id="periodeSelect" class="w-full text-sm bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                                    <option value="w45">Minggu ke-5 (3 – 7 Nov 2026)</option>
                                    <option value="w44">Minggu ke-4 (27 Okt – 2 Nov 2026)</option>
                                    <option value="w43">Minggu ke-3 (20 – 26 Okt 2026)</option>
                                    <option value="w42">Minggu ke-2 (13 – 19 Okt 2026)</option>
                                    <option value="w41">Minggu ke-1 (6 – 12 Okt 2026)</option>
                                </select>
                            </div>

                            <!-- Criteria List -->
                            <div class="space-y-4" id="criteriaList">
                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-white">Disiplin & Kehadiran</span>
                                        <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot 20%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range" class="score-slider flex-1" min="0" max="100" value="85" data-weight="0.2" oninput="updateScore(this)">
                                        <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">85</div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2">Sangat baik — jarang terlambat, absensi konsisten</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-white">Kualitas Kerja</span>
                                        <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot 30%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range" class="score-slider flex-1" min="0" max="100" value="88" data-weight="0.3" oninput="updateScore(this)">
                                        <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">88</div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2">Hasil kerja rapi, akurat, dan sesuai standar</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-white">Komunikasi & Kerjasama</span>
                                        <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot 20%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range" class="score-slider flex-1" min="0" max="100" value="82" data-weight="0.2" oninput="updateScore(this)">
                                        <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">82</div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2">Mampu berkomunikasi dengan jelas dan kolaboratif</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-white">Inisiatif & Kreativitas</span>
                                        <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot 15%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range" class="score-slider flex-1" min="0" max="100" value="80" data-weight="0.15" oninput="updateScore(this)">
                                        <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">80</div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2">Aktif memberikan ide dan solusi baru</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-semibold text-white">Tanggung Jawab</span>
                                        <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot 15%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range" class="score-slider flex-1" min="0" max="100" value="90" data-weight="0.15" oninput="updateScore(this)">
                                        <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">90</div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2">Dapat diandalkan dalam menyelesaikan tugas</p>
                                </div>
                            </div>

                            <!-- Total Score -->
                            <div class="mt-5 p-4 rounded-2xl bg-gradient-to-r from-komdigi-blue/15 to-komdigi-cerulean/10 border border-komdigi-cerulean/30 flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-slate-300 font-medium">Skor Total (Tertimbang)</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Berdasarkan bobot setiap aspek</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl font-black text-komdigi-cerulean" id="totalScore">85.3</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400" id="gradeLabel">Baik</span>
                                </div>
                            </div>

                            <!-- Comment -->
                            <div class="mt-5">
                                <label class="block text-sm font-medium text-slate-300 mb-2">Komentar Keseluruhan</label>
                                <textarea id="overallComment" rows="4" placeholder="Berikan feedback dan saran pengembangan untuk peserta magang..." class="w-full text-sm bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-komdigi-cerulean focus:ring-1 focus:ring-komdigi-cerulean/40 resize-y"></textarea>
                            </div>

                            <!-- Actions -->
                            <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                                <button type="button" onclick="resetForm()" class="px-5 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition">
                                    Reset
                                </button>
                                <button type="button" onclick="submitAssessment()" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Simpan Penilaian
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Riwayat (2 cols) -->
                    <div class="xl:col-span-2">
                        <div class="glass-card rounded-3xl p-5 sm:p-6 h-full">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-white">Riwayat Penilaian</h3>
                            </div>

                            <div class="space-y-3" id="historyList">
                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-komdigi-cerulean/40 transition cursor-pointer">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-white">Minggu ke-4</span>
                                        <span class="text-lg font-black text-komdigi-cerulean">87</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
                                        <span>27 Okt – 2 Nov 2026</span>
                                        <span class="text-emerald-400 font-medium">Baik</span>
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-2">Performa konsisten. Perlu meningkatkan inisiatif dalam memberikan ide baru pada proyek digitalisasi.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-komdigi-cerulean/40 transition cursor-pointer">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-white">Minggu ke-3</span>
                                        <span class="text-lg font-black text-komdigi-cerulean">84</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
                                        <span>20 – 26 Okt 2026</span>
                                        <span class="text-emerald-400 font-medium">Baik</span>
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-2">Kehadiran sangat baik. Kualitas laporan sudah membaik dibanding minggu sebelumnya.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-komdigi-cerulean/40 transition cursor-pointer">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-white">Minggu ke-2</span>
                                        <span class="text-lg font-black text-amber-400">81</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
                                        <span>13 – 19 Okt 2026</span>
                                        <span class="text-amber-400 font-medium">Cukup Baik</span>
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-2">Masih perlu penyesuaian dengan alur kerja unit. Komunikasi sudah mulai lancar.</p>
                                </div>

                                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-komdigi-cerulean/40 transition cursor-pointer">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-white">Minggu ke-1</span>
                                        <span class="text-lg font-black text-amber-400">78</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
                                        <span>6 – 12 Okt 2026</span>
                                        <span class="text-amber-400 font-medium">Cukup Baik</span>
                                    </div>
                                    <p class="text-xs text-slate-400 line-clamp-2">Adaptasi awal cukup baik. Perlu lebih proaktif dalam menanyakan tugas.</p>
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
        <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
            <div class="w-8 h-8 rounded-xl bg-komdigi-cerulean/15 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <span class="text-[10px] font-semibold">Penilaian</span>
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
            const timeStr = `${h}.${m}.${s} WIB`;
            
            document.getElementById('current-date').textContent = dateStr;
            document.getElementById('current-time').textContent = timeStr;
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        function updateScore(slider) {
            const valueEl = slider.parentElement.querySelector('.score-value');
            valueEl.textContent = slider.value;
            calculateTotal();
        }

        function calculateTotal() {
            const sliders = document.querySelectorAll('.score-slider');
            let total = 0;
            sliders.forEach(s => {
                const weight = parseFloat(s.dataset.weight);
                total += parseInt(s.value) * weight;
            });
            const rounded = Math.round(total * 10) / 10;
            document.getElementById('totalScore').textContent = rounded.toFixed(1);

            const gradeEl = document.getElementById('gradeLabel');
            if (rounded >= 90) {
                gradeEl.textContent = 'Sangat Baik';
                gradeEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400';
            } else if (rounded >= 80) {
                gradeEl.textContent = 'Baik';
                gradeEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400';
            } else if (rounded >= 70) {
                gradeEl.textContent = 'Cukup Baik';
                gradeEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-400';
            } else {
                gradeEl.textContent = 'Perlu Perbaikan';
                gradeEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400';
            }
        }

        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const type = this.dataset.type;
                const select = document.getElementById('periodeSelect');
                if (type === 'mingguan') {
                    select.innerHTML = `
                        <option value="w45">Minggu ke-5 (3 – 7 Nov 2026)</option>
                        <option value="w44">Minggu ke-4 (27 Okt – 2 Nov 2026)</option>
                        <option value="w43">Minggu ke-3 (20 – 26 Okt 2026)</option>
                        <option value="w42">Minggu ke-2 (13 – 19 Okt 2026)</option>
                        <option value="w41">Minggu ke-1 (6 – 12 Okt 2026)</option>
                    `;
                } else {
                    select.innerHTML = `
                        <option value="m11">November 2026</option>
                        <option value="m10">Oktober 2026</option>
                    `;
                }
            });
        });

        function resetForm() {
            document.querySelectorAll('.score-slider').forEach(s => {
                s.value = 80;
                updateScore(s);
            });
            document.getElementById('overallComment').value = '';
        }

        function submitAssessment() {
            const score = document.getElementById('totalScore').textContent;
            const comment = document.getElementById('overallComment').value.trim();
            const period = document.getElementById('periodeSelect').selectedOptions[0].text;

            if (!comment) {
                alert('Mohon isi komentar keseluruhan sebelum menyimpan.');
                return;
            }

            alert(`Penilaian berhasil disimpan!\n\nPeriode: ${period}\nSkor Total: ${score}\n\nTerima kasih atas penilaiannya.`);
        }

        calculateTotal();
    </script>
</body>
</html>
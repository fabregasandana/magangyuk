<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Magang Komdigi 2026</title>
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
            /* Dominan biru */
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

        /* Dark glass – lebih transparan */
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

        /* Panel utama konten – layer transparan seperti referensi */
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

        /* Sidebar collapsible – rapi & transparan, tidak nempel kiri */
        .glass-sidebar {
            background: rgba(8, 12, 24, 0.35);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            ::-webkit-scrollbar{
                display: none;
            }
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 68px;
            transition: width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            z-index: 40;
        }
        .glass-sidebar:hover {
            width: 228px;
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
            max-width: 150px;
        }

        /* Teks di dark glass card */
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
        .glass-card .bg-white {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .border-blue-100,
        .glass-card .border-emerald-100,
        .glass-card .border-amber-100,
        .glass-card .border-slate-200,
        .glass-card .border-white {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .glass-card .bg-emerald-100 { background: rgba(16, 185, 129, 0.2) !important; }
        .glass-card .text-emerald-700 { color: #6ee7b7 !important; }
        .glass-card .bg-amber-100 { background: rgba(245, 158, 11, 0.2) !important; }
        .glass-card .text-amber-700 { color: #fcd34d !important; }
        .glass-card .bg-blue-100 { background: rgba(0, 147, 221, 0.2) !important; }
        .glass-card .text-komdigi-blue { color: #38bdf8 !important; }
        .glass-card .text-komdigi-cerulean { color: #38bdf8 !important; }
        .glass-card .border-b { border-color: rgba(255, 255, 255, 0.08) !important; }
        .glass-card .h-px { background: rgba(255, 255, 255, 0.08) !important; }

        /* Navbar text di dark glass */
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

    <!-- TOP BAR – full width -->
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
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Digital Generation</div>
                    </div>
                </div>

                <!-- Nav Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Beranda</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Absen</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Riwayat</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Laporan</a>
                    <a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Profil</a>
                </nav>

                <!-- User + Logout -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white shadow-md">
                            NR
                        </div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-slate-800 leading-tight">Nisa Ramadani</div>
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
        
        <!-- SIDEBAR collapsible (ikon, expand saat hover) – sedikit geser dari kiri -->
        <aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
            <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Utama</p>
                
                <nav class="space-y-0.5" id="sidebar-nav">
                    <a href="/dashboard" class="sidebar-link active text-sm" title="Beranda">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                    <a href="/absen" class="sidebar-link text-sm" title="Absen">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="sidebar-label">Absen</span>
                    </a>
                    <a href="/riwayat" class="sidebar-link text-sm" title="Riwayat">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="sidebar-label">Riwayat</span>
                    </a>
                    <a href="/grafik" class="sidebar-link text-sm" title="Grafik Perkembangan">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                        </div>
                        <span class="sidebar-label">Grafik Perkembangan</span>
                    </a>
                    <a href="/penilaian" class="sidebar-link text-sm" title="Penilaian & Feedback">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <span class="sidebar-label">Penilaian & Feedback</span>
                    </a>
                    <a href="/laporan" class="sidebar-link text-sm" title="Laporan Akhir">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Laporan Akhir</span>
                    </a>
                    <a href="/sertifikat" class="sidebar-link text-sm" title="Sertifikat">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <span class="sidebar-label">Sertifikat</span>
                    </a>
                    <a href="/izin" class="sidebar-link text-sm" title="Ajukan Ketidakhadiran">
                        <div class="sidebar-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="sidebar-label">Ajukan Ketidakhadiran</span>
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                <!-- Welcome Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-blue-100/80 font-medium">Selamat datang kembali</p>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Nisa Ramadani 👋</h1>
                    </div>
                    <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-white" id="current-date">Rabu, 4 November 2026</p>
                            <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">09.28.46 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- ===================== CARD PESERTA ===================== -->
                <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-komdigi-blue/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-5">
                        <div class="relative shrink-0">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/40">
                                SR
                            </div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                <div>
                                    <h2 class="text-xl font-black text-komdigi-dark">Salwa Rameyza</h2>
                                    <p class="text-sm text-slate-500 font-medium">Peserta Magang • ID: <span class="text-komdigi-blue font-semibold">MKD-2026-0847</span></p>
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
                </div>

                <!-- RINGKASAN ATAS -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-3xl p-5 col-span-2 lg:col-span-1">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-3">Ringkasan Kehadiran</p>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="text-center">
                                <p class="text-2xl font-black text-emerald-600">22</p>
                                <p class="text-[10px] font-semibold text-slate-500 mt-0.5">Hadir</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-amber-500">3</p>
                                <p class="text-[10px] font-semibold text-slate-500 mt-0.5">Terlambat</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-sky-500">1</p>
                                <p class="text-[10px] font-semibold text-slate-500 mt-0.5">Izin</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-rose-500">0</p>
                                <p class="text-[10px] font-semibold text-slate-500 mt-0.5">Alpha</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-3xl p-5 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Skor Kinerja</p>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.5" fill="none" stroke="#E0EDFF" stroke-width="3.5"/>
                                <circle cx="18" cy="18" r="15.5" fill="none" stroke="url(#scoreGrad)" stroke-width="3.5" stroke-dasharray="85 100" stroke-linecap="round"/>
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
                        <p class="text-[10px] font-bold text-emerald-600 mt-1.5 bg-emerald-50 px-2.5 py-0.5 rounded-full">Baik</p>
                    </div>

                    <div class="glass-card rounded-3xl p-5 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Status Magang</p>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100">Aktif</span>
                        <p class="text-[10px] text-slate-400 mt-1.5">Berjalan lancar</p>
                    </div>

                    <div class="glass-card rounded-3xl p-5 flex flex-col items-center justify-center">
                        <p class="text-[11px] font-bold text-komdigi-blue uppercase tracking-wide mb-2">Logbook</p>
                        <div class="flex items-end gap-3">
                            <div class="text-center">
                                <p class="text-2xl font-black text-amber-500">2</p>
                                <p class="text-[10px] font-semibold text-slate-500">Belum isi</p>
                            </div>
                            <div class="w-px h-9 bg-slate-200"></div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-komdigi-blue">1</p>
                                <p class="text-[10px] font-semibold text-slate-500">Menunggu</p>
                            </div>
                        </div>
                        <a href="#" class="text-[11px] font-bold text-komdigi-blue hover:text-komdigi-dark mt-2.5 flex items-center gap-1 transition">
                            Isi logbook 
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <!-- GRAFIK -->
                <div class="glass-card rounded-3xl p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-komdigi-dark">Grafik Perkembangan</h3>
                                <p class="text-xs text-slate-500">Skor kinerja mingguan</p>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu Terakhir</span>
                    </div>
                    <div class="h-64">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>

                <!-- 4 FEATURE CARDS -->
                <div class="grid sm:grid-cols-2 gap-5">

                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-komdigi-blue/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <h3 class="font-bold text-komdigi-dark">Detail Magang</h3>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-100">Aktif</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Periode</span>
                                <span class="font-semibold text-slate-800">1 Okt – 19 Des 2026</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Unit Kerja</span>
                                <span class="font-semibold text-slate-800">Dinas Kominfo Sumut</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Pembimbing</span>
                                <span class="font-semibold text-slate-800">Budi Santoso, S.Kom</span>
                            </div>
                            <div class="pt-3">
                                <div class="flex justify-between text-xs font-semibold text-slate-500 mb-1.5">
                                    <span>Progress Periode</span>
                                    <span class="text-komdigi-blue">42%</span>
                                </div>
                                <div class="h-2 bg-blue-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width: 42%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-amber-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-bold text-komdigi-dark">Absensi Hari Ini</h3>
                            </div>
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-100 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Belum absen
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-2.5 mb-5">
                            <div class="bg-blue-50/70 rounded-2xl p-3 text-center border border-blue-100">
                                <p class="text-[10px] font-semibold text-slate-500 mb-0.5">Masuk</p>
                                <p class="text-sm font-bold text-slate-800">—</p>
                            </div>
                            <div class="bg-blue-50/70 rounded-2xl p-3 text-center border border-blue-100">
                                <p class="text-[10px] font-semibold text-slate-500 mb-0.5">Pulang</p>
                                <p class="text-sm font-bold text-slate-800">—</p>
                            </div>
                            <div class="bg-blue-50/70 rounded-2xl p-3 text-center border border-blue-100">
                                <p class="text-[10px] font-semibold text-slate-500 mb-0.5">Durasi</p>
                                <p class="text-sm font-bold text-slate-800">—</p>
                            </div>
                        </div>
                        <a href="#" class="btn-shine flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Absen Masuk Sekarang
                        </a>
                    </div>

                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-indigo-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                </div>
                                <h3 class="font-bold text-komdigi-dark">Penilaian Pembimbing</h3>
                            </div>
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[11px] font-bold rounded-full border border-indigo-100">4.3 / 5.0</span>
                        </div>
                        
                        <div class="space-y-3.5">
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Disiplin & Kehadiran</span>
                                    <span class="font-bold text-slate-800">4.5</span>
                                </div>
                                <div class="h-1.5 bg-blue-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Kerjasama Tim</span>
                                    <span class="font-bold text-slate-800">4.2</span>
                                </div>
                                <div class="h-1.5 bg-blue-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-komdigi-blue to-sky-400 rounded-full" style="width: 84%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Kompetensi Teknis</span>
                                    <span class="font-bold text-slate-800">4.0</span>
                                </div>
                                <div class="h-1.5 bg-blue-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-400 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Inisiatif & Kreativitas</span>
                                    <span class="font-bold text-slate-800">4.5</span>
                                </div>
                                <div class="h-1.5 bg-blue-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 p-4 bg-blue-50/60 rounded-2xl border border-blue-100">
                            <p class="text-xs text-slate-600 italic leading-relaxed">"Peserta menunjukkan progres yang baik dan aktif berkontribusi dalam proyek digitalisasi."</p>
                            <p class="text-[10px] text-komdigi-blue mt-2 font-medium">— Budi Santoso, S.Kom • 28 Okt 2026</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-3xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-indigo-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h3 class="font-bold text-komdigi-dark">Laporan Akhir</h3>
                            </div>
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-100">Belum dikumpulkan</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-3.5 bg-amber-50/80 rounded-2xl border border-amber-100">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Batas pengumpulan</p>
                                    <p class="text-xs text-amber-700 font-medium">19 Desember 2026 (45 hari lagi)</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-700">Laporan mingguan <span class="text-emerald-600 font-semibold">(5/8)</span></span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-400">Draft laporan akhir</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-400">Persetujuan pembimbing</span>
                                </div>
                            </div>
                            
                            <a href="#" class="btn-shine flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-sm font-bold rounded-2xl shadow-md shadow-indigo-500/25 hover:shadow-lg transition mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Mulai Buat Laporan Akhir
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SERTIFIKAT -->
                <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-amber-300/15 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-komdigi-dark text-lg">Sertifikat Magang</h3>
                                    <p class="text-sm text-slate-500">Kelengkapan syarat penerbitan sertifikat</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-3xl font-black text-amber-500">68%</p>
                                    <p class="text-xs text-slate-500 font-medium">Lengkap</p>
                                </div>
                                <div class="w-16 h-16 relative">
                                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 36 36">
                                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="#FEF3C7" stroke-width="3.5"/>
                                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="#F59E0B" stroke-width="3.5" stroke-dasharray="68 100" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-700">Absensi minimal 80% <span class="text-emerald-600 font-bold">(92%)</span></span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-700">Laporan mingguan <span class="text-emerald-600 font-bold">(5/8)</span></span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-400">Laporan akhir disetujui</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-slate-400">Penilaian pembimbing final</span>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50/60 rounded-2xl p-5 flex flex-col justify-center items-center text-center border border-blue-100">
                                <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center mb-3 border border-blue-100 shadow-sm">
                                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Sertifikat terkunci</p>
                                <p class="text-xs text-slate-500 mt-1 mb-4">Lengkapi semua syarat untuk membuka</p>
                                <button disabled class="px-5 py-2.5 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed border border-slate-200">
                                    Unduh Sertifikat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                            <svg class="w-5 h-5 text-komdigi-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Riwayat</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Catatan kehadiran</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Laporan</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Harian & mingguan</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Izin / Sakit</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Ajukan ketidakhadiran</p>
                    </a>
                    <a href="#" class="glass-card group rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Profil</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Data peserta</p>
                    </a>
                </div>

                <!-- Area Absensi -->
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-100 flex items-center justify-between bg-blue-50/40">
                        <h3 class="font-bold text-komdigi-dark">Area Absensi</h3>
                        <span class="px-3 py-1 bg-blue-100 text-komdigi-blue text-[11px] font-bold rounded-full">Senin–Kamis</span>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 font-medium">Lokasi</span>
                            <span class="text-sm font-semibold text-slate-800 text-right">Dinas Kominfo Provinsi Sumatera Utara</span>
                        </div>
                        <div class="h-px bg-blue-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 font-medium">Radius</span>
                            <span class="text-sm font-semibold text-komdigi-cerulean">2000 meter</span>
                        </div>
                    </div>
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Absen</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Riwayat</span>
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

        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Skor Kinerja',
                    data: [72, 78, 81, 83, 85],
                    borderColor: '#0055FF',
                    backgroundColor: 'rgba(0, 85, 255, 0.1)',
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
                        ticks: { color: '#64748b', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 11 } }
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

        (function setActiveFromUrl() {
            const path = window.location.pathname.replace(/\/$/, '') || '/';
            document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
                const href = link.getAttribute('href')?.replace(/\/$/, '') || '';
                if (href && (path === href || path.startsWith(href + '/'))) {
                    document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        })();
    </script>
</body>
</html>
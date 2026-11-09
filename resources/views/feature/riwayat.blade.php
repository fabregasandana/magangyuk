<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen | Magang Komdigi 2026</title>
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
        .glass-card .text-slate-500, .glass-card .text-slate-400 { color: #94a3b8 !important; }
        .glass-card .text-slate-700, .glass-card .text-slate-800, .glass-card .text-komdigi-dark { color: #e2e8f0 !important; }
        .glass-strong .text-slate-800 { color: #f1f5f9 !important; }
        .glass-strong .text-slate-600, .glass-strong .text-slate-500 { color: #94a3b8 !important; }
        .glass-strong .text-komdigi-dark { color: #f8fafc !important; }
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
        .filter-btn {
            transition: all 0.2s ease;
        }
        .filter-btn.active {
            background: linear-gradient(to right, #0055FF, #0093DD);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(0, 85, 255, 0.35);
        }
        .attendance-item {
            transition: all 0.2s ease;
        }
        .attendance-item:hover {
            background: rgba(255, 255, 255, 0.05);
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
                    <a href="absensi.html" class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Absen</a>
                    <a href="riwayat.html" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">Riwayat</a>
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
                    <a href="absensi.html" class="sidebar-link text-sm" title="Absen">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <span class="sidebar-label">Absen</span>
                    </a>
                    <a href="riwayat.html" class="sidebar-link active text-sm" title="Riwayat">
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

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Riwayat Absen</h1>
                        <p class="text-sm text-blue-100/80 font-medium mt-0.5">Catatan kehadiran selama periode magang</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <select class="glass px-4 py-2.5 rounded-xl text-sm font-semibold text-white border border-white/10 focus:outline-none focus:ring-2 focus:ring-komdigi-cerulean/50 appearance-none cursor-pointer bg-transparent">
                            <option class="bg-slate-900">November 2026</option>
                            <option class="bg-slate-900">Oktober 2026</option>
                            <option class="bg-slate-900">Desember 2026</option>
                        </select>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-emerald-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-3xl font-black text-emerald-400">22</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Hadir</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-3xl font-black text-amber-400">3</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Terlambat</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-sky-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-3xl font-black text-sky-400">1</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Izin</p>
                    </div>
                    <div class="glass-card rounded-3xl p-5 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-rose-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <p class="text-3xl font-black text-rose-400">0</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Alpha</p>
                    </div>
                </div>

                <!-- Filter Pills -->
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-white" data-filter="all">Semua</button>
                    <button class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="hadir">Hadir</button>
                    <button class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="terlambat">Terlambat</button>
                    <button class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="izin">Izin</button>
                    <button class="filter-btn px-4 py-2 text-sm font-semibold rounded-full border border-white/10 text-slate-300 hover:bg-white/5" data-filter="alpha">Alpha</button>
                </div>

                <!-- Daftar Kehadiran -->
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                        <h3 class="font-bold text-white">Daftar Kehadiran</h3>
                        <span class="text-xs font-medium text-slate-400">26 hari tercatat</span>
                    </div>
                    <div class="divide-y divide-white/5" id="attendance-list">
                        <!-- Item 1 - Hadir -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="hadir">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-emerald-400/80 uppercase">NOV</span>
                                    <span class="text-sm font-black text-emerald-400">03</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Senin, 3 November 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 07.58 · Pulang 16.05 · Durasi 8j 7m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 2 - Terlambat -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="terlambat">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-amber-400/80 uppercase">NOV</span>
                                    <span class="text-sm font-black text-amber-400">04</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Selasa, 4 November 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 08.22 · Pulang 16.10 · Durasi 7j 48m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-amber-500/20 text-amber-400 text-[11px] font-bold rounded-full border border-amber-500/30">Terlambat</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 3 - Hadir -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="hadir">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-emerald-400/80 uppercase">NOV</span>
                                    <span class="text-sm font-black text-emerald-400">05</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Rabu, 5 November 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 07.55 · Pulang 16.02 · Durasi 8j 7m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 4 - Izin -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="izin">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-sky-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-sky-400/80 uppercase">OKT</span>
                                    <span class="text-sm font-black text-sky-400">30</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Kamis, 30 Oktober 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Izin sakit · Disetujui pembimbing</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-sky-500/20 text-sky-400 text-[11px] font-bold rounded-full border border-sky-500/30">Izin</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 5 - Hadir -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="hadir">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-emerald-400/80 uppercase">OKT</span>
                                    <span class="text-sm font-black text-emerald-400">29</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Rabu, 29 Oktober 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 07.50 · Pulang 16.00 · Durasi 8j 10m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 6 - Terlambat -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="terlambat">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-amber-400/80 uppercase">OKT</span>
                                    <span class="text-sm font-black text-amber-400">28</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Selasa, 28 Oktober 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 08.18 · Pulang 16.05 · Durasi 7j 47m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-amber-500/20 text-amber-400 text-[11px] font-bold rounded-full border border-amber-500/30">Terlambat</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                        <!-- Item 7 - Hadir -->
                        <div class="attendance-item px-5 py-4 flex items-center justify-between gap-3" data-status="hadir">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-[9px] font-bold text-emerald-400/80 uppercase">OKT</span>
                                    <span class="text-sm font-black text-emerald-400">27</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white">Senin, 27 Oktober 2026</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Masuk 07.52 · Pulang 16.08 · Durasi 8j 16m</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">Hadir</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
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
                    <a href="absensi.html" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                        <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-medium">Absen</span>
                    </a>
                    <a href="riwayat.html" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
                        <div class="w-8 h-8 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-semibold">Riwayat</span>
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

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('text-slate-300');
                });
                this.classList.add('active');
                this.classList.remove('text-slate-300');

                const filter = this.dataset.filter;
                document.querySelectorAll('.attendance-item').forEach(item => {
                    if (filter === 'all' || item.dataset.status === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Sidebar active
        document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('#sidebar-nav .sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>

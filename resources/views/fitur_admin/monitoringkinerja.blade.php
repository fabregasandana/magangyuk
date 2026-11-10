<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kinerja Global | Magang Komdigi 2026</title>
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
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
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
                0 6px 24px rgba(0, 0, 0, 0.16),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #e2e8f0;
        }
        .glass-panel {
            background: rgba(8, 12, 24, 0.35);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(125, 211, 252, 0.28);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.08),
                0 0 24px rgba(0, 147, 221, 0.22),
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
        .glass-sidebar:hover { width: 240px; background: rgba(8, 12, 24, 0.5); }
        .glass-sidebar .sidebar-label {
            opacity: 0; white-space: nowrap; transition: opacity 0.18s ease 0.04s;
            pointer-events: none; font-size: 0.8125rem;
        }
        .glass-sidebar:hover .sidebar-label { opacity: 1; pointer-events: auto; }
        .glass-sidebar .sidebar-section-title {
            opacity: 0; max-height: 0; margin: 0; padding: 0; overflow: hidden; transition: all 0.2s ease;
        }
        .glass-sidebar:hover .sidebar-section-title {
            opacity: 1; max-height: 2rem; margin-bottom: 0.75rem; padding: 0 0.5rem;
        }
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
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar-link.active .sidebar-icon { background: rgba(0, 147, 221, 0.3); }
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent); transition: 0.5s;
        }
        .btn-shine:hover::after { left: 120%; }
        .form-input {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
            color: #f1f5f9; border-radius: 0.75rem; padding: 0.6rem 0.9rem; width: 100%;
            font-size: 0.875rem; transition: all 0.2s;
        }
        .form-input:focus {
            outline: none; border-color: rgba(56,189,248,0.5);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
        }
        .form-input::placeholder { color: #64748b; }
        select.form-input option { background: #0f172a; color: #f1f5f9; }
        .table-row:hover { background: rgba(255,255,255,0.04); }
        .row-alert { background: rgba(239, 68, 68, 0.08) !important; border-left: 3px solid #f87171; }
        .row-warning { background: rgba(245, 158, 11, 0.08) !important; border-left: 3px solid #fbbf24; }
        .modal-overlay { background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); }
        .sort-btn { cursor: pointer; user-select: none; }
        .sort-btn:hover { color: #38bdf8; }
    </style>
</head>
<body class="font-sans antialiased">

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
                        <div class="text-[10px] font-semibold text-komdigi-cerulean">Admin Panel · 2026</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/30 shadow-md">AD</div>
                        <div class="hidden md:block">
                            <div class="text-xs font-bold text-white leading-tight">Admin Komdigi</div>
                            <div class="text-[10px] text-emerald-400 font-medium">● Online</div>
                        </div>
                    </div>
                    <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg transition shadow-md">Keluar</a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">
        <!-- SIDEBAR -->
        <aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
            <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
                <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Admin Menu</p>
                <nav class="space-y-0.5">
                    <a href="#" class="sidebar-link text-sm" title="Dashboard">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="sidebar-label">Dashboard Admin</span>
                    </a>
                    <a href="manajemen-peserta.html" class="sidebar-link text-sm" title="Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <span class="sidebar-label">Manajemen Peserta</span>
                    </a>
                    <a href="manajemen-pembimbing.html" class="sidebar-link text-sm" title="Pembimbing">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        <span class="sidebar-label">Manajemen Pembimbing</span>
                    </a>
                    <a href="monitoring-kinerja.html" class="sidebar-link active text-sm" title="Kinerja">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                        <span class="sidebar-label">Monitoring Kinerja</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Kehadiran">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <span class="sidebar-label">Monitoring Kehadiran</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Laporan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan & Penilaian</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Sertifikat">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg></div>
                        <span class="sidebar-label">Sertifikat</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Pengaturan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <span class="sidebar-label">Pengaturan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                <!-- Header -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Monitoring Kinerja Global</h1>
                        <p class="text-sm text-blue-100/80 mt-0.5">Performa seluruh peserta magang Komdigi 2026</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="exportLaporan()" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export Laporan
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-white">48</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Total Peserta</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-emerald-400">38</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Kinerja Baik</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-amber-400">6</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Perlu Perhatian</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-rose-400">4</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Bermasalah</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-sky-400">82.4</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Rata-rata Skor</p>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap gap-4 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-rose-500/40 border-l-2 border-rose-400"></span>
                        <span class="text-slate-400">Bermasalah (skor &lt;70 atau kehadiran &lt;70%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-amber-500/40 border-l-2 border-amber-400"></span>
                        <span class="text-slate-400">Perlu perhatian (skor 70–79 atau kehadiran 70–79%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-emerald-500/20"></span>
                        <span class="text-slate-400">Baik (≥80)</span>
                    </div>
                </div>

                <!-- Filters -->
                <div class="glass-card rounded-2xl p-4">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Cari</label>
                            <input type="text" id="searchInput" placeholder="Nama / ID..." class="form-input" oninput="filterTable()">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Status Kinerja</label>
                            <select id="filterKinerja" class="form-input" onchange="filterTable()">
                                <option value="">Semua</option>
                                <option value="baik">Baik</option>
                                <option value="perhatian">Perlu Perhatian</option>
                                <option value="bermasalah">Bermasalah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Status Peserta</label>
                            <select id="filterStatus" class="form-input" onchange="filterTable()">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Periode</label>
                            <select id="filterPeriode" class="form-input" onchange="filterTable()">
                                <option value="">Semua Periode</option>
                                <option value="okt-des">Okt – Des 2026</option>
                                <option value="jul-sep">Jul – Sep 2026</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Urutkan</label>
                            <select id="sortBy" class="form-input" onchange="sortTable()">
                                <option value="skor-desc">Skor Tertinggi</option>
                                <option value="skor-asc">Skor Terendah</option>
                                <option value="hadir-desc">Kehadiran Tertinggi</option>
                                <option value="hadir-asc">Kehadiran Terendah</option>
                                <option value="nama">Nama A–Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="kinerjaTable">
                            <thead>
                                <tr class="border-b border-white/10">
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn" onclick="setSort('nama')">Peserta</th>
                                    <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn" onclick="setSort('skor')">Skor <span class="text-komdigi-cerulean">↕</span></th>
                                    <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn" onclick="setSort('hadir')">Kehadiran <span class="text-komdigi-cerulean">↕</span></th>
                                    <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Penilaian</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kinerjaBody">
                                <!-- Baik -->
                                <tr class="table-row border-b border-white/5" data-name="nisa ramadani" data-skor="85" data-hadir="92" data-kinerja="baik" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">NR</div>
                                            <div>
                                                <p class="font-semibold text-white">Nisa Ramadani</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0847</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="text-emerald-400 font-bold text-base">85</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-emerald-400 font-bold">92%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-emerald-400 rounded-full" style="width:92%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="text-amber-400 font-bold">4.3</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Budi Santoso</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/30">Baik</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Nisa Ramadani', 85, 92, 4.3)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Baik -->
                                <tr class="table-row border-b border-white/5" data-name="dewi lestari" data-skor="88" data-hadir="96" data-kinerja="baik" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white text-xs font-bold shrink-0">DL</div>
                                            <div>
                                                <p class="font-semibold text-white">Dewi Lestari</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0851</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-emerald-400 font-bold text-base">88</span></td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-emerald-400 font-bold">96%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-emerald-400 rounded-full" style="width:96%"></div></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold">4.5</span></td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Sari Dewi</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/30">Baik</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Dewi Lestari', 88, 96, 4.5)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Perhatian -->
                                <tr class="table-row border-b border-white/5 row-warning" data-name="ahmad fauzi" data-skor="74" data-hadir="78" data-kinerja="perhatian" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0">AF</div>
                                            <div>
                                                <p class="font-semibold text-white">Ahmad Fauzi</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0848</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold text-base">74</span></td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-amber-400 font-bold">78%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-amber-400 rounded-full" style="width:78%"></div></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold">3.8</span></td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Sari Dewi</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-500/20 text-amber-400 text-[10px] font-bold rounded-full border border-amber-500/30">Perhatian</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Ahmad Fauzi', 74, 78, 3.8)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Bermasalah -->
                                <tr class="table-row border-b border-white/5 row-alert" data-name="reza maulana" data-skor="58" data-hadir="62" data-kinerja="bermasalah" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center text-white text-xs font-bold shrink-0">RM</div>
                                            <div>
                                                <p class="font-semibold text-white">Reza Maulana</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0850</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-rose-400 font-bold text-base">58</span></td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-rose-400 font-bold">62%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-rose-400 rounded-full" style="width:62%"></div></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-rose-400 font-bold">3.1</span></td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Budi Santoso</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-rose-500/20 text-rose-400 text-[10px] font-bold rounded-full border border-rose-500/30">Bermasalah</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Reza Maulana', 58, 62, 3.1)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Baik -->
                                <tr class="table-row border-b border-white/5" data-name="siti nurhaliza" data-skor="81" data-hadir="88" data-kinerja="baik" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center text-white text-xs font-bold shrink-0">SN</div>
                                            <div>
                                                <p class="font-semibold text-white">Siti Nurhaliza</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0849</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-emerald-400 font-bold text-base">81</span></td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-emerald-400 font-bold">88%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-emerald-400 rounded-full" style="width:88%"></div></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold">4.0</span></td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Andi Pratama</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/30">Baik</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Siti Nurhaliza', 81, 88, 4.0)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Bermasalah - low attendance -->
                                <tr class="table-row border-b border-white/5 row-alert" data-name="bayu pratama" data-skor="72" data-hadir="55" data-kinerja="bermasalah" data-status="aktif" data-periode="okt-des">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white text-xs font-bold shrink-0">BP</div>
                                            <div>
                                                <p class="font-semibold text-white">Bayu Pratama</p>
                                                <p class="text-[11px] text-slate-400">MKD-2026-0852</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold text-base">72</span></td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-rose-400 font-bold">55%</span>
                                            <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-rose-400 rounded-full" style="width:55%"></div></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center"><span class="text-amber-400 font-bold">3.5</span></td>
                                    <td class="px-4 py-3.5 text-slate-300 text-xs">Andi Pratama</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-rose-500/20 text-rose-400 text-[10px] font-bold rounded-full border border-rose-500/30">Bermasalah</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <button onclick="viewDetail('Bayu Pratama', 72, 55, 3.5)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-white/10 flex items-center justify-between">
                        <p class="text-xs text-slate-400">Menampilkan 1–6 dari 48 peserta</p>
                        <div class="flex gap-1">
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-semibold hover:bg-white/10 disabled:opacity-40" disabled>‹</button>
                            <button class="w-8 h-8 rounded-lg bg-komdigi-blue/30 text-white text-xs font-semibold">1</button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-semibold hover:bg-white/10">2</button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-semibold hover:bg-white/10">3</button>
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-semibold hover:bg-white/10">›</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL Detail -->
    <div id="modalDetail" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal()"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white">Detail Kinerja Peserta</h3>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="detailContent"></div>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
            document.getElementById('modalDetail').classList.remove('flex');
        }
        function exportLaporan() {
            alert('Laporan kinerja global berhasil diexport ke Excel!');
        }
        function viewDetail(name, skor, hadir, penilaian) {
            const initials = name.split(' ').map(w => w[0]).slice(0,2).join('');
            const statusLabel = skor < 70 || hadir < 70 ? 'Bermasalah' : skor < 80 || hadir < 80 ? 'Perlu Perhatian' : 'Baik';
            const statusColor = skor < 70 || hadir < 70 ? 'rose' : skor < 80 || hadir < 80 ? 'amber' : 'emerald';
            document.getElementById('detailContent').innerHTML = `
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xl font-black">${initials}</div>
                    <div>
                        <h4 class="text-xl font-black text-white">${name}</h4>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-${statusColor}-500/20 text-${statusColor}-400 text-[11px] font-bold rounded-full border border-${statusColor}-500/30 mt-1">${statusLabel}</span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-white">${skor}</p>
                        <p class="text-[11px] text-slate-400">Skor Kinerja</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-white">${hadir}%</p>
                        <p class="text-[11px] text-slate-400">Kehadiran</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-amber-400">${penilaian}</p>
                        <p class="text-[11px] text-slate-400">Penilaian</p>
                    </div>
                </div>
                <div class="bg-white/5 rounded-xl p-4 border border-white/10 mb-4">
                    <p class="text-xs font-semibold text-slate-400 mb-3">Rincian Mingguan (Skor)</p>
                    <div class="flex items-end gap-2 h-24">
                        ${[72,78,81,83,skor].map((v,i) => `
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <span class="text-[10px] text-slate-400">${v}</span>
                                <div class="w-full bg-komdigi-cerulean/80 rounded-t" style="height:${v}%"></div>
                                <span class="text-[9px] text-slate-500">M${i+1}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">Hadir</p>
                        <p class="text-sm text-white font-semibold">${Math.round(hadir/100*25)} hari</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">Terlambat / Alpha</p>
                        <p class="text-sm text-white font-semibold">${hadir < 70 ? '3 / 2' : hadir < 85 ? '2 / 0' : '1 / 0'}</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">Laporan Mingguan</p>
                        <p class="text-sm text-white font-semibold">${skor >= 80 ? '5/8 disetujui' : '3/8 disetujui'}</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">Pembimbing</p>
                        <p class="text-sm text-white font-semibold">Budi Santoso, S.Kom</p>
                    </div>
                </div>
            `;
            document.getElementById('modalDetail').classList.remove('hidden');
            document.getElementById('modalDetail').classList.add('flex');
        }
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const kinerja = document.getElementById('filterKinerja').value;
            const status = document.getElementById('filterStatus').value;
            const periode = document.getElementById('filterPeriode').value;
            document.querySelectorAll('#kinerjaBody tr').forEach(row => {
                const matchSearch = !search || row.dataset.name.includes(search);
                const matchKinerja = !kinerja || row.dataset.kinerja === kinerja;
                const matchStatus = !status || row.dataset.status === status;
                const matchPeriode = !periode || row.dataset.periode === periode;
                row.style.display = (matchSearch && matchKinerja && matchStatus && matchPeriode) ? '' : 'none';
            });
        }
        function sortTable() {
            const sortBy = document.getElementById('sortBy').value;
            const tbody = document.getElementById('kinerjaBody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            rows.sort((a, b) => {
                if (sortBy === 'skor-desc') return Number(b.dataset.skor) - Number(a.dataset.skor);
                if (sortBy === 'skor-asc') return Number(a.dataset.skor) - Number(b.dataset.skor);
                if (sortBy === 'hadir-desc') return Number(b.dataset.hadir) - Number(a.dataset.hadir);
                if (sortBy === 'hadir-asc') return Number(a.dataset.hadir) - Number(b.dataset.hadir);
                if (sortBy === 'nama') return a.dataset.name.localeCompare(b.dataset.name);
                return 0;
            });
            rows.forEach(r => tbody.appendChild(r));
        }
        function setSort(type) {
            const sel = document.getElementById('sortBy');
            if (type === 'skor') sel.value = sel.value === 'skor-desc' ? 'skor-asc' : 'skor-desc';
            else if (type === 'hadir') sel.value = sel.value === 'hadir-desc' ? 'hadir-asc' : 'hadir-desc';
            else sel.value = 'nama';
            sortTable();
        }
    </script>
</body>
</html>

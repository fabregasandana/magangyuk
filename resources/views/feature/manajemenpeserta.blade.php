<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peserta | Magang Komdigi 2026</title>
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
        table { border-collapse: separate; border-spacing: 0; }
        .table-row:hover { background: rgba(255,255,255,0.04); }
        .modal-overlay { background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); }
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
                    <a href="manajemen-peserta.html" class="sidebar-link active text-sm" title="Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <span class="sidebar-label">Manajemen Peserta</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Pembimbing">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        <span class="sidebar-label">Manajemen Pembimbing</span>
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
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Manajemen Peserta</h1>
                        <p class="text-sm text-blue-100/80 mt-0.5">Kelola data peserta magang Komdigi 2026</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="openImportModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Import Excel
                        </button>
                        <button onclick="exportData()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export
                        </button>
                        <button onclick="openAddModal()" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Peserta
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-white">48</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Total Peserta</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-emerald-400">42</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Aktif</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-amber-400">4</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Nonaktif</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-sky-400">2</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Selesai</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="glass-card rounded-2xl p-4">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Cari</label>
                            <input type="text" id="searchInput" placeholder="Nama / ID / NIM..." class="form-input" oninput="filterTable()">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Institusi</label>
                            <select id="filterInstitusi" class="form-input" onchange="filterTable()">
                                <option value="">Semua Institusi</option>
                                <option value="USU">Universitas Sumatera Utara</option>
                                <option value="UNIMED">Universitas Negeri Medan</option>
                                <option value="ITM">Institut Teknologi Medan</option>
                                <option value="UISU">Universitas Islam Sumatera Utara</option>
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
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Status</label>
                            <select id="filterStatus" class="form-input" onchange="filterTable()">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Pembimbing</label>
                            <select id="filterPembimbing" class="form-input" onchange="filterTable()">
                                <option value="">Semua Pembimbing</option>
                                <option value="budi">Budi Santoso, S.Kom</option>
                                <option value="sari">Sari Dewi, M.Kom</option>
                                <option value="andi">Andi Pratama, S.T</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-white/10">
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">ID / NIM</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Institusi</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Periode</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pesertaTable">
                                <!-- Row 1 -->
                                <tr class="table-row border-b border-white/5" data-institusi="USU" data-status="aktif" data-pembimbing="budi" data-periode="okt-des" data-name="nisa ramadani mkd-2026-0847 210401023">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold shrink-0">NR</div>
                                            <div>
                                                <p class="font-semibold text-white">Nisa Ramadani</p>
                                                <p class="text-[11px] text-slate-400">nisa.ramadani@students.usu.ac.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-komdigi-cerulean font-semibold">MKD-2026-0847</p>
                                        <p class="text-[11px] text-slate-400">210401023</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300">Universitas Sumatera Utara</td>
                                    <td class="px-4 py-3.5 text-slate-300">Budi Santoso, S.Kom</td>
                                    <td class="px-4 py-3.5 text-slate-300">Okt – Des 2026</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Nisa Ramadani')" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Nisa Ramadani')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Nisa Ramadani')" title="Assign Pembimbing" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="table-row border-b border-white/5" data-institusi="UNIMED" data-status="aktif" data-pembimbing="sari" data-periode="okt-des" data-name="ahmad fauzi mkd-2026-0848 210501044">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0">AF</div>
                                            <div>
                                                <p class="font-semibold text-white">Ahmad Fauzi</p>
                                                <p class="text-[11px] text-slate-400">ahmad.fauzi@unimed.ac.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-komdigi-cerulean font-semibold">MKD-2026-0848</p>
                                        <p class="text-[11px] text-slate-400">210501044</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300">Universitas Negeri Medan</td>
                                    <td class="px-4 py-3.5 text-slate-300">Sari Dewi, M.Kom</td>
                                    <td class="px-4 py-3.5 text-slate-300">Okt – Des 2026</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Ahmad Fauzi')" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Ahmad Fauzi')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Ahmad Fauzi')" title="Assign Pembimbing" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="table-row border-b border-white/5" data-institusi="ITM" data-status="aktif" data-pembimbing="andi" data-periode="okt-des" data-name="siti nurhaliza mkd-2026-0849 220301012">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center text-white text-xs font-bold shrink-0">SN</div>
                                            <div>
                                                <p class="font-semibold text-white">Siti Nurhaliza</p>
                                                <p class="text-[11px] text-slate-400">siti.nur@itm.ac.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-komdigi-cerulean font-semibold">MKD-2026-0849</p>
                                        <p class="text-[11px] text-slate-400">220301012</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300">Institut Teknologi Medan</td>
                                    <td class="px-4 py-3.5 text-slate-300">Andi Pratama, S.T</td>
                                    <td class="px-4 py-3.5 text-slate-300">Okt – Des 2026</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Siti Nurhaliza')" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Siti Nurhaliza')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Siti Nurhaliza')" title="Assign Pembimbing" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 - Nonaktif -->
                                <tr class="table-row border-b border-white/5 opacity-60" data-institusi="UISU" data-status="nonaktif" data-pembimbing="budi" data-periode="okt-des" data-name="reza maulana mkd-2026-0850 210701033">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold shrink-0">RM</div>
                                            <div>
                                                <p class="font-semibold text-white">Reza Maulana</p>
                                                <p class="text-[11px] text-slate-400">reza.m@uisu.ac.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-komdigi-cerulean font-semibold">MKD-2026-0850</p>
                                        <p class="text-[11px] text-slate-400">210701033</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300">Universitas Islam Sumatera Utara</td>
                                    <td class="px-4 py-3.5 text-slate-300">Budi Santoso, S.Kom</td>
                                    <td class="px-4 py-3.5 text-slate-300">Okt – Des 2026</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-500/20 text-slate-400 text-[11px] font-bold rounded-full border border-slate-500/30">
                                            Nonaktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Reza Maulana')" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Reza Maulana')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Reza Maulana')" title="Assign Pembimbing" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Aktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-slate-400 hover:text-emerald-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 5 -->
                                <tr class="table-row border-b border-white/5" data-institusi="USU" data-status="aktif" data-pembimbing="sari" data-periode="okt-des" data-name="dewi lestari mkd-2026-0851 210401055">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white text-xs font-bold shrink-0">DL</div>
                                            <div>
                                                <p class="font-semibold text-white">Dewi Lestari</p>
                                                <p class="text-[11px] text-slate-400">dewi.lestari@students.usu.ac.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-komdigi-cerulean font-semibold">MKD-2026-0851</p>
                                        <p class="text-[11px] text-slate-400">210401055</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-300">Universitas Sumatera Utara</td>
                                    <td class="px-4 py-3.5 text-slate-300">Sari Dewi, M.Kom</td>
                                    <td class="px-4 py-3.5 text-slate-300">Okt – Des 2026</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Dewi Lestari')" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Dewi Lestari')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Dewi Lestari')" title="Assign Pembimbing" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-4 py-3 border-t border-white/10 flex items-center justify-between">
                        <p class="text-xs text-slate-400">Menampilkan 1–5 dari 48 peserta</p>
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

    <!-- MODAL: Tambah / Edit Peserta -->
    <div id="modalPeserta" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalPeserta')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white" id="modalPesertaTitle">Tambah Peserta</h3>
                    <button onclick="closeModal('modalPeserta')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form class="space-y-4" onsubmit="savePeserta(event)">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Lengkap</label>
                            <input type="text" class="form-input" placeholder="Nama lengkap" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">NIM / NIS</label>
                            <input type="text" class="form-input" placeholder="NIM" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Email</label>
                            <input type="email" class="form-input" placeholder="email@example.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">No. HP</label>
                            <input type="tel" class="form-input" placeholder="08xxxxxxxxxx">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Institusi</label>
                            <select class="form-input" required>
                                <option value="">Pilih institusi</option>
                                <option>Universitas Sumatera Utara</option>
                                <option>Universitas Negeri Medan</option>
                                <option>Institut Teknologi Medan</option>
                                <option>Universitas Islam Sumatera Utara</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Program Studi</label>
                            <input type="text" class="form-input" placeholder="Contoh: Ilmu Komputer">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Pembimbing</label>
                            <select class="form-input">
                                <option value="">Pilih pembimbing</option>
                                <option>Budi Santoso, S.Kom</option>
                                <option>Sari Dewi, M.Kom</option>
                                <option>Andi Pratama, S.T</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Periode</label>
                            <select class="form-input" required>
                                <option value="">Pilih periode</option>
                                <option>Okt – Des 2026</option>
                                <option>Jul – Sep 2026</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Status</label>
                            <select class="form-input">
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('modalPeserta')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Assign Pembimbing -->
    <div id="modalAssign" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalAssign')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Assign / Ganti Pembimbing</h3>
                    <button onclick="closeModal('modalAssign')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-slate-400 mb-4">Peserta: <span id="assignPesertaName" class="text-white font-semibold"></span></p>
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Pilih Pembimbing</label>
                    <select class="form-input">
                        <option>Budi Santoso, S.Kom</option>
                        <option>Sari Dewi, M.Kom</option>
                        <option>Andi Pratama, S.T</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeModal('modalAssign')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="closeModal('modalAssign'); alert('Pembimbing berhasil diubah!')" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Import Excel -->
    <div id="modalImport" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalImport')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Import Data Peserta</h3>
                    <button onclick="closeModal('modalImport')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-slate-400 mb-4">Upload file Excel (.xlsx) berisi data peserta. Pastikan format kolom sesuai template.</p>
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/15 rounded-2xl cursor-pointer bg-white/5 hover:bg-white/8 hover:border-komdigi-cerulean/40 transition mb-4">
                    <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-sm text-slate-400"><span class="font-semibold text-komdigi-cerulean">Pilih file Excel</span></p>
                    <p class="text-xs text-slate-500 mt-0.5">.xlsx, max 5MB</p>
                    <input type="file" class="hidden" accept=".xlsx,.xls">
                </label>
                <a href="#" class="text-xs text-komdigi-cerulean hover:underline mb-4 inline-block">↓ Download template Excel</a>
                <div class="flex gap-3">
                    <button onclick="closeModal('modalImport')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="closeModal('modalImport'); alert('Data berhasil diimport!')" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail Peserta -->
    <div id="modalDetail" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalDetail')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white">Detail Peserta</h3>
                    <button onclick="closeModal('modalDetail')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="detailContent" class="space-y-5">
                    <!-- filled by JS -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
        function openAddModal() {
            document.getElementById('modalPesertaTitle').textContent = 'Tambah Peserta';
            openModal('modalPeserta');
        }
        function openEditModal(name) {
            document.getElementById('modalPesertaTitle').textContent = 'Edit Peserta – ' + name;
            openModal('modalPeserta');
        }
        function openAssignModal(name) {
            document.getElementById('assignPesertaName').textContent = name;
            openModal('modalAssign');
        }
        function openImportModal() {
            openModal('modalImport');
        }
        function savePeserta(e) {
            e.preventDefault();
            closeModal('modalPeserta');
            alert('Data peserta berhasil disimpan!');
        }
        function exportData() {
            alert('Data peserta berhasil diexport ke Excel!');
        }
        function toggleStatus(btn) {
            if (confirm('Ubah status peserta ini?')) {
                alert('Status peserta berhasil diubah.');
            }
        }
        function viewDetail(name) {
            document.getElementById('detailContent').innerHTML = `
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xl font-black">${name.split(' ').map(w=>w[0]).join('').slice(0,2)}</div>
                    <div>
                        <h4 class="text-xl font-black text-white">${name}</h4>
                        <p class="text-sm text-slate-400">MKD-2026-0847 · Aktif</p>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-[11px] font-semibold text-slate-400 mb-1">Email</p>
                        <p class="text-sm text-white">email@students.usu.ac.id</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-[11px] font-semibold text-slate-400 mb-1">No. HP</p>
                        <p class="text-sm text-white">0812-3456-7890</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-[11px] font-semibold text-slate-400 mb-1">Institusi</p>
                        <p class="text-sm text-white">Universitas Sumatera Utara</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <p class="text-[11px] font-semibold text-slate-400 mb-1">Pembimbing</p>
                        <p class="text-sm text-white">Budi Santoso, S.Kom</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mt-2">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-emerald-400">22</p>
                        <p class="text-[11px] text-slate-400">Hadir</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-komdigi-cerulean">85</p>
                        <p class="text-[11px] text-slate-400">Skor Kinerja</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-amber-400">4.3</p>
                        <p class="text-[11px] text-slate-400">Penilaian</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button class="flex-1 py-2.5 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10">Lihat Logbook</button>
                    <button class="flex-1 py-2.5 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10">Lihat Kehadiran</button>
                    <button class="flex-1 py-2.5 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10">Lihat Penilaian</button>
                </div>
            `;
            openModal('modalDetail');
        }
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const institusi = document.getElementById('filterInstitusi').value;
            const status = document.getElementById('filterStatus').value;
            const pembimbing = document.getElementById('filterPembimbing').value;
            const periode = document.getElementById('filterPeriode').value;
            document.querySelectorAll('#pesertaTable tr').forEach(row => {
                const matchSearch = !search || row.dataset.name.includes(search);
                const matchInst = !institusi || row.dataset.institusi === institusi;
                const matchStatus = !status || row.dataset.status === status;
                const matchPemb = !pembimbing || row.dataset.pembimbing === pembimbing;
                const matchPeriode = !periode || row.dataset.periode === periode;
                row.style.display = (matchSearch && matchInst && matchStatus && matchPemb && matchPeriode) ? '' : 'none';
            });
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembimbing | Magang Komdigi 2026</title>
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
                    <a href="manajemen-peserta.html" class="sidebar-link text-sm" title="Peserta">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                        <span class="sidebar-label">Manajemen Peserta</span>
                    </a>
                    <a href="manajemen-pembimbing.html" class="sidebar-link active text-sm" title="Pembimbing">
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
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Manajemen Pembimbing</h1>
                        <p class="text-sm text-blue-100/80 mt-0.5">Kelola data pembimbing lapangan magang Komdigi 2026</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="openAddModal()" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Pembimbing
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-white">12</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Total Pembimbing</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-emerald-400">10</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Aktif</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-sky-400">48</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Peserta Dibimbing</p>
                    </div>
                    <div class="glass-card rounded-2xl p-4 text-center">
                        <p class="text-3xl font-black text-amber-400">4.2</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Rata-rata Skor</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="glass-card rounded-2xl p-4">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Cari</label>
                            <input type="text" id="searchInput" placeholder="Nama / NIP / Email..." class="form-input" oninput="filterTable()">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Unit Kerja</label>
                            <select id="filterUnit" class="form-input" onchange="filterTable()">
                                <option value="">Semua Unit</option>
                                <option value="kominfo">Dinas Kominfo Sumut</option>
                                <option value="diskominfo">Diskominfo Medan</option>
                                <option value="bkpsdm">BKPSDM</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Status</label>
                            <select id="filterStatus" class="form-input" onchange="filterTable()">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Beban Bimbingan</label>
                            <select id="filterBeban" class="form-input" onchange="filterTable()">
                                <option value="">Semua</option>
                                <option value="rendah">0–3 peserta</option>
                                <option value="sedang">4–6 peserta</option>
                                <option value="tinggi">7+ peserta</option>
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
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">NIP / Unit</th>
                                    <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                                    <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Skor</th>
                                    <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pembimbingTable">
                                <!-- Row 1 -->
                                <tr class="table-row border-b border-white/5" data-unit="kominfo" data-status="aktif" data-beban="sedang" data-name="budi santoso 197805152005011002">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shrink-0">BS</div>
                                            <div>
                                                <p class="font-semibold text-white">Budi Santoso, S.Kom</p>
                                                <p class="text-[11px] text-slate-400">budi.santoso@sumutprov.go.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-300 text-xs">197805152005011002</p>
                                        <p class="text-[11px] text-slate-400">Dinas Kominfo Sumut</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-komdigi-blue/20 text-komdigi-cerulean text-sm font-bold">5</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <span class="text-amber-400 font-bold">4.3</span>
                                            <div class="w-16 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: 86%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Budi Santoso, S.Kom', 5, 4.3)" title="Detail & Performa" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Budi Santoso, S.Kom')" title="Assign / Unassign Peserta" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Budi Santoso, S.Kom')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="table-row border-b border-white/5" data-unit="kominfo" data-status="aktif" data-beban="sedang" data-name="sari dewi 198203102008012003">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center text-white text-xs font-bold shrink-0">SD</div>
                                            <div>
                                                <p class="font-semibold text-white">Sari Dewi, M.Kom</p>
                                                <p class="text-[11px] text-slate-400">sari.dewi@sumutprov.go.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-300 text-xs">198203102008012003</p>
                                        <p class="text-[11px] text-slate-400">Dinas Kominfo Sumut</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-komdigi-blue/20 text-komdigi-cerulean text-sm font-bold">6</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <span class="text-amber-400 font-bold">4.5</span>
                                            <div class="w-16 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: 90%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Sari Dewi, M.Kom', 6, 4.5)" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Sari Dewi, M.Kom')" title="Assign Peserta" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Sari Dewi, M.Kom')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="table-row border-b border-white/5" data-unit="diskominfo" data-status="aktif" data-beban="rendah" data-name="andi pratama 199001202015011005">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white text-xs font-bold shrink-0">AP</div>
                                            <div>
                                                <p class="font-semibold text-white">Andi Pratama, S.T</p>
                                                <p class="text-[11px] text-slate-400">andi.pratama@medan.go.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-300 text-xs">199001202015011005</p>
                                        <p class="text-[11px] text-slate-400">Diskominfo Medan</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-komdigi-blue/20 text-komdigi-cerulean text-sm font-bold">3</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <span class="text-amber-400 font-bold">4.0</span>
                                            <div class="w-16 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: 80%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Aktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Andi Pratama, S.T', 3, 4.0)" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Andi Pratama, S.T')" title="Assign Peserta" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Andi Pratama, S.T')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Nonaktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 - Nonaktif -->
                                <tr class="table-row border-b border-white/5 opacity-60" data-unit="bkpsdm" data-status="nonaktif" data-beban="rendah" data-name="rina wulandari 198506152010012004">
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-xs font-bold shrink-0">RW</div>
                                            <div>
                                                <p class="font-semibold text-white">Rina Wulandari, S.Sos</p>
                                                <p class="text-[11px] text-slate-400">rina.w@sumutprov.go.id</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-300 text-xs">198506152010012004</p>
                                        <p class="text-[11px] text-slate-400">BKPSDM</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 text-slate-400 text-sm font-bold">0</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="text-slate-500 text-sm">—</span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-500/20 text-slate-400 text-[11px] font-bold rounded-full border border-slate-500/30">
                                            Nonaktif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1">
                                            <button onclick="viewDetail('Rina Wulandari, S.Sos', 0, 0)" title="Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button onclick="openAssignModal('Rina Wulandari, S.Sos')" title="Assign" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </button>
                                            <button onclick="openEditModal('Rina Wulandari, S.Sos')" title="Edit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button onclick="toggleStatus(this)" title="Aktifkan" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-slate-400 hover:text-emerald-400 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-white/10 flex items-center justify-between">
                        <p class="text-xs text-slate-400">Menampilkan 1–4 dari 12 pembimbing</p>
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

    <!-- MODAL: Tambah / Edit Pembimbing -->
    <div id="modalPembimbing" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalPembimbing')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white" id="modalPembimbingTitle">Tambah Pembimbing</h3>
                    <button onclick="closeModal('modalPembimbing')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form class="space-y-4" onsubmit="savePembimbing(event)">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Lengkap & Gelar</label>
                            <input type="text" class="form-input" placeholder="Contoh: Budi Santoso, S.Kom" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">NIP</label>
                            <input type="text" class="form-input" placeholder="NIP" required>
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
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Unit Kerja</label>
                            <select class="form-input" required>
                                <option value="">Pilih unit</option>
                                <option>Dinas Kominfo Sumut</option>
                                <option>Diskominfo Medan</option>
                                <option>BKPSDM</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Jabatan</label>
                            <input type="text" class="form-input" placeholder="Contoh: Analis Kebijakan">
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
                        <button type="button" onclick="closeModal('modalPembimbing')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Assign / Unassign Peserta -->
    <div id="modalAssign" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalAssign')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Assign / Unassign Peserta</h3>
                    <button onclick="closeModal('modalAssign')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-slate-400 mb-4">Pembimbing: <span id="assignPembimbingName" class="text-white font-semibold"></span></p>
                
                <div class="mb-4">
                    <p class="text-xs font-semibold text-slate-400 mb-2">Peserta yang dibimbing saat ini</p>
                    <div class="space-y-2 max-h-40 overflow-y-auto" id="assignedList">
                        <div class="flex items-center justify-between bg-white/5 rounded-xl px-3 py-2 border border-white/10">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">NR</div>
                                <span class="text-sm text-white">Nisa Ramadani</span>
                            </div>
                            <button class="text-xs text-rose-400 hover:text-rose-300 font-semibold" onclick="this.parentElement.remove()">Unassign</button>
                        </div>
                        <div class="flex items-center justify-between bg-white/5 rounded-xl px-3 py-2 border border-white/10">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-500/30 flex items-center justify-center text-[10px] font-bold text-white">AF</div>
                                <span class="text-sm text-white">Ahmad Fauzi</span>
                            </div>
                            <button class="text-xs text-rose-400 hover:text-rose-300 font-semibold" onclick="this.parentElement.remove()">Unassign</button>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Tambah Peserta</label>
                    <select class="form-input">
                        <option value="">Pilih peserta yang belum di-assign</option>
                        <option>Siti Nurhaliza – MKD-2026-0849</option>
                        <option>Dewi Lestari – MKD-2026-0851</option>
                        <option>Reza Maulana – MKD-2026-0850</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeModal('modalAssign')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="closeModal('modalAssign'); alert('Assign peserta berhasil disimpan!')" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail & Performa -->
    <div id="modalDetail" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalDetail')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white">Detail & Performa Pembimbing</h3>
                    <button onclick="closeModal('modalDetail')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="detailContent"></div>
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
            document.getElementById('modalPembimbingTitle').textContent = 'Tambah Pembimbing';
            openModal('modalPembimbing');
        }
        function openEditModal(name) {
            document.getElementById('modalPembimbingTitle').textContent = 'Edit Pembimbing – ' + name;
            openModal('modalPembimbing');
        }
        function openAssignModal(name) {
            document.getElementById('assignPembimbingName').textContent = name;
            openModal('modalAssign');
        }
        function savePembimbing(e) {
            e.preventDefault();
            closeModal('modalPembimbing');
            alert('Data pembimbing berhasil disimpan!');
        }
        function toggleStatus(btn) {
            if (confirm('Ubah status pembimbing ini?')) {
                alert('Status pembimbing berhasil diubah.');
            }
        }
        function viewDetail(name, peserta, skor) {
            const initials = name.split(' ').filter(w => w.length > 1).map(w => w[0]).slice(0,2).join('');
            document.getElementById('detailContent').innerHTML = `
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xl font-black">${initials}</div>
                    <div>
                        <h4 class="text-xl font-black text-white">${name}</h4>
                        <p class="text-sm text-slate-400">Dinas Kominfo Sumut · Aktif</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-komdigi-cerulean">${peserta}</p>
                        <p class="text-[11px] text-slate-400">Peserta Dibimbing</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-amber-400">${skor || '—'}</p>
                        <p class="text-[11px] text-slate-400">Rata-rata Skor</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                        <p class="text-2xl font-black text-emerald-400">${skor >= 4.3 ? 'Baik' : skor >= 4 ? 'Cukup' : '—'}</p>
                        <p class="text-[11px] text-slate-400">Performa</p>
                    </div>
                </div>
                <div class="bg-white/5 rounded-xl p-4 border border-white/10 mb-4">
                    <p class="text-xs font-semibold text-slate-400 mb-3">Daftar Peserta yang Dibimbing</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">NR</div>
                                <span class="text-sm text-white">Nisa Ramadani</span>
                            </div>
                            <span class="text-xs text-amber-400 font-bold">4.3</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-500/30 flex items-center justify-center text-[10px] font-bold text-white">AF</div>
                                <span class="text-sm text-white">Ahmad Fauzi</span>
                            </div>
                            <span class="text-xs text-amber-400 font-bold">4.1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-teal-500/30 flex items-center justify-center text-[10px] font-bold text-white">DL</div>
                                <span class="text-sm text-white">Dewi Lestari</span>
                            </div>
                            <span class="text-xs text-amber-400 font-bold">4.5</span>
                        </div>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">Email</p>
                        <p class="text-sm text-white">budi.santoso@sumutprov.go.id</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-[11px] text-slate-400">NIP</p>
                        <p class="text-sm text-white">197805152005011002</p>
                    </div>
                </div>
            `;
            openModal('modalDetail');
        }
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const unit = document.getElementById('filterUnit').value;
            const status = document.getElementById('filterStatus').value;
            const beban = document.getElementById('filterBeban').value;
            document.querySelectorAll('#pembimbingTable tr').forEach(row => {
                const matchSearch = !search || row.dataset.name.includes(search);
                const matchUnit = !unit || row.dataset.unit === unit;
                const matchStatus = !status || row.dataset.status === status;
                const matchBeban = !beban || row.dataset.beban === beban;
                row.style.display = (matchSearch && matchUnit && matchStatus && matchBeban) ? '' : 'none';
            });
        }
    </script>
</body>
</html>

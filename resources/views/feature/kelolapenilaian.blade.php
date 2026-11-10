<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penilaian | Magang Komdigi 2026</title>
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
        .tab-btn.active { background: rgba(0, 147, 221, 0.25); color: #fff; border-color: rgba(56, 189, 248, 0.4); }
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
                    <a href="monitoring-kinerja.html" class="sidebar-link text-sm" title="Kinerja">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                        <span class="sidebar-label">Monitoring Kinerja</span>
                    </a>
                    <a href="kelola-penilaian.html" class="sidebar-link active text-sm" title="Penilaian">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                        <span class="sidebar-label">Kelola Penilaian</span>
                    </a>
                    <a href="#" class="sidebar-link text-sm" title="Laporan">
                        <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <span class="sidebar-label">Laporan & Sertifikat</span>
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
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Kelola Penilaian</h1>
                    <p class="text-sm text-blue-100/80 mt-0.5">Atur kriteria, bobot, dan pantau penilaian peserta</p>
                </div>

                <!-- Tabs -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="switchTab('kriteria')" id="tab-kriteria" class="tab-btn active px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 transition">Kriteria & Bobot</button>
                    <button onclick="switchTab('penilaian')" id="tab-penilaian" class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white transition">Semua Penilaian</button>
                    <button onclick="switchTab('audit')" id="tab-audit" class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white transition">Riwayat Perubahan</button>
                </div>

                <!-- TAB: Kriteria & Bobot -->
                <div id="panel-kriteria" class="space-y-5">
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="font-bold text-white">Kriteria Penilaian</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Total bobot harus 100%</p>
                            </div>
                            <button onclick="openAddKriteria()" class="btn-shine inline-flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-xs font-bold rounded-xl shadow-md">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Kriteria
                            </button>
                        </div>
                        <div class="space-y-3" id="kriteriaList">
                            <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="w-10 h-10 rounded-xl bg-komdigi-blue/20 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-komdigi-cerulean">1</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white">Disiplin & Kehadiran</p>
                                    <p class="text-xs text-slate-400">Ketepatan waktu dan kehadiran selama magang</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <p class="text-lg font-black text-komdigi-cerulean">25%</p>
                                        <p class="text-[10px] text-slate-500">Bobot</p>
                                    </div>
                                    <button onclick="editKriteria(this)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-indigo-400">2</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white">Kerjasama Tim</p>
                                    <p class="text-xs text-slate-400">Kemampuan berkolaborasi dan komunikasi</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <p class="text-lg font-black text-indigo-400">20%</p>
                                        <p class="text-[10px] text-slate-500">Bobot</p>
                                    </div>
                                    <button onclick="editKriteria(this)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-emerald-400">3</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white">Kompetensi Teknis</p>
                                    <p class="text-xs text-slate-400">Penguasaan skill teknis sesuai bidang</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <p class="text-lg font-black text-emerald-400">30%</p>
                                        <p class="text-[10px] text-slate-500">Bobot</p>
                                    </div>
                                    <button onclick="editKriteria(this)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-amber-400">4</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white">Inisiatif & Kreativitas</p>
                                    <p class="text-xs text-slate-400">Kemampuan memberikan ide dan solusi</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <div class="text-right">
                                        <p class="text-lg font-black text-amber-400">25%</p>
                                        <p class="text-[10px] text-slate-500">Bobot</p>
                                    </div>
                                    <button onclick="editKriteria(this)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between">
                            <p class="text-sm text-slate-400">Total Bobot</p>
                            <p class="text-xl font-black text-emerald-400">100%</p>
                        </div>
                    </div>
                </div>

                <!-- TAB: Semua Penilaian -->
                <div id="panel-penilaian" class="hidden space-y-5">
                    <div class="glass-card rounded-2xl p-4">
                        <div class="grid sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Cari Peserta</label>
                                <input type="text" id="searchPenilaian" placeholder="Nama peserta..." class="form-input" oninput="filterPenilaian()">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Pembimbing</label>
                                <select id="filterPembimbing" class="form-input" onchange="filterPenilaian()">
                                    <option value="">Semua</option>
                                    <option>Budi Santoso</option>
                                    <option>Sari Dewi</option>
                                    <option>Andi Pratama</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5">Periode</label>
                                <select class="form-input">
                                    <option>Semua Periode</option>
                                    <option>Minggu 5 (Nov 2026)</option>
                                    <option>Minggu 4 (Okt 2026)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-white/10">
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Peserta</th>
                                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Nilai</th>
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Pembimbing</th>
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="penilaianBody">
                                    <tr class="table-row border-b border-white/5" data-name="nisa ramadani" data-pembimbing="budi santoso">
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold">NR</div>
                                                <div>
                                                    <p class="font-semibold text-white">Nisa Ramadani</p>
                                                    <p class="text-[11px] text-slate-400">MKD-2026-0847</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-lg font-black text-komdigi-cerulean">4.3</span>
                                            <span class="text-xs text-slate-500">/5.0</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-slate-300 text-xs">Budi Santoso, S.Kom</td>
                                        <td class="px-4 py-3.5 text-slate-400 text-xs">28 Okt 2026</td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button onclick="viewPenilaian('Nisa Ramadani', 4.3)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition" title="Lihat">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                                <button onclick="openOverride('Nisa Ramadani', 4.3)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition" title="Override / Koreksi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row border-b border-white/5" data-name="dewi lestari" data-pembimbing="sari dewi">
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white text-xs font-bold">DL</div>
                                                <div>
                                                    <p class="font-semibold text-white">Dewi Lestari</p>
                                                    <p class="text-[11px] text-slate-400">MKD-2026-0851</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-lg font-black text-komdigi-cerulean">4.5</span>
                                            <span class="text-xs text-slate-500">/5.0</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-slate-300 text-xs">Sari Dewi, M.Kom</td>
                                        <td class="px-4 py-3.5 text-slate-400 text-xs">28 Okt 2026</td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button onclick="viewPenilaian('Dewi Lestari', 4.5)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                                <button onclick="openOverride('Dewi Lestari', 4.5)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-row border-b border-white/5" data-name="ahmad fauzi" data-pembimbing="sari dewi">
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">AF</div>
                                                <div>
                                                    <p class="font-semibold text-white">Ahmad Fauzi</p>
                                                    <p class="text-[11px] text-slate-400">MKD-2026-0848</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-lg font-black text-amber-400">3.8</span>
                                            <span class="text-xs text-slate-500">/5.0</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-slate-300 text-xs">Sari Dewi, M.Kom</td>
                                        <td class="px-4 py-3.5 text-slate-400 text-xs">27 Okt 2026</td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button onclick="viewPenilaian('Ahmad Fauzi', 3.8)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                                <button onclick="openOverride('Ahmad Fauzi', 3.8)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB: Audit Log -->
                <div id="panel-audit" class="hidden space-y-5">
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="px-5 py-4 border-b border-white/10">
                            <h3 class="font-bold text-white">Riwayat Perubahan Penilaian (Audit Log)</h3>
                        </div>
                        <div class="divide-y divide-white/5">
                            <div class="px-5 py-4 flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white"><span class="font-semibold">Admin Komdigi</span> mengoreksi penilaian <span class="font-semibold text-komdigi-cerulean">Ahmad Fauzi</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Nilai: 3.5 → <span class="text-amber-400 font-semibold">3.8</span> · Alasan: Koreksi input pembimbing</p>
                                    <p class="text-[11px] text-slate-500 mt-1">28 Okt 2026, 14:32 WIB</p>
                                </div>
                            </div>
                            <div class="px-5 py-4 flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white"><span class="font-semibold">Budi Santoso</span> menambahkan penilaian untuk <span class="font-semibold text-komdigi-cerulean">Nisa Ramadani</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Nilai keseluruhan: <span class="text-emerald-400 font-semibold">4.3</span></p>
                                    <p class="text-[11px] text-slate-500 mt-1">28 Okt 2026, 10:15 WIB</p>
                                </div>
                            </div>
                            <div class="px-5 py-4 flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-sky-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4v2m0 10v2m0-2a2 2 0 100 4m0-4a2 2 0 110 0v2m-6-4h2m10-4h2"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white"><span class="font-semibold">Admin Komdigi</span> mengubah bobot kriteria <span class="font-semibold text-komdigi-cerulean">Kompetensi Teknis</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Bobot: 25% → <span class="text-sky-400 font-semibold">30%</span></p>
                                    <p class="text-[11px] text-slate-500 mt-1">25 Okt 2026, 09:00 WIB</p>
                                </div>
                            </div>
                            <div class="px-5 py-4 flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white"><span class="font-semibold">Sari Dewi</span> menambahkan penilaian untuk <span class="font-semibold text-komdigi-cerulean">Dewi Lestari</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Nilai keseluruhan: <span class="text-emerald-400 font-semibold">4.5</span></p>
                                    <p class="text-[11px] text-slate-500 mt-1">28 Okt 2026, 11:40 WIB</p>
                                </div>
                            </div>
                            <div class="px-5 py-4 flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white"><span class="font-semibold">Admin Komdigi</span> mengoreksi penilaian <span class="font-semibold text-komdigi-cerulean">Reza Maulana</span></p>
                                    <p class="text-xs text-slate-400 mt-0.5">Nilai: 3.0 → <span class="text-amber-400 font-semibold">3.1</span> · Alasan: Penyesuaian skor disiplin</p>
                                    <p class="text-[11px] text-slate-500 mt-1">20 Okt 2026, 16:05 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: Override / Koreksi -->
    <div id="modalOverride" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalOverride')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Override / Koreksi Penilaian</h3>
                    <button onclick="closeModal('modalOverride')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-slate-400 mb-4">Peserta: <span id="overrideName" class="text-white font-semibold"></span> · Nilai saat ini: <span id="overrideCurrent" class="text-komdigi-cerulean font-bold"></span></p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nilai Baru (0–5)</label>
                        <input type="number" class="form-input" min="0" max="5" step="0.1" placeholder="Contoh: 4.0" id="overrideNew">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Alasan Koreksi <span class="text-rose-400">*</span></label>
                        <textarea class="form-input min-h-[80px]" placeholder="Jelaskan alasan koreksi penilaian..." required id="overrideAlasan"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 mt-5">
                    <button onclick="closeModal('modalOverride')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="submitOverride()" class="btn-shine flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-xl shadow-lg text-sm">Simpan Koreksi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: View Penilaian Detail -->
    <div id="modalView" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalView')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Detail Penilaian</h3>
                    <button onclick="closeModal('modalView')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="viewContent"></div>
            </div>
        </div>
    </div>

    <!-- MODAL: Edit/Add Kriteria -->
    <div id="modalKriteria" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" onclick="closeModal('modalKriteria')"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" id="modalKriteriaTitle">Tambah Kriteria</h3>
                    <button onclick="closeModal('modalKriteria')" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Kriteria</label>
                        <input type="text" class="form-input" placeholder="Contoh: Disiplin & Kehadiran">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                        <input type="text" class="form-input" placeholder="Penjelasan singkat">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Bobot (%)</label>
                        <input type="number" class="form-input" min="0" max="100" placeholder="25">
                    </div>
                </div>
                <div class="flex gap-3 mt-5">
                    <button onclick="closeModal('modalKriteria')" class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button onclick="closeModal('modalKriteria'); alert('Kriteria berhasil disimpan!')" class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            ['kriteria', 'penilaian', 'audit'].forEach(t => {
                document.getElementById('panel-' + t).classList.add('hidden');
                document.getElementById('tab-' + t).classList.remove('active');
                document.getElementById('tab-' + t).classList.add('text-slate-400');
            });
            document.getElementById('panel-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).classList.add('active');
            document.getElementById('tab-' + tab).classList.remove('text-slate-400');
        }
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
        function openAddKriteria() {
            document.getElementById('modalKriteriaTitle').textContent = 'Tambah Kriteria';
            openModal('modalKriteria');
        }
        function editKriteria() {
            document.getElementById('modalKriteriaTitle').textContent = 'Edit Kriteria';
            openModal('modalKriteria');
        }
        function openOverride(name, current) {
            document.getElementById('overrideName').textContent = name;
            document.getElementById('overrideCurrent').textContent = current;
            document.getElementById('overrideNew').value = current;
            openModal('modalOverride');
        }
        function submitOverride() {
            const alasan = document.getElementById('overrideAlasan').value;
            if (!alasan.trim()) { alert('Alasan koreksi wajib diisi!'); return; }
            closeModal('modalOverride');
            alert('Penilaian berhasil dikoreksi. Perubahan tercatat di audit log.');
        }
        function viewPenilaian(name, nilai) {
            document.getElementById('viewContent').innerHTML = `
                <p class="text-sm text-slate-400 mb-4">Peserta: <span class="text-white font-semibold">${name}</span></p>
                <div class="text-center mb-5">
                    <p class="text-4xl font-black text-komdigi-cerulean">${nilai}</p>
                    <p class="text-xs text-slate-400">/ 5.0</p>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-300">Disiplin & Kehadiran</span>
                        <span class="text-sm font-bold text-white">${(nilai + 0.2).toFixed(1)}</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-komdigi-cerulean rounded-full" style="width:${(nilai+0.2)/5*100}%"></div></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-300">Kerjasama Tim</span>
                        <span class="text-sm font-bold text-white">${(nilai - 0.1).toFixed(1)}</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-indigo-400 rounded-full" style="width:${(nilai-0.1)/5*100}%"></div></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-300">Kompetensi Teknis</span>
                        <span class="text-sm font-bold text-white">${nilai.toFixed(1)}</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-emerald-400 rounded-full" style="width:${nilai/5*100}%"></div></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-300">Inisiatif & Kreativitas</span>
                        <span class="text-sm font-bold text-white">${(nilai + 0.1).toFixed(1)}</span>
                    </div>
                    <div class="h-2 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-amber-400 rounded-full" style="width:${(nilai+0.1)/5*100}%"></div></div>
                </div>
                <div class="mt-4 p-3 bg-white/5 rounded-xl border border-white/10">
                    <p class="text-xs text-slate-400 italic">"Peserta menunjukkan progres yang baik dan aktif berkontribusi."</p>
                </div>
            `;
            openModal('modalView');
        }
        function filterPenilaian() {
            const search = document.getElementById('searchPenilaian').value.toLowerCase();
            const pemb = document.getElementById('filterPembimbing').value.toLowerCase();
            document.querySelectorAll('#penilaianBody tr').forEach(row => {
                const matchSearch = !search || row.dataset.name.includes(search);
                const matchPemb = !pemb || row.dataset.pembimbing.includes(pemb);
                row.style.display = (matchSearch && matchPemb) ? '' : 'none';
            });
        }
    </script>
</body>
</html>

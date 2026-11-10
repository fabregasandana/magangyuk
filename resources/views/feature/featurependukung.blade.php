<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fitur Pendukung Admin | Magang Komdigi 2026</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script>tailwind.config={theme:{extend:{colors:{'komdigi-blue':'#0055FF','komdigi-dark':'#00336C','komdigi-cerulean':'#0093DD','komdigi-navy':'#001B3D'},fontFamily:{sans:['Inter','sans-serif']}}}}</script>
<style>
body{overflow-x:hidden;background:linear-gradient(160deg,#001B3D 0%,#00336C 28%,#0055FF 65%,#0093DD 100%);background-attachment:fixed;min-height:100vh}
body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 90% 60% at 10% 20%,rgba(0,147,221,.35) 0%,transparent 55%),radial-gradient(ellipse 70% 50% at 90% 10%,rgba(0,85,255,.3) 0%,transparent 50%);pointer-events:none;z-index:0}
.glass{background:rgba(15,23,42,.32);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.1)}
.glass-strong{background:rgba(15,23,42,.38);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.12)}
.glass-card{background:rgba(15,23,42,.26);backdrop-filter:blur(18px);border:1px solid rgba(125,211,252,.45);box-shadow:0 0 0 1px rgba(255,255,255,.14),0 0 14px rgba(56,189,248,.4),0 6px 24px rgba(0,0,0,.16);transition:all .3s;color:#e2e8f0}
.glass-card:hover{background:rgba(15,23,42,.42);border-color:rgba(125,211,252,.75);transform:translateY(-2px)}
.glass-panel{background:rgba(8,12,24,.35);backdrop-filter:blur(24px);border:1px solid rgba(125,211,252,.28);border-radius:1.5rem}
.glass-sidebar{background:rgba(8,12,24,.35);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.1);width:68px;transition:width .28s;overflow:hidden;z-index:40}
.glass-sidebar:hover{width:240px;background:rgba(8,12,24,.5)}
.glass-sidebar .sidebar-label{opacity:0;white-space:nowrap;transition:opacity .18s;pointer-events:none;font-size:.8125rem}
.glass-sidebar:hover .sidebar-label{opacity:1;pointer-events:auto}
.glass-sidebar .sidebar-section-title{opacity:0;max-height:0;overflow:hidden;transition:all .2s}
.glass-sidebar:hover .sidebar-section-title{opacity:1;max-height:2rem;margin-bottom:.75rem;padding:0 .5rem}
.sidebar-link{transition:all .2s;color:rgba(186,198,214,.95);font-weight:500;display:flex;align-items:center;gap:.7rem;padding:.55rem .7rem;border-radius:.7rem;position:relative;margin:0 .2rem}
.sidebar-link:hover{background:rgba(255,255,255,.07);color:#f8fafc}
.sidebar-link.active{background:rgba(0,147,221,.18);color:#fff;font-weight:600}
.sidebar-link.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:55%;background:#38bdf8;border-radius:0 3px 3px 0}
.sidebar-link .sidebar-icon{width:1.85rem;height:1.85rem;border-radius:.5rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(255,255,255,.05)}
.sidebar-link.active .sidebar-icon{background:rgba(0,147,221,.3)}
.table-row:hover{background:rgba(255,255,255,.04)}
.nav-tab{transition:all .2s;cursor:pointer}
.nav-tab.active{background:linear-gradient(135deg,rgba(0,85,255,.35),rgba(0,147,221,.25));border-color:rgba(56,189,248,.6);color:#fff}
.tab-panel{display:none}.tab-panel.active{display:block}
</style>
</head>
<body class="font-sans antialiased">

<!-- HEADER -->
<header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
<div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">
<div class="flex items-center gap-3 shrink-0">
<div class="relative"><div class="absolute inset-0 bg-komdigi-blue rounded-xl blur-md opacity-40"></div>
<div class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">K</div></div>
<div class="hidden sm:block"><div class="font-extrabold text-white text-sm tracking-tight">MAGANG KOMDIGI</div><div class="text-[10px] font-semibold text-amber-300">2026 • Admin</div></div>
</div>
<nav class="hidden lg:flex items-center gap-1">
<a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Dashboard</a>
<a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Peserta</a>
<a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Logbook</a>
<a href="#" class="px-4 py-1.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition">Laporan</a>
<a href="#" class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md">Pengaturan</a>
</nav>
<div class="flex items-center gap-3 shrink-0">
<div class="hidden sm:flex items-center gap-2.5">
<div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20">AD</div>
<div class="hidden md:block"><div class="text-xs font-bold text-white">Admin Sistem</div><div class="text-[10px] text-emerald-400 font-medium">● Online</div></div>
</div>
<a href="#" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full shadow-md">Keluar</a>
</div>
</div>
</header>

<div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">
<!-- SIDEBAR -->
<aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
<div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
<p class="sidebar-section-title text-[10px] font-bold tracking-widest text-amber-300/60 uppercase">Menu Admin</p>
<nav class="space-y-0.5">
<a href="#" class="sidebar-link text-sm"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div><span class="sidebar-label">Dashboard</span></a>
<a href="#" onclick="showSection('periode');return false;" class="sidebar-link active text-sm" id="side-periode"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div><span class="sidebar-label">Periode Magang</span></a>
<a href="#" onclick="showSection('institusi');return false;" class="sidebar-link text-sm" id="side-institusi"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div><span class="sidebar-label">Institusi</span></a>
<a href="#" onclick="showSection('log');return false;" class="sidebar-link text-sm" id="side-log"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div><span class="sidebar-label">Log Aktivitas</span></a>
<a href="#" onclick="showSection('role');return false;" class="sidebar-link text-sm" id="side-role"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div><span class="sidebar-label">Role & Permission</span></a>
<a href="#" onclick="showSection('pengaturan');return false;" class="sidebar-link text-sm" id="side-pengaturan"><div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div><span class="sidebar-label">Pengaturan</span></a>
</nav></div>
</aside>

<!-- MAIN -->
<main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
<div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
<div>
<p class="text-sm text-blue-100/80 font-medium">Panel Administrasi</p>
<h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight" id="pageTitle">Fitur Pendukung Admin</h1>
</div>
<div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
<div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
<div class="text-right"><p class="text-sm font-bold text-white" id="current-date">Selasa, 10 November 2026</p>
<p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">09.30.00 WIB</p></div>
</div>
</div>

<!-- Horizontal Tabs -->
<div class="flex flex-wrap gap-2">
<button onclick="showSection('periode')" class="nav-tab active px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300" data-tab="periode">📅 Periode Magang</button>
<button onclick="showSection('institusi')" class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300" data-tab="institusi">🏫 Institusi</button>
<button onclick="showSection('log')" class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300" data-tab="log">📋 Log Aktivitas</button>
<button onclick="showSection('role')" class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300" data-tab="role">🔐 Role & Permission</button>
<button onclick="showSection('pengaturan')" class="nav-tab px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300" data-tab="pengaturan">⚙️ Pengaturan</button>
</div>

<!-- ==================== SECTION: PERIODE ==================== -->
<div id="sec-periode" class="tab-panel active space-y-5">
<div class="flex justify-end">
<button onclick="document.getElementById('modalPeriode').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Buat Periode Baru</button>
</div>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
<div class="glass-card rounded-2xl p-5"><p class="text-2xl font-black text-white">3</p><p class="text-xs text-slate-400 mt-1">Total Periode</p></div>
<div class="glass-card rounded-2xl p-5"><p class="text-2xl font-black text-emerald-400">1</p><p class="text-xs text-slate-400 mt-1">Periode Aktif</p></div>
<div class="glass-card rounded-2xl p-5"><p class="text-2xl font-black text-komdigi-cerulean">248</p><p class="text-xs text-slate-400 mt-1">Peserta Aktif</p></div>
<div class="glass-card rounded-2xl p-5"><p class="text-2xl font-black text-amber-400">55%</p><p class="text-xs text-slate-400 mt-1">Progress</p></div>
</div>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="px-5 py-4 border-b border-white/8"><h3 class="text-base font-bold text-white">Daftar Periode Magang</h3></div>
<div class="overflow-x-auto"><table class="w-full text-left">
<thead><tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
<th class="px-5 py-3.5 font-semibold">Nama Periode</th><th class="px-4 py-3.5 font-semibold">Mulai</th><th class="px-4 py-3.5 font-semibold">Selesai</th>
<th class="px-4 py-3.5 font-semibold text-center">Peserta</th><th class="px-4 py-3.5 font-semibold">Status</th><th class="px-4 py-3.5 font-semibold text-center">Aksi</th>
</tr></thead>
<tbody>
<tr class="table-row border-b border-white/5">
<td class="px-5 py-4"><p class="text-sm font-bold text-white">Magang Batch 1 - 2026</p>
<div class="mt-1.5 w-32 h-1.5 bg-white/10 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width:55%"></div></div></td>
<td class="px-4 py-4 text-sm text-slate-300">1 Okt 2026</td><td class="px-4 py-4 text-sm text-slate-300">19 Des 2026</td>
<td class="px-4 py-4 text-center text-sm font-semibold text-white">248</td>
<td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif</span></td>
<td class="px-4 py-4"><div class="flex justify-center gap-1.5">
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
</div></td></tr>
<tr class="table-row border-b border-white/5">
<td class="px-5 py-4"><p class="text-sm font-bold text-white">Magang Batch 2 - 2025</p></td>
<td class="px-4 py-4 text-sm text-slate-300">1 Mar 2025</td><td class="px-4 py-4 text-sm text-slate-300">30 Mei 2025</td>
<td class="px-4 py-4 text-center text-sm font-semibold text-white">192</td>
<td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-400 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Selesai</span></td>
<td class="px-4 py-4"><div class="flex justify-center gap-1.5">
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-slate-400 hover:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></button>
</div></td></tr>
<tr class="table-row">
<td class="px-5 py-4"><p class="text-sm font-bold text-white">Magang Batch 1 - 2025</p></td>
<td class="px-4 py-4 text-sm text-slate-300">1 Okt 2024</td><td class="px-4 py-4 text-sm text-slate-300">20 Des 2024</td>
<td class="px-4 py-4 text-center text-sm font-semibold text-white">175</td>
<td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-400 text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Selesai</span></td>
<td class="px-4 py-4"><div class="flex justify-center gap-1.5">
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-slate-400 hover:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></button>
</div></td></tr>
</tbody></table></div></div>
</div>

<!-- ==================== SECTION: INSTITUSI ==================== -->
<div id="sec-institusi" class="tab-panel space-y-5">
<div class="flex flex-col sm:flex-row sm:items-center gap-4">
<div class="relative flex-1">
<svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
<input type="text" placeholder="Cari institusi..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-komdigi-cerulean">
</div>
<button onclick="document.getElementById('modalInstitusi').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah Institusi</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-sm font-black">USU</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-bold">Aktif</span></div>
<h3 class="text-sm font-bold text-white">Universitas Sumatera Utara</h3><p class="text-xs text-slate-400 mt-1">PTN • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-komdigi-cerulean">68</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-black">UNIMED</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-bold">Aktif</span></div>
<h3 class="text-sm font-bold text-white">Universitas Negeri Medan</h3><p class="text-xs text-slate-400 mt-1">PTN • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-komdigi-cerulean">45</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-black">POLMED</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-bold">Aktif</span></div>
<h3 class="text-sm font-bold text-white">Politeknik Negeri Medan</h3><p class="text-xs text-slate-400 mt-1">Politeknik • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-komdigi-cerulean">42</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-sm font-black">ITM</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-bold">Aktif</span></div>
<h3 class="text-sm font-bold text-white">Institut Teknologi Medan</h3><p class="text-xs text-slate-400 mt-1">PTS • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-komdigi-cerulean">28</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-sm font-black">UMSU</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-bold">Aktif</span></div>
<h3 class="text-sm font-bold text-white">Universitas Muhammadiyah Sumut</h3><p class="text-xs text-slate-400 mt-1">PTS • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-komdigi-cerulean">35</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-start justify-between mb-3"><div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-500 to-slate-600 flex items-center justify-center text-white text-sm font-black">LP3I</div>
<span class="px-2 py-0.5 rounded-full bg-slate-500/20 text-slate-400 text-[10px] font-bold">Nonaktif</span></div>
<h3 class="text-sm font-bold text-white">Politeknik LP3I Medan</h3><p class="text-xs text-slate-400 mt-1">Politeknik • Medan</p>
<div class="mt-4 flex items-center justify-between"><div><p class="text-lg font-black text-slate-400">12</p><p class="text-[10px] text-slate-500">Peserta</p></div>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-cerulean"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
<button class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div></div>
</div>
</div>
</div>

<!-- ==================== SECTION: LOG AKTIVITAS ==================== -->
<div id="sec-log" class="tab-panel space-y-5">
<div class="glass-card rounded-3xl p-5">
<div class="flex flex-col lg:flex-row lg:items-center gap-3">
<div class="relative flex-1">
<svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
<input type="text" placeholder="Cari aktivitas..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-komdigi-cerulean">
</div>
<select class="text-xs bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5"><option>Semua Aksi</option><option>Login</option><option>Create</option><option>Update</option><option>Approve</option><option>Export</option></select>
<select class="text-xs bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5"><option>Semua Role</option><option>Admin</option><option>Pembimbing</option><option>Peserta</option></select>
<button onclick="alert('Mengunduh log...')" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Export</button>
</div></div>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="overflow-x-auto"><table class="w-full text-left">
<thead><tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
<th class="px-5 py-3.5 font-semibold">Waktu</th><th class="px-4 py-3.5 font-semibold">User</th><th class="px-4 py-3.5 font-semibold">Role</th>
<th class="px-4 py-3.5 font-semibold">Aksi</th><th class="px-4 py-3.5 font-semibold">Deskripsi</th><th class="px-4 py-3.5 font-semibold">IP</th>
</tr></thead>
<tbody>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">10 Nov 2026, 09:12</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Admin Sistem</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Admin</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/15 text-amber-400">UPDATE</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Memperbarui bobot penilaian global</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">103.45.xx.xx</td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">10 Nov 2026, 08:55</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Budi Santoso</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Pembimbing</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/15 text-emerald-400">APPROVE</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Menyetujui logbook Salwa Rameyza</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">114.79.xx.xx</td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">10 Nov 2026, 08:30</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Salwa Rameyza</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Peserta</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-500/15 text-sky-400">CREATE</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Mengirim logbook minggu ke-5</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">125.160.xx.xx</td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">09 Nov 2026, 16:40</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Budi Santoso</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Pembimbing</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-500/15 text-sky-400">CREATE</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Memberikan penilaian Nadia Putri (86)</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">114.79.xx.xx</td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">09 Nov 2026, 11:05</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Sari Dewi</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Pembimbing</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-500/15 text-rose-400">REJECT</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Menolak logbook Rizky Fauzan</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">180.252.xx.xx</td></tr>
<tr class="table-row"><td class="px-5 py-3.5 text-xs text-slate-400 whitespace-nowrap">08 Nov 2026, 15:30</td><td class="px-4 py-3.5 text-sm font-semibold text-white">Admin Sistem</td><td class="px-4 py-3.5 text-[11px] text-slate-300">Admin</td><td class="px-4 py-3.5"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-violet-500/15 text-violet-400">EXPORT</span></td><td class="px-4 py-3.5 text-sm text-slate-300">Export laporan Oktober 2026 (PDF)</td><td class="px-4 py-3.5 text-xs text-slate-500 font-mono">103.45.xx.xx</td></tr>
</tbody></table></div>
<div class="flex items-center justify-between px-5 py-4 border-t border-white/8">
<p class="text-xs text-slate-400">Menampilkan 1–6 dari 1.284 log</p>
<div class="flex gap-1.5"><button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold" disabled>‹</button>
<button class="w-8 h-8 rounded-lg bg-komdigi-blue text-white text-xs font-bold">1</button>
<button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10">2</button>
<button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10">›</button></div>
</div></div>
</div>

<!-- ==================== SECTION: ROLE & PERMISSION ==================== -->
<div id="sec-role" class="tab-panel space-y-5">
<div class="flex justify-end">
<button onclick="document.getElementById('modalRole').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah Role</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="glass-card rounded-2xl p-5">
<div class="flex items-center gap-3 mb-3"><div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center text-white text-sm font-black">A</div>
<div><h3 class="text-base font-bold text-white">Admin</h3><p class="text-[11px] text-slate-400">3 pengguna</p></div></div>
<p class="text-xs text-slate-400 mb-3">Akses penuh ke seluruh fitur sistem</p>
<span class="text-[11px] font-semibold text-komdigi-cerulean">24 permissions</span>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-center gap-3 mb-3"><div class="w-11 h-11 rounded-xl bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-sm font-black">P</div>
<div><h3 class="text-base font-bold text-white">Pembimbing</h3><p class="text-[11px] text-slate-400">18 pengguna</p></div></div>
<p class="text-xs text-slate-400 mb-3">Membimbing, menilai, dan menyetujui logbook</p>
<span class="text-[11px] font-semibold text-komdigi-cerulean">12 permissions</span>
</div>
<div class="glass-card rounded-2xl p-5">
<div class="flex items-center gap-3 mb-3"><div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 flex items-center justify-center text-white text-sm font-black">S</div>
<div><h3 class="text-base font-bold text-white">Peserta</h3><p class="text-[11px] text-slate-400">248 pengguna</p></div></div>
<p class="text-xs text-slate-400 mb-3">Absensi, isi logbook, lihat penilaian</p>
<span class="text-[11px] font-semibold text-komdigi-cerulean">8 permissions</span>
</div>
</div>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="px-5 py-4 border-b border-white/8 flex items-center justify-between">
<div><h3 class="text-base font-bold text-white">Matriks Permission</h3></div>
<button onclick="alert('Permission disimpan!')" class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button>
</div>
<div class="overflow-x-auto"><table class="w-full text-left">
<thead><tr class="border-b border-white/8 text-[11px] uppercase tracking-wider text-slate-400">
<th class="px-5 py-3.5 font-semibold">Permission</th><th class="px-4 py-3.5 font-semibold text-center">Admin</th><th class="px-4 py-3.5 font-semibold text-center">Pembimbing</th><th class="px-4 py-3.5 font-semibold text-center">Peserta</th>
</tr></thead>
<tbody>
<tr class="border-b border-white/5"><td colspan="4" class="px-5 py-2 bg-white/[0.02]"><span class="text-[11px] font-bold text-komdigi-cerulean uppercase">Dashboard</span></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Lihat Dashboard Admin</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Lihat Dashboard Pembimbing</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="border-b border-white/5"><td colspan="4" class="px-5 py-2 bg-white/[0.02]"><span class="text-[11px] font-bold text-komdigi-cerulean uppercase">Logbook</span></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Isi logbook sendiri</td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Approve / Reject logbook</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="border-b border-white/5"><td colspan="4" class="px-5 py-2 bg-white/[0.02]"><span class="text-[11px] font-bold text-komdigi-cerulean uppercase">Penilaian</span></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Memberi penilaian</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Atur bobot penilaian</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="border-b border-white/5"><td colspan="4" class="px-5 py-2 bg-white/[0.02]"><span class="text-[11px] font-bold text-komdigi-cerulean uppercase">Sistem</span></td></tr>
<tr class="table-row border-b border-white/5"><td class="px-5 py-3 text-sm text-slate-300">Manajemen periode & institusi</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
<tr class="table-row"><td class="px-5 py-3 text-sm text-slate-300">Pengaturan sistem & role</td><td class="px-4 py-3 text-center"><input type="checkbox" checked class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td><td class="px-4 py-3 text-center"><input type="checkbox" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"></td></tr>
</tbody></table></div></div>
</div>

<!-- ==================== SECTION: PENGATURAN ==================== -->
<div id="sec-pengaturan" class="tab-panel space-y-5">
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
<div class="space-y-2">
<button onclick="showSetTab('bobot')" id="stab-bobot" class="set-tab active w-full text-left px-4 py-3 rounded-xl text-sm font-semibold flex items-center gap-3 bg-komdigi-cerulean/15 text-white border border-komdigi-cerulean/30">⭐ Bobot Penilaian</button>
<button onclick="showSetTab('notif')" id="stab-notif" class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5 flex items-center gap-3">🔔 Notifikasi</button>
<button onclick="showSetTab('umum')" id="stab-umum" class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5 flex items-center gap-3">⚙️ Umum</button>
<button onclick="showSetTab('keamanan')" id="stab-keamanan" class="set-tab w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5 flex items-center gap-3">🔒 Keamanan</button>
</div>
<div class="xl:col-span-2">
<div id="set-bobot" class="set-panel">
<div class="glass-card rounded-3xl p-5 sm:p-6 space-y-4">
<h3 class="text-base font-bold text-white">Bobot Penilaian Global</h3>
<div class="space-y-3">
<div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.03] border border-white/8"><p class="flex-1 text-sm font-semibold text-white">Disiplin & Kehadiran</p><div class="flex items-center gap-2"><input type="number" value="20" class="w-16 text-center bg-white/5 border border-white/10 text-white rounded-lg px-2 py-1.5 text-sm font-bold"><span class="text-sm text-slate-400">%</span></div></div>
<div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.03] border border-white/8"><p class="flex-1 text-sm font-semibold text-white">Kualitas Kerja</p><div class="flex items-center gap-2"><input type="number" value="30" class="w-16 text-center bg-white/5 border border-white/10 text-white rounded-lg px-2 py-1.5 text-sm font-bold"><span class="text-sm text-slate-400">%</span></div></div>
<div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.03] border border-white/8"><p class="flex-1 text-sm font-semibold text-white">Komunikasi & Kerjasama</p><div class="flex items-center gap-2"><input type="number" value="20" class="w-16 text-center bg-white/5 border border-white/10 text-white rounded-lg px-2 py-1.5 text-sm font-bold"><span class="text-sm text-slate-400">%</span></div></div>
<div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.03] border border-white/8"><p class="flex-1 text-sm font-semibold text-white">Inisiatif & Kreativitas</p><div class="flex items-center gap-2"><input type="number" value="15" class="w-16 text-center bg-white/5 border border-white/10 text-white rounded-lg px-2 py-1.5 text-sm font-bold"><span class="text-sm text-slate-400">%</span></div></div>
<div class="flex items-center gap-4 p-3 rounded-2xl bg-white/[0.03] border border-white/8"><p class="flex-1 text-sm font-semibold text-white">Tanggung Jawab</p><div class="flex items-center gap-2"><input type="number" value="15" class="w-16 text-center bg-white/5 border border-white/10 text-white rounded-lg px-2 py-1.5 text-sm font-bold"><span class="text-sm text-slate-400">%</span></div></div>
</div>
<div class="flex items-center justify-between pt-2"><p class="text-sm text-slate-400">Total: <span class="font-bold text-emerald-400">100%</span></p>
<button onclick="alert('Bobot disimpan!')" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button></div>
</div></div>
<div id="set-notif" class="set-panel hidden">
<div class="glass-card rounded-3xl p-5 sm:p-6 space-y-4">
<h3 class="text-base font-bold text-white">Pengaturan Notifikasi</h3>
<div class="space-y-3">
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Logbook Pending</p><p class="text-[11px] text-slate-400">Pengingat jika menunggu > 3 hari</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" checked class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Peserta Performa Rendah</p><p class="text-[11px] text-slate-400">Alert skor < 75</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" checked class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Pendaftaran Baru</p><p class="text-[11px] text-slate-400">Notifikasi pendaftaran magang</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" checked class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Email Ringkasan Mingguan</p><p class="text-[11px] text-slate-400">Setiap Senin</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
</div>
<button onclick="alert('Notifikasi disimpan!')" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button>
</div></div>
<div id="set-umum" class="set-panel hidden">
<div class="glass-card rounded-3xl p-5 sm:p-6 space-y-4">
<h3 class="text-base font-bold text-white">Pengaturan Umum</h3>
<div class="space-y-4">
<div><label class="block text-xs text-slate-400 mb-1.5">Nama Sistem</label><input type="text" value="MAGANG KOMDIGI 2026" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean"></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Email Admin</label><input type="email" value="admin@magangkomdigi.sumutprov.go.id" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean"></div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-xs text-slate-400 mb-1.5">Min. Skor Lulus</label><input type="number" value="70" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm"></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Min. Kehadiran (%)</label><input type="number" value="80" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm"></div>
</div>
<div><label class="block text-xs text-slate-400 mb-1.5">Maks. Peserta / Pembimbing</label><input type="number" value="15" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm"></div>
</div>
<button onclick="alert('Pengaturan disimpan!')" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button>
</div></div>
<div id="set-keamanan" class="set-panel hidden">
<div class="glass-card rounded-3xl p-5 sm:p-6 space-y-4">
<h3 class="text-base font-bold text-white">Keamanan</h3>
<div class="space-y-3">
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Two-Factor Authentication</p><p class="text-[11px] text-slate-400">Wajibkan 2FA untuk Admin</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" checked class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Session Timeout</p><p class="text-[11px] text-slate-400">Logout otomatis</p></div><select class="text-xs bg-white/5 border border-white/10 text-slate-300 rounded-lg px-2 py-1.5"><option>30 menit</option><option selected>1 jam</option><option>2 jam</option></select></div>
<div class="flex items-center justify-between p-3 rounded-2xl bg-white/[0.03] border border-white/8"><div><p class="text-sm font-semibold text-white">Force Password Change</p><p class="text-[11px] text-slate-400">Setiap 90 hari</p></div><label class="relative inline-flex cursor-pointer"><input type="checkbox" class="sr-only peer"><div class="w-10 h-5 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-komdigi-cerulean"></div></label></div>
</div>
<button onclick="alert('Keamanan disimpan!')" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button>
</div></div>
</div></div>
</div>

</div>
</main>
</div>

<!-- MODALS -->
<div id="modalPeriode" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
<div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('modalPeriode').classList.add('hidden')"></div>
<div class="relative w-full max-w-lg glass-strong rounded-3xl p-6 space-y-5">
<div class="flex items-center justify-between"><h3 class="text-lg font-bold text-white">Buat Periode Baru</h3>
<button onclick="document.getElementById('modalPeriode').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form class="space-y-4" onsubmit="event.preventDefault();alert('Periode disimpan!');document.getElementById('modalPeriode').classList.add('hidden');">
<div><label class="block text-xs text-slate-400 mb-1.5">Nama Periode</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean" placeholder="Magang Batch 2 - 2026" required></div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-xs text-slate-400 mb-1.5">Tanggal Mulai</label><input type="date" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm" required></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Tanggal Selesai</label><input type="date" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm" required></div>
</div>
<div class="flex items-center gap-2"><input type="checkbox" id="setAktif" class="rounded border-white/20 bg-white/5 text-komdigi-cerulean"><label for="setAktif" class="text-sm text-slate-300">Jadikan aktif sekarang</label></div>
<div class="flex justify-end gap-3"><button type="button" onclick="document.getElementById('modalPeriode').classList.add('hidden')" class="px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl">Batal</button>
<button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button></div>
</form></div></div>

<div id="modalInstitusi" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
<div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('modalInstitusi').classList.add('hidden')"></div>
<div class="relative w-full max-w-lg glass-strong rounded-3xl p-6 space-y-5">
<div class="flex items-center justify-between"><h3 class="text-lg font-bold text-white">Tambah Institusi</h3>
<button onclick="document.getElementById('modalInstitusi').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form class="space-y-4" onsubmit="event.preventDefault();alert('Institusi ditambahkan!');document.getElementById('modalInstitusi').classList.add('hidden');">
<div><label class="block text-xs text-slate-400 mb-1.5">Nama Institusi</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean" required></div>
<div class="grid grid-cols-2 gap-4">
<div><label class="block text-xs text-slate-400 mb-1.5">Singkatan</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm" required></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Jenis</label><select class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm"><option>PTN</option><option>PTS</option><option>Politeknik</option></select></div>
</div>
<div><label class="block text-xs text-slate-400 mb-1.5">Kota</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm" placeholder="Medan"></div>
<div class="flex justify-end gap-3"><button type="button" onclick="document.getElementById('modalInstitusi').classList.add('hidden')" class="px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl">Batal</button>
<button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button></div>
</form></div></div>

<div id="modalRole" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
<div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('modalRole').classList.add('hidden')"></div>
<div class="relative w-full max-w-md glass-strong rounded-3xl p-6 space-y-5">
<div class="flex items-center justify-between"><h3 class="text-lg font-bold text-white">Tambah Role</h3>
<button onclick="document.getElementById('modalRole').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
<form class="space-y-4" onsubmit="event.preventDefault();alert('Role ditambahkan!');document.getElementById('modalRole').classList.add('hidden');">
<div><label class="block text-xs text-slate-400 mb-1.5">Nama Role</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-komdigi-cerulean" placeholder="Koordinator" required></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Slug</label><input type="text" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm" placeholder="koordinator"></div>
<div><label class="block text-xs text-slate-400 mb-1.5">Deskripsi</label><textarea rows="2" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm resize-none"></textarea></div>
<div class="flex justify-end gap-3"><button type="button" onclick="document.getElementById('modalRole').classList.add('hidden')" class="px-4 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl">Batal</button>
<button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl">Simpan</button></div>
</form></div></div>

<script>
const titles={periode:'Manajemen Periode Magang',institusi:'Manajemen Institusi / Kampus',log:'Log Aktivitas Sistem',role:'Role & Permission',pengaturan:'Pengaturan Sistem'};
function showSection(name){
document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
document.getElementById('sec-'+name).classList.add('active');
document.querySelectorAll('.nav-tab').forEach(t=>{t.classList.remove('active');if(t.dataset.tab===name)t.classList.add('active');});
document.querySelectorAll('.sidebar-link').forEach(l=>l.classList.remove('active'));
const side=document.getElementById('side-'+name);if(side)side.classList.add('active');
document.getElementById('pageTitle').textContent=titles[name]||'Fitur Pendukung Admin';
}
function showSetTab(name){
document.querySelectorAll('.set-panel').forEach(p=>p.classList.add('hidden'));
document.getElementById('set-'+name).classList.remove('hidden');
document.querySelectorAll('.set-tab').forEach(t=>{t.classList.remove('active','bg-komdigi-cerulean/15','text-white','border','border-komdigi-cerulean/30');t.classList.add('text-slate-300','font-medium');});
const btn=document.getElementById('stab-'+name);
btn.classList.add('active','bg-komdigi-cerulean/15','text-white','border','border-komdigi-cerulean/30');
btn.classList.remove('text-slate-300','font-medium');
}
function updateDateTime(){
const now=new Date();
const days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const months=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
document.getElementById('current-date').textContent=`${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
const h=String(now.getHours()).padStart(2,'0'),m=String(now.getMinutes()).padStart(2,'0'),s=String(now.getSeconds()).padStart(2,'0');
document.getElementById('current-time').textContent=`${h}.${m}.${s} WIB`;
}
updateDateTime();setInterval(updateDateTime,1000);
</script>
</body>
</html>
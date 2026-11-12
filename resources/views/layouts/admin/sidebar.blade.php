<!-- SIDEBAR -->
<aside
    class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
    <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
        <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Admin Menu
        </p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                title="Dashboard">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg></div>
                <span class="sidebar-label">Dashboard Admin</span>
            </a>
            <a href="{{ route('admin.manajemen-peserta') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.manajemen-peserta') ? 'active' : '' }}"
                title="Peserta">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg></div>
                <span class="sidebar-label">Manajemen Peserta</span>
            </a>
            <a href="{{ route('admin.manajemen-pembimbing') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.manajemen-pembimbing') ? 'active' : '' }}"
                title="Pembimbing">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg></div>
                <span class="sidebar-label">Manajemen Pembimbing</span>
            </a>
            <a href="{{ route('admin.monitoring') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}"
                title="Monitoring">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></div>
                <span class="sidebar-label">Monitoring Kinerja</span>
            </a>
            <a href="{{ route('admin.kelola-penilaian') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.kelola-penilaian') ? 'active' : '' }}"
                title="Penilaian">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg></div>
                <span class="sidebar-label">Laporan &amp; Penilaian</span>
            </a>
            <a href="{{ route('admin.cms') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.cms') ? 'active' : '' }}" title="CMS">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg></div>
                <span class="sidebar-label">CMS Konten</span>
            </a>
            <a href="{{ route('admin.feature-pendukung') }}"
                class="sidebar-link text-sm {{ request()->routeIs('admin.feature-pendukung') ? 'active' : '' }}"
                title="Fitur Pendukung">
                <div class="sidebar-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg></div>
                <span class="sidebar-label">Fitur Pendukung</span>
            </a>
        </nav>
    </div>
    <div class="px-3 pb-4 pt-2 border-t border-white/10">
        <div class="sidebar-footer-text">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Periode Magang</p>
            <p class="text-xs font-semibold text-white mt-0.5">Okt – Des 2026</p>
            <div class="mt-2 h-1.5 rounded-full bg-white/10 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean"
                    style="width: {{ $periodeProgress ?? 55 }}%"></div>
            </div>
            <p class="text-[10px] text-slate-400 mt-1.5">{{ $periodeProgress ?? 55 }}% berjalan</p>
        </div>
    </div>
</aside>

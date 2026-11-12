{{-- SIDEBAR PEMBIMBING --}}
<aside class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
    <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
        <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Pembimbing</p>

        <nav class="space-y-0.5" id="sidebar-nav">
            <a href="{{ route('pembimbing.dashboard') }}" class="sidebar-link {{ request()->routeIs('pembimbing.dashboard') ? 'active' : '' }} text-sm" title="Beranda">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="sidebar-label">Beranda</span>
            </a>
            <a href="{{ route('pembimbing.peserta') }}" class="sidebar-link {{ request()->routeIs('pembimbing.peserta', 'pembimbing.detailpeserta') ? 'active' : '' }} text-sm" title="Daftar Peserta">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="sidebar-label">Daftar Peserta</span>
            </a>
            <a href="{{ route('pembimbing.logbook') }}" class="sidebar-link {{ request()->routeIs('pembimbing.logbook') ? 'active' : '' }} text-sm" title="Approval Logbook">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="sidebar-label">Approval Logbook</span>
            </a>
            <a href="{{ route('pembimbing.penilaianpeserta') }}" class="sidebar-link {{ request()->routeIs('pembimbing.penilaianpeserta') ? 'active' : '' }} text-sm" title="Penilaian Peserta">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <span class="sidebar-label">Penilaian Peserta</span>
            </a>
            <a href="{{ route('pembimbing.laporanbimbingan') }}" class="sidebar-link {{ request()->routeIs('pembimbing.laporanbimbingan') ? 'active' : '' }} text-sm" title="Laporan Bimbingan">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="sidebar-label">Laporan Bimbingan</span>
            </a>
            <a href="{{ route('pembimbing.profile') }}" class="sidebar-link {{ request()->routeIs('pembimbing.profile') ? 'active' : '' }} text-sm" title="Profil">
                <div class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="sidebar-label">Profil</span>
            </a>
        </nav>
    </div>

    {{-- Sidebar Footer --}}
    <div class="p-2 border-t border-white/8">
        <div class="rounded-xl p-2 border border-white/8 bg-white/[0.03]">
            @if (request()->routeIs('pembimbing.logbook'))
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="sidebar-footer-text min-w-0">
                        <p class="text-[10px] font-semibold text-blue-200/70">Menunggu Review</p>
                        <p class="text-xs font-bold text-white truncate">{{ $jumlahPending ?? 0 }} Logbook</p>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="sidebar-footer-text min-w-0">
                        <p class="text-[10px] font-semibold text-blue-200/70">Peserta Bimbingan</p>
                        <p class="text-xs font-bold text-white truncate">{{ $jumlahPeserta ?? 0 }} Peserta Aktif</p>
                        <div class="mt-1 h-1 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</aside>

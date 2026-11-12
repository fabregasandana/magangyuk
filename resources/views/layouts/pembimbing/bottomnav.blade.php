{{-- MOBILE BOTTOM NAV PEMBIMBING --}}
<div class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-blue-100 px-4 py-2.5 flex justify-around z-40">
    <a href="{{ route('pembimbing.dashboard') }}" class="flex flex-col items-center gap-0.5 py-1.5 {{ request()->routeIs('pembimbing.dashboard') ? 'text-komdigi-blue' : 'text-slate-400' }}">
        <div class="w-8 h-8 rounded-xl {{ request()->routeIs('pembimbing.dashboard') ? 'bg-komdigi-blue/10' : 'bg-white/5' }} flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
        <span class="text-[10px] {{ request()->routeIs('pembimbing.dashboard') ? 'font-semibold' : 'font-medium' }}">Beranda</span>
    </a>
    <a href="{{ route('pembimbing.peserta') }}" class="flex flex-col items-center gap-0.5 py-1.5 {{ request()->routeIs('pembimbing.peserta', 'pembimbing.detailpeserta') ? 'text-komdigi-blue' : 'text-slate-400' }}">
        <div class="w-8 h-8 rounded-xl {{ request()->routeIs('pembimbing.peserta', 'pembimbing.detailpeserta') ? 'bg-komdigi-blue/10' : 'bg-white/5' }} flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <span class="text-[10px] {{ request()->routeIs('pembimbing.peserta', 'pembimbing.detailpeserta') ? 'font-semibold' : 'font-medium' }}">Peserta</span>
    </a>
    <a href="{{ route('pembimbing.logbook') }}" class="flex flex-col items-center gap-0.5 py-1.5 {{ request()->routeIs('pembimbing.logbook') ? 'text-komdigi-blue' : 'text-slate-400' }}">
        <div class="w-8 h-8 rounded-xl {{ request()->routeIs('pembimbing.logbook') ? 'bg-komdigi-blue/10' : 'bg-white/5' }} flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <span class="text-[10px] {{ request()->routeIs('pembimbing.logbook') ? 'font-semibold' : 'font-medium' }}">Logbook</span>
    </a>
    <a href="{{ route('pembimbing.profile') }}" class="flex flex-col items-center gap-0.5 py-1.5 {{ request()->routeIs('pembimbing.profile') ? 'text-komdigi-blue' : 'text-slate-400' }}">
        <div class="w-8 h-8 rounded-xl {{ request()->routeIs('pembimbing.profile') ? 'bg-komdigi-blue/10' : 'bg-white/5' }} flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <span class="text-[10px] {{ request()->routeIs('pembimbing.profile') ? 'font-semibold' : 'font-medium' }}">Profil</span>
    </a>
</div>

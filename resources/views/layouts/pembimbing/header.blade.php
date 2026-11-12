{{-- TOP BAR PEMBIMBING --}}
@php
    $namaTampil = (auth()->check() && auth()->user()->name) ? auth()->user()->name : ($mentor['nama_pendek'] ?? 'Pembimbing');
    $inisialTampil = $mentor['inisial'] ?? collect(explode(' ', $namaTampil))->filter()->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
@endphp
<header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
    <div class="w-full">
        <div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">

            {{-- Logo --}}
            <div class="flex items-center gap-3 shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-komdigi-blue rounded-xl blur-md opacity-40"></div>
                    <div class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">
                        K
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="font-extrabold text-white text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                    <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Pembimbing</div>
                </div>
            </div>

            {{-- Nav Links --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('pembimbing.dashboard') }}" class="px-4 py-1.5 text-sm {{ request()->routeIs('pembimbing.dashboard') ? 'font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30' : 'font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition' }}">Beranda</a>
                <a href="{{ route('pembimbing.peserta') }}" class="px-4 py-1.5 text-sm {{ request()->routeIs('pembimbing.peserta', 'pembimbing.detailpeserta') ? 'font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30' : 'font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition' }}">Peserta</a>
                <a href="{{ route('pembimbing.logbook') }}" class="px-4 py-1.5 text-sm {{ request()->routeIs('pembimbing.logbook') ? 'font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30' : 'font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition' }}">Logbook</a>
                <a href="{{ route('pembimbing.penilaianpeserta') }}" class="px-4 py-1.5 text-sm {{ request()->routeIs('pembimbing.penilaianpeserta') ? 'font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30' : 'font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition' }}">Penilaian</a>
                <a href="{{ route('pembimbing.laporanbimbingan') }}" class="px-4 py-1.5 text-sm {{ request()->routeIs('pembimbing.laporanbimbingan') ? 'font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30' : 'font-medium text-slate-300 hover:text-white hover:bg-white/10 rounded-full transition' }}">Laporan</a>
            </nav>

            {{-- User + Logout --}}
            <div class="flex items-center gap-3 shrink-0">
                <div class="hidden sm:flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20 shadow-md">
                        {{ $inisialTampil }}
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-bold text-white leading-tight">{{ $namaTampil }}</div>
                        <div class="text-[10px] text-emerald-400 font-medium">● Online</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@php
    // Nama & inisial dinamis: pakai user login bila ada, fallback data dummy dari controller.
    $headerName = auth()->check() ? auth()->user()->name : ($peserta['nama'] ?? 'Peserta Magang');
    $headerInitials = collect(explode(' ', trim($headerName)))
        ->filter(fn ($word) => $word !== '')
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('') ?: 'P';

    $headerNav = [
        ['label' => 'Beranda', 'route' => 'peserta.dashboard', 'match' => 'peserta.dashboard'],
        ['label' => 'Absen', 'route' => 'peserta.absensi', 'match' => 'peserta.absensi'],
        ['label' => 'Riwayat', 'route' => 'peserta.riwayat', 'match' => 'peserta.riwayat'],
        ['label' => 'Laporan', 'route' => 'peserta.laporan', 'match' => 'peserta.laporan'],
        ['label' => 'Profil', 'route' => 'peserta.profil', 'match' => 'peserta.profil'],
    ];
@endphp
<!-- TOP BAR – full width -->
<header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
    <div class="w-full">
        <div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">

            <!-- Logo -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-komdigi-blue rounded-xl blur-md opacity-40"></div>
                    <a href="{{ route('peserta.dashboard') }}"
                        class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">
                        K
                    </a>
                </div>
                <div class="hidden sm:block">
                    <div class="font-extrabold text-komdigi-dark text-sm leading-tight tracking-tight">MAGANG KOMDIGI
                    </div>
                    <div class="text-[10px] font-semibold text-komdigi-cerulean">2026 • Digital Generation</div>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="hidden lg:flex items-center gap-1">
                @foreach ($headerNav as $item)
                    @if (request()->routeIs($item['match']))
                        <a href="{{ route($item['route']) }}"
                            class="px-4 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-md shadow-blue-500/30">{{ $item['label'] }}</a>
                    @else
                        <a href="{{ route($item['route']) }}"
                            class="px-4 py-1.5 text-sm font-medium text-slate-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">{{ $item['label'] }}</a>
                    @endif
                @endforeach
            </nav>

            <!-- User + Logout -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="hidden sm:flex items-center gap-2.5">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean flex items-center justify-center text-white text-xs font-bold ring-2 ring-white shadow-md">
                        {{ $headerInitials }}
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-bold text-slate-800 leading-tight">{{ $headerName }}</div>
                        <div class="text-[10px] text-emerald-600 font-medium">● Online</div>
                    </div>
                </div>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition shadow-md">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

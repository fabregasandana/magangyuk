<!-- TOP BAR -->
<header class="sticky top-0 z-50 pt-4 px-4 sm:px-5 relative">
    <div class="w-full">
        <div class="flex items-center justify-between gap-3 px-4 py-3 glass-strong rounded-2xl">
            <div class="flex items-center gap-3 shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-komdigi-blue rounded-xl blur-md opacity-40"></div>
                    <div
                        class="relative w-10 h-10 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg">
                        K</div>
                </div>
                <div class="hidden sm:block">
                    <div class="font-extrabold text-white text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                    <div class="text-[10px] font-semibold text-komdigi-cerulean">Admin Panel · 2026</div>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="hidden sm:flex items-center gap-2.5">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/30 shadow-md">
                        @auth
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                        @else
                            AD
                        @endauth
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-bold text-white leading-tight">
                            @auth
                                {{ auth()->user()->name ?? 'Admin' }}
                            @else
                                Admin Komdigi
                            @endauth
                        </div>
                        <div class="text-[10px] text-emerald-400 font-medium">● Online</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-dark to-komdigi-blue rounded-full hover:shadow-lg transition shadow-md">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</header>

@php
    $bottomNav = [
        [
            'label' => 'Beranda',
            'route' => 'peserta.dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'label' => 'Absen',
            'route' => 'peserta.absensi',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'label' => 'Riwayat',
            'route' => 'peserta.riwayat',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'label' => 'Profil',
            'route' => 'peserta.profil',
            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        ],
    ];
@endphp
<!-- Mobile Bottom Nav -->
<div
    class="lg:hidden fixed bottom-0 left-0 right-0 glass-strong border-t border-white/10 px-4 py-2.5 flex justify-around z-40">
    @foreach ($bottomNav as $item)
        @if (request()->routeIs($item['route']))
            <a href="{{ route($item['route']) }}" class="flex flex-col items-center gap-0.5 py-1.5 text-komdigi-cerulean">
                <div class="w-8 h-8 rounded-xl bg-komdigi-blue/20 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $item['icon'] }}" />
                    </svg>
                </div>
                <span class="text-[10px] font-semibold">{{ $item['label'] }}</span>
            </a>
        @else
            <a href="{{ route($item['route']) }}" class="flex flex-col items-center gap-0.5 py-1.5 text-slate-400">
                <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $item['icon'] }}" />
                    </svg>
                </div>
                <span class="text-[10px] font-medium">{{ $item['label'] }}</span>
            </a>
        @endif
    @endforeach
</div>

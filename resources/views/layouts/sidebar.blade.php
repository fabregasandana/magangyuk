@php
    $sidebarMenu = [
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
            'label' => 'Grafik Perkembangan',
            'route' => 'peserta.grafik',
            'icon' => 'M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z',
        ],
        [
            'label' => 'Penilaian & Feedback',
            'route' => 'peserta.penilaian',
            'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        ],
        [
            'label' => 'Laporan Akhir',
            'route' => 'peserta.laporan',
            'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        ],
        [
            'label' => 'Sertifikat',
            'route' => 'peserta.sertifikat',
            'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        ],
        [
            'label' => 'Ajukan Ketidakhadiran',
            'route' => 'peserta.izin',
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'label' => 'Profil',
            'route' => 'peserta.profil',
            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        ],
    ];

    $periodeLabel = $peserta['periode_label'] ?? 'Okt – Des 2026';
    $periodeProgress = $peserta['periode_progress'] ?? 42;
@endphp
<!-- SIDEBAR collapsible (ikon, expand saat hover) -->
<aside
    class="hidden lg:flex flex-col glass-sidebar shrink-0 sticky top-[88px] h-[calc(100vh-100px)] mt-2 mb-3 rounded-2xl">
    <div class="py-4 px-2 flex-1 overflow-y-auto overflow-x-hidden">
        <p class="sidebar-section-title text-[10px] font-bold tracking-widest text-blue-300/60 uppercase">Menu Utama</p>

        <nav class="space-y-0.5" id="sidebar-nav">
            @foreach ($sidebarMenu as $item)
                <a href="{{ route($item['route']) }}"
                    class="sidebar-link text-sm @if (request()->routeIs($item['route'])) active @endif"
                    title="{{ $item['label'] }}">
                    <div class="sidebar-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <span class="sidebar-label">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="p-2 border-t border-white/8">
        <div class="rounded-xl p-2 border border-white/8 bg-white/[0.03]">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/15 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="sidebar-footer-text min-w-0">
                    <p class="text-[10px] font-semibold text-blue-200/70">Periode Magang</p>
                    <p class="text-xs font-bold text-white truncate">{{ $periodeLabel }}</p>
                    <div class="mt-1 h-1 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-komdigi-cerulean to-blue-300 rounded-full"
                            style="width: {{ $periodeProgress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

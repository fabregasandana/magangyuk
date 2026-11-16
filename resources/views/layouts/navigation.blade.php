@php
    $menus = [
        'peserta' => [
            ['Beranda', 'peserta.dashboard', 'layout-dashboard'],
            ['Absensi', 'peserta.absensi', 'scan-face'],
            ['Riwayat kehadiran', 'peserta.riwayat', 'history'],
            ['Grafik perkembangan', 'peserta.grafik', 'chart-no-axes-combined'],
            ['Penilaian & feedback', 'peserta.penilaian', 'star'],
            ['Laporan akhir', 'peserta.laporan', 'file-text'],
            ['Sertifikat', 'peserta.sertifikat', 'award'],
            ['Ajukan ketidakhadiran', 'peserta.izin', 'calendar-off'],
            ['Profil', 'peserta.profil', 'user-round'],
        ],
        'pembimbing' => [
            ['Beranda', 'pembimbing.dashboard', 'layout-dashboard'],
            ['Daftar peserta', 'pembimbing.peserta', 'users-round', 'pembimbing.detailpeserta'],
            ['Approval logbook', 'pembimbing.logbook', 'book-open-check'],
            ['Penilaian peserta', 'pembimbing.penilaianpeserta', 'star'],
            ['Laporan bimbingan', 'pembimbing.laporanbimbingan', 'chart-no-axes-combined'],
            ['Profil', 'pembimbing.profile', 'user-round'],
        ],
        'admin' => [
            ['Dashboard', 'admin.dashboard', 'layout-dashboard'],
            ['Manajemen peserta', 'admin.manajemen-peserta', 'users-round'],
            ['Manajemen pembimbing', 'admin.manajemen-pembimbing', 'user-round-check'],
            ['Monitoring kinerja', 'admin.monitoring', 'chart-no-axes-combined'],
            ['Laporan & penilaian', 'admin.kelola-penilaian', 'clipboard-check'],
            ['CMS konten', 'admin.cms', 'panels-top-left'],
            ['Fitur pendukung', 'admin.feature-pendukung', 'settings-2'],
        ],
    ];
    $menu = $menus[$role];
@endphp
@if (($variant ?? 'sidebar') === 'bottom')
    <nav class="bottom-nav" aria-label="Navigasi cepat">
        @foreach (array_slice($menu, 0, 3) as [$label, $route, $icon])
            <a href="{{ route($route) }}" class="bottom-nav-link {{ request()->routeIs($route) ? 'active' : '' }}" @if(request()->routeIs($route)) aria-current="page" @endif>
                <i data-lucide="{{ $icon }}" class="w-5 h-5" aria-hidden="true"></i>
                <span>{{ $role === 'admin' ? str_replace('Manajemen ', '', $label) : str_replace('Riwayat kehadiran', 'Riwayat', $label) }}</span>
            </a>
        @endforeach
        <button type="button" class="bottom-nav-link" data-navigation-toggle aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka semua menu">
            <i data-lucide="menu" class="w-5 h-5" aria-hidden="true"></i>
            <span>Menu lainnya</span>
        </button>
    </nav>
@else
    <div class="navigation-backdrop" data-navigation-close aria-hidden="true"></div>
    <aside class="glass-sidebar" id="app-sidebar" aria-label="Navigasi {{ $role }}" tabindex="-1">
        <div class="sidebar-mobile-heading">
            <p class="font-semibold text-sm">Menu {{ ucfirst($role) }}</p>
            <button type="button" class="ui-icon-button" data-navigation-close aria-label="Tutup navigasi"><i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i></button>
        </div>
        <div class="sidebar-scroll">
            <p class="sidebar-section-title">Workspace / {{ $role }}</p>
            <nav id="sidebar-nav" aria-label="Menu utama">
                @foreach ($menu as $item)
                    @php
                        [$label, $route, $icon] = $item;
                        $isActive = request()->routeIs($route, $item[3] ?? $route);
                    @endphp
                    <a href="{{ route($route) }}" class="sidebar-link {{ $isActive ? 'active' : '' }}" title="{{ $label }}" @if($isActive) aria-current="page" @endif>
                        <span class="sidebar-icon"><i data-lucide="{{ $icon }}" class="w-[18px] h-[18px]" aria-hidden="true"></i></span>
                        <span class="sidebar-label">{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
        <div class="sidebar-footer">
            @if ($role === 'peserta' && isset($peserta['periode_label']))
                <p class="ui-eyebrow">Periode magang</p>
                <p class="text-xs font-semibold mt-2">{{ $peserta['periode_label'] }}</p>
                <div class="h-1 bg-elevated rounded-full overflow-hidden mt-3" role="progressbar" aria-label="Periode magang berjalan" aria-valuenow="{{ $peserta['periode_progress'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="h-full bg-komdigi-blue rounded-full" data-progress style="width: {{ max(0, min(100, $peserta['periode_progress'] ?? 0)) }}%"></div>
                </div>
            @elseif ($role === 'pembimbing')
                <p class="ui-eyebrow">Ruang bimbingan</p>
                <p class="text-xs text-muted mt-2 leading-relaxed">Dampingi proses. Apresiasi setiap perkembangan.</p>
            @else
                <p class="ui-eyebrow">Magang Komdigi</p>
                <p class="text-xs text-muted mt-2 leading-relaxed">Monitoring yang terarah,<br>pengelolaan yang lebih mudah.</p>
            @endif
        </div>
    </aside>
@endif

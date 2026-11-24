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
    $sidebarName = auth()->user()?->nama_lengkap ?? ucfirst($role);
    $sidebarInitials = collect(explode(' ', trim($sidebarName)))->filter()->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
    $sidebarProfileRoute = match ($role) {
        'peserta' => 'peserta.profil',
        'pembimbing' => 'pembimbing.profile',
        default => 'admin.feature-pendukung',
    };
    $roleMeta = [
        'peserta' => ['label' => 'Peserta magang', 'icon' => 'graduation-cap'],
        'pembimbing' => ['label' => 'Pembimbing magang', 'icon' => 'users-round'],
        'admin' => ['label' => 'Administrator', 'icon' => 'shield-check'],
    ][$role];
    $help = [
        'peserta' => ['title' => 'Butuh bantuan?', 'copy' => 'Pelajari alur absensi dan logbook agar progres magangmu tetap rapi.', 'label' => 'Buka panduan', 'route' => 'peserta.laporan', 'icon' => 'circle-help'],
        'pembimbing' => ['title' => 'Ruang bimbingan', 'copy' => 'Tinjau logbook dan beri umpan balik yang membangun setiap minggu.', 'label' => 'Lihat logbook', 'route' => 'pembimbing.logbook', 'icon' => 'book-open-check'],
        'admin' => ['title' => 'Pusat kendali', 'copy' => 'Pantau performa program dan tindak lanjuti peserta yang perlu perhatian.', 'label' => 'Monitoring', 'route' => 'admin.monitoring', 'icon' => 'chart-no-axes-combined'],
    ][$role];
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
        <div class="sidebar-brand">
            <a href="{{ route($role . '.dashboard') }}" class="app-brand" aria-label="Magang Komdigi — beranda">
                <span class="sidebar-brand-mark"><i data-lucide="radio-tower" class="w-5 h-5" aria-hidden="true"></i></span>
                <span class="sidebar-brand-text">
                    <span class="sidebar-brand-name">Magang Komdigi</span>
                    <span class="sidebar-brand-caption">Ruang tumbuh talenta digital</span>
                </span>
            </a>
        </div>

        <div class="sidebar-mobile-heading">
            <p class="font-semibold text-sm">Menu {{ ucfirst($role) }}</p>
            <button type="button" class="ui-icon-button" data-navigation-close aria-label="Tutup navigasi"><i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i></button>
        </div>

        <div class="sidebar-scroll">
            <nav id="sidebar-nav" aria-label="Menu utama">
                @foreach ($menu as $item)
                    @php
                        [$label, $route, $icon] = $item;
                        $isActive = request()->routeIs($route, $item[3] ?? $route);
                    @endphp
                    <a href="{{ route($route) }}" class="sidebar-link {{ $isActive ? 'active' : '' }}" title="{{ $label }}" aria-label="{{ $label }}" data-nav-label="{{ $label }}" @if($isActive) aria-current="page" @endif>
                        <span class="sidebar-icon"><i data-lucide="{{ $icon }}" class="w-[18px] h-[18px]" aria-hidden="true"></i></span>
                        <span class="sidebar-label">{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route($sidebarProfileRoute) }}" class="sidebar-account" aria-label="Profil {{ $sidebarName }}">
                <span class="app-avatar" aria-hidden="true">{{ $sidebarInitials }}</span>
                <span class="sidebar-account-copy">
                    <strong>{{ $sidebarName }}</strong>
                    <small>{{ $roleMeta['label'] }}</small>
                </span>
            </a>
            <button type="button" class="sidebar-collapse-button" data-sidebar-pin aria-controls="app-sidebar" aria-expanded="false" aria-pressed="false" aria-label="Sematkan menu">
                <i data-lucide="panel-left" class="w-5 h-5" aria-hidden="true"></i>
                <span>Sematkan menu</span>
            </button>
        </div>
    </aside>
@endif

@php
    $accountName = auth()->user()?->name ?? ucfirst($role);
    $accountEmail = auth()->user()?->email ?? '';
    $accountInitials = collect(explode(' ', trim($accountName)))->filter()->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
    $roleLabel = ['admin' => 'Administrator', 'pembimbing' => 'Pembimbing', 'peserta' => 'Peserta magang'][$role];
    $roleShort = ['admin' => 'Admin', 'pembimbing' => 'Pembimbing', 'peserta' => 'Peserta'][$role];
    $pageTitle = trim($pageTitle ?? $roleShort);
    $profileRoute = match ($role) {
        'peserta' => route('peserta.profil'),
        'pembimbing' => route('pembimbing.profile'),
        default => route('admin.feature-pendukung'),
    };
    $notifications = match ($role) {
        'peserta' => [
            ['title' => 'Lengkapi logbook harian', 'desc' => 'Catat kegiatan sebelum hari berakhir.', 'href' => route('peserta.laporan'), 'icon' => 'notebook-pen', 'time' => 'Hari ini'],
            ['title' => 'Absensi menunggu', 'desc' => 'Pastikan kehadiran hari ini sudah tercatat.', 'href' => route('peserta.absensi'), 'icon' => 'scan-face', 'time' => 'Hari ini'],
            ['title' => 'Feedback pembimbing', 'desc' => 'Lihat penilaian dan catatan terbaru.', 'href' => route('peserta.penilaian'), 'icon' => 'star', 'time' => 'Minggu ini'],
        ],
        'pembimbing' => [
            ['title' => 'Logbook menunggu review', 'desc' => 'Beberapa peserta menunggu persetujuan.', 'href' => route('pembimbing.logbook'), 'icon' => 'book-open-check', 'time' => 'Hari ini'],
            ['title' => 'Penilaian belum lengkap', 'desc' => 'Lengkapi penilaian peserta bimbingan.', 'href' => route('pembimbing.penilaianpeserta'), 'icon' => 'star', 'time' => 'Minggu ini'],
            ['title' => 'Laporan bimbingan', 'desc' => 'Rekap progres peserta siap ditinjau.', 'href' => route('pembimbing.laporanbimbingan'), 'icon' => 'chart-column', 'time' => 'Minggu ini'],
        ],
        default => [
            ['title' => 'Peserta perlu perhatian', 'desc' => 'Tinjau performa dan kehadiran peserta.', 'href' => route('admin.monitoring'), 'icon' => 'circle-alert', 'time' => 'Hari ini'],
            ['title' => 'Logbook menunggu approval', 'desc' => 'Antrean persetujuan perlu ditindaklanjuti.', 'href' => route('admin.kelola-penilaian'), 'icon' => 'clipboard-check', 'time' => 'Hari ini'],
            ['title' => 'Konten CMS', 'desc' => 'Perbarui informasi landing page.', 'href' => route('admin.cms'), 'icon' => 'panels-top-left', 'time' => 'Minggu ini'],
        ],
    };
@endphp
<a href="#main-content" class="skip-link">Lewati ke konten utama</a>
<header class="app-header">
    <div class="app-header-start">
        <button type="button" class="ui-icon-button" data-navigation-toggle aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka navigasi">
            <i data-lucide="panel-left" class="w-4 h-4" aria-hidden="true"></i>
        </button>
        <div class="app-header-crumbs">
            <p class="app-header-crumb">
                <span>Workspace</span>
                <i data-lucide="chevron-right" class="w-3 h-3" aria-hidden="true"></i>
                <span>{{ $roleShort }}</span>
            </p>
            <p class="app-header-title">{{ $pageTitle }}</p>
        </div>
    </div>

    <div class="app-header-actions">
        <button type="button" class="app-search" @click="openCommand()" aria-label="Cari halaman atau menu (Ctrl K)" aria-keyshortcuts="Control+K">
            <i data-lucide="search" class="w-4 h-4" aria-hidden="true"></i>
            <span>Cari menu atau halaman…</span>
            <kbd>Ctrl K</kbd>
        </button>

        @include('layouts.theme-toggle')

        <div class="app-action" @keydown.escape="notifOpen = false">
            <button type="button" class="ui-icon-button app-action-button" @click="toggleNotifications()" :aria-expanded="notifOpen ? 'true' : 'false'" aria-haspopup="true" aria-label="Notifikasi">
                <i data-lucide="bell" class="w-4 h-4" aria-hidden="true"></i>
                <span class="app-action-dot" aria-hidden="true"></span>
            </button>
            <div class="popover" x-show="notifOpen" x-cloak x-transition.origin.top.right @click.outside="notifOpen = false" role="menu" aria-label="Notifikasi">
                <div class="popover-head">
                    <p class="popover-title">Notifikasi</p>
                    <span class="chip">{{ count($notifications) }} baru</span>
                </div>
                <div class="popover-body">
                    @foreach ($notifications as $notification)
                        <a href="{{ $notification['href'] }}" class="popover-item" role="menuitem">
                            <span class="popover-item-icon"><i data-lucide="{{ $notification['icon'] }}" class="w-4 h-4" aria-hidden="true"></i></span>
                            <span class="min-w-0">
                                <span class="popover-item-title block">{{ $notification['title'] }}</span>
                                <span class="popover-item-desc block">{{ $notification['desc'] }} · {{ $notification['time'] }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
                <div class="popover-foot">
                    <a href="{{ $profileRoute }}" class="text-xs font-semibold text-primary hover:underline">Kelola preferensi</a>
                </div>
            </div>
        </div>

        <div class="app-action" @keydown.escape="profileOpen = false">
            <button type="button" class="app-account" @click="toggleProfile()" :aria-expanded="profileOpen ? 'true' : 'false'" aria-haspopup="true" aria-label="Menu akun {{ $accountName }}">
                <span class="app-avatar">{{ $accountInitials }}</span>
                <span class="app-account-copy">
                    <span class="app-account-name block">{{ $accountName }}</span>
                    <span class="app-account-role block">{{ $roleLabel }}</span>
                </span>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-muted" aria-hidden="true"></i>
            </button>
            <div class="popover" x-show="profileOpen" x-cloak x-transition.origin.top.right @click.outside="profileOpen = false" role="menu" aria-label="Menu akun">
                <div class="profile-meta">
                    <p class="profile-name">{{ $accountName }}</p>
                    <p class="profile-email">{{ $accountEmail }}</p>
                </div>
                <div class="popover-body">
                    <a href="{{ $profileRoute }}" class="popover-item" role="menuitem">
                        <span class="popover-item-icon"><i data-lucide="user-round" class="w-4 h-4" aria-hidden="true"></i></span>
                        <span><span class="popover-item-title block">Profil & pengaturan</span><span class="popover-item-desc block">Kelola data akun dan preferensi</span></span>
                    </a>
                    <button type="button" class="popover-item" role="menuitem" @click="notify('Tema mengikuti preferensi perangkat Anda.', 'info')">
                        <span class="popover-item-icon"><i data-lucide="sparkles" class="w-4 h-4" aria-hidden="true"></i></span>
                        <span><span class="popover-item-title block">Pintasan cepat</span><span class="popover-item-desc block">Tekan Ctrl K untuk mencari halaman</span></span>
                    </button>
                </div>
                <div class="popover-foot">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="popover-item w-full" role="menuitem">
                            <span class="popover-item-icon"><i data-lucide="log-out" class="w-4 h-4" aria-hidden="true"></i></span>
                            <span class="popover-item-title">Keluar dari akun</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

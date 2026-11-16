@php
    $accountName = auth()->user()?->name ?? ucfirst($role);
    $accountInitials = collect(explode(' ', trim($accountName)))->filter()->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
    $roleLabel = ['admin' => 'Administrator', 'pembimbing' => 'Pembimbing', 'peserta' => 'Peserta magang'][$role];
@endphp
<a href="#main-content" class="skip-link">Lewati ke konten utama</a>
<header class="app-header">
    <div class="flex items-center gap-4 min-w-0">
        <button type="button" class="ui-icon-button" data-navigation-toggle aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka navigasi">
            <i data-lucide="panel-left" class="w-4 h-4" aria-hidden="true"></i>
        </button>
        <a href="{{ route($role . '.dashboard') }}" class="app-brand" aria-label="Magang Komdigi — beranda">
            <span class="app-brand-mark"><i data-lucide="radio-tower" class="w-5 h-5" aria-hidden="true"></i></span>
            <span>
                <span class="app-brand-name block">Magang Komdigi<span class="text-primary">.</span></span>
                <span class="app-brand-caption block">Ruang tumbuh talenta digital</span>
            </span>
        </a>
    </div>
    <div class="app-header-actions">
        @include('layouts.theme-toggle')
        <div class="app-account">
            <span class="app-avatar">{{ $accountInitials }}</span>
            <div>
                <p class="app-account-name">{{ $accountName }}</p>
                <p class="app-account-role">{{ $roleLabel }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ui-icon-button" aria-label="Keluar dari akun" title="Keluar dari akun">
                <i data-lucide="log-out" class="w-4 h-4" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</header>

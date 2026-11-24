<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pembimbing') | Magang Komdigi</title>
    @include('layouts.theme-init')
    @vite(['resources/css/pembimbing.css', 'resources/js/pembimbing.js'])
    @stack('styles')
</head>
<body class="dashboard-body font-sans antialiased">
    <div class="app-shell" x-data="appChrome" @keydown.window.ctrl.k.prevent="openCommand()" @keydown.window.meta.k.prevent="openCommand()" @keydown.window.escape="closeCommand()">
        @include('layouts.pembimbing.sidebar')
        <div class="app-main">
            @include('layouts.pembimbing.header', ['pageTitle' => trim($__env->yieldContent('title', 'Dashboard Pembimbing'))])
            <main id="main-content" class="dashboard-main" tabindex="-1">
                <div class="glass-panel space-y-6">
                    @include('layouts.pembimbing.flash')
                    @yield('content')
                </div>
            </main>
        </div>
        @include('layouts.dashboard-overlays', ['role' => 'pembimbing'])
    </div>
    @include('layouts.pembimbing.bottomnav')
    @stack('modals')
    @yield('scripts')
    @stack('scripts')
</body>
</html>

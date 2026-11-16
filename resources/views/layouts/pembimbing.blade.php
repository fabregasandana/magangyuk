<!DOCTYPE html>
<html lang="id" data-theme="dark">
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
    @include('layouts.pembimbing.header')
    <div class="dashboard-shell">
        @include('layouts.pembimbing.sidebar')
        <main id="main-content" class="dashboard-main" tabindex="-1">
            <div class="glass-panel space-y-6">
                @include('layouts.pembimbing.flash')
                @yield('content')
            </div>
        </main>
    </div>
    @include('layouts.pembimbing.bottomnav')
    @stack('modals')
    @yield('scripts')
    @stack('scripts')
</body>
</html>

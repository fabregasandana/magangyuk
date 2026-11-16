<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peserta') | Magang Komdigi</title>
    @include('layouts.theme-init')
    @vite(['resources/css/peserta.css', 'resources/js/peserta.js'])
    @stack('styles')
</head>
<body class="dashboard-body font-sans antialiased">
    @include('layouts.header')
    <div class="dashboard-shell">
        @include('layouts.sidebar')
        <main id="main-content" class="dashboard-main" tabindex="-1">
            @include('layouts.peserta.flash')
            @yield('content')
        </main>
    </div>
    @include('layouts.peserta.bottomnav')
    @stack('modals')
    @stack('scripts')
</body>
</html>

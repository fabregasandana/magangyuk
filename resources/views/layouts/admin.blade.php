<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Magang Komdigi</title>
    @include('layouts.theme-init')
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body class="dashboard-body admin-body font-sans antialiased">
    @include('layouts.admin.header')
    <div class="dashboard-shell">
        @include('layouts.admin.sidebar')
        <main id="main-content" class="dashboard-main" tabindex="-1">
            <div class="glass-panel space-y-6">
                @if (session('success'))
                    <div role="status" class="flex items-start gap-3 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                        <i data-lucide="circle-check" class="w-5 h-5 text-emerald-400 shrink-0" aria-hidden="true"></i>
                        <p class="text-sm font-medium text-emerald-400">{{ session('success') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <div role="alert" class="flex items-start gap-3 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20">
                        <i data-lucide="circle-alert" class="w-5 h-5 text-rose-400 shrink-0" aria-hidden="true"></i>
                        <div class="text-sm text-rose-400">
                            <p class="font-semibold">Mohon periksa kembali isian Anda:</p>
                            <ul class="list-disc list-inside mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @include('layouts.navigation', ['role' => 'admin', 'variant' => 'bottom'])
    @stack('modals')
    @stack('scripts')
</body>
</html>

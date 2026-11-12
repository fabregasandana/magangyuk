<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Magang Komdigi 2026</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    {{-- @viteFonts() --}}
    @stack('styles')
</head>

<body class="admin-body font-sans antialiased">

    @include('layouts.admin.header')

    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">

        @include('layouts.admin.sidebar')

        <!-- MAIN -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                @if (session('success'))
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-emerald-300">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30">
                        <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-rose-300">
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

    {{-- Modal harus berada di level body: backdrop-filter pada glass-panel
         membuat ancestor menjadi containing block untuk posisi fixed. --}}
    @stack('modals')
    @stack('scripts')
</body>

</html>

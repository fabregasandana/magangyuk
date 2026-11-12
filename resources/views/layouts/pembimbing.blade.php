<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pembimbing') | Magang Komdigi 2026</title>
    @vite(['resources/css/pembimbing.css', 'resources/js/pembimbing.js'])
    @viteFonts()
</head>
<body class="font-sans text-slate-800 antialiased">

    @include('layouts.pembimbing.header')

    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">

        @include('layouts.pembimbing.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

                @include('layouts.pembimbing.flash')

                @yield('content')

                @include('layouts.pembimbing.bottomnav')

                <div class="h-20 lg:hidden"></div>
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>

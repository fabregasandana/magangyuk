<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peserta') | MagangYuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/peserta.css', 'resources/js/peserta.js'])
    @fonts
</head>
<body class="font-sans text-slate-800 antialiased">
    @include('layouts.header')
    <div class="flex min-h-[calc(100vh-88px)] relative z-10 pl-0 lg:pl-3 gap-0 lg:gap-3">
        @include('layouts.sidebar')
        <!-- MAIN CONTENT -->
        <main class="flex-1 p-3 sm:p-4 lg:p-5 overflow-y-auto">
            @include('layouts.peserta.flash')
            @yield('content')
            <div class="h-20 lg:hidden"></div>
        </main>
    </div>
    @include('layouts.peserta.bottomnav')
</body>
</html>

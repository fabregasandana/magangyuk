<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magang Komdigi 2026 | Kementerian Komunikasi dan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="{{ asset('js/index.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body class="bg-gradient-to-b from-blue-50 via-indigo-50/30 to-pink-50/40 font-sans text-gray-800 antialiased">

    <!-- HEADER - Floating Rounded Navbar -->
<header class="sticky top-0 z-50 pt-4 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between gap-3 px-3 sm:px-4 py-2.5 bg-white/90 backdrop-blur-xl rounded-full shadow-lg shadow-black/5 border border-white/80">
            
            <!-- Logo -->
            <div class="flex items-center gap-2.5 shrink-0 pl-1">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-xl blur opacity-50"></div>
                    <div class="relative w-9 h-9 bg-gradient-to-br from-komdigi-blue via-komdigi-cerulean to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-md">
                        K
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="font-extrabold text-komdigi-dark text-sm leading-tight tracking-tight">MAGANG KOMDIGI</div>
                    <div class="text-[10px] font-bold bg-gradient-to-r from-komdigi-cerulean to-komdigi-gold bg-clip-text text-transparent">2026</div>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="hidden lg:flex items-center gap-0.5">
                <a href="#" class="px-3.5 py-1.5 text-sm font-semibold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full shadow-sm">Beranda</a>
                <a href="#tentang" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Tentang Kami</a>
                <a href="#profil" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Profil</a>
                <a href="#kegiatan" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Kegiatan</a>
                <a href="#anggota" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Anggota</a>
                <a href="#dokumentasi" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Dokumentasi</a>
                <a href="#" class="px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-komdigi-blue hover:bg-blue-50 rounded-full transition">Admin</a>
            </nav>

            <!-- Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <a href="/login" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-amber-800 bg-amber-100 hover:bg-amber-200 rounded-full transition">
                    Login
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
                
               
            </div>
        </div>
    </div>
</header>

    <!-- HERO -->
    <section class="hero-gradient pt-14 pb-32 md:pt-20 md:pb-40 relative overflow-hidden">
        <!-- Animated Blobs -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-komdigi-blue/25 rounded-full blur-3xl blob animate-float"></div>
        <div class="absolute bottom-0 left-0 w-[450px] h-[450px] bg-komdigi-cerulean/30 rounded-full blur-3xl blob animate-float-slow" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-80 h-80 bg-komdigi-gold/25 rounded-full blur-3xl blob animate-float" style="animation-delay: -4s;"></div>
        <div class="absolute bottom-20 right-1/4 w-64 h-64 bg-pink-400/20 rounded-full blur-3xl blob animate-float-slow" style="animation-delay: -1s;"></div>
        <div class="absolute top-20 left-1/4 w-48 h-48 bg-indigo-400/20 rounded-full blur-3xl animate-pulse-soft"></div>

        <!-- Decorative circles -->
        <div class="absolute top-32 right-20 w-3 h-3 bg-komdigi-blue rounded-full opacity-60 animate-pulse-soft"></div>
        <div class="absolute top-48 right-40 w-2 h-2 bg-komdigi-gold rounded-full opacity-70"></div>
        <div class="absolute bottom-40 left-16 w-4 h-4 bg-pink-400 rounded-full opacity-50 animate-pulse-soft"></div>
        <div class="absolute top-1/2 left-10 w-2 h-2 bg-komdigi-cerulean rounded-full opacity-60"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 glass-strong border border-white/60 rounded-full text-sm font-bold text-komdigi-blue mb-6 shadow-lg shadow-blue-500/10">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-komdigi-blue opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-komdigi-blue"></span>
                        </span>
                        <span class="text-base">👋</span>
                        HALO, SELAMAT DATANG!
                    </div>
                    
                    <p class="text-xs font-extrabold tracking-[0.25em] text-komdigi-gold uppercase mb-4 drop-shadow-sm">
                        ✨ Perjalanan Magang Komdigi 2026
                    </p>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-[3.6rem] font-black text-gray-900 leading-[1.1] mb-6 tracking-tight">
                        Belajar, berkarya,<br>
                        <span class="text-gradient">dan bertumbuh</span><br>
                        <span class="relative inline-block">
                            <span class="text-komdigi-gold">bersama.</span>
                            <svg class="absolute -bottom-2 left-0 w-full" height="8" viewBox="0 0 200 8" fill="none">
                                <path d="M1 5.5C50 1.5 150 1.5 199 5.5" stroke="#FFB700" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h1>
                    
                    <p class="text-gray-600 text-lg leading-relaxed mb-9 max-w-lg">
                        Pusat informasi, kegiatan, logbook, dan dokumentasi 
                        <span class="font-semibold text-komdigi-blue">Magang Komdigi 2026</span>. 
                        Data kegiatan yang dikirim melalui Logbook tampil secara otomatis.
                    </p>

                    <div class="flex flex-wrap gap-3.5">
                        <a href="#kegiatan" class="btn-shine inline-flex items-center gap-2.5 px-8 py-4 bg-gradient-to-r from-komdigi-blue via-komdigi-cerulean to-indigo-500 text-white font-bold rounded-full hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 shadow-xl shadow-blue-500/30 text-[15px]">
                            Lihat Kegiatan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#dokumentasi" class="inline-flex items-center px-8 py-4 glass-strong text-komdigi-blue font-bold rounded-full border-2 border-komdigi-blue/30 hover:border-komdigi-blue hover:bg-white transition-all duration-300 shadow-lg text-[15px]">
                            Lihat Dokumentasi
                        </a>
                    </div>

                    <!-- Stats mini -->
                    <div class="flex items-center gap-6 mt-10">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                                <span class="text-lg">📅</span>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Periode</div>
                                <div class="text-sm font-bold text-gray-800">Okt – Des 2026</div>
                            </div>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-yellow-50 flex items-center justify-center">
                                <span class="text-lg">🎯</span>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Status</div>
                                <div class="text-sm font-bold text-emerald-600">Sedang Berjalan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Countdown Card -->
                <div class="relative animate-float">
                    <div class="absolute -inset-2 bg-gradient-to-r from-komdigi-blue via-komdigi-cerulean via-komdigi-gold to-pink-400 rounded-[32px] blur-md opacity-50 animate-pulse-soft"></div>
                    <div class="relative glass-strong rounded-[28px] shadow-2xl p-7 md:p-8 border border-white/80">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-bold tracking-wider text-gray-400 uppercase">⏱️ Masa Magang</p>
                            <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-400 to-green-500 text-white text-xs font-bold rounded-full shadow-md shadow-green-500/30 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                        </div>
                        <p class="text-xl font-extrabold text-gray-900 mb-1">Periode Magang Komdigi 2026</p>
                        <p class="text-sm text-gray-500 mb-7">Berakhir pada <span class="font-bold text-komdigi-blue">19 Desember 2026</span></p>
                        
                        <div class="grid grid-cols-4 gap-3">
                            <div class="countdown-box bg-gradient-to-br from-blue-50 via-blue-100/80 to-indigo-50 rounded-2xl p-4 text-center border border-blue-200/60 shadow-sm">
                                <div class="text-3xl md:text-4xl font-black text-komdigi-blue" id="days">—</div>
                                <div class="text-[10px] font-bold text-blue-600/70 mt-1.5 tracking-widest">HARI</div>
                            </div>
                            <div class="countdown-box bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 rounded-2xl p-4 text-center border border-amber-200/60 shadow-sm">
                                <div class="text-3xl md:text-4xl font-black text-komdigi-gold" id="hours">—</div>
                                <div class="text-[10px] font-bold text-amber-600/70 mt-1.5 tracking-widest">JAM</div>
                            </div>
                            <div class="countdown-box bg-gradient-to-br from-rose-50 via-red-50 to-pink-50 rounded-2xl p-4 text-center border border-rose-200/60 shadow-sm">
                                <div class="text-3xl md:text-4xl font-black text-komdigi-red" id="minutes">—</div>
                                <div class="text-[10px] font-bold text-rose-600/70 mt-1.5 tracking-widest">MENIT</div>
                            </div>
                            <div class="countdown-box bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 rounded-2xl p-4 text-center border border-gray-200/80 shadow-sm">
                                <div class="text-3xl md:text-4xl font-black text-gray-700" id="seconds">—</div>
                                <div class="text-[10px] font-bold text-gray-500 mt-1.5 tracking-widest">DETIK</div>
                            </div>
                        </div>

                        <!-- Progress bar -->
                        <div class="mt-6">
                            <div class="flex justify-between text-xs font-semibold text-gray-500 mb-1.5">
                                <span>Progress Magang</span>
                                <span id="progress-text">—</span>
                            </div>
                            <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                <div id="progress-bar" class="h-full bg-gradient-to-r from-komdigi-blue via-komdigi-cerulean to-komdigi-gold rounded-full transition-all duration-1000" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK MENU -->
    <section class="relative -mt-16 z-20 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Kegiatan -->
                <a href="#kegiatan" class="card-hover group relative bg-white rounded-2xl p-5 text-center shadow-xl border border-blue-100/80 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/10 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-blue-100 to-indigo-50 rounded-2xl flex items-center justify-center group-hover:from-komdigi-blue group-hover:to-indigo-500 transition-all duration-400 shadow-inner group-hover:shadow-lg group-hover:shadow-blue-500/30">
                            <svg class="w-7 h-7 text-komdigi-blue group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-komdigi-blue transition">Kegiatan</span>
                    </div>
                </a>

                <!-- Dokumentasi -->
                <a href="#dokumentasi" class="card-hover group relative bg-white rounded-2xl p-5 text-center shadow-xl border border-purple-100/80 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-fuchsia-500/0 group-hover:from-purple-500/5 group-hover:to-fuchsia-500/10 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-purple-100 to-fuchsia-50 rounded-2xl flex items-center justify-center group-hover:from-purple-500 group-hover:to-fuchsia-500 transition-all duration-400 shadow-inner group-hover:shadow-lg group-hover:shadow-purple-500/30">
                            <svg class="w-7 h-7 text-purple-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-purple-600 transition">Dokumentasi</span>
                    </div>
                </a>

                <!-- Profil Tim -->
                <a href="#profil" class="card-hover group relative bg-white rounded-2xl p-5 text-center shadow-xl border border-pink-100/80 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500/0 to-rose-500/0 group-hover:from-pink-500/5 group-hover:to-rose-500/10 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-pink-100 to-rose-50 rounded-2xl flex items-center justify-center group-hover:from-pink-500 group-hover:to-rose-500 transition-all duration-400 shadow-inner group-hover:shadow-lg group-hover:shadow-pink-500/30">
                            <svg class="w-7 h-7 text-pink-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-pink-600 transition">Profil Tim</span>
                    </div>
                </a>

                <!-- Tentang -->
                <a href="#tentang" class="card-hover group relative bg-white rounded-2xl p-5 text-center shadow-xl border border-cyan-100/80 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/0 to-sky-500/0 group-hover:from-cyan-500/5 group-hover:to-sky-500/10 transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-cyan-100 to-sky-50 rounded-2xl flex items-center justify-center group-hover:from-cyan-500 group-hover:to-sky-500 transition-all duration-400 shadow-inner group-hover:shadow-lg group-hover:shadow-cyan-500/30">
                            <svg class="w-7 h-7 text-cyan-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-cyan-600 transition">Tentang</span>
                    </div>
                </a>

              
              
            </div>
        </div>
    </section>

    <!-- KEGIATAN TERBARU -->
    <section id="kegiatan" class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-komdigi-blue text-xs font-bold rounded-full mb-3">
                        <span class="w-1.5 h-1.5 bg-komdigi-blue rounded-full"></span>
                        TERBARU
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 section-title">Kegiatan terbaru</h2>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-komdigi-blue hover:text-komdigi-dark transition group">
                    Semua kegiatan 
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
                <!-- Card 1 -->
                <article class="card-hover group bg-white rounded-3xl overflow-hidden shadow-xl border border-blue-50/80">
                    <div class="relative h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?w=600&h=400&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="">
                        <div class="absolute inset-0 img-overlay"></div>
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md text-gray-800 text-xs font-extrabold px-3.5 py-1.5 rounded-xl shadow-lg">15 OKT</div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="inline-block text-[11px] font-bold text-white bg-komdigi-blue/90 backdrop-blur px-3 py-1 rounded-full">Pribadi</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-extrabold text-gray-900 text-lg leading-snug mb-2 group-hover:text-komdigi-blue transition">Menjadi announcer lagu Indonesia Raya</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">NR</div>
                            <span>Nisa Ramadani · 15 Oktober 2026</span>
                        </div>
                    </div>
                </article>

                <!-- Card 2 -->
                <article class="card-hover group bg-white rounded-3xl overflow-hidden shadow-xl border border-blue-50/80">
                    <div class="relative h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="">
                        <div class="absolute inset-0 img-overlay"></div>
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md text-gray-800 text-xs font-extrabold px-3.5 py-1.5 rounded-xl shadow-lg">19 OKT</div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="inline-block text-[11px] font-bold text-white bg-gray-700/90 backdrop-blur px-3 py-1 rounded-full">Semua User</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-extrabold text-gray-900 text-lg leading-snug mb-2 group-hover:text-komdigi-blue transition">Mengikuti apel pagi</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center text-white text-xs font-bold">SA</div>
                            <span>Semua Anggota · 19 Oktober 2026</span>
                        </div>
                    </div>
                </article>

                <!-- Card 3 -->
                <article class="card-hover group bg-white rounded-3xl overflow-hidden shadow-xl border border-blue-50/80">
                    <div class="relative h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&h=400&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="">
                        <div class="absolute inset-0 img-overlay"></div>
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md text-gray-800 text-xs font-extrabold px-3.5 py-1.5 rounded-xl shadow-lg">19 OKT</div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="inline-block text-[11px] font-bold text-white bg-komdigi-blue/90 backdrop-blur px-3 py-1 rounded-full">Pribadi</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-extrabold text-gray-900 text-lg leading-snug mb-2 group-hover:text-komdigi-blue transition">Menjadi announcer barang kehilangan</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">NR</div>
                            <span>Nisa Ramadani · 19 Oktober 2026</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- DOKUMENTASI -->
    <section id="dokumentasi" class="py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-white via-komdigi-soft/40 to-indigo-50/50"></div>
        <div class="absolute top-20 right-0 w-72 h-72 bg-purple-300/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-64 h-64 bg-blue-300/20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-600 text-xs font-bold rounded-full mb-3">
                        <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                        GALERI
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 section-title">Dokumentasi terbaru</h2>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-komdigi-blue hover:text-komdigi-dark transition group">
                    Semua dokumentasi 
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden group cursor-pointer shadow-xl ring-4 ring-white hover:ring-komdigi-blue/30 transition-all duration-500">
                    <img src="{{ asset('images/alip5.jpeg') }}" class="w-full h-full object-cover group-hover:scale-125 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-komdigi-dark/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition duration-500 translate-y-2 group-hover:translate-y-0">
                        <p class="text-white text-xs font-bold truncate">Dokumentasi 1</p>
                    </div>
                </div>
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden group cursor-pointer shadow-xl ring-4 ring-white hover:ring-purple-400/30 transition-all duration-500">
                    <img src="{{ asset('images/alip2.jpg') }}" class="w-full h-full object-cover group-hover:scale-125 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-komdigi-dark/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition duration-500 translate-y-2 group-hover:translate-y-0">
                        <p class="text-white text-xs font-bold truncate">Dokumentasi 2</p>
                    </div>
                </div>
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden group cursor-pointer shadow-xl ring-4 ring-white hover:ring-pink-400/30 transition-all duration-500">
                    <img src="{{ asset('images/alip3.jpg') }}" class="w-full h-full object-cover group-hover:scale-125 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-komdigi-dark/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition duration-500 translate-y-2 group-hover:translate-y-0">
                        <p class="text-white text-xs font-bold truncate">Dokumentasi 3</p>
                    </div>
                </div>
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden group cursor-pointer shadow-xl ring-4 ring-white hover:ring-komdigi-gold/40 transition-all duration-500">
                    <img src="{{ asset('images/alip4.jpeg') }}" class="w-full h-full object-cover group-hover:scale-125 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-komdigi-dark/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition duration-500 translate-y-2 group-hover:translate-y-0">
                        <p class="text-white text-xs font-bold truncate">Dokumentasi 4</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-r from-komdigi-dark via-komdigi-blue to-komdigi-cerulean"></div>
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-komdigi-gold/30 rounded-full blur-3xl"></div>
                </div>
                <div class="relative px-8 py-12 md:px-14 md:py-14 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-black text-white mb-2">Siap mencatat kegiatan hari ini?</h3>
                        <p class="text-blue-100 text-base max-w-md">Isi logbook dan absensi secara rutin agar perjalanan magangmu terdokumentasi dengan baik.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="#" class="btn-shine inline-flex items-center gap-2 px-7 py-3.5 bg-white text-komdigi-blue font-bold rounded-full hover:shadow-xl transition shadow-lg text-sm">
                            Isi Logbook
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="inline-flex items-center px-7 py-3.5 bg-white/15 text-white font-bold rounded-full border border-white/40 hover:bg-white/25 transition text-sm">
                            Absensi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gradient-to-br from-[#001a3d] via-komdigi-dark to-[#002a5c] text-white pt-16 pb-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-komdigi-blue/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-komdigi-cerulean/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-2xl blur opacity-50"></div>
                            <div class="relative w-12 h-12 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg">
                                K
                            </div>
                        </div>
                        <div>
                            <div class="font-extrabold text-white text-lg">Magang Komdigi 2026</div>
                            <div class="text-xs text-blue-200 font-medium">Kementerian Komunikasi dan Digital</div>
                        </div>
                    </div>
                    <p class="text-sm text-blue-100/90 leading-relaxed mb-5">
                        Dokumentasi kegiatan Magang Komdigi 2026 di lingkungan Kementerian Komunikasi dan Digital Republik Indonesia.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition border border-white/10">
                            <svg class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition border border-white/10">
                            <svg class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <h4 class="font-extrabold text-white mb-4 text-lg flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-komdigi-blue to-komdigi-gold rounded-full"></span>
                        Lokasi
                    </h4>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/15 shadow-xl">
                        <div class="relative w-full h-48 sm:h-52">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3784.914568404523!2d98.68025207473231!3d3.601784996372325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031319355b82e2b%3A0x286733de8de3d062!2sDinas%20Kominfo%20Provinsi%20Sumut!5e1!3m2!1sid!2sid!4v1793695785419!5m2!1sid!2sid"
                                class="absolute inset-0 w-full h-full border-0"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="p-5">
                            <p class="text-sm text-blue-100 mb-4 leading-relaxed">
                                Jl. HM. Said No.27, Gaharu, Kec. Medan Tim., Kota Medan, Sumatera Utara 20233
                            </p>
                            
                            <a href="https://maps.app.goo.gl/1PyiR9wqdNK6gq6b9" 
                               target="_blank"
                               class="btn-shine inline-flex items-center gap-2 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean hover:from-komdigi-cerulean hover:to-indigo-500 px-5 py-2.5 rounded-full transition shadow-lg shadow-blue-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-blue-200/90">© 2026 Magang Komdigi. All rights reserved.</p>
                <p class="text-xs text-blue-300/80">Dibuat dengan ❤️ untuk Magang Komdigi</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/countdown.js') }}"></script>
</body>
</html>
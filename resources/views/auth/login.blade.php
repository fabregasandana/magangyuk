<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Magang Komdigi 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @fonts
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body class="min-h-screen font-sans text-gray-800 antialiased">

    <div class="min-h-screen hero-gradient relative overflow-hidden flex items-center justify-center p-4 sm:p-6">

        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[420px] h-[420px] bg-komdigi-blue/25 rounded-full blur-3xl blob"></div>
        <div class="absolute bottom-0 left-0 w-[380px] h-[380px] bg-komdigi-cerulean/30 rounded-full blur-3xl blob" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-72 h-72 bg-komdigi-gold/20 rounded-full blur-3xl blob" style="animation-delay: -5s;"></div>
        <div class="absolute bottom-20 right-1/4 w-56 h-56 bg-pink-400/20 rounded-full blur-3xl"></div>

        <div class="absolute top-24 right-24 w-3 h-3 bg-komdigi-blue rounded-full opacity-50"></div>
        <div class="absolute top-40 right-40 w-2 h-2 bg-komdigi-gold rounded-full opacity-60"></div>
        <div class="absolute bottom-32 left-20 w-4 h-4 bg-pink-400 rounded-full opacity-40"></div>

        <div class="relative z-10 w-full max-w-md">

            <!-- Logo / Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-komdigi-blue to-komdigi-cerulean rounded-2xl blur opacity-50"></div>
                        <div class="relative w-14 h-14 bg-gradient-to-br from-komdigi-blue via-komdigi-cerulean to-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-blue-500/30">
                            K
                        </div>
                    </div>
                </div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Magang Komdigi</h1>
                <p class="text-sm font-semibold text-komdigi-cerulean mt-1">2026 &bull; Kementerian Komunikasi dan Digital</p>
            </div>

            <!-- Login Card -->
            <div class="relative float-anim">
                <div class="absolute -inset-1.5 bg-gradient-to-r from-komdigi-blue via-komdigi-cerulean to-komdigi-gold rounded-[28px] blur-md opacity-40"></div>

                <div class="relative glass-strong rounded-[26px] shadow-2xl border border-white/70 p-7 sm:p-8">

                    <div class="text-center mb-7">
                        <h2 class="text-xl font-extrabold text-gray-900">Selamat Datang &#128075;</h2>
                        <p class="text-sm text-gray-500 mt-1.5">Masuk untuk mengakses logbook &amp; absensi</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="username"
                                    class="input-focus w-full pl-11 pr-4 py-3 bg-white border-2 border-gray-200 rounded-2xl text-sm font-medium text-gray-800 placeholder-gray-400 outline-none transition-all duration-200"
                                    required
                                >
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs font-semibold text-komdigi-red">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                    autocomplete="current-password"
                                    class="input-focus w-full pl-11 pr-12 py-3 bg-white border-2 border-gray-200 rounded-2xl text-sm font-medium text-gray-800 placeholder-gray-400 outline-none transition-all duration-200"
                                    required
                                >
                                <button
                                    type="button"
                                    data-action="toggle-password"
                                    data-target="password"
                                    aria-pressed="false"
                                    aria-label="Tampilkan password"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-komdigi-blue transition"
                                >
                                    <svg data-icon="eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg data-icon="eye-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-semibold text-komdigi-red">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-komdigi-blue focus:ring-komdigi-blue/30 accent-[#0055FF]">
                                <span class="text-sm font-medium text-gray-600">Ingat saya</span>
                            </label>
                            <span class="text-sm font-semibold text-gray-400 cursor-not-allowed" title="Fitur belum tersedia">Lupa password?</span>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-blue via-komdigi-cerulean to-indigo-500 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 text-[15px]"
                        >
                            Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-xs font-medium text-gray-400">atau</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Back to Home -->
                    <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-2xl hover:border-komdigi-blue hover:text-komdigi-blue transition-all duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <p class="text-center text-xs text-gray-500 mt-8">
                &copy; 2026 Magang Komdigi. All rights reserved.
            </p>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke ruang Magang Komdigi untuk mengakses logbook, absensi, dan perkembangan magang sesuai peran akun Anda.">
    <title>Login | Magang Komdigi 2026</title>
    @include('layouts.theme-init')
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body class="login-page">
    <a href="#login-form" class="login-skip-link">Lewati ke formulir masuk</a>
    <div class="login-shell">
        {{-- Panel kiri: formulir masuk (gaya WeStud: bersih, field pill, CTA gradient) --}}
        <main class="login-main">
            <header class="login-main-header">
                <a href="{{ url('/') }}" class="login-brand" aria-label="Magang Komdigi — Beranda">
                    <span class="login-brand-mark" aria-hidden="true">K<span></span></span>
                    <span>Magang Komdigi<small>Kementerian Komunikasi dan Digital</small></span>
                </a>
                <div class="login-header-actions">
                    <a href="{{ url('/') }}" class="login-back-link"><i data-lucide="arrow-left" class="w-5 h-5" aria-hidden="true"></i> Beranda</a>
                    @include('layouts.theme-toggle')
                </div>
            </header>

            <div class="login-form-region">
                <div class="login-form-shell">
                    <p class="login-form-eyebrow">Program Magang 2026</p>
                    <h1 data-split-text>Selamat datang<br>kembali.</h1>
                    <p class="login-form-description">Masuk untuk melanjutkan perjalanan magangmu. Kelola absensi, logbook, dan ulasan pembimbing dalam satu ruang.</p>

                    <form action="{{ route('login') }}" method="POST" id="login-form" class="login-form" data-anime-stagger>
                        @csrf
                        <div class="login-field">
                            <label for="email">Alamat email</label>
                            <div class="login-input-wrap">
                                <span class="login-input-icon"><i data-lucide="mail" class="w-5 h-5" aria-hidden="true"></i></span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="username"
                                    inputmode="email"
                                    autocapitalize="none"
                                    spellcheck="false"
                                    class="form-input login-input"
                                    @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                    required
                                >
                            </div>
                            @error('email')
                                <p id="email-error" class="login-field-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="login-field">
                            <div class="login-label-row">
                                <label for="password">Password</label>
                            </div>
                            <div class="login-input-wrap">
                                <span class="login-input-icon"><i data-lucide="lock-keyhole" class="w-5 h-5" aria-hidden="true"></i></span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    class="form-input login-input login-password-input"
                                    @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                                    required
                                >
                                <button
                                    type="button"
                                    data-action="toggle-password"
                                    data-target="password"
                                    aria-controls="password"
                                    aria-pressed="false"
                                    aria-label="Tampilkan password"
                                    class="ui-icon-button login-password-toggle"
                                >
                                    <span data-icon="eye"><i data-lucide="eye" class="w-5 h-5" aria-hidden="true"></i></span>
                                    <span data-icon="eye-off" hidden><i data-lucide="eye-off" class="w-5 h-5" aria-hidden="true"></i></span>
                                </button>
                            </div>
                            @error('password')
                                <p id="password-error" class="login-field-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="login-form-options">
                            <label class="login-remember" for="remember">
                                <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                                <span>Ingat saya</span>
                            </label>
                            <p class="login-password-help">Lupa password? Hubungi admin program.</p>
                        </div>

                        <button type="submit" class="ui-button login-submit">
                            <span class="login-spinner" aria-hidden="true"></span>
                            <span>Masuk</span>
                            <i data-lucide="arrow-right" class="w-5 h-5 login-submit-icon" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div class="login-account-note"><i data-lucide="shield-check" class="w-5 h-5" aria-hidden="true"></i><p><strong>Akses khusus anggota program</strong>Gunakan akun yang diberikan admin.</p></div>
                </div>
            </div>

            <footer class="login-main-footer">&copy; 2026 Magang Komdigi. All rights reserved.</footer>
        </main>

        {{-- Panel kanan: story brand berilahiran + bentuk mengambang (gaya ilustrasi WeStud) --}}
        <aside class="login-story" aria-labelledby="story-title">
            <div class="login-story-art" aria-hidden="true">
                <span class="login-arc login-arc-1"></span>
                <span class="login-arc login-arc-2"></span>
                <span class="login-dot-grid"></span>
                <span class="login-chip-float chip-mail"><i data-lucide="mail" class="w-5 h-5"></i></span>
                <span class="login-chip-float chip-cap"><i data-lucide="graduation-cap" class="w-5 h-5"></i></span>
                <span class="login-chip-float chip-spark"><i data-lucide="sparkles" class="w-5 h-5"></i></span>
                <span class="login-story-rings"></span>
            </div>

            <div class="login-story-content">
                <p class="login-eyebrow">Ruang Magang Komdigi</p>
                <h2 id="story-title" data-split-text>Tempat belajar.<br>Ruang berkarya.<br><span>Langkah bersama.</span></h2>
                <p class="login-story-description">Setiap pengalaman membentuk perjalananmu — tetap terhubung dengan pembimbing, rekam proses, dan tumbuh bersama.</p>

                <div class="login-story-workflow" data-anime-stagger>
                    <div><span><i data-lucide="calendar-check" class="w-5 h-5" aria-hidden="true"></i></span><p><strong>Mulai dengan kehadiran</strong><small>Catat absensi dan bangun kebiasaan baik.</small></p></div>
                    <div><span><i data-lucide="notebook-pen" class="w-5 h-5" aria-hidden="true"></i></span><p><strong>Rekam proses belajarmu</strong><small>Dokumentasikan kegiatan melalui logbook.</small></p></div>
                    <div><span><i data-lucide="message-square" class="w-5 h-5" aria-hidden="true"></i></span><p><strong>Berkembang lewat arahan</strong><small>Ikuti evaluasi dan ulasan pembimbing.</small></p></div>
                </div>

                <div class="login-story-quote">
                    <i data-lucide="quote" class="w-5 h-5" aria-hidden="true"></i>
                    <p>Belajar hari ini. Berkontribusi untuk esok.</p>
                </div>
            </div>

            <div class="login-story-footer">
                <span class="login-story-year">MMXXVI</span>
                <span class="login-story-tag">Komdigi</span>
            </div>
        </aside>
    </div>
</body>
</html>

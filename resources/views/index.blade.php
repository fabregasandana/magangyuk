<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pusat informasi, kegiatan, dan dokumentasi Magang Komdigi 2026. Pantau perjalanan magang melalui logbook dan absensi dalam satu tempat.">
    <title>Magang Komdigi 2026 | Kementerian Komunikasi dan Digital</title>
    @include('layouts.theme-init')
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="landing-page">
    <a class="landing-skip-link" href="#konten-utama">Lewati ke konten utama</a>

    <header class="landing-header">
        <div class="landing-container landing-header-inner">
            <a href="{{ url('/') }}" class="landing-brand" aria-label="Magang Komdigi — Beranda">
                <span class="landing-brand-mark" aria-hidden="true">K<span></span></span>
                <span class="landing-brand-text">Magang Komdigi<small>Program magang 2026</small></span>
            </a>

            <nav class="landing-desktop-nav" aria-label="Navigasi utama">
                <a href="{{ url('/') }}" aria-current="page">Beranda</a>
                <a href="#tentang">Tentang</a>
                <a href="#profil">Profil</a>
                <a href="#kegiatan">Kegiatan</a>
                <a href="#anggota">Anggota</a>
                <a href="#dokumentasi">Dokumentasi</a>
            </nav>

            <div class="landing-header-actions">
                @include('layouts.theme-toggle')
                <a href="{{ route('login') }}" class="ui-button landing-header-login">Masuk <i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></a>
                <details class="landing-mobile-nav">
                    <summary aria-label="Menu navigasi"><i data-lucide="menu" class="w-5 h-5" aria-hidden="true"></i></summary>
                    <nav aria-label="Navigasi seluler">
                        <a href="{{ url('/') }}" aria-current="page">Beranda</a>
                        <a href="#tentang">Tentang kami</a>
                        <a href="#profil">Profil program</a>
                        <a href="#kegiatan">Kegiatan</a>
                        <a href="#anggota">Anggota</a>
                        <a href="#dokumentasi">Dokumentasi</a>
                        <a href="{{ route('admin.dashboard') }}">Portal admin</a>
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main id="konten-utama">
        <section class="landing-hero" aria-labelledby="hero-title">
            <div class="landing-visual" aria-hidden="true">
                <canvas data-webgl-bg></canvas>
            </div>
            <div class="landing-container landing-hero-grid">
                <div class="landing-hero-copy">
                    <p class="landing-eyebrow"><span></span> Belajar. Berkontribusi. Bertumbuh.</p>
                    <h1 id="hero-title" data-split-text>Langkah kecil hari ini.<br><span>Kontribusi nyata</span><br>untuk esok.</h1>
                    <p class="landing-hero-description">Ruang untuk belajar, berkarya, dan mencatat perjalanan Magang Komdigi. Dari kehadiran hingga hasil kerja, setiap proses punya tempatnya.</p>
                    <div class="landing-hero-actions">
                        <a href="{{ route('login') }}" class="ui-button">Masuk ke ruang magang <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i></a>
                        <a href="#kegiatan" class="ui-button ui-button-secondary">Jelajahi kegiatan</a>
                    </div>
                    <a href="#dokumentasi" class="landing-text-link landing-hero-gallery">Lihat cerita dalam dokumentasi <i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></a>
                    <div class="landing-hero-signature">
                        <i data-lucide="building-2" class="w-5 h-5" aria-hidden="true"></i>
                        <span>Kementerian Komunikasi dan Digital<small>Program Magang 2026</small></span>
                    </div>
                </div>

                <figure class="landing-preview glass-card" data-parallax="0.05" aria-labelledby="preview-title" aria-describedby="preview-caption">
                    <div class="landing-preview-toolbar">
                        <span><i data-lucide="layout-dashboard" class="w-5 h-5" aria-hidden="true"></i> Ruang magang</span>
                        <span class="landing-preview-label">Pratinjau</span>
                    </div>
                    <div class="landing-preview-body">
                        <p class="landing-eyebrow">Alur harian peserta</p>
                        <h2 id="preview-title">Satu hari, tercatat rapi.</h2>
                        <p class="landing-preview-intro">Fokus berkarya. Dokumentasikan prosesnya.</p>
                        <ol class="landing-workflow" data-anime-stagger>
                            <li>
                                <span class="landing-workflow-icon" data-anime-draw><i data-lucide="calendar-check" class="w-5 h-5" aria-hidden="true"></i></span>
                                <div><h3>Mulai dengan absensi</h3><p>Catat kehadiran sebelum beraktivitas.</p></div>
                                <span class="landing-step-number">01</span>
                            </li>
                            <li>
                                <span class="landing-workflow-icon" data-anime-draw><i data-lucide="notebook-pen" class="w-5 h-5" aria-hidden="true"></i></span>
                                <div><h3>Ceritakan progresmu</h3><p>Tulis kegiatan dan hasil kerja di logbook.</p></div>
                                <span class="landing-step-number">02</span>
                            </li>
                            <li>
                                <span class="landing-workflow-icon" data-anime-draw><i data-lucide="message-square" class="w-5 h-5" aria-hidden="true"></i></span>
                                <div><h3>Bertumbuh lewat ulasan</h3><p>Ikuti tinjauan dan arahan pembimbing.</p></div>
                                <span class="landing-step-number">03</span>
                            </li>
                        </ol>
                        <div class="landing-preview-note"><i data-lucide="file-check-2" class="w-5 h-5" aria-hidden="true"></i><span>Kehadiran, kegiatan, dan evaluasi.<strong>Terhubung dalam satu perjalanan.</strong></span></div>
                    </div>
                    <figcaption id="preview-caption">Ilustrasi alur penggunaan, bukan data peserta.</figcaption>
                </figure>
            </div>
        </section>

        <section class="landing-period" aria-labelledby="period-title">
            <div class="landing-container landing-period-inner">
                <div class="landing-period-heading">
                    <span class="landing-icon-tile"><i data-lucide="calendar-days" class="w-5 h-5" aria-hidden="true"></i></span>
                    <div><p class="landing-eyebrow">Periode magang</p><h2 id="period-title">1 Oktober – 19 Desember 2026</h2><p id="period-status" aria-live="polite">Program Magang Komdigi 2026</p></div>
                </div>
                <div class="landing-countdown-block">
                    <p id="countdown-label">Menuju akhir periode</p>
                    <div class="landing-countdown" role="timer" aria-label="Waktu tersisa hingga akhir periode magang">
                        <div><strong id="days">—</strong><span>Hari</span></div>
                        <div><strong id="hours">—</strong><span>Jam</span></div>
                        <div><strong id="minutes">—</strong><span>Menit</span></div>
                        <div><strong id="seconds">—</strong><span>Detik</span></div>
                    </div>
                </div>
                <div class="landing-period-progress">
                    <div><span>Perjalanan periode</span><strong id="progress-text">—</strong></div>
                    <div class="landing-progress-track" role="progressbar" aria-label="Progres periode magang" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="period-progress"><span id="progress-bar"></span></div>
                    <small>Berakhir 19 Desember 2026, WIB</small>
                </div>
            </div>
        </section>

        <section id="tentang" class="landing-section" aria-labelledby="about-title">
            <div class="landing-container">
                <div class="landing-about-heading" data-reveal>
                    <div><p class="landing-eyebrow">Tentang program</p><h2 id="about-title">Pengalaman nyata.<br>Pembelajaran yang bermakna.</h2></div>
                    <p>Magang bukan hanya tentang menyelesaikan tugas. Ini adalah kesempatan mengenal dunia kerja, berkolaborasi, dan melihat kontribusimu berkembang dari hari ke hari.</p>
                </div>
                <div class="landing-feature-grid">
                    <article class="landing-feature" id="profil">
                        <span class="landing-icon-tile"><i data-lucide="building-2" class="w-5 h-5" aria-hidden="true"></i></span>
                        <p class="landing-feature-index">01 / Profil program</p>
                        <h3>Belajar di lingkungan kerja nyata</h3>
                        <p>Kenali kegiatan Magang Komdigi 2026 melalui informasi dan cerita yang dipublikasikan di portal ini.</p>
                        <a href="#kegiatan" class="landing-text-link">Kenali kegiatan kami <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i></a>
                    </article>
                    <article class="landing-feature" id="anggota">
                        <span class="landing-icon-tile"><i data-lucide="users" class="w-5 h-5" aria-hidden="true"></i></span>
                        <p class="landing-feature-index">02 / Anggota &amp; pembimbing</p>
                        <h3>Berkembang bersama tim</h3>
                        <p>Peserta mencatat proses belajar, pembimbing memberikan arahan, dan admin mendukung pengelolaan program.</p>
                        <a href="{{ route('login') }}" class="landing-text-link">Akses ruang anggota <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i></a>
                    </article>
                    <article class="landing-feature">
                        <span class="landing-icon-tile"><i data-lucide="images" class="w-5 h-5" aria-hidden="true"></i></span>
                        <p class="landing-feature-index">03 / Jejak perjalanan</p>
                        <h3>Setiap proses layak dicatat</h3>
                        <p>Temukan dokumentasi kegiatan sebagai bagian dari cerita belajar dan kolaborasi selama masa magang.</p>
                        <a href="#dokumentasi" class="landing-text-link">Jelajahi dokumentasi <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i></a>
                    </article>
                </div>
            </div>
        </section>

        <section id="kegiatan" class="landing-section landing-section-surface" aria-labelledby="activities-title">
            <div class="landing-container">
                <div class="landing-section-heading" data-reveal>
                    <div><p class="landing-eyebrow">Dari ruang magang</p><h2 id="activities-title">Kegiatan terbaru</h2></div>
                    <p>Catatan aktivitas, kolaborasi, dan pengalaman<br class="landing-desktop-break"> yang membentuk perjalanan kami.</p>
                </div>
                <div class="landing-activity-grid">
                    @forelse ($kegiatans as $kegiatan)
                        <article class="landing-activity-card">
                            <div class="landing-activity-image">
                                <img src="{{ $kegiatan['img'] }}" alt="{{ $kegiatan['judul'] }}" loading="lazy" decoding="async" width="600" height="400">
                                <span class="landing-date-badge">{{ $kegiatan['badge'] }}</span>
                            </div>
                            <div class="landing-activity-body">
                                <span class="landing-category {{ $kegiatan['kategoriClass'] }}">{{ $kegiatan['kategori'] }}</span>
                                <h3>{{ $kegiatan['judul'] }}</h3>
                                <div class="landing-author"><span class="landing-avatar {{ $kegiatan['avatarClass'] }}" aria-hidden="true">{{ $kegiatan['inisial'] }}</span><span>{{ $kegiatan['penulis'] }}</span></div>
                            </div>
                        </article>
                    @empty
                        <div class="landing-empty-state"><i data-lucide="notebook-pen" class="w-5 h-5" aria-hidden="true"></i><h3>Belum ada kegiatan dipublikasikan</h3><p>Catatan perjalanan magang akan hadir di sini.</p></div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="dokumentasi" class="landing-section" aria-labelledby="gallery-title">
            <div class="landing-container">
                <div class="landing-section-heading" data-reveal>
                    <div><p class="landing-eyebrow">Galeri perjalanan</p><h2 id="gallery-title">Momen yang bercerita.</h2></div>
                    <p>Potret kegiatan dan kebersamaan.<br class="landing-desktop-break"> Pilih foto untuk melihat ukuran penuh.</p>
                </div>
                <div class="landing-gallery-grid">
                    @forelse ($dokumentasis as $dokumentasi)
                        <figure class="landing-gallery-card {{ $dokumentasi['ringClass'] }}">
                            <a href="{{ asset($dokumentasi['img']) }}" target="_blank" rel="noopener noreferrer" aria-label="Lihat {{ $dokumentasi['judul'] }} dalam ukuran penuh (tab baru)">
                                <img src="{{ asset($dokumentasi['img']) }}" alt="{{ $dokumentasi['judul'] }}" loading="lazy" decoding="async" width="600" height="450">
                                <span class="landing-gallery-open"><i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></span>
                            </a>
                            <figcaption>{{ $dokumentasi['judul'] }}</figcaption>
                        </figure>
                    @empty
                        <div class="landing-empty-state"><i data-lucide="images" class="w-5 h-5" aria-hidden="true"></i><h3>Dokumentasi segera hadir</h3><p>Momen kegiatan yang dipublikasikan akan tampil di sini.</p></div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="landing-cta-section" aria-labelledby="cta-title">
            <div class="landing-container">
                <div class="landing-cta" data-reveal>
                    <canvas data-canvas-ripple aria-hidden="true"></canvas>
                    <div><p class="landing-eyebrow">Jadikan setiap hari berarti</p><h2 id="cta-title">Sudah mencatat<br>kegiatan hari ini?</h2><p>Isi logbook dan absensi secara rutin.<br>Bangun rekam jejak yang bisa kamu banggakan.</p></div>
                    <div class="landing-cta-actions">
                        <a href="{{ route('login') }}" class="ui-button landing-cta-primary">Buka logbook <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i></a>
                        <a href="{{ route('peserta.absensi') }}" class="ui-button ui-button-secondary landing-cta-secondary"><i data-lucide="calendar-check" class="w-5 h-5" aria-hidden="true"></i> Absensi sekarang</a>
                        <span>Akses sesuai peran akun yang diberikan admin.</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="landing-container">
            <div class="landing-footer-grid">
                <div class="landing-footer-brand">
                    <a href="{{ url('/') }}" class="landing-brand"><span class="landing-brand-mark" aria-hidden="true">K<span></span></span><span class="landing-brand-text">Magang Komdigi<small>Kementerian Komunikasi dan Digital</small></span></a>
                    <p>Ruang informasi dan dokumentasi perjalanan Magang Komdigi 2026 di lingkungan Kementerian Komunikasi dan Digital Republik Indonesia.</p>
                    <div class="landing-social-links">
                        <a href="https://x.com/kemkomdigi" target="_blank" rel="noopener noreferrer" aria-label="X Kementerian Komdigi (tab baru)">X <i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com/kementeriankomdigi/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Kementerian Komdigi (tab baru)">Instagram <i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></a>
                    </div>
                </div>
                <nav class="landing-footer-nav" aria-label="Tautan footer">
                    <h2>Jelajahi</h2>
                    <a href="#tentang">Tentang kami</a>
                    <a href="#profil">Profil program</a>
                    <a href="#anggota">Anggota</a>
                    <a href="#kegiatan">Kegiatan</a>
                    <a href="#dokumentasi">Dokumentasi</a>
                    <a href="{{ route('admin.dashboard') }}">Portal admin</a>
                </nav>
                <div class="landing-footer-location">
                    <h2>Temukan kami</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3784.914568404523!2d98.68025207473231!3d3.601784996372325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031319355b82e2b%3A0x286733de8de3d062!2sDinas%20Kominfo%20Provinsi%20Sumut!5e1!3m2!1sid!2sid!4v1793695785419!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi Dinas Kominfo Provinsi Sumatera Utara"></iframe>
                    <p>Jl. HM. Said No.27, Gaharu, Kec. Medan Tim., Kota Medan, Sumatera Utara 20233</p>
                    <a href="https://maps.app.goo.gl/1PyiR9wqdNK6gq6b9" target="_blank" rel="noopener noreferrer" class="landing-text-link"><i data-lucide="map-pin" class="w-5 h-5" aria-hidden="true"></i> Buka di Google Maps <i data-lucide="arrow-up-right" class="w-5 h-5" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="landing-footer-bottom"><p>&copy; 2026 Magang Komdigi. All rights reserved.</p><span>Belajar hari ini. Berkontribusi untuk esok.</span></div>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="id" class="landing-document" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pusat informasi, kegiatan, dan dokumentasi Magang Komdigi 2026. Pantau perjalanan magang melalui logbook dan absensi dalam satu tempat.">
    <title>MagangYuk | Kementerian Komunikasi dan Digital</title>
    @include('layouts.theme-init')
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="landing-page">
    <a class="landing-skip-link" href="#konten-utama">Lewati ke konten utama</a>

    <div class="landing-stage">
        <div class="landing-shell">
            <header class="landing-header" data-landing-header>
                <div class="landing-container landing-header-inner">
                    <a href="{{ url('/') }}" class="landing-brand" aria-label="Magang Komdigi — Beranda">
                        <span class="landing-brand-mark" aria-hidden="true">K<span></span></span>
                        <span class="landing-brand-text">MagangYuk<small>Program magang 2026</small></span>
                    </a>

                    <nav class="landing-desktop-nav" aria-label="Navigasi utama">
                        <a href="#konten-utama" aria-current="page">Beranda</a>
                        <a href="#tentang">Tentang</a>
                        <a href="#alur">Alur</a>
                        <a href="#kegiatan">Kegiatan</a>
                        <a href="#dokumentasi">Dokumentasi</a>
                    </nav>

                    <div class="landing-header-actions">
                        @include('layouts.theme-toggle')
                        <a href="{{ route('login') }}" class="landing-login-pill">Masuk <i data-lucide="arrow-up-right" class="w-4 h-4" aria-hidden="true"></i></a>
                        <details class="landing-mobile-nav">
                            <summary aria-label="Menu navigasi"><i data-lucide="menu" class="w-5 h-5" aria-hidden="true"></i></summary>
                            <nav aria-label="Navigasi seluler">
                                <a href="#konten-utama" aria-current="page">Beranda</a>
                                <a href="#tentang">Tentang program</a>
                                <a href="#alur">Alur magang</a>
                                <a href="#kegiatan">Kegiatan</a>
                                <a href="#dokumentasi">Dokumentasi</a>
                                <a href="{{ route('login') }}">Masuk ruang magang</a>
                                <a href="{{ route('admin.dashboard') }}">Portal admin</a>
                            </nav>
                        </details>
                    </div>
                </div>
            </header>

            <main id="konten-utama">
                <section class="landing-hero" aria-labelledby="hero-title">
                    <div class="landing-hero-visual" aria-hidden="true">
                        <span class="landing-aura landing-aura-one"></span>
                        <span class="landing-aura landing-aura-two"></span>
                        <span class="landing-aura landing-aura-three"></span>
                    </div>

                    <div class="landing-container">
                        <div class="landing-hero-copy">
                            <a href="#tentang" class="landing-announce" data-intro>
                                <span class="landing-announce-dot" aria-hidden="true"></span>
                                <span>Program Magang Komdigi 2026</span>
                                <span class="landing-announce-arrow" aria-hidden="true"><i data-lucide="arrow-down" class="w-3.5 h-3.5"></i></span>
                            </a>

                            <h1 id="hero-title" data-split-text>Belajar hari ini.<br><span>Berkontribusi</span> untuk esok.</h1>

                            <p class="landing-hero-description" data-intro>Ruang untuk mencatat perjalanan magang—dari absensi, logbook, bimbingan, hingga penilaian. Setiap proses punya tempatnya, setiap langkah terlihat.</p>

                            <div class="landing-hero-actions" data-intro>
                                <a href="{{ route('login') }}" class="landing-pill landing-pill-primary">
                                    Masuk ke ruang magang
                                    <span class="landing-pill-icon" aria-hidden="true"><i data-lucide="arrow-right" class="w-4 h-4"></i></span>
                                </a>
                                <a href="#kegiatan" class="landing-pill landing-pill-secondary">
                                    <i data-lucide="sparkles" class="w-4 h-4" aria-hidden="true"></i>
                                    Jelajahi kegiatan
                                </a>
                            </div>

                            <ul class="landing-role-chips" data-anime-stagger aria-label="Peran pengguna di ruang magang">
                                <li><i data-lucide="user-round" class="w-4 h-4" aria-hidden="true"></i> Peserta</li>
                                <li><i data-lucide="user-round-check" class="w-4 h-4" aria-hidden="true"></i> Pembimbing</li>
                                <li><i data-lucide="shield-check" class="w-4 h-4" aria-hidden="true"></i> Admin</li>
                            </ul>
                        </div>

                        <div class="landing-preview-stage" data-parallax="0.035">
                            <div class="landing-float-chip landing-float-chip-left" aria-hidden="true">
                                <span class="landing-float-icon"><i data-lucide="circle-check" class="w-4 h-4"></i></span>
                                <span><strong>Absensi tercatat</strong><small>08.01 WIB · Tepat waktu</small></span>
                            </div>
                            <div class="landing-float-chip landing-float-chip-right" aria-hidden="true">
                                <span class="landing-float-icon"><i data-lucide="notebook-pen" class="w-4 h-4"></i></span>
                                <span><strong>Logbook disetujui</strong><small>Ulasan pembimbing hari ini</small></span>
                            </div>

                            <div class="landing-device">
                                <div class="landing-app" role="img" aria-label="Pratinjau ruang magang berisi ringkasan kehadiran, logbook, progres, dan penilaian peserta. Bukan data peserta sebenarnya.">
                                    <aside class="landing-app-sidebar" aria-hidden="true">
                                        <div class="landing-app-brand"><span>K</span> MagangYuk</div>
                                        <nav class="landing-app-nav">
                                            <span class="is-active"><i data-lucide="layout-dashboard" class="w-4 h-4"></i> Ringkasan</span>
                                            <span><i data-lucide="calendar-check" class="w-4 h-4"></i> Absensi</span>
                                            <span><i data-lucide="notebook-pen" class="w-4 h-4"></i> Logbook</span>
                                            <span><i data-lucide="file-text" class="w-4 h-4"></i> Laporan</span>
                                            <span><i data-lucide="chart-no-axes-combined" class="w-4 h-4"></i> Penilaian</span>
                                        </nav>
                                        <div class="landing-app-user">
                                            <span class="landing-app-avatar">RP</span>
                                            <span><strong>Rani Putri</strong><small>Peserta magang</small></span>
                                        </div>
                                    </aside>

                                    <div class="landing-app-main" aria-hidden="true">
                                        <div class="landing-app-topbar">
                                            <div>
                                                <p class="landing-app-kicker">Selasa, 18 November 2026</p>
                                                <h2>Selamat pagi, Rani.</h2>
                                            </div>
                                            <span class="landing-app-button"><i data-lucide="plus" class="w-3.5 h-3.5"></i> Isi logbook</span>
                                        </div>

                                        <div class="landing-app-stats">
                                            <div class="landing-app-stat">
                                                <span>Kehadiran</span>
                                                <strong><b data-counter="98">98</b>%</strong>
                                                <small><i data-lucide="trending-up" class="w-3 h-3"></i> Tepat waktu</small>
                                            </div>
                                            <div class="landing-app-stat">
                                                <span>Logbook</span>
                                                <strong><b data-counter="24">24</b></strong>
                                                <small><i data-lucide="circle-check" class="w-3 h-3"></i> Semua terisi</small>
                                            </div>
                                            <div class="landing-app-stat">
                                                <span>Nilai akhir</span>
                                                <strong><b data-counter="92">92</b></strong>
                                                <small><i data-lucide="star" class="w-3 h-3"></i> Sangat baik</small>
                                            </div>
                                        </div>

                                        <div class="landing-app-panels">
                                            <div class="landing-app-card landing-app-chart">
                                                <div class="landing-app-card-head"><strong>Aktivitas mingguan</strong><span>7 hari terakhir</span></div>
                                                <div class="landing-bars" data-bars>
                                                    <div class="landing-bar" style="--bar: 46%"><span></span><small>Sen</small></div>
                                                    <div class="landing-bar" style="--bar: 68%"><span></span><small>Sel</small></div>
                                                    <div class="landing-bar" style="--bar: 54%"><span></span><small>Rab</small></div>
                                                    <div class="landing-bar" style="--bar: 88%"><span></span><small>Kam</small></div>
                                                    <div class="landing-bar" style="--bar: 72%"><span></span><small>Jum</small></div>
                                                    <div class="landing-bar" style="--bar: 34%"><span></span><small>Sab</small></div>
                                                    <div class="landing-bar is-muted" style="--bar: 18%"><span></span><small>Min</small></div>
                                                </div>
                                            </div>

                                            <div class="landing-app-card landing-app-ring-card">
                                                <div class="landing-app-card-head"><strong>Progres magang</strong></div>
                                                <div class="landing-ring-wrap">
                                                    <svg viewBox="0 0 120 120" aria-hidden="true">
                                                        <circle class="landing-ring-track" cx="60" cy="60" r="48" pathLength="100"></circle>
                                                        <circle class="landing-ring-value" data-ring cx="60" cy="60" r="48" pathLength="100" stroke-dasharray="78 100"></circle>
                                                    </svg>
                                                    <span><strong>78%</strong><small>periode</small></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="landing-app-note">
                                            <span class="landing-app-note-icon"><i data-lucide="message-square" class="w-4 h-4"></i></span>
                                            <span><strong>Ulasan baru dari pembimbing</strong><small>Logbook “Riset konten dashboard” sudah ditinjau.</small></span>
                                            <span class="landing-app-note-tag">Hari ini</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="landing-preview-caption" data-landing-reveal>Pratinjau antarmuka ruang magang, bukan data peserta sebenarnya.</p>
                    </div>
                </section>

                <div class="landing-marquee" aria-hidden="true">
                    <div class="landing-marquee-track">
                        <div class="landing-marquee-group">
                            <span>Absensi</span><i></i><span>Logbook</span><i></i><span>Bimbingan</span><i></i><span>Penilaian</span><i></i><span>Dokumentasi</span><i></i><span>Sertifikat</span><i></i>
                        </div>
                        <div class="landing-marquee-group">
                            <span>Absensi</span><i></i><span>Logbook</span><i></i><span>Bimbingan</span><i></i><span>Penilaian</span><i></i><span>Dokumentasi</span><i></i><span>Sertifikat</span><i></i>
                        </div>
                    </div>
                </div>

                <section class="landing-period" aria-labelledby="period-title">
                    <div class="landing-container">
                        <div class="landing-period-card" data-landing-reveal>
                            <div class="landing-period-copy">
                                <span class="landing-period-eyebrow"><i data-lucide="calendar-days" class="w-4 h-4" aria-hidden="true"></i> Periode magang</span>
                                <h2 id="period-title">1 Oktober — 19 Desember 2026</h2>
                                <p id="period-status" aria-live="polite">Program Magang Komdigi 2026</p>
                                <small>Seluruh waktu menggunakan WIB.</small>
                            </div>

                            <div class="landing-period-data" data-anime-stagger>
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
                                    <div class="landing-period-progress-head"><span>Perjalanan periode</span><strong id="progress-text">—</strong></div>
                                    <div class="landing-progress-track" role="progressbar" aria-label="Progres periode magang" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="period-progress"><span id="progress-bar"></span></div>
                                    <small>Berakhir 19 Desember 2026, 23.59 WIB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="tentang" class="landing-section" aria-labelledby="about-title">
                    <div class="landing-container">
                        <div class="landing-section-heading" data-landing-reveal>
                            <div>
                                <span class="landing-kicker">Tentang program</span>
                                <h2 id="about-title">Satu ruang.<br>Tiga peran. Banyak cerita.</h2>
                            </div>
                            <p>Magang bukan hanya tentang menyelesaikan tugas. Ini ruang untuk mengenal dunia kerja, berkolaborasi, dan melihat kontribusimu tumbuh dari hari ke hari.</p>
                        </div>

                        <div class="landing-feature-grid" data-landing-stagger>
                            <article class="landing-feature" id="profil" data-spotlight data-tilt>
                                <div class="landing-feature-top">
                                    <span class="landing-feature-icon" data-anime-draw><i data-lucide="building-2" class="w-5 h-5" aria-hidden="true"></i></span>
                                    <span class="landing-feature-index">01 / Profil program</span>
                                </div>
                                <h3>Belajar di lingkungan kerja nyata</h3>
                                <p>Kenali kegiatan Magang Komdigi 2026 melalui informasi dan cerita yang dipublikasikan di portal ini.</p>
                                <a href="#kegiatan" class="landing-text-link">Kenali kegiatan kami <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i></a>

                                <div class="landing-feature-art" aria-hidden="true">
                                    <div class="landing-calendar" data-anime-stagger>
                                        <div class="landing-calendar-head"><span>Oktober 2026</span><strong>Hari ke-49</strong></div>
                                        <div class="landing-calendar-week"><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span><span>M</span></div>
                                        <div class="landing-calendar-days">
                                            <span class="is-muted">28</span><span class="is-muted">29</span><span class="is-muted">30</span><span>1</span><span>2</span><span>3</span><span>4</span>
                                            <span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span>
                                            <span>12</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span class="is-today">18</span>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <article class="landing-feature" id="anggota" data-spotlight data-tilt>
                                <div class="landing-feature-top">
                                    <span class="landing-feature-icon" data-anime-draw><i data-lucide="users" class="w-5 h-5" aria-hidden="true"></i></span>
                                    <span class="landing-feature-index">02 / Anggota &amp; pembimbing</span>
                                </div>
                                <h3>Berkembang bersama tim</h3>
                                <p>Peserta mencatat proses belajar, pembimbing memberi arahan, dan admin menjaga program tetap berjalan rapi.</p>
                                <a href="{{ route('login') }}" class="landing-text-link">Akses ruang anggota <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i></a>

                                <div class="landing-feature-art landing-team-art" aria-hidden="true">
                                    <div class="landing-team-avatars" data-anime-stagger>
                                        <span class="landing-team-avatar a1">RP</span>
                                        <span class="landing-team-avatar a2">AD</span>
                                        <span class="landing-team-avatar a3">MB</span>
                                        <span class="landing-team-avatar a4">KN</span>
                                        <span class="landing-team-plus">+2</span>
                                    </div>
                                    <div class="landing-team-tags"><span>Pembimbing</span><span>Peserta</span><span>Admin</span></div>
                                </div>
                            </article>

                            <article class="landing-feature" data-spotlight data-tilt>
                                <div class="landing-feature-top">
                                    <span class="landing-feature-icon" data-anime-draw><i data-lucide="images" class="w-5 h-5" aria-hidden="true"></i></span>
                                    <span class="landing-feature-index">03 / Jejak perjalanan</span>
                                </div>
                                <h3>Setiap proses layak dicatat</h3>
                                <p>Temukan dokumentasi kegiatan sebagai bagian dari cerita belajar dan kolaborasi selama masa magang.</p>
                                <a href="#dokumentasi" class="landing-text-link">Jelajahi dokumentasi <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i></a>

                                <div class="landing-feature-art landing-timeline-art" aria-hidden="true">
                                    <ul class="landing-mini-timeline" data-anime-stagger>
                                        <li><span class="landing-timeline-dot"></span><span><strong>Absensi</strong><small>08.01 WIB</small></span><em>Tercatat</em></li>
                                        <li><span class="landing-timeline-dot"></span><span><strong>Logbook</strong><small>16.30 WIB</small></span><em>Terisi</em></li>
                                        <li><span class="landing-timeline-dot"></span><span><strong>Ulasan</strong><small>Hari ini</small></span><em>Disetujui</em></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="alur" class="landing-section landing-flow-section" aria-labelledby="flow-title">
                    <div class="landing-container">
                        <div class="landing-flow-panel">
                            <div class="landing-section-heading landing-flow-heading" data-landing-reveal>
                                <div>
                                    <span class="landing-kicker">Alur magang</span>
                                    <h2 id="flow-title">Satu alur.<br>Empat tahap berarti.</h2>
                                </div>
                                <p>Dari pembekalan sampai sertifikat, setiap langkah punya ruangnya. Kartu-kartu ini bergerak mengikuti perjalananmu.</p>
                            </div>

                            <div class="landing-flow-stage" data-flow-stage>
                                <span class="landing-flow-orbit landing-flow-orbit-one" aria-hidden="true"></span>
                                <span class="landing-flow-orbit landing-flow-orbit-two" aria-hidden="true"></span>

                                <div class="landing-flow-center" aria-hidden="true" data-anime-stagger>
                                    <span class="landing-flow-logo">K<span></span></span>
                                    <strong>Empat tahap.</strong>
                                    <small>Satu perjalanan.</small>
                                </div>

                                <article class="landing-flow-card landing-flow-card-1" data-flow-card data-spotlight data-tilt>
                                    <div class="landing-flow-top">
                                        <span class="landing-flow-number">01</span>
                                        <span class="landing-flow-icon"><i data-lucide="graduation-cap" class="w-5 h-5" aria-hidden="true"></i></span>
                                    </div>
                                    <h3>Pembekalan</h3>
                                    <p>Orientasi program, aturan, dan target belajar sebelum terjun.</p>
                                    <div class="landing-flow-art flow-art-brief" aria-hidden="true" data-anime-stagger>
                                        <span><i></i>Orientasi</span>
                                        <span><i></i>Eksplorasi</span>
                                        <span><i></i>Evaluasi</span>
                                    </div>
                                </article>

                                <article class="landing-flow-card landing-flow-card-2" data-flow-card data-spotlight data-tilt>
                                    <div class="landing-flow-top">
                                        <span class="landing-flow-number">02</span>
                                        <span class="landing-flow-icon"><i data-lucide="calendar-check" class="w-5 h-5" aria-hidden="true"></i></span>
                                    </div>
                                    <h3>Aktivitas harian</h3>
                                    <p>Absensi dan logbook tercatat rapi setiap hari kerja.</p>
                                    <div class="landing-flow-art flow-art-attendance" aria-hidden="true" data-anime-stagger>
                                        <span class="flow-attendance-check"><i data-lucide="check" class="w-4 h-4"></i></span>
                                        <span><strong>08.01</strong><small>Tepat waktu</small></span>
                                        <em>Hadir</em>
                                    </div>
                                </article>

                                <article class="landing-flow-card landing-flow-card-3" data-flow-card data-spotlight data-tilt>
                                    <div class="landing-flow-top">
                                        <span class="landing-flow-number">03</span>
                                        <span class="landing-flow-icon"><i data-lucide="message-square" class="w-5 h-5" aria-hidden="true"></i></span>
                                    </div>
                                    <h3>Bimbingan</h3>
                                    <p>Pembimbing memberi arahan dan meninjau hasil kerjamu.</p>
                                    <div class="landing-flow-art flow-art-chat" aria-hidden="true" data-anime-stagger>
                                        <span class="flow-chat-avatar">MB</span>
                                        <span><strong>Logbook ditinjau</strong><small>“Struktur laporan sudah rapi.”</small></span>
                                    </div>
                                </article>

                                <article class="landing-flow-card landing-flow-card-4" data-flow-card data-spotlight data-tilt>
                                    <div class="landing-flow-top">
                                        <span class="landing-flow-number">04</span>
                                        <span class="landing-flow-icon"><i data-lucide="award" class="w-5 h-5" aria-hidden="true"></i></span>
                                    </div>
                                    <h3>Penilaian &amp; sertifikat</h3>
                                    <p>Rekam jejak lengkap, siap menjadi bekal langkah berikutnya.</p>
                                    <div class="landing-flow-art flow-art-score" aria-hidden="true" data-anime-stagger>
                                        <span class="flow-mini-ring">92</span>
                                        <span><strong>Sangat baik</strong><small>Rekap penilaian akhir</small></span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="kegiatan" class="landing-section landing-section-surface landing-activity-section" aria-labelledby="activities-title">
                    <div class="landing-container">
                        <div class="landing-section-heading" data-landing-reveal>
                            <div>
                                <span class="landing-kicker">Dari ruang magang</span>
                                <h2 id="activities-title">Kegiatan terbaru</h2>
                            </div>
                            <p>Catatan aktivitas, kolaborasi, dan pengalaman yang membentuk perjalanan kami.</p>
                        </div>

                        @php
                            $activityCount = count($kegiatans);
                            $activityColumns = $activityCount <= 1 ? [37] : ($activityCount === 2 ? [17, 51] : [3, 33, 63]);
                            $activitySlots = [
                                ['y' => 34, 'r' => -5],
                                ['y' => 0, 'r' => 3.4],
                                ['y' => 72, 'r' => -2.6],
                            ];
                            $activityRows = max(1, (int) ceil($activityCount / count($activityColumns)));
                        @endphp

                        <div class="landing-activity-deck" data-activity-stage style="--stage-rows: {{ $activityRows }}">
                            <span class="landing-activity-deck-glow" aria-hidden="true"></span>
                            @forelse ($kegiatans as $kegiatan)
                                @php
                                    $columnIndex = $loop->index % count($activityColumns);
                                    $slot = $activitySlots[$columnIndex];
                                    $rowIndex = intdiv($loop->index, count($activityColumns));
                                @endphp
                                <article
                                    class="landing-activity-card"
                                    data-activity-card
                                    data-spotlight
                                    style="--card-x: {{ $activityColumns[$columnIndex] }}%; --card-y: {{ $slot['y'] + ($rowIndex * 340) }}px; --card-r: {{ $slot['r'] }}deg;"
                                >
                                    <span class="landing-activity-tape" aria-hidden="true"></span>
                                    <div class="landing-activity-image">
                                        <img src="{{ $kegiatan['img'] }}" alt="{{ $kegiatan['judul'] }}" loading="lazy" decoding="async" width="600" height="400" draggable="false">
                                    </div>
                                    <div class="landing-activity-body">
                                        <div class="landing-activity-meta">
                                            <span class="landing-activity-category">{{ $kegiatan['kategori'] }}</span>
                                            <span class="landing-date-badge">{{ $kegiatan['badge'] }}</span>
                                        </div>
                                        <h3>{{ $kegiatan['judul'] }}</h3>
                                        <div class="landing-author">
                                            <span class="landing-avatar" aria-hidden="true">{{ $kegiatan['inisial'] }}</span>
                                            <span>{{ $kegiatan['penulis'] }}</span>
                                        </div>
                                    </div>
                                    <span class="landing-activity-grip" aria-hidden="true"><i data-lucide="grip-vertical" class="w-4 h-4"></i></span>
                                </article>
                            @empty
                                <div class="landing-empty-state"><i data-lucide="notebook-pen" class="w-5 h-5" aria-hidden="true"></i><h3>Belum ada kegiatan dipublikasikan</h3><p>Catatan perjalanan magang akan hadir di sini.</p></div>
                            @endforelse
                        </div>

                        @if ($kegiatans)
                            <div class="landing-activity-toolbar" data-landing-reveal>
                                <p><i data-lucide="move" class="w-4 h-4" aria-hidden="true"></i> Tarik kartu untuk menata ulang papan kegiatan.</p>
                                <button type="button" class="landing-activity-reset" data-activity-reset>
                                    <i data-lucide="sparkles" class="w-4 h-4" aria-hidden="true"></i> Rapikan
                                </button>
                            </div>
                        @endif
                    </div>
                </section>

                <section id="dokumentasi" class="landing-section landing-gallery-section" aria-labelledby="gallery-title">
                    <div class="landing-container">
                        <div class="landing-section-heading" data-landing-reveal>
                            <div>
                                <span class="landing-kicker">Galeri perjalanan</span>
                                <h2 id="gallery-title">Momen yang bercerita.</h2>
                            </div>
                            <p>Potret kegiatan dan kebersamaan. Pilih panel untuk membuka cerita di baliknya.</p>
                        </div>

                        <div class="landing-gallery-accordion" data-gallery-accordion>
                            @forelse ($dokumentasis as $dokumentasi)
                                <a
                                    class="landing-gallery-panel{{ $loop->first ? ' is-active' : '' }}"
                                    href="{{ asset($dokumentasi['img']) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    data-gallery-panel
                                    aria-label="Lihat {{ $dokumentasi['judul'] }} dalam ukuran penuh (tab baru)"
                                >
                                    <img src="{{ asset($dokumentasi['img']) }}" alt="{{ $dokumentasi['judul'] }}" loading="lazy" decoding="async" width="600" height="800" draggable="false">
                                    <span class="landing-gallery-panel-shade" aria-hidden="true"></span>
                                    <span class="landing-gallery-panel-number" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="landing-gallery-panel-label">
                                        <span class="landing-gallery-panel-bar" aria-hidden="true"></span>
                                        <span class="landing-gallery-panel-copy">
                                            <strong>{{ $dokumentasi['judul'] }}</strong>
                                            <small>Buka foto</small>
                                        </span>
                                        <span class="landing-gallery-panel-arrow" aria-hidden="true"><i data-lucide="arrow-up-right" class="w-4 h-4"></i></span>
                                    </span>
                                </a>
                            @empty
                                <div class="landing-empty-state"><i data-lucide="images" class="w-5 h-5" aria-hidden="true"></i><h3>Dokumentasi segera hadir</h3><p>Momen kegiatan yang dipublikasikan akan tampil di sini.</p></div>
                            @endforelse
                        </div>

                        @if ($dokumentasis)
                            <p class="landing-gallery-hint" data-landing-reveal><i data-lucide="images" class="w-4 h-4" aria-hidden="true"></i> {{ count($dokumentasis) }} momen terdokumentasi. Pilih panel untuk melihat foto penuh.</p>
                        @endif
                    </div>
                </section>

                <section class="landing-cta-section" aria-labelledby="cta-title">
                    <div class="landing-container">
                        <div class="landing-cta" data-landing-reveal>
                            <canvas data-canvas-ripple data-dot-grid aria-hidden="true"></canvas>
                            <div class="landing-cta-copy" data-anime-stagger>
                                <p class="landing-cta-eyebrow"><span aria-hidden="true"></span> Jadikan setiap hari berarti</p>
                                <h2 id="cta-title">Sudah mencatat<br>kegiatan hari ini?</h2>
                                <p>Isi logbook dan absensi secara rutin.<br>Bangun rekam jejak yang bisa kamu banggakan.</p>
                            </div>
                            <div class="landing-cta-actions" data-anime-stagger>
                                <a href="{{ route('login') }}" class="landing-pill landing-pill-white">Buka logbook <span class="landing-pill-icon" aria-hidden="true"><i data-lucide="arrow-right" class="w-4 h-4"></i></span></a>
                                <a href="{{ route('peserta.absensi') }}" class="landing-pill landing-pill-ghost"><i data-lucide="calendar-check" class="w-4 h-4" aria-hidden="true"></i> Absensi sekarang</a>
                                <small>Akses sesuai peran akun yang diberikan admin.</small>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="landing-footer" data-landing-footer>
                <span class="landing-footer-aura" aria-hidden="true"></span>
                <div class="landing-container landing-footer-inner">
                    <div class="landing-footer-brand" data-footer-reveal>
                        <a href="{{ url('/') }}" class="landing-brand" aria-label="Magang Komdigi — Beranda">
                            <span class="landing-brand-mark" aria-hidden="true">K<span></span></span>
                            <span class="landing-brand-text">Magang Komdigi<small>Kementerian Komunikasi dan Digital</small></span>
                        </a>
                        <p>Ruang informasi dan dokumentasi perjalanan Magang Komdigi 2026. Belajar hari ini, berkontribusi untuk esok.</p>
                    </div>

                    <nav class="landing-footer-links" aria-label="Tautan footer" data-footer-reveal>
                        <a href="#konten-utama">Beranda</a>
                        <a href="#tentang">Tentang</a>
                        <a href="#alur">Alur magang</a>
                        <a href="#kegiatan">Kegiatan</a>
                        <a href="#dokumentasi">Dokumentasi</a>
                    </nav>

                    <div class="landing-footer-socials" data-footer-reveal>
                        <a href="https://x.com/kemkomdigi" target="_blank" rel="noopener noreferrer" class="landing-footer-social" aria-label="X Kementerian Komdigi (tab baru)"><span aria-hidden="true">X</span></a>
                        <a href="https://www.instagram.com/kementeriankomdigi/" target="_blank" rel="noopener noreferrer" class="landing-footer-social" aria-label="Instagram Kementerian Komdigi (tab baru)"><i data-lucide="camera" class="w-4 h-4" aria-hidden="true"></i></a>
                        <a href="https://maps.app.goo.gl/1PyiR9wqdNK6gq6b9" target="_blank" rel="noopener noreferrer" class="landing-footer-social" aria-label="Lokasi Magang Komdigi di Google Maps (tab baru)"><i data-lucide="map-pin" class="w-4 h-4" aria-hidden="true"></i></a>
                        <a href="{{ route('login') }}" class="landing-footer-social" aria-label="Masuk ke ruang magang"><i data-lucide="log-in" class="w-4 h-4" aria-hidden="true"></i></a>
                    </div>

                    <div class="landing-footer-meta" data-footer-reveal>
                        <span>Jl. HM. Said No.27, Gaharu, Medan Timur, Sumatera Utara</span>
                        <span>&copy; 2026 Magang Komdigi</span>
                        <a href="{{ route('admin.dashboard') }}">Portal admin</a>
                        <a href="#konten-utama" class="landing-back-top">Kembali ke atas <i data-lucide="arrow-up" class="w-4 h-4" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="landing-footer-wordmark-wrap" aria-hidden="true">
                    <span class="landing-footer-wordmark" data-footer-wordmark>magangyuk</span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>

@extends('layouts.dashboardUser')
@section('title', 'Dashboard')
@section('content')
    @php
        $namaPeserta = auth()->check() ? auth()->user()->nama_lengkap : $peserta['nama'];
        $idPeserta = auth()->check() ? auth()->user()->id : $peserta['id_peserta'];
        $inisial = collect(explode(' ', trim($namaPeserta)))
            ->filter(fn ($word) => $word !== '')
            ->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('') ?: 'P';
    @endphp

    <div class="space-y-6 text-foreground">
        <header class="ui-page-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" data-reveal>
            <div class="min-w-0">
                <p class="ui-eyebrow">Selamat datang kembali</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl break-words">{{ $namaPeserta }}</h1>
                <p class="mt-2 text-sm text-muted">Pantau perkembangan dan aktivitas magangmu di sini.</p>
            </div>
            <div class="glass flex w-fit shrink-0 items-center gap-3 rounded-xl px-4 py-3">
                <i data-lucide="calendar-days" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div>
                    <p class="text-sm font-medium" id="current-date">{{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}</p>
                    <p class="mt-0.5 text-xs tabular-nums text-muted" id="current-time">{{ now()->timezone('Asia/Jakarta')->format('H.i.s') }} WIB</p>
                </div>
            </div>
        </header>

        {{-- Daily action comes before the overview. --}}
        <div class="grid gap-5 xl:grid-cols-5" data-reveal>
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6 xl:col-span-3" aria-labelledby="attendance-heading">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="ui-eyebrow">Prioritas hari ini</p>
                        <h2 id="attendance-heading" class="mt-2 text-lg font-semibold">Absensi Hari Ini</h2>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-lg border border-subtle bg-elevated px-3 py-1.5 text-xs font-medium">
                        <i data-lucide="clock" class="w-4 h-4 text-primary" aria-hidden="true"></i>
                        {{ $absenHariIni['status'] }}
                    </span>
                </div>
                <dl class="my-6 grid grid-cols-3 gap-3">
                    <div class="rounded-xl border border-subtle bg-elevated p-3 sm:p-4">
                        <dt class="text-xs text-muted">Masuk</dt>
                        <dd class="mt-2 text-lg font-semibold tabular-nums">{{ $absenHariIni['masuk'] ?? '—' }}</dd>
                    </div>
                    <div class="rounded-xl border border-subtle bg-elevated p-3 sm:p-4">
                        <dt class="text-xs text-muted">Pulang</dt>
                        <dd class="mt-2 text-lg font-semibold tabular-nums">{{ $absenHariIni['pulang'] ?? '—' }}</dd>
                    </div>
                    <div class="rounded-xl border border-subtle bg-elevated p-3 sm:p-4">
                        <dt class="text-xs text-muted">Durasi</dt>
                        <dd class="mt-2 text-lg font-semibold tabular-nums">{{ $absenHariIni['durasi'] ?? '—' }}</dd>
                    </div>
                </dl>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm leading-relaxed text-muted">Catat kehadiran dan lengkapi aktivitas harianmu.</p>
                    <a href="{{ route('peserta.absensi') }}" class="ui-button inline-flex shrink-0 items-center justify-center gap-2 px-4 py-3 text-sm">
                        <i data-lucide="scan-face" class="w-5 h-5" aria-hidden="true"></i>
                        @if ($absenHariIni['pulang'])
                            Lihat Absensi Hari Ini
                        @elseif ($absenHariIni['masuk'])
                            Absen Pulang
                        @else
                            Absen Masuk Sekarang
                        @endif
                        <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
            </section>

            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6 xl:col-span-2" aria-label="Identitas peserta">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary text-base font-semibold text-white">{{ $inisial }}</div>
                    <div class="min-w-0">
                        <h2 class="font-semibold break-words">{{ $namaPeserta }}</h2>
                        <p class="mt-1 text-xs text-muted">Peserta Magang · ID: <span class="text-foreground">{{ $idPeserta }}</span></p>
                    </div>
                    <span class="ml-auto shrink-0 rounded-lg border border-subtle bg-elevated px-2.5 py-1 text-xs font-medium text-primary">{{ $peserta['status'] }}</span>
                </div>
                <dl class="mt-5 space-y-4 border-t border-subtle pt-5 text-sm">
                    <div class="grid grid-cols-3 gap-3">
                        <dt class="text-muted">Institusi</dt>
                        <dd class="col-span-2 font-medium break-words">{{ $peserta['institusi'] }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <dt class="text-muted">Unit Kerja</dt>
                        <dd class="col-span-2 font-medium break-words">{{ $peserta['unit_kerja'] }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <dt class="text-muted">Periode</dt>
                        <dd class="col-span-2 font-medium">{{ $peserta['periode'] }}</dd>
                    </div>
                </dl>
            </section>
        </div>

        <div class="grid grid-cols-2 gap-4 xl:grid-cols-5" data-stagger>
            <section class="glass-card ui-stat col-span-2 rounded-2xl p-5" aria-label="Ringkasan kehadiran">
                <p class="text-sm font-medium text-muted">Ringkasan Kehadiran</p>
                <dl class="mt-5 grid grid-cols-4 gap-2">
                    @foreach (['hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'izin' => 'Izin', 'alpha' => 'Alpha'] as $key => $label)
                        <div>
                            <dt class="text-xs text-muted">{{ $label }}</dt>
                            <dd class="ui-stat-value mt-2 text-2xl font-semibold tabular-nums"><span data-counter="{{ $kehadiran[$key] }}">{{ $kehadiran[$key] }}</span></dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <section class="glass-card ui-stat rounded-2xl p-5" aria-label="Skor kinerja">
                <p class="text-sm font-medium text-muted">Skor Kinerja</p>
                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <div class="relative h-16 w-16 shrink-0">
                        <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36" aria-hidden="true">
                            <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--ui-border)" stroke-width="3" />
                            <circle cx="18" cy="18" r="15.5" pathLength="100" fill="none" stroke="url(#scoreGrad)" stroke-width="3" stroke-dasharray="{{ $skor['nilai'] }} 100" stroke-linecap="round" data-ring />
                            <defs>
                                <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="var(--ui-primary)" />
                                    <stop offset="100%" stop-color="var(--ui-accent)" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="ui-stat-value text-xl font-semibold tabular-nums" data-counter="{{ $skor['nilai'] }}">{{ $skor['nilai'] }}</span>
                        </div>
                    </div>
                    <p class="text-xs font-medium text-primary">{{ $skor['label'] }}</p>
                </div>
            </section>

            <section class="glass-card ui-stat rounded-2xl p-5" aria-label="Status magang">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-sm font-medium text-muted">Status Magang</p>
                    <i data-lucide="shield-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                </div>
                <p class="mt-5 inline-flex items-center text-xl font-semibold {{ strtolower($peserta['status']) === 'aktif' ? 'ui-badge-live' : '' }}">{{ $peserta['status'] }}</p>
                <p class="mt-2 text-xs text-muted">Status kepesertaan</p>
            </section>

            <section class="glass-card ui-stat col-span-2 rounded-2xl p-5 xl:col-span-1" aria-label="Ringkasan logbook">
                <p class="text-sm font-medium text-muted">Logbook</p>
                <dl class="mt-3 flex gap-6">
                    <div>
                        <dt class="text-xs text-muted">Belum isi</dt>
                        <dd class="ui-stat-value mt-1 text-2xl font-semibold tabular-nums"><span data-counter="{{ $logbook['belum_isi'] }}">{{ $logbook['belum_isi'] }}</span></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">Menunggu</dt>
                        <dd class="ui-stat-value mt-1 text-2xl font-semibold tabular-nums"><span data-counter="{{ $logbook['menunggu'] }}">{{ $logbook['menunggu'] }}</span></dd>
                    </div>
                </dl>
                <a href="{{ route('peserta.laporan') }}" class="mt-3 inline-flex items-center gap-2 text-xs font-medium text-primary hover:underline">
                    Isi logbook <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </section>
        </div>

        <div class="grid gap-5 xl:grid-cols-3" data-stagger>
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6 xl:col-span-2" aria-labelledby="progress-heading">
                <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 id="progress-heading" class="text-base font-semibold">Grafik Perkembangan</h2>
                        <p class="mt-1 text-sm text-muted">Skor kinerja mingguan</p>
                    </div>
                    <a href="{{ route('peserta.grafik') }}" class="ui-button-secondary inline-flex items-center gap-2 px-3 py-2 text-xs">
                        {{ count($chartData['labels']) }} Minggu Terakhir
                        <i data-lucide="arrow-up-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="h-64 sm:h-72">
                    <div id="progressChart" class="h-full w-full" data-chart='@json($chartData)' role="img" aria-label="Grafik skor kinerja mingguan"></div>
                </div>
            </section>

            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="internship-heading">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <h2 id="internship-heading" class="text-base font-semibold">Detail Magang</h2>
                    <span class="rounded-lg border border-subtle bg-elevated px-2.5 py-1 text-xs font-medium text-primary">{{ $peserta['status'] }}</span>
                </div>
                <dl class="space-y-5 text-sm">
                    <div>
                        <dt class="text-xs text-muted">Periode</dt>
                        <dd class="mt-1.5 font-medium">{{ $peserta['periode'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">Unit Kerja</dt>
                        <dd class="mt-1.5 font-medium break-words">{{ $peserta['unit_kerja'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">Pembimbing</dt>
                        <dd class="mt-1.5 font-medium break-words">{{ $peserta['pembimbing'] }}</dd>
                    </div>
                </dl>
                <div class="mt-6 border-t border-subtle pt-5">
                    <div class="mb-2 flex items-center justify-between gap-3 text-xs">
                        <span class="text-muted">Progress Periode</span>
                        <span class="font-medium text-primary">{{ $peserta['periode_progress'] }}%</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-elevated" role="progressbar" aria-label="Progress periode magang" aria-valuenow="{{ $peserta['periode_progress'] }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full origin-left rounded-full bg-primary" data-progress="{{ $peserta['periode_progress'] }}" style="width: {{ $peserta['periode_progress'] }}%"></div>
                    </div>
                </div>
            </section>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="assessment-heading">
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <i data-lucide="star" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                        <h2 id="assessment-heading" class="text-base font-semibold">Penilaian Pembimbing</h2>
                    </div>
                    <a href="{{ route('peserta.penilaian') }}" class="ui-button-secondary inline-flex items-center gap-2 px-3 py-2 text-xs">
                        {{ $penilaian['total'] }} / 5.0
                        <i data-lucide="arrow-up-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse ($penilaian['aspek'] as $aspek)
                        <div>
                            <div class="mb-2 flex justify-between gap-3 text-sm">
                                <span class="text-muted">{{ $aspek['label'] }}</span>
                                <span class="font-medium tabular-nums">{{ $aspek['nilai'] }}</span>
                            </div>
                            <div class="h-1.5 overflow-hidden rounded-full bg-elevated" role="progressbar" aria-label="{{ $aspek['label'] }}" aria-valuenow="{{ $aspek['persen'] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="h-full origin-left rounded-full bg-accent" data-progress="{{ $aspek['persen'] }}" style="width: {{ $aspek['persen'] }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-muted">Belum ada penilaian dari pembimbing.</p>
                    @endforelse
                </div>
                <blockquote class="mt-6 rounded-xl border border-subtle bg-elevated p-4">
                    <p class="text-sm leading-relaxed">{{ $penilaian['komentar'] }}</p>
                    <footer class="mt-3 text-xs text-muted">— {{ $penilaian['komentar_oleh'] }}</footer>
                </blockquote>
            </section>

            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="report-heading">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <i data-lucide="file-text" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                        <h2 id="report-heading" class="text-base font-semibold">Laporan Akhir</h2>
                    </div>
                    <span class="rounded-lg border border-subtle bg-elevated px-2.5 py-1.5 text-xs font-medium">{{ $laporan['status'] }}</span>
                </div>
                <div class="flex items-center gap-3 rounded-xl border border-subtle bg-elevated p-4">
                    <i data-lucide="calendar-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                    <div>
                        <p class="text-xs text-muted">Batas pengumpulan</p>
                        <p class="mt-1 text-sm font-medium">{{ $laporan['batas'] }}</p>
                    </div>
                </div>
                <ul class="my-5 space-y-3 text-sm">
                    @foreach ($laporan['checklist'] as $item)
                        <li class="flex items-start gap-3">
                            @if ($item['done'])
                                <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                                <span><span class="sr-only">Selesai: </span>{{ $item['label'] }}
                                    @if ($item['detail'])
                                        <span class="font-medium text-primary">{{ $item['detail'] }}</span>
                                    @endif
                                </span>
                            @else
                                <i data-lucide="clock" class="w-5 h-5 shrink-0 text-muted" aria-hidden="true"></i>
                                <span class="text-muted"><span class="sr-only">Belum selesai: </span>{{ $item['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('peserta.laporan') }}" class="ui-button-secondary inline-flex w-full items-center justify-center gap-2 px-4 py-3 text-sm">
                    <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
                    Mulai Buat Laporan Akhir
                </a>
            </section>
        </div>

        <section class="glass-card rounded-2xl p-5 sm:p-6" aria-labelledby="certificate-heading">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <i data-lucide="award" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                    <div>
                        <h2 id="certificate-heading" class="text-base font-semibold">Sertifikat Magang</h2>
                        <p class="mt-1 text-sm text-muted">Kelengkapan syarat penerbitan sertifikat</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-2xl font-semibold tabular-nums"><span data-counter="{{ $sertifikat['progress'] }}">{{ $sertifikat['progress'] }}</span><span class="ml-0.5 text-base text-muted">%</span></p>
                        <p class="text-xs text-muted">Lengkap</p>
                    </div>
                    <svg class="h-12 w-12 -rotate-90" viewBox="0 0 36 36" aria-hidden="true">
                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--ui-border)" stroke-width="3" />
                        <circle cx="18" cy="18" r="15.5" pathLength="100" fill="none" stroke="var(--ui-accent)" stroke-width="3" stroke-dasharray="{{ $sertifikat['progress'] }} 100" stroke-linecap="round" data-ring />
                    </svg>
                </div>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                <ul class="space-y-4">
                    @foreach ($sertifikat['syarat'] as $syarat)
                        <li class="flex items-start gap-3 text-sm">
                            @if ($syarat['done'])
                                <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                                <span><span class="sr-only">Terpenuhi: </span>{{ $syarat['label'] }}
                                    @if ($syarat['detail'])
                                        <span class="font-medium text-primary">{{ $syarat['detail'] }}</span>
                                    @endif
                                </span>
                            @else
                                <i data-lucide="clock" class="w-5 h-5 shrink-0 text-muted" aria-hidden="true"></i>
                                <span class="text-muted"><span class="sr-only">Belum terpenuhi: </span>{{ $syarat['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-col items-start justify-center rounded-xl border border-subtle bg-elevated p-5">
                    <div class="flex items-center gap-3">
                        @if ($sertifikat['terkunci'])
                            <i data-lucide="lock-keyhole" class="w-5 h-5 text-muted" aria-hidden="true"></i>
                            <p class="text-sm font-semibold">Sertifikat terkunci</p>
                        @else
                            <i data-lucide="award" class="w-5 h-5 text-accent" aria-hidden="true"></i>
                            <p class="text-sm font-semibold">Sertifikat tersedia</p>
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-muted">{{ $sertifikat['terkunci'] ? 'Lengkapi semua syarat untuk membuka.' : 'Semua syarat penerbitan telah terpenuhi.' }}</p>
                    <a href="{{ route('peserta.sertifikat') }}" class="ui-button-secondary mt-4 inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                        Lihat Detail Sertifikat
                        <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </section>

        <nav class="grid grid-cols-2 gap-4 lg:grid-cols-4" aria-label="Akses cepat peserta" data-stagger>
            <a href="{{ route('peserta.riwayat') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="history" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Riwayat</p><p class="mt-1 text-xs text-muted">Catatan kehadiran</p></div>
            </a>
            <a href="{{ route('peserta.laporan') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="book-open" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Laporan</p><p class="mt-1 text-xs text-muted">Harian & mingguan</p></div>
            </a>
            <a href="{{ route('peserta.izin') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="calendar-days" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Izin / Sakit</p><p class="mt-1 text-xs text-muted">Ajukan ketidakhadiran</p></div>
            </a>
            <a href="{{ route('peserta.profil') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="user-round" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Profil</p><p class="mt-1 text-xs text-muted">Data peserta</p></div>
            </a>
        </nav>

        <section class="glass-card flex flex-col gap-5 rounded-2xl p-5 sm:p-6 lg:flex-row lg:items-center" aria-labelledby="attendance-area-heading">
            <div class="flex items-center gap-3 lg:mr-auto">
                <i data-lucide="map-pin" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                <div>
                    <h2 id="attendance-area-heading" class="text-sm font-semibold">Area Absensi</h2>
                    <p class="mt-1 text-xs text-muted">{{ $areaAbsensi['hari_kerja'] }}</p>
                </div>
            </div>
            <dl class="grid gap-4 text-sm sm:grid-cols-2 lg:gap-8">
                <div><dt class="text-xs text-muted">Lokasi</dt><dd class="mt-1 font-medium">{{ $areaAbsensi['lokasi'] }}</dd></div>
                <div><dt class="text-xs text-muted">Radius</dt><dd class="mt-1 font-medium text-accent">{{ $areaAbsensi['radius'] }}</dd></div>
            </dl>
        </section>
    </div>
@endsection

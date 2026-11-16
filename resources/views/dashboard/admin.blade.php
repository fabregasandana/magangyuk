@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6 text-foreground">
        <header class="ui-page-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" data-reveal>
            <div class="min-w-0">
                <p class="ui-eyebrow">Panel Administrasi</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">Dashboard Admin</h1>
                <p class="mt-2 text-sm text-muted">Ringkasan program, performa peserta, dan aktivitas terbaru.</p>
            </div>
            <div class="glass flex w-fit shrink-0 items-center gap-3 rounded-xl px-4 py-3">
                <i data-lucide="calendar-days" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div>
                    <p class="text-sm font-medium" id="current-date">{{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}</p>
                    <p class="mt-0.5 text-xs tabular-nums text-muted" id="current-time">{{ now()->timezone('Asia/Jakarta')->format('H.i.s') }} WIB</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4" data-stagger>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Total peserta aktif">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Total Peserta Aktif</p>
                    <i data-lucide="users-round" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $stats['total_peserta_aktif'] }}">{{ $stats['total_peserta_aktif'] }}</span></p>
                <p class="mt-2 text-xs text-muted">Peserta dalam program</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Rata-rata kehadiran">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Rata-rata Kehadiran</p>
                    <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $stats['rata_kehadiran'] }}">{{ $stats['rata_kehadiran'] }}</span><span class="ml-1 text-lg text-muted">%</span></p>
                <p class="mt-2 text-xs text-muted">Dari peserta aktif</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Rata-rata skor kinerja">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Rata-rata Skor Kinerja</p>
                    <i data-lucide="trending-up" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $stats['rata_skor'] }}">{{ $stats['rata_skor'] }}</span></p>
                <p class="mt-2 text-xs text-muted">Dari peserta aktif</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Logbook menunggu approval">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Logbook Menunggu Approval</p>
                    <i data-lucide="book-open" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $stats['logbook_pending'] }}">{{ $stats['logbook_pending'] }}</span></p>
                @if ($stats['logbook_pending'] > 0)
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-primary">
                        <i data-lucide="circle-alert" class="w-3.5 h-3.5" aria-hidden="true"></i>
                        Perlu aksi
                    </p>
                @else
                    <p class="mt-2 text-xs text-muted">Tidak ada antrean approval</p>
                @endif
            </section>
        </div>

        <div class="grid gap-5 xl:grid-cols-5">
            <section class="glass-card min-w-0 overflow-hidden rounded-2xl xl:col-span-3" aria-labelledby="low-performance-heading">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-subtle p-5 sm:p-6">
                    <div>
                        <p class="ui-eyebrow">Perlu ditindaklanjuti</p>
                        <h2 id="low-performance-heading" class="mt-2 text-lg font-semibold">Peserta Performa Rendah</h2>
                        <p class="mt-1 text-sm text-muted">Skor &lt; 75 atau kehadiran &lt; 80%</p>
                    </div>
                    <a href="{{ route('admin.monitoring') }}" class="ui-button inline-flex items-center justify-center gap-2 px-3 py-2.5 text-xs">
                        Lihat semua
                        <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="overflow-x-auto" tabindex="0" role="region" aria-label="Tabel peserta performa rendah">
                    <table class="w-full min-w-[620px] text-left">
                        <caption class="sr-only">Peserta dengan skor di bawah 75 atau kehadiran di bawah 80 persen</caption>
                        <thead class="bg-elevated">
                            <tr class="border-b border-subtle text-xs text-muted">
                                <th scope="col" class="px-5 py-3 font-medium">Peserta</th>
                                <th scope="col" class="px-4 py-3 text-center font-medium">Skor</th>
                                <th scope="col" class="px-4 py-3 text-center font-medium">Kehadiran</th>
                                <th scope="col" class="px-4 py-3 font-medium">Pembimbing</th>
                                <th scope="col" class="px-4 py-3 text-center font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody data-stagger>
                            @forelse ($lowPerformers as $p)
                                <tr class="table-row border-b border-subtle transition-colors last:border-0 hover:bg-elevated">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary text-xs font-semibold text-white">{{ $p['initial'] }}</div>
                                            <div>
                                                <p class="text-sm font-medium">{{ $p['nama'] }}</p>
                                                <p class="mt-1 text-xs text-muted">{{ $p['id'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold tabular-nums">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $p['skor'] < 70 ? 'bg-rose-500' : 'bg-amber-500' }}" aria-hidden="true"></span>
                                            {{ $p['skor'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-medium tabular-nums">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $p['hadir'] < 75 ? 'bg-rose-500' : 'bg-amber-500' }}" aria-hidden="true"></span>
                                            {{ $p['hadir'] }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-muted">{{ $p['pembimbing'] }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.monitoring') }}" class="inline-flex py-2 text-xs font-medium text-primary hover:underline" aria-label="Detail monitoring {{ $p['nama'] }}">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-muted">Tidak ada peserta dengan performa rendah</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6 xl:col-span-2" aria-labelledby="notifications-heading">
                <div class="mb-5 flex items-center gap-3">
                    <i data-lucide="bell" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                    <h2 id="notifications-heading" class="text-base font-semibold">Notifikasi Penting</h2>
                </div>
                <ul class="space-y-3">
                    @forelse ($notifications as $n)
                        <li class="rounded-xl border border-subtle bg-elevated p-4">
                            <div class="flex items-start gap-3">
                                <span class="ui-dot-pulse mt-1.5 h-2 w-2 shrink-0 rounded-full
                                    {{ $n['type'] === 'danger' ? 'bg-rose-500' : '' }}
                                    {{ $n['type'] === 'warning' ? 'bg-amber-500' : '' }}
                                    {{ $n['type'] === 'info' ? 'bg-primary' : '' }}
                                    {{ $n['type'] === 'success' ? 'bg-emerald-500' : '' }}" aria-hidden="true"></span>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-sm font-medium leading-relaxed">{{ $n['title'] }}</h3>
                                    <p class="mt-1 text-xs leading-relaxed text-muted">{{ $n['desc'] }}</p>
                                    <p class="mt-2 text-xs text-muted">{{ $n['time'] }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="flex items-center gap-3 rounded-xl border border-dashed border-subtle p-5 text-sm text-muted">
                            <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                            Tidak ada notifikasi penting saat ini
                        </li>
                    @endforelse
                </ul>
            </section>
        </div>

        <div class="grid gap-5 lg:grid-cols-2" data-stagger>
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="period-trend-heading">
                <div class="mb-5">
                    <h2 id="period-trend-heading" class="text-base font-semibold">Tren Magang per Periode</h2>
                    <p class="mt-1 text-sm text-muted">Perkembangan program dari waktu ke waktu</p>
                </div>
                <div class="h-64 sm:h-72">
                    <div id="trendPeriodeChart" class="h-full w-full" data-chart='@json($trendChart)' role="img" aria-label="Grafik tren magang per periode"></div>
                </div>
            </section>
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="institution-heading">
                <div class="mb-5">
                    <h2 id="institution-heading" class="text-base font-semibold">Distribusi Peserta per Institusi</h2>
                    <p class="mt-1 text-sm text-muted">Sebaran institusi asal peserta magang</p>
                </div>
                <div class="h-64 sm:h-72">
                    <div id="institusiChart" class="h-full w-full" data-chart='@json($institusiChart)' role="img" aria-label="Grafik distribusi peserta menurut institusi"></div>
                </div>
            </section>
        </div>

        <section class="glass-card rounded-2xl p-5 sm:p-6" aria-labelledby="activity-heading">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <i data-lucide="history" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                    <h2 id="activity-heading" class="text-base font-semibold">Ringkasan Aktivitas Terbaru</h2>
                </div>
                <a href="{{ route('admin.feature-pendukung') }}" class="inline-flex items-center gap-2 py-1 text-xs font-medium text-primary hover:underline">
                    Lihat semua aktivitas
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </div>
            <div class="grid gap-5 lg:grid-cols-3" data-stagger>
                <section class="rounded-xl border border-subtle bg-elevated p-4" aria-label="Aktivitas logbook">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold">
                        <i data-lucide="book-open" class="w-4 h-4 text-primary" aria-hidden="true"></i>
                        Logbook
                    </h3>
                    <ul class="space-y-4">
                        @forelse ($recentLogbook as $item)
                            <li class="border-l border-subtle pl-3">
                                <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-muted">Belum ada aktivitas logbook</li>
                        @endforelse
                    </ul>
                </section>
                <section class="rounded-xl border border-subtle bg-elevated p-4" aria-label="Aktivitas penilaian">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold">
                        <i data-lucide="star" class="w-4 h-4 text-primary" aria-hidden="true"></i>
                        Penilaian
                    </h3>
                    <ul class="space-y-4">
                        @forelse ($recentPenilaian as $item)
                            <li class="border-l border-subtle pl-3">
                                <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-muted">Belum ada aktivitas penilaian</li>
                        @endforelse
                    </ul>
                </section>
                <section class="rounded-xl border border-subtle bg-elevated p-4" aria-label="Aktivitas pendaftaran baru">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold">
                        <i data-lucide="user-plus" class="w-4 h-4 text-primary" aria-hidden="true"></i>
                        Pendaftaran Baru
                    </h3>
                    <ul class="space-y-4">
                        @forelse ($recentPendaftaran as $item)
                            <li class="border-l border-subtle pl-3">
                                <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-muted">Belum ada pendaftaran baru</li>
                        @endforelse
                    </ul>
                </section>
            </div>
        </section>
    </div>
@endsection

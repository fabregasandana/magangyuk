@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6 text-foreground">
        @include('layouts.dashboard-hero', [
            'kicker' => 'Panel administrasi',
            'title' => 'Pantau progres,',
            'accent' => 'kembangkan potensi.',
            'description' => 'Ringkasan program, performa peserta, dan aktivitas terbaru dalam satu ruang kendali.',
            'meta' => [
                ['icon' => 'calendar-days', 'label' => now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y')],
                ['icon' => 'clock', 'label' => now()->timezone('Asia/Jakarta')->format('H.i') . ' WIB'],
                ['icon' => 'shield-check', 'label' => 'Akses administrator'],
            ],
            'mini' => [
                ['label' => 'Peserta aktif', 'value' => $stats['total_peserta_aktif']],
                ['label' => 'Kehadiran', 'value' => $stats['rata_kehadiran'] . '%'],
                ['label' => 'Skor rata-rata', 'value' => $stats['rata_skor']],
                ['label' => 'Logbook pending', 'value' => $stats['logbook_pending']],
            ],
            'actions' => [
                ['label' => 'Monitoring', 'href' => route('admin.monitoring'), 'icon' => 'chart-no-axes-combined'],
                ['label' => 'Kelola penilaian', 'href' => route('admin.kelola-penilaian'), 'icon' => 'clipboard-check', 'variant' => 'secondary'],
            ],
        ])

        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4" data-stagger>
            <section class="glass-card ui-stat ui-stat-featured rounded-2xl p-4 sm:p-5" aria-label="Total peserta aktif">
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

        <div class="grid gap-5 xl:grid-cols-3">
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6 xl:col-span-2" aria-labelledby="activity-heading" x-data="dashTabs" data-reveal>
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="dash-icon-tile"><i data-lucide="history" class="w-4 h-4" aria-hidden="true"></i></span>
                        <div class="min-w-0">
                            <h2 id="activity-heading" class="dash-card-title">Ringkasan Aktivitas Terbaru</h2>
                            <p class="dash-card-subtitle">Pilih kategori untuk menelusuri arus aktivitas.</p>
                        </div>
                    </div>
                    <div class="dash-tabs" role="tablist" aria-label="Kategori aktivitas">
                        <button type="button" class="dash-tab" role="tab" id="activity-tab-logbook" aria-controls="activity-panel-logbook" :aria-selected="active === 0 ? 'true' : 'false'" @click="select(0)">Logbook</button>
                        <button type="button" class="dash-tab" role="tab" id="activity-tab-penilaian" aria-controls="activity-panel-penilaian" :aria-selected="active === 1 ? 'true' : 'false'" @click="select(1)">Penilaian</button>
                        <button type="button" class="dash-tab" role="tab" id="activity-tab-pendaftaran" aria-controls="activity-panel-pendaftaran" :aria-selected="active === 2 ? 'true' : 'false'" @click="select(2)">Pendaftaran</button>
                    </div>
                </div>

                <div id="activity-panel-logbook" role="tabpanel" aria-labelledby="activity-tab-logbook" x-show="active === 0" x-transition.opacity.duration.200ms>
                    <ul class="space-y-3">
                        @forelse ($recentLogbook as $item)
                            <li class="flex items-start gap-3 rounded-xl border border-subtle bg-elevated p-3.5">
                                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-surface text-primary"><i data-lucide="book-open" class="w-4 h-4" aria-hidden="true"></i></span>
                                <div class="min-w-0">
                                    <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                    <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-xl border border-dashed border-subtle p-5 text-sm text-muted">Belum ada aktivitas logbook</li>
                        @endforelse
                    </ul>
                </div>

                <div id="activity-panel-penilaian" role="tabpanel" aria-labelledby="activity-tab-penilaian" x-show="active === 1" x-cloak x-transition.opacity.duration.200ms>
                    <ul class="space-y-3">
                        @forelse ($recentPenilaian as $item)
                            <li class="flex items-start gap-3 rounded-xl border border-subtle bg-elevated p-3.5">
                                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-surface text-primary"><i data-lucide="star" class="w-4 h-4" aria-hidden="true"></i></span>
                                <div class="min-w-0">
                                    <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                    <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-xl border border-dashed border-subtle p-5 text-sm text-muted">Belum ada aktivitas penilaian</li>
                        @endforelse
                    </ul>
                </div>

                <div id="activity-panel-pendaftaran" role="tabpanel" aria-labelledby="activity-tab-pendaftaran" x-show="active === 2" x-cloak x-transition.opacity.duration.200ms>
                    <ul class="space-y-3">
                        @forelse ($recentPendaftaran as $item)
                            <li class="flex items-start gap-3 rounded-xl border border-subtle bg-elevated p-3.5">
                                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-surface text-primary"><i data-lucide="user-plus" class="w-4 h-4" aria-hidden="true"></i></span>
                                <div class="min-w-0">
                                    <p class="text-sm leading-relaxed"><span class="font-medium">{{ $item['user'] }}</span> {{ $item['action'] }}</p>
                                    <p class="mt-1 text-xs text-muted">{{ $item['time'] }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="rounded-xl border border-dashed border-subtle p-5 text-sm text-muted">Belum ada pendaftaran baru</li>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-subtle pt-4">
                    <p class="text-xs text-muted">Diperbarui otomatis setiap kali data berubah.</p>
                    <a href="{{ route('admin.feature-pendukung') }}" class="inline-flex items-center gap-2 py-1 text-xs font-semibold text-primary hover:underline">
                        Lihat semua aktivitas
                        <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
            </section>

            <section class="glass-card relative min-w-0 overflow-hidden rounded-2xl p-5 sm:p-6" aria-labelledby="focus-heading" data-reveal>
                <canvas class="pointer-events-none absolute inset-0 h-full w-full opacity-20" data-canvas-ripple aria-hidden="true"></canvas>
                <div class="relative">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="ui-eyebrow">Sinyal program</p>
                            <h2 id="focus-heading" class="mt-2 text-lg font-semibold">Fokus hari ini</h2>
                        </div>
                        <div class="relative grid h-14 w-14 place-items-center rounded-full border border-subtle bg-surface">
                            <svg class="absolute inset-0 h-14 w-14 -rotate-90" viewBox="0 0 36 36" aria-hidden="true">
                                <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--ui-border)" stroke-width="2.5" />
                                <circle cx="18" cy="18" r="15.5" pathLength="100" fill="none" stroke="url(#focusGrad)" stroke-width="2.5" stroke-dasharray="{{ $stats['rata_kehadiran'] }} 100" stroke-linecap="round" data-ring />
                                <defs>
                                    <linearGradient id="focusGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="var(--ui-primary)" />
                                        <stop offset="100%" stop-color="var(--ui-accent)" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <span class="text-sm font-semibold tabular-nums">{{ $stats['rata_kehadiran'] }}%</span>
                        </div>
                    </div>

                    <p class="mt-3 text-sm leading-relaxed text-muted">Kehadiran rata-rata peserta aktif. Tindak lanjuti antrean yang masih terbuka.</p>

                    <ul class="mt-5 space-y-2.5">
                        <li class="flex items-center justify-between gap-3 rounded-xl border border-subtle bg-elevated px-3.5 py-3">
                            <span class="flex items-center gap-2.5 text-sm"><i data-lucide="book-open" class="w-4 h-4 text-primary" aria-hidden="true"></i> Logbook pending</span>
                            <span class="text-sm font-semibold tabular-nums">{{ $stats['logbook_pending'] }}</span>
                        </li>
                        <li class="flex items-center justify-between gap-3 rounded-xl border border-subtle bg-elevated px-3.5 py-3">
                            <span class="flex items-center gap-2.5 text-sm"><i data-lucide="circle-alert" class="w-4 h-4 text-primary" aria-hidden="true"></i> Performa rendah</span>
                            <span class="text-sm font-semibold tabular-nums">{{ count($lowPerformers) }}</span>
                        </li>
                        <li class="flex items-center justify-between gap-3 rounded-xl border border-subtle bg-elevated px-3.5 py-3">
                            <span class="flex items-center gap-2.5 text-sm"><i data-lucide="trending-up" class="w-4 h-4 text-primary" aria-hidden="true"></i> Skor rata-rata</span>
                            <span class="text-sm font-semibold tabular-nums">{{ $stats['rata_skor'] }}</span>
                        </li>
                    </ul>

                    <a href="{{ route('admin.monitoring') }}" class="ui-button mt-5 inline-flex w-full items-center justify-center gap-2 px-4 py-2.5 text-xs">
                        Buka monitoring
                        <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection

@extends('layouts.pembimbing')

@section('title', 'Dashboard Pembimbing')

@section('content')
    <div class="space-y-6 text-foreground">
        <header class="ui-page-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" data-reveal>
            <div class="min-w-0">
                <p class="ui-eyebrow">Selamat datang kembali</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl break-words">{{ $mentor['nama_gelar'] }}</h1>
                <p class="mt-2 text-sm text-muted">Pembimbing Magang · {{ $mentor['unit_penempatan'] }}</p>
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
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Peserta bimbingan">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Peserta Bimbingan</p>
                    <i data-lucide="users-round" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $jumlahPeserta }}">{{ $jumlahPeserta }}</span></p>
                <p class="mt-2 text-xs leading-relaxed text-muted">{{ $ringkasan['aktif'] }} Aktif · {{ $ringkasan['selesai'] }} Selesai</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Logbook pending">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Logbook Pending</p>
                    <i data-lucide="book-open" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $ringkasan['logbook_pending'] }}">{{ $ringkasan['logbook_pending'] }}</span></p>
                <p class="mt-2 text-xs leading-relaxed text-muted">Menunggu persetujuan</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Peserta perlu perhatian">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Perlu Perhatian</p>
                    <i data-lucide="circle-alert" class="w-5 h-5 shrink-0 text-primary" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums"><span data-counter="{{ $ringkasan['perhatian'] }}">{{ $ringkasan['perhatian'] }}</span></p>
                <p class="mt-2 text-xs leading-relaxed text-muted">Kehadiran / logbook rendah</p>
            </section>
            <section class="glass-card ui-stat rounded-2xl p-4 sm:p-5" aria-label="Rata-rata skor">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-muted">Rata-rata Skor</p>
                    <i data-lucide="trending-up" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                </div>
                <p class="ui-stat-value text-3xl font-semibold tabular-nums">{{ $ringkasan['rata_skor'] }}</p>
                <p class="mt-2 text-xs leading-relaxed text-muted">{{ $deltaSkor }}</p>
            </section>
        </div>

        {{-- Reviews are the primary daily action. --}}
        <div class="grid gap-5 xl:grid-cols-2">
            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="pending-heading">
                <div class="mb-5 flex items-start justify-between gap-3">
                    <div>
                        <p class="ui-eyebrow">Prioritas hari ini</p>
                        <h2 id="pending-heading" class="mt-2 text-lg font-semibold">Logbook Menunggu</h2>
                        <p class="mt-1 text-sm text-muted">Tinjau aktivitas dan berikan persetujuan.</p>
                    </div>
                    <span class="rounded-lg border border-subtle bg-elevated px-3 py-1.5 text-sm font-medium tabular-nums text-primary">{{ $ringkasan['logbook_pending'] }}</span>
                </div>
                <ul class="space-y-3">
                    @forelse ($logbookPending as $lb)
                        <li class="flex flex-wrap items-center gap-3 rounded-xl border border-subtle bg-elevated p-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary text-xs font-semibold text-white">{{ $lb['peserta_inisial'] }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium break-words">{{ $lb['peserta_nama'] }}</p>
                                <p class="mt-1 text-xs text-muted">{{ $lb['minggu_label'] }} · {{ \Illuminate\Support\Str::before($lb['dikirim'], ',') }}</p>
                            </div>
                            <a href="{{ route('pembimbing.logbook') }}" class="ui-button inline-flex shrink-0 items-center justify-center px-3 py-2 text-xs" aria-label="Review logbook {{ $lb['peserta_nama'] }}">Review</a>
                        </li>
                    @empty
                        <li class="flex items-center gap-3 rounded-xl border border-dashed border-subtle p-5 text-sm text-muted">
                            <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                            Tidak ada logbook yang menunggu approval.
                        </li>
                    @endforelse
                </ul>
                <a href="{{ route('pembimbing.logbook') }}" class="ui-button-secondary mt-5 inline-flex w-full items-center justify-center gap-2 px-4 py-3 text-sm">
                    Lihat semua logbook
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </section>

            <section class="glass-card min-w-0 rounded-2xl p-5 sm:p-6" aria-labelledby="performance-heading">
                <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 id="performance-heading" class="text-base font-semibold">Ringkasan Performa</h2>
                        <p class="mt-1 text-sm text-muted">Rata-rata skor bimbingan</p>
                    </div>
                    <span class="rounded-lg border border-subtle bg-elevated px-3 py-1.5 text-xs text-muted">{{ count($chartPerforma['data']['labels']) }} Minggu</span>
                </div>
                <div class="h-64 sm:h-72">
                    <div id="perfChart" class="h-full w-full" data-chart='@json($chartPerforma)' role="img" aria-label="Grafik rata-rata skor peserta bimbingan per minggu"></div>
                </div>
            </section>
        </div>

        <section class="glass-card rounded-2xl p-5 sm:p-6" aria-labelledby="attention-heading">
            <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <i data-lucide="circle-alert" class="w-5 h-5 mt-0.5 shrink-0 text-primary" aria-hidden="true"></i>
                    <div>
                        <h2 id="attention-heading" class="text-base font-semibold">Peserta Perlu Perhatian</h2>
                        <p class="mt-1 text-sm text-muted">Kehadiran rendah atau jarang isi logbook</p>
                    </div>
                </div>
                <span class="rounded-lg border border-subtle bg-elevated px-3 py-1.5 text-xs font-medium">{{ count($perluPerhatian) }} Peserta</span>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                @forelse ($perluPerhatian as $p)
                    <article class="flex flex-wrap items-center gap-3 rounded-xl border border-subtle bg-elevated p-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary text-sm font-semibold text-white">{{ $p['inisial'] }}</div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold break-words">{{ $p['nama'] }}</h3>
                            <p class="mt-1 text-xs text-muted">{{ $p['id_peserta'] }} · Kehadiran {{ $p['kehadiran'] }}%</p>
                            @if ($p['catatan'])
                                <p class="mt-2 flex items-start gap-1.5 text-xs text-foreground">
                                    <i data-lucide="circle-alert" class="w-3.5 h-3.5 shrink-0 text-primary" aria-hidden="true"></i>
                                    {{ $p['catatan'] }}
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="inline-flex shrink-0 items-center gap-1.5 py-2 text-xs font-medium text-primary hover:underline" aria-label="Detail peserta {{ $p['nama'] }}">
                            Detail <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                    </article>
                @empty
                    <div class="flex items-center gap-3 rounded-xl border border-dashed border-subtle p-5 text-sm text-muted lg:col-span-2">
                        <i data-lucide="circle-check" class="w-5 h-5 shrink-0 text-accent" aria-hidden="true"></i>
                        Tidak ada peserta yang perlu perhatian.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="glass-card rounded-2xl p-5 sm:p-6" aria-labelledby="participants-heading">
            <div class="mb-5 flex items-start gap-3">
                <i data-lucide="users-round" class="w-5 h-5 mt-0.5 shrink-0 text-primary" aria-hidden="true"></i>
                <div>
                    <h2 id="participants-heading" class="text-base font-semibold">Daftar Peserta Bimbingan</h2>
                    <p class="mt-1 text-sm text-muted">Kartu ringkas performa peserta</p>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 2xl:grid-cols-4" data-stagger>
                @forelse ($pesertaSorot as $p)
                    <article class="min-w-0 rounded-xl border bg-elevated p-4 {{ $p['status'] === 'perhatian' ? 'border-rose-500/30' : 'border-subtle' }}">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary text-sm font-semibold text-white">{{ $p['inisial'] }}</div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold break-words">{{ $p['nama'] }}</h3>
                                <p class="mt-1 text-xs text-muted">{{ $p['id_peserta'] }}</p>
                            </div>
                        </div>
                        <div class="mb-2 flex items-center justify-between text-sm">
                            <span class="text-muted">Skor</span>
                            <span class="font-semibold tabular-nums">{{ $p['skor'] }}</span>
                        </div>
                        <div class="mb-4 h-1.5 overflow-hidden rounded-full bg-surface" role="progressbar" aria-label="Skor {{ $p['nama'] }}" aria-valuenow="{{ $p['skor'] }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="h-full origin-left rounded-full bg-primary" data-progress="{{ $p['skor'] }}" style="width: {{ $p['skor'] }}%"></div>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-2 text-xs">
                            <p class="text-muted">Kehadiran <span class="font-medium text-foreground">{{ $p['kehadiran'] }}%</span></p>
                            <span class="inline-flex items-center gap-1.5 rounded-md border border-subtle bg-surface px-2 py-1 font-medium">
                                @if ($p['status'] === 'perhatian')
                                    <i data-lucide="circle-alert" class="w-3.5 h-3.5 text-primary" aria-hidden="true"></i>
                                @endif
                                {{ $p['gaya']['label'] }}
                            </span>
                        </div>
                        <div class="mt-5 grid grid-cols-2 gap-2">
                            <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="ui-button-secondary inline-flex items-center justify-center px-3 py-2.5 text-xs" aria-label="Detail peserta {{ $p['nama'] }}">Detail</a>
                            <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $p['id']]) }}" class="ui-button-secondary inline-flex items-center justify-center px-3 py-2.5 text-xs" aria-label="Nilai peserta {{ $p['nama'] }}">Nilai</a>
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl border border-dashed border-subtle p-5 text-sm text-muted sm:col-span-2 2xl:col-span-4">Belum ada peserta bimbingan.</p>
                @endforelse
            </div>
            <div class="mt-5 border-t border-subtle pt-4">
                <a href="{{ route('pembimbing.peserta') }}" class="inline-flex items-center gap-2 py-1 text-sm font-medium text-primary hover:underline">
                    Lihat semua peserta
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </div>
        </section>

        <nav class="grid grid-cols-2 gap-4 lg:grid-cols-4" aria-label="Akses cepat pembimbing" data-stagger>
            <a href="{{ route('pembimbing.peserta') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="users-round" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Daftar Peserta</p><p class="mt-1 text-xs text-muted">Kelola peserta</p></div>
            </a>
            <a href="{{ route('pembimbing.logbook') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="book-open" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Approval</p><p class="mt-1 text-xs text-muted">Review logbook</p></div>
            </a>
            <a href="{{ route('pembimbing.penilaianpeserta') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="star" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Penilaian</p><p class="mt-1 text-xs text-muted">Beri nilai peserta</p></div>
            </a>
            <a href="{{ route('pembimbing.laporanbimbingan') }}" class="glass-card flex flex-col items-start gap-3 rounded-2xl p-4 transition-colors hover:bg-elevated sm:p-5">
                <i data-lucide="chart-column" class="w-5 h-5 text-primary" aria-hidden="true"></i>
                <div><p class="text-sm font-semibold">Laporan</p><p class="mt-1 text-xs text-muted">Export & rekap</p></div>
            </a>
        </nav>
    </div>
@endsection

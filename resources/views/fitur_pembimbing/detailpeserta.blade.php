@extends('layouts.pembimbing')

@section('title', 'Detail Peserta')

@section('content')
    @php
        // Status peserta → badge terang di kartu profil (kelas Tailwind statis).
        $badgeHero = match ($peserta['status']) {
            'perhatian' => ['box' => 'bg-amber-50 text-amber-700 border-amber-100', 'dot' => 'bg-amber-500'],
            'selesai' => ['box' => 'bg-elevated text-muted border-subtle', 'dot' => 'bg-slate-400'],
            default => ['box' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot' => 'bg-emerald-500'],
        };
        // Status logbook peserta → border, ikon, dan badge (kelas Tailwind statis).
        $gayaLogbook = [
            'disetujui' => [
                'border' => 'border-subtle',
                'ikon' => 'bg-emerald-500/20',
                'label' => 'Disetujui',
                'badge' => 'bg-emerald-100 text-emerald-700',
            ],
            'menunggu' => [
                'border' => 'border-amber-500/30',
                'ikon' => 'bg-amber-500/20',
                'label' => 'Menunggu',
                'badge' => 'bg-amber-100 text-amber-700',
            ],
            'ditolak' => [
                'border' => 'border-rose-500/30',
                'ikon' => 'bg-rose-500/20',
                'label' => 'Ditolak',
                'badge' => 'bg-rose-100 text-rose-700',
            ],
        ];
    @endphp

    <!-- Breadcrumb + Back -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('pembimbing.peserta') }}" class="text-muted hover:text-foreground transition font-medium">Daftar Peserta</a>
        <i data-lucide="chevron-right" class="w-4 h-4 text-muted" aria-hidden="true"></i>
        <span class="text-foreground font-semibold">Detail Peserta</span>
    </div>

    <!-- PROFILE CARD -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-56 h-56 bg-komdigi-blue/10 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col lg:flex-row gap-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 flex-1">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 rounded-2xl {{ $peserta['avatar'] }} flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-blue-500/40">
                        {{ $peserta['inisial'] }}
                    </div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-sm">
                        <i data-lucide="check" class="w-4 h-4 text-white" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                        <div>
                            <p class="ui-eyebrow">Peserta magang</p>
                            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-foreground break-words">{{ $peserta['nama'] }}</h1>
                            <p class="mt-2 text-sm text-muted">ID: <span class="font-medium text-primary">{{ $peserta['id_peserta'] }}</span></p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 {{ $badgeHero['box'] }} text-xs font-bold rounded-full self-center sm:self-auto border">
                            <span class="w-2 h-2 {{ $badgeHero['dot'] }} rounded-full animate-pulse"></span>
                            {{ $peserta['gaya']['label_panjang'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-surface rounded-2xl px-4 py-3 border border-subtle">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Institusi</p>
                            <p class="text-sm font-semibold text-foreground mt-0.5">{{ $peserta['institusi'] }}</p>
                        </div>
                        <div class="bg-surface rounded-2xl px-4 py-3 border border-subtle">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Unit Kerja</p>
                            <p class="text-sm font-semibold text-foreground mt-0.5">{{ $peserta['unit_kerja'] }}</p>
                        </div>
                        <div class="bg-surface rounded-2xl px-4 py-3 border border-subtle">
                            <p class="text-[10px] font-bold text-komdigi-blue uppercase tracking-wide">Periode</p>
                            <p class="text-sm font-semibold text-foreground mt-0.5">{{ $peserta['periode'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick actions -->
            <div class="flex lg:flex-col gap-2 shrink-0 justify-center">
                <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $peserta['id']]) }}" class="ui-button inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm">
                    <i data-lucide="star" class="w-4 h-4" aria-hidden="true"></i>
                    Beri Penilaian
                </a>
                <a href="{{ route('pembimbing.logbook') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface border border-subtle text-foreground text-sm font-bold rounded-xl hover:bg-elevated transition">
                    <i data-lucide="file-text" class="w-4 h-4" aria-hidden="true"></i>
                    Lihat Logbook
                </a>
            </div>
        </div>
    </div>

    <!-- STATS ROW -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($statistik as $stat)
            <x-stat-card :label="$stat['label']" :value="$stat['nilai']" :caption="$stat['keterangan']" :icon="null" />
        @endforeach
    </div>

    <!-- TABS -->
    <div class="flex flex-wrap gap-2" data-tab-group>
        <button type="button" class="tab-btn active px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="grafik">Grafik Performa</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="absensi">Riwayat Absensi</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="logbook">Daftar Logbook</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="penilaian">Riwayat Penilaian</button>
        <button type="button" class="tab-btn px-4 py-2 text-sm rounded-xl border border-transparent" data-tab="laporan">Laporan &amp; Izin</button>
    </div>

    <!-- TAB: GRAFIK -->
    <div id="tab-grafik" class="tab-content active space-y-5">
        <div class="grid lg:grid-cols-2 gap-5">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-foreground">Skor Kinerja Mingguan</h3>
                    <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                </div>
                <div class="h-56">
                    <canvas id="scoreChart" data-chart='@json($chartSkor)'></canvas>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-foreground">Kehadiran Mingguan</h3>
                    <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">5 Minggu</span>
                </div>
                <div class="h-56">
                    <canvas id="attendChart" data-chart='@json($chartKehadiran)'></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: RIWAYAT ABSENSI -->
    <div id="tab-absensi" class="tab-content">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-subtle flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="font-bold text-foreground">Riwayat Absensi</h3>
                <div class="flex gap-2">
                    <select id="filterBulan" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                        <option value="all" selected>Semua Bulan</option>
                        <option value="nov">November 2026</option>
                        <option value="okt">Oktober 2026</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[700px]">
                    <thead>
                        <tr class="border-b border-subtle">
                            <th class="px-5 py-3 text-[11px] font-bold text-muted uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-muted uppercase">Masuk</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-muted uppercase">Pulang</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-muted uppercase">Durasi</th>
                            <th class="px-4 py-3 text-[11px] font-bold text-muted uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody id="absensiTable">
                        @foreach ($absensi as $a)
                            <tr class="{{ $loop->last ? '' : 'border-b border-subtle' }} hover:bg-elevated" data-bulan="{{ str_contains($a['tanggal'], 'Nov') ? 'nov' : 'okt' }}">
                                <td class="px-5 py-3.5 text-sm text-foreground font-medium">{{ $a['tanggal'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-foreground">{{ $a['masuk'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-foreground">{{ $a['pulang'] }}</td>
                                <td class="px-4 py-3.5 text-sm text-foreground">{{ $a['durasi'] }}</td>
                                <td class="px-4 py-3.5"><span class="px-2.5 py-1 rounded-full {{ $a['badge'] }} text-[11px] font-bold">{{ $a['label'] }}</span></td>
                            </tr>
                        @endforeach
                        <tr id="absensiEmpty" class="hidden">
                            <td colspan="5" class="px-5 py-10 text-center text-sm text-muted">Tidak ada data absensi untuk bulan ini.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: LOGBOOK -->
    <div id="tab-logbook" class="tab-content">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Daftar Logbook Peserta</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">{{ $peserta['logbook_terisi'] }} / {{ $peserta['logbook_total'] }} terisi</span>
            </div>
            <div class="space-y-3">
                @forelse ($logbookPeserta as $lb)
                    @php $gaya = $gayaLogbook[$lb['status']] ?? $gayaLogbook['disetujui']; @endphp
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-surface border {{ $gaya['border'] }}">
                        <div class="w-10 h-10 rounded-xl {{ $gaya['ikon'] }} flex items-center justify-center shrink-0">
                            @if ($lb['status'] === 'menunggu')
                                <i data-lucide="clock-3" class="w-5 h-5 text-amber-400" aria-hidden="true"></i>
                            @elseif ($lb['status'] === 'ditolak')
                                <i data-lucide="x" class="w-5 h-5 text-rose-400" aria-hidden="true"></i>
                            @else
                                <i data-lucide="check" class="w-5 h-5 text-emerald-400" aria-hidden="true"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-foreground">{{ $lb['minggu'] }} • {{ $lb['rentang'] }}</p>
                            <p class="text-xs text-muted mt-0.5 truncate">{{ $lb['ringkasan'] }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full {{ $gaya['badge'] }} text-[11px] font-bold shrink-0">{{ $gaya['label'] }}</span>
                        <a href="{{ route('pembimbing.logbook') }}" class="text-xs font-bold text-komdigi-blue hover:underline shrink-0">{{ $lb['aksi'] }}</a>
                    </div>
                @empty
                    <p class="text-sm text-muted text-center py-6">Belum ada logbook yang diisi peserta.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB: RIWAYAT PENILAIAN -->
    <div id="tab-penilaian" class="tab-content">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Riwayat Penilaian</h3>
                <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $peserta['id']]) }}" class="text-sm font-bold text-komdigi-blue hover:underline">+ Beri Penilaian Baru</a>
            </div>
            <div class="space-y-4">
                @forelse ($riwayatPenilaian as $rp)
                    <div class="p-5 rounded-2xl bg-surface border border-subtle">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                            <div>
                                <p class="text-sm font-bold text-foreground">{{ $rp['judul'] }}</p>
                                <p class="text-xs text-muted">{{ $rp['tanggal'] }} • oleh {{ $mentor['nama_gelar'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-amber-400">{{ $rp['skor'] }}</span>
                                <span class="text-xs text-muted">/ 5.0</span>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3 mb-4">
                            @foreach ($rp['kriteria'] as $k)
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-muted">{{ $k['nama'] }}</span>
                                        <span class="font-bold text-foreground">{{ $k['nilai'] }}</span>
                                    </div>
                                    <div class="h-1.5 bg-elevated rounded-full overflow-hidden">
                                        <div class="h-full {{ $k['bar'] }} rounded-full" style="width:{{ $k['persen'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="p-3.5 rounded-xl bg-surface border border-subtle">
                            <p class="text-xs text-foreground italic leading-relaxed">"{{ $rp['komentar'] }}"</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-muted text-center py-6">Belum ada riwayat penilaian untuk peserta ini.</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- TAB: LAPORAN & IZIN -->
    <div id="tab-laporan" class="tab-content space-y-5">
        {{-- Laporan --}}
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Laporan Peserta</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">
                    {{ collect($laporanPeserta)->where('status', 'disetujui')->count() }} / {{ count($laporanPeserta) }} disetujui
                </span>
            </div>
            <div class="space-y-4">
                @forelse ($laporanPeserta as $lp)
                    <div class="p-5 rounded-2xl bg-surface border {{ $lp['boleh_review'] ? 'border-amber-500/30' : 'border-subtle' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-foreground">{{ $lp['judul'] }}</p>
                                <p class="text-xs text-muted mt-0.5">Dikirim {{ $lp['dikirim'] }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full {{ $lp['badge'] }} text-[11px] font-bold shrink-0">{{ $lp['label'] }}</span>
                        </div>
                        <p class="text-sm text-foreground leading-relaxed">{{ $lp['ringkasan'] }}</p>

                        @if ($lp['catatan'])
                            <div class="mt-3 p-3.5 rounded-xl bg-surface border border-subtle">
                                <p class="text-[11px] font-bold text-muted uppercase tracking-wider mb-1">Catatan Pembimbing</p>
                                <p class="text-xs text-foreground italic leading-relaxed">"{{ $lp['catatan'] }}"</p>
                            </div>
                        @endif

                        @if ($lp['boleh_review'])
                            <form method="POST" action="{{ route('pembimbing.laporan.review') }}" class="mt-4 space-y-3 pt-4 border-t border-subtle">
                                @csrf
                                <input type="hidden" name="laporan_id" value="{{ $lp['id'] }}">
                                <div>
                                    <label class="form-label" for="komentar-laporan-{{ $lp['id'] }}">Catatan Review</label>
                                    <textarea id="komentar-laporan-{{ $lp['id'] }}" name="komentar" rows="2" placeholder="Wajib diisi jika menolak laporan..." class="form-input"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2.5">
                                    <button type="submit" name="keputusan" value="approve" class="ui-button ui-button-success flex-1">
                                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                                        Setujui
                                    </button>
                                    <button type="submit" name="keputusan" value="reject" class="ui-button ui-button-danger flex-1">
                                        <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                                        Perlu Revisi
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-muted text-center py-6">Peserta belum mengajukan laporan apa pun.</p>
                @endforelse
            </div>
        </div>

        {{-- Izin --}}
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-foreground">Pengajuan Izin</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-komdigi-blue text-[11px] font-bold rounded-full border border-blue-100">
                    {{ collect($izinPeserta)->where('status', 'menunggu')->count() }} menunggu review
                </span>
            </div>
            <div class="space-y-4">
                @forelse ($izinPeserta as $iz)
                    <div class="p-5 rounded-2xl bg-surface border {{ $iz['boleh_review'] ? 'border-amber-500/30' : 'border-subtle' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-foreground">{{ $iz['jenis'] }} • {{ $iz['rentang'] }}</p>
                                <p class="text-xs text-muted mt-0.5">{{ $iz['alasan'] }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full {{ $iz['badge'] }} text-[11px] font-bold shrink-0">{{ $iz['label'] }}</span>
                        </div>

                        @if ($iz['bukti_url'])
                            <a href="{{ $iz['bukti_url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-bold text-komdigi-blue hover:underline">
                                <i data-lucide="paperclip" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                Lihat Bukti Pendukung
                            </a>
                        @endif

                        @if ($iz['catatan'])
                            <div class="mt-3 p-3.5 rounded-xl bg-surface border border-subtle">
                                <p class="text-[11px] font-bold text-muted uppercase tracking-wider mb-1">Catatan Review</p>
                                <p class="text-xs text-foreground italic leading-relaxed">"{{ $iz['catatan'] }}"</p>
                            </div>
                        @endif

                        @if ($iz['boleh_review'])
                            <form method="POST" action="{{ route('pembimbing.izin.review') }}" class="mt-4 space-y-3 pt-4 border-t border-subtle">
                                @csrf
                                <input type="hidden" name="izin_id" value="{{ $iz['id'] }}">
                                <div>
                                    <label class="form-label" for="catatan-izin-{{ $iz['id'] }}">Catatan Review</label>
                                    <textarea id="catatan-izin-{{ $iz['id'] }}" name="catatan_review" rows="2" placeholder="Wajib diisi jika menolak pengajuan..." class="form-input"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2.5">
                                    <button type="submit" name="keputusan" value="approve" class="ui-button ui-button-success flex-1">
                                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                                        Setujui
                                    </button>
                                    <button type="submit" name="keputusan" value="reject" class="ui-button ui-button-danger flex-1">
                                        <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                                        Tolak
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-muted text-center py-6">Peserta belum pernah mengajukan izin.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

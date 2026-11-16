@extends('layouts.admin')

@section('title', 'Monitoring Kinerja Global')

@section('content')
    @php
        // Peta nilai -> class Tailwind statis literal (menggantikan bug `bg-${statusColor}-500/20`).
        $skorText = fn($v) => $v >= 80 ? 'text-emerald-400' : ($v >= 70 ? 'text-amber-400' : 'text-rose-400');
        $hadirText = fn($v) => $v >= 80 ? 'text-emerald-400' : ($v >= 70 ? 'text-amber-400' : 'text-rose-400');
        $hadirBar = fn($v) => $v >= 80 ? 'bg-emerald-400' : ($v >= 70 ? 'bg-amber-400' : 'bg-rose-400');
        $badgeKinerja = [
            'baik' => ['class' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30', 'label' => 'Baik'],
            'perhatian' => ['class' => 'bg-amber-500/20 text-amber-400 border-amber-500/30', 'label' => 'Perhatian'],
            'bermasalah' => ['class' => 'bg-rose-500/20 text-rose-400 border-rose-500/30', 'label' => 'Bermasalah'],
        ];
    @endphp

    <x-page-header eyebrow="Panel administrasi" title="Monitoring Kinerja Global" description="Performa seluruh peserta magang Komdigi 2026">
        <form action="{{ route('admin.monitoring.export') }}" method="POST" class="inline-flex">
            @csrf
            <button type="submit" class="ui-button inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                <i data-lucide="download" class="w-4 h-4" aria-hidden="true"></i>
                Export Laporan
            </button>
        </form>
    </x-page-header>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <x-stat-card label="Total Peserta" :value="$kinerjaStats['total']" icon="users" />
        <x-stat-card label="Kinerja Baik" :value="$kinerjaStats['baik']" icon="trending-up" />
        <x-stat-card label="Perlu Perhatian" :value="$kinerjaStats['perhatian']" icon="circle-alert" />
        <x-stat-card label="Bermasalah" :value="$kinerjaStats['bermasalah']" icon="triangle-alert" />
        <x-stat-card label="Rata-rata Skor" :value="$kinerjaStats['rata_skor']" icon="trending-up" />
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap gap-4 text-xs">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-rose-500/40 border-l-2 border-rose-400"></span>
            <span class="text-muted">Bermasalah (skor &lt;70 atau kehadiran &lt;70%)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-amber-500/40 border-l-2 border-amber-400"></span>
            <span class="text-muted">Perlu perhatian (skor 70–79 atau kehadiran 70–79%)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-emerald-500/20"></span>
            <span class="text-muted">Baik (≥80)</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="searchInput">Cari</label>
                <input type="text" id="searchInput" placeholder="Nama / ID..." class="form-input"
                    data-action="filter-table" data-table="kinerjaTable" data-key="search">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterKinerja">Status Kinerja</label>
                <select id="filterKinerja" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="kinerja">
                    <option value="">Semua</option>
                    <option value="baik">Baik</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="bermasalah">Bermasalah</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterStatus">Status Peserta</label>
                <select id="filterStatus" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterPeriode">Periode</label>
                <select id="filterPeriode" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="periode">
                    <option value="">Semua Periode</option>
                    @foreach ($periodeOptions as $kodePer => $namaPer)
                        <option value="{{ $kodePer }}">{{ $namaPer }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="sortBy">Urutkan</label>
                <select id="sortBy" class="form-input" data-action="sort-select" data-table="kinerjaTable">
                    <option value="skor-desc">Skor Tertinggi</option>
                    <option value="skor-asc">Skor Terendah</option>
                    <option value="hadir-desc">Kehadiran Tertinggi</option>
                    <option value="hadir-asc">Kehadiran Terendah</option>
                    <option value="nama-asc">Nama A–Z</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="kinerjaTable">
                <thead>
                    <tr class="border-b border-subtle">
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="nama" data-dir="asc">Peserta</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="skor" data-dir="desc">Skor <span
                                class="text-komdigi-cerulean"><i data-lucide="arrow-up-down" class="w-3.5 h-3.5 inline-block align-middle" aria-hidden="true"></i></span></th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="hadir" data-dir="desc">Kehadiran
                            <span class="text-komdigi-cerulean"><i data-lucide="arrow-up-down" class="w-3.5 h-3.5 inline-block align-middle" aria-hidden="true"></i></span></th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Penilaian</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Pembimbing</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kinerja as $k)
                        @php $badge = $badgeKinerja[$k['kinerja']] ?? $badgeKinerja['baik']; @endphp
                        <tr class="table-row border-b border-subtle {{ $k['row_class'] }}"
                            data-row
                            data-nama="{{ strtolower($k['nama']) }}"
                            data-skor="{{ $k['skor'] }}"
                            data-hadir="{{ $k['hadir'] }}"
                            data-kinerja="{{ $k['kinerja'] }}"
                            data-status="{{ $k['status'] }}"
                            data-periode="{{ $k['periode_key'] }}">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $k['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $k['initial'] }}</div>
                                    <div>
                                        <p class="font-semibold text-foreground">{{ $k['nama'] }}</p>
                                        <p class="text-[11px] text-muted">{{ $k['id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="{{ $skorText($k['skor']) }} font-bold text-base">{{ $k['skor'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="{{ $hadirText($k['hadir']) }} font-bold">{{ $k['hadir'] }}%</span>
                                    <div class="w-14 h-1.5 bg-elevated rounded-full overflow-hidden">
                                        <div class="h-full {{ $hadirBar($k['hadir']) }} rounded-full"
                                            style="width: {{ $k['hadir'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="{{ (float) $k['penilaian'] >= 3.5 ? 'text-amber-400' : 'text-rose-400' }} font-bold">{{ $k['penilaian'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-foreground text-xs">{{ $k['pembimbing'] }}</td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 {{ $badge['class'] }} text-[10px] font-bold rounded-full border">{{ $badge['label'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                @include('layouts.admin.row-actions', ['actions' => [
                                    'detail_modal' => 'modalDetail-' . $k['id'],
                                ]])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-muted">Belum ada data kinerja peserta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination (tampilan statis dari data controller) -->
        <div class="px-4 py-3 border-t border-subtle flex items-center justify-between">
            <p class="text-xs text-muted">Menampilkan {{ $pagination['dari'] }}–{{ $pagination['sampai'] }} dari
                {{ $pagination['total'] }} peserta</p>
            <div class="flex gap-1">
                @for ($i = 1; $i <= $pagination['jumlah_halaman']; $i++)
                    <span
                        class="w-8 h-8 rounded-lg text-xs font-semibold inline-flex items-center justify-center {{ $i === $pagination['halaman_aktif'] ? 'bg-primary text-white' : 'bg-surface text-muted' }}">{{ $i }}</span>
                @endfor
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL: Detail Kinerja (dirender per baris dari data controller, tanpa innerHTML;
         class status memakai peta literal dari PHP — fix bug `bg-${statusColor}-500/20`) -->
    @foreach ($kinerja as $k)
        <div id="modalDetail-{{ $k['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDetail-{{ $k['id'] }}"></div>
            <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-subtle">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-foreground">Detail Kinerja Peserta</h3>
                        <button type="button" data-action="close-modal" data-target="modalDetail-{{ $k['id'] }}"
                            class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                            <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $k['gradient'] }} flex items-center justify-center text-white text-xl font-black">{{ $k['initial'] }}</div>
                        <div>
                            <h4 class="text-xl font-black text-foreground">{{ $k['nama'] }}</h4>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 {{ $k['status_class'] }} text-[11px] font-bold rounded-full mt-1">{{ $k['kinerja_label'] }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-foreground">{{ $k['skor'] }}</p>
                            <p class="text-[11px] text-muted">Skor Kinerja</p>
                        </div>
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-foreground">{{ $k['hadir'] }}%</p>
                            <p class="text-[11px] text-muted">Kehadiran</p>
                        </div>
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-amber-400">{{ $k['penilaian'] }}</p>
                            <p class="text-[11px] text-muted">Penilaian</p>
                        </div>
                    </div>
                    <div class="bg-surface rounded-xl p-4 border border-subtle mb-4">
                        <p class="text-xs font-semibold text-muted mb-3">Rincian Mingguan (Skor)</p>
                        <div class="flex items-end gap-2 h-24">
                            @foreach ($k['weekly_bars'] as $i => $v)
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <span class="text-[10px] text-muted">{{ $v }}</span>
                                    <div class="w-full bg-komdigi-cerulean/80 rounded-t" style="height: {{ $v }}%"></div>
                                    <span class="text-[9px] text-muted">M{{ $i + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">Hadir</p>
                            <p class="text-sm text-foreground font-semibold">{{ $k['hadir_hari'] }} hari</p>
                        </div>
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">Terlambat / Alpha</p>
                            <p class="text-sm text-foreground font-semibold">{{ $k['terlambat'] }} / {{ $k['alpha'] }}</p>
                        </div>
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">Laporan Mingguan</p>
                            <p class="text-sm text-foreground font-semibold">{{ $k['laporan'] }} disetujui</p>
                        </div>
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">Pembimbing</p>
                            <p class="text-sm text-foreground font-semibold">{{ $k['pembimbing_full'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush

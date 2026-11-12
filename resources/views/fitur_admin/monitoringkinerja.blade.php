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

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Monitoring Kinerja Global</h1>
            <p class="text-sm text-blue-100/80 mt-0.5">Performa seluruh peserta magang Komdigi 2026</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <form action="{{ route('admin.monitoring.export') }}" method="POST" class="inline-flex">
                @csrf
                <button type="submit"
                    class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Laporan
                </button>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-white">{{ $kinerjaStats['total'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Total Peserta</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-emerald-400">{{ $kinerjaStats['baik'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Kinerja Baik</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-amber-400">{{ $kinerjaStats['perhatian'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Perlu Perhatian</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-rose-400">{{ $kinerjaStats['bermasalah'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Bermasalah</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-sky-400">{{ $kinerjaStats['rata_skor'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Rata-rata Skor</p>
        </div>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap gap-4 text-xs">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-rose-500/40 border-l-2 border-rose-400"></span>
            <span class="text-slate-400">Bermasalah (skor &lt;70 atau kehadiran &lt;70%)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-amber-500/40 border-l-2 border-amber-400"></span>
            <span class="text-slate-400">Perlu perhatian (skor 70–79 atau kehadiran 70–79%)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-emerald-500/20"></span>
            <span class="text-slate-400">Baik (≥80)</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="searchInput">Cari</label>
                <input type="text" id="searchInput" placeholder="Nama / ID..." class="form-input"
                    data-action="filter-table" data-table="kinerjaTable" data-key="search">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterKinerja">Status Kinerja</label>
                <select id="filterKinerja" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="kinerja">
                    <option value="">Semua</option>
                    <option value="baik">Baik</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="bermasalah">Bermasalah</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterStatus">Status Peserta</label>
                <select id="filterStatus" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterPeriode">Periode</label>
                <select id="filterPeriode" class="form-input" data-action="filter-table" data-table="kinerjaTable"
                    data-key="periode">
                    <option value="">Semua Periode</option>
                    @foreach ($periodeOptions as $kodePer => $namaPer)
                        <option value="{{ $kodePer }}">{{ $namaPer }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="sortBy">Urutkan</label>
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
                    <tr class="border-b border-white/10">
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="nama" data-dir="asc">Peserta</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="skor" data-dir="desc">Skor <span
                                class="text-komdigi-cerulean">↕</span></th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider sort-btn"
                            data-action="sort-table" data-table="kinerjaTable" data-key="hadir" data-dir="desc">Kehadiran
                            <span class="text-komdigi-cerulean">↕</span></th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Penilaian</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kinerja as $k)
                        @php $badge = $badgeKinerja[$k['kinerja']] ?? $badgeKinerja['baik']; @endphp
                        <tr class="table-row border-b border-white/5 {{ $k['row_class'] }}"
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
                                        <p class="font-semibold text-white">{{ $k['nama'] }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $k['id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="{{ $skorText($k['skor']) }} font-bold text-base">{{ $k['skor'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="{{ $hadirText($k['hadir']) }} font-bold">{{ $k['hadir'] }}%</span>
                                    <div class="w-14 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full {{ $hadirBar($k['hadir']) }} rounded-full"
                                            style="width: {{ $k['hadir'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="{{ (float) $k['penilaian'] >= 3.5 ? 'text-amber-400' : 'text-rose-400' }} font-bold">{{ $k['penilaian'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-300 text-xs">{{ $k['pembimbing'] }}</td>
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
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data kinerja peserta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination (tampilan statis dari data controller) -->
        <div class="px-4 py-3 border-t border-white/10 flex items-center justify-between">
            <p class="text-xs text-slate-400">Menampilkan {{ $pagination['dari'] }}–{{ $pagination['sampai'] }} dari
                {{ $pagination['total'] }} peserta</p>
            <div class="flex gap-1">
                @for ($i = 1; $i <= $pagination['jumlah_halaman']; $i++)
                    <span
                        class="w-8 h-8 rounded-lg text-xs font-semibold inline-flex items-center justify-center {{ $i === $pagination['halaman_aktif'] ? 'bg-komdigi-blue/30 text-white' : 'bg-white/5 text-slate-400' }}">{{ $i }}</span>
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
            <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-white">Detail Kinerja Peserta</h3>
                        <button type="button" data-action="close-modal" data-target="modalDetail-{{ $k['id'] }}"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $k['gradient'] }} flex items-center justify-center text-white text-xl font-black">{{ $k['initial'] }}</div>
                        <div>
                            <h4 class="text-xl font-black text-white">{{ $k['nama'] }}</h4>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 {{ $k['status_class'] }} text-[11px] font-bold rounded-full mt-1">{{ $k['kinerja_label'] }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-white">{{ $k['skor'] }}</p>
                            <p class="text-[11px] text-slate-400">Skor Kinerja</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-white">{{ $k['hadir'] }}%</p>
                            <p class="text-[11px] text-slate-400">Kehadiran</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-amber-400">{{ $k['penilaian'] }}</p>
                            <p class="text-[11px] text-slate-400">Penilaian</p>
                        </div>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 mb-4">
                        <p class="text-xs font-semibold text-slate-400 mb-3">Rincian Mingguan (Skor)</p>
                        <div class="flex items-end gap-2 h-24">
                            @foreach ($k['weekly_bars'] as $i => $v)
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <span class="text-[10px] text-slate-400">{{ $v }}</span>
                                    <div class="w-full bg-komdigi-cerulean/80 rounded-t" style="height: {{ $v }}%"></div>
                                    <span class="text-[9px] text-slate-500">M{{ $i + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">Hadir</p>
                            <p class="text-sm text-white font-semibold">{{ $k['hadir_hari'] }} hari</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">Terlambat / Alpha</p>
                            <p class="text-sm text-white font-semibold">{{ $k['terlambat'] }} / {{ $k['alpha'] }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">Laporan Mingguan</p>
                            <p class="text-sm text-white font-semibold">{{ $k['laporan'] }} disetujui</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">Pembimbing</p>
                            <p class="text-sm text-white font-semibold">{{ $k['pembimbing_full'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush

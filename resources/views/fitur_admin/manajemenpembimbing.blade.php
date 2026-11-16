@extends('layouts.admin')

@section('title', 'Manajemen Pembimbing')

@section('content')
    @php
        // Peta status/beban -> class Tailwind statis (tanpa perakitan class dinamis).
        $statusBadges = [
            'aktif' => ['class' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30', 'dot' => 'bg-emerald-400', 'label' => 'Aktif'],
            'nonaktif' => ['class' => 'bg-elevated text-muted border-subtle', 'dot' => '', 'label' => 'Nonaktif'],
        ];
    @endphp

    <x-page-header eyebrow="Panel administrasi" title="Manajemen Pembimbing" description="Kelola data pembimbing lapangan magang Komdigi 2026">
        <button type="button" data-action="open-modal" data-target="modalPembimbing"
            data-modal-title="Tambah Pembimbing"
            class="ui-button inline-flex items-center gap-2 px-4 py-2.5 text-sm">
            <i data-lucide="plus" class="w-4 h-4" aria-hidden="true"></i>
            Tambah Pembimbing
        </button>
    </x-page-header>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stat-card label="Total Pembimbing" :value="$pembimbingStats['total']" icon="users-round" />
        <x-stat-card label="Aktif" :value="$pembimbingStats['aktif']" icon="user-check" />
        <x-stat-card label="Peserta Dibimbing" :value="$pembimbingStats['peserta_dibimbing']" icon="user-round-check" />
        <x-stat-card label="Rata-rata Skor" :value="$pembimbingStats['rata_skor']" icon="trending-up" />
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="searchInput">Cari</label>
                <input type="text" id="searchInput" placeholder="Nama / NIP / Email..." class="form-input"
                    data-action="filter-table" data-table="pembimbingTable" data-key="search">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterUnit">Unit Kerja</label>
                <select id="filterUnit" class="form-input" data-action="filter-table" data-table="pembimbingTable"
                    data-key="unit">
                    <option value="">Semua Unit</option>
                    @foreach ($unitOptions as $key => $unit)
                        <option value="{{ $key }}">{{ $unit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterStatus">Status</label>
                <select id="filterStatus" class="form-input" data-action="filter-table" data-table="pembimbingTable"
                    data-key="status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterBeban">Beban Bimbingan</label>
                <select id="filterBeban" class="form-input" data-action="filter-table" data-table="pembimbingTable"
                    data-key="beban">
                    <option value="">Semua</option>
                    <option value="rendah">0–3 peserta</option>
                    <option value="sedang">4–6 peserta</option>
                    <option value="tinggi">7+ peserta</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="pembimbingTable">
                <thead>
                    <tr class="border-b border-subtle">
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Pembimbing</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">NIP / Unit</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Peserta</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Rata-rata Skor</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-muted uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembimbing as $p)
                        @php $badge = $statusBadges[$p['status']] ?? $statusBadges['nonaktif']; @endphp
                        <tr class="table-row border-b border-subtle {{ $p['status'] === 'nonaktif' ? 'opacity-60' : '' }}"
                            data-row
                            data-unit="{{ $p['unit_key'] }}"
                            data-status="{{ $p['status'] }}"
                            data-beban="{{ $p['beban_key'] }}">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['initial'] }}</div>
                                    <div>
                                        <p class="font-semibold text-foreground">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-muted">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-foreground text-xs">{{ $p['nip'] }}</p>
                                <p class="text-[11px] text-muted">{{ $p['unit'] }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $p['jumlah_peserta'] > 0 ? 'bg-komdigi-blue/20 text-komdigi-cerulean' : 'bg-elevated text-muted' }} text-sm font-bold">{{ $p['jumlah_peserta'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                @if ($p['jumlah_peserta'] > 0)
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="text-amber-400 font-bold">{{ $p['skor'] }}</span>
                                        <div class="w-16 h-1.5 bg-elevated rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full"
                                                style="width: {{ $p['skor_persen'] }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 {{ $badge['class'] }} text-[11px] font-bold rounded-full border">
                                    @if ($badge['dot'])
                                        <span class="w-1.5 h-1.5 {{ $badge['dot'] }} rounded-full"></span>
                                    @endif
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @include('layouts.admin.row-actions', ['actions' => [
                                    'detail_modal' => 'modalDetail-' . $p['id'],
                                    'edit_modal' => 'modalPembimbing',
                                    'edit_title' => 'Edit Pembimbing – ' . $p['nama'],
                                    'edit_fields' => $p['form'],
                                    'assign_modal' => 'modalAssign-' . $p['id'],
                                    'assign_title' => 'Assign / Unassign Peserta',
                                    'assign_desc' => $p['nama'],
                                    'form_field' => 'pembimbing_id',
                                    'form_value' => $p['id'],
                                    'toggle_url' => route('admin.pembimbing.toggle'),
                                    'toggle_id' => $p['id'],
                                    'toggle_active' => $p['status'] === 'aktif',
                                    'delete_url' => route('admin.pembimbing.delete'),
                                    'delete_label' => $p['nama'] . ' (' . $p['id'] . ')',
                                ]])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-muted">Belum ada data pembimbing</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination (tampilan statis dari data controller) -->
        <div class="px-4 py-3 border-t border-subtle flex items-center justify-between">
            <p class="text-xs text-muted">Menampilkan {{ $pagination['dari'] }}–{{ $pagination['sampai'] }} dari
                {{ $pagination['total'] }} pembimbing</p>
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
    <!-- MODAL: Tambah / Edit Pembimbing -->
    <div id="modalPembimbing" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalPembimbing"></div>
        <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-subtle">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-foreground" data-modal-title-slot>Tambah Pembimbing</h3>
                    <button type="button" data-action="close-modal" data-target="modalPembimbing"
                        class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                        <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.pembimbing.store') }}" data-modal-form>
                    @csrf
                    {{-- Kode pembimbing (PMB-…). Kosong = tambah baru; terisi = edit. --}}
                    <input type="hidden" name="id" value="{{ old('id') }}">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingNama">Nama Lengkap &amp; Gelar</label>
                            <input type="text" id="pembimbingNama" name="nama" class="form-input"
                                placeholder="Contoh: Budi Santoso, S.Kom" value="{{ old('nama') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingNip">NIP</label>
                            <input type="text" id="pembimbingNip" name="nip" class="form-input" placeholder="NIP"
                                value="{{ old('nip') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingEmail">Email</label>
                            <input type="email" id="pembimbingEmail" name="email" class="form-input"
                                placeholder="email@example.com" value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingHp">No. HP</label>
                            <input type="tel" id="pembimbingHp" name="hp" class="form-input" placeholder="08xxxxxxxxxx"
                                value="{{ old('hp') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingUnit">Unit Kerja</label>
                            <select id="pembimbingUnit" name="unit" class="form-input" required>
                                <option value="">Pilih unit</option>
                                @foreach ($unitOptions as $key => $unit)
                                    <option value="{{ $unit }}" @selected(old('unit') === $unit)>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingJabatan">Jabatan</label>
                            <input type="text" id="pembimbingJabatan" name="jabatan" class="form-input"
                                placeholder="Contoh: Analis Kebijakan" value="{{ old('jabatan') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="pembimbingStatus">Status</label>
                            <select id="pembimbingStatus" name="status" class="form-input" required>
                                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" data-action="close-modal" data-target="modalPembimbing"
                            class="flex-1 py-3 ui-button-secondary text-sm">Batal</button>
                        <button type="submit"
                            class="ui-button flex-1 py-3 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail & Performa (dirender per baris dari data controller, tanpa innerHTML) -->
    @foreach ($pembimbing as $p)
        @php
            $performa = $p['jumlah_peserta'] === 0 ? '—' : ((float) $p['skor'] >= 4.3 ? 'Baik' : ((float) $p['skor'] >= 4 ? 'Cukup' : '—'));
            $idAssign = 'modalAssign-' . $p['id'];
        @endphp

        <!-- MODAL: Assign / Unassign Peserta (per pembimbing) -->
        <div id="{{ $idAssign }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="{{ $idAssign }}"></div>
            <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-subtle">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-black text-foreground" data-modal-title-slot>Assign / Unassign Peserta</h3>
                        <button type="button" data-action="close-modal" data-target="{{ $idAssign }}"
                            class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                            <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                        </button>
                    </div>
                    <p class="text-sm text-muted mb-4">Pembimbing: <span data-modal-desc-slot
                            class="text-foreground font-semibold">{{ $p['nama'] }}</span></p>

                    <div class="mb-4">
                        <p class="text-xs font-semibold text-muted mb-2">Peserta yang dibimbing saat ini</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @forelse ($p['terassign'] as $ps)
                                <form method="POST" action="{{ route('admin.pembimbing.unassign') }}"
                                    class="flex items-center justify-between bg-surface rounded-xl px-3 py-2 border border-subtle">
                                    @csrf
                                    <input type="hidden" name="pembimbing_id" value="{{ $p['id'] }}">
                                    <input type="hidden" name="peserta_id" value="{{ $ps['id'] }}">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">{{ strtoupper(substr($ps['nama'], 0, 2)) }}</div>
                                        <span class="text-sm text-foreground">{{ $ps['nama'] }}</span>
                                    </div>
                                    <button type="submit"
                                        class="text-xs text-rose-400 hover:text-rose-300 font-semibold">Unassign</button>
                                </form>
                            @empty
                                <p class="text-xs text-muted bg-surface rounded-xl px-3 py-2 border border-subtle">Belum
                                    ada peserta yang di-assign.</p>
                            @endforelse
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.pembimbing.assign') }}" data-modal-form>
                        @csrf
                        <input type="hidden" name="pembimbing_id" value="{{ $p['id'] }}">
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="assignPeserta-{{ $p['id'] }}">Tambah Peserta</label>
                            <select id="assignPeserta-{{ $p['id'] }}" name="peserta_id" class="form-input" required>
                                <option value="">Pilih peserta yang belum di-assign</option>
                                @foreach ($p['tersedia'] as $ps)
                                    <option value="{{ $ps['id'] }}">{{ $ps['nama'] }} – {{ $ps['id'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" data-action="close-modal" data-target="{{ $idAssign }}"
                                class="flex-1 py-3 ui-button-secondary text-sm">Batal</button>
                            <button type="submit"
                                class="ui-button flex-1 py-3 text-white text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="modalDetail-{{ $p['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"></div>
            <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-subtle">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-foreground">Detail &amp; Performa Pembimbing</h3>
                        <button type="button" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"
                            class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                            <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xl font-black">{{ $p['initial'] }}</div>
                        <div>
                            <h4 class="text-xl font-black text-foreground">{{ $p['nama'] }}</h4>
                            <p class="text-sm text-muted">{{ $p['unit'] }} · {{ ucfirst($p['status']) }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-komdigi-cerulean">{{ $p['jumlah_peserta'] }}</p>
                            <p class="text-[11px] text-muted">Peserta Dibimbing</p>
                        </div>
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-amber-400">{{ $p['jumlah_peserta'] > 0 ? $p['skor'] : '—' }}</p>
                            <p class="text-[11px] text-muted">Rata-rata Skor</p>
                        </div>
                        <div class="bg-surface rounded-xl p-4 border border-subtle text-center">
                            <p class="text-2xl font-black text-emerald-400">{{ $performa }}</p>
                            <p class="text-[11px] text-muted">Performa</p>
                        </div>
                    </div>
                    <div class="bg-surface rounded-xl p-4 border border-subtle mb-4">
                        <p class="text-xs font-semibold text-muted mb-3">Daftar Peserta yang Dibimbing</p>
                        <div class="space-y-2">
                            @forelse ($p['bimbingan'] as $b)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">{{ $b['initial'] }}</div>
                                        <span class="text-sm text-foreground">{{ $b['nama'] }}</span>
                                    </div>
                                    <span class="text-xs text-amber-400 font-bold">{{ $b['skor'] }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-muted">Belum ada peserta yang dibimbing.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">Email</p>
                            <p class="text-sm text-foreground">{{ $p['email'] }}</p>
                        </div>
                        <div class="bg-surface rounded-xl p-3 border border-subtle">
                            <p class="text-[11px] text-muted">NIP</p>
                            <p class="text-sm text-foreground">{{ $p['nip'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('layouts.admin.modal-delete', [
        'route' => route('admin.pembimbing.delete'),
        'field' => 'id',
        'label' => 'pembimbing',
    ])
@endpush

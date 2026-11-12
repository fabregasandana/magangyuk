@extends('layouts.admin')

@section('title', 'Manajemen Pembimbing')

@section('content')
    @php
        // Peta status/beban -> class Tailwind statis (tanpa perakitan class dinamis).
        $statusBadges = [
            'aktif' => ['class' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30', 'dot' => 'bg-emerald-400', 'label' => 'Aktif'],
            'nonaktif' => ['class' => 'bg-slate-500/20 text-slate-400 border-slate-500/30', 'dot' => '', 'label' => 'Nonaktif'],
        ];
    @endphp

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Manajemen Pembimbing</h1>
            <p class="text-sm text-blue-100/80 mt-0.5">Kelola data pembimbing lapangan magang Komdigi 2026</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" data-action="open-modal" data-target="modalPembimbing"
                data-modal-title="Tambah Pembimbing"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pembimbing
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-white">{{ $pembimbingStats['total'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Total Pembimbing</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-emerald-400">{{ $pembimbingStats['aktif'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Aktif</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-sky-400">{{ $pembimbingStats['peserta_dibimbing'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Peserta Dibimbing</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-amber-400">{{ $pembimbingStats['rata_skor'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Rata-rata Skor</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="searchInput">Cari</label>
                <input type="text" id="searchInput" placeholder="Nama / NIP / Email..." class="form-input"
                    data-action="filter-table" data-table="pembimbingTable" data-key="search">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterUnit">Unit Kerja</label>
                <select id="filterUnit" class="form-input" data-action="filter-table" data-table="pembimbingTable"
                    data-key="unit">
                    <option value="">Semua Unit</option>
                    @foreach ($unitOptions as $key => $unit)
                        <option value="{{ $key }}">{{ $unit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterStatus">Status</label>
                <select id="filterStatus" class="form-input" data-action="filter-table" data-table="pembimbingTable"
                    data-key="status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterBeban">Beban Bimbingan</label>
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
                    <tr class="border-b border-white/10">
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">NIP / Unit</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                        <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Skor</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembimbing as $p)
                        @php $badge = $statusBadges[$p['status']] ?? $statusBadges['nonaktif']; @endphp
                        <tr class="table-row border-b border-white/5 {{ $p['status'] === 'nonaktif' ? 'opacity-60' : '' }}"
                            data-row
                            data-unit="{{ $p['unit_key'] }}"
                            data-status="{{ $p['status'] }}"
                            data-beban="{{ $p['beban_key'] }}">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['initial'] }}</div>
                                    <div>
                                        <p class="font-semibold text-white">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-slate-300 text-xs">{{ $p['nip'] }}</p>
                                <p class="text-[11px] text-slate-400">{{ $p['unit'] }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg {{ $p['jumlah_peserta'] > 0 ? 'bg-komdigi-blue/20 text-komdigi-cerulean' : 'bg-white/10 text-slate-400' }} text-sm font-bold">{{ $p['jumlah_peserta'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                @if ($p['jumlah_peserta'] > 0)
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="text-amber-400 font-bold">{{ $p['skor'] }}</span>
                                        <div class="w-16 h-1.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full"
                                                style="width: {{ $p['skor_persen'] }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-500 text-sm">—</span>
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
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data pembimbing</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination (tampilan statis dari data controller) -->
        <div class="px-4 py-3 border-t border-white/10 flex items-center justify-between">
            <p class="text-xs text-slate-400">Menampilkan {{ $pagination['dari'] }}–{{ $pagination['sampai'] }} dari
                {{ $pagination['total'] }} pembimbing</p>
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
    <!-- MODAL: Tambah / Edit Pembimbing -->
    <div id="modalPembimbing" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalPembimbing"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah Pembimbing</h3>
                    <button type="button" data-action="close-modal" data-target="modalPembimbing"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.pembimbing.store') }}" data-modal-form>
                    @csrf
                    {{-- Kode pembimbing (PMB-…). Kosong = tambah baru; terisi = edit. --}}
                    <input type="hidden" name="id" value="{{ old('id') }}">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingNama">Nama Lengkap &amp; Gelar</label>
                            <input type="text" id="pembimbingNama" name="nama" class="form-input"
                                placeholder="Contoh: Budi Santoso, S.Kom" value="{{ old('nama') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingNip">NIP</label>
                            <input type="text" id="pembimbingNip" name="nip" class="form-input" placeholder="NIP"
                                value="{{ old('nip') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingEmail">Email</label>
                            <input type="email" id="pembimbingEmail" name="email" class="form-input"
                                placeholder="email@example.com" value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingHp">No. HP</label>
                            <input type="tel" id="pembimbingHp" name="hp" class="form-input" placeholder="08xxxxxxxxxx"
                                value="{{ old('hp') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingUnit">Unit Kerja</label>
                            <select id="pembimbingUnit" name="unit" class="form-input" required>
                                <option value="">Pilih unit</option>
                                @foreach ($unitOptions as $key => $unit)
                                    <option value="{{ $unit }}" @selected(old('unit') === $unit)>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingJabatan">Jabatan</label>
                            <input type="text" id="pembimbingJabatan" name="jabatan" class="form-input"
                                placeholder="Contoh: Analis Kebijakan" value="{{ old('jabatan') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pembimbingStatus">Status</label>
                            <select id="pembimbingStatus" name="status" class="form-input" required>
                                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" data-action="close-modal" data-target="modalPembimbing"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Simpan</button>
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
            <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-white/15">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-black text-white" data-modal-title-slot>Assign / Unassign Peserta</h3>
                        <button type="button" data-action="close-modal" data-target="{{ $idAssign }}"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-slate-400 mb-4">Pembimbing: <span data-modal-desc-slot
                            class="text-white font-semibold">{{ $p['nama'] }}</span></p>

                    <div class="mb-4">
                        <p class="text-xs font-semibold text-slate-400 mb-2">Peserta yang dibimbing saat ini</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @forelse ($p['terassign'] as $ps)
                                <form method="POST" action="{{ route('admin.pembimbing.unassign') }}"
                                    class="flex items-center justify-between bg-white/5 rounded-xl px-3 py-2 border border-white/10">
                                    @csrf
                                    <input type="hidden" name="pembimbing_id" value="{{ $p['id'] }}">
                                    <input type="hidden" name="peserta_id" value="{{ $ps['id'] }}">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">{{ strtoupper(substr($ps['nama'], 0, 2)) }}</div>
                                        <span class="text-sm text-white">{{ $ps['nama'] }}</span>
                                    </div>
                                    <button type="submit"
                                        class="text-xs text-rose-400 hover:text-rose-300 font-semibold">Unassign</button>
                                </form>
                            @empty
                                <p class="text-xs text-slate-500 bg-white/5 rounded-xl px-3 py-2 border border-white/10">Belum
                                    ada peserta yang di-assign.</p>
                            @endforelse
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.pembimbing.assign') }}" data-modal-form>
                        @csrf
                        <input type="hidden" name="pembimbing_id" value="{{ $p['id'] }}">
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="assignPeserta-{{ $p['id'] }}">Tambah Peserta</label>
                            <select id="assignPeserta-{{ $p['id'] }}" name="peserta_id" class="form-input" required>
                                <option value="">Pilih peserta yang belum di-assign</option>
                                @foreach ($p['tersedia'] as $ps)
                                    <option value="{{ $ps['id'] }}">{{ $ps['nama'] }} – {{ $ps['id'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" data-action="close-modal" data-target="{{ $idAssign }}"
                                class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                            <button type="submit"
                                class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="modalDetail-{{ $p['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"></div>
            <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-white">Detail &amp; Performa Pembimbing</h3>
                        <button type="button" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xl font-black">{{ $p['initial'] }}</div>
                        <div>
                            <h4 class="text-xl font-black text-white">{{ $p['nama'] }}</h4>
                            <p class="text-sm text-slate-400">{{ $p['unit'] }} · {{ ucfirst($p['status']) }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-komdigi-cerulean">{{ $p['jumlah_peserta'] }}</p>
                            <p class="text-[11px] text-slate-400">Peserta Dibimbing</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-amber-400">{{ $p['jumlah_peserta'] > 0 ? $p['skor'] : '—' }}</p>
                            <p class="text-[11px] text-slate-400">Rata-rata Skor</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                            <p class="text-2xl font-black text-emerald-400">{{ $performa }}</p>
                            <p class="text-[11px] text-slate-400">Performa</p>
                        </div>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10 mb-4">
                        <p class="text-xs font-semibold text-slate-400 mb-3">Daftar Peserta yang Dibimbing</p>
                        <div class="space-y-2">
                            @forelse ($p['bimbingan'] as $b)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-komdigi-blue/30 flex items-center justify-center text-[10px] font-bold text-white">{{ $b['initial'] }}</div>
                                        <span class="text-sm text-white">{{ $b['nama'] }}</span>
                                    </div>
                                    <span class="text-xs text-amber-400 font-bold">{{ $b['skor'] }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-500">Belum ada peserta yang dibimbing.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">Email</p>
                            <p class="text-sm text-white">{{ $p['email'] }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-[11px] text-slate-400">NIP</p>
                            <p class="text-sm text-white">{{ $p['nip'] }}</p>
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

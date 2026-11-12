@extends('layouts.admin')

@section('title', 'Manajemen Peserta')

@section('content')
    @php
        // Peta status -> class Tailwind statis (tanpa perakitan class dinamis).
        $statusBadges = [
            'aktif' => ['class' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30', 'dot' => 'bg-emerald-400', 'label' => 'Aktif'],
            'nonaktif' => ['class' => 'bg-slate-500/20 text-slate-400 border-slate-500/30', 'dot' => '', 'label' => 'Nonaktif'],
            'selesai' => ['class' => 'bg-sky-500/20 text-sky-400 border-sky-500/30', 'dot' => 'bg-sky-400', 'label' => 'Selesai'],
        ];
    @endphp

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Manajemen Peserta</h1>
            <p class="text-sm text-blue-100/80 mt-0.5">Kelola data peserta magang Komdigi 2026</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" data-action="open-modal" data-target="modalImport"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Excel
            </button>
            <form action="{{ route('admin.peserta.export') }}" method="POST" class="inline-flex">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </form>
            <button type="button" data-action="open-modal" data-target="modalPeserta" data-modal-title="Tambah Peserta"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Peserta
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-white">{{ $pesertaStats['total'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Total Peserta</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-emerald-400">{{ $pesertaStats['aktif'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Aktif</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-amber-400">{{ $pesertaStats['nonaktif'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Nonaktif</p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <p class="text-3xl font-black text-sky-400">{{ $pesertaStats['selesai'] }}</p>
            <p class="text-xs font-semibold text-slate-400 mt-1">Selesai</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="searchInput">Cari</label>
                <input type="text" id="searchInput" placeholder="Nama / ID / NIM..." class="form-input"
                    data-action="filter-table" data-table="pesertaTable" data-key="search">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterInstitusi">Institusi</label>
                <select id="filterInstitusi" class="form-input" data-action="filter-table" data-table="pesertaTable"
                    data-key="institusi">
                    <option value="">Semua Institusi</option>
                    @foreach ($institusiOptions as $kode => $namaIns)
                        <option value="{{ $kode }}">{{ $namaIns }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterPeriode">Periode</label>
                <select id="filterPeriode" class="form-input" data-action="filter-table" data-table="pesertaTable"
                    data-key="periode">
                    <option value="">Semua Periode</option>
                    @foreach ($periodeOptions as $kodePeriode => $namaPeriode)
                        <option value="{{ $kodePeriode }}">{{ $namaPeriode }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterStatus">Status</label>
                <select id="filterStatus" class="form-input" data-action="filter-table" data-table="pesertaTable"
                    data-key="status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterPembimbing">Pembimbing</label>
                <select id="filterPembimbing" class="form-input" data-action="filter-table" data-table="pesertaTable"
                    data-key="pembimbing">
                    <option value="">Semua Pembimbing</option>
                    @foreach ($pembimbingOptions as $key => $nama)
                        <option value="{{ $key }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="pesertaTable">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">ID / NIM</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Institusi</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pembimbing</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Periode</th>
                        <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta as $p)
                        @php $badge = $statusBadges[$p['status']] ?? $statusBadges['nonaktif']; @endphp
                        <tr class="table-row border-b border-white/5 {{ $p['status'] === 'nonaktif' ? 'opacity-60' : '' }}"
                            data-row
                            data-institusi="{{ $p['institusi_key'] }}"
                            data-status="{{ $p['status'] }}"
                            data-pembimbing="{{ $p['pembimbing_key'] }}"
                            data-periode="{{ $p['periode_key'] }}">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['initial'] }}</div>
                                    <div>
                                        <p class="font-semibold text-white">{{ $p['nama'] }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-komdigi-cerulean font-semibold">{{ $p['id'] }}</p>
                                <p class="text-[11px] text-slate-400">{{ $p['nim'] }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-slate-300">{{ $p['institusi'] }}</td>
                            <td class="px-4 py-3.5 text-slate-300">{{ $p['pembimbing'] }}</td>
                            <td class="px-4 py-3.5 text-slate-300">{{ $p['periode'] }}</td>
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
                                    'edit_modal' => 'modalPeserta',
                                    'edit_title' => 'Edit Peserta – ' . $p['nama'],
                                    'edit_fields' => $p['form'],
                                    'assign_modal' => 'modalAssign',
                                    'assign_title' => 'Assign / Ganti Pembimbing',
                                    'form_field' => 'peserta_id',
                                    'form_value' => $p['id'],
                                    'toggle_url' => route('admin.peserta.toggle'),
                                    'toggle_id' => $p['id'],
                                    'toggle_active' => $p['status'] === 'aktif',
                                    'delete_url' => route('admin.peserta.delete'),
                                    'delete_label' => $p['nama'] . ' (' . $p['id'] . ')',
                                ]])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data peserta</td>
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
    <!-- MODAL: Tambah / Edit Peserta -->
    <div id="modalPeserta" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalPeserta"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah Peserta</h3>
                    <button type="button" data-action="close-modal" data-target="modalPeserta"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.peserta.store') }}" data-modal-form>
                    @csrf
                    {{-- Kode peserta (MKD-…). Kosong = tambah baru; terisi = edit. --}}
                    <input type="hidden" name="id" value="{{ old('id') }}">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaNama">Nama Lengkap</label>
                            <input type="text" id="pesertaNama" name="nama" class="form-input" placeholder="Nama lengkap"
                                value="{{ old('nama') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaNim">NIM / NIS</label>
                            <input type="text" id="pesertaNim" name="nim" class="form-input" placeholder="NIM"
                                value="{{ old('nim') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaEmail">Email</label>
                            <input type="email" id="pesertaEmail" name="email" class="form-input" placeholder="email@example.com"
                                value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaHp">No. HP</label>
                            <input type="tel" id="pesertaHp" name="hp" class="form-input" placeholder="08xxxxxxxxxx"
                                value="{{ old('hp') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaNik">NIK</label>
                            <input type="text" id="pesertaNik" name="nik" class="form-input" placeholder="16 digit NIK"
                                maxlength="20" value="{{ old('nik') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaJk">Jenis Kelamin</label>
                            <select id="pesertaJk" name="jenis_kelamin" class="form-input" required>
                                <option value="L" @selected(old('jenis_kelamin', 'L') === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaTempatLahir">Tempat Lahir</label>
                            <input type="text" id="pesertaTempatLahir" name="tempat_lahir" class="form-input" placeholder="Contoh: Medan"
                                value="{{ old('tempat_lahir') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaTanggalLahir">Tanggal Lahir</label>
                            <input type="date" id="pesertaTanggalLahir" name="tanggal_lahir" class="form-input"
                                value="{{ old('tanggal_lahir') }}">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaAlamat">Alamat</label>
                            <input type="text" id="pesertaAlamat" name="alamat" class="form-input" placeholder="Alamat domisili"
                                value="{{ old('alamat') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaInstitusi">Institusi</label>
                            <select id="pesertaInstitusi" name="institusi" class="form-input" required>
                                <option value="">Pilih institusi</option>
                                @foreach ($institusiOptions as $kodeIns => $namaIns)
                                    <option value="{{ $kodeIns }}" @selected(old('institusi') === $kodeIns)>{{ $namaIns }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaProdi">Program Studi</label>
                            <input type="text" id="pesertaProdi" name="prodi" class="form-input" placeholder="Contoh: Ilmu Komputer"
                                value="{{ old('prodi') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaPembimbing">Pembimbing</label>
                            <select id="pesertaPembimbing" name="pembimbing" class="form-input">
                                <option value="">Pilih pembimbing</option>
                                @foreach ($pembimbingOptions as $kodePmb => $namaPmb)
                                    <option value="{{ $kodePmb }}" @selected(old('pembimbing') === $kodePmb)>{{ $namaPmb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaPeriode">Periode</label>
                            <select id="pesertaPeriode" name="periode" class="form-input" required>
                                <option value="">Pilih periode</option>
                                @foreach ($periodeOptions as $kodePer => $namaPer)
                                    <option value="{{ $kodePer }}" @selected(old('periode') === $kodePer)>{{ $namaPer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pesertaStatus">Status</label>
                            <select id="pesertaStatus" name="status" class="form-input" required>
                                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                                <option value="selesai" @selected(old('status') === 'selesai')>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" data-action="close-modal" data-target="modalPeserta"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Assign Pembimbing -->
    <div id="modalAssign" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalAssign"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Assign / Ganti Pembimbing</h3>
                    <button type="button" data-action="close-modal" data-target="modalAssign"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.peserta.assign') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="peserta_id" value="">
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="assignPembimbing">Pilih Pembimbing</label>
                        <select id="assignPembimbing" name="pembimbing" class="form-input" required>
                            <option value="">Pilih pembimbing</option>
                            @foreach ($pembimbingOptions as $kodePmb => $namaPmb)
                                <option value="{{ $kodePmb }}">{{ $namaPmb }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" data-action="close-modal" data-target="modalAssign"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Import Excel -->
    <div id="modalImport" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalImport"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Import Data Peserta</h3>
                    <button type="button" data-action="close-modal" data-target="modalImport"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.peserta.import') }}" enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <p class="text-sm text-slate-400 mb-4">Upload file Excel (.xlsx) berisi data peserta. Pastikan format kolom
                        sesuai template.</p>
                    <label
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/15 rounded-2xl cursor-pointer bg-white/5 hover:border-komdigi-cerulean/40 transition mb-4">
                        <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-slate-400"><span class="font-semibold text-komdigi-cerulean">Pilih file Excel</span></p>
                        <p class="text-xs text-slate-500 mt-0.5">.xlsx, max 5MB</p>
                        <input type="file" name="file" class="hidden" accept=".xlsx,.xls" required>
                    </label>
                    <div class="flex gap-3">
                        <button type="button" data-action="close-modal" data-target="modalImport"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail Peserta (dirender per baris dari data controller, tanpa innerHTML) -->
    @foreach ($peserta as $p)
        @php $badge = $statusBadges[$p['status']] ?? $statusBadges['nonaktif']; @endphp
        <div id="modalDetail-{{ $p['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"></div>
            <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto border border-white/15">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-white">Detail Peserta</h3>
                        <button type="button" data-action="close-modal" data-target="modalDetail-{{ $p['id'] }}"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-5">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $p['gradient'] }} flex items-center justify-center text-white text-xl font-black">{{ $p['initial'] }}</div>
                            <div>
                                <h4 class="text-xl font-black text-white">{{ $p['nama'] }}</h4>
                                <p class="text-sm text-slate-400">{{ $p['id'] }} · {{ $badge['label'] }}</p>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <p class="text-[11px] font-semibold text-slate-400 mb-1">Email</p>
                                <p class="text-sm text-white">{{ $p['email'] }}</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <p class="text-[11px] font-semibold text-slate-400 mb-1">No. HP</p>
                                <p class="text-sm text-white">{{ $p['hp'] }}</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <p class="text-[11px] font-semibold text-slate-400 mb-1">Institusi</p>
                                <p class="text-sm text-white">{{ $p['institusi'] }}</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                                <p class="text-[11px] font-semibold text-slate-400 mb-1">Pembimbing</p>
                                <p class="text-sm text-white">{{ $p['pembimbing'] }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3 mt-2">
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                                <p class="text-2xl font-black text-emerald-400">{{ $p['hadir'] }}</p>
                                <p class="text-[11px] text-slate-400">Hadir</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                                <p class="text-2xl font-black text-komdigi-cerulean">{{ $p['skor'] }}</p>
                                <p class="text-[11px] text-slate-400">Skor Kinerja</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/10 text-center">
                                <p class="text-2xl font-black text-amber-400">{{ $p['penilaian'] }}</p>
                                <p class="text-[11px] text-slate-400">Penilaian</p>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('admin.monitoring') }}"
                                class="flex-1 py-2.5 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 text-center">Lihat
                                Kehadiran</a>
                            <a href="{{ route('admin.kelola-penilaian') }}"
                                class="flex-1 py-2.5 bg-white/10 text-slate-300 text-sm font-semibold rounded-xl hover:bg-white/15 border border-white/10 text-center">Lihat
                                Penilaian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('layouts.admin.modal-delete', [
        'route' => route('admin.peserta.delete'),
        'field' => 'id',
        'label' => 'peserta',
    ])
@endpush

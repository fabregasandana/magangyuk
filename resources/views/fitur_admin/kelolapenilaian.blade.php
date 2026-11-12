@extends('layouts.admin')

@section('title', 'Kelola Penilaian')

@section('content')
    @php
        // Peta jenis audit -> warna kotak & ikon (class statis, tanpa perakitan dinamis).
        $auditIcons = [
            'koreksi' => ['box' => 'bg-amber-500/20', 'icon' => 'text-amber-400'],
            'tambah' => ['box' => 'bg-emerald-500/20', 'icon' => 'text-emerald-400'],
            'bobot' => ['box' => 'bg-sky-500/20', 'icon' => 'text-sky-400'],
        ];
        // Warna bar rincian pada modal detail (mengikuti urutan kriteria mockup).
        $barColors = ['bg-komdigi-cerulean', 'bg-indigo-400', 'bg-emerald-400', 'bg-amber-400'];
        // Daftar pembimbing unik untuk filter (dari data controller).
        $pembimbingUnik = array_values(array_unique(array_column($penilaian, 'pembimbing')));
        // Daftar periode unik untuk filter (label periode dari data controller).
        $periodeUnik = array_values(array_unique(array_column($penilaian, 'periode_label')));
    @endphp

    <!-- Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Kelola Penilaian</h1>
        <p class="text-sm text-blue-100/80 mt-0.5">Atur kriteria, bobot, dan pantau penilaian peserta</p>
    </div>

    <!-- Tabs -->
    <div class="flex flex-wrap gap-2">
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="kriteria"
            class="tab-btn active px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 transition">Kriteria &amp; Bobot</button>
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="penilaian"
            class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white transition">Semua Penilaian</button>
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="audit"
            class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white transition">Riwayat Perubahan</button>
    </div>

    <!-- TAB: Kriteria & Bobot -->
    <div data-panel="kriteria" data-group="kp" class="space-y-5">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-white">Kriteria Penilaian</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Total bobot harus 100%</p>
                </div>
                <button type="button" data-action="open-modal" data-target="modalKriteria"
                    data-modal-title="Tambah Kriteria"
                    class="btn-shine inline-flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-xs font-bold rounded-xl shadow-md">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kriteria
                </button>
            </div>
            <div class="space-y-3">
                @forelse ($kriteria as $kr)
                    @php
                        // Ambil class warna teks dari icon_class (string statis dari controller),
                        // mis. 'bg-komdigi-blue/20 text-komdigi-cerulean' -> 'text-komdigi-cerulean'.
                        $textColor = strstr($kr['icon_class'], 'text-') ?: '';
                        $textColor = trim($textColor);
                    @endphp
                    <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 rounded-xl {{ $kr['icon_class'] }} flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold">{{ $kr['nomor'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white">{{ $kr['nama'] }}</p>
                            <p class="text-xs text-slate-400">{{ $kr['deskripsi'] }}</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="text-right">
                                <p class="text-lg font-black {{ $textColor }}">{{ $kr['bobot'] }}%</p>
                                <p class="text-[10px] text-slate-500">Bobot</p>
                            </div>
                            <button type="button" data-action="open-modal" data-target="modalKriteria"
                                data-modal-title="Edit Kriteria – {{ $kr['nama'] }}"
                                data-form-fields='@json($kr['form'])'
                                class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition"
                                title="Edit Kriteria">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.kriteria.delete') }}"
                                data-form-field="id" data-form-value="{{ $kr['id'] }}"
                                data-modal-title="Hapus kriteria {{ $kr['nama'] }}?"
                                data-modal-desc="Kriteria yang sudah dipakai pada riwayat penilaian hanya akan dinonaktifkan."
                                class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition"
                                title="Hapus Kriteria">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-4">Belum ada kriteria penilaian</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between">
                <p class="text-sm text-slate-400">Total Bobot</p>
                <p class="text-xl font-black text-emerald-400">{{ $totalBobot }}%</p>
            </div>
        </div>
    </div>

    <!-- TAB: Semua Penilaian -->
    <div data-panel="penilaian" data-group="kp" class="hidden space-y-5">
        <div class="glass-card rounded-2xl p-4">
            <div class="grid sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="searchPenilaian">Cari Peserta</label>
                    <input type="text" id="searchPenilaian" placeholder="Nama peserta..." class="form-input"
                        data-action="filter-table" data-table="penilaianTable" data-key="search">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterPembimbingNilai">Pembimbing</label>
                    <select id="filterPembimbingNilai" class="form-input" data-action="filter-table"
                        data-table="penilaianTable" data-key="pembimbing">
                        <option value="">Semua</option>
                        @foreach ($pembimbingUnik as $pb)
                            <option value="{{ $pb }}">{{ strstr($pb, ',') ? trim(substr($pb, 0, strpos($pb, ','))) : $pb }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1.5" for="filterPeriodeNilai">Periode</label>
                    <select id="filterPeriodeNilai" class="form-input" data-action="filter-table"
                        data-table="penilaianTable" data-key="periode">
                        <option value="">Semua Periode</option>
                        @foreach ($periodeUnik as $per)
                            <option value="{{ $per }}">{{ $per }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="penilaianTable">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Peserta</th>
                            <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Nilai</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Pembimbing</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                            <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penilaian as $pn)
                            <tr class="table-row border-b border-white/5" data-row data-pembimbing="{{ $pn['pembimbing'] }}"
                                data-periode="{{ $pn['periode_label'] }}">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $pn['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $pn['initial'] }}</div>
                                        <div>
                                            <p class="font-semibold text-white">{{ $pn['nama'] }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $pn['id'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="text-lg font-black {{ $pn['nilai_class'] }}">{{ $pn['nilai'] }}</span>
                                    <span class="text-xs text-slate-500">/5.0</span>
                                </td>
                                <td class="px-4 py-3.5 text-slate-300 text-xs">{{ $pn['pembimbing'] }}</td>
                                <td class="px-4 py-3.5 text-slate-400 text-xs">{{ $pn['tanggal'] }}</td>
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" data-action="open-modal" data-target="modalView-{{ $pn['id'] }}"
                                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition"
                                            title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button type="button" data-action="open-modal" data-target="modalOverride"
                                            data-modal-desc="Peserta: {{ $pn['nama'] }} · Nilai saat ini: {{ $pn['nilai'] }}"
                                            data-form-field="penilaian_id" data-form-value="{{ $pn['id'] }}"
                                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition"
                                            title="Override / Koreksi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data penilaian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: Audit Log -->
    <div data-panel="audit" data-group="kp" class="hidden space-y-5">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10">
                <h3 class="font-bold text-white">Riwayat Perubahan Penilaian (Audit Log)</h3>
            </div>
            <div class="divide-y divide-white/5">
                @forelse ($auditLog as $log)
                    @php $ai = $auditIcons[$log['jenis']] ?? $auditIcons['tambah']; @endphp
                    <div class="px-5 py-4 flex gap-4">
                        <div class="w-10 h-10 rounded-xl {{ $ai['box'] }} flex items-center justify-center shrink-0">
                            @if ($log['jenis'] === 'koreksi')
                                <svg class="w-5 h-5 {{ $ai['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            @elseif ($log['jenis'] === 'bobot')
                                <svg class="w-5 h-5 {{ $ai['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4v2m0 10v2m0-2a2 2 0 100 4m0-4a2 2 0 110 0v2m-6-4h2m10-4h2" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 {{ $ai['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-white"><span class="font-semibold">{{ $log['user'] }}</span> {{ $log['aksi'] }}</p>
                            <p class="text-[11px] text-slate-500 mt-1">{{ $log['waktu'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-slate-400 text-center">Belum ada riwayat perubahan</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL: Override / Koreksi Penilaian -->
    <div id="modalOverride" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalOverride"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white">Override / Koreksi Penilaian</h3>
                    <button type="button" data-action="close-modal" data-target="modalOverride"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.penilaian.override') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="penilaian_id" value="">
                    <p class="text-sm text-slate-400 mb-4" data-modal-desc-slot>Peserta: – · Nilai saat ini: –</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="overrideNew">Nilai Baru (0–5)</label>
                            <input type="number" id="overrideNew" name="nilai_baru" class="form-input" min="0" max="5"
                                step="0.1" placeholder="Contoh: 4.0" value="{{ old('nilai_baru') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="overrideAlasan">Alasan Koreksi
                                <span class="text-rose-400">*</span></label>
                            <textarea id="overrideAlasan" name="alasan" class="form-input min-h-[80px]"
                                placeholder="Jelaskan alasan koreksi penilaian..." required>{{ old('alasan') }}</textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button type="button" data-action="close-modal" data-target="modalOverride"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-xl shadow-lg text-sm">Simpan Koreksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Kriteria -->
    <div id="modalKriteria" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalKriteria"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah Kriteria</h3>
                    <button type="button" data-action="close-modal" data-target="modalKriteria"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.kriteria.store') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kriteriaNama">Nama Kriteria</label>
                        <input type="text" id="kriteriaNama" name="nama" class="form-input"
                            placeholder="Contoh: Disiplin &amp; Kehadiran" value="{{ old('nama') }}" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kriteriaDeskripsi">Deskripsi</label>
                        <input type="text" id="kriteriaDeskripsi" name="deskripsi" class="form-input"
                            placeholder="Penjelasan singkat" value="{{ old('deskripsi') }}">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kriteriaBobot">Bobot (%)</label>
                            <input type="number" id="kriteriaBobot" name="bobot" class="form-input" min="1" max="100"
                                placeholder="25" value="{{ old('bobot') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kriteriaUrutan">Urutan</label>
                            <input type="number" id="kriteriaUrutan" name="urutan" class="form-input" min="1" max="99"
                                placeholder="Otomatis" value="{{ old('urutan') }}">
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button type="button" data-action="close-modal" data-target="modalKriteria"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail Penilaian (dirender per baris dari data controller, tanpa innerHTML) -->
    @foreach ($penilaian as $pn)
        <div id="modalView-{{ $pn['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalView-{{ $pn['id'] }}"></div>
            <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-white/15">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-black text-white">Detail Penilaian</h3>
                        <button type="button" data-action="close-modal" data-target="modalView-{{ $pn['id'] }}"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-slate-400 mb-4">Peserta: <span class="text-white font-semibold">{{ $pn['nama'] }}</span></p>
                    <div class="text-center mb-5">
                        <p class="text-4xl font-black text-komdigi-cerulean">{{ $pn['nilai'] }}</p>
                        <p class="text-xs text-slate-400">/ 5.0</p>
                    </div>
                    <div class="space-y-3">
                        @foreach ($pn['rincian'] as $i => $r)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-300">{{ $r['kriteria'] }}</span>
                                <span class="text-sm font-bold text-white">{{ number_format($r['nilai'], 1) }}</span>
                            </div>
                            <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full {{ $barColors[$i % count($barColors)] }} rounded-full"
                                    style="width: {{ min(100, $r['nilai'] / 5 * 100) }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 bg-white/5 rounded-xl border border-white/10">
                        <p class="text-xs text-slate-400 italic">"{{ $pn['catatan'] }}"</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('layouts.admin.modal-delete', [
        'route' => route('admin.kriteria.delete'),
        'field' => 'id',
        'label' => 'kriteria',
    ])
@endpush

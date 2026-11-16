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

    <x-page-header eyebrow="Panel administrasi" title="Kelola Penilaian" description="Atur kriteria, bobot, dan pantau penilaian peserta" />

    <!-- Tabs -->
    <div class="flex flex-wrap gap-2">
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="kriteria"
            class="tab-btn active px-4 py-2 text-sm font-semibold rounded-xl border border-subtle transition">Kriteria &amp; Bobot</button>
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="penilaian"
            class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-subtle text-muted hover:text-foreground transition">Semua Penilaian</button>
        <button type="button" data-action="switch-tab" data-group="kp" data-tab="audit"
            class="tab-btn px-4 py-2 text-sm font-semibold rounded-xl border border-subtle text-muted hover:text-foreground transition">Riwayat Perubahan</button>
    </div>

    <!-- TAB: Kriteria & Bobot -->
    <div data-panel="kriteria" data-group="kp" class="space-y-5">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-foreground">Kriteria Penilaian</h3>
                    <p class="text-xs text-muted mt-0.5">Total bobot harus 100%</p>
                </div>
                <button type="button" data-action="open-modal" data-target="modalKriteria"
                    data-modal-title="Tambah Kriteria"
                    class="ui-button inline-flex items-center gap-1.5 px-3 py-2 text-white text-xs">
                    <i data-lucide="plus" class="w-3.5 h-3.5" aria-hidden="true"></i>
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
                    <div class="flex items-center gap-4 bg-surface rounded-xl p-4 border border-subtle">
                        <div class="w-10 h-10 rounded-xl {{ $kr['icon_class'] }} flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold">{{ $kr['nomor'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-foreground">{{ $kr['nama'] }}</p>
                            <p class="text-xs text-muted">{{ $kr['deskripsi'] }}</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="text-right">
                                <p class="text-lg font-black {{ $textColor }}">{{ $kr['bobot'] }}%</p>
                                <p class="text-[10px] text-muted">Bobot</p>
                            </div>
                            <button type="button" data-action="open-modal" data-target="modalKriteria"
                                data-modal-title="Edit Kriteria – {{ $kr['nama'] }}"
                                data-form-fields='@json($kr['form'])'
                                class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted hover:text-foreground transition"
                                title="Edit Kriteria">
                                <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.kriteria.delete') }}"
                                data-form-field="id" data-form-value="{{ $kr['id'] }}"
                                data-modal-title="Hapus kriteria {{ $kr['nama'] }}?"
                                data-modal-desc="Kriteria yang sudah dipakai pada riwayat penilaian hanya akan dinonaktifkan."
                                class="w-8 h-8 rounded-lg bg-surface hover:bg-rose-500/20 flex items-center justify-center text-muted hover:text-rose-400 transition"
                                title="Hapus Kriteria">
                                <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-muted text-center py-4">Belum ada kriteria penilaian</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-subtle flex items-center justify-between">
                <p class="text-sm text-muted">Total Bobot</p>
                <p class="text-xl font-black text-emerald-400">{{ $totalBobot }}%</p>
            </div>
        </div>
    </div>

    <!-- TAB: Semua Penilaian -->
    <div data-panel="penilaian" data-group="kp" class="hidden space-y-5">
        <div class="glass-card rounded-2xl p-4">
            <div class="grid sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-muted mb-1.5" for="searchPenilaian">Cari Peserta</label>
                    <input type="text" id="searchPenilaian" placeholder="Nama peserta..." class="form-input"
                        data-action="filter-table" data-table="penilaianTable" data-key="search">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterPembimbingNilai">Pembimbing</label>
                    <select id="filterPembimbingNilai" class="form-input" data-action="filter-table"
                        data-table="penilaianTable" data-key="pembimbing">
                        <option value="">Semua</option>
                        @foreach ($pembimbingUnik as $pb)
                            <option value="{{ $pb }}">{{ strstr($pb, ',') ? trim(substr($pb, 0, strpos($pb, ','))) : $pb }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-muted mb-1.5" for="filterPeriodeNilai">Periode</label>
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
                        <tr class="border-b border-subtle">
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase">Peserta</th>
                            <th class="text-center px-4 py-3.5 text-[11px] font-bold text-muted uppercase">Nilai</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase">Pembimbing</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-muted uppercase">Tanggal</th>
                            <th class="text-right px-4 py-3.5 text-[11px] font-bold text-muted uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penilaian as $pn)
                            <tr class="table-row border-b border-subtle" data-row data-pembimbing="{{ $pn['pembimbing'] }}"
                                data-periode="{{ $pn['periode_label'] }}">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $pn['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $pn['initial'] }}</div>
                                        <div>
                                            <p class="font-semibold text-foreground">{{ $pn['nama'] }}</p>
                                            <p class="text-[11px] text-muted">{{ $pn['id'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="text-lg font-black {{ $pn['nilai_class'] }}">{{ $pn['nilai'] }}</span>
                                    <span class="text-xs text-muted">/5.0</span>
                                </td>
                                <td class="px-4 py-3.5 text-foreground text-xs">{{ $pn['pembimbing'] }}</td>
                                <td class="px-4 py-3.5 text-muted text-xs">{{ $pn['tanggal'] }}</td>
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" data-action="open-modal" data-target="modalView-{{ $pn['id'] }}"
                                            class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted hover:text-foreground transition"
                                            title="Lihat">
                                            <i data-lucide="eye" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" data-action="open-modal" data-target="modalOverride"
                                            data-modal-desc="Peserta: {{ $pn['nama'] }} · Nilai saat ini: {{ $pn['nilai'] }}"
                                            data-form-field="penilaian_id" data-form-value="{{ $pn['id'] }}"
                                            class="w-8 h-8 rounded-lg bg-surface hover:bg-amber-500/20 flex items-center justify-center text-muted hover:text-amber-400 transition"
                                            title="Override / Koreksi">
                                            <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-muted">Belum ada data penilaian</td>
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
            <div class="px-5 py-4 border-b border-subtle">
                <h3 class="font-bold text-foreground">Riwayat Perubahan Penilaian (Audit Log)</h3>
            </div>
            <div class="divide-y divide-subtle">
                @forelse ($auditLog as $log)
                    @php $ai = $auditIcons[$log['jenis']] ?? $auditIcons['tambah']; @endphp
                    <div class="px-5 py-4 flex gap-4">
                        <div class="w-10 h-10 rounded-xl {{ $ai['box'] }} flex items-center justify-center shrink-0">
                            @if ($log['jenis'] === 'koreksi')
                                <i data-lucide="square-pen" class="w-5 h-5 {{ $ai['icon'] }}" aria-hidden="true"></i>
                            @elseif ($log['jenis'] === 'bobot')
                                <i data-lucide="sliders-horizontal" class="w-5 h-5 {{ $ai['icon'] }}" aria-hidden="true"></i>
                            @else
                                <i data-lucide="plus" class="w-5 h-5 {{ $ai['icon'] }}" aria-hidden="true"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-foreground"><span class="font-semibold">{{ $log['user'] }}</span> {{ $log['aksi'] }}</p>
                            <p class="text-[11px] text-muted mt-1">{{ $log['waktu'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-muted text-center">Belum ada riwayat perubahan</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL: Override / Koreksi Penilaian -->
    <div id="modalOverride" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalOverride"></div>
        <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-lg border border-subtle">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-foreground">Override / Koreksi Penilaian</h3>
                    <button type="button" data-action="close-modal" data-target="modalOverride"
                        class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                        <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.penilaian.override') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="penilaian_id" value="">
                    <p class="text-sm text-muted mb-4" data-modal-desc-slot>Peserta: – · Nilai saat ini: –</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="overrideNew">Nilai Baru (0–5)</label>
                            <input type="number" id="overrideNew" name="nilai_baru" class="form-input" min="0" max="5"
                                step="0.1" placeholder="Contoh: 4.0" value="{{ old('nilai_baru') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="overrideAlasan">Alasan Koreksi
                                <span class="text-rose-400">*</span></label>
                            <textarea id="overrideAlasan" name="alasan" class="form-input min-h-[80px]"
                                placeholder="Jelaskan alasan koreksi penilaian..." required>{{ old('alasan') }}</textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button type="button" data-action="close-modal" data-target="modalOverride"
                            class="flex-1 py-3 ui-button-secondary text-sm">Batal</button>
                        <button type="submit"
                            class="ui-button flex-1 py-3 text-white text-sm">Simpan Koreksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Kriteria -->
    <div id="modalKriteria" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalKriteria"></div>
        <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-md border border-subtle">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-foreground" data-modal-title-slot>Tambah Kriteria</h3>
                    <button type="button" data-action="close-modal" data-target="modalKriteria"
                        class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                        <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.kriteria.store') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-muted mb-1.5" for="kriteriaNama">Nama Kriteria</label>
                        <input type="text" id="kriteriaNama" name="nama" class="form-input"
                            placeholder="Contoh: Disiplin &amp; Kehadiran" value="{{ old('nama') }}" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-muted mb-1.5" for="kriteriaDeskripsi">Deskripsi</label>
                        <input type="text" id="kriteriaDeskripsi" name="deskripsi" class="form-input"
                            placeholder="Penjelasan singkat" value="{{ old('deskripsi') }}">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="kriteriaBobot">Bobot (%)</label>
                            <input type="number" id="kriteriaBobot" name="bobot" class="form-input" min="1" max="100"
                                placeholder="25" value="{{ old('bobot') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-muted mb-1.5" for="kriteriaUrutan">Urutan</label>
                            <input type="number" id="kriteriaUrutan" name="urutan" class="form-input" min="1" max="99"
                                placeholder="Otomatis" value="{{ old('urutan') }}">
                        </div>
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button type="button" data-action="close-modal" data-target="modalKriteria"
                            class="flex-1 py-3 ui-button-secondary text-sm">Batal</button>
                        <button type="submit"
                            class="ui-button flex-1 py-3 text-white text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Detail Penilaian (dirender per baris dari data controller, tanpa innerHTML) -->
    @foreach ($penilaian as $pn)
        <div id="modalView-{{ $pn['id'] }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
            <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalView-{{ $pn['id'] }}"></div>
            <div class="relative glass-strong rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-subtle">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-black text-foreground">Detail Penilaian</h3>
                        <button type="button" data-action="close-modal" data-target="modalView-{{ $pn['id'] }}"
                            class="w-8 h-8 rounded-full bg-elevated flex items-center justify-center hover:bg-elevated transition">
                            <i data-lucide="x" class="w-4 h-4 text-foreground" aria-hidden="true"></i>
                        </button>
                    </div>
                    <p class="text-sm text-muted mb-4">Peserta: <span class="text-foreground font-semibold">{{ $pn['nama'] }}</span></p>
                    <div class="text-center mb-5">
                        <p class="text-4xl font-black text-komdigi-cerulean">{{ $pn['nilai'] }}</p>
                        <p class="text-xs text-muted">/ 5.0</p>
                    </div>
                    <div class="space-y-3">
                        @foreach ($pn['rincian'] as $i => $r)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-foreground">{{ $r['kriteria'] }}</span>
                                <span class="text-sm font-bold text-foreground">{{ number_format($r['nilai'], 1) }}</span>
                            </div>
                            <div class="h-2 bg-elevated rounded-full overflow-hidden">
                                <div class="h-full {{ $barColors[$i % count($barColors)] }} rounded-full"
                                    style="width: {{ min(100, $r['nilai'] / 5 * 100) }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 bg-surface rounded-xl border border-subtle">
                        <p class="text-xs text-muted italic">"{{ $pn['catatan'] }}"</p>
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

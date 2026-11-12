@extends('layouts.admin')

@section('title', 'CMS Konten')

@section('content')
    <!-- Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">CMS / Konten Publik</h1>
        <p class="text-sm text-blue-100/80 mt-0.5">Kelola seluruh konten landing page &amp; area publik Magang Komdigi</p>
    </div>

    <!-- Tabs -->
    <div class="tabs-scroll">
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="kegiatan"
            class="tab-btn active px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10">Kegiatan</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="dokumentasi"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Dokumentasi</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="anggota"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Profil / Anggota</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="halaman"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Halaman Statis</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="pengumuman"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Pengumuman</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="hero"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Hero &amp; Countdown</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="menu"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Menu Navigasi</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="dokumen"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">Dokumen</button>
        <button type="button" data-action="switch-tab" data-group="cms" data-tab="faq"
            class="tab-btn px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-white/10 text-slate-400 hover:text-white">FAQ</button>
    </div>

    <!-- TAB: KEGIATAN -->
    <div data-panel="kegiatan" data-group="cms" class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Logbook Kegiatan Publik</h2>
                <p class="text-xs text-slate-400">Section “Kegiatan Terbaru”</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalKegiatan"
                data-modal-title="Tambah Kegiatan"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kegiatan
            </button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Total</p>
                <p class="text-2xl font-black text-white mt-1">{{ $kegiatanStats['total'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Published</p>
                <p class="text-2xl font-black text-emerald-400 mt-1">{{ $kegiatanStats['published'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Draft</p>
                <p class="text-2xl font-black text-slate-300 mt-1">{{ $kegiatanStats['draft'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Pinned</p>
                <p class="text-2xl font-black text-amber-400 mt-1">{{ $kegiatanStats['pinned'] }}</p>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-4">
            <input type="text" placeholder="Cari kegiatan..." class="form-input" data-action="filter-table"
                data-table="kegiatanTable" data-key="search" aria-label="Cari kegiatan">
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="kegiatanTable">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kegiatan</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatan as $kg)
                            <tr class="table-row border-b border-white/5" data-row>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($kg['cover'])
                                            <img src="{{ $kg['cover'] }}" alt=""
                                                class="w-10 h-10 rounded-lg object-cover shrink-0 border border-white/10">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center shrink-0 border border-white/10">
                                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-semibold text-white truncate">
                                                @if ($kg['pin'])
                                                    <span class="text-amber-400" title="Di-pin di atas">📌</span>
                                                @endif
                                                {{ $kg['judul'] }}
                                            </p>
                                            <p class="text-[11px] text-slate-400 truncate">{{ $kg['deskripsi'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-slate-300 text-xs whitespace-nowrap">{{ $kg['tanggal'] }}</td>
                                <td class="px-4 py-3.5">
                                    <span class="kategori-badge {{ $kg['kategori_class'] }}">{{ $kg['kategori'] }}</span>
                                </td>
                                <td class="px-4 py-3.5">
                                    @if ($kg['status'] === 'publish')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold rounded-full">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Publish
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-500/20 text-slate-400 border border-slate-500/30 text-[11px] font-bold rounded-full">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" data-action="open-modal" data-target="modalKegiatan"
                                            data-modal-title="Edit Kegiatan – {{ $kg['judul'] }}"
                                            data-form-fields='@json($kg['form'])' title="Edit kegiatan"
                                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" data-action="open-modal" data-target="modalDelete"
                                            data-form-action="{{ route('admin.cms.delete') }}"
                                            data-form-fields='@json(['jenis' => 'kegiatan', 'id' => $kg['id']])'
                                            data-modal-title="Hapus {{ $kg['judul'] }}?" title="Hapus kegiatan"
                                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada kegiatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: DOKUMENTASI -->
    <div data-panel="dokumentasi" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Galeri Dokumentasi</h2>
                <p class="text-xs text-slate-400">Section “Dokumentasi”</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalDokumentasi"
                data-modal-title="Upload Foto Dokumentasi"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Foto
            </button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Total Foto</p>
                <p class="text-2xl font-black text-white mt-1">{{ $dokumentasiStats['total'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Published</p>
                <p class="text-2xl font-black text-emerald-400 mt-1">{{ $dokumentasiStats['published'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Unpublished</p>
                <p class="text-2xl font-black text-slate-300 mt-1">{{ $dokumentasiStats['unpublished'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Kategori</p>
                <p class="text-2xl font-black text-komdigi-cerulean mt-1">{{ $dokumentasiStats['kategori'] }}</p>
            </div>
        </div>
        @if (count($dokumentasi) === 0)
            <div class="glass-card rounded-2xl p-8 text-center text-sm text-slate-400">
                Belum ada foto dokumentasi. Klik “Upload Foto” untuk menambahkan.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($dokumentasi as $d)
                    <div class="glass-card rounded-2xl overflow-hidden group">
                        <div class="relative aspect-[4/3] bg-white/5">
                            @if ($d['foto'])
                                <img src="{{ $d['foto'] }}" alt="{{ $d['judul'] }}"
                                    class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            @if ($d['status'] !== 'publish')
                                <span
                                    class="absolute top-2 left-2 px-2 py-0.5 bg-slate-900/80 border border-white/15 text-[10px] font-bold text-slate-300 rounded-full">Draft</span>
                            @endif
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.cms.delete') }}"
                                data-form-fields='@json(['jenis' => 'dokumentasi', 'id' => $d['id']])'
                                data-modal-title="Hapus foto “{{ $d['judul'] }}”?"
                                class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-slate-900/80 border border-white/15 flex items-center justify-center text-slate-300 hover:text-rose-400 hover:border-rose-500/40 transition"
                                title="Hapus foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-3 space-y-1.5">
                            <p class="text-xs font-semibold text-white truncate">{{ $d['judul'] }}</p>
                            <div class="flex items-center justify-between gap-2">
                                <span class="kategori-badge {{ $d['kategori_class'] }}">{{ $d['kategori'] }}</span>
                                <span class="text-[11px] text-slate-400 whitespace-nowrap">{{ $d['tanggal'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- TAB: ANGGOTA -->
    <div data-panel="anggota" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Profil Tim &amp; Anggota</h2>
                <p class="text-xs text-slate-400">Section Profil Tim dan daftar anggota</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalAnggota"
                data-modal-title="Tambah Anggota"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Anggota
            </button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Total</p>
                <p class="text-2xl font-black text-white mt-1">{{ $anggotaStats['total'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Peserta</p>
                <p class="text-2xl font-black text-sky-400 mt-1">{{ $anggotaStats['peserta'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Pembimbing</p>
                <p class="text-2xl font-black text-violet-400 mt-1">{{ $anggotaStats['pembimbing'] }}</p>
            </div>
            <div class="glass-card rounded-xl p-4">
                <p class="text-[11px] font-semibold text-slate-400 uppercase">Aktif</p>
                <p class="text-2xl font-black text-emerald-400 mt-1">{{ $anggotaStats['aktif'] }}</p>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-4">
            <div class="grid sm:grid-cols-3 gap-3">
                <input type="text" placeholder="Cari nama..." class="form-input" data-action="filter-table"
                    data-table="anggotaTable" data-key="search" aria-label="Cari anggota">
                <select class="form-input" data-action="filter-table" data-table="anggotaTable" data-key="posisi"
                    aria-label="Filter posisi">
                    <option value="">Semua Posisi</option>
                    <option value="peserta">Peserta</option>
                    <option value="pembimbing">Pembimbing</option>
                    <option value="koordinator">Koordinator</option>
                </select>
                <select class="form-input" data-action="filter-table" data-table="anggotaTable" data-key="status"
                    aria-label="Filter status">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="anggotaTable">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Anggota</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Posisi</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Institusi</th>
                            <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Status</th>
                            <th class="text-center px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Urutan</th>
                            <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggota as $a)
                            <tr class="table-row border-b border-white/5 {{ $a['status'] === 'nonaktif' ? 'opacity-70' : '' }}"
                                data-row data-posisi="{{ $a['posisi_key'] }}" data-status="{{ $a['status'] }}">
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $a['gradient'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">
                                            {{ $a['initial'] }}</div>
                                        <div>
                                            <p class="font-semibold text-white">{{ $a['nama'] }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $a['username'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <span class="kategori-badge kat-{{ $a['posisi_key'] }}">{{ $a['posisi'] }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-slate-300 text-xs">{{ $a['institusi'] }}</td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="status-badge status-{{ $a['status'] }}">●
                                        {{ ucfirst($a['status']) }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-center text-slate-400">{{ $a['urutan'] }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" data-action="open-modal" data-target="modalAnggota"
                                            data-modal-title="Edit Anggota – {{ $a['nama'] }}"
                                            data-form-fields='@json($a['form'])' title="Edit"
                                            class="w-8 h-8 rounded-lg bg-white/5 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" data-action="open-modal" data-target="modalDelete"
                                            data-form-action="{{ route('admin.cms.delete') }}"
                                            data-form-fields='@json(['jenis' => 'anggota', 'id' => $a['id']])'
                                            data-modal-title="Hapus {{ $a['nama'] }}?" title="Hapus"
                                            class="w-8 h-8 rounded-lg bg-white/5 inline-flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data
                                    anggota</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: HALAMAN STATIS -->
    <div data-panel="halaman" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Halaman Statis</h2>
                <p class="text-xs text-slate-400">Tentang Kami, Panduan, Kebijakan, dll.</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalHalaman"
                data-modal-title="Tambah Halaman"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Halaman
            </button>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($halaman as $h)
                <div class="glass-card rounded-2xl p-5 flex flex-col {{ $h['status'] === 'draft' ? 'opacity-80' : '' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl {{ $h['icon_class'] }} flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="status-badge status-{{ $h['status'] }}">● {{ ucfirst($h['status']) }}</span>
                    </div>
                    <h3 class="font-bold text-white mb-1">{{ $h['judul'] }}</h3>
                    <p class="text-xs text-slate-400 mb-3 flex-1">{{ $h['deskripsi'] }}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-white/10">
                        <span class="text-[11px] text-slate-500">{{ $h['slug'] }}</span>
                        <div class="flex gap-1">
                            <button type="button" data-action="open-modal" data-target="modalHalaman"
                                data-modal-title="Edit Halaman – {{ $h['judul'] }}"
                                data-form-fields='@json($h['form'])' title="Edit"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.cms.delete') }}"
                                data-form-fields='@json(['jenis' => 'halaman', 'id' => $h['id']])'
                                data-modal-title="Hapus {{ $h['judul'] }}?" title="Hapus"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada halaman statis</p>
            @endforelse
        </div>
    </div>

    <!-- TAB: PENGUMUMAN -->
    <div data-panel="pengumuman" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Pengumuman &amp; Banner</h2>
                <p class="text-xs text-slate-400">Notifikasi dan highlight di beranda</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalPengumuman"
                data-modal-title="Tambah Pengumuman"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengumuman
            </button>
        </div>
        <div class="space-y-3">
            @forelse ($pengumuman as $p)
                <div class="glass-card rounded-2xl p-5 {{ $p['status'] === 'nonaktif' ? 'opacity-75' : '' }}">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-xl {{ $p['icon_class'] }} flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="font-bold text-white">{{ $p['judul'] }}</h3>
                                <span class="kategori-badge {{ $p['posisi_class'] }}">{{ $p['posisi'] }}</span>
                                <span class="status-badge status-{{ $p['status'] }}">●
                                    {{ ucfirst($p['status']) }}</span>
                            </div>
                            <p class="text-sm text-slate-400 mb-2">{{ $p['deskripsi'] }}</p>
                            <div class="flex flex-wrap gap-3 text-[11px] text-slate-500">
                                <span>Target: {{ $p['target'] }}</span>
                                <span>·</span>
                                <span>{{ $p['tanggal'] }}</span>
                                @if (!empty($p['link']))
                                    <span>·</span>
                                    <span class="text-komdigi-cerulean">{{ $p['link'] }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-1 shrink-0">
                            <button type="button" data-action="open-modal" data-target="modalPengumuman"
                                data-modal-title="Edit Pengumuman – {{ $p['judul'] }}"
                                data-form-fields='@json($p['form'])' title="Edit"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.cms.delete') }}"
                                data-form-fields='@json(['jenis' => 'pengumuman', 'id' => $p['id']])'
                                data-modal-title="Hapus {{ $p['judul'] }}?" title="Hapus"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada pengumuman</p>
            @endforelse
        </div>
    </div>

    <!-- TAB: HERO & COUNTDOWN -->
    <div data-panel="hero" data-group="cms" class="hidden space-y-5">
        <div>
            <h2 class="text-lg font-bold text-white">Hero &amp; Countdown</h2>
            <p class="text-xs text-slate-400">Konten utama landing page + timer periode magang</p>
        </div>
        <form class="glass-card rounded-2xl p-6 space-y-5" method="POST" action="{{ route('admin.cms.store') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis" value="hero">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroJudul">Judul Utama Hero</label>
                <input type="text" id="heroJudul" name="judul" class="form-input" required
                    value="{{ old('judul', $hero['judul']) }}">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroSubjudul">Subjudul /
                    Deskripsi</label>
                <textarea id="heroSubjudul" name="subjudul" class="form-input">{{ old('subjudul', $hero['subjudul']) }}</textarea>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroTombol1">Teks Tombol
                        1</label>
                    <input type="text" id="heroTombol1" name="tombol1" class="form-input"
                        value="{{ old('tombol1', $hero['tombol1']) }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroLink1">Link Tombol
                        1</label>
                    <input type="text" id="heroLink1" name="link1" class="form-input"
                        value="{{ old('link1', $hero['link1']) }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroTombol2">Teks Tombol
                        2</label>
                    <input type="text" id="heroTombol2" name="tombol2" class="form-input"
                        value="{{ old('tombol2', $hero['tombol2']) }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroLink2">Link Tombol
                        2</label>
                    <input type="text" id="heroLink2" name="link2" class="form-input"
                        value="{{ old('link2', $hero['link2']) }}">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroMulai">Tanggal Mulai
                        Magang</label>
                    <input type="date" id="heroMulai" name="tanggal_mulai" class="form-input"
                        value="{{ old('tanggal_mulai', $hero['tanggal_mulai']) }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroSelesai">Tanggal Berakhir
                        Magang</label>
                    <input type="date" id="heroSelesai" name="tanggal_selesai" class="form-input"
                        value="{{ old('tanggal_selesai', $hero['tanggal_selesai']) }}">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroStatus">Status Periode</label>
                <select id="heroStatus" name="status_periode" class="form-input">
                    @foreach (['Sedang Berjalan', 'Belum Mulai', 'Selesai'] as $opt)
                        <option value="{{ $opt }}" @selected(old('status_periode', $hero['status_periode']) === $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="heroGambar">Gambar Latar Hero
                    (opsional)</label>
                <div class="flex items-center gap-4">
                    <div
                        class="w-32 h-20 rounded-xl bg-white/5 border border-dashed border-white/15 flex items-center justify-center text-slate-500 text-xs">
                        Preview</div>
                    <label
                        class="px-4 py-2 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl border border-white/10 cursor-pointer hover:bg-white/15 transition">
                        Upload Gambar
                        <input type="file" id="heroGambar" name="gambar" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>
            <div class="pt-2">
                <button type="submit"
                    class="btn-shine px-6 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl shadow-lg text-sm">Simpan
                    Perubahan</button>
            </div>
        </form>
        <div class="glass-card rounded-2xl p-6">
            <p class="text-xs font-semibold text-slate-400 mb-3 uppercase tracking-wide">Preview Countdown</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="text-center px-5 py-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-3xl font-black text-komdigi-cerulean">{{ $hero['countdown']['hari'] }}</p>
                    <p class="text-[10px] text-slate-400 uppercase">Hari</p>
                </div>
                <div class="text-center px-5 py-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-3xl font-black text-komdigi-cerulean">
                        {{ sprintf('%02d', $hero['countdown']['jam']) }}</p>
                    <p class="text-[10px] text-slate-400 uppercase">Jam</p>
                </div>
                <div class="text-center px-5 py-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-3xl font-black text-komdigi-cerulean">
                        {{ sprintf('%02d', $hero['countdown']['menit']) }}</p>
                    <p class="text-[10px] text-slate-400 uppercase">Menit</p>
                </div>
                <div class="text-center px-5 py-3 rounded-xl bg-white/5 border border-white/10">
                    <p class="text-3xl font-black text-komdigi-cerulean">
                        {{ sprintf('%02d', $hero['countdown']['detik']) }}</p>
                    <p class="text-[10px] text-slate-400 uppercase">Detik</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-xs text-slate-400 mb-1">
                    <span>Progress Periode</span>
                    <span>{{ $hero['progress'] }}%</span>
                </div>
                <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-full"
                        style="width: {{ $hero['progress'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: MENU NAVIGASI -->
    <div data-panel="menu" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Menu Navigasi</h2>
                <p class="text-xs text-slate-400">Atur urutan &amp; visibilitas menu navbar</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalMenu" data-modal-title="Tambah Menu"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Menu
            </button>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="divide-y divide-white/5">
                @forelse ($menu as $m)
                    <div
                        class="flex items-center gap-3 px-4 py-3.5 {{ $m['status'] === 'nonaktif' ? 'opacity-60' : '' }}">
                        <span class="drag-handle text-lg" title="Seret untuk mengurutkan">⠿</span>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white text-sm">{{ $m['label'] }}</p>
                            <p class="text-[11px] text-slate-500">{{ $m['url'] }} · {{ $m['tipe'] }}</p>
                        </div>
                        <span class="status-badge status-{{ $m['status'] }}">● {{ ucfirst($m['status']) }}</span>
                        <button type="button" data-action="open-modal" data-target="modalMenu"
                            data-modal-title="Edit Menu – {{ $m['label'] }}"
                            data-form-fields='@json($m['form'])' title="Edit"
                            class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-white transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button type="button" data-action="open-modal" data-target="modalDelete"
                            data-form-action="{{ route('admin.cms.delete') }}"
                            data-form-fields='@json(['jenis' => 'menu', 'id' => $m['id']])'
                            data-modal-title="Hapus menu {{ $m['label'] }}?" title="Hapus"
                            class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-4">Belum ada menu navigasi</p>
                @endforelse
            </div>
        </div>
        <p class="text-xs text-slate-500">Seret ikon ⠿ untuk mengubah urutan (simulasi UI). Perubahan urutan disimpan di
            implementasi nyata.</p>
    </div>

    <!-- TAB: DOKUMEN -->
    <div data-panel="dokumen" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Manajemen Dokumen</h2>
                <p class="text-xs text-slate-400">Panduan, template, form, dan file unduhan</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalDokumen"
                data-modal-title="Upload Dokumen"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Dokumen
            </button>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Nama File
                            </th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Kategori
                            </th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Akses</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Ukuran</th>
                            <th class="text-right px-4 py-3.5 text-[11px] font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen as $d)
                            <tr class="table-row border-b border-white/5" data-row>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-lg {{ $d['tipe_class'] }} flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ $d['tipe'] }}</div>
                                        <div>
                                            <p class="font-semibold text-white">{{ $d['nama'] }}</p>
                                            <p class="text-[11px] text-slate-500">{{ $d['file'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-slate-300 text-xs">{{ $d['kategori'] }}</td>
                                <td class="px-4 py-3.5">
                                    <span class="kategori-badge {{ $d['akses_class'] }}">{{ $d['akses'] }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-slate-400 text-xs">{{ $d['ukuran'] }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" data-action="open-modal" data-target="modalDokumen"
                                            data-modal-title="Edit Dokumen – {{ $d['nama'] }}"
                                            data-form-fields='@json($d['form'])' title="Edit"
                                            class="w-8 h-8 rounded-lg bg-white/5 inline-flex items-center justify-center text-slate-400 hover:text-white transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" data-action="open-modal" data-target="modalDelete"
                                            data-form-action="{{ route('admin.cms.delete') }}"
                                            data-form-fields='@json(['jenis' => 'dokumen', 'id' => $d['id']])'
                                            data-modal-title="Hapus {{ $d['nama'] }}?" title="Hapus"
                                            class="w-8 h-8 rounded-lg bg-white/5 inline-flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada dokumen
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: FAQ -->
    <div data-panel="faq" data-group="cms" class="hidden space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-white">Manajemen FAQ</h2>
                <p class="text-xs text-slate-400">Pertanyaan yang sering diajukan</p>
            </div>
            <button type="button" data-action="open-modal" data-target="modalFaq" data-modal-title="Tambah FAQ"
                class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white text-sm font-bold rounded-xl shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah FAQ
            </button>
        </div>
        <div class="space-y-3">
            @forelse ($faq as $f)
                <div class="glass-card rounded-2xl p-5">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-8 h-8 rounded-lg bg-komdigi-blue/20 flex items-center justify-center text-komdigi-cerulean text-xs font-bold shrink-0">
                            {{ $loop->iteration }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="font-bold text-white text-sm">{{ $f['pertanyaan'] }}</h3>
                                <span class="kategori-badge {{ $f['kategori_class'] }}">{{ $f['kategori'] }}</span>
                            </div>
                            <p class="text-xs text-slate-400">{{ $f['jawaban'] }}</p>
                        </div>
                        <div class="flex gap-1 shrink-0">
                            <button type="button" data-action="open-modal" data-target="modalFaq"
                                data-modal-title="Edit FAQ – {{ $f['pertanyaan'] }}"
                                data-form-fields='@json($f['form'])' title="Edit"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" data-action="open-modal" data-target="modalDelete"
                                data-form-action="{{ route('admin.cms.delete') }}"
                                data-form-fields='@json(['jenis' => 'faq', 'id' => $f['id']])'
                                data-modal-title="Hapus FAQ?" title="Hapus"
                                class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada FAQ</p>
            @endforelse
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL: Tambah / Edit Kegiatan -->
    <div id="modalKegiatan" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalKegiatan"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit Kegiatan</h3>
                    <button type="button" data-action="close-modal" data-target="modalKegiatan"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}"
                    enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="kegiatan">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kegiatanJudul">Judul
                            Kegiatan *</label>
                        <input type="text" id="kegiatanJudul" name="judul" class="form-input"
                            placeholder="Menjadi announcer lagu Indonesia Raya" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="kegiatanDeskripsi">Deskripsi</label>
                        <textarea id="kegiatanDeskripsi" name="deskripsi" class="form-input" placeholder="Ceritakan kegiatan singkatnya..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="kegiatanTanggal">Tanggal</label>
                            <input type="date" id="kegiatanTanggal" name="tanggal" class="form-input">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="kegiatanKategori">Kategori</label>
                            <select id="kegiatanKategori" name="kategori" class="form-input">
                                <option value="Pribadi">Pribadi</option>
                                <option value="Semua">Semua User</option>
                                <option value="Tim">Tim</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="kegiatanCover">Foto
                            Cover</label>
                        <input type="file" id="kegiatanCover" name="cover" class="form-input" accept="image/*">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="kegiatanStatus">Status</label>
                            <select id="kegiatanStatus" name="status" class="form-input" required>
                                <option value="publish">Publish</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="flex items-end pb-2">
                            <label class="flex items-center gap-2 text-xs font-semibold text-slate-300 cursor-pointer">
                                <input type="checkbox" name="pin" value="1" class="w-4 h-4 rounded">
                                Pin di atas
                            </label>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalKegiatan"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Upload Foto Dokumentasi -->
    <div id="modalDokumentasi" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDokumentasi"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Upload Foto Dokumentasi</h3>
                    <button type="button" data-action="close-modal" data-target="modalDokumentasi"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}"
                    enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="dokumentasi">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Foto (bisa lebih dari
                            satu)</label>
                        <label class="dropzone block cursor-pointer">
                            <p class="text-sm text-slate-300">Klik atau drag foto di sini</p>
                            <p class="text-[11px] text-slate-500 mt-1">JPG, PNG, WEBP · Maks. 5 MB per foto</p>
                            <input type="file" name="foto[]" class="hidden" accept="image/*" multiple>
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="dokumentasiCaption">Caption</label>
                        <input type="text" id="dokumentasiCaption" name="judul" class="form-input"
                            placeholder="Contoh: Apel pagi minggu ke-5">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="dokumentasiKategori">Kategori</label>
                            <select id="dokumentasiKategori" name="kategori" class="form-input">
                                <option value="Umum">Umum</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Tim">Tim</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="dokumentasiTanggal">Tanggal</label>
                            <input type="date" id="dokumentasiTanggal" name="tanggal" class="form-input">
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalDokumentasi"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Anggota -->
    <div id="modalAnggota" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalAnggota"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit Anggota</h3>
                    <button type="button" data-action="close-modal" data-target="modalAnggota"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}"
                    enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="anggota">
                    <input type="hidden" name="id" value="">
                    <div class="flex items-center gap-4">
                        <div class="avatar-lg shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <label
                            class="px-3 py-2 bg-white/10 text-slate-200 text-xs font-semibold rounded-xl border border-white/10 cursor-pointer hover:bg-white/15 transition">
                            Upload Foto
                            <input type="file" name="foto" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="anggotaNama">Nama Lengkap
                            *</label>
                        <input type="text" id="anggotaNama" name="nama" class="form-input"
                            placeholder="Nisa Ramadani" required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="anggotaPosisi">Jabatan / Posisi</label>
                            <select id="anggotaPosisi" name="posisi" class="form-input" required>
                                <option value="peserta">Peserta</option>
                                <option value="pembimbing">Pembimbing</option>
                                <option value="koordinator">Koordinator</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="anggotaStatus">Status</label>
                            <select id="anggotaStatus" name="status" class="form-input" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="anggotaInstitusi">Institusi / Kampus</label>
                        <input type="text" id="anggotaInstitusi" name="institusi" class="form-input"
                            placeholder="Universitas Indonesia">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="anggotaBio">Bio
                            Singkat</label>
                        <textarea id="anggotaBio" name="bio" class="form-input" placeholder="Deskripsi singkat..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="anggotaInstagram">Instagram</label>
                            <input type="text" id="anggotaInstagram" name="instagram" class="form-input"
                                placeholder="@username">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="anggotaLinkedin">LinkedIn</label>
                            <input type="text" id="anggotaLinkedin" name="linkedin" class="form-input"
                                placeholder="URL profil">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="anggotaUrutan">Urutan
                            Tampilan</label>
                        <input type="number" id="anggotaUrutan" name="urutan" class="form-input" min="1"
                            value="1">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalAnggota"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Halaman -->
    <div id="modalHalaman" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalHalaman"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-2xl border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit Halaman</h3>
                    <button type="button" data-action="close-modal" data-target="modalHalaman"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}"
                    enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="halaman">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="halamanJudul">Judul
                            Halaman *</label>
                        <input type="text" id="halamanJudul" name="judul" class="form-input"
                            placeholder="Tentang Kami" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="halamanSlug">Slug /
                            URL</label>
                        <input type="text" id="halamanSlug" name="slug" class="form-input"
                            placeholder="tentang-kami">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Konten (Rich Text)</label>
                        <div class="rich-toolbar">
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="bold"><b>B</b></button>
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="italic"><i>I</i></button>
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="underline"><u>U</u></button>
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="formatBlock" data-value="<h2>">H2</button>
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="insertUnorderedList">• List</button>
                            <button type="button" data-action="rich-command" data-editor="#halamanKonten"
                                data-command="createLink">Link</button>
                        </div>
                        <div id="halamanKonten" class="rich-editor" contenteditable="true">Tulis konten halaman di
                            sini...</div>
                        <input type="hidden" name="konten" data-rich-target="#halamanKonten">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar Utama
                            (opsional)</label>
                        <label
                            class="inline-block px-4 py-2 bg-white/10 text-slate-200 text-sm font-semibold rounded-xl border border-white/10 cursor-pointer hover:bg-white/15 transition">
                            Upload Gambar
                            <input type="file" name="gambar" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="halamanStatus">Status</label>
                            <select id="halamanStatus" name="status" class="form-input" required>
                                <option value="publish">Publish</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="halamanSeoTitle">SEO
                                Title</label>
                            <input type="text" id="halamanSeoTitle" name="seo_title" class="form-input"
                                placeholder="Judul SEO">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="halamanSeoDescription">SEO Description</label>
                        <textarea id="halamanSeoDescription" name="seo_description" class="form-input" placeholder="Deskripsi untuk mesin pencari"></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalHalaman"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Pengumuman -->
    <div id="modalPengumuman" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalPengumuman"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit Pengumuman</h3>
                    <button type="button" data-action="close-modal" data-target="modalPengumuman"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="pengumuman">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="pengumumanJudul">Judul *</label>
                        <input type="text" id="pengumumanJudul" name="judul" class="form-input"
                            placeholder="Judul singkat" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="pengumumanIsi">Isi
                            Singkat</label>
                        <textarea id="pengumumanIsi" name="deskripsi" class="form-input" placeholder="Pesan pengumuman..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="pengumumanLink">Link Tujuan</label>
                        <input type="text" id="pengumumanLink" name="link" class="form-input"
                            placeholder="/daftar">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="pengumumanMulai">Tanggal Mulai</label>
                            <input type="date" id="pengumumanMulai" name="tanggal_mulai" class="form-input">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="pengumumanSelesai">Tanggal Berakhir</label>
                            <input type="date" id="pengumumanSelesai" name="tanggal_selesai" class="form-input">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="pengumumanTarget">Target</label>
                            <select id="pengumumanTarget" name="target" class="form-input" required>
                                <option value="Semua">Semua</option>
                                <option value="Peserta">Peserta</option>
                                <option value="Pembimbing">Pembimbing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="pengumumanPosisi">Posisi Tampil</label>
                            <select id="pengumumanPosisi" name="posisi" class="form-input" required>
                                <option value="Hero">Hero</option>
                                <option value="Popup">Popup</option>
                                <option value="Running Text">Running Text</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="pengumumanStatus">Status</label>
                        <select id="pengumumanStatus" name="status" class="form-input" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalPengumuman"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Menu -->
    <div id="modalMenu" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalMenu"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit Menu</h3>
                    <button type="button" data-action="close-modal" data-target="modalMenu"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="menu">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="menuLabel">Label Menu
                            *</label>
                        <input type="text" id="menuLabel" name="label" class="form-input" placeholder="Blog"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="menuUrl">URL /
                            Anchor</label>
                        <input type="text" id="menuUrl" name="url" class="form-input"
                            placeholder="#section atau /halaman">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="menuStatus">Status</label>
                        <select id="menuStatus" name="status" class="form-input" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="menuUrutan">Urutan</label>
                        <input type="number" id="menuUrutan" name="urutan" class="form-input" min="1"
                            value="1">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalMenu"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Upload / Edit Dokumen -->
    <div id="modalDokumen" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDokumen"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Upload / Edit Dokumen</h3>
                    <button type="button" data-action="close-modal" data-target="modalDokumen"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}"
                    enctype="multipart/form-data" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="dokumen">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="dokumenNama">Nama
                            Tampilan *</label>
                        <input type="text" id="dokumenNama" name="nama" class="form-input"
                            placeholder="Panduan Magang 2026" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">File</label>
                        <label class="dropzone block cursor-pointer">
                            <p class="text-sm text-slate-300">Klik atau drag file di sini</p>
                            <p class="text-[11px] text-slate-500 mt-1">PDF, DOC, DOCX, XLS, XLSX · Maks. 10 MB</p>
                            <input type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="dokumenKategori">Kategori</label>
                            <select id="dokumenKategori" name="kategori" class="form-input" required>
                                <option value="Panduan">Panduan</option>
                                <option value="Template">Template</option>
                                <option value="Form">Form</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="dokumenAkses">Akses Download</label>
                            <select id="dokumenAkses" name="akses" class="form-input" required>
                                <option value="Publik">Publik</option>
                                <option value="Login saja">Login saja</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalDokumen"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit FAQ -->
    <div id="modalFaq" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalFaq"></div>
        <div
            class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-lg border border-white/15 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Tambah / Edit FAQ</h3>
                    <button type="button" data-action="close-modal" data-target="modalFaq"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('admin.cms.store') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="faq">
                    <input type="hidden" name="id" value="">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                            for="faqPertanyaan">Pertanyaan *</label>
                        <input type="text" id="faqPertanyaan" name="pertanyaan" class="form-input"
                            placeholder="Siapa yang boleh mendaftar?" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5" for="faqJawaban">Jawaban
                            *</label>
                        <textarea id="faqJawaban" name="jawaban" class="form-input" placeholder="Jawaban lengkap..." required></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="faqKategori">Kategori FAQ</label>
                            <select id="faqKategori" name="kategori" class="form-input" required>
                                <option value="Umum">Umum</option>
                                <option value="Teknis">Teknis</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5"
                                for="faqUrutan">Urutan</label>
                            <input type="number" id="faqUrutan" name="urutan" class="form-input" min="1"
                                value="1">
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" data-action="close-modal" data-target="modalFaq"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="btn-shine flex-1 py-3 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-xl text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Konfirmasi Hapus (dipakai semua tab; jenis+id diisi via data-form-fields) -->
    <div id="modalDelete" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDelete"></div>
        <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-sm border border-white/15">
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-white mb-1" data-modal-title-slot>Hapus Item?</h3>
                <p class="text-sm text-slate-400 mb-5" data-modal-desc-slot>Item yang dihapus tidak dapat
                    dikembalikan.</p>
                <form method="POST" action="{{ route('admin.cms.delete') }}" data-modal-form>
                    @csrf
                    <input type="hidden" name="jenis" value="">
                    <input type="hidden" name="id" value="">
                    <div class="flex gap-3">
                        <button type="button" data-action="close-modal" data-target="modalDelete"
                            class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl text-sm border border-white/10 hover:bg-white/15 transition">Batal</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-gradient-to-r from-rose-500 to-rose-600 text-white font-bold rounded-xl text-sm">Ya,
                            Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

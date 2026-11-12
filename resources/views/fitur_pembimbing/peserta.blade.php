@extends('layouts.pembimbing')

@section('title', 'Daftar Peserta Bimbingan')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Manajemen Bimbingan</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Daftar Peserta Bimbingan</h1>
        </div>
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">10.30.00 WIB</p>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="glass-card rounded-3xl p-5">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Cari nama atau ID peserta..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-komdigi-cerulean focus:ring-1 focus:ring-komdigi-cerulean/40">
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <select id="filterStatus" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="selesai">Selesai</option>
                </select>
                <select id="filterPeriode" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Periode</option>
                    <option value="okt-des">Okt – Des 2026</option>
                    <option value="jul-sep">Jul – Sep 2026</option>
                </select>
                <select id="filterSort" class="text-xs font-medium bg-white/5 border border-white/10 text-slate-300 rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="skor-desc">Skor Tertinggi</option>
                    <option value="skor-asc">Skor Terendah</option>
                    <option value="hadir-desc">Kehadiran Tertinggi</option>
                    <option value="hadir-asc">Kehadiran Terendah</option>
                    <option value="nama">Nama A–Z</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Summary chips --}}
    <div class="flex flex-wrap gap-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            Aktif: <span class="text-white font-bold">{{ $ringkasan['aktif'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            Perlu Perhatian: <span class="text-white font-bold">{{ $ringkasan['perhatian'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            Selesai: <span class="text-white font-bold">{{ $ringkasan['selesai'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
            Total: <span class="text-white font-bold">{{ $ringkasan['total'] }}</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peserta</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Skor</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Kehadiran</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Logbook</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pesertaTable">
                    @foreach ($peserta as $p)
                        <tr class="table-row border-b border-white/5"
                            data-nama="{{ $p['nama'] }}"
                            data-institusi="{{ $p['institusi'] }}"
                            data-id="{{ $p['id_peserta'] }}"
                            data-status="{{ $p['status'] }}"
                            data-periode="{{ $p['periode_key'] }}"
                            data-skor="{{ $p['skor'] }}"
                            data-hadir="{{ $p['kehadiran'] }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl {{ $p['avatar'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $p['inisial'] }}</div>
                                    <div>
                                        <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="text-sm font-bold text-white hover:text-komdigi-cerulean transition">{{ $p['nama'] }}</a>
                                        <p class="text-[11px] text-slate-400">{{ $p['institusi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-300 font-medium">{{ $p['id_peserta'] }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-black {{ $p['skor_color'] }}">{{ $p['skor'] }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-semibold {{ $p['hadir_color'] }}">{{ $p['kehadiran'] }}%</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-semibold {{ $p['logbook_color'] }}">{{ $p['logbook_terisi'] }}/{{ $p['logbook_total'] }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $p['gaya']['badge'] }} text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $p['gaya']['dot'] }}"></span> {{ $p['gaya']['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-komdigi-blue/20 flex items-center justify-center text-slate-400 hover:text-komdigi-blue transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $p['id']]) }}" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-500/20 flex items-center justify-center text-slate-400 hover:text-amber-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    </a>
                                    <a href="{{ route('pembimbing.logbook') }}" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 flex items-center justify-center text-slate-400 hover:text-indigo-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="pesertaEmpty" class="hidden">
                        <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada peserta yang cocok dengan pencarian/filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-white/8">
            <p class="text-xs text-slate-400">Menampilkan <span class="text-white font-semibold" id="jumlahPeserta">{{ $jumlahPeserta }}</span> dari <span class="text-white font-semibold">{{ $jumlahPeserta }}</span> peserta</p>
            <div class="flex items-center gap-1.5">
                <button type="button" class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10 transition disabled:opacity-40" disabled>‹</button>
                <button type="button" class="w-8 h-8 rounded-lg bg-komdigi-blue text-white text-xs font-bold">1</button>
                <button type="button" class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 text-xs font-bold hover:bg-white/10 transition disabled:opacity-40" disabled>›</button>
            </div>
        </div>
    </div>

@endsection

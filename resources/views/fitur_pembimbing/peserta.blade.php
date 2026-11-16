@extends('layouts.pembimbing')

@section('title', 'Daftar Peserta Bimbingan')

@section('content')

    <x-page-header eyebrow="Manajemen bimbingan" title="Daftar Peserta Bimbingan" description="Pantau kehadiran dan perkembangan setiap peserta">
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-foreground" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-muted font-medium tabular-nums" id="current-time">10.30.00 WIB</p>
            </div>
        </div>
    </x-page-header>

    {{-- Filter & Search --}}
    <div class="glass-card rounded-2xl p-5">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            {{-- Search --}}
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" aria-hidden="true"></i>
                <input type="text" id="searchInput" placeholder="Cari nama atau ID peserta..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-surface border border-subtle rounded-xl text-foreground placeholder:text-muted focus:outline-none focus:border-komdigi-cerulean focus:ring-1 focus:ring-komdigi-cerulean/40">
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <select id="filterStatus" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="perhatian">Perlu Perhatian</option>
                    <option value="selesai">Selesai</option>
                </select>
                <select id="filterPeriode" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                    <option value="all">Semua Periode</option>
                    <option value="okt-des">Okt – Des 2026</option>
                    <option value="jul-sep">Jul – Sep 2026</option>
                </select>
                <select id="filterSort" class="text-xs font-medium bg-surface border border-subtle text-foreground rounded-xl px-3 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
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
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface border border-subtle text-xs font-semibold text-foreground">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            Aktif: <span class="text-foreground font-bold">{{ $ringkasan['aktif'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface border border-subtle text-xs font-semibold text-foreground">
            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
            Perlu Perhatian: <span class="text-foreground font-bold">{{ $ringkasan['perhatian'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface border border-subtle text-xs font-semibold text-foreground">
            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            Selesai: <span class="text-foreground font-bold">{{ $ringkasan['selesai'] }}</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface border border-subtle text-xs font-semibold text-foreground">
            Total: <span class="text-foreground font-bold">{{ $ringkasan['total'] }}</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead>
                    <tr class="border-b border-subtle">
                        <th class="px-5 py-4 text-[11px] font-bold text-muted uppercase tracking-wider">Peserta</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider">ID</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider text-center">Skor</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider text-center">Kehadiran</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider text-center">Logbook</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-muted uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pesertaTable">
                    @foreach ($peserta as $p)
                        <tr class="table-row border-b border-subtle"
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
                                        <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" class="text-sm font-bold text-foreground hover:text-komdigi-cerulean transition">{{ $p['nama'] }}</a>
                                        <p class="text-[11px] text-muted">{{ $p['institusi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-foreground font-medium">{{ $p['id_peserta'] }}</td>
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
                                    <a href="{{ route('pembimbing.detailpeserta', $p['id']) }}" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-surface hover:bg-komdigi-blue/20 flex items-center justify-center text-muted hover:text-komdigi-blue transition">
                                        <i data-lucide="eye" class="w-4 h-4" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('pembimbing.penilaianpeserta', ['peserta' => $p['id']]) }}" title="Beri Penilaian" class="w-8 h-8 rounded-lg bg-surface hover:bg-amber-500/20 flex items-center justify-center text-muted hover:text-amber-400 transition">
                                        <i data-lucide="star" class="w-4 h-4" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('pembimbing.logbook') }}" title="Lihat Logbook" class="w-8 h-8 rounded-lg bg-surface hover:bg-indigo-500/20 flex items-center justify-center text-muted hover:text-indigo-400 transition">
                                        <i data-lucide="file-text" class="w-4 h-4" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="pesertaEmpty" class="hidden">
                        <td colspan="7" class="px-5 py-10 text-center text-sm text-muted">Tidak ada peserta yang cocok dengan pencarian/filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-subtle">
            <p class="text-xs text-muted">Menampilkan <span class="text-foreground font-semibold" id="jumlahPeserta">{{ $jumlahPeserta }}</span> dari <span class="text-foreground font-semibold">{{ $jumlahPeserta }}</span> peserta</p>
            <div class="flex items-center gap-1.5">
                <button type="button" class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold hover:bg-elevated transition disabled:opacity-40" aria-label="Halaman sebelumnya" disabled><i data-lucide="chevron-left" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></button>
                <button type="button" class="w-8 h-8 rounded-lg bg-komdigi-blue text-white text-xs font-bold">1</button>
                <button type="button" class="w-8 h-8 rounded-lg bg-surface text-muted text-xs font-bold hover:bg-elevated transition disabled:opacity-40" aria-label="Halaman berikutnya" disabled><i data-lucide="chevron-right" class="w-4 h-4 inline-block align-middle" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>

@endsection

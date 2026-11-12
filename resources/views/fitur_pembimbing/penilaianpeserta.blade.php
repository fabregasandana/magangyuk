@extends('layouts.pembimbing')

@section('title', 'Penilaian Peserta')

@section('content')

    @php
        // Skor awal tertimbang (konsisten dengan kriteria dari controller; JS menghitung ulang saat load).
        $totalAwal = collect($kriteria)->sum(fn ($k) => $k['nilai'] * $k['weight']);
        $totalAwalTeks = number_format($totalAwal, 1, ',', '.');
        $gradeAwal = $totalAwal >= 90
            ? ['label' => 'Sangat Baik', 'kelas' => 'bg-emerald-500/15 text-emerald-400']
            : ($totalAwal >= 80
                ? ['label' => 'Baik', 'kelas' => 'bg-emerald-500/15 text-emerald-400']
                : ($totalAwal >= 70
                    ? ['label' => 'Cukup Baik', 'kelas' => 'bg-amber-500/15 text-amber-400']
                    : ['label' => 'Perlu Perbaikan', 'kelas' => 'bg-rose-500/15 text-rose-400']));
    @endphp

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-blue-100/80 font-medium">Manajemen Bimbingan</p>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Penilaian Peserta</h1>
        </div>
        <div class="flex items-center gap-3 glass px-4 py-2.5 rounded-2xl">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <div class="text-right">
                <p class="text-sm font-bold text-white" id="current-date">Jumat, 6 November 2026</p>
                <p class="text-xs text-blue-200/70 font-medium tabular-nums" id="current-time">11.40.00 WIB</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('pembimbing.penilaian.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="jenis_periode" id="jenisPeriode" value="mingguan">
        <input type="hidden" name="total_skor" id="totalSkorInput" value="{{ $totalAwal }}">

        {{-- Participant Selector Card --}}
        <div class="glass-card rounded-3xl p-5 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-center gap-5">
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-16 h-16 rounded-2xl {{ $pesertaTerpilih['avatar'] }} flex items-center justify-center text-white text-xl font-black shadow-lg shadow-blue-500/30 shrink-0 relative">
                        {{ $pesertaTerpilih['inisial'] }}
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center border-2 border-[#0a1628]">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $pesertaTerpilih['nama'] }}</h2>
                        <p class="text-sm text-slate-400 mt-0.5">Peserta Magang • ID: <span class="text-komdigi-cerulean font-medium">{{ $pesertaTerpilih['id_peserta'] }}</span></p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Institusi</span>
                                <span class="text-white font-medium">{{ $pesertaTerpilih['institusi'] }}</span>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Unit Kerja</span>
                                <span class="text-white font-medium">{{ $pesertaTerpilih['unit_kerja'] }}</span>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                                <span class="text-slate-400 block text-[10px] uppercase tracking-wide">Periode</span>
                                <span class="text-white font-medium">{{ $pesertaTerpilih['periode'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full {{ $pesertaTerpilih['gaya']['badge_soft'] }} text-xs font-bold border {{ $pesertaTerpilih['gaya']['border_soft'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $pesertaTerpilih['gaya']['dot_soft'] }}"></span> {{ $pesertaTerpilih['gaya']['label_panjang'] }}
                    </span>
                    <select id="pesertaSelect" name="peserta_id" class="text-sm bg-white/5 border border-white/10 text-white rounded-xl px-3 py-2 focus:outline-none focus:border-komdigi-cerulean">
                        @foreach ($opsiPeserta as $opsi)
                            <option value="{{ $opsi['id'] }}" @selected($opsi['id'] === $pesertaTerpilih['id'])>{{ $opsi['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

            {{-- LEFT: Form Penilaian (3 cols) --}}
            <div class="xl:col-span-3 space-y-5">
                <div class="glass-card rounded-3xl p-5 sm:p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Form Penilaian</h3>
                    </div>

                    {{-- Period Type --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <button type="button" class="period-btn active px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300 transition" data-periode-type="mingguan">Mingguan</button>
                        <button type="button" class="period-btn px-4 py-2 text-xs font-semibold rounded-xl border border-white/10 text-slate-300 transition hover:border-white/20" data-periode-type="bulanan">Bulanan</button>
                    </div>

                    <div class="mb-5">
                        <select id="periodeSelect" name="periode" class="w-full text-sm bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-komdigi-cerulean">
                            @foreach ($opsiPeriode['mingguan'] as $opsi)
                                <option value="{{ $opsi['value'] }}" data-periode-group="mingguan">{{ $opsi['label'] }}</option>
                            @endforeach
                            @foreach ($opsiPeriode['bulanan'] as $opsi)
                                <option value="{{ $opsi['value'] }}" data-periode-group="bulanan" hidden>{{ $opsi['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Criteria List --}}
                    <div class="space-y-4" id="criteriaList">
                        @foreach ($kriteria as $k)
                            <div class="kriteria-card p-4 rounded-2xl bg-white/[0.03] border border-white/8">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-white">{{ $k['label'] }}</span>
                                    <span class="text-[10px] font-medium text-slate-400 bg-white/5 px-2 py-0.5 rounded-md">Bobot {{ $k['bobot'] }}%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <input type="range" name="kriteria[{{ $k['key'] }}]" class="score-slider flex-1" min="0" max="100" value="{{ $k['nilai'] }}" data-weight="{{ $k['weight'] }}" data-default="{{ $k['nilai'] }}">
                                    <div class="w-12 text-center text-lg font-black text-komdigi-cerulean bg-komdigi-cerulean/10 rounded-lg py-1 score-value">{{ $k['nilai'] }}</div>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-2">{{ $k['deskripsi'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total Score --}}
                    <div class="mt-5 p-4 rounded-2xl bg-gradient-to-r from-komdigi-blue/15 to-komdigi-cerulean/10 border border-komdigi-cerulean/30 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-300 font-medium">Skor Total (Tertimbang)</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Berdasarkan bobot setiap aspek</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-black text-komdigi-cerulean" id="totalScore">{{ $totalAwalTeks }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $gradeAwal['kelas'] }}" id="gradeLabel">{{ $gradeAwal['label'] }}</span>
                        </div>
                    </div>

                    {{-- Comment --}}
                    <div class="mt-5">
                        <label for="overallComment" class="block text-sm font-medium text-slate-300 mb-2">Komentar Keseluruhan</label>
                        <textarea id="overallComment" name="komentar" rows="4" placeholder="Berikan feedback dan saran pengembangan untuk peserta magang..." class="w-full text-sm bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 placeholder-slate-500 focus:outline-none focus:border-komdigi-cerulean focus:ring-1 focus:ring-komdigi-cerulean/40 resize-y">{{ old('komentar') }}</textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                        <button type="button" data-action="reset-penilaian" class="px-5 py-2.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition cursor-pointer">
                            Reset
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Simpan Penilaian
                        </button>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Riwayat (2 cols) --}}
            <div class="xl:col-span-2">
                <div class="glass-card rounded-3xl p-5 sm:p-6 h-full">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-komdigi-cerulean/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-komdigi-cerulean" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">Riwayat Penilaian</h3>
                    </div>

                    <div class="space-y-3" id="historyList">
                        @forelse ($riwayat as $r)
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/8 hover:border-komdigi-cerulean/40 transition cursor-pointer">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-semibold text-white">{{ $r['periode'] }}</span>
                                    <span class="text-lg font-black {{ $r['warna'] }}">{{ $r['skor'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-slate-500 mb-2">
                                    <span>{{ $r['rentang'] }}</span>
                                    <span class="{{ $r['grade_color'] }} font-medium">{{ $r['grade'] }}</span>
                                </div>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $r['komentar'] }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Belum ada riwayat penilaian.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@extends('layouts.dashboardUser')

@section('title', 'Ajukan Ketidakhadiran')

@section('content')
    <div class="glass-panel p-5 sm:p-6 lg:p-8 space-y-6 min-h-[calc(100vh-120px)]">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight drop-shadow-sm">Ajukan Ketidakhadiran</h1>
                <p class="text-sm text-blue-100/80 font-medium mt-0.5">Isi formulir di bawah untuk mengajukan izin, sakit, atau cuti</p>
            </div>
            <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-komdigi-cerulean hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8">
            <form id="izin-form" method="POST" action="{{ route('peserta.izin.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Jenis Ketidakhadiran -->
                <div>
                    <label for="jenis" class="block text-sm font-semibold text-slate-300 mb-2">Jenis Ketidakhadiran</label>
                    <select id="jenis" name="jenis" class="form-input" required>
                        <option value="" disabled @selected(old('jenis') === null) selected>Pilih jenis</option>
                        @foreach ($jenisOptions as $value => $labelJenis)
                            <option value="{{ $value }}" @selected(old('jenis') === $value)>{{ $labelJenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-slate-300 mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-input" required>
                        @error('tanggal_mulai')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-slate-300 mb-2">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-input" required>
                        @error('tanggal_selesai')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alasan -->
                <div>
                    <label for="alasan" class="block text-sm font-semibold text-slate-300 mb-2">Alasan / Keterangan</label>
                    <textarea id="alasan" name="alasan" class="form-input min-h-[120px] resize-y" placeholder="Jelaskan alasan ketidakhadiran..." required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bukti Pendukung -->
                <div>
                    <label for="bukti" class="block text-sm font-semibold text-slate-300 mb-2">Bukti Pendukung <span class="text-slate-500 font-normal">(opsional)</span></label>
                    <div class="relative">
                        <label for="bukti" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/15 rounded-2xl cursor-pointer bg-white/5 hover:bg-white/8 hover:border-komdigi-cerulean/40 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <p class="text-sm text-slate-400"><span class="font-semibold text-komdigi-cerulean">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-slate-500 mt-1">Surat dokter, surat izin, atau dokumen lain (PDF/JPG, max 5MB)</p>
                            </div>
                            <input type="file" id="bukti" name="bukti" class="hidden" accept=".pdf,.jpg,.jpeg,.png" data-filename-target="izin-filename">
                        </label>
                        <p id="izin-filename" class="hidden text-xs font-semibold text-komdigi-cerulean mt-2 truncate"></p>
                    </div>
                    @error('bukti')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('peserta.dashboard') }}" class="flex-1 py-3.5 bg-white/10 text-slate-300 font-bold rounded-2xl hover:bg-white/15 transition text-sm border border-white/10 text-center">
                        Batal
                    </a>
                    <button type="submit" class="btn-shine flex-1 py-3.5 bg-gradient-to-r from-komdigi-blue to-komdigi-cerulean text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="glass-card rounded-3xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white mb-1">Catatan</p>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ $catatan }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

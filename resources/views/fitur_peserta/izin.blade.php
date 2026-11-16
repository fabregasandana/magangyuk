@extends('layouts.dashboardUser')

@section('title', 'Ajukan Ketidakhadiran')

@section('content')
    <div class="space-y-6 text-foreground">

        <x-page-header eyebrow="Perizinan" title="Ajukan Ketidakhadiran" description="Isi formulir di bawah untuk mengajukan izin, sakit, atau cuti">
            <a href="{{ route('peserta.dashboard') }}" class="ui-button-secondary inline-flex items-center gap-2 px-4 py-2.5 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                Kembali ke dashboard
            </a>
        </x-page-header>

        <!-- Form Card -->
        <div class="glass-card rounded-2xl p-6 sm:p-8">
            <form id="izin-form" method="POST" action="{{ route('peserta.izin.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Jenis Ketidakhadiran -->
                <div>
                    <label for="jenis" class="block text-sm font-semibold text-foreground mb-2">Jenis Ketidakhadiran</label>
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
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-foreground mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-input" required>
                        @error('tanggal_mulai')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-foreground mb-2">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-input" required>
                        @error('tanggal_selesai')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alasan -->
                <div>
                    <label for="alasan" class="block text-sm font-semibold text-foreground mb-2">Alasan / Keterangan</label>
                    <textarea id="alasan" name="alasan" class="form-input min-h-[120px] resize-y" placeholder="Jelaskan alasan ketidakhadiran..." required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bukti Pendukung -->
                <div>
                    <label for="bukti" class="block text-sm font-semibold text-foreground mb-2">Bukti Pendukung <span class="text-muted font-normal">(opsional)</span></label>
                    <div class="relative">
                        <label for="bukti" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-subtle rounded-2xl cursor-pointer bg-surface hover:bg-elevated hover:border-komdigi-cerulean/40 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i data-lucide="cloud-upload" class="w-8 h-8 text-muted mb-2" aria-hidden="true"></i>
                                <p class="text-sm text-muted"><span class="font-semibold text-komdigi-cerulean">Klik untuk upload</span> atau drag & drop</p>
                                <p class="text-xs text-muted mt-1">Surat dokter, surat izin, atau dokumen lain (PDF/JPG, max 5MB)</p>
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
                    <a href="{{ route('peserta.dashboard') }}" class="flex-1 py-3.5 bg-elevated text-foreground font-bold rounded-2xl hover:bg-elevated transition text-sm border border-subtle text-center">
                        Batal
                    </a>
                    <button type="submit" class="ui-button flex-1 py-3.5 transition text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                    <i data-lucide="info" class="w-4 h-4 text-amber-400" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-foreground mb-1">Catatan</p>
                    <p class="text-xs text-muted leading-relaxed">{{ $catatan }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

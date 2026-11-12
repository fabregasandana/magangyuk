{{--
    Modal konfirmasi hapus bersama (id: modalDelete).

    Cara pakai di view:
        @include('layouts.admin.modal-delete', [
            'route' => route('admin.peserta.delete'),
            'field' => 'id',
            'label' => 'data',
            'extra' => ['jenis' => ''],   // opsional: field tersembunyi tambahan
        ])

    Tombol pemicunya cukup memakai partial row-actions (delete_url + delete_label)
    atau atribut data-action="open-modal" data-target="modalDelete" secara langsung.
    openModal() di admin.js menimpa action form lewat data-form-action, mengisi
    input tersembunyi lewat data-form-field/data-form-value (atau beberapa field
    sekaligus lewat data-form-fields), dan judul lewat data-modal-title — sehingga
    satu modal ini bisa dipakai banyak tabel. Nilai pada 'extra' hanya default;
    isian sebenarnya dikirim tombol pemicu lewat data-form-fields.
--}}
@php
    $fieldHapus = $field ?? 'id';
    $labelHapus = $label ?? 'data';
    $extraHapus = $extra ?? [];
@endphp

<div id="modalDelete" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-overlay" data-action="close-modal" data-target="modalDelete"></div>
    <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-white/15">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-rose-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-white" data-modal-title-slot>Hapus {{ $labelHapus }}?</h3>
                    <p class="text-sm text-slate-400 mt-1" data-modal-desc-slot>
                        Tindakan ini tidak dapat dibatalkan. Seluruh data terkait akan ikut terhapus.
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ $route }}" data-modal-form>
                @csrf
                <input type="hidden" name="{{ $fieldHapus }}" value="">
                @foreach ($extraHapus as $namaExtra => $nilaiExtra)
                    <input type="hidden" name="{{ $namaExtra }}" value="{{ $nilaiExtra }}">
                @endforeach
                <div class="flex gap-3">
                    <button type="button" data-action="close-modal" data-target="modalDelete"
                        class="flex-1 py-3 bg-white/10 text-slate-300 font-bold rounded-xl hover:bg-white/15 transition text-sm border border-white/10">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold rounded-xl shadow-lg shadow-rose-500/30 text-sm">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

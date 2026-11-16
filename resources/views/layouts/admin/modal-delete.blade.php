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
    <div class="relative glass-strong rounded-3xl shadow-2xl w-full max-w-md border border-subtle">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-rose-500/15 flex items-center justify-center shrink-0">
                    <i data-lucide="triangle-alert" class="w-5 h-5 text-rose-400" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-foreground" data-modal-title-slot>Hapus {{ $labelHapus }}?</h3>
                    <p class="text-sm text-muted mt-1" data-modal-desc-slot>
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
                    <button type="button" data-action="close-modal" data-target="modalDelete" class="ui-button-secondary flex-1">Batal</button>
                    <button type="submit" class="ui-button ui-button-danger flex-1">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

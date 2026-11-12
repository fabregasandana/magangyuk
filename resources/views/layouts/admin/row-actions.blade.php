{{--
    Aksi baris tabel admin (partial bersama).
    Parameter lewat $actions:
      detail_modal   : id modal detail (opsional)
      edit_modal     : id modal edit (opsional)
      edit_title     : judul dinamis modal edit
      edit_fields    : array isian awal modal edit (data-form-fields JSON)
      assign_modal   : id modal assign (opsional)
      assign_title   : judul dinamis modal assign
      assign_desc    : deskripsi dinamis modal assign (data-modal-desc)
      form_field     : nama input tersembunyi utk konteks baris di modal
      form_value     : nilai input tersembunyi
      toggle_url     : URL POST toggle status (opsional)
      toggle_id      : id record utk toggle
      toggle_active  : bool status aktif sekarang
      delete_modal   : id modal konfirmasi hapus (default modalDelete)
      delete_url     : URL POST hapus (opsional)
      delete_label   : nama item utk judul modal hapus
      delete_field   : nama input tersembunyi modal hapus (default "id")
      delete_value   : nilai input tersembunyi modal hapus
--}}
<div class="flex items-center justify-end gap-1">
    @if (!empty($actions['detail_modal']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['detail_modal'] }}" title="Detail"
            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    @endif

    @if (!empty($actions['edit_modal']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['edit_modal'] }}"
            @if (!empty($actions['edit_title'])) data-modal-title="{{ $actions['edit_title'] }}" @endif
            @if (!empty($actions['edit_fields'])) data-form-fields='@json($actions['edit_fields'])' @endif
            title="Edit"
            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
    @endif

    @if (!empty($actions['assign_modal']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['assign_modal'] }}"
            @if (!empty($actions['assign_title'])) data-modal-title="{{ $actions['assign_title'] }}" @endif
            @if (!empty($actions['assign_desc'])) data-modal-desc="{{ $actions['assign_desc'] }}" @endif
            @if (!empty($actions['form_field'])) data-form-field="{{ $actions['form_field'] }}" data-form-value="{{ $actions['form_value'] ?? '' }}" @endif
            title="Assign Pembimbing"
            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-400 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </button>
    @endif

    @if (!empty($actions['toggle_url']))
        <form action="{{ $actions['toggle_url'] }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="id" value="{{ $actions['toggle_id'] ?? '' }}">
            @if (!empty($actions['toggle_active']))
                <button type="submit" title="Nonaktifkan"
                    class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </button>
            @else
                <button type="submit" title="Aktifkan"
                    class="w-8 h-8 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-slate-400 hover:text-emerald-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            @endif
        </form>
    @endif

    @if (!empty($actions['delete_url']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['delete_modal'] ?? 'modalDelete' }}"
            data-form-action="{{ $actions['delete_url'] }}"
            data-form-field="{{ $actions['delete_field'] ?? 'id' }}"
            data-form-value="{{ $actions['delete_value'] ?? ($actions['toggle_id'] ?? '') }}"
            @if (!empty($actions['delete_label'])) data-modal-title="Hapus {{ $actions['delete_label'] }}?" @endif
            title="Hapus"
            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-rose-500/20 flex items-center justify-center text-slate-400 hover:text-rose-400 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    @endif
</div>

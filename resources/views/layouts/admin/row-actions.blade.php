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
            class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted hover:text-foreground transition">
            <i data-lucide="eye" class="w-4 h-4" aria-hidden="true"></i>
        </button>
    @endif

    @if (!empty($actions['edit_modal']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['edit_modal'] }}"
            @if (!empty($actions['edit_title'])) data-modal-title="{{ $actions['edit_title'] }}" @endif
            @if (!empty($actions['edit_fields'])) data-form-fields='@json($actions['edit_fields'])' @endif
            title="Edit"
            class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted hover:text-foreground transition">
            <i data-lucide="square-pen" class="w-4 h-4" aria-hidden="true"></i>
        </button>
    @endif

    @if (!empty($actions['assign_modal']))
        <button type="button" data-action="open-modal" data-target="{{ $actions['assign_modal'] }}"
            @if (!empty($actions['assign_title'])) data-modal-title="{{ $actions['assign_title'] }}" @endif
            @if (!empty($actions['assign_desc'])) data-modal-desc="{{ $actions['assign_desc'] }}" @endif
            @if (!empty($actions['form_field'])) data-form-field="{{ $actions['form_field'] }}" data-form-value="{{ $actions['form_value'] ?? '' }}" @endif
            title="Assign Pembimbing"
            class="w-8 h-8 rounded-lg bg-surface hover:bg-elevated flex items-center justify-center text-muted hover:text-foreground transition">
            <i data-lucide="user-plus" class="w-4 h-4" aria-hidden="true"></i>
        </button>
    @endif

    @if (!empty($actions['toggle_url']))
        <form action="{{ $actions['toggle_url'] }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="id" value="{{ $actions['toggle_id'] ?? '' }}">
            @if (!empty($actions['toggle_active']))
                <button type="submit" title="Nonaktifkan"
                    class="w-8 h-8 rounded-lg bg-surface hover:bg-rose-500/20 flex items-center justify-center text-muted hover:text-rose-400 transition">
                    <i data-lucide="ban" class="w-4 h-4" aria-hidden="true"></i>
                </button>
            @else
                <button type="submit" title="Aktifkan"
                    class="w-8 h-8 rounded-lg bg-surface hover:bg-emerald-500/20 flex items-center justify-center text-muted hover:text-emerald-400 transition">
                    <i data-lucide="circle-check" class="w-4 h-4" aria-hidden="true"></i>
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
            class="w-8 h-8 rounded-lg bg-surface hover:bg-rose-500/20 flex items-center justify-center text-muted hover:text-rose-400 transition">
            <i data-lucide="trash-2" class="w-4 h-4" aria-hidden="true"></i>
        </button>
    @endif
</div>

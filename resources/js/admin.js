/**
 * Admin Panel — shared behaviour (Magang Komdigi 2026).
 *
 * Semua interaksi memakai event delegation + atribut data-action,
 * tanpa inline handler. Konten dari data pengguna selalu ditulis
 * dengan textContent (tidak pernah innerHTML).
 *
 * data-action yang didukung:
 *  - open-modal   (data-target, opsional data-form-action / data-modal-title / data-modal-desc)
 *  - close-modal  (data-target)
 *  - switch-tab   (data-tab, data-group, opsional data-title -> #pageTitle)
 *  - filter-table (data-table, data-key: "search" atau nama atribut data-* baris)
 *  - sort-table   (data-table, data-key, data-dir: asc|desc)
 *  - sort-select  (data-table; value: key-dir mis. "skor-desc")
 *  - rich-command (data-command: bold/italic/... untuk editor contenteditable)
 */

import Chart from 'chart.js/auto';

/* ------------------------------------------------------------------ */
/* Jam & tanggal (menggantikan updateDateTime() di mockup)             */
/* ------------------------------------------------------------------ */

const HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

function pad(n) {
    return String(n).padStart(2, '0');
}

function updateDateTime() {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    if (!dateEl && !timeEl) return;

    const now = new Date();
    if (dateEl) {
        dateEl.textContent = `${HARI[now.getDay()]}, ${now.getDate()} ${BULAN[now.getMonth()]} ${now.getFullYear()}`;
    }
    if (timeEl) {
        timeEl.textContent = `${pad(now.getHours())}.${pad(now.getMinutes())}.${pad(now.getSeconds())} WIB`;
    }
}

/* ------------------------------------------------------------------ */
/* Modal buka/tutup                                                    */
/* ------------------------------------------------------------------ */

/**
 * Salin nilai hidden input ber-`data-rich-target` ke editor contenteditable-nya.
 * Diperlukan saat modal edit mengisi `konten` lewat data-form-fields: admin
 * melihat editor, bukan hidden input, jadi keduanya harus sinkron.
 * Nilai berupa HTML yang sudah disanitasi server (Sanitizer::html).
 */
function syncRichEditor(input) {
    const selector = input.dataset?.richTarget;
    if (!selector) return;
    const editor = document.querySelector(selector);
    if (!editor) return;
    editor.innerHTML = input.value || '';
}

/**
 * Tulis satu nilai ke SEMUA field bernama sama di dalam modal.
 * Mencakup input, select, dan textarea karena modal edit memakai ketiganya
 * (mis. select institusi/pembimbing/periode, textarea deskripsi/bio/konten).
 * Checkbox/radio diset lewat properti `checked`, bukan `value`.
 */
function setFieldValues(modal, name, value) {
    const fields = modal.querySelectorAll(
        `input[name="${name}"], select[name="${name}"], textarea[name="${name}"]`
    );
    fields.forEach((field) => {
        if (field.type === 'checkbox' || field.type === 'radio') {
            field.checked = String(field.value) === String(value ?? '');
            return;
        }
        field.value = value ?? '';
        syncRichEditor(field);
    });
}

function openModal(id, trigger) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (trigger) {
        // Modal konfirmasi hapus: arahkan form ke URL aksi yang benar.
        const formAction = trigger.dataset.formAction;
        if (formAction) {
            const form = modal.querySelector('form[data-modal-form]');
            if (form) form.setAttribute('action', formAction);
        }

        const formField = trigger.dataset.formField;
        const formFields = trigger.dataset.formFields;

        // Tombol "Tambah …" tidak membawa data baris: kosongkan form agar sisa
        // isian dari edit sebelumnya tidak ikut terkirim.
        if (!formField && !formFields) {
            modal.querySelectorAll('form').forEach((form) => form.reset());
            // reset() tidak menyentuh contenteditable; kosongkan manual.
            modal.querySelectorAll('input[data-rich-target]').forEach(syncRichEditor);
        }

        // Salin nilai konteks baris ke SEMUA field bernama sama di dalam modal
        // (mendukung form utama + form inline, mis. unassign).
        if (formField) {
            setFieldValues(modal, formField, trigger.dataset.formValue || '');
        }
        // Beberapa field sekaligus via JSON (mis. modal hapus bersama CMS:
        // data-form-fields='{"jenis":"anggota","id":"AGT-1"}').
        if (formFields) {
            try {
                Object.entries(JSON.parse(formFields)).forEach(([name, value]) => {
                    setFieldValues(modal, name, value);
                });
            } catch (e) {
                // JSON tidak valid: abaikan tanpa memutus interaksi lain.
            }
        }
        // Judul/deskripsi dinamis (textContent, aman dari XSS).
        const title = trigger.dataset.modalTitle;
        if (title) {
            const titleEl = modal.querySelector('[data-modal-title-slot]');
            if (titleEl) titleEl.textContent = title;
        }
        const desc = trigger.dataset.modalDesc;
        if (desc) {
            const descEl = modal.querySelector('[data-modal-desc-slot]');
            if (descEl) descEl.textContent = desc;
        }
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/* ------------------------------------------------------------------ */
/* Tab / seksi (kelola penilaian, CMS, fitur pendukung)                */
/* ------------------------------------------------------------------ */

function switchTab(group, tab, trigger) {
    document.querySelectorAll(`[data-action="switch-tab"][data-group="${group}"]`).forEach((btn) => {
        const isActive = btn.dataset.tab === tab;
        btn.classList.toggle('active', isActive);
        // Hanya tombol bergaya .tab-btn yang memakai warna teks untuk state non-aktif
        // (kelola penilaian & CMS). nav-tab/set-tab diatur lewat CSS (.active).
        if (btn.classList.contains('tab-btn')) {
            btn.classList.toggle('text-slate-400', !isActive);
        }
    });

    document.querySelectorAll(`[data-panel][data-group="${group}"]`).forEach((panel) => {
        const isActive = panel.dataset.panel === tab;
        if (panel.classList.contains('tab-panel')) {
            // Fitur pendukung: display diatur oleh class .active.
            panel.classList.toggle('active', isActive);
        } else {
            panel.classList.toggle('hidden', !isActive);
        }
    });

    if (trigger && trigger.dataset.title) {
        const pageTitle = document.getElementById('pageTitle');
        if (pageTitle) pageTitle.textContent = trigger.dataset.title;
    }
}

/* ------------------------------------------------------------------ */
/* Filter tabel generik                                                */
/* ------------------------------------------------------------------ */

function getFilterControls(tableId) {
    return Array.from(document.querySelectorAll(`[data-action="filter-table"][data-table="${tableId}"]`));
}

function applyTableFilters(tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;
    const rows = table.querySelectorAll('tbody tr[data-row]');
    const controls = getFilterControls(tableId);

    rows.forEach((row) => {
        let visible = true;
        controls.forEach((control) => {
            const value = (control.value || '').toLowerCase();
            if (!value) return;
            const key = control.dataset.key;
            if (key === 'search') {
                if (!row.textContent.toLowerCase().includes(value)) visible = false;
            } else if ((row.dataset[key] || '').toLowerCase() !== value) {
                visible = false;
            }
        });
        row.style.display = visible ? '' : 'none';
    });

    // Perbarui info jumlah baris terlihat bila disediakan.
    const counter = document.querySelector(`[data-visible-count="${tableId}"]`);
    if (counter) {
        const shown = Array.from(rows).filter((r) => r.style.display !== 'none').length;
        counter.textContent = String(shown);
    }
}

/* ------------------------------------------------------------------ */
/* Sortir tabel (monitoring kinerja)                                   */
/* ------------------------------------------------------------------ */

function sortTable(tableId, key, dir) {
    const table = document.getElementById(tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    if (!tbody) return;
    const rows = Array.from(tbody.querySelectorAll('tr[data-row]'));

    rows.sort((a, b) => {
        const av = a.dataset[key] ?? '';
        const bv = b.dataset[key] ?? '';
        const an = parseFloat(av);
        const bn = parseFloat(bv);
        let cmp;
        if (!Number.isNaN(an) && !Number.isNaN(bn)) {
            cmp = an - bn;
        } else {
            cmp = av.localeCompare(bv, 'id');
        }
        return dir === 'asc' ? cmp : -cmp;
    });

    rows.forEach((row) => tbody.appendChild(row));
}

/* ------------------------------------------------------------------ */
/* Chart.js dari atribut data-chart='@json(...)'                       */
/* ------------------------------------------------------------------ */

function initCharts() {
    document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
        let config;
        try {
            config = JSON.parse(canvas.dataset.chart);
        } catch (e) {
            return;
        }
        if (config && typeof config === 'object') {
            new Chart(canvas, config);
        }
    });
}

/* ------------------------------------------------------------------ */
/* Delegasi event global                                               */
/* ------------------------------------------------------------------ */

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-action]');
    if (!trigger) return;

    const action = trigger.dataset.action;

    if (action === 'open-modal') {
        event.preventDefault();
        openModal(trigger.dataset.target, trigger);
        return;
    }

    if (action === 'close-modal') {
        event.preventDefault();
        closeModal(trigger.dataset.target);
        return;
    }

    if (action === 'switch-tab') {
        event.preventDefault();
        switchTab(trigger.dataset.group, trigger.dataset.tab, trigger);
        return;
    }

    if (action === 'sort-table') {
        event.preventDefault();
        sortTable(trigger.dataset.table, trigger.dataset.key, trigger.dataset.dir || 'asc');
        return;
    }

    if (action === 'rich-command') {
        event.preventDefault();
        const editor = document.querySelector(trigger.dataset.editor || '.rich-editor');
        if (editor) {
            editor.focus();
            if (trigger.dataset.command === 'createLink') {
                const url = window.prompt('Masukkan URL tautan:', 'https://');
                if (url) document.execCommand('createLink', false, url);
            } else {
                document.execCommand(trigger.dataset.command, false, trigger.dataset.value || null);
            }
        }
        return;
    }
});

document.addEventListener('input', (event) => {
    const trigger = event.target.closest('[data-action="filter-table"]');
    if (trigger) applyTableFilters(trigger.dataset.table);
});

document.addEventListener('change', (event) => {
    const filter = event.target.closest('[data-action="filter-table"]');
    if (filter) {
        applyTableFilters(filter.dataset.table);
        return;
    }

    const sorter = event.target.closest('[data-action="sort-select"]');
    if (sorter && sorter.value) {
        const idx = sorter.value.lastIndexOf('-');
        const key = sorter.value.slice(0, idx);
        const dir = sorter.value.slice(idx + 1);
        sortTable(sorter.dataset.table, key, dir);
    }
});

// Tutup modal dengan tombol Escape.
document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    document.querySelectorAll('.fixed.inset-0:not(.hidden)').forEach((modal) => {
        if (modal.id) closeModal(modal.id);
    });
});

// Sinkronkan konten rich editor ke hidden input sebelum form dikirim.
document.addEventListener('submit', (event) => {
    const form = event.target;
    form.querySelectorAll('input[data-rich-target]').forEach((input) => {
        const editor = document.querySelector(input.dataset.richTarget);
        if (editor) input.value = editor.innerHTML;
    });
});

/* ------------------------------------------------------------------ */
/* Init                                                                */
/* ------------------------------------------------------------------ */

function init() {
    updateDateTime();
    if (document.getElementById('current-date') || document.getElementById('current-time')) {
        setInterval(updateDateTime, 1000);
    }
    initCharts();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

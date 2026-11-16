/**
 * Skrip bersama halaman peserta MagangYuk.
 * Migrasi dari public/js/user/{user.js,dateTime.js,chart.js,absen.js}.
 *
 * Aturan: tanpa inline handler — semua via addEventListener + delegasi
 * (data-action / data-*). Satu file aman untuk semua halaman karena setiap
 * inisialisasi dijaga cek elemen. Data chart dibaca dari atribut
 * data-chart='@json($var)' pada <canvas>.
 */

import './app';
import { initCharts } from './charts';

/* ---------------------------------------------------------------------------
 * 1. Jam & tanggal real-time (dateTime.js lama) — elemen #current-date/#current-time
 * ------------------------------------------------------------------------- */
function initDateTime() {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');
    if (!dateEl || !timeEl) return;

    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    ];

    const update = () => {
        const now = new Date();
        dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        timeEl.textContent = `${h}.${m}.${s} WIB`;
    };

    update();
    setInterval(update, 1000);
}

/* ---------------------------------------------------------------------------
 * 3. Modal absen (absen.js lama) — delegasi data-action
 *    absen-open  : buka modal, set jenis (masuk/pulang) + judul + input hidden
 *    absen-close : tutup modal (tombol batal / X / backdrop)
 *    Submit "Ambil & Kirim" adalah form POST sungguhan (route peserta.absen.store).
 * ------------------------------------------------------------------------- */
function initAbsenModal() {
    const modal = document.getElementById('modal-absen');
    if (!modal) return;

    const title = document.getElementById('modal-title');
    const jenisInput = modal.querySelector('input[name="jenis"]');

    const openModal = (jenis) => {
        if (title) title.textContent = jenis === 'pulang' ? 'Absen Pulang' : 'Absen Masuk';
        if (jenisInput) jenisInput.value = jenis;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-action]');
        if (!trigger) return;
        const action = trigger.dataset.action;

        if (action === 'absen-open') {
            event.preventDefault();
            openModal(trigger.dataset.jenis || 'masuk');
        } else if (action === 'absen-close') {
            event.preventDefault();
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('flex')) closeModal();
    });
}

/* ---------------------------------------------------------------------------
 * 4. Filter riwayat kehadiran (riwayat.blade.php lama) — delegasi data-filter
 * ------------------------------------------------------------------------- */
function initRiwayatFilter() {
    const list = document.getElementById('attendance-list');
    if (!list) return;

    document.addEventListener('click', (event) => {
        const btn = event.target.closest('.filter-btn[data-filter]');
        if (!btn) return;

        // The active state is styled by .filter-btn.active, so only move the class.
        document.querySelectorAll('.filter-btn[data-filter]').forEach((b) => {
            b.classList.toggle('active', b === btn);
        });

        const filter = btn.dataset.filter;
        list.querySelectorAll('.attendance-item[data-status]').forEach((item) => {
            item.style.display =
                filter === 'all' || item.dataset.status === filter ? 'flex' : 'none';
        });
    });
}

/* ---------------------------------------------------------------------------
 * 5. Select bulan (riwayat) — auto-submit form GET saat berubah
 * ------------------------------------------------------------------------- */
function initAutoSubmitSelect() {
    document.addEventListener('change', (event) => {
        const select = event.target.closest('select[data-action="auto-submit"]');
        if (!select) return;
        const form = select.closest('form');
        if (form) form.submit();
    });
}

/* ---------------------------------------------------------------------------
 * 6. Halaman izin — tampilkan nama file yang dipilih (textContent, aman)
 * ------------------------------------------------------------------------- */
function initIzinFilePreview() {
    document.addEventListener('change', (event) => {
        const input = event.target.closest('input[type="file"][data-filename-target]');
        if (!input) return;
        const target = document.getElementById(input.dataset.filenameTarget);
        if (!target) return;
        const file = input.files && input.files[0];
        target.textContent = file ? file.name : '';
        target.classList.toggle('hidden', !file);
    });
}

/* ---------------------------------------------------------------------------
 * 7. Flash message — auto-dismiss
 * ------------------------------------------------------------------------- */
function initFlashAutoDismiss() {
    document.querySelectorAll('[data-flash-dismiss]').forEach((el) => {
        const delay = parseInt(el.dataset.flashDismiss, 10) || 5000;
        window.setTimeout(() => {
            el.classList.add('opacity-0', 'transition', 'duration-500');
            window.setTimeout(() => el.remove(), 500);
        }, delay);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initDateTime();
    initCharts();
    initAbsenModal();
    initRiwayatFilter();
    initAutoSubmitSelect();
    initIzinFilePreview();
    initFlashAutoDismiss();
});

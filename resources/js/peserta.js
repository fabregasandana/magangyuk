/**
 * Skrip bersama halaman peserta MagangYuk.
 * Migrasi dari public/js/user/{user.js,dateTime.js,chart.js,absen.js}.
 *
 * Aturan: tanpa inline handler — semua via addEventListener + delegasi
 * (data-action / data-*). Satu file aman untuk semua halaman karena setiap
 * inisialisasi dijaga cek elemen. Data chart dibaca dari atribut
 * data-chart='@json($var)' pada <canvas>.
 */

import Chart from 'chart.js/auto';

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
 * 2. Chart perkembangan (chart.js lama) — canvas[data-chart]
 *    Payload: { labels: [], data: [], variant: 'light'|'dark' }
 * ------------------------------------------------------------------------- */
function initCharts() {
    document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
        let payload;
        try {
            payload = JSON.parse(canvas.dataset.chart);
        } catch (e) {
            return;
        }
        if (!payload || !Array.isArray(payload.labels) || !Array.isArray(payload.data)) return;

        const dark = payload.variant === 'dark';
        const lineColor = dark ? '#38bdf8' : '#0055FF';

        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: payload.labels,
                datasets: [
                    {
                        label: payload.label ?? 'Skor Kinerja',
                        data: payload.data,
                        borderColor: lineColor,
                        backgroundColor: dark ? 'rgba(56, 189, 248, 0.12)' : 'rgba(0, 85, 255, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: lineColor,
                        pointBorderColor: dark ? '#0f172a' : '#fff',
                        pointBorderWidth: dark ? 3 : 2.5,
                        pointRadius: dark ? 6 : 5,
                        pointHoverRadius: dark ? 9 : 8,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: dark ? 'rgba(15, 23, 42, 0.95)' : '#00336C',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,
                        ...(dark
                            ? { borderColor: 'rgba(56, 189, 248, 0.3)', borderWidth: 1 }
                            : {}),
                    },
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 60,
                        max: 100,
                        grid: { color: dark ? 'rgba(255, 255, 255, 0.06)' : 'rgba(0, 85, 255, 0.08)' },
                        ticks: { color: dark ? '#94a3b8' : '#64748b', font: { size: 11 } },
                        border: { display: false },
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: dark ? '#94a3b8' : '#64748b', font: { size: 11 } },
                        border: { display: false },
                    },
                },
            },
        });
    });
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

        document.querySelectorAll('.filter-btn[data-filter]').forEach((b) => {
            b.classList.remove('active');
            b.classList.add('text-slate-300');
        });
        btn.classList.add('active');
        btn.classList.remove('text-slate-300');

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

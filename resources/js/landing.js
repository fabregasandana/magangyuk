/* ==========================================================================
 * Skrip landing page (index)
 * Migrasi dari public/js/countdown.js — tanpa inline handler, tanpa innerHTML
 * untuk konten dinamis (pakai textContent), dan di-guard dengan cek elemen.
 * File lama di public/ TIDAK dihapus, hanya tidak direferensikan lagi.
 * ========================================================================== */

const PERIODE_MULAI = new Date('2026-10-01T00:00:00').getTime();
const PERIODE_SELESAI = new Date('2026-12-19T23:59:59').getTime();

function initCountdown() {
    const elDays = document.getElementById('days');
    const elHours = document.getElementById('hours');
    const elMinutes = document.getElementById('minutes');
    const elSeconds = document.getElementById('seconds');
    const elProgressBar = document.getElementById('progress-bar');
    const elProgressText = document.getElementById('progress-text');

    // Guard: hanya jalan jika elemen countdown benar-benar ada di halaman.
    if (!elDays || !elHours || !elMinutes || !elSeconds || !elProgressBar || !elProgressText) {
        return;
    }

    const updateCountdown = () => {
        const now = Date.now();
        const distance = PERIODE_SELESAI - now;
        const totalDuration = PERIODE_SELESAI - PERIODE_MULAI;
        const elapsed = now - PERIODE_MULAI;

        if (distance < 0) {
            elDays.textContent = '0';
            elHours.textContent = '0';
            elMinutes.textContent = '0';
            elSeconds.textContent = '0';
            elProgressBar.style.width = '100%';
            elProgressText.textContent = '100%';
            return;
        }

        elDays.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24)));
        elHours.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        elMinutes.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
        elSeconds.textContent = String(Math.floor((distance % (1000 * 60)) / 1000));

        const progress = Math.min(100, Math.max(0, (elapsed / totalDuration) * 100));
        elProgressBar.style.width = `${progress.toFixed(1)}%`;
        elProgressText.textContent = `${progress.toFixed(0)}%`;
    };

    updateCountdown();
    window.setInterval(updateCountdown, 1000);
}

document.addEventListener('DOMContentLoaded', () => {
    initCountdown();
});

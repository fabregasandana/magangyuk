// Skrip halaman login.
// DILARANG inline handler & innerHTML:
// - Ikon toggle password memakai dua SVG yang sudah dirender di Blade,
//   ditampilkan/disembunyikan lewat class "hidden" (tanpa injeksi HTML).
// - Label tombol ("Lihat"/"Sembunyikan") diganti lewat textContent — BUKAN
//   innerHTML (perbaikan XSS dari mockup lama yang memakai icon.innerHTML).

const initPasswordToggle = () => {
    const buttons = document.querySelectorAll('[data-action="toggle-password"]');
    if (!buttons.length) return;

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.target || 'password';
            const input = document.getElementById(targetId);
            if (!input) return;

            const jadiTeks = input.type === 'password';
            input.type = jadiTeks ? 'text' : 'password';

            const iconEye = button.querySelector('[data-icon="eye"]');
            const iconEyeOff = button.querySelector('[data-icon="eye-off"]');
            if (iconEye) iconEye.classList.toggle('hidden', jadiTeks);
            if (iconEyeOff) iconEyeOff.classList.toggle('hidden', !jadiTeks);

            // Label teks tombol diganti via textContent (aman dari XSS).
            // Opsional: markup tombol saat ini icon-only, jadi hanya berjalan
            // bila ada elemen ber-data-label di dalam tombol.
            const label = button.querySelector('[data-label]');
            if (label) {
                label.textContent = jadiTeks ? 'Sembunyikan' : 'Lihat';
            }

            button.setAttribute('aria-pressed', jadiTeks ? 'true' : 'false');
            button.setAttribute(
                'aria-label',
                jadiTeks ? 'Sembunyikan password' : 'Tampilkan password'
            );
            input.focus();
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
});

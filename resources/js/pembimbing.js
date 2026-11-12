// Skrip bersama halaman pembimbing: jam/tanggal, filter, tab, chart, dsb.
// Semua memakai addEventListener + delegasi + atribut data-action (tanpa inline handler).
// Konten teks selalu diisi via textContent (tidak pernah innerHTML untuk data user).

import Chart from 'chart.js/auto';

/* ==========================================================================
   1. Jam & tanggal WIB
   ========================================================================== */

const NAMA_HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const NAMA_BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

function perbaruiJam() {
    const elTanggal = document.getElementById('current-date');
    const elJam = document.getElementById('current-time');
    if (!elTanggal && !elJam) return;

    // Format waktu WIB (UTC+7) tanpa tergantung zona waktu perangkat.
    const fmt = new Intl.DateTimeFormat('id-ID', {
        timeZone: 'Asia/Jakarta',
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false,
    });
    const bagian = fmt.formatToParts(new Date());
    const ambil = (tipe) => (bagian.find((b) => b.type === tipe) || {}).value || '';

    if (elTanggal) {
        elTanggal.textContent = `${ambil('weekday')}, ${ambil('day')} ${NAMA_BULAN[Number(ambil('month')) - 1] || ambil('month')} ${ambil('year')}`;
    }
    if (elJam) {
        elJam.textContent = `${ambil('hour')}.${ambil('minute')}.${ambil('second')} WIB`;
    }
}

// Fallback sederhana bila formatToParts tidak tersedia (browser sangat lama).
function perbaruiJamFallback() {
    const elTanggal = document.getElementById('current-date');
    const elJam = document.getElementById('current-time');
    if (!elTanggal && !elJam) return;
    const now = new Date();
    if (elTanggal) {
        elTanggal.textContent = `${NAMA_HARI[now.getDay()]}, ${now.getDate()} ${NAMA_BULAN[now.getMonth()]} ${now.getFullYear()}`;
    }
    if (elJam) {
        const p = (n) => String(n).padStart(2, '0');
        elJam.textContent = `${p(now.getHours())}.${p(now.getMinutes())}.${p(now.getSeconds())} WIB`;
    }
}

const mulaiJam = Intl.DateTimeFormat && Intl.DateTimeFormat.prototype.formatToParts ? perbaruiJam : perbaruiJamFallback;
mulaiJam();
if (document.getElementById('current-time') || document.getElementById('current-date')) {
    setInterval(mulaiJam, 1000);
}

/* ==========================================================================
   1b. Sidebar aktif berdasarkan URL (fallback; normalnya diset server-side
   oleh Blade via request()->routeIs(), jadi hanya jalan bila tak ada .active)
   ========================================================================== */

(function initSidebarActive() {
    const nav = document.getElementById('sidebar-nav');
    if (!nav || nav.querySelector('.sidebar-link.active')) return;
    const path = window.location.pathname.replace(/\/+$/, '') || '/';
    nav.querySelectorAll('.sidebar-link').forEach((link) => {
        try {
            const href = new URL(link.getAttribute('href'), window.location.origin);
            if (href.pathname.replace(/\/+$/, '') === path) link.classList.add('active');
        } catch (e) {
            /* href bukan URL valid — abaikan */
        }
    });
})();

/* ==========================================================================
   2. Chart.js — konfigurasi dibaca dari atribut data-chart pada canvas
   ========================================================================== */

document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
    let config;
    try {
        config = JSON.parse(canvas.dataset.chart);
    } catch (e) {
        console.error('Konfigurasi chart tidak valid pada #' + canvas.id, e);
        return;
    }
    config.options = Object.assign({ responsive: true, maintainAspectRatio: false }, config.options || {});
    new Chart(canvas, config);
});

/* ==========================================================================
   3. Halaman Daftar Peserta — pencarian, filter status/periode, sorting
   ========================================================================== */

(function initFilterPeserta() {
    const inputCari = document.getElementById('searchInput');
    const selectStatus = document.getElementById('filterStatus');
    const selectPeriode = document.getElementById('filterPeriode');
    const selectUrut = document.getElementById('filterSort');
    const tbody = document.getElementById('pesertaTable');
    const barisKosong = document.getElementById('pesertaEmpty');
    const labelJumlah = document.getElementById('jumlahPeserta');
    if (!tbody) return;

    const semuaBaris = Array.from(tbody.querySelectorAll('tr[data-nama]'));

    function terapkan() {
        const kata = (inputCari?.value || '').toLowerCase().trim();
        const status = selectStatus?.value || 'all';
        const periode = selectPeriode?.value || 'all';

        const tampil = semuaBaris.filter((baris) => {
            const cocokKata =
                !kata ||
                baris.dataset.nama.toLowerCase().includes(kata) ||
                (baris.dataset.institusi || '').toLowerCase().includes(kata) ||
                (baris.dataset.id || '').toLowerCase().includes(kata);
            const cocokStatus = status === 'all' || baris.dataset.status === status;
            const cocokPeriode = periode === 'all' || baris.dataset.periode === periode;
            return cocokKata && cocokStatus && cocokPeriode;
        });

        const urut = selectUrut?.value || 'skor-desc';
        tampil.sort((a, b) => {
            switch (urut) {
                case 'skor-asc':
                    return Number(a.dataset.skor) - Number(b.dataset.skor);
                case 'hadir-desc':
                    return Number(b.dataset.hadir) - Number(a.dataset.hadir);
                case 'hadir-asc':
                    return Number(a.dataset.hadir) - Number(b.dataset.hadir);
                case 'nama':
                    return a.dataset.nama.localeCompare(b.dataset.nama, 'id');
                case 'skor-desc':
                default:
                    return Number(b.dataset.skor) - Number(a.dataset.skor);
            }
        });

        semuaBaris.forEach((baris) => baris.classList.add('hidden'));
        tampil.forEach((baris) => {
            baris.classList.remove('hidden');
            tbody.appendChild(baris); // urutkan ulang DOM sesuai hasil sorting
        });

        if (barisKosong) {
            barisKosong.classList.toggle('hidden', tampil.length > 0);
        }
        if (labelJumlah) {
            labelJumlah.textContent = String(tampil.length);
        }
    }

    inputCari?.addEventListener('input', terapkan);
    selectStatus?.addEventListener('change', terapkan);
    selectPeriode?.addEventListener('change', terapkan);
    selectUrut?.addEventListener('change', terapkan);
    terapkan();
})();

/* ==========================================================================
   4. Tab (Detail Peserta & halaman lain yang memakai .tab-btn/.tab-content)
   ========================================================================== */

document.addEventListener('click', (event) => {
    const tombol = event.target.closest('.tab-btn[data-tab]');
    if (!tombol) return;
    const wadah = tombol.closest('[data-tab-group]') || document;
    wadah.querySelectorAll('.tab-btn[data-tab]').forEach((btn) => btn.classList.remove('active'));
    tombol.classList.add('active');
    document.querySelectorAll('.tab-content').forEach((panel) => {
        panel.classList.toggle('active', panel.id === `tab-${tombol.dataset.tab}`);
    });
});

/* ==========================================================================
   5. Approval Logbook — pilih item & tampilkan panel preview terkait
   ========================================================================== */

(function initLogbook() {
    const daftar = document.querySelectorAll('.logbook-item[data-id]');
    if (!daftar.length) return;

    const meta = document.getElementById('previewMeta');
    const inputId = document.getElementById('logbookIdInput');

    function pilih(id) {
        daftar.forEach((item) => {
            const aktif = item.dataset.id === id;
            item.classList.toggle('active', aktif);
            if (aktif && meta && item.dataset.meta) {
                meta.textContent = item.dataset.meta;
            }
        });
        document.querySelectorAll('[data-preview-for]').forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.previewFor !== id);
        });
        if (inputId) {
            inputId.value = id;
        }
    }

    daftar.forEach((item) => {
        item.addEventListener('click', () => pilih(item.dataset.id));
    });

    // Pilih item pertama secara default.
    pilih(daftar[0].dataset.id);
})();

// Filter daftar logbook (pencarian + filter peserta/tanggal/status).
(function initFilterLogbook() {
    const inputCari = document.getElementById('searchLogbook');
    const selectPeserta = document.getElementById('filterPeserta');
    const selectTanggal = document.getElementById('filterTanggal');
    const selectStatus = document.getElementById('filterStatusLogbook');
    const daftar = document.querySelectorAll('.logbook-item[data-id]');
    const kosong = document.getElementById('logbookEmpty');
    if (!daftar.length || (!inputCari && !selectPeserta && !selectTanggal && !selectStatus)) return;

    function terapkan() {
        const kata = (inputCari?.value || '').toLowerCase().trim();
        const peserta = selectPeserta?.value || 'all';
        const minggu = selectTanggal?.value || 'all';
        const status = selectStatus?.value || 'all';
        let tampil = 0;
        daftar.forEach((item) => {
            const cocok =
                (!kata || (item.dataset.nama || '').toLowerCase().includes(kata)) &&
                (peserta === 'all' || item.dataset.peserta === peserta) &&
                (minggu === 'all' || item.dataset.minggu === minggu) &&
                (status === 'all' || item.dataset.status === status);
            item.classList.toggle('hidden', !cocok);
            if (cocok) tampil += 1;
        });
        if (kosong) kosong.classList.toggle('hidden', tampil > 0);
    }

    inputCari?.addEventListener('input', terapkan);
    selectPeserta?.addEventListener('change', terapkan);
    selectTanggal?.addEventListener('change', terapkan);
    selectStatus?.addEventListener('change', terapkan);
})();

/* ==========================================================================
   6. Penilaian Peserta — slider bobot, total skor, periode, reset
   ========================================================================== */

const GRADE_STYLES = [
    { min: 90, label: 'Sangat Baik', kelas: 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400' },
    { min: 80, label: 'Baik', kelas: 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400' },
    { min: 70, label: 'Cukup Baik', kelas: 'px-3 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-400' },
    { min: -Infinity, label: 'Perlu Perbaikan', kelas: 'px-3 py-1 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400' },
];

function kelasGrade(skor) {
    return GRADE_STYLES.find((g) => skor >= g.min) || GRADE_STYLES[GRADE_STYLES.length - 1];
}

function hitungTotalPenilaian() {
    const slider = document.querySelectorAll('.score-slider');
    if (!slider.length) return;

    let total = 0;
    let totalBobot = 0;
    slider.forEach((s) => {
        const bobot = Number(s.dataset.weight || 0);
        total += Number(s.value) * bobot;
        totalBobot += bobot;
        const tampilan = s.closest('.kriteria-card')?.querySelector('.score-value') || s.parentElement?.querySelector('.score-value');
        if (tampilan) tampilan.textContent = s.value;
    });

    const nilai = totalBobot > 0 ? total / totalBobot : 0;
    const nilaiBulat = Math.round(nilai * 10) / 10;

    const elTotal = document.getElementById('totalScore');
    if (elTotal) elTotal.textContent = nilaiBulat.toFixed(1).replace('.', ',');
    const elInput = document.getElementById('totalSkorInput');
    if (elInput) elInput.value = String(nilaiBulat);

    const elGrade = document.getElementById('gradeLabel');
    if (elGrade) {
        const grade = kelasGrade(nilaiBulat);
        elGrade.textContent = grade.label;
        elGrade.className = grade.kelas;
    }
}

// Delegasi input slider.
document.addEventListener('input', (event) => {
    if (event.target.matches('.score-slider')) {
        const tampilan = event.target.closest('.kriteria-card')?.querySelector('.score-value');
        if (tampilan) tampilan.textContent = event.target.value;
        hitungTotalPenilaian();
    }
});

// Tombol jenis periode (Mingguan / Bulanan).
document.addEventListener('click', (event) => {
    const tombol = event.target.closest('.period-btn[data-periode-type]');
    if (!tombol) return;
    const jenis = tombol.dataset.periodeType;

    document.querySelectorAll('.period-btn[data-periode-type]').forEach((btn) => {
        btn.classList.toggle('active', btn === tombol);
    });

    const select = document.getElementById('periodeSelect');
    const inputJenis = document.getElementById('jenisPeriode');
    if (inputJenis) inputJenis.value = jenis;
    if (!select) return;

    let opsiTerpilih = null;
    select.querySelectorAll('option[data-periode-group]').forEach((opt) => {
        const cocok = opt.dataset.periodeGroup === jenis;
        opt.hidden = !cocok;
        if (cocok && !opsiTerpilih) opsiTerpilih = opt;
    });
    if (opsiTerpilih) select.value = opsiTerpilih.value;
});

// Reset form penilaian.
document.addEventListener('click', (event) => {
    if (!event.target.matches('[data-action="reset-penilaian"]')) return;
    event.preventDefault();
    const form = event.target.closest('form');
    if (!form) return;
    form.reset();
    form.querySelectorAll('.score-slider').forEach((s) => {
        s.value = s.dataset.default ?? s.defaultValue;
    });
    hitungTotalPenilaian();
});

hitungTotalPenilaian();

/* ==========================================================================
   7. Profil — mode edit data pribadi
   ========================================================================== */

(function initProfil() {
    const form = document.getElementById('profileForm');
    if (!form) return;
    const kolom = form.querySelectorAll('[data-profile-field]');
    const aksi = document.getElementById('editActions');
    const tombolEdit = document.querySelector('[data-action="edit-profil"]');

    function aturModeEdit(aktif) {
        kolom.forEach((input) => {
            input.disabled = !aktif;
        });
        if (aksi) aksi.classList.toggle('hidden', !aktif);
        if (tombolEdit) tombolEdit.classList.toggle('hidden', aktif);
    }

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-action="edit-profil"]')) {
            event.preventDefault();
            aturModeEdit(true);
            kolom[0]?.focus();
        }
        if (event.target.closest('[data-action="cancel-profil"]')) {
            event.preventDefault();
            form.reset();
            aturModeEdit(false);
        }
    });

    aturModeEdit(false);
})();

/* ==========================================================================
   8. Laporan Bimbingan — tombol export (tanpa alert)
   ========================================================================== */

document.addEventListener('click', (event) => {
    const tombol = event.target.closest('[data-action="export-pdf"], [data-action="export-excel"]');
    if (!tombol) return;
    event.preventDefault();
    const status = document.getElementById('exportStatus');
    if (!status) return;
    const jenis = tombol.dataset.action === 'export-pdf' ? 'PDF' : 'Excel';
    status.textContent = `Mempersiapkan export ${jenis} laporan bimbingan...`;
    status.classList.remove('hidden');
});

/* ==========================================================================
   9. Laporan Bimbingan — filter rekap kinerja (periode + status) client-side
   ========================================================================== */

(function initFilterLaporan() {
    const tbody = document.getElementById('rekapTable');
    if (!tbody) return;

    const selectPeriode = document.getElementById('filterPeriode');
    const selectStatus = document.getElementById('filterStatus');
    const barisKosong = document.getElementById('rekapEmpty');
    const baris = Array.from(tbody.querySelectorAll('tr[data-status]'));

    function terapkan() {
        const periode = selectPeriode?.value || 'all';
        const status = selectStatus?.value || 'all';
        let tampil = 0;

        baris.forEach((row) => {
            const cocokPeriode = periode === 'all' || row.dataset.periode === periode;
            const cocokStatus = status === 'all' || row.dataset.status === status;
            const cocok = cocokPeriode && cocokStatus;
            row.classList.toggle('hidden', !cocok);
            if (cocok) tampil += 1;
        });

        if (barisKosong) barisKosong.classList.toggle('hidden', tampil > 0);
    }

    selectPeriode?.addEventListener('change', terapkan);
    selectStatus?.addEventListener('change', terapkan);
    terapkan();
})();

/* ==========================================================================
   10. Detail Peserta — filter riwayat absensi per bulan (client-side)
   ========================================================================== */

(function initFilterAbsensi() {
    const tbody = document.getElementById('absensiTable');
    if (!tbody) return;

    const selectBulan = document.getElementById('filterBulan');
    const barisKosong = document.getElementById('absensiEmpty');
    const baris = Array.from(tbody.querySelectorAll('tr[data-bulan]'));

    function terapkan() {
        const bulan = selectBulan?.value || 'all';
        let tampil = 0;

        baris.forEach((row) => {
            const cocok = bulan === 'all' || row.dataset.bulan === bulan;
            row.classList.toggle('hidden', !cocok);
            if (cocok) tampil += 1;
        });

        if (barisKosong) barisKosong.classList.toggle('hidden', tampil > 0);
    }

    selectBulan?.addEventListener('change', terapkan);
    terapkan();
})();

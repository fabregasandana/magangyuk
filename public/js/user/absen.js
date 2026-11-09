let absenType = "masuk";
let sudahMasuk = false;

function handleAbsen(type) {
    absenType = type;
    document.getElementById("modal-title").textContent =
        type === "masuk" ? "Absen Masuk" : "Absen Pulang";
    document.getElementById("modal-absen").classList.remove("hidden");
    document.getElementById("modal-absen").classList.add("flex");
}

function closeModal() {
    document.getElementById("modal-absen").classList.add("hidden");
    document.getElementById("modal-absen").classList.remove("flex");
}

function confirmAbsen() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, "0");
    const m = String(now.getMinutes()).padStart(2, "0");
    const timeStr = `${h}.${m}`;

    if (absenType === "masuk") {
        document.getElementById("time-masuk").textContent = timeStr;
        sudahMasuk = true;
        const btnPulang = document.getElementById("btn-pulang");
        btnPulang.disabled = false;
        btnPulang.className =
            "btn-shine w-full py-3.5 bg-gradient-to-r from-komdigi-dark to-komdigi-blue text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl transition text-sm";
        btnPulang.textContent = "Absen Pulang Sekarang";
        btnPulang.onclick = () => handleAbsen("pulang");
        document.getElementById("card-pulang").classList.remove("opacity-60");
        const btnMasuk = document.getElementById("btn-masuk");
        btnMasuk.disabled = true;
        btnMasuk.className =
            "w-full py-3.5 bg-emerald-500/20 text-emerald-300 font-bold rounded-2xl cursor-default text-sm border border-emerald-500/30";
        btnMasuk.textContent = "✓ Sudah Absen Masuk";
        const badge = document.getElementById("status-badge");
        if (badge) {
            badge.className =
                "inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-400/90 text-emerald-900 text-xs font-bold rounded-full shadow-sm";
            badge.innerHTML =
                '<span class="w-1.5 h-1.5 bg-emerald-900 rounded-full"></span> Sudah Absen Masuk';
        }
    } else {
        document.getElementById("time-pulang").textContent = timeStr;
        const masukText = document.getElementById("time-masuk").textContent;
        if (masukText !== "—") {
            const [mh, mm] = masukText.split(".").map(Number);
            const masukMin = mh * 60 + mm;
            const pulangMin = now.getHours() * 60 + now.getMinutes();
            const diff = pulangMin - masukMin;
            const dh = Math.floor(diff / 60);
            const dm = diff % 60;
            document.getElementById("time-durasi").textContent =
                `${dh}j ${dm}m`;
        }
        const btnPulang = document.getElementById("btn-pulang");
        btnPulang.disabled = true;
        btnPulang.className =
            "w-full py-3.5 bg-emerald-500/20 text-emerald-300 font-bold rounded-2xl cursor-default text-sm border border-emerald-500/30";
        btnPulang.textContent = "✓ Sudah Absen Pulang";
    }
    closeModal();
}

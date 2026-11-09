function updateDateTime() {
    const now = new Date();
    const days = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    const dayName = days[now.getDay()];
    const dateStr = `${dayName}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

    const h = String(now.getHours()).padStart(2, "0");
    const m = String(now.getMinutes()).padStart(2, "0");
    const s = String(now.getSeconds()).padStart(2, "0");
    const timeStr = `${h}.${m}.${s} WIB`;

    document.getElementById("current-date").textContent = dateStr;
    document.getElementById("current-time").textContent = timeStr;
}
updateDateTime();
setInterval(updateDateTime, 1000);

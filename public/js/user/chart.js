const ctx = document.getElementById("progressChart").getContext("2d");
new Chart(ctx, {
    type: "line",
    data: {
        labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4", "Minggu 5"],
        datasets: [
            {
                label: "Skor Kinerja",
                data: [72, 78, 81, 83, 85],
                borderColor: "#0055FF",
                backgroundColor: "rgba(0, 85, 255, 0.1)",
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: "#0055FF",
                pointBorderColor: "#fff",
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 8,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: "#00336C",
                titleFont: { size: 13, weight: "bold" },
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 10,
                displayColors: false,
            },
        },
        scales: {
            y: {
                beginAtZero: false,
                min: 60,
                max: 100,
                grid: { color: "rgba(0, 85, 255, 0.08)" },
                ticks: { color: "#64748b", font: { size: 11 } },
            },
            x: {
                grid: { display: false },
                ticks: { color: "#64748b", font: { size: 11 } },
            },
        },
    },
});

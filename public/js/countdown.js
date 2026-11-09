const startDate = new Date("2026-10-01T00:00:00").getTime();
        const endDate = new Date("2026-12-19T23:59:59").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endDate - now;
            const totalDuration = endDate - startDate;
            const elapsed = now - startDate;

            if (distance < 0) {
                document.getElementById("days").innerText = "0";
                document.getElementById("hours").innerText = "0";
                document.getElementById("minutes").innerText = "0";
                document.getElementById("seconds").innerText = "0";
                document.getElementById("progress-bar").style.width = "100%";
                document.getElementById("progress-text").innerText = "100%";
                return;
            }

            document.getElementById("days").innerText = Math.floor(distance / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById("minutes").innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById("seconds").innerText = Math.floor((distance % (1000 * 60)) / 1000);

            // Progress
            let progress = Math.min(100, Math.max(0, (elapsed / totalDuration) * 100));
            document.getElementById("progress-bar").style.width = progress.toFixed(1) + "%";
            document.getElementById("progress-text").innerText = progress.toFixed(0) + "%";
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
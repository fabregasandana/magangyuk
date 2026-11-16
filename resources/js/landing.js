import './app';
import { initAnime } from './animations/anime';
import { initParallax, initScrollReveal } from './animations/gsap';

// Program dates use WIB, regardless of the visitor's device timezone.
const PERIOD_START = new Date('2026-10-01T00:00:00+07:00').getTime();
const PERIOD_END = new Date('2026-12-19T23:59:59+07:00').getTime();

function initCountdown() {
    const days = document.getElementById('days');
    const hours = document.getElementById('hours');
    const minutes = document.getElementById('minutes');
    const seconds = document.getElementById('seconds');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressRegion = document.getElementById('period-progress');
    const status = document.getElementById('period-status');
    const label = document.getElementById('countdown-label');

    if (![days, hours, minutes, seconds, progressBar, progressText, progressRegion, status, label].every(Boolean)) {
        return;
    }

    const update = () => {
        const now = Date.now();
        const remaining = Math.max(0, PERIOD_END - now);
        const progress = Math.min(100, Math.max(0, ((now - PERIOD_START) / (PERIOD_END - PERIOD_START)) * 100));
        const finished = now >= PERIOD_END;

        days.textContent = String(Math.floor(remaining / 86400000));
        hours.textContent = String(Math.floor((remaining % 86400000) / 3600000)).padStart(2, '0');
        minutes.textContent = String(Math.floor((remaining % 3600000) / 60000)).padStart(2, '0');
        seconds.textContent = String(Math.floor((remaining % 60000) / 1000)).padStart(2, '0');
        progressBar.style.width = `${progress.toFixed(1)}%`;
        progressText.textContent = `${Math.round(progress)}%`;
        progressRegion.setAttribute('aria-valuenow', progress.toFixed(1));

        const statusText = finished ? 'Periode selesai' : now < PERIOD_START ? 'Periode akan dimulai' : 'Periode sedang berlangsung';
        // Avoid re-announcing an unchanged live status every second.
        if (status.textContent !== statusText) status.textContent = statusText;
        label.textContent = finished ? 'Periode telah berakhir' : 'Menuju akhir periode';

        return finished;
    };

    if (!update()) {
        const interval = window.setInterval(() => {
            if (update()) window.clearInterval(interval);
        }, 1000);
    }
}

function initMobileNavigation() {
    const menu = document.querySelector('.landing-mobile-nav');
    if (!menu) return;

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => { menu.open = false; });
    });

    document.addEventListener('click', (event) => {
        if (!menu.contains(event.target)) menu.open = false;
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape' || !menu.open) return;
        menu.open = false;
        menu.querySelector('summary')?.focus();
    });

    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches) menu.open = false;
    });
}

function initLanding() {
    initCountdown();
    initMobileNavigation();

    const cleanups = [
        initScrollReveal(),
        initParallax(),
        initAnime(),
    ];
    const canvasCleanups = [];

    loadCanvasEffects(canvasCleanups);

    // Release observers, animation frames, and shader programs when the page goes away.
    window.addEventListener('pagehide', (event) => {
        if (event.persisted) return;
        cleanups.forEach((cleanup) => cleanup());
        canvasCleanups.forEach((cleanup) => cleanup());
    }, { once: true });
}

/**
 * Canvas and WebGL are loaded only after the page is interactive. Each module
 * checks support, pauses off-screen, and returns its own cleanup function.
 */
function loadCanvasEffects(cleanups) {
    const ripple = document.querySelector('[data-canvas-ripple]');
    const background = document.querySelector('[data-webgl-bg]');
    if (!ripple && !background) return;

    let cancelled = false;
    const start = () => {
        if (cancelled) return;
        if (background) {
            import('./animations/webgl')
                .then(({ initWebglBackground }) => cleanups.push(initWebglBackground(background)))
                .catch(() => {});
        }
        if (ripple) {
            import('./animations/canvas')
                .then(({ initAsciiRipple }) => cleanups.push(initAsciiRipple(ripple)))
                .catch(() => {});
        }
    };

    window.addEventListener('pagehide', () => { cancelled = true; }, { once: true });

    if ('requestIdleCallback' in window) {
        window.requestIdleCallback(start, { timeout: 1500 });
    } else {
        window.setTimeout(start, 250);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLanding, { once: true });
} else {
    initLanding();
}

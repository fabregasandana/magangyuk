import './app';
import {
    initAnime,
    initLandingIntro,
    initLandingScroll,
    initParallax,
} from './animations/anime';

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

/**
 * Scattered activity board: pointer dragging with a soft constraint inside the
 * stage. Cards settle back to their editorial layout when the board leaves the
 * viewport or the visitor presses "Rapikan".
 */
function initActivityBoard() {
    const stage = document.querySelector('[data-activity-stage]');
    if (!stage) return () => {};

    const cards = [...stage.querySelectorAll('[data-activity-card]')];
    if (!cards.length) return () => {};

    const resetButton = document.querySelector('[data-activity-reset]');
    const finePointer = window.matchMedia('(min-width: 1024px)');
    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);
    const readOffset = (card, name) => Number.parseFloat(card.style.getPropertyValue(name)) || 0;
    let moved = false;

    const setOffset = (card, x, y) => {
        card.style.setProperty('--drag-x', `${x.toFixed(1)}px`);
        card.style.setProperty('--drag-y', `${y.toFixed(1)}px`);
    };

    const resetCard = (card) => {
        card.classList.remove('is-dragging');
        card.style.removeProperty('--drag-x');
        card.style.removeProperty('--drag-y');
    };

    const resetAll = () => {
        moved = false;
        cards.forEach(resetCard);
    };

    const cleanups = [];

    cards.forEach((card) => {
        let drag = null;

        const onPointerDown = (event) => {
            if (!finePointer.matches || event.button !== 0) return;
            if (event.target.closest('a, button')) return;

            const stageRect = stage.getBoundingClientRect();
            const cardRect = card.getBoundingClientRect();
            drag = {
                pointerId: event.pointerId,
                startX: event.clientX,
                startY: event.clientY,
                baseX: readOffset(card, '--drag-x'),
                baseY: readOffset(card, '--drag-y'),
                minX: stageRect.left - cardRect.left,
                maxX: stageRect.right - cardRect.right,
                minY: stageRect.top - cardRect.top,
                maxY: stageRect.bottom - cardRect.bottom,
            };

            card.classList.add('is-dragging');
            card.setPointerCapture(event.pointerId);
            event.preventDefault();
        };

        const onPointerMove = (event) => {
            if (!drag || event.pointerId !== drag.pointerId) return;
            const x = clamp(
                drag.baseX + (event.clientX - drag.startX),
                Math.min(drag.minX, drag.maxX),
                Math.max(drag.minX, drag.maxX),
            );
            const y = clamp(
                drag.baseY + (event.clientY - drag.startY),
                Math.min(drag.minY, drag.maxY),
                Math.max(drag.minY, drag.maxY),
            );
            setOffset(card, x, y);
            moved = true;
        };

        const onPointerEnd = (event) => {
            if (!drag) return;
            if (event && event.pointerId !== drag.pointerId) return;
            const pointerId = drag.pointerId;
            drag = null;
            card.classList.remove('is-dragging');
            if (card.hasPointerCapture?.(pointerId)) card.releasePointerCapture(pointerId);
        };

        card.addEventListener('pointerdown', onPointerDown);
        card.addEventListener('pointermove', onPointerMove);
        card.addEventListener('pointerup', onPointerEnd);
        card.addEventListener('pointercancel', onPointerEnd);
        cleanups.push(() => {
            card.removeEventListener('pointerdown', onPointerDown);
            card.removeEventListener('pointermove', onPointerMove);
            card.removeEventListener('pointerup', onPointerEnd);
            card.removeEventListener('pointercancel', onPointerEnd);
        });
    });

    const onReset = () => resetAll();
    resetButton?.addEventListener('click', onReset);

    const boardObserver = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            if (entries.some((entry) => entry.isIntersecting)) return;
            if (moved) resetAll();
        }, { threshold: 0 })
        : null;
    boardObserver?.observe(stage);

    const onPointerCapabilityChange = (event) => {
        if (!event.matches) resetAll();
    };
    finePointer.addEventListener('change', onPointerCapabilityChange);

    return () => {
        cleanups.forEach((cleanup) => cleanup());
        resetButton?.removeEventListener('click', onReset);
        boardObserver?.disconnect();
        finePointer.removeEventListener('change', onPointerCapabilityChange);
    };
}

/**
 * Expanding gallery: the active panel grows while its siblings dim and turn
 * grayscale. Hover and keyboard focus both move the active state.
 */
function initGalleryAccordion() {
    const accordion = document.querySelector('[data-gallery-accordion]');
    if (!accordion) return () => {};

    const panels = [...accordion.querySelectorAll('[data-gallery-panel]')];
    if (!panels.length) return () => {};

    const activate = (panel) => {
        panels.forEach((item) => item.classList.toggle('is-active', item === panel));
    };

    if (!panels.some((panel) => panel.classList.contains('is-active'))) {
        activate(panels[0]);
    }

    const listeners = [];
    panels.forEach((panel) => {
        const onEnter = (event) => {
            if (event.pointerType && event.pointerType !== 'mouse' && event.pointerType !== 'pen') return;
            activate(panel);
        };
        const onFocus = () => activate(panel);
        panel.addEventListener('pointerenter', onEnter);
        panel.addEventListener('focus', onFocus);
        listeners.push(() => {
            panel.removeEventListener('pointerenter', onEnter);
            panel.removeEventListener('focus', onFocus);
        });
    });

    // On touch screens a tap should first open the accordion panel. Only a
    // second tap on the already-active panel follows the photo link.
    let suppressNavigation = false;
    const onPointerDown = (event) => {
        if (event.pointerType === 'mouse') return;
        const panel = event.target.closest('[data-gallery-panel]');
        if (!panel) return;
        suppressNavigation = !panel.classList.contains('is-active');
        if (suppressNavigation) activate(panel);
    };
    const onClick = (event) => {
        if (!suppressNavigation) return;
        suppressNavigation = false;
        event.preventDefault();
    };
    accordion.addEventListener('pointerdown', onPointerDown, true);
    accordion.addEventListener('click', onClick, true);

    const onKeyDown = (event) => {
        const keys = ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End'];
        if (!keys.includes(event.key)) return;

        const focused = document.activeElement?.closest?.('[data-gallery-panel]');
        const current = focused && accordion.contains(focused)
            ? panels.indexOf(focused)
            : panels.findIndex((panel) => panel.classList.contains('is-active'));
        if (current < 0) return;

        let next = current;
        if (event.key === 'Home') next = 0;
        else if (event.key === 'End') next = panels.length - 1;
        else {
            const direction = event.key === 'ArrowRight' || event.key === 'ArrowDown' ? 1 : -1;
            next = (current + direction + panels.length) % panels.length;
        }

        event.preventDefault();
        panels[next].focus();
        activate(panels[next]);
    };

    accordion.addEventListener('keydown', onKeyDown);

    return () => {
        listeners.forEach((cleanup) => cleanup());
        accordion.removeEventListener('keydown', onKeyDown);
        accordion.removeEventListener('pointerdown', onPointerDown, true);
        accordion.removeEventListener('click', onClick, true);
    };
}

/** Glass header state and pointer-tracked card highlights. */
function initLandingChrome() {
    const header = document.querySelector('[data-landing-header]');
    const shell = header?.closest('.landing-shell');
    let ticking = false;

    const syncHeader = () => {
        header?.classList.toggle('is-scrolled', window.scrollY > 8);
        ticking = false;
    };
    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(syncHeader);
    };

    // Keep the hero pulled behind the exact height of the floating bar, so no
    // flat strip shows above the tinted canvas at any breakpoint.
    const syncHeaderSpace = () => {
        if (!header || !shell) return;
        shell.style.setProperty('--lp-header-space', `${header.getBoundingClientRect().height}px`);
    };
    const headerObserver = header ? new ResizeObserver(syncHeaderSpace) : null;
    headerObserver?.observe(header);

    syncHeader();
    syncHeaderSpace();
    window.addEventListener('scroll', onScroll, { passive: true });

    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const cards = canHover ? [...document.querySelectorAll('[data-spotlight]')] : [];
    const onPointerMove = (event) => {
        const card = event.currentTarget;
        const rect = card.getBoundingClientRect();
        card.style.setProperty('--spot-x', `${event.clientX - rect.left}px`);
        card.style.setProperty('--spot-y', `${event.clientY - rect.top}px`);
    };
    cards.forEach((card) => card.addEventListener('pointermove', onPointerMove));

    // A small 3D tilt makes card hovers feel like the floating cards in the
    // reference. Values are written as CSS variables so reduced-motion CSS can
    // opt out without extra JavaScript branches.
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const tiltCards = canHover && !prefersReducedMotion ? [...document.querySelectorAll('[data-tilt]')] : [];
    const onTiltMove = (event) => {
        const card = event.currentTarget;
        const rect = card.getBoundingClientRect();
        const offsetX = (event.clientX - rect.left) / rect.width - 0.5;
        const offsetY = (event.clientY - rect.top) / rect.height - 0.5;
        card.style.setProperty('--tilt-x', `${(-offsetY * 5).toFixed(2)}deg`);
        card.style.setProperty('--tilt-y', `${(offsetX * 6).toFixed(2)}deg`);
    };
    const resetTilt = (event) => {
        event.currentTarget.style.setProperty('--tilt-x', '0deg');
        event.currentTarget.style.setProperty('--tilt-y', '0deg');
    };
    tiltCards.forEach((card) => {
        card.addEventListener('pointermove', onTiltMove);
        card.addEventListener('pointerleave', resetTilt);
    });

    return () => {
        window.removeEventListener('scroll', onScroll);
        headerObserver?.disconnect();
        cards.forEach((card) => card.removeEventListener('pointermove', onPointerMove));
        tiltCards.forEach((card) => {
            card.removeEventListener('pointermove', onTiltMove);
            card.removeEventListener('pointerleave', resetTilt);
        });
    };
}

function initLanding() {
    initCountdown();
    initMobileNavigation();

    const cleanups = [
        initLandingChrome(),
        initLandingIntro(),
        initLandingScroll(),
        initParallax(),
        initAnime(),
        initActivityBoard(),
        initGalleryAccordion(),
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
 * The CTA dot field is the only canvas left on the landing page: it is
 * loaded after the page is interactive, pauses off-screen, and stops
 * entirely when the tab is hidden or reduced motion is requested. The hero
 * light field is pure CSS, which keeps the first paint cheap.
 */
function loadCanvasEffects(cleanups) {
    const ripple = document.querySelector('[data-canvas-ripple]');
    if (!ripple) return;

    let cancelled = false;
    const start = () => {
        if (cancelled) return;
        import('./animations/canvas')
            .then(({ initDotGrid }) => cleanups.push(initDotGrid(ripple)))
            .catch(() => {});
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

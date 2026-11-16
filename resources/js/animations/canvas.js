/**
 * Canvas ASCII ripple for the landing call-to-action (PRD §8E).
 *
 * The effect is deliberately small: a fixed character grid, a single pass of
 * `fillText` per frame, a 30 fps cap, and rendering that stops whenever the
 * canvas is off-screen or the tab is hidden.
 */

const DEFAULT_GLYPHS = ' .·:-=+*#%@';

function hexToRgb(value, fallback) {
    const match = /^#?([\da-f]{3}|[\da-f]{6})$/i.exec(String(value).trim());
    if (!match) return fallback;
    let hex = match[1];
    if (hex.length === 3) hex = [...hex].map((part) => part + part).join('');
    return [
        parseInt(hex.slice(0, 2), 16),
        parseInt(hex.slice(2, 4), 16),
        parseInt(hex.slice(4, 6), 16),
    ];
}

export function initAsciiRipple(canvas, options = {}) {
    if (!(canvas instanceof HTMLCanvasElement)) return () => {};
    const context = canvas.getContext('2d', { alpha: true });
    if (!context) return () => {};

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const glyphs = options.glyphs ?? DEFAULT_GLYPHS;
    const host = canvas.parentElement ?? canvas;

    let width = 0;
    let height = 0;
    let points = [];
    let color = [139, 170, 255];
    let raf = 0;
    let running = false;
    let visible = false;
    let lastFrame = 0;
    let elapsed = 0;
    const pointer = { x: 0, y: 0, active: false };

    const readColor = () => {
        const raw = getComputedStyle(document.documentElement).getPropertyValue('--ui-accent');
        color = hexToRgb(raw, color);
    };

    const buildGrid = () => {
        const rect = canvas.getBoundingClientRect();
        width = Math.max(1, Math.round(rect.width));
        height = Math.max(1, Math.round(rect.height));
        if (!width || !height) return;

        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        context.setTransform(dpr, 0, 0, dpr, 0, 0);

        // Keep the grid between roughly 900 and 1500 characters on any screen.
        const cell = Math.max(14, Math.min(24, Math.round(Math.sqrt((width * height) / 1100))));
        const cols = Math.ceil(width / cell);
        const rows = Math.ceil(height / cell);
        const cx = width / 2;
        const cy = height * 0.55;
        const maxDistance = Math.hypot(width / 2, height / 2) || 1;

        points = [];
        for (let row = 0; row < rows; row += 1) {
            for (let col = 0; col < cols; col += 1) {
                const x = col * cell + cell / 2;
                const y = row * cell + cell / 2;
                points.push({
                    x,
                    y,
                    distance: Math.hypot(x - cx, y - cy) / maxDistance,
                    phase: (col * 7 + row * 13) % 17,
                });
            }
        }

        context.font = `600 ${Math.max(10, Math.round(cell - 2))}px "Plus Jakarta Sans Variable", sans-serif`;
        context.textAlign = 'center';
        context.textBaseline = 'middle';
    };

    const render = (time) => {
        if (!width || !height) return;
        context.clearRect(0, 0, width, height);
        context.fillStyle = `rgb(${color[0]} ${color[1]} ${color[2]} / 0.72)`;

        const seconds = time / 1000;
        const max = glyphs.length - 1;

        for (const point of points) {
            let intensity = 0.5
                + Math.sin(point.distance * 11 - seconds * 2.1 + point.phase * 0.05) * 0.34
                + Math.sin(point.x * 0.02 + seconds * 0.7) * Math.cos(point.y * 0.025 - seconds * 0.5) * 0.16;

            if (pointer.active) {
                const distance = Math.hypot(point.x - pointer.x, point.y - pointer.y);
                intensity += Math.max(0, 1 - distance / 170) * 0.55;
            }

            const index = Math.round(Math.min(1, Math.max(0, intensity)) * max);
            const glyph = glyphs[index];
            if (glyph === ' ') continue;
            context.fillText(glyph, point.x, point.y);
        }
    };

    const frame = (now) => {
        if (!running) return;
        raf = requestAnimationFrame(frame);
        // Roughly 30 fps is enough for a background texture and saves battery.
        if (now - lastFrame < 33) return;
        lastFrame = now;
        elapsed = now;
        render(now);
    };

    const canRun = () => visible && !document.hidden && !reducedMotion.matches;

    const start = () => {
        if (running || !canRun()) return;
        running = true;
        raf = requestAnimationFrame(frame);
    };

    const stop = () => {
        running = false;
        window.cancelAnimationFrame(raf);
    };

    const sync = () => {
        if (canRun()) start();
        else {
            stop();
            if (reducedMotion.matches) render(1200);
        }
    };

    const onPointerMove = (event) => {
        const rect = canvas.getBoundingClientRect();
        pointer.x = event.clientX - rect.left;
        pointer.y = event.clientY - rect.top;
        pointer.active = true;
    };

    const onPointerLeave = () => { pointer.active = false; };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            visible = entries.some((entry) => entry.isIntersecting);
            sync();
        }, { threshold: 0 })
        : null;

    const resizeObserver = 'ResizeObserver' in window ? new ResizeObserver(() => {
        buildGrid();
        sync();
        if (!running) render(elapsed || 1200);
    }) : null;

    const onVisibilityChange = () => sync();
    const onThemeChange = () => {
        readColor();
        if (!running) render(elapsed || 1200);
    };

    readColor();
    buildGrid();
    if (observer) observer.observe(canvas);
    else visible = true;
    resizeObserver?.observe(canvas);
    host.addEventListener('pointermove', onPointerMove);
    host.addEventListener('pointerleave', onPointerLeave);
    document.addEventListener('visibilitychange', onVisibilityChange);
    document.addEventListener('theme:change', onThemeChange);
    sync();

    return () => {
        stop();
        observer?.disconnect();
        resizeObserver?.disconnect();
        host.removeEventListener('pointermove', onPointerMove);
        host.removeEventListener('pointerleave', onPointerLeave);
        document.removeEventListener('visibilitychange', onVisibilityChange);
        document.removeEventListener('theme:change', onThemeChange);
    };
}

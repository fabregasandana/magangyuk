/**
 * Canvas backgrounds.
 *
 * `initAsciiRipple` is the small ASCII texture used by dashboard insight
 * cards. `initDotGrid` is the interactive dot field used by the landing
 * call-to-action. Both cap their frame rate, pause off-screen, and stop when
 * the tab is hidden or reduced motion is requested.
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

/**
 * Interactive dot-grid background for the landing call-to-action.
 *
 * The reference effect is a field of small dots that drift, repel around the
 * pointer, and ripple outward after a click. This 2D canvas version keeps the
 * same feel without shipping a WebGL renderer: one spring per dot, one pass of
 * draw calls per frame, a 40 fps cap, and rendering only while the CTA is
 * visible and the tab is awake.
 */
export function initDotGrid(canvas, options = {}) {
    if (!(canvas instanceof HTMLCanvasElement)) return () => {};
    const context = canvas.getContext('2d', { alpha: true });
    if (!context) return () => {};

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const host = canvas.closest('.landing-cta') ?? canvas.parentElement ?? canvas;

    let width = 0;
    let height = 0;
    let spacing = 24;
    let dots = [];
    let color = [255, 255, 255];
    let raf = 0;
    let running = false;
    let visible = false;
    let lastFrame = 0;
    let elapsed = 0;

    const pointer = { x: 0, y: 0, lastX: 0, lastY: 0, velocityX: 0, velocityY: 0, active: false };
    const waves = [];

    const readColor = () => {
        const styles = getComputedStyle(host);
        const raw = styles.getPropertyValue('--dot-grid-color')
            || styles.getPropertyValue('--ripple-color')
            || '#ffffff';
        color = hexToRgb(raw, color);
    };

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

    const buildGrid = () => {
        const rect = canvas.getBoundingClientRect();
        width = Math.max(1, Math.round(rect.width));
        height = Math.max(1, Math.round(rect.height));
        if (!width || !height) return;

        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        context.setTransform(dpr, 0, 0, dpr, 0, 0);

        // Keep roughly 700–1200 dots regardless of the CTA size.
        const targetCount = options.count ?? 1000;
        spacing = clamp(Math.sqrt((width * height) / targetCount), 18, 32);
        const cols = Math.ceil(width / spacing) + 2;
        const rows = Math.ceil(height / spacing) + 2;
        const offsetX = (width - (cols - 1) * spacing) / 2;
        const offsetY = (height - (rows - 1) * spacing) / 2;

        dots = [];
        for (let row = 0; row < rows; row += 1) {
            for (let col = 0; col < cols; col += 1) {
                const x = offsetX + col * spacing;
                const y = offsetY + row * spacing;
                dots.push({
                    x,
                    y,
                    originX: x,
                    originY: y,
                    velocityX: 0,
                    velocityY: 0,
                    phase: (col * 0.83 + row * 1.27) % (Math.PI * 2),
                });
            }
        }
    };

    const render = (now, withMotion = true) => {
        if (!width || !height || !dots.length) return;
        context.clearRect(0, 0, width, height);

        const seconds = now / 1000;
        const delta = Math.min(32, Math.max(12, now - (lastFrame || now - 16))) / 16.67;
        const activeWaves = [];
        for (const wave of waves) {
            const age = (now - wave.born) / 1000;
            if (age <= 1.6) activeWaves.push({ ...wave, age });
        }
        waves.length = 0;
        waves.push(...activeWaves);

        if (withMotion && pointer.active) {
            pointer.velocityX *= 0.9;
            pointer.velocityY *= 0.9;
        }

        context.fillStyle = `rgb(${color[0]} ${color[1]} ${color[2]})`;
        context.strokeStyle = context.fillStyle;
        context.lineCap = 'round';

        for (const dot of dots) {
            let forceX = 0;
            let forceY = 0;
            let energy = 0;

            if (withMotion) {
                const idleX = Math.sin(seconds * 0.52 + dot.phase + dot.originY * 0.012) * 1.15;
                const idleY = Math.cos(seconds * 0.46 + dot.phase * 1.3 + dot.originX * 0.014) * 1.15;
                forceX += (dot.originX + idleX - dot.x) * 0.055;
                forceY += (dot.originY + idleY - dot.y) * 0.055;

                if (pointer.active) {
                    const dx = dot.x - pointer.x;
                    const dy = dot.y - pointer.y;
                    const distance = Math.hypot(dx, dy) || 1;
                    const radius = spacing * 5.4;
                    if (distance < radius) {
                        const pressure = 1 - distance / radius;
                        const force = pressure * pressure * 3.1;
                        forceX += (dx / distance) * force;
                        forceY += (dy / distance) * force;
                        energy = Math.max(energy, pressure * 0.9);
                    }
                }

                for (const wave of activeWaves) {
                    const dx = dot.x - wave.x;
                    const dy = dot.y - wave.y;
                    const distance = Math.hypot(dx, dy) || 1;
                    const radius = wave.age * 430;
                    const band = Math.exp(-Math.pow((distance - radius) / 58, 2));
                    if (band < 0.02) continue;
                    const fade = Math.max(0, 1 - wave.age / 1.6);
                    const force = band * fade * 3.4;
                    forceX += (dx / distance) * force;
                    forceY += (dy / distance) * force;
                    energy = Math.max(energy, band * fade);
                }

                dot.velocityX = (dot.velocityX + forceX) * 0.9;
                dot.velocityY = (dot.velocityY + forceY) * 0.9;
                dot.velocityX = clamp(dot.velocityX, -18, 18);
                dot.velocityY = clamp(dot.velocityY, -18, 18);
                dot.x += dot.velocityX * delta;
                dot.y += dot.velocityY * delta;
            }

            const speed = Math.hypot(dot.velocityX, dot.velocityY);
            const glow = Math.min(1, speed * 0.34);
            const alpha = 0.13 + glow * 0.38 + energy * 0.3;
            const size = spacing < 22 ? 1.35 : 1.55;

            context.globalAlpha = alpha;
            if (speed > 1.1) {
                const stretch = Math.min(8, speed * 0.75);
                context.lineWidth = size + glow * 1.4;
                context.beginPath();
                context.moveTo(dot.x - dot.velocityX * stretch, dot.y - dot.velocityY * stretch);
                context.lineTo(dot.x, dot.y);
                context.stroke();
            } else {
                context.beginPath();
                context.arc(dot.x, dot.y, size + energy * 1.1, 0, Math.PI * 2);
                context.fill();
            }
        }

        if (withMotion && pointer.active) {
            const halo = context.createRadialGradient(pointer.x, pointer.y, 0, pointer.x, pointer.y, spacing * 5.5);
            halo.addColorStop(0, 'rgb(255 255 255 / 0.08)');
            halo.addColorStop(0.5, 'rgb(255 255 255 / 0.025)');
            halo.addColorStop(1, 'rgb(255 255 255 / 0)');
            context.globalAlpha = 1;
            context.fillStyle = halo;
            context.fillRect(0, 0, width, height);
        }

        context.globalAlpha = 1;
    };

    const frame = (now) => {
        if (!running) return;
        raf = requestAnimationFrame(frame);
        if (now - lastFrame < 24) return;
        render(now, true);
        lastFrame = now;
        elapsed = now;
    };

    const canRun = () => visible && !document.hidden && !reducedMotion.matches;

    const start = () => {
        if (running || !canRun()) return;
        running = true;
        lastFrame = 0;
        raf = requestAnimationFrame(frame);
    };

    const stop = () => {
        running = false;
        window.cancelAnimationFrame(raf);
    };

    const sync = () => {
        if (canRun()) {
            start();
            return;
        }
        stop();
        if (reducedMotion.matches) render(1400, false);
    };

    const setPointer = (event) => {
        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        if (pointer.active) {
            pointer.velocityX += (x - pointer.lastX) * 0.35;
            pointer.velocityY += (y - pointer.lastY) * 0.35;
        }
        pointer.x = x;
        pointer.y = y;
        pointer.lastX = x;
        pointer.lastY = y;
        pointer.active = true;
    };

    const onPointerMove = (event) => setPointer(event);

    const onPointerDown = (event) => {
        setPointer(event);
        waves.push({ x: pointer.x, y: pointer.y, born: performance.now() });
        if (waves.length > 6) waves.shift();
    };

    const onPointerLeave = () => {
        pointer.active = false;
        pointer.velocityX = 0;
        pointer.velocityY = 0;
    };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            visible = entries.some((entry) => entry.isIntersecting);
            sync();
        }, { threshold: 0 })
        : null;

    const resizeObserver = 'ResizeObserver' in window ? new ResizeObserver(() => {
        buildGrid();
        sync();
        if (!running) render(elapsed || 1400, false);
    }) : null;

    const onVisibilityChange = () => sync();
    const onThemeChange = () => {
        readColor();
        if (!running) render(elapsed || 1400, false);
    };
    const onMotionChange = () => sync();

    readColor();
    buildGrid();
    if (observer) observer.observe(canvas);
    else visible = true;
    resizeObserver?.observe(canvas);
    host.addEventListener('pointermove', onPointerMove);
    host.addEventListener('pointerdown', onPointerDown);
    host.addEventListener('pointerleave', onPointerLeave);
    document.addEventListener('visibilitychange', onVisibilityChange);
    document.addEventListener('theme:change', onThemeChange);
    reducedMotion.addEventListener('change', onMotionChange);
    sync();

    return () => {
        stop();
        observer?.disconnect();
        resizeObserver?.disconnect();
        host.removeEventListener('pointermove', onPointerMove);
        host.removeEventListener('pointerdown', onPointerDown);
        host.removeEventListener('pointerleave', onPointerLeave);
        document.removeEventListener('visibilitychange', onVisibilityChange);
        document.removeEventListener('theme:change', onThemeChange);
        reducedMotion.removeEventListener('change', onMotionChange);
    };
}

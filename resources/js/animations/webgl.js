/**
 * WebGL animated background for the landing hero (PRD §8F).
 *
 * One full-screen shader, no external 3D library. Rendering stops when the
 * canvas leaves the viewport or the tab is hidden, and a missing WebGL context
 * quietly falls back to the CSS radial gradients already painted by landing.css.
 */

const VERTEX_SOURCE = `
attribute vec2 a_position;

void main() {
    gl_Position = vec4(a_position, 0.0, 1.0);
}
`;

const FRAGMENT_SOURCE = `
precision mediump float;

uniform vec2 u_resolution;
uniform float u_time;
uniform vec2 u_pointer;
uniform vec3 u_cool;
uniform vec3 u_warm;

void main() {
    vec2 uv = gl_FragCoord.xy / u_resolution.xy;
    vec2 p = uv * 2.0 - 1.0;
    p.x *= u_resolution.x / u_resolution.y;

    float t = u_time * 0.12;
    float radius = length(p);
    float angle = atan(p.y, p.x);

    // A slow domain warp keeps the tunnel from looking mechanically circular.
    vec2 warp = vec2(
        sin(p.y * 2.2 + t * 1.4),
        cos(p.x * 1.9 - t * 1.1)
    ) * 0.16;
    vec2 q = p + warp;

    float tunnel = sin(length(q) * 5.2 - t * 3.0 + sin(angle * 3.0 + t) * 0.6);
    float rings = smoothstep(-0.2, 0.9, tunnel);
    float glow = smoothstep(1.25, 0.15, radius);
    float pointerGlow = smoothstep(0.7, 0.0, length(p - u_pointer));

    vec3 color = mix(u_cool, u_warm, rings * 0.7 + glow * 0.3);
    float alpha = rings * 0.3 + glow * 0.26 + pointerGlow * 0.22;

    gl_FragColor = vec4(color, alpha * 0.85);
}
`;

function hexToUnitRgb(value, fallback) {
    const match = /^#?([\da-f]{3}|[\da-f]{6})$/i.exec(String(value).trim());
    const source = match ? (match[1].length === 3 ? [...match[1]].map((part) => part + part).join('') : match[1]) : null;
    if (!source) return fallback;
    return [
        parseInt(source.slice(0, 2), 16) / 255,
        parseInt(source.slice(2, 4), 16) / 255,
        parseInt(source.slice(4, 6), 16) / 255,
    ];
}

function compileShader(gl, type, source) {
    const shader = gl.createShader(type);
    if (!shader) return null;
    gl.shaderSource(shader, source);
    gl.compileShader(shader);
    if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        gl.deleteShader(shader);
        return null;
    }
    return shader;
}

function createProgram(gl) {
    const vertex = compileShader(gl, gl.VERTEX_SHADER, VERTEX_SOURCE);
    const fragment = compileShader(gl, gl.FRAGMENT_SHADER, FRAGMENT_SOURCE);
    if (!vertex || !fragment) return null;

    const program = gl.createProgram();
    if (!program) return null;
    gl.attachShader(program, vertex);
    gl.attachShader(program, fragment);
    gl.linkProgram(program);
    gl.deleteShader(vertex);
    gl.deleteShader(fragment);

    if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
        gl.deleteProgram(program);
        return null;
    }
    return program;
}

export function initWebglBackground(canvas, options = {}) {
    if (!(canvas instanceof HTMLCanvasElement)) return () => {};

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const gl = canvas.getContext('webgl', {
        alpha: true,
        antialias: false,
        depth: false,
        stencil: false,
        premultipliedAlpha: false,
        powerPreference: 'low-power',
    }) ?? canvas.getContext('experimental-webgl');

    // No WebGL: keep the CSS gradient fallback and remove the empty canvas.
    if (!gl) {
        canvas.hidden = true;
        return () => {};
    }

    let program = null;
    let buffer = null;
    let uniforms = {};
    const host = canvas.closest('.landing-hero') ?? canvas.parentElement ?? canvas;

    const setupGpu = () => {
        program = createProgram(gl);
        if (!program) return false;

        buffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
        gl.useProgram(program);
        const position = gl.getAttribLocation(program, 'a_position');
        gl.enableVertexAttribArray(position);
        gl.vertexAttribPointer(position, 2, gl.FLOAT, false, 0, 0);
        gl.enable(gl.BLEND);
        gl.blendFunc(gl.SRC_ALPHA, gl.ONE_MINUS_SRC_ALPHA);
        gl.clearColor(0, 0, 0, 0);

        uniforms = {
            resolution: gl.getUniformLocation(program, 'u_resolution'),
            time: gl.getUniformLocation(program, 'u_time'),
            pointer: gl.getUniformLocation(program, 'u_pointer'),
            cool: gl.getUniformLocation(program, 'u_cool'),
            warm: gl.getUniformLocation(program, 'u_warm'),
        };
        return true;
    };

    if (!setupGpu()) {
        canvas.hidden = true;
        return () => {};
    }

    let colorCool = hexToUnitRgb(getComputedStyle(document.documentElement).getPropertyValue('--ui-primary'), [0.36, 0.49, 1]);
    let colorWarm = hexToUnitRgb(getComputedStyle(document.documentElement).getPropertyValue('--ui-accent'), [0.55, 0.67, 1]);
    const pointer = { x: 0, y: 0, targetX: 0, targetY: 0 };
    let raf = 0;
    let running = false;
    let visible = false;
    let lost = false;
    let lastFrame = 0;
    let startedAt = performance.now();

    const resize = () => {
        const rect = canvas.getBoundingClientRect();
        const mobile = window.matchMedia('(max-width: 767px)').matches;
        const dpr = Math.min(window.devicePixelRatio || 1, mobile ? 1.25 : 1.75);
        const width = Math.max(1, Math.round(rect.width * dpr));
        const height = Math.max(1, Math.round(rect.height * dpr));
        if (canvas.width !== width || canvas.height !== height) {
            canvas.width = width;
            canvas.height = height;
            gl.viewport(0, 0, width, height);
        }
    };

    const draw = (time) => {
        if (lost) return;
        const seconds = reducedMotion.matches ? 0.8 : (time - startedAt) / 1000;
        pointer.x += (pointer.targetX - pointer.x) * 0.08;
        pointer.y += (pointer.targetY - pointer.y) * 0.08;

        gl.clear(gl.COLOR_BUFFER_BIT);
        gl.useProgram(program);
        gl.uniform2f(uniforms.resolution, canvas.width, canvas.height);
        gl.uniform1f(uniforms.time, seconds);
        gl.uniform2f(uniforms.pointer, pointer.x, pointer.y);
        gl.uniform3fv(uniforms.cool, colorCool);
        gl.uniform3fv(uniforms.warm, colorWarm);
        gl.drawArrays(gl.TRIANGLES, 0, 3);
    };

    const frame = (time) => {
        if (!running) return;
        raf = requestAnimationFrame(frame);
        // 40 fps is plenty for a soft background and keeps GPU use modest.
        if (time - lastFrame < 25) return;
        lastFrame = time;
        draw(time);
    };

    const canRun = () => visible && !document.hidden && !lost && !reducedMotion.matches;

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
            if (reducedMotion.matches || !visible) draw(performance.now());
        }
    };

    const readColors = () => {
        const styles = getComputedStyle(document.documentElement);
        colorCool = hexToUnitRgb(styles.getPropertyValue('--ui-primary'), colorCool);
        colorWarm = hexToUnitRgb(styles.getPropertyValue('--ui-accent'), colorWarm);
        if (!running) draw(performance.now());
    };

    const onPointerMove = (event) => {
        const rect = host.getBoundingClientRect();
        const aspect = rect.width / Math.max(1, rect.height);
        pointer.targetX = ((event.clientX - rect.left) / rect.width * 2 - 1) * aspect;
        pointer.targetY = -((event.clientY - rect.top) / rect.height * 2 - 1);
    };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            visible = entries.some((entry) => entry.isIntersecting);
            sync();
        }, { threshold: 0 })
        : null;

    const resizeObserver = 'ResizeObserver' in window ? new ResizeObserver(() => {
        resize();
        if (!running) draw(performance.now());
    }) : null;

    const onVisibilityChange = () => sync();
    const onThemeChange = () => readColors();
    const onContextLost = (event) => {
        event.preventDefault();
        stop();
        lost = true;
    };
    const onContextRestored = () => {
        lost = false;
        if (!setupGpu()) {
            canvas.hidden = true;
            return;
        }
        startedAt = performance.now();
        sync();
    };

    resize();
    if (observer) observer.observe(canvas);
    else visible = true;
    resizeObserver?.observe(canvas);
    host.addEventListener('pointermove', onPointerMove);
    document.addEventListener('visibilitychange', onVisibilityChange);
    document.addEventListener('theme:change', onThemeChange);
    canvas.addEventListener('webglcontextlost', onContextLost);
    canvas.addEventListener('webglcontextrestored', onContextRestored);
    sync();
    draw(performance.now());

    return () => {
        stop();
        observer?.disconnect();
        resizeObserver?.disconnect();
        host.removeEventListener('pointermove', onPointerMove);
        document.removeEventListener('visibilitychange', onVisibilityChange);
        document.removeEventListener('theme:change', onThemeChange);
        canvas.removeEventListener('webglcontextlost', onContextLost);
        canvas.removeEventListener('webglcontextrestored', onContextRestored);
        gl.deleteBuffer(buffer);
        gl.deleteProgram(program);
    };
}

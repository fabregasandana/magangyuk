/**
 * WebGL light-field for dashboard hero banners.
 *
 * A single full-bleed shader draws slow blue light ribbons behind the hero
 * copy. It is intentionally subtle, renders at 30 fps, pauses off-screen, and
 * falls back to the CSS gradient when WebGL is unavailable.
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
uniform vec3 u_deep;
uniform vec3 u_light;

void main() {
    vec2 uv = gl_FragCoord.xy / u_resolution.xy;
    vec2 p = uv * 2.0 - 1.0;
    p.x *= u_resolution.x / max(1.0, u_resolution.y);

    float t = u_time * 0.18;
    float wave = sin(p.x * 1.6 + t) * 0.28
               + sin(p.x * 2.7 - t * 0.8 + p.y * 1.4) * 0.16
               + cos(p.y * 2.1 + t * 1.1) * 0.12;

    float ribbon = smoothstep(0.55, 1.0, 1.0 - abs(p.y - wave));
    float glow = smoothstep(1.35, 0.0, length(p - vec2(0.55, 0.25)));
    float dots = step(0.985, fract(sin(dot(floor(uv * 90.0), vec2(12.9898, 78.233)) + t) * 43758.5453));

    vec3 color = mix(u_deep, u_light, ribbon * 0.75 + glow * 0.35);
    float alpha = ribbon * 0.16 + glow * 0.18 + dots * 0.05;

    gl_FragColor = vec4(color, alpha);
}
`;

function hexToUnitRgb(value, fallback) {
    const match = /^#?([\da-f]{3}|[\da-f]{6})$/i.exec(String(value).trim());
    if (!match) return fallback;
    const hex = match[1].length === 3 ? [...match[1]].map((part) => part + part).join('') : match[1];
    return [
        parseInt(hex.slice(0, 2), 16) / 255,
        parseInt(hex.slice(2, 4), 16) / 255,
        parseInt(hex.slice(4, 6), 16) / 255,
    ];
}

function compile(gl, type, source) {
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

function buildProgram(gl) {
    const vertex = compile(gl, gl.VERTEX_SHADER, VERTEX_SOURCE);
    const fragment = compile(gl, gl.FRAGMENT_SHADER, FRAGMENT_SOURCE);
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

export function initDashboardWebgl(canvas) {
    if (!(canvas instanceof HTMLCanvasElement)) return () => {};

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const gl = canvas.getContext('webgl', {
        alpha: true,
        antialias: false,
        depth: false,
        stencil: false,
        premultipliedAlpha: true,
        powerPreference: 'low-power',
    }) ?? canvas.getContext('experimental-webgl');

    if (!gl) {
        canvas.hidden = true;
        return () => {};
    }

    let program = null;
    let buffer = null;
    let uniforms = {};

    const setup = () => {
        program = buildProgram(gl);
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
            deep: gl.getUniformLocation(program, 'u_deep'),
            light: gl.getUniformLocation(program, 'u_light'),
        };
        return true;
    };

    if (!setup()) {
        canvas.hidden = true;
        return () => {};
    }

    const readColors = () => {
        const styles = getComputedStyle(document.body);
        return {
            deep: hexToUnitRgb(styles.getPropertyValue('--dash-hero-a'), [0.12, 0.25, 0.69]),
            light: hexToUnitRgb(styles.getPropertyValue('--dash-hero-c'), [0.38, 0.65, 0.98]),
        };
    };

    let colors = readColors();
    let raf = 0;
    let running = false;
    let visible = false;
    let lost = false;
    let lastFrame = 0;
    let startedAt = performance.now();

    const resize = () => {
        const rect = canvas.getBoundingClientRect();
        const dpr = Math.min(window.devicePixelRatio || 1, 1.5);
        const width = Math.max(1, Math.round(rect.width * dpr));
        const height = Math.max(1, Math.round(rect.height * dpr));
        if (canvas.width !== width || canvas.height !== height) {
            canvas.width = width;
            canvas.height = height;
            gl.viewport(0, 0, width, height);
        }
    };

    const draw = (time) => {
        if (lost || !program) return;
        const seconds = reducedMotion.matches ? 1.2 : (time - startedAt) / 1000;
        gl.clear(gl.COLOR_BUFFER_BIT);
        gl.useProgram(program);
        gl.uniform2f(uniforms.resolution, canvas.width, canvas.height);
        gl.uniform1f(uniforms.time, seconds);
        gl.uniform3fv(uniforms.deep, colors.deep);
        gl.uniform3fv(uniforms.light, colors.light);
        gl.drawArrays(gl.TRIANGLES, 0, 3);
    };

    const frame = (time) => {
        if (!running) return;
        raf = requestAnimationFrame(frame);
        if (time - lastFrame < 33) return;
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
            if (!running) draw(performance.now());
        }
    };

    const onVisibility = () => sync();
    const onTheme = () => {
        colors = readColors();
        if (!running) draw(performance.now());
    };
    const onLost = (event) => {
        event.preventDefault();
        stop();
        lost = true;
    };
    const onRestored = () => {
        lost = false;
        if (!setup()) {
            canvas.hidden = true;
            return;
        }
        startedAt = performance.now();
        sync();
    };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            visible = entries.some((entry) => entry.isIntersecting);
            sync();
        }, { threshold: 0 })
        : null;

    const resizeObserver = 'ResizeObserver' in window
        ? new ResizeObserver(() => {
            resize();
            if (!running) draw(performance.now());
        })
        : null;

    resize();
    if (observer) observer.observe(canvas);
    else visible = true;
    resizeObserver?.observe(canvas);
    document.addEventListener('visibilitychange', onVisibility);
    document.addEventListener('theme:change', onTheme);
    canvas.addEventListener('webglcontextlost', onLost);
    canvas.addEventListener('webglcontextrestored', onRestored);
    sync();
    draw(performance.now());

    return () => {
        stop();
        observer?.disconnect();
        resizeObserver?.disconnect();
        document.removeEventListener('visibilitychange', onVisibility);
        document.removeEventListener('theme:change', onTheme);
        canvas.removeEventListener('webglcontextlost', onLost);
        canvas.removeEventListener('webglcontextrestored', onRestored);
        gl.deleteBuffer(buffer);
        gl.deleteProgram(program);
    };
}

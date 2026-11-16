/**
 * Anime.js choreography (PRD §8D).
 *
 * Owns text reveals, SVG stroke drawing, and staggered entrances only.
 * Counters, scroll reveals, and progress rings belong to gsap.js, so the same
 * element is never driven by two animation engines.
 */
import { animate, createDrawable, splitText, stagger } from 'animejs';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
const DRAWABLE_SELECTOR = 'path, circle, line, polyline, polygon, rect, ellipse';

function track(cleanups, animation) {
    cleanups.push(() => animation.revert());
    return animation;
}

/**
 * Word-by-word reveal for headings marked with `data-split-text`.
 * Anime.js keeps the original markup in a visually hidden node for screen
 * readers, and `splitter.revert()` restores the heading on cleanup.
 */
export function initAnimeText(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    root.querySelectorAll('[data-split-text]').forEach((element) => {
        if (element.dataset.splitReady === 'true') return;

        const splitter = splitText(element, {
            words: { class: 'split-word' },
            accessible: true,
        });
        element.dataset.splitReady = 'true';

        const animation = animate(splitter.words, {
            opacity: [0, 1],
            y: ['0.5em', '0em'],
            duration: 620,
            delay: stagger(22, { start: 100 }),
            ease: 'out(3)',
        });

        cleanups.push(() => {
            animation.revert();
            splitter.revert();
            delete element.dataset.splitReady;
        });
    });

    return () => cleanups.forEach((cleanup) => cleanup());
}

/**
 * Staggered entrance for the direct children of `data-anime-stagger`.
 * Used for the landing workflow list and the login form rows.
 */
export function initAnimeStagger(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    root.querySelectorAll('[data-anime-stagger]').forEach((container) => {
        const items = [...container.children].filter((child) => child.nodeType === 1);
        if (!items.length) return;

        const animation = animate(items, {
            opacity: [0, 1],
            y: [16, 0],
            duration: 460,
            delay: stagger(55, { start: 80 }),
            ease: 'out(2)',
            // Inline transforms would override the CSS hover states on buttons and cards.
            onComplete: () => items.forEach((item) => {
                item.style.removeProperty('opacity');
                item.style.removeProperty('transform');
            }),
        });
        track(cleanups, animation);
    });

    return () => cleanups.forEach((cleanup) => cleanup());
}

/**
 * SVG stroke drawing for icons wrapped in `data-anime-draw`.
 * `createDrawable` normalises each geometry to a 0–1 path, so mixed icon
 * shapes (rect, circle, path) share one timing curve.
 */
export function initAnimeDraw(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    root.querySelectorAll('[data-anime-draw]').forEach((wrapper) => {
        const shapes = [...wrapper.querySelectorAll(DRAWABLE_SELECTOR)];
        if (!shapes.length) return;

        // `createDrawable` normalises geometry with its own dash attributes; capture
        // the originals so cleanup does not leave the icon invisible.
        const originals = shapes.map((shape) => ({
            shape,
            pathLength: shape.getAttribute('pathLength'),
            dasharray: shape.getAttribute('stroke-dasharray'),
            dashoffset: shape.getAttribute('stroke-dashoffset'),
        }));
        const restore = () => originals.forEach(({ shape, pathLength, dasharray, dashoffset }) => {
            if (pathLength === null) shape.removeAttribute('pathLength');
            else shape.setAttribute('pathLength', pathLength);
            if (dasharray === null) shape.removeAttribute('stroke-dasharray');
            else shape.setAttribute('stroke-dasharray', dasharray);
            if (dashoffset === null) shape.removeAttribute('stroke-dashoffset');
            else shape.setAttribute('stroke-dashoffset', dashoffset);
        });

        const drawables = createDrawable(shapes);
        if (!drawables.length) return;

        const animation = animate(drawables, {
            draw: ['0 0', '0 1'],
            duration: 820,
            delay: stagger(60, { start: 160 }),
            ease: 'inOut(2)',
            onComplete: restore,
        });
        cleanups.push(() => {
            animation.revert();
            restore();
        });
    });

    return () => cleanups.forEach((cleanup) => cleanup());
}

/** Single entry point so page scripts do not repeat the wiring. */
export function initAnime(root = document) {
    const cleanups = [
        initAnimeText(root),
        initAnimeStagger(root),
        initAnimeDraw(root),
    ];
    return () => cleanups.forEach((cleanup) => cleanup());
}

export function prefersReducedMotion() {
    return reducedMotion.matches;
}

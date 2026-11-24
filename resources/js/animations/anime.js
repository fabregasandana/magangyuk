/**
 * Anime.js choreography (PRD §5A, §8C, §8D).
 *
 * Single animation engine for the whole app: text reveals, SVG stroke
 * drawing, staggered entrances, counters, scroll reveals, the landing intro
 * timeline, the flow-card deck, and parallax. One engine keeps the landing
 * bundle light (no GSAP/ScrollTrigger) and guarantees that the same element
 * is never driven by two systems.
 */
import { animate, createDrawable, createTimeline, splitText, stagger } from 'animejs';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
const DRAWABLE_SELECTOR = 'path, circle, line, polyline, polygon, rect, ellipse';

function track(cleanups, animation) {
    cleanups.push(() => animation.revert());
    return animation;
}

/** Release inline opacity/transform so CSS hover states keep working. */
function releaseStyles(items) {
    items.forEach((item) => {
        item.style.removeProperty('opacity');
        item.style.removeProperty('transform');
    });
}

function observeOnce(elements, callback, options = {}) {
    if (!elements.length) return () => {};
    if (!('IntersectionObserver' in window)) {
        elements.forEach(callback);
        return () => {};
    }
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            callback(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.05, rootMargin: '0px 0px -6% 0px', ...options });
    elements.forEach((element) => observer.observe(element));
    return () => observer.disconnect();
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
 * Fires when the container scrolls into view so below-the-fold lists are
 * still choreographed at the right moment.
 */
export function initAnimeStagger(root = document) {
    if (reducedMotion.matches) return () => {};

    const running = [];
    const launch = (container) => {
        const items = [...container.children].filter((child) => child.nodeType === 1);
        if (!items.length) return;
        running.push(animate(items, {
            opacity: [0, 1],
            y: [16, 0],
            duration: 460,
            delay: stagger(55, { start: 80 }),
            ease: 'out(2)',
            onComplete: () => releaseStyles(items),
        }));
    };

    const cleanup = observeOnce([...root.querySelectorAll('[data-anime-stagger]')], launch);
    return () => {
        cleanup();
        running.forEach((animation) => animation.revert());
    };
}

/**
 * SVG stroke drawing for icons wrapped in `data-anime-draw`.
 * `createDrawable` normalises each geometry to a 0–1 path, so mixed icon
 * shapes (rect, circle, path) share one timing curve. Triggered on view.
 */
export function initAnimeDraw(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    const launch = (wrapper) => {
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
    };

    const cleanup = observeOnce([...root.querySelectorAll('[data-anime-draw]')], launch);
    return () => {
        cleanup();
        cleanups.forEach((cleanupFn) => cleanupFn());
    };
}

/**
 * Numeric and progress choreography shared by the landing hero preview and
 * the dashboards: `data-counter`, `data-progress`, `data-ring`,
 * `data-stagger`, `data-reveal`. Replaces the former GSAP module.
 */
export function initAnimeMotion(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    const animations = [];

    const animateCounter = (element) => {
        const target = Number(element.dataset.counter);
        if (!Number.isFinite(target)) return;
        const original = element.textContent;
        const decimals = (String(target).split('.')[1] ?? '').length;
        const state = { value: 0 };
        animations.push(animate(state, {
            value: target,
            duration: 700,
            ease: 'out(2)',
            onUpdate: () => { element.textContent = state.value.toFixed(decimals); },
            // Keep the server-rendered formatting (separators, suffix) intact.
            onComplete: () => { element.textContent = original; },
        }));
    };

    const animateScaleX = (element) => {
        animations.push(animate(element, {
            scaleX: [0, 1],
            duration: 600,
            ease: 'out(2)',
            onComplete: () => element.style.removeProperty('transform'),
        }));
    };

    const animateRing = (element) => {
        const arc = element.getAttribute('stroke-dasharray');
        if (!arc) return;
        const target = Number(String(arc).split(' ')[0]);
        if (!Number.isFinite(target)) return;
        const state = { value: 0 };
        animations.push(animate(state, {
            value: target,
            duration: 800,
            ease: 'out(2)',
            onUpdate: () => element.setAttribute('stroke-dasharray', `${state.value.toFixed(1)} 100`),
            onComplete: () => element.setAttribute('stroke-dasharray', arc),
        }));
    };

    const animateStagger = (container) => {
        const items = [...container.children].filter((child) => child.nodeType === 1);
        if (!items.length) return;
        animations.push(animate(items, {
            y: [18, 0],
            opacity: [0, 1],
            duration: 500,
            delay: stagger(60),
            ease: 'out(2)',
            onComplete: () => releaseStyles(items),
        }));
    };

    const animateReveal = (element) => {
        animations.push(animate(element, {
            y: [12, 0],
            opacity: [0, 1],
            duration: 450,
            ease: 'out(2)',
            onComplete: () => releaseStyles([element]),
        }));
    };

    cleanups.push(
        observeOnce([...root.querySelectorAll('[data-counter]')], animateCounter, { threshold: 0.45 }),
        observeOnce([...root.querySelectorAll('[data-progress]')], animateScaleX),
        observeOnce([...root.querySelectorAll('[data-ring]')], animateRing),
        observeOnce([...root.querySelectorAll('[data-stagger]')], animateStagger),
        observeOnce([...root.querySelectorAll('[data-reveal]')], animateReveal),
    );

    return () => {
        cleanups.forEach((cleanup) => cleanup());
        animations.forEach((animation) => animation.revert());
    };
}

/**
 * Landing hero entrance: header, copy, floating chips, and the product
 * preview on one Anime.js timeline. Headings with `data-split-text` stay
 * with the text module, so this never touches h1.
 */
export function initLandingIntro(root = document) {
    if (reducedMotion.matches) return () => {};

    const hero = root.querySelector('.landing-hero');
    if (!hero) return () => {};

    const header = root.querySelector('[data-landing-header]');
    const intro = [...hero.querySelectorAll('[data-intro]')];
    const device = hero.querySelector('.landing-device');
    const chips = [...hero.querySelectorAll('.landing-float-chip')];
    const bars = hero.querySelector('[data-bars]');

    const timeline = createTimeline({ defaults: { ease: 'out(3)' } });

    if (header) {
        timeline.add(header, { opacity: [0, 1], y: [-18, 0], duration: 520 });
    }
    if (intro.length) {
        timeline.add(intro, { y: [24, 0], opacity: [0, 1], duration: 700, delay: stagger(80, { start: 120 }) }, '-=320');
    }
    if (device) {
        timeline.add(device, { y: [74, 0], opacity: [0, 1], rotateX: [13, 0], scale: [0.97, 1], duration: 1100, onComplete: () => releaseStyles([device]) }, '-=500');
    }
    if (chips.length) {
        timeline.add(chips, { opacity: [0, 1], scale: [0.9, 1], duration: 550, delay: stagger(120), onComplete: () => releaseStyles(chips) }, '-=550');
    }
    if (bars) {
        const spans = [...bars.querySelectorAll('.landing-bar > span')];
        spans.forEach((span) => { span.style.transformOrigin = 'bottom center'; });
        timeline.add(spans, {
            scaleY: [0, 1],
            duration: 850,
            delay: stagger(60),
            onComplete: () => spans.forEach((span) => {
                span.style.removeProperty('transform');
                span.style.removeProperty('transform-origin');
            }),
        }, '-=650');
    }

    return () => timeline.revert();
}

/**
 * Scroll choreography for the landing sections, driven by Anime.js plus a
 * single shared IntersectionObserver pass (no ScrollTrigger needed):
 * reveals, card decks, the orbiting flow stage, activity board, gallery,
 * and the footer wordmark.
 */
export function initLandingScroll(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [];
    const animations = [];

    // Section headings, panels, and standalone blocks.
    const launchReveal = (element) => {
        animations.push(animate(element, {
            y: [30, 0],
            opacity: [0, 1],
            duration: 800,
            ease: 'out(3)',
            onComplete: () => releaseStyles([element]),
        }));
    };
    cleanups.push(observeOnce([...root.querySelectorAll('[data-landing-reveal]')], launchReveal));

    // Card grids fan out from a loose deck as the grid enters the view.
    const launchGrid = (container) => {
        const items = [...container.children].filter((child) => child.nodeType === 1);
        if (!items.length) return;
        const compact = window.matchMedia('(max-width: 767px)').matches;
        const center = (items.length - 1) / 2;
        animations.push(animate(items, {
            y: compact ? 26 : 58,
            opacity: [0, 1],
            x: compact ? 0 : (element) => (items.indexOf(element) - center) * 28,
            rotation: compact ? 0 : (element) => (items.indexOf(element) - center) * 2.2,
            scale: compact ? 1 : 0.95,
            duration: 850,
            delay: stagger(75),
            ease: 'out(3)',
            onComplete: () => releaseStyles(items),
        }));
    };
    cleanups.push(observeOnce([...root.querySelectorAll('[data-landing-stagger]')], launchGrid));

    // Scattered activity board and expanding gallery.
    const launchOffset = (offsetY) => (container) => {
        const items = [...container.children].filter((child) => child.nodeType === 1 && child.matches('[data-activity-card], [data-gallery-panel]'));
        if (!items.length) items.push(...[...container.querySelectorAll('[data-activity-card], [data-gallery-panel]')]);
        animations.push(animate(items, {
            y: offsetY,
            opacity: [0, 1],
            scale: 0.96,
            duration: 850,
            delay: stagger(80),
            ease: 'out(3)',
            onComplete: () => releaseStyles(items),
        }));
    };
    cleanups.push(observeOnce([...root.querySelectorAll('[data-activity-stage]')], launchOffset(46)));
    cleanups.push(observeOnce([...root.querySelectorAll('[data-gallery-accordion]')], launchOffset(36)));

    // Footer: links rise first, then the oversized wordmark lifts from its mask.
    const footer = root.querySelector('[data-landing-footer]');
    if (footer) {
        const revealItems = [...footer.querySelectorAll('[data-footer-reveal]')];
        if (revealItems.length) {
            cleanups.push(observeOnce([footer], () => {
                animations.push(animate(revealItems, {
                    y: [18, 0],
                    opacity: [0, 1],
                    duration: 700,
                    delay: stagger(80),
                    ease: 'out(2)',
                    onComplete: () => releaseStyles(revealItems),
                }));
            }, { threshold: 0.1 }));
        }

        const wordmark = footer.querySelector('[data-footer-wordmark]');
        if (wordmark) {
            cleanups.push(observeOnce([wordmark.parentElement ?? wordmark], () => {
                animations.push(animate(wordmark, {
                    y: ['55%', '0%'],
                    duration: 1300,
                    delay: 50,
                    ease: 'out(2)',
                    onComplete: () => wordmark.style.removeProperty('transform'),
                }));
            }, { threshold: 0 }));
        }
    }

    // Flow stage: cards fold into the centre and fan back out while the
    // section is in view, replaying when the visitor scrolls back up.
    root.querySelectorAll('[data-flow-stage]').forEach((stage) => {
        const cards = [...stage.querySelectorAll('[data-flow-card]')];
        if (!cards.length) return;

        let deck = null;
        let lastY = window.scrollY;

        const build = () => {
            if (deck) deck.revert();
            const compact = window.matchMedia('(max-width: 1023px)').matches;
            deck = animate(cards, {
                x: compact ? 0 : (card) => stage.clientWidth / 2 - (card.offsetLeft + card.offsetWidth / 2),
                y: compact ? 26 : (card) => stage.clientHeight / 2 - (card.offsetTop + card.offsetHeight / 2),
                rotation: compact ? 0 : (card, index) => -14 + index * 8,
                scale: compact ? 1 : 0.78,
                opacity: [0, 1],
                duration: 1050,
                delay: stagger(90),
                ease: 'out(3)',
                autoplay: false,
                onComplete: () => {
                    stage.classList.add('is-ready');
                    releaseStyles(cards);
                },
            });
            return deck;
        };

        if (!('IntersectionObserver' in window)) {
            build().play();
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const forward = window.scrollY >= lastY;
                lastY = window.scrollY;
                if (entry.isIntersecting) {
                    if (forward || !deck) build().play();
                    else deck.play();
                } else if (deck && !forward) {
                    stage.classList.remove('is-ready');
                    deck.reverse();
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -5% 0px' });
        observer.observe(stage);
        cleanups.push(() => {
            observer.disconnect();
            if (deck) deck.revert();
        });
    });

    return () => {
        cleanups.forEach((cleanup) => cleanup());
        animations.forEach((animation) => animation.revert());
    };
}

/**
 * Subtle parallax for large landing visuals (desktop only). One passive
 * scroll listener and one rAF pass drive every element, and updates stop
 * while nothing is in view.
 */
export function initParallax(root = document) {
    if (reducedMotion.matches) return () => {};
    if (!window.matchMedia('(min-width: 768px)').matches) return () => {};

    const elements = [...root.querySelectorAll('[data-parallax]')];
    if (!elements.length) return () => {};

    const visible = new Set();
    let frame = 0;

    const update = () => {
        frame = 0;
        const vh = window.innerHeight;
        visible.forEach((element) => {
            const depth = Number(element.dataset.parallax) || 0.08;
            const rect = element.getBoundingClientRect();
            const progress = Math.min(1, Math.max(0, (vh - rect.top) / (vh + rect.height)));
            element.style.transform = `translate3d(0, ${((progress - 0.5) * depth * 200).toFixed(2)}%, 0)`;
        });
    };

    const request = () => {
        if (!frame && visible.size) frame = window.requestAnimationFrame(update);
    };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) visible.add(entry.target);
                else {
                    visible.delete(entry.target);
                    entry.target.style.removeProperty('transform');
                }
            });
            request();
        }, { threshold: 0 })
        : null;

    if (observer) elements.forEach((element) => observer.observe(element));
    else elements.forEach((element) => visible.add(element));

    window.addEventListener('scroll', request, { passive: true });
    window.addEventListener('resize', request);
    request();

    return () => {
        if (frame) window.cancelAnimationFrame(frame);
        observer?.disconnect();
        window.removeEventListener('scroll', request);
        window.removeEventListener('resize', request);
        elements.forEach((element) => element.style.removeProperty('transform'));
    };
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

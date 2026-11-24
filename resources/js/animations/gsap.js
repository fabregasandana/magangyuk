/**
 * GSAP + ScrollTrigger choreography (PRD §5A, §8C).
 *
 * Responsibilities stay narrow: counters, progress, reveal, stagger, parallax.
 * Elements animated here never receive an Anime.js animation as well.
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

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
    }, { threshold: 0.25, rootMargin: '0px 0px -40px 0px', ...options });
    elements.forEach((element) => observer.observe(element));
    return () => observer.disconnect();
}

function animateCounter(element) {
    const target = Number(element.dataset.counter);
    if (!Number.isFinite(target)) return;
    const original = element.textContent;
    const decimals = (String(target).split('.')[1] ?? '').length;
    const state = { value: 0 };
    gsap.to(state, {
        value: target,
        duration: 0.7,
        ease: 'power2.out',
        onUpdate: () => { element.textContent = state.value.toFixed(decimals); },
        // Keep the server-rendered formatting (separators, suffix) intact.
        onComplete: () => { element.textContent = original; },
    });
}

function animateProgress(element) {
    gsap.from(element, { scaleX: 0, duration: 0.6, ease: 'power2.out', clearProps: 'transform' });
}

function animateRing(element) {
    const arc = element.getAttribute('stroke-dasharray');
    if (!arc) return;
    gsap.from(element, {
        attr: { 'stroke-dasharray': '0 100' },
        duration: 0.8,
        ease: 'power2.out',
        clearProps: 'stroke-dasharray',
    });
}

function animateStagger(container) {
    const items = [...container.children].filter((child) => child.nodeType === 1);
    if (!items.length) return;
    gsap.from(items, {
        y: 18,
        opacity: 0,
        duration: 0.5,
        stagger: 0.06,
        ease: 'power2.out',
        clearProps: 'all',
    });
}

function animateReveal(element) {
    gsap.from(element, { y: 12, opacity: 0, duration: 0.45, ease: 'power2.out', clearProps: 'all' });
}

/** Dashboard/default motion: runs when elements enter the viewport. */
export function initGsapMotion(root = document) {
    if (reducedMotion.matches) return () => {};

    const cleanups = [
        observeOnce([...root.querySelectorAll('[data-counter]')], animateCounter, { threshold: 0.45 }),
        observeOnce([...root.querySelectorAll('[data-progress]')], animateProgress),
        observeOnce([...root.querySelectorAll('[data-ring]')], animateRing),
        observeOnce([...root.querySelectorAll('[data-stagger]')], animateStagger),
        observeOnce([...root.querySelectorAll('[data-reveal]')], animateReveal),
    ];

    return () => cleanups.forEach((cleanup) => cleanup());
}

/** Landing-only reveal using ScrollTrigger so the effect tracks scrolling. */
export function initScrollReveal(root = document) {
    if (reducedMotion.matches) return () => {};
    const elements = [...root.querySelectorAll('[data-reveal]')];
    if (!elements.length) return () => {};

    elements.forEach((element) => {
        gsap.from(element, {
            y: 24,
            opacity: 0,
            duration: 0.6,
            ease: 'power2.out',
            clearProps: 'all',
            scrollTrigger: { trigger: element, start: 'top 88%', once: true },
        });
    });

    return () => {
        elements.forEach((element) => {
            ScrollTrigger.getAll().forEach((trigger) => {
                if (trigger.trigger === element) trigger.kill();
            });
        });
    };
}

/**
 * Landing hero entrance: copy, floating chips, and the product preview.
 * Headings with `data-split-text` stay with Anime.js, so this never touches h1.
 */
export function initLandingIntro(root = document) {
    if (reducedMotion.matches) return () => {};

    const hero = root.querySelector('.landing-hero');
    if (!hero) return () => {};

    let observerCleanup = () => {};
    const context = gsap.context(() => {
        const timeline = gsap.timeline({ defaults: { ease: 'power3.out' } });
        const intro = hero.querySelectorAll('[data-intro]');

        if (intro.length) {
            timeline.from(intro, {
                y: 24,
                opacity: 0,
                duration: 0.7,
                stagger: 0.08,
                delay: 0.12,
                clearProps: 'all',
            });
        }

        const device = hero.querySelector('.landing-device');
        if (device) {
            timeline.from(device, {
                y: 74,
                opacity: 0,
                rotateX: 13,
                scale: 0.97,
                duration: 1.1,
                ease: 'power3.out',
                clearProps: 'all',
            }, intro.length ? '-=0.5' : 0);
        }

        const chips = hero.querySelectorAll('.landing-float-chip');
        if (chips.length) {
            timeline.from(chips, {
                opacity: 0,
                scale: 0.9,
                duration: 0.55,
                stagger: 0.12,
                clearProps: 'all',
            }, '-=0.55');
        }

        const bars = hero.querySelector('[data-bars]');
        if (bars) {
            observerCleanup = observeOnce([bars], (target) => {
                gsap.from(target.querySelectorAll('.landing-bar > span'), {
                    scaleY: 0,
                    transformOrigin: 'bottom center',
                    duration: 0.85,
                    stagger: 0.06,
                    ease: 'power3.out',
                    clearProps: 'transform',
                });
            }, { threshold: 0.25 });
        }
    }, hero);

    return () => {
        observerCleanup();
        context.revert();
    };
}

/** Scroll choreography for the new landing sections (headings and card grids). */
export function initLandingScroll(root = document) {
    if (reducedMotion.matches) return () => {};

    const context = gsap.context(() => {
        root.querySelectorAll('[data-landing-reveal]').forEach((element) => {
            gsap.from(element, {
                y: 30,
                opacity: 0,
                duration: 0.8,
                ease: 'power3.out',
                clearProps: 'all',
                scrollTrigger: { trigger: element, start: 'top 88%', once: true },
            });
        });

        root.querySelectorAll('[data-landing-stagger]').forEach((container) => {
            const items = [...container.children].filter((child) => child.nodeType === 1);
            if (!items.length) return;

            const compact = window.matchMedia('(max-width: 767px)').matches;
            const center = (items.length - 1) / 2;

            // Cards fan out from a loose deck as the grid enters, echoing the
            // floating card choreography in the reference landing.
            gsap.from(items, {
                y: compact ? 26 : 58,
                x: compact ? 0 : (index) => (index - center) * 28,
                rotation: compact ? 0 : (index) => (index - center) * 2.2,
                scale: compact ? 1 : 0.95,
                opacity: 0,
                duration: 0.85,
                stagger: 0.075,
                ease: 'power3.out',
                clearProps: 'all',
                scrollTrigger: { trigger: container, start: 'top 86%', once: true },
            });
        });

        root.querySelectorAll('[data-flow-stage]').forEach((stage) => {
            const cards = [...stage.querySelectorAll('[data-flow-card]')];
            if (!cards.length) return;

            const compact = window.matchMedia('(max-width: 1023px)').matches;

            if (compact) {
                gsap.from(cards, {
                    y: 26,
                    opacity: 0,
                    duration: 0.7,
                    stagger: 0.07,
                    ease: 'power3.out',
                    clearProps: 'all',
                    onComplete: () => stage.classList.add('is-ready'),
                    scrollTrigger: { trigger: stage, start: 'top 86%', once: true },
                });
                return;
            }

            // Desktop: the cards start stacked at the centre of the orbit and
            // fan out while the section is in view. Reversing the timeline on
            // the way out closes the deck again, mirroring the reference
            // programme cards that fold back when another section arrives.
            const timeline = gsap.timeline({
                scrollTrigger: {
                    trigger: stage,
                    start: 'top 82%',
                    end: 'bottom 30%',
                    toggleActions: 'play reverse play reverse',
                    invalidateOnRefresh: true,
                    onToggle: (self) => {
                        if (!self.isActive) stage.classList.remove('is-ready');
                    },
                },
            });

            timeline.from(cards, {
                x: (index, card) => stage.clientWidth / 2 - (card.offsetLeft + card.offsetWidth / 2),
                y: (index, card) => stage.clientHeight / 2 - (card.offsetTop + card.offsetHeight / 2),
                rotation: (index) => -14 + index * 8,
                scale: 0.78,
                opacity: 0,
                duration: 1.05,
                stagger: 0.09,
                ease: 'power3.out',
                clearProps: 'transform,opacity',
                onComplete: () => stage.classList.add('is-ready'),
            });
        });

        root.querySelectorAll('[data-activity-stage]').forEach((stage) => {
            const cards = [...stage.querySelectorAll('[data-activity-card]')];
            if (!cards.length) return;

            // Clear only the animated properties: the cards carry their
            // scattered layout in inline custom properties, and
            // `clearProps: 'all'` would wipe those out too.
            gsap.from(cards, {
                y: 46,
                scale: 0.96,
                opacity: 0,
                duration: 0.85,
                stagger: 0.08,
                ease: 'power3.out',
                clearProps: 'transform,opacity',
                scrollTrigger: { trigger: stage, start: 'top 84%', once: true },
            });
        });

        root.querySelectorAll('[data-gallery-accordion]').forEach((accordion) => {
            const panels = [...accordion.querySelectorAll('[data-gallery-panel]')];
            if (!panels.length) return;

            gsap.from(panels, {
                y: 36,
                opacity: 0,
                duration: 0.8,
                stagger: 0.06,
                ease: 'power3.out',
                clearProps: 'all',
                scrollTrigger: { trigger: accordion, start: 'top 84%', once: true },
            });
        });

        const footer = root.querySelector('[data-landing-footer]');
        if (footer) {
            const revealItems = [...footer.querySelectorAll('[data-footer-reveal]')];
            if (revealItems.length) {
                gsap.from(revealItems, {
                    y: 18,
                    opacity: 0,
                    duration: 0.7,
                    stagger: 0.08,
                    ease: 'power3.out',
                    clearProps: 'all',
                    scrollTrigger: { trigger: footer, start: 'top 94%', once: true },
                });
            }

            const wordmark = footer.querySelector('[data-footer-wordmark]');
            if (wordmark) {
                // The oversized wordmark rises from beneath its mask as the
                // footer settles into place. A timed tween (instead of a
                // scrub) keeps the rise readable during the short distance
                // between the last section and the end of the page, and the
                // bottom-anchored trigger works at every breakpoint.
                gsap.fromTo(
                    wordmark,
                    { yPercent: 55 },
                    {
                        yPercent: 0,
                        duration: 1.3,
                        delay: 0.05,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: wordmark.parentElement,
                            start: 'bottom 110%',
                            once: true,
                        },
                    },
                );
            }
        }
    }, root);

    return () => context.revert();
}

/** Subtle parallax for large landing visuals (desktop only). */
export function initParallax(root = document) {
    if (reducedMotion.matches) return () => {};
    if (!window.matchMedia('(min-width: 768px)').matches) return () => {};

    const elements = [...root.querySelectorAll('[data-parallax]')];
    if (!elements.length) return () => {};

    const context = gsap.context(() => {
        elements.forEach((element) => {
            const depth = Number(element.dataset.parallax) || 0.08;
            gsap.to(element, {
                yPercent: depth * 100,
                ease: 'none',
                scrollTrigger: {
                    trigger: element.closest('section') ?? element,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 0.6,
                },
            });
        });
    }, root);

    return () => context.revert();
}

export function prefersReducedMotion() {
    return reducedMotion.matches;
}

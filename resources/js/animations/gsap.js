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

/** Subtle parallax for large landing visuals (desktop only). */
export function initParallax(root = document) {
    if (reducedMotion.matches) return () => {};
    if (!window.matchMedia('(min-width: 768px)').matches) return () => {};

    const elements = [...root.querySelectorAll('[data-parallax]')];
    if (!elements.length) return () => {};

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

    return () => {
        elements.forEach((element) => gsap.killTweensOf(element));
    };
}

export function prefersReducedMotion() {
    return reducedMotion.matches;
}

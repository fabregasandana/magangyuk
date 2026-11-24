import '@fontsource-variable/plus-jakarta-sans';
import { renderIcons } from './icons';
import { initAnimeText, initAnimeMotion } from './animations/anime';

const root = document.documentElement;
const desktop = window.matchMedia('(min-width: 1024px)');
const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
const focusableSelector = 'a[href], button:not(:disabled), input:not(:disabled):not([type="hidden"]), select:not(:disabled), textarea:not(:disabled), [tabindex="0"]';

function persist(key, value) {
    try { localStorage.setItem(key, value); } catch { /* Preferences remain usable without storage. */ }
}

function syncThemeButtons() {
    const dark = root.dataset.theme === 'dark';
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const label = dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
        button.setAttribute('aria-pressed', String(dark));
    });
}

function applyTheme(theme) {
    if (!['light', 'dark'].includes(theme)) return;
    root.dataset.theme = theme;
    root.style.colorScheme = theme;
    syncThemeButtons();
    document.dispatchEvent(new CustomEvent('theme:change', { detail: { theme } }));
}

function trapFocus(event, container) {
    if (event.key !== 'Tab') return;
    const items = [...container.querySelectorAll(focusableSelector)].filter((item) => item.getClientRects().length && !item.closest('[inert]'));
    if (!items.length) { event.preventDefault(); container.focus(); return; }
    const first = items[0];
    const last = items.at(-1);
    if (event.shiftKey && (document.activeElement === first || !items.includes(document.activeElement))) {
        event.preventDefault(); last.focus();
    } else if (!event.shiftKey && (document.activeElement === last || !items.includes(document.activeElement))) {
        event.preventDefault(); first.focus();
    }
}

function initNavigation() {
    const sidebar = document.getElementById('app-sidebar');
    if (!sidebar) return;
    let trigger;
    let hovered = false;
    root.dataset.sidebarCollapsed ??= 'true';
    const pinButton = sidebar.querySelector('[data-sidebar-pin]');
    const background = [...document.querySelectorAll('.app-header, .dashboard-main, .bottom-nav')];
    const sync = () => {
        const open = root.dataset.navigationOpen === 'true';
        const pinned = root.dataset.sidebarCollapsed === 'false';
        const expanded = desktop.matches ? pinned || hovered || sidebar.contains(document.activeElement) : open;
        sidebar.dataset.expanded = String(expanded);
        document.querySelectorAll('[data-navigation-toggle]').forEach((button) => {
            button.setAttribute('aria-expanded', String(expanded));
            button.setAttribute('aria-label', desktop.matches ? (expanded ? 'Ringkas navigasi' : 'Perluas navigasi') : 'Buka semua menu');
        });
        if (pinButton) {
            const label = pinned ? 'Lepas sematan menu' : 'Sematkan menu';
            pinButton.setAttribute('aria-pressed', String(pinned));
            pinButton.setAttribute('aria-expanded', String(expanded));
            pinButton.setAttribute('aria-label', label);
            pinButton.setAttribute('title', label);
            pinButton.querySelector('span').textContent = label;
        }
    };
    sidebar.addEventListener('pointerenter', (event) => {
        hovered = event.pointerType !== 'touch' && desktop.matches;
        sync();
    });
    sidebar.addEventListener('pointerleave', () => { hovered = false; sync(); });
    sidebar.addEventListener('focusin', sync);
    sidebar.addEventListener('focusout', () => queueMicrotask(sync));
    pinButton?.addEventListener('click', (event) => {
        root.dataset.sidebarCollapsed = String(root.dataset.sidebarCollapsed === 'false');
        persist('komdigi-sidebar-pinned', String(root.dataset.sidebarCollapsed === 'false'));
        if (event.detail > 0) pinButton.blur();
        sync();
    });
    const close = () => {
        root.dataset.navigationOpen = 'false';
        sidebar.removeAttribute('role');
        sidebar.removeAttribute('aria-modal');
        background.forEach((el) => { el.inert = false; });
        document.body.style.overflow = '';
        sync();
        trigger?.focus();
    };
    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('[data-navigation-toggle]');
        if (toggle) {
            if (desktop.matches) {
                root.dataset.sidebarCollapsed = String(root.dataset.sidebarCollapsed === 'false');
                persist('komdigi-sidebar-pinned', String(root.dataset.sidebarCollapsed === 'false'));
            } else {
                trigger = toggle;
                root.dataset.navigationOpen = 'true';
                sidebar.setAttribute('role', 'dialog');
                sidebar.setAttribute('aria-modal', 'true');
                background.forEach((el) => { el.inert = true; });
                document.body.style.overflow = 'hidden';
                sidebar.querySelector('[data-navigation-close]')?.focus();
            }
            sync();
        }
        if (event.target.closest('[data-navigation-close]')) close();
    });
    document.addEventListener('keydown', (event) => {
        if (root.dataset.navigationOpen !== 'true') return;
        if (event.key === 'Escape') close();
        trapFocus(event, sidebar);
    });
    desktop.addEventListener('change', () => { hovered = false; close(); sync(); });
    sync();
}

function initDialogAccessibility() {
    if (!document.body.classList.contains('dashboard-body')) return;
    const dialogs = new Set([...document.querySelectorAll('.modal-overlay')].map((overlay) => overlay.closest('.fixed')).filter(Boolean));
    const attendance = document.getElementById('modal-absen');
    if (attendance) dialogs.add(attendance);
    let active = null;
    let returnFocus = null;
    const savedInert = new Map();

    const restoreBackground = () => {
        savedInert.forEach((value, el) => { el.inert = value; });
        savedInert.clear();
        document.body.style.overflow = '';
    };
    const sync = () => {
        const open = [...dialogs].find((dialog) => !dialog.classList.contains('hidden')) ?? null;
        dialogs.forEach((dialog) => dialog.setAttribute('aria-hidden', String(dialog !== open)));
        if (open === active) return;
        restoreBackground();
        if (open) {
            if (!active) returnFocus = document.activeElement;
            [...document.body.children].filter((el) => el !== open && !['SCRIPT', 'STYLE'].includes(el.tagName)).forEach((el) => {
                savedInert.set(el, el.inert);
                el.inert = true;
            });
            document.body.style.overflow = 'hidden';
            const target = [...open.querySelectorAll(focusableSelector)].find((el) => el.getClientRects().length);
            (target ?? open).focus();
        } else {
            returnFocus?.focus();
        }
        active = open;
    };
    dialogs.forEach((dialog, index) => {
        // Fixed dialogs must not inherit a blurred or transformed containing block.
        document.body.append(dialog);
        dialog.dataset.uiDialog = '';
        dialog.setAttribute('role', 'dialog');
        dialog.setAttribute('aria-modal', 'true');
        dialog.setAttribute('tabindex', '-1');
        const title = dialog.querySelector('h2, h3, [data-modal-title-slot]');
        if (title) {
            title.id ||= `dialog-heading-${index}`;
            dialog.setAttribute('aria-labelledby', title.id);
        }
        new MutationObserver(sync).observe(dialog, { attributes: true, attributeFilter: ['class'] });
    });
    document.addEventListener('keydown', (event) => { if (active) trapFocus(event, active); });
    sync();
}

function initCounterReset() {
    // Keep number values correct when the preference changes during a tween.
    motion.addEventListener('change', () => {
        if (motion.matches) document.querySelectorAll('[data-counter]').forEach((el) => { el.textContent = el.dataset.counter; });
    });
}

/**
 * Dashboard-only visual layers. WebGL paints the hero light field and the
 * Canvas module draws the ASCII ripple inside insight cards. Both are loaded
 * after the page is interactive so first paint stays cheap.
 */
function initDashboardEffects() {
    if (!document.body.classList.contains('dashboard-body')) return;

    initAnimeText(document);

    const cleanups = [];
    const dispose = () => cleanups.forEach((cleanup) => cleanup());

    const hero = document.querySelector('[data-dashboard-webgl]');
    if (hero) {
        import('./animations/dashboard-webgl')
            .then(({ initDashboardWebgl }) => cleanups.push(initDashboardWebgl(hero)))
            .catch(() => {});
    }

    document.querySelectorAll('[data-canvas-ripple]').forEach((canvas) => {
        import('./animations/canvas')
            .then(({ initAsciiRipple }) => cleanups.push(initAsciiRipple(canvas)))
            .catch(() => {});
    });

    window.addEventListener('pagehide', (event) => {
        if (event.persisted) return;
        dispose();
    }, { once: true });
}

function init() {
    renderIcons();
    syncThemeButtons();
    initNavigation();
    initDialogAccessibility();
    initAnimeMotion();
    initDashboardEffects();
    initCounterReset();
    // Alpine owns dashboard state only; landing and login skip the runtime.
    if (document.querySelector('[x-data]')) import('./alpine');
    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-theme-toggle]')) return;
        const theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        applyTheme(theme);
        persist('komdigi-theme', theme);
    });
    window.addEventListener('storage', (event) => { if (event.key === 'komdigi-theme') applyTheme(event.newValue); });
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
else init();

import './app';
import { initAnime } from './animations/anime';

function initPasswordToggle() {
    document.querySelectorAll('[data-action="toggle-password"]').forEach((button) => {
        const input = document.getElementById(button.dataset.target || 'password');
        if (!(input instanceof HTMLInputElement)) return;

        button.addEventListener('click', () => {
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';

            // Keep Lucide's rendered icons intact; toggle their stable wrappers.
            const eye = button.querySelector('[data-icon="eye"]');
            const eyeOff = button.querySelector('[data-icon="eye-off"]');
            if (eye) eye.hidden = visible;
            if (eyeOff) eyeOff.hidden = !visible;

            button.setAttribute('aria-pressed', String(visible));
            button.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
            input.focus({ preventScroll: true });
        });
    });
}

function initSubmitFeedback() {
    const form = document.getElementById('login-form');
    if (!form) return;

    form.addEventListener('submit', () => {
        const button = form.querySelector('.login-submit');
        if (!(button instanceof HTMLButtonElement)) return;
        button.dataset.loading = 'true';
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
    });

    // Returning through the back/forward cache must not keep the button disabled.
    window.addEventListener('pageshow', (event) => {
        if (!event.persisted) return;
        const button = form.querySelector('.login-submit');
        if (!(button instanceof HTMLButtonElement)) return;
        delete button.dataset.loading;
        button.disabled = false;
        button.removeAttribute('aria-busy');
    });
}

function initLogin() {
    initPasswordToggle();
    initSubmitFeedback();

    const cleanup = initAnime();
    window.addEventListener('pagehide', (event) => {
        if (event.persisted) return;
        cleanup();
    }, { once: true });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLogin, { once: true });
} else {
    initLogin();
}

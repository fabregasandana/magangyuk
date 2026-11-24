/**
 * Alpine.js interactivity layer.
 *
 * Alpine owns UI state only: command palette, dropdowns, quick actions,
 * dashboard tabs, filters, checklists, and toasts. Business data still comes
 * from Blade, and GSAP/Anime.js keep their own animation targets.
 */
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

function register() {
    Alpine.plugin(collapse);

    Alpine.store('toasts', {
        items: [],
        nextId: 1,
        push(message, type = 'info') {
            const id = this.nextId++;
            this.items.push({ id, message, type });
            window.setTimeout(() => this.dismiss(id), 4200);
        },
        dismiss(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    });

    Alpine.data('appChrome', () => ({
        commandOpen: false,
        quickOpen: false,
        notifOpen: false,
        profileOpen: false,
        query: '',
        activeIndex: 0,
        actions: [],

        init() {
            this.actions = [...document.querySelectorAll('#sidebar-nav .sidebar-link')].map((link) => ({
                label: (link.dataset.navLabel || link.textContent || '').trim(),
                href: link.href,
            }));
            this.$watch('query', () => { this.activeIndex = 0; });
        },

        get filtered() {
            const query = this.query.trim().toLowerCase();
            if (!query) return this.actions;
            return this.actions.filter((item) => item.label.toLowerCase().includes(query));
        },

        openCommand() {
            this.commandOpen = true;
            this.query = '';
            this.activeIndex = 0;
            this.quickOpen = false;
            this.notifOpen = false;
            this.profileOpen = false;
            this.$nextTick(() => this.$refs.commandInput?.focus());
        },

        closeCommand() {
            this.commandOpen = false;
        },

        move(step) {
            const total = this.filtered.length;
            if (!total) return;
            this.activeIndex = (this.activeIndex + step + total) % total;
        },

        runActive() {
            const item = this.filtered[this.activeIndex];
            if (item) window.location.href = item.href;
        },

        toggleNotifications() {
            this.profileOpen = false;
            this.notifOpen = !this.notifOpen;
        },

        toggleProfile() {
            this.notifOpen = false;
            this.profileOpen = !this.profileOpen;
        },

        notify(message, type = 'info') {
            this.$store.toasts.push(message, type);
            this.profileOpen = false;
        },
    }));

    Alpine.data('dashTabs', (initial = 0) => ({
        active: initial,
        isActive(index) { return this.active === index; },
        select(index) { this.active = index; },
    }));

    Alpine.data('checklist', (key = 'komdigi-checklist', defaults = []) => ({
        items: [],
        init() {
            const source = Array.isArray(defaults) && defaults.length
                ? defaults
                : [...this.$el.querySelectorAll('[data-checklist-item]')].map((item) => ({
                    id: item.dataset.checklistItem,
                    label: item.dataset.checklistLabel,
                    caption: item.dataset.checklistCaption || '',
                    done: false,
                }));
            let saved = {};
            try { saved = JSON.parse(localStorage.getItem(key) || '{}'); } catch { saved = {}; }
            this.items = source.map((item) => ({
                id: item.id,
                label: item.label,
                caption: item.caption || '',
                done: saved[item.id] !== undefined ? Boolean(saved[item.id]) : Boolean(item.done),
            }));
        },
        toggle(id) {
            const item = this.items.find((entry) => entry.id === id);
            if (!item) return;
            item.done = !item.done;
            const state = Object.fromEntries(this.items.map((entry) => [entry.id, entry.done]));
            try { localStorage.setItem(key, JSON.stringify(state)); } catch { /* private mode */ }
        },
        get progress() {
            if (!this.items.length) return 0;
            return Math.round((this.items.filter((item) => item.done).length / this.items.length) * 100);
        },
        reset() {
            this.items.forEach((item) => { item.done = false; });
            try { localStorage.removeItem(key); } catch { /* private mode */ }
        },
    }));

    window.__komdigiAlpine = Alpine;
    Alpine.start();
}

if (!window.__komdigiAlpine) register();

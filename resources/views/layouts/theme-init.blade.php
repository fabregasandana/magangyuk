{{-- Apply saved preference before styles paint, including when storage is unavailable. --}}
<script>
    (() => {
        const root = document.documentElement;
        root.dataset.sidebarCollapsed = 'true';
        try {
            const theme = localStorage.getItem('komdigi-theme');
            if (theme === 'dark' || theme === 'light') root.dataset.theme = theme;
            root.dataset.sidebarCollapsed = localStorage.getItem('komdigi-sidebar-pinned') === 'true' ? 'false' : 'true';
        } catch (_) {
            // Keep the compact rail and page theme when storage is unavailable.
        }
        if (!root.dataset.theme) root.dataset.theme = 'light';
        root.style.colorScheme = root.dataset.theme;
    })();
</script>

{{-- Apply saved preference before styles paint, including when storage is unavailable. --}}
<script>
    (() => {
        const root = document.documentElement;
        try {
            const theme = localStorage.getItem('komdigi-theme');
            if (theme === 'dark' || theme === 'light') root.dataset.theme = theme;
            root.dataset.sidebarCollapsed = localStorage.getItem('komdigi-sidebar-collapsed') === 'true' ? 'true' : 'false';
        } catch (_) {
            // Use the page default in private or restricted browsing contexts.
        }
        if (!root.dataset.theme) root.dataset.theme = 'dark';
        root.style.colorScheme = root.dataset.theme;
    })();
</script>

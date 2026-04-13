<script>
    // Hanya eksekusi saat Livewire selesai melakukan navigasi SPA (wire:navigate)
    document.addEventListener('livewire:navigated', () => {
        const savedTheme = localStorage.getItem('flux.appearance');
        const isDark = savedTheme === 'dark' || (!savedTheme && window.matchMedia(
            '(prefers-color-scheme: dark)').matches);

        if (isDark) {
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.style.colorScheme = 'light';
        }
    });
</script>

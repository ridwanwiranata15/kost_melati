{{-- Centralized Theme Script --}}
<script>
    /**
     * Set the theme class on the HTML element immediately to prevent FOUC.
     */
    function applyTheme() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    /**
     * Update the theme toggle icon based on the current theme.
     */
    window.updateThemeIcon = function() {
        const themeIcon = document.getElementById('theme-icon');
        if (!themeIcon) return;

        if (document.documentElement.classList.contains('dark')) {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    };

    /**
     * Toggle the theme and save the preference to localStorage.
     */
    window.toggleDarkMode = function() {
        const htmlElement = document.documentElement;
        if (htmlElement.classList.contains('dark')) {
            htmlElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            htmlElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
        window.updateThemeIcon();
    };

    // Initial application of the theme
    applyTheme();

    // Re-verify theme state on each Livewire navigation to prevent glitches
    document.addEventListener('livewire:navigated', () => {
        applyTheme();
        window.updateThemeIcon();
    });

    // Handle initial icon state
    document.addEventListener('DOMContentLoaded', window.updateThemeIcon);
</script>

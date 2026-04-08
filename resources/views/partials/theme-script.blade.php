{{-- Centralized Theme Script --}}
<script>
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

    window.toggleDarkMode = function() {
        const isDark = document.documentElement.classList.contains('dark');
        const next = isDark ? 'light' : 'dark';

        if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
            window.Flux.applyAppearance(next);
        } else {
            if (next === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('flux.appearance', next);
        }
        
        window.updateThemeIcon();
    };

    // Function to apply theme absolutely
    window.syncTheme = () => {
        try {
            const savedTheme = localStorage.getItem('flux.appearance');
            const isDark = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
            
            if (typeof window.updateThemeIcon === 'function') {
                window.updateThemeIcon();
            }
        } catch (e) {
            console.error('Theme sync error:', e);
        }
    };

    // Immediate execution
    window.syncTheme();

    // High-aggression persistence (Brute force to fight other scripts resetting it)
    setInterval(() => {
        const savedTheme = localStorage.getItem('flux.appearance');
        if (savedTheme) {
            const isDark = savedTheme === 'dark';
            if (document.documentElement.classList.contains('dark') !== isDark) {
                window.syncTheme();
            }
        }
    }, 500);

    // Re-run on critical Livewire events
    document.addEventListener('livewire:navigated', window.syncTheme);
    document.addEventListener('livewire:initialized', window.syncTheme);

    document.addEventListener('DOMContentLoaded', window.updateThemeIcon);
</script>

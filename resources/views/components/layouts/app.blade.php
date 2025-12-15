<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kost Asri</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#ecfdf5', 100: '#d1fae5', 500: '#10b981', 600: '#059669', 700: '#047857', 900: '#064e3b' },
                        dark: { bg: '#0f172a', card: '#1e293b', text: '#f8fafc' }
                    }
                }
            }
        }
    </script>

    <style>
        /* Transisi halus */
        body, div, nav, aside, table, tr, td, th, main {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-dark-bg dark:text-dark-text font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar (Tetap Diam) --}}
        @include('components.layouts.sidebar')

        {{-- Area Konten Utama --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            {{-- Navbar (Tetap di Atas) --}}
            @include('components.layouts.navbar')

            {{-- [REVISI DISINI] --}}
            {{-- Tambahkan <main> dengan overflow-y-auto agar konten bisa di-scroll --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-dark-bg scroll-smooth">
                {{-- Slot Halaman (Daftar Kamar, Booking, dll akan masuk sini) --}}
                {{ $slot }}
            </main>

        </div>
    </div>

    <script>
        // --- Dark Mode Logic ---
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            if(themeIcon) { themeIcon.classList.remove('fa-moon'); themeIcon.classList.add('fa-sun'); }
        } else {
            html.classList.remove('dark');
            if(themeIcon) { themeIcon.classList.remove('fa-sun'); themeIcon.classList.add('fa-moon'); }
        }

        function toggleDarkMode() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                if(themeIcon) { themeIcon.classList.remove('fa-sun'); themeIcon.classList.add('fa-moon'); }
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                if(themeIcon) { themeIcon.classList.remove('fa-moon'); themeIcon.classList.add('fa-sun'); }
            }
            updateChartTheme();
        }

        // --- Chart Config (Dengan Pengecekan ID agar tidak error di halaman lain) ---
        function getChartColors() {
            const isDark = html.classList.contains('dark');
            return {
                text: isDark ? '#9ca3af' : '#64748b',
                grid: isDark ? '#374151' : '#e2e8f0',
                primary: '#10b981',
            };
        }

        // Variable global untuk chart instance
        let revenueChartInstance = null;

        // Cek apakah elemen ada sebelum render (PENTING untuk halaman non-dashboard)
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const ctxRevenue = revenueCtx.getContext('2d');
            revenueChartInstance = new Chart(ctxRevenue, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: [18, 20, 19, 22, 21, 22.5],
                        backgroundColor: '#10b981',
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { color: getChartColors().grid }, ticks: { color: getChartColors().text } },
                        x: { grid: { display: false }, ticks: { color: getChartColors().text } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        const occupancyCtx = document.getElementById('occupancyChart');
        if (occupancyCtx) {
            new Chart(occupancyCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Terisi', 'Kosong'],
                    datasets: [{
                        data: [15, 5],
                        backgroundColor: ['#10b981', '#cbd5e1'],
                        borderWidth: 0,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false } } }
            });
        }

        function updateChartTheme() {
            if (revenueChartInstance) {
                const colors = getChartColors();
                revenueChartInstance.options.scales.y.grid.color = colors.grid;
                revenueChartInstance.options.scales.y.ticks.color = colors.text;
                revenueChartInstance.options.scales.x.ticks.color = colors.text;
                revenueChartInstance.update();
            }
        }
    </script>
</body>
</html>

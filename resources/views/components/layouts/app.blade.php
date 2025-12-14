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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981', // Emerald Green
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                        },
                        dark: {
                            bg: '#0f172a', // Slate 900
                            card: '#1e293b', // Slate 800
                            text: '#f8fafc'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth Transition untuk Dark Mode */
        body,
        div,
        nav,
        aside,
        table,
        tr,
        td,
        th {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-dark-bg dark:text-dark-text font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        @include('components.layouts.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            @include('components.layouts.navbar')

            {{ $slot }}
        </div>
    </div>

    <script>
        // --- 1. Dark Mode Logic ---
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');

        // Cek LocalStorage
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            html.classList.remove('dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }

        function toggleDarkMode() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
            updateChartTheme(); // Update warna chart saat toggle
        }

        // --- 2. Chart.js Configurations ---

        // Setup Chart Colors based on theme
        function getChartColors() {
            const isDark = html.classList.contains('dark');
            return {
                text: isDark ? '#9ca3af' : '#64748b', // Text Color
                grid: isDark ? '#374151' : '#e2e8f0', // Grid Color
                primary: '#10b981', // Emerald 500
            };
        }

        // Data Dummy Chart Pendapatan
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(ctxRevenue, {
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
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: getChartColors().grid
                        },
                        ticks: {
                            color: getChartColors().text
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: getChartColors().text
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Data Dummy Chart Okupansi
        const ctxOccupancy = document.getElementById('occupancyChart').getContext('2d');
        let occupancyChart = new Chart(ctxOccupancy, {
            type: 'doughnut',
            data: {
                labels: ['Terisi', 'Kosong'],
                datasets: [{
                    data: [15, 5],
                    backgroundColor: ['#10b981', '#cbd5e1'], // Emerald & Gray
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });

        // Fungsi Update Chart saat ganti tema
        function updateChartTheme() {
            const colors = getChartColors();

            // Update Revenue Chart
            revenueChart.options.scales.y.grid.color = colors.grid;
            revenueChart.options.scales.y.ticks.color = colors.text;
            revenueChart.options.scales.x.ticks.color = colors.text;
            revenueChart.update();
        }
    </script>
</body>

</html>

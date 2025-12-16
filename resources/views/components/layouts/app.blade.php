<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kost Asri</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome & Google Fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- KONFIGURASI TAILWIND (GABUNGAN) --}}
    <script>
        // 1. Fungsi untuk mengatur warna Brand (Opsional, agar rapi)
        // Kamu bisa mengganti nilai ini secara dinamis nanti jika perlu
        const brandColors = {
            light: '#3b82f6',   // Blue-500
            DEFAULT: '#3b82f6', // Blue-500 (Warna Utama)
            dark: '#1e3a8a',    // Blue-900
        };

        // 2. Konfigurasi Utama
        tailwind.config = {
            darkMode: 'class', // Penting agar dark mode toggle bekerja
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        // Warna bawaan aplikasi (Emerald)
                        primary: {
                            50: '#ecfdf5', 100: '#d1fae5', 500: '#10b981',
                            600: '#059669', 700: '#047857', 900: '#064e3b'
                        },
                        // Warna mode gelap
                        dark: {
                            bg: '#0f172a', card: '#1e293b', text: '#f8fafc'
                        },
                        // Warna BRAND (Dimasukkan di sini agar tidak menimpa yang lain)
                        brand: brandColors
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-dark-bg dark:text-dark-text font-sans antialiased">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        {{-- Sidebar Component --}}
        @include('components.layouts.sidebar')

        {{-- Main Content Wrapper --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            {{-- Navbar Component --}}
            @include('components.layouts.navbar')

            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-dark-bg p-4 md:p-6 scroll-smooth">
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>

    {{-- Script di body dihapus karena sudah digabung di head --}}
<script>
    // Ambil elemen icon dan html
    const themeIcon = document.getElementById('theme-icon');
    const htmlElement = document.documentElement;

    // 1. Cek Kondisi Awal saat halaman dimuat (Load saved preference)
    // Jika user pernah pilih dark, atau settingan OS mereka dark mode
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun'); // Sedang gelap, tawarkan icon matahari
    } else {
        htmlElement.classList.remove('dark');
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon'); // Sedang terang, tawarkan icon bulan
    }

    // 2. Fungsi yang dipanggil saat tombol diklik
    function toggleDarkMode() {
        if (htmlElement.classList.contains('dark')) {
            // Ubah ke LIGHT mode
            htmlElement.classList.remove('dark');
            localStorage.theme = 'light'; // Simpan ke memori

            // Ubah Icon jadi Bulan
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            // Ubah ke DARK mode
            htmlElement.classList.add('dark');
            localStorage.theme = 'dark'; // Simpan ke memori

            // Ubah Icon jadi Matahari
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
    }
</script>

</body> </html>
</body>
</html>

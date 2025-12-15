<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kost Asri</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
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

    {{--
       PERBAIKAN UTAMA:
       HAPUS baris <script src="...alpine.js..."></script> di sini.
       Livewire 3 akan otomatis menyuntikkan Alpine.js dan script Livewire.
    --}}
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

</body>
</html>

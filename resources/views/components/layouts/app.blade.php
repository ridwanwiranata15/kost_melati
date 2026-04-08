<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Kos El Sholeha' }}</title>

    {{-- Vite for Tailwind 4 and App JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Flux UI Appearance (handles dark mode class on html) --}}
    @fluxAppearance

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Global Theme Script --}}
    @include('partials.theme-script')

    {{-- x-cloak: hide elements before Alpine initializes --}}
    <style>[x-cloak] { display: none !important; }</style>
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

    {{-- Flux UI Scripts (handles Livewire and Alpine) --}}
    @fluxScripts
</body>
</html>

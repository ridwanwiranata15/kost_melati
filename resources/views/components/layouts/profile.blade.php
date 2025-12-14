<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - Kos Melati Indah</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#ecfdf5', 100: '#d1fae5', 500: '#10b981', 600: '#059669', 900: '#064e3b' },
                        dark: { 900: '#0f172a', 800: '#1e293b' }
                    }
                }
            }
        }
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <div class="flex h-screen overflow-hidden bg-gray-50">

        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black/50 hidden lg:hidden backdrop-blur-sm transition-opacity"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-dark-900 text-white transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out flex flex-col h-full shadow-2xl shrink-0">

            <div class="h-20 flex items-center px-8 border-b border-gray-800/50">
                <a href="/" class="text-xl font-bold tracking-wide flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary-500 flex items-center justify-center text-white shadow-lg shadow-primary-500/20">
                        <i class="fas fa-home text-sm"></i>
                    </div>
                    <span class="tracking-tight">TEDJIA<span class="text-primary-500">.</span></span>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
                <a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all group">
                    <i class="fa-regular fa-user w-6 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Profil Saya</span>
                </a>

                {{-- Sesuaikan route ini jika perlu --}}
                <a href="{{ route('customer.order') }}" class="{{ request()->routeIs('customer.order') ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition-all group">
                    <i class="fa-solid fa-receipt w-6 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Tagihan & Booking</span>
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl transition-all group">
                    <i class="fa-regular fa-bell w-6 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Notifikasi</span>
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">2</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-500 rounded-xl transition-all group">
                        <i class="fa-solid fa-arrow-right-from-bracket w-6 text-lg group-hover:translate-x-1 transition-transform"></i>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <header class="bg-white border-b border-gray-200 lg:hidden flex items-center justify-between px-4 h-16 shrink-0 z-10">
                <button onclick="toggleSidebar()" class="text-gray-600 focus:outline-none p-2 rounded-md hover:bg-gray-100">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <span class="font-bold text-gray-800">TEDJIA KOS</span>
                <div class="w-8"></div> </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="w-full h-full">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Script Preview Image (Global Helper)
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-preview');
                if(output) output.src = reader.result;
            }
            if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>

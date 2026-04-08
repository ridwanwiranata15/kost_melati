<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/50 z-40 md:hidden backdrop-blur-sm">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-dark-card border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:flex flex-col">

    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <i class="fas fa-leaf text-primary-500 text-2xl mr-3"></i>
            <span class="text-xl font-bold text-primary-700 dark:text-primary-500">Kost Asri</span>
        </div>
        <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-red-500">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    @php
        $activeClass = 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400';
        $inactiveClass = 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700';
    @endphp

    @php $authUser = auth()->user(); @endphp

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

        {{-- Role badge --}}
        @if($authUser->isCaretaker())
        <div class="mb-4 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 flex items-center gap-2">
            <i class="fas fa-user-shield text-blue-500 text-xs"></i>
            <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide">Penjaga Kost</span>
        </div>
        @else
        <div class="mb-4 px-3 py-2 rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 flex items-center gap-2">
            <i class="fas fa-crown text-purple-500 text-xs"></i>
            <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wide">Super Admin</span>
        </div>
        @endif

        {{-- Menu Utama --}}
        <div class="pb-1 px-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</div>
        <a href="{{ route('dashboard') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-home w-6"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.room') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.room*') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-door-open w-6"></i>
            <span class="font-medium">Data Kamar</span>
        </a>
        <a href="{{ route('admin.booking') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.booking') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fa fa-book-open w-6"></i>
            <span class="font-medium">Booking & Check-in</span>
        </a>

        @if($authUser->isAdmin())
        {{-- Menu khusus Admin --}}
        <div class="pt-3 pb-1 px-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Manajemen</div>
        <a href="{{ route('admin.user') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.user*') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-users w-6"></i>
            <span class="font-medium">Penghuni</span>
        </a>
        <a href="{{ route('admin.gallery') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.gallery') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-images w-6"></i>
            <span class="font-medium">Galeri</span>
        </a>

        <div class="pt-3 pb-1 px-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Pengaturan Sistem</div>
        <a href="{{ route('admin.properties') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.properties') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-building w-6"></i>
            <span class="font-medium">Daftar Properti</span>
        </a>
        <a href="{{ route('admin.staff') }}" wire:navigate
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('admin.staff') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-user-shield w-6"></i>
            <span class="font-medium">Manajemen Staff</span>
        </a>
        @endif

        {{-- Profil & Settings (semua role) --}}
        <div class="pt-3 pb-1 px-2 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Akun</div>
        <a href="{{ route('customer.profile') }}"
            class="flex items-center px-4 py-2.5 {{ request()->routeIs('customer.profile') ? $activeClass : $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-user-circle w-6"></i>
            <span class="font-medium">Profil Saya</span>
        </a>
        <a href="{{ route('home') }}"
            class="flex items-center px-4 py-2.5 {{ $inactiveClass }} rounded-lg transition-colors">
            <i class="fas fa-globe w-6"></i>
            <span class="font-medium">Halaman Utama</span>
        </a>
    </nav>

    {{-- Logout di sidebar (backup, sama dengan di navbar dropdown) --}}
    <div class="p-2 border-t border-gray-200 dark:border-gray-700">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="w-full flex items-center px-4 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

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

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('dashboard') }}" wire:navigate
            class="flex items-center px-4 py-3 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg transition-colors">
            <i class="fas fa-home w-6"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.room') }}" wire:navigate
            class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <i class="fas fa-door-open w-6"></i>
            <span class="font-medium">Data Kamar</span>
        </a>
        <a href="{{ route('admin.user') }}" wire:navigate
            class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <i class="fas fa-users w-6"></i>
            <span class="font-medium">Penghuni</span>
        </a>
        <a href="{{ route('admin.booking') }}" wire:navigate
            class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <i class="fa fa-book-open w-6"></i> {{-- Tambah w-6 agar rata --}}
            <span class="font-medium">Booking</span>
        </a>
        <a href="{{ route('admin.gallery') }}" wire:navigate
            class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <i class="fas fa-file-invoice-dollar w-6"></i>
            <span class="font-medium">Galeri</span>
        </a>
    </nav>
    <div class="p-1 border-t border-gray-200 dark:border-gray-700">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="w-full flex items-center px-4 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
</aside>

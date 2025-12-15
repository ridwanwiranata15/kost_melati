<header class="h-16 flex items-center justify-between px-0 md:px-6 bg-white dark:bg-dark-card border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">

    <button @click="sidebarOpen = true"
            class="h-16 px-4 flex items-center text-gray-500 hover:text-primary-600 md:hidden focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
    </button>

    <div class="flex items-center gap-4 pr-4 md:pr-0 ml-auto">

        <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400">
            <i id="theme-icon" class="fas fa-moon"></i>
        </button>

        <button class="relative text-gray-500 hover:text-gray-700 dark:text-gray-400">
            <i class="fas fa-bell"></i>
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white transform translate-x-1/2 -translate-y-1/2"></span>
        </button>

        <div class="relative">
            <button class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 text-white shadow-sm">
                <span class="text-xs font-medium">AK</span>
            </button>
        </div>
    </div>

</header>

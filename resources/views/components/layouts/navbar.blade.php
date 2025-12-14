<header
                class="h-16 bg-white dark:bg-dark-card border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6">
                <button class="md:hidden text-gray-500 hover:text-primary-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <span class="md:hidden font-bold text-primary-600 dark:text-primary-500">Kost Asri</span>

                <div class="flex items-center space-x-4 ml-auto">
                    <button onclick="toggleDarkMode()"
                        class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-yellow-400 transition-colors">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>

                    <button
                        class="relative w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:text-primary-500 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-600">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold dark:text-white">Admin Utama</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pemilik Kost</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+Kost&background=10b981&color=fff"
                            class="w-9 h-9 rounded-full border-2 border-white dark:border-gray-600 shadow-sm"
                            alt="Profile">
                    </div>
                </div>
            </header>

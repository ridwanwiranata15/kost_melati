<header
    class="h-16 flex items-center justify-between px-0 md:px-6 bg-white dark:bg-dark-card border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">

    {{-- Hamburger (mobile only) --}}
    <button @click="sidebarOpen = true"
        class="h-16 px-4 flex items-center text-gray-500 hover:text-primary-600 md:hidden focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
    </button>

    {{-- Right side actions --}}
    <div class="flex items-center gap-2 sm:gap-3 pr-4 md:pr-0 ml-auto">

        {{-- Beranda (Landing Page) --}}
        <a href="{{ route('home') }}"
            class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
            title="Kembali ke Halaman Utama">
            <i class="fas fa-globe text-sm"></i>
            <span>Beranda</span>
        </a>

        {{-- Mobile: hanya icon Beranda --}}
        <a href="{{ route('home') }}"
            class="sm:hidden flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 transition-colors"
            title="Kembali ke Beranda">
            <i class="fas fa-globe text-base"></i>
        </a>

        {{-- Dark Mode Toggle --}}
        <button x-data="{
            // Baca status tema saat ini dari localStorage atau preferensi sistem
            isDark: localStorage.getItem('flux.appearance') === 'dark' || (!localStorage.getItem('flux.appearance') && window.matchMedia('(prefers-color-scheme: dark)').matches),

            toggleTheme() {
                // Tentukan tema selanjutnya
                const nextTheme = this.isDark ? 'light' : 'dark';

                // Simpan ke localStorage
                localStorage.setItem('flux.appearance', nextTheme);

                // AUTO HARD REFRESH instan sesuai ide Anda!
                window.location.reload();
            }
        }" @click="toggleTheme()"
            class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors cursor-pointer"
            title="Ganti Tema">

            {{-- Icon matahari/bulan --}}
            <i class="fas" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
        </button>

        {{-- User Dropdown --}}
        @php $user = auth()->user(); @endphp
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false"
                class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                {{-- Avatar --}}
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-500 text-white text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name ?? 'U ')[1] ?? '', 0, 1)) }}
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-xs font-semibold text-gray-800 dark:text-white leading-tight max-w-[100px] truncate">
                        {{ $user->name ?? 'User' }}
                    </p>
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 capitalize">
                        {{ $user->role === 'admin' ? 'Super Admin' : ($user->role === 'caretaker' ? 'Penjaga Kost' : $user->role) }}
                    </p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-gray-400 hidden sm:block transition-transform duration-200"
                    :class="{ 'rotate-180': open }"></i>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-1 w-52 rounded-xl bg-white dark:bg-dark-card shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden z-50"
                style="top: 100%;">

                {{-- User info row --}}
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $user->name ?? 'User' }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email ?? '' }}</p>
                </div>

                {{-- Menu items --}}
                <div class="py-1">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-globe w-4 text-center text-gray-400"></i>
                        <span>Halaman Utama</span>
                    </a>
                    <a href="{{ route('customer.profile') }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-user-circle w-4 text-center text-gray-400"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>

                {{-- Logout --}}
                <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <i class="fas fa-sign-out-alt w-4 text-center"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</header>

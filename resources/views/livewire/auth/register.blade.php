<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kos Melati Indah</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981', // Emerald
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">

    <div class="min-h-screen flex">

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white overflow-y-auto">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                <div class="text-center lg:text-left">
                    <a href="/" class="inline-flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white text-xl shadow-lg shadow-primary-500/30">
                            <i class="fas fa-home"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">Kos Melati Indah</span>
                    </a>

                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Buat Akun Baru</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Bergabunglah dan temukan kamar impianmu sekarang.
                    </p>
                </div>

                <div class="mt-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-user text-gray-400"></i>
                                </div>
                                <input id="name" name="name" type="text" required autofocus
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition"
                                    placeholder="Nama Sesuai KTP">
                            </div>
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition"
                                    placeholder="nama@email.com">
                            </div>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-gray-400"></i>
                                </div>
                                <input id="phone" name="phone" type="number"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition"
                                    placeholder="08123xxxxx">
                            </div>
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition"
                                    placeholder="Min. 8 karakter">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePass('password', 'eye-pass')">
                                    <i id="eye-pass" class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                                </div>
                            </div>
                            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition"
                                    placeholder="Ulangi password">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePass('password_confirmation', 'eye-conf')">
                                    <i id="eye-conf" class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Sudah punya akun?</span>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Masuk disini
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1596276020587-8044fe049813?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Suasana Kos">

            <div class="absolute inset-0 bg-gradient-to-t from-primary-900/90 via-primary-800/50 to-transparent flex flex-col justify-end p-16">
                <div class="relative z-10 text-white">
                    <div class="w-16 h-1 bg-green-400 mb-6 rounded-full"></div>
                    <h3 class="text-4xl font-bold mb-4 leading-tight">Mulai Hidup Nyaman<br>di Lingkungan Terbaik.</h3>
                    <p class="text-lg text-green-50 opacity-90 max-w-lg">
                        Daftar sekarang dan nikmati kemudahan booking kamar kost secara online, aman, dan transparan.
                    </p>

                    <div class="mt-8 flex gap-6">
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm"><i class="fas fa-wifi text-white"></i></div>
                            <span class="text-sm font-medium">Free WiFi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm"><i class="fas fa-shield-alt text-white"></i></div>
                            <span class="text-sm font-medium">Aman 24 Jam</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm"><i class="fas fa-bolt text-white"></i></div>
                            <span class="text-sm font-medium">Bebas Listrik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>

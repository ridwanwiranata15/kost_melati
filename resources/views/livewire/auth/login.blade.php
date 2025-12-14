<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kos Melati Indah</title>

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

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                <div class="text-center lg:text-left">
                    <a href="/" class="inline-flex items-center gap-2 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white text-xl shadow-lg shadow-primary-500/30">
                            <i class="fas fa-home"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">Kos Melati Indah</span>
                    </a>

                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">Selamat Datang Kembali!</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Silakan masuk untuk mengelola akun Anda.
                    </p>
                </div>

                <div class="mt-10">
                    <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out"
                                    placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out"
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword()">
                                    <i id="eye-icon" class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                            </div>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors">
                                    Lupa password?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5">
                                Masuk Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Belum punya akun?</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('register') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Interior Kost">

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-16">
                <div class="relative z-10 text-white">
                    <h3 class="text-4xl font-bold mb-4">Kenyamanan Anda, <br>Prioritas Utama Kami.</h3>
                    <p class="text-lg text-gray-200 opacity-90 max-w-lg">
                        Nikmati pengalaman tinggal di hunian kost yang bersih, aman, dan strategis di pusat kota.
                    </p>

                    <div class="mt-8 flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 w-fit">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=A&background=random" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=B&background=random" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=C&background=random" alt="">
                        </div>
                        <div class="text-sm">
                            <span class="font-bold text-white">50+ Penghuni</span>
                            <span class="text-gray-300 text-xs block">Bergabung bersama kami</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>

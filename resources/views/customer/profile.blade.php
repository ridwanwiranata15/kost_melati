<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/60f3c978d3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tedjia | My Profile</title>

    <style>
        /* =========================================
             BASE STYLE & SIDEBAR
           (Sama persis dengan halaman sebelumnya)
        ========================================= */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F3F4F6;
            color: #1F2937;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        .layout-wrapper { display: flex; min-height: 100vh; width: 100%; }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 280px;
            background-color: #02051E;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-content { padding: 40px 30px; }
        .logo-container { margin-bottom: 40px; }
        .nav-list { display: flex; flex-direction: column; gap: 15px; }

        .nav-item .nav-link {
            display: block;
            padding: 12px 16px;
            border-radius: 12px;
            color: #9CA3AF;
            transition: 0.3s;
        }

        .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active .nav-link {
            background-color: #D4F247;
            color: #02051E;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(212, 242, 71, 0.3);
        }

        .nav-content { display: flex; align-items: center; gap: 12px; }

        /* --- MAIN WRAPPER --- */
        .main-wrapper {
            flex-grow: 1;
            padding: 40px 50px;
            background-color: #F8F9FD;
            overflow-y: auto;
        }

        /* --- RESPONSIVE SIDEBAR --- */
        @media screen and (max-width: 768px) {
            .layout-wrapper { display: block; }
            .sidebar {
                position: fixed; bottom: 0; top: auto; left: 0; right: 0;
                width: 100%; height: auto; padding: 0;
                border-top-left-radius: 20px; border-top-right-radius: 20px;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1); z-index: 50;
            }
            .logo-container { display: none; }
            .sidebar-content { padding: 15px 10px; }
            .nav-list { flex-direction: row; justify-content: space-around; }
            .nav-content { flex-direction: column; gap: 4px; align-items: center; }
            .nav-text { font-size: 10px; }
            .main-wrapper { padding: 20px 20px 100px 20px; }
            .nav-item.active .nav-link { padding: 8px 12px; }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <aside class="sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <a href="/" class="text-2xl font-bold tracking-wider text-white">
                        TEDJIA<span style="color:#D4F247">.</span>
                    </a>
                </div>

                <ul class="nav-list">
                    <li class="nav-item active">
                        <a href="{{ route('customer.profile') }}" class="nav-link">
                            <div class="nav-content">
                                <i class="fa-regular fa-user text-lg"></i>
                                <p class="nav-text">Profile</p>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('customer.order') }}" class="nav-link">
                            <div class="nav-content">
                                <i class="fa-solid fa-basket-shopping text-lg"></i>
                                <p class="nav-text">My Order</p>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link w-full text-left">
                                <div class="nav-content">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                                    <p class="nav-text">Log out</p>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="main-wrapper">
            <main class="content-area max-w-5xl mx-auto">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">My Profile</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola informasi pribadi dan keamanan akun</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center sticky top-4">
                            <div class="relative w-32 h-32 mx-auto mb-4 group">
                                <img src="{{ url('storage/' . auth()->user()->photo) }}"
                                     alt="Profile Photo"
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-50 shadow-md">

                                <label for="photo-upload" class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                    <i class="fa-solid fa-camera text-white text-xl"></i>
                                </label>
                                <input type="file" id="photo-upload" class="hidden">
                            </div>

                            <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-500 mb-4">{{ auth()->user()->email }}</p>

                            <div class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
                                {{ auth()->user()->status }}
                            </div>

                            <div class="border-t border-gray-100 pt-4 text-left">
                                <p class="text-xs text-gray-400 uppercase font-semibold mb-3">Info Kost</p>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                        <i class="fa-solid fa-door-open text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Kamar</p>
                                        <p class="text-sm font-semibold text-gray-800">A-12 (Lantai 2)</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                        <i class="fa-solid fa-calendar-check text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Bergabung Sejak</p>
                                        <p class="text-sm font-semibold text-gray-800">12 Jan 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-800">Data Pribadi</h3>
                                <button class="text-sm text-blue-600 font-medium hover:underline">Edit</button>
                            </div>

                            <form action="#" method="POST">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition" placeholder="Nama Lengkap">
                                    </div>

                                    <div class="col-span-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Alamat Email</label>
                                        <input type="email" value="{{ auth()->user()->email }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition" placeholder="email@domain.com">
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="bg-[#02051E] text-white hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-6 py-3 text-center transition shadow-lg shadow-gray-300/50">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>

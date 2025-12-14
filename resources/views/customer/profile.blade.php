<x-layouts.profile>
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:hidden">
                <button onclick="toggleSidebar()" class="text-gray-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <span class="font-bold text-gray-800">Profil Saya</span>
                <div class="w-6"></div> </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-8">
                <div class="max-w-5xl mx-auto">

                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda di sini.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <div class="lg:col-span-1 space-y-6">

                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-primary-500 to-primary-600"></div>

                                <div class="relative z-10 -mt-4">
                                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                                        @if(auth()->user()->photo)
                                            <img id="profile-preview" src="{{ url('storage/' . auth()->user()->photo) }}"
                                                class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                        @else
                                            <img id="profile-preview" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=10b981&color=fff"
                                                class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                        @endif

                                        <div class="absolute bottom-2 right-2 bg-gray-900 text-white p-2 rounded-full shadow-lg border-2 border-white cursor-pointer hover:bg-primary-500 transition-colors" onclick="document.getElementById('file-upload').click()">
                                            <i class="fas fa-camera text-xs"></i>
                                        </div>
                                    </div>

                                    <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>

                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ auth()->user()->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }} mr-2"></span>
                                            {{ ucfirst(auth()->user()->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-l-4 border-primary-500 pl-3">Info Hunian</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-door-open"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Nomor Kamar</p>
                                            <p class="font-bold text-gray-800">A-12 (Lantai 1)</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Mulai Ngekos</p>
                                            <p class="font-bold text-gray-800">12 Jan 2025</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="lg:col-span-2 space-y-8">

                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h3 class="text-lg font-bold text-gray-900">Edit Data Pribadi</h3>
                                    <p class="text-xs text-gray-500">Perbarui informasi kontak dan profil Anda.</p>
                                </div>
                                <div class="p-6">
                                    <form action="#" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="col-span-2 md:col-span-1">
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="far fa-user"></i></span>
                                                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm" placeholder="Nama Lengkap">
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="far fa-envelope"></i></span>
                                                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm" placeholder="email@domain.com">
                                                </div>
                                            </div>

                                            <div class="col-span-2 md:col-span-1">
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">No. WhatsApp</label>
                                                <div class="relative">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fab fa-whatsapp"></i></span>
                                                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm" placeholder="08123xxxx">
                                                </div>
                                            </div>

                                            <input type="file" name="photo" id="file-upload" class="hidden" onchange="previewImage(event)">
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all shadow-lg shadow-primary-500/30 flex items-center gap-2">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                                    <p class="text-xs text-gray-500">Ubah password akun Anda secara berkala.</p>
                                </div>
                                <div class="p-6">
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Password Saat Ini</label>
                                                <input type="password" name="current_password" class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Password Baru</label>
                                                    <input type="password" name="password" class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Ulangi Password Baru</label>
                                                    <input type="password" name="password_confirmation" class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2">
                                                <i class="fas fa-lock"></i> Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </main>
        </div>
</x-layouts.profile>

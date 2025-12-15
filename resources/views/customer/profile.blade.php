@php
    // LOGIKA PHP: Pindahkan ke atas agar rapi
    $durasiTeks = '-';
    $hasActiveBooking = false;

    // Pastikan variabel $booking ada (dikirim dari controller)
    // Jika tidak dikirim, anggap null.
    $booking = $booking ?? null;

    if ($booking && $booking->status == 'confirmed') {
        $hasActiveBooking = true;

        $tglMasuk = \Carbon\Carbon::parse($booking->date_in);
        $sekarang = \Carbon\Carbon::now();

        if ($tglMasuk->isFuture()) {
            $durasiTeks = 'Menunggu Check-in';
        } else {
            $durasiTeks =
                'Sudah ' .
                $tglMasuk->diffForHumans($sekarang, [
                    'syntax' => \Carbon\Carbon::DIFF_ABSOLUTE,
                    'parts' => 2,
                    'join' => true,
                ]);
        }
    }
@endphp

<x-layouts.profile>
    {{-- Alert Sukses --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Alert Error Validasi Global --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        {{-- Header Mobile --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-gray-800">Profil Saya</span>
            <div class="w-6"></div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-8">
            <div class="max-w-5xl mx-auto">

                {{-- Page Header --}}
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda di sini.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: FOTO & INFO SINGKAT --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Card Profil Foto --}}
                        <div
                            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-primary-500 to-primary-600">
                            </div>

                            <div class="relative z-10 -mt-4">
                                <div class="relative w-32 h-32 mx-auto mb-4 group">
                                    @if (auth()->user()->photo)
                                        <img id="profile-preview" src="{{ url('storage/' . auth()->user()->photo) }}"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                    @else
                                        <img id="profile-preview"
                                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=10b981&color=fff"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                    @endif

                                    {{-- Tombol Ganti Foto --}}
                                    <div class="absolute bottom-2 right-2 bg-gray-900 text-white p-2 rounded-full shadow-lg border-2 border-white cursor-pointer hover:bg-primary-500 transition-colors"
                                        onclick="document.getElementById('file-upload').click()">
                                        <i class="fas fa-camera text-xs"></i>
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>

                                <div class="mt-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ auth()->user()->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ auth()->user()->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }} mr-2"></span>
                                        {{ ucfirst(auth()->user()->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Info Hunian (Hanya muncul jika ada booking aktif) --}}
                        @if ($hasActiveBooking)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3
                                    class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-l-4 border-primary-500 pl-3">
                                    Info Hunian</h3>

                                <div class="space-y-4">
                                    {{-- Item 1: Nomor Kamar --}}
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-door-open"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Nomor Kamar</p>
                                            <p class="font-bold text-gray-800">
                                                {{ $booking->room->room_number ?? '-' }}
                                                <span
                                                    class="text-xs font-normal text-gray-500">({{ $booking->room->type ?? 'Standard' }})</span>
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Item 2: Mulai Ngekos --}}
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Mulai Ngekos</p>
                                            <p class="font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($booking->date_in)->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Item 3: Durasi Saat Ini --}}
                                    <div
                                        class="flex items-center p-3 bg-primary-50 rounded-xl border border-primary-100">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-hourglass-half"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-primary-600 font-semibold">Durasi Huni Saat Ini</p>
                                            <p class="font-bold text-gray-900">{{ $durasiTeks }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- KOLOM KANAN: FORM EDIT PROFIL & PASSWORD --}}
                    <div class="lg:col-span-2 space-y-8">

                        {{-- Form Data Pribadi --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-lg font-bold text-gray-900">Edit Data Pribadi</h3>
                                <p class="text-xs text-gray-500">Perbarui informasi kontak dan profil Anda.</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('profile.password') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Input File Tersembunyi (Dipicu oleh icon kamera di atas) --}}
                                    <input type="file" name="photo" id="file-upload" class="hidden"
                                        onchange="previewImage(event)">
                                        @error('photo')
                                            <div class="mt-2 p-2 bg-red-100 border border-red-400 text-red-700 text-sm rounded">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Nama --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama
                                                Lengkap</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="far fa-user"></i>
                                                </span>
                                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="Nama Lengkap">
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="far fa-envelope"></i>
                                                </span>
                                                <input type="email" name="email"
                                                    value="{{ auth()->user()->email }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="email@domain.com">
                                            </div>
                                        </div>

                                        {{-- No HP --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">No.
                                                WhatsApp</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="fab fa-whatsapp"></i>
                                                </span>
                                                <input type="text" name="phone"
                                                    value="{{ auth()->user()->phone ?? '' }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="08123xxxx">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button type="submit"
                                            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all shadow-lg shadow-primary-500/30 flex items-center gap-2">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Form Keamanan (Password) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                                <p class="text-xs text-gray-500">Ubah password akun Anda secara berkala.</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('profile.password') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Password Saat
                                                Ini</label>
                                            <input type="password" name="current_password"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Password
                                                    Baru</label>
                                                <input type="password" name="password"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Ulangi
                                                    Password Baru</label>
                                                <input type="password" name="password_confirmation"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button type="submit"
                                            class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl font-medium text-sm transition-all flex items-center gap-2">
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

    {{-- Script Sederhana untuk Preview Image --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-layouts.profile>

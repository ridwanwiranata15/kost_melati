@php
    // --- 1. LOGIKA PHP (DURASI SEWA) ---
    $durasiTeks = '-';
    $booking = $booking ?? null; // Null Coalescing Operator (Safety Check)

    // Cek jika booking ada & statusnya confirmed (huruf kecil/besar tidak masalah)
    if ($booking && strtolower($booking->status) == 'confirmed') {

        // Reset jam ke 00:00:00 agar hitungan hari akurat
        $tglMasuk = \Carbon\Carbon::parse($booking->date_in)->startOfDay();
        $sekarang = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();

        // Cek apakah tanggal masuk masih di masa depan
        if ($tglMasuk->gt($sekarang)) {
            $durasiTeks = 'Menunggu Check-in';
        } else {
            // Hitung selisih hari
            $totalHari = $tglMasuk->diffInDays($sekarang);

            if ($totalHari == 0) {
                $durasiTeks = 'Baru hari ini';
            } else {
                $durasiTeks = 'Sudah ' . $totalHari . ' hari';
            }
        }
    } else {
        // Jika status pending/rejected
        $durasiTeks = 'Menunggu Konfirmasi';
    }
@endphp

<x-layouts.profile>
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        {{-- 2. HEADER MOBILE (Hanya muncul di layar kecil) --}}
        
        {{-- 3. MAIN CONTENT --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-8">
            <div class="max-w-5xl mx-auto">

                {{-- A. ALERT MESSAGES --}}
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- B. PAGE TITLE --}}
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda di sini.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- C. KOLOM KIRI (FOTO & INFO HUNIAN) --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Card 1: Foto Profil --}}
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                            {{-- Background Gradient --}}
                            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-primary-500 to-primary-600"></div>

                            <div class="relative z-10 -mt-4">
                                {{-- Avatar Wrapper --}}
                                <div class="relative w-32 h-32 mx-auto mb-4 group">
                                    @if (auth()->user()->photo)
                                        <img id="profile-preview" src="{{ url('storage/' . auth()->user()->photo) }}"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                    @else
                                        <img id="profile-preview"
                                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=10b981&color=fff"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                                    @endif

                                    {{-- Tombol Kamera (Trigger Input File) --}}
                                    <div class="absolute bottom-2 right-2 bg-gray-900 text-white p-2 rounded-full shadow-lg border-2 border-white cursor-pointer hover:bg-primary-500 transition-colors"
                                        onclick="document.getElementById('file-upload').click()">
                                        <i class="fas fa-camera text-xs"></i>
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>

                                {{-- Status Badge --}}
                                <div class="mt-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ auth()->user()->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }} mr-2"></span>
                                        {{ ucfirst(auth()->user()->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Card 2: Info Hunian (Hanya muncul jika user punya booking) --}}
                        @if ($booking)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-l-4 border-primary-500 pl-3">
                                    Info Hunian
                                </h3>

                                <div class="space-y-4">
                                    {{-- Info Nomor Kamar --}}
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-door-open"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Nomor Kamar</p>
                                            <p class="font-bold text-gray-800">
                                                {{ $booking->room->room_number ?? '-' }}
                                                <span class="text-xs font-normal text-gray-500">({{ $booking->room->type ?? 'Standard' }})</span>
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Info Mulai Ngekos --}}
                                    <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-600 shadow-sm mr-4">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Mulai Ngekos</p>
                                            <p class="font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($booking->date_in)->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Info Durasi (Hanya aktif jika confirmed) --}}
                                    <div class="flex items-center p-3 rounded-xl border {{ strtolower($booking->status) == 'confirmed' ? 'bg-primary-50 border-primary-100' : 'bg-yellow-50 border-yellow-100' }}">
                                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm mr-4 {{ strtolower($booking->status) == 'confirmed' ? 'text-primary-600' : 'text-yellow-600' }}">
                                            <i class="fa-solid {{ strtolower($booking->status) == 'confirmed' ? 'fa-hourglass-half' : 'fa-info-circle' }}"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold {{ strtolower($booking->status) == 'confirmed' ? 'text-primary-600' : 'text-yellow-600' }}">
                                                {{ strtolower($booking->status) == 'confirmed' ? 'Durasi Huni Saat Ini' : 'Status Booking' }}
                                            </p>
                                            <p class="font-bold text-gray-900">{{ $durasiTeks }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- D. KOLOM KANAN (FORM INPUT) --}}
                    <div class="lg:col-span-2 space-y-8">

                        {{-- Form 1: Edit Data Pribadi --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-lg font-bold text-gray-900">Edit Data Pribadi</h3>
                                <p class="text-xs text-gray-500">Perbarui informasi kontak dan profil Anda.</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Input File Hidden (Untuk Foto) --}}
                                    <input type="file" name="photo" id="file-upload" class="hidden" onchange="previewImage(event)">

                                    {{-- Error Message Foto --}}
                                    @error('photo')
                                        <div class="mb-4 p-2 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Input Nama --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="far fa-user"></i>
                                                </span>
                                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="Nama Lengkap">
                                            </div>
                                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Input Email --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="far fa-envelope"></i>
                                                </span>
                                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="email@domain.com">
                                            </div>
                                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Input No HP --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">No. WhatsApp</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="fab fa-whatsapp"></i>
                                                </span>
                                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="08123xxxx">
                                            </div>
                                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

                        {{-- Form 2: Keamanan (Password) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                                <p class="text-xs text-gray-500">Ubah password akun Anda secara berkala.</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        {{-- Password Lama --}}
                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Password Saat Ini</label>
                                            <input type="password" name="current_password"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Password Baru & Konfirmasi --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Password Baru</label>
                                                <input type="password" name="password"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm">
                                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Ulangi Password Baru</label>
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

    {{-- Script JavaScript untuk Preview Gambar --}}
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

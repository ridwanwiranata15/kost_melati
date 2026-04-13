@php
    // --- 1. LOGIKA PHP (DURASI SEWA) ---
    // --- 1. LOGIKA PHP (DURASI SEWA & STATUS) ---
    $durasiTeks = '-';
    $booking = $booking ?? null;
    $statusWarna = 'text-yellow-600'; // Default kuning
    $bgWarna = 'bg-yellow-50 border-yellow-100'; // Default latar kuning
    $iconWarna = 'text-yellow-600';
    $iconStatus = 'fa-info-circle';

    if ($booking) {
        $statusBook = strtolower($booking->status);

        // Jika statusnya Confirmed ATAU Checkin (Indikator Hijau/Aktif)
        if (in_array($statusBook, ['confirmed', 'checkin'])) {
            $statusWarna = 'text-primary-600';
            $bgWarna = 'bg-primary-50 border-primary-100';
            $iconWarna = 'text-primary-600';
            $iconStatus = 'fa-hourglass-half';

            $tglMasuk = \Carbon\Carbon::parse($booking->date_in)->startOfDay();
            $sekarang = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();

            if ($tglMasuk->gt($sekarang)) {
                $durasiTeks = 'Menunggu Check-in';
            } else {
                $totalHari = $tglMasuk->diffInDays($sekarang);
                $durasiTeks = $totalHari == 0 ? 'Baru hari ini' : 'Sudah ' . $totalHari . ' hari';
            }
        }
        // Jika Pending
        elseif ($statusBook === 'pending') {
            $durasiTeks = 'Menunggu Konfirmasi';
        }
        // Jika Checkout
        elseif ($statusBook === 'checkout') {
            $durasiTeks = 'Selesai Masa Sewa';
            $statusWarna = 'text-gray-600';
            $bgWarna = 'bg-gray-50 border-gray-200';
            $iconWarna = 'text-gray-500';
            $iconStatus = 'fa-check-double';
        }
        // Jika Cancelled
        else {
            $durasiTeks = 'Dibatalkan';
            $statusWarna = 'text-red-600';
            $bgWarna = 'bg-red-50 border-red-200';
            $iconWarna = 'text-red-600';
            $iconStatus = 'fa-times-circle';
        }
    }

    // KTP photo URL (served via protected route)
    $ktpUrl = null;
    if (auth()->user()->ktp_photo) {
        $filename = basename(auth()->user()->ktp_photo);
        $ktpUrl = route('ktp.photo', $filename);
    }
@endphp

<x-layouts.profile>
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-8">
            <div class="max-w-5xl mx-auto">

                {{-- A. ALERT MESSAGES --}}
                @if (session('success'))
                    <div
                        class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
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
                    <h1 class="flex items-center gap-2 text-2xl md:text-3xl font-bold text-gray-900">
                        <span>Halo, {{ auth()->user()->name }}!</span>
                        <img src="https://raw.githubusercontent.com/Ridhsuki/Ridhsuki/refs/heads/main/img/Hi.gif"
                            loading="lazy" class="w-8 h-8">
                    </h1>
                    <p class="text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda di sini.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- C. KOLOM KIRI --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Card: Foto Profil --}}
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
                                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white" loading="lazy">
                                    @endif
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

                        {{-- Card: Info Cepat --}}
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 space-y-3">
                            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Info Tambahan
                            </h3>

                            @if (auth()->user()->university)
                                <div class="flex items-start gap-3 text-sm">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500 flex-shrink-0 mt-0.5">
                                        <i class="fas fa-graduation-cap text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Universitas / Prodi</p>
                                        <p class="font-semibold text-gray-800 leading-tight">
                                            {{ auth()->user()->university }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->parents_name)
                                <div class="flex items-start gap-3 text-sm">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-500 flex-shrink-0 mt-0.5">
                                        <i class="fas fa-people-roof text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Orang Tua / Wali</p>
                                        <p class="font-semibold text-gray-800">{{ auth()->user()->parents_name }}</p>
                                        @if (auth()->user()->parents_phone)
                                            <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->parents_phone }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!auth()->user()->university && !auth()->user()->parents_name)
                                <p class="text-xs text-gray-400 italic text-center py-2">Belum ada data
                                    tambahan.<br>Lengkapi melalui form di bawah.</p>
                            @endif
                        </div>

                        {{-- Card: Info Hunian --}}
                        @if ($booking)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3
                                    class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4 border-l-4 border-primary-500 pl-3">
                                    Info Hunian</h3>
                                <div class="space-y-4">
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
                                    <div class="flex items-center p-3 rounded-xl border {{ $bgWarna }}">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm mr-4 {{ $iconWarna }}">
                                            <i class="fa-solid {{ $iconStatus }}"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold {{ $statusWarna }}">
                                                {{ in_array(strtolower($booking->status), ['confirmed', 'checkin']) ? 'Durasi Huni' : 'Status Booking' }}
                                            </p>
                                            <p class="font-bold text-gray-900">{{ $durasiTeks }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- D. KOLOM KANAN --}}
                    <div class="lg:col-span-2 space-y-8">

                        {{-- Form: Edit Data Pribadi --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-lg font-bold text-gray-900">Edit Data Pribadi</h3>
                                <p class="text-xs text-gray-500">Perbarui informasi kontak dan profil Anda.</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Hidden file input --}}
                                    <input type="file" name="photo" id="file-upload" class="hidden"
                                        accept="image/*" onchange="previewImage(event)">
                                    @error('photo')
                                        <div
                                            class="mb-4 p-2 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg">
                                            {{ $message }}</div>
                                    @enderror

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        {{-- Nama --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama
                                                Lengkap</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="far fa-user"></i></span>
                                                <input type="text" name="name"
                                                    value="{{ old('name', auth()->user()->name) }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm">
                                            </div>
                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="far fa-envelope"></i></span>
                                                <input type="email" name="email"
                                                    value="{{ old('email', auth()->user()->email) }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm">
                                            </div>
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- No. WA --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">No.
                                                WhatsApp</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="fab fa-whatsapp"></i></span>
                                                <input type="text" name="phone"
                                                    value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="08123xxxx">
                                            </div>
                                            @error('phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Universitas / Prodi --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Universitas /
                                                Program Studi</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="fas fa-graduation-cap"></i></span>
                                                <input type="text" name="university"
                                                    value="{{ old('university', auth()->user()->university ?? '') }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="cth: IAIN Curup – PAI">
                                            </div>
                                            @error('university')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Nama Ortu --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Orang
                                                Tua / Wali</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="fas fa-people-roof"></i></span>
                                                <input type="text" name="parents_name"
                                                    value="{{ old('parents_name', auth()->user()->parents_name ?? '') }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="Nama orang tua / wali">
                                            </div>
                                            @error('parents_name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- HP Ortu --}}
                                        <div class="col-span-2 md:col-span-1">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">No. HP Orang
                                                Tua / Wali</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                                        class="fas fa-phone"></i></span>
                                                <input type="text" name="parents_phone"
                                                    value="{{ old('parents_phone', auth()->user()->parents_phone ?? '') }}"
                                                    class="pl-10 w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-shadow py-2.5 text-sm"
                                                    placeholder="08123xxxx">
                                            </div>
                                            @error('parents_phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- KTP Photo Upload --}}
                                        <div class="col-span-2">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                                Foto KTP
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                                    <i class="fas fa-shield-alt mr-1"></i> Tersimpan Aman (Private)
                                                </span>
                                            </label>

                                            @if ($ktpUrl)
                                                <div
                                                    class="mb-3 p-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-4">
                                                    <img src="{{ $ktpUrl }}" alt="KTP Saat Ini"
                                                        class="h-20 w-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-700">KTP tersimpan
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-1">Upload baru untuk
                                                            mengganti. Diakses melalui link aman.</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-1">
                                                <label for="ktp-update"
                                                    class="flex items-center gap-3 cursor-pointer p-3 border border-dashed border-gray-300 rounded-xl hover:border-primary-400 hover:bg-primary-50 transition-colors">
                                                    <div
                                                        class="w-9 h-9 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600 flex-shrink-0">
                                                        <i class="fas fa-id-card text-sm"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-700"
                                                            id="ktp-update-label">
                                                            {{ $ktpUrl ? 'Ganti Foto KTP' : 'Upload Foto KTP' }}
                                                        </p>
                                                        <p class="text-xs text-gray-400">JPG, JPEG, PNG – Maks. 4 MB
                                                        </p>
                                                    </div>
                                                    <i class="fas fa-upload text-gray-400 text-sm"></i>
                                                </label>
                                                <input id="ktp-update" name="ktp_photo" type="file"
                                                    class="hidden" accept="image/*" onchange="updateKtpLabel(this)">
                                            </div>
                                            @error('ktp_photo')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
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

                        {{-- Form: Keamanan (Password) --}}
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
                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Password Saat
                                                Ini</label>
                                            <input type="password" name="current_password"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm"
                                                placeholder="••••••••">
                                            @error('current_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Password
                                                    Baru</label>
                                                <input type="password" name="password"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm"
                                                    placeholder="Min. 8 karakter">
                                                @error('password')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block mb-2 text-sm font-semibold text-gray-700">Ulangi
                                                    Password Baru</label>
                                                <input type="password" name="password_confirmation"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 py-2.5 text-sm"
                                                    placeholder="••••••••">
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

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profile-preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function updateKtpLabel(input) {
            const label = document.getElementById('ktp-update-label');
            if (input.files && input.files[0]) {
                label.textContent = input.files[0].name;
            }
        }
    </script>
</x-layouts.profile>

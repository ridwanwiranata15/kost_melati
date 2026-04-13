<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - El Sholeha Indah</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Step indicator progress animation */
        .step-line { transition: width 0.5s ease; }
        /* Slide transition */
        .step-panel { display: none; animation: fadeIn 0.35s ease forwards; }
        .step-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

        /* KTP drop zone */
        .drop-zone { border: 2px dashed #d1fae5; transition: border-color 0.2s, background-color 0.2s; }
        .drop-zone.drag-over { border-color: #10b981; background-color: #f0fdf4; }

        /* Avatar uploader */
        .avatar-ring { box-shadow: 0 0 0 3px #fff, 0 0 0 5px #10b981; }
        .avatar-overlay { opacity: 0; transition: opacity 0.2s ease; }
        .avatar-wrap:hover .avatar-overlay { opacity: 1; }
        .avatar-wrap { cursor: pointer; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <div class="min-h-screen flex">

        {{-- ===== LEFT PANEL (Form) ===== --}}
        <div class="flex-1 flex flex-col justify-center py-10 px-4 sm:px-8 lg:flex-none lg:w-[52%] bg-white overflow-y-auto">
            <div class="mx-auto w-full max-w-lg">

                {{-- Logo --}}
                <div class="mb-6">
                    <a href="/" class="inline-flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white text-xl shadow-lg shadow-primary-500/30">
                            <i class="fas fa-home"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">El Sholeha Indah</span>
                    </a>
                </div>

                {{-- Heading --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Buat Akun Baru</h2>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi data diri Anda dalam 2 langkah mudah.</p>
                </div>

                {{-- ======= Step Indicator ======= --}}
                <div class="flex items-center mb-8" id="step-indicator">
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center" id="ind-1">
                        <div class="w-9 h-9 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold shadow-md shadow-primary-500/30 transition-all">
                            <span id="ind-1-num">1</span>
                            <i class="fas fa-check hidden" id="ind-1-check"></i>
                        </div>
                        <span class="text-xs font-semibold text-primary-600 mt-1.5">Akun</span>
                    </div>

                    <div class="flex-1 mx-2 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progress-line" class="step-line h-full bg-primary-500 w-0"></div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center" id="ind-2">
                        <div class="w-9 h-9 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold transition-all" id="ind-2-circle">
                            <span id="ind-2-num">2</span>
                            <i class="fas fa-check hidden" id="ind-2-check"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-400 mt-1.5" id="ind-2-label">Data Diri</span>
                    </div>
                </div>

                {{-- ===== FORM ===== --}}
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="register-form" class="space-y-0">
                    @csrf

                    {{-- ============ STEP 1 ============ --}}
                    <div class="step-panel active space-y-5" id="panel-1">

                        {{-- ── Avatar / Profile Photo Uploader ── --}}
                        <div class="flex flex-col items-center gap-2 pb-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Foto Profil</p>

                            {{-- Clickable ring + preview circle --}}
                            <div class="relative avatar-wrap group" onclick="document.getElementById('photo-input').click()" title="Pilih foto profil">

                                {{-- Avatar image / placeholder --}}
                                <div id="avatar-placeholder"
                                    class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center avatar-ring shadow-lg">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>

                                <img id="avatar-preview" src="#" alt="Preview"
                                    class="w-24 h-24 rounded-full object-cover avatar-ring shadow-lg hidden">

                                {{-- Camera overlay --}}
                                <div class="avatar-overlay absolute inset-0 rounded-full bg-black/40 flex flex-col items-center justify-center">
                                    <i class="fas fa-camera text-white text-lg"></i>
                                    <span class="text-white text-[10px] font-semibold mt-0.5">Ubah</span>
                                </div>
                            </div>

                            {{-- File name / clear button --}}
                            <div id="avatar-meta" class="hidden flex items-center gap-2">
                                <span id="avatar-filename" class="text-xs text-primary-600 font-medium max-w-[160px] truncate"></span>
                                <button type="button" onclick="clearAvatar()"
                                    class="text-xs text-red-400 hover:text-red-600 transition-colors">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>

                            {{-- Hidden input --}}
                            <input id="photo-input" name="photo" type="file" class="hidden"
                                accept="image/jpeg,image/png,image/jpg"
                                onchange="previewAvatar(this)">

                            @error('photo')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="text-[11px] text-gray-400">JPG, PNG maks. 2 MB</p>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-user text-gray-400"></i>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" autofocus
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="Nama Sesuai KTP">
                            </div>
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="nama@email.com">
                            </div>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-gray-400"></i>
                                </div>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="08123xxxxxx">
                            </div>
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password"
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="Min. 8 karakter">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePass('password','eye-p1')">
                                    <i id="eye-p1" class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="Ulangi password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePass('password_confirmation','eye-p2')">
                                    <i id="eye-p2" class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Next Button --}}
                        <div class="pt-2">
                            <button type="button" onclick="goToStep2()" id="btn-next"
                                class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/20 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5">
                                Lanjutkan <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ============ STEP 2 ============ --}}
                    <div class="step-panel space-y-5" id="panel-2">

                        {{-- Universitas / Prodi --}}
                        <div>
                            <label for="university" class="block text-sm font-medium text-gray-700 mb-1">Universitas / Program Studi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-graduation-cap text-gray-400"></i>
                                </div>
                                <input id="university" name="university" type="text" value="{{ old('university') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="cth: IAIN Curup – Pendidikan Agama Islam">
                            </div>
                            @error('university') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nama Orang Tua --}}
                        <div>
                            <label for="parents_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua / Wali</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-people-roof text-gray-400"></i>
                                </div>
                                <input id="parents_name" name="parents_name" type="text" value="{{ old('parents_name') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="Nama Lengkap Orang Tua / Wali">
                            </div>
                            @error('parents_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- No HP Orang Tua --}}
                        <div>
                            <label for="parents_phone" class="block text-sm font-medium text-gray-700 mb-1">No. HP Orang Tua / Wali</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-phone text-gray-400"></i>
                                </div>
                                <input id="parents_phone" name="parents_phone" type="tel" value="{{ old('parents_phone') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            @error('parents_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- KTP Photo Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Foto KTP (Kartu Tanda Penduduk)
                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-700">
                                    <i class="fas fa-shield-alt mr-1"></i> Tersimpan Aman
                                </span>
                            </label>

                            {{-- Drop Zone --}}
                            <div id="ktp-drop-zone"
                                class="drop-zone mt-1 rounded-xl p-6 text-center cursor-pointer bg-gray-50 hover:bg-primary-50 transition-colors"
                                onclick="document.getElementById('ktp_photo').click()"
                                ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)"
                                ondrop="handleDrop(event)">

                                <div id="ktp-placeholder">
                                    <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-primary-100 flex items-center justify-center text-primary-500 text-2xl">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700">Klik atau drag & drop foto KTP di sini</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG – Maks. 4 MB</p>
                                </div>

                                <div id="ktp-preview-wrap" class="hidden">
                                    <img id="ktp-preview" src="#" alt="Preview KTP"
                                        class="max-h-40 mx-auto rounded-lg shadow border border-gray-200 object-contain">
                                    <p class="text-xs text-primary-600 mt-2 font-medium" id="ktp-filename"></p>
                                    <button type="button" onclick="clearKtp(event)" class="mt-2 text-xs text-red-500 hover:text-red-700 underline">Hapus</button>
                                </div>
                            </div>

                            <input id="ktp_photo" name="ktp_photo" type="file" class="hidden" accept="image/jpg,image/jpeg,image/png"
                                onchange="previewKtp(this)">
                            @error('ktp_photo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                                <i class="fas fa-lock text-green-500"></i>
                                Foto KTP tidak akan dipublikasikan dan hanya bisa diakses oleh admin.
                            </p>
                        </div>

                        {{-- Button Row --}}
                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="goToStep1()"
                                class="flex-none flex items-center gap-2 px-5 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="submit"
                                class="flex-1 flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/20 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-user-plus"></i> Daftar Sekarang
                            </button>
                        </div>
                    </div>

                </form>

                {{-- Login Link --}}
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">Masuk di sini</a>
                    </p>
                </div>

            </div>
        </div>

        {{-- ===== RIGHT PANEL (Image) ===== --}}
        <div class="hidden lg:block relative flex-1">
            <img class="absolute inset-0 h-full w-full object-cover"
                src="https://images.unsplash.com/photo-1596276020587-8044fe049813?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Suasana Kos">
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
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm"><i class="fas fa-graduation-cap text-white"></i></div>
                            <span class="text-sm font-medium">Dekat Kampus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    /* ─── Step navigation ─── */
    function goToStep2() {
        // Client-side quick validation for step 1 required fields
        const name  = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const pass  = document.getElementById('password').value;
        const conf  = document.getElementById('password_confirmation').value;

        if (!name)  { shakeField('name', 'Nama wajib diisi.'); return; }
        if (!email) { shakeField('email', 'Email wajib diisi.'); return; }
        if (!pass)  { shakeField('password', 'Password wajib diisi.'); return; }
        if (pass !== conf) { shakeField('password_confirmation', 'Konfirmasi password tidak cocok.'); return; }
        if (pass.length < 8) { shakeField('password', 'Password minimal 8 karakter.'); return; }

        showPanel(2);
    }

    function goToStep1() { showPanel(1); }

    function showPanel(step) {
        document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('panel-' + step).classList.add('active');
        updateIndicator(step);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateIndicator(currentStep) {
        const circle1 = document.getElementById('ind-1').querySelector('div');
        const num1    = document.getElementById('ind-1-num');
        const check1  = document.getElementById('ind-1-check');
        const circle2 = document.getElementById('ind-2-circle');
        const label2  = document.getElementById('ind-2-label');
        const line    = document.getElementById('progress-line');

        if (currentStep === 2) {
            // Step 1 done
            circle1.classList.replace('bg-primary-600', 'bg-green-500');
            circle1.classList.replace('shadow-primary-500/30', 'shadow-green-500/30');
            num1.classList.add('hidden');
            check1.classList.remove('hidden');
            // Step 2 active
            circle2.classList.replace('bg-gray-200', 'bg-primary-600');
            circle2.classList.replace('text-gray-500', 'text-white');
            circle2.classList.add('shadow-md', 'shadow-primary-500/30');
            label2.classList.replace('text-gray-400', 'text-primary-600');
            label2.classList.add('font-semibold');
            line.style.width = '100%';
        } else {
            circle1.classList.replace('bg-green-500', 'bg-primary-600');
            num1.classList.remove('hidden');
            check1.classList.add('hidden');
            circle2.classList.replace('bg-primary-600', 'bg-gray-200');
            circle2.classList.replace('text-white', 'text-gray-500');
            circle2.classList.remove('shadow-md', 'shadow-primary-500/30');
            label2.classList.replace('text-primary-600', 'text-gray-400');
            label2.classList.remove('font-semibold');
            line.style.width = '0%';
        }
    }

    /* ─── Field shake helper ─── */
    function shakeField(id, msg) {
        const el = document.getElementById(id);
        el.classList.add('border-red-400', 'ring-2', 'ring-red-300');
        el.focus();
        // Remove after 2s
        setTimeout(() => el.classList.remove('border-red-400', 'ring-2', 'ring-red-300'), 2000);
        // Remove old error msg if any
        const parentDiv = el.closest('div').parentElement;
        let errEl = parentDiv.querySelector('.client-error');
        if (!errEl) {
            errEl = document.createElement('p');
            errEl.className = 'mt-1 text-xs text-red-600 client-error';
            parentDiv.appendChild(errEl);
        }
        errEl.textContent = msg;
        setTimeout(() => errEl && errEl.remove(), 3000);
    }

    /* ─── Password toggle ─── */
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    /* ─── Avatar / Profile Photo ─── */
    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        // Client-side size guard (2 MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto profil maksimal 2 MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview     = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            const meta        = document.getElementById('avatar-meta');
            const filename    = document.getElementById('avatar-filename');

            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            meta.classList.remove('hidden');
            filename.textContent = file.name;
        };
        reader.readAsDataURL(file);
    }

    function clearAvatar() {
        document.getElementById('photo-input').value = '';
        document.getElementById('avatar-preview').src = '#';
        document.getElementById('avatar-preview').classList.add('hidden');
        document.getElementById('avatar-placeholder').classList.remove('hidden');
        document.getElementById('avatar-meta').classList.add('hidden');
        document.getElementById('avatar-filename').textContent = '';
    }

    /* ─── KTP preview ─── */
    function previewKtp(input) {
        if (!input.files || !input.files[0]) return;
        const file   = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('ktp-preview').src = e.target.result;
            document.getElementById('ktp-filename').textContent = file.name;
            document.getElementById('ktp-placeholder').classList.add('hidden');
            document.getElementById('ktp-preview-wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function clearKtp(e) {
        e.stopPropagation();
        document.getElementById('ktp_photo').value = '';
        document.getElementById('ktp-preview').src = '#';
        document.getElementById('ktp-placeholder').classList.remove('hidden');
        document.getElementById('ktp-preview-wrap').classList.add('hidden');
    }

    /* ─── Drag & Drop ─── */
    function handleDragOver(e) {
        e.preventDefault();
        e.currentTarget.classList.add('drag-over');
    }
    function handleDragLeave(e) {
        e.currentTarget.classList.remove('drag-over');
    }
    function handleDrop(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length) {
            const input = document.getElementById('ktp_photo');
            const dt    = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            previewKtp(input);
        }
    }

    /* ─── If server returned errors, restore step ─── */
    @if($errors->hasAny(['university','parents_name','parents_phone','ktp_photo']))
        document.addEventListener('DOMContentLoaded', () => showPanel(2));
    @endif
    {{-- If there is a photo error, stay on step 1 (default) so user can fix it --}}
    @if($errors->has('photo'))
        document.addEventListener('DOMContentLoaded', () => showPanel(1));
    @endif
</script>
</body>
</html>

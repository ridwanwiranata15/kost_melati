<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $room->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
        }

        #error-message {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body>

    <div class="flex flex-col md:flex-row justify-center gap-8 mt-12 mb-20 px-4 max-w-6xl mx-auto">

        <div class="w-full md:w-[380px] shrink-0">
            <div class="sticky top-24 flex flex-col w-full rounded-3xl border border-gray-200 p-4 bg-white shadow-lg">
                <div class="relative w-full h-[240px] rounded-2xl overflow-hidden mb-4">
                    <img src="{{ $room->image ? url('storage/' . $room->image) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=600&q=80' }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                        alt="{{ $room->name }}" loading="lazy">
                    <div
                        class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-800">
                        Room Preview
                    </div>
                </div>

                <div class="flex flex-col gap-2 px-2">
                    <h3 class="font-bold text-xl text-gray-900">{{ $room->name }}</h3>
                    <div class="flex flex-col gap-2 text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium text-sm">
                                Durasi Sewa:
                                <span class="text-blue-600 font-bold text-base">
                                    {{ $packageLabel ?? $duration . ' Bulan' }}
                                </span>
                            </p>
                        </div>

                        <div class="rounded-2xl bg-blue-50 border border-blue-100 p-4 mt-2">
                            <p class="text-xs text-gray-500">Harga per bulan</p>
                            <p class="text-base font-bold text-gray-800">
                                {{ \App\Support\BookingPrice::formatRupiah($monthlyPrice ?? \App\Support\BookingPrice::monthlyPrice()) }}
                            </p>

                            <div class="h-px bg-blue-100 my-3"></div>

                            <p class="text-xs text-gray-500">Total paket sewa</p>
                            <p class="text-2xl font-extrabold text-blue-700">
                                {{ \App\Support\BookingPrice::formatRupiah($totalAmount ?? 0) }}
                            </p>

                            @if (\App\Support\BookingPrice::hasSaving($duration ?? 0))
                                <p
                                    class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Hemat {{ \App\Support\BookingPrice::formatRupiah(\App\Support\BookingPrice::savingForDuration(12)) }} untuk paket 1 tahun
                                </p>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">
                        Durasi sewa digunakan untuk menghitung paket pembayaran. Tanggal masuk dan keluar dapat
                        disesuaikan dengan data sewa Anda.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full md:w-[500px]">
            <form action="{{ route('booking') }}" id="booking-form"
                class="bg-white border border-gray-100 shadow-xl rounded-3xl p-6 md:p-8 flex flex-col gap-6"
                method="POST">
                @csrf

                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="duration" id="duration-data" value="{{ $duration }}">

                <div class="flex flex-col gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">Atur Tanggal</h2>
                    <p class="text-gray-500 text-sm">
                        Tentukan tanggal masuk dan tanggal keluar sesuai data sewa kos Anda.
                    </p>
                </div>

                <div id="error-message" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium" id="error-text"></p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                        <p class="text-sm text-red-700 font-semibold mb-2">Data belum valid:</p>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex flex-col gap-2">
                    <label for="date_in" class="font-semibold text-gray-700 ml-1">Tanggal Masuk</label>
                    <div class="relative">
                        <input type="date" name="date_in" id="date_in" required value="{{ old('date_in') }}"
                            class="w-full rounded-full border border-gray-300 py-3.5 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="date_out" class="font-semibold text-gray-700 ml-1">Tanggal Keluar</label>
                    <div class="relative">
                        <input type="date" name="date_out" id="date_out" required value="{{ old('date_out') }}"
                            class="w-full rounded-full border border-gray-300 py-3.5 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-400 ml-2 italic">
                        *Tanggal keluar dapat dipilih bebas, tetapi harus setelah tanggal masuk.
                    </p>
                </div>

                <button type="submit" id="submit-btn" disabled
                    class="mt-4 w-full rounded-full py-4 px-6 bg-gray-300 text-gray-500 font-bold text-lg shadow-md transition-all duration-300 cursor-not-allowed hover:shadow-lg">
                    Pilih Tanggal Dulu
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInInput = document.getElementById('date_in');
            const dateOutInput = document.getElementById('date_out');
            const submitBtn = document.getElementById('submit-btn');
            const errorMessageDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            function parseLocalDate(value) {
                const [year, month, day] = value.split('-').map(Number);
                return new Date(year, month - 1, day);
            }

            function setButtonState(isEnabled, text = 'Booking Sekarang') {
                submitBtn.disabled = !isEnabled;

                if (isEnabled) {
                    submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600', 'cursor-pointer');
                    submitBtn.innerText = text;
                    return;
                }

                submitBtn.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600', 'cursor-pointer');
                submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.innerText = text;
            }

            function showError(message) {
                errorMessageDiv.classList.remove('hidden');
                errorText.innerHTML = message;
                setButtonState(false, 'Perbaiki Tanggal');
            }

            function hideError() {
                errorMessageDiv.classList.add('hidden');
                errorText.innerHTML = '';
            }

            function validateDates() {
                const dateInValue = dateInInput.value;
                const dateOutValue = dateOutInput.value;

                if (!dateInValue || !dateOutValue) {
                    hideError();
                    setButtonState(false, 'Pilih Tanggal Dulu');
                    return;
                }

                const dateIn = parseLocalDate(dateInValue);
                const dateOut = parseLocalDate(dateOutValue);

                if (dateOut <= dateIn) {
                    showError('Tanggal keluar harus setelah tanggal masuk.');
                    return;
                }

                hideError();
                setButtonState(true);
            }

            dateInInput.addEventListener('change', validateDates);
            dateOutInput.addEventListener('change', validateDates);
            dateInInput.addEventListener('input', validateDates);
            dateOutInput.addEventListener('input', validateDates);

            validateDates();
        });
    </script>
</body>

</html>

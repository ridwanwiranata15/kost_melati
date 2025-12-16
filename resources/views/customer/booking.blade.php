<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $room->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #FAFAFA; }
        /* Transisi halus untuk alert */
        #error-message { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body>

    <div class="flex flex-col md:flex-row justify-center gap-8 mt-12 mb-20 px-4 max-w-6xl mx-auto">

        <div class="w-full md:w-[380px] shrink-0">
            <div class="sticky top-24 flex flex-col w-full rounded-3xl border border-gray-200 p-4 bg-white shadow-lg">
                <div class="relative w-full h-[240px] rounded-2xl overflow-hidden mb-4">
                    <img src="{{ $room->image ? url('storage/' . $room->image) : 'https://via.placeholder.com/400x300' }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                         alt="{{ $room->name }}">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-800">
                        Room Preview
                    </div>
                </div>

                <div class="flex flex-col gap-2 px-2">
                    <h3 class="font-bold text-xl text-gray-900">{{ $room->name }}</h3>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium text-sm">Durasi Sewa: <span class="text-blue-600 font-bold text-base">{{ $duration }} Bulan</span></p>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Pastikan tanggal yang Anda pilih sesuai dengan durasi paket sewa.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-full md:w-[500px]">
            <form action="{{ route('booking') }}" id="booking-form" class="bg-white border border-gray-100 shadow-xl rounded-3xl p-6 md:p-8 flex flex-col gap-6" method="post">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="duration" id="duration-data" value="{{ $duration }}">

                <div class="flex flex-col gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">Atur Tanggal</h2>
                    <p class="text-gray-500 text-sm">Tentukan kapan Anda mulai ngekos.</p>
                </div>

                <div id="error-message" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium" id="error-text">
                                </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="date_in" class="font-semibold text-gray-700 ml-1">Tanggal Masuk</label>
                    <div class="relative">
                        <input type="date" name="date_in" id="date_in" required
                            class="w-full rounded-full border border-gray-300 py-3.5 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="date_out" class="font-semibold text-gray-700 ml-1">Tanggal Keluar</label>
                    <div class="relative">
                        <input type="date" name="date_out" id="date_out" required
                            class="w-full rounded-full border border-gray-300 py-3.5 px-5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-400 ml-2 italic">*Tanggal keluar harus tepat {{ $duration }} bulan dari tanggal masuk.</p>
                </div>

                <button type="submit" id="submit-btn" disabled
                    class="mt-4 w-full rounded-full py-4 px-6 bg-gray-300 text-gray-500 font-bold text-lg shadow-md transition-all duration-300 cursor-not-allowed hover:shadow-lg">
                    Pilih Tanggal Dulu
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInInput = document.getElementById('date_in');
            const dateOutInput = document.getElementById('date_out');
            const duration = parseInt(document.getElementById('duration-data').value); // Durasi dari PHP (integer)
            const submitBtn = document.getElementById('submit-btn');
            const errorMessageDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            function validateDates() {
                const dateInVal = dateInInput.value;
                const dateOutVal = dateOutInput.value;

                // Jika salah satu tanggal belum diisi, jangan lakukan apa-apa
                if (!dateInVal || !dateOutVal) return;

                const startDate = new Date(dateInVal);
                const endDate = new Date(dateOutVal);

                // Hitung selisih bulan secara kasar
                // Logika: (Tahun * 12 + Bulan) - (Tahun * 12 + Bulan)
                let monthsDiff = (endDate.getFullYear() - startDate.getFullYear()) * 12;
                monthsDiff -= startDate.getMonth();
                monthsDiff += endDate.getMonth();

                // Hitung selisih hari untuk presisi (opsional, tapi bagus untuk validasi user)
                // Jika tanggal hari (date) di endDate lebih kecil dari startDate, kurangi 1 bulan
                if (endDate.getDate() < startDate.getDate()) {
                    monthsDiff--;
                }

                // Cek Validasi
                if (monthsDiff !== duration) {
                    // KONDISI GAGAL
                    errorMessageDiv.classList.remove('hidden');

                    let message = "";
                    if (monthsDiff < duration) {
                        message = `Anda memesan paket <strong>${duration} Bulan</strong>, tetapi rentang tanggal yang Anda pilih hanya <strong>${monthsDiff <= 0 ? 'kurang dari 1' : monthsDiff} Bulan</strong>. Silakan perpanjang Tanggal Keluar.`;
                    } else {
                        message = `Anda memesan paket <strong>${duration} Bulan</strong>, tetapi rentang tanggal yang Anda pilih kelebihan menjadi <strong>${monthsDiff} Bulan</strong>. Silakan sesuaikan Tanggal Keluar.`;
                    }

                    errorText.innerHTML = message;

                    // Disable tombol & style abu-abu
                    submitBtn.disabled = true;
                    submitBtn.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600', 'cursor-pointer');
                    submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitBtn.innerText = "Perbaiki Tanggal";
                } else {
                    // KONDISI SUKSES (Valid)
                    errorMessageDiv.classList.add('hidden');

                    // Enable tombol & style hijau
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600', 'cursor-pointer');
                    submitBtn.innerText = "Booking Sekarang";
                }
            }

            // Fitur Tambahan UX: Auto-suggest Tanggal Keluar saat Tanggal Masuk dipilih
            dateInInput.addEventListener('change', function() {
                if(this.value) {
                    const d = new Date(this.value);
                    // Tambahkan durasi bulan secara otomatis
                    d.setMonth(d.getMonth() + duration);
                    // Format ke YYYY-MM-DD untuk input date
                    const yyyy = d.getFullYear();
                    const mm = String(d.getMonth() + 1).padStart(2, '0');
                    const dd = String(d.getDate()).padStart(2, '0');

                    // Set nilai ke input date_out otomatis (User masih bisa ubah kalau mau ngetes validasi)
                    dateOutInput.value = `${yyyy}-${mm}-${dd}`;

                    // Panggil validasi langsung
                    validateDates();
                }
            });

            // Jalankan validasi saat user mengubah tanggal keluar manual
            dateOutInput.addEventListener('change', validateDates);
        });
    </script>
</body>
</html>

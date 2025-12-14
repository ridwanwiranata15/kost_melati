<x-layouts.profile>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <form action="{{ route('booking.pay', $transaction->id) }}" method="post" enctype="multipart/form-data"
            class="w-full max-w-6xl bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf
            @method('put')

            {{-- Header Full Width --}}
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <span class="bg-white/20 p-2 rounded-lg"><i class="fa-solid fa-wallet"></i></span>
                            Konfirmasi Pembayaran
                        </h2>
                        <p class="text-emerald-100 text-sm mt-2 ml-12">Selesaikan pembayaran tagihan Anda.</p>
                    </div>
                    <div class="hidden md:block text-right text-emerald-100">
                        <p class="text-xs uppercase tracking-wider">Total Tagihan</p>
                        <p class="text-2xl font-bold text-white">Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 h-full">

                {{-- BAGIAN KIRI: Pilih Metode (Lebar 2/5) --}}
                <div class="lg:col-span-2 bg-gray-50 p-8 border-r border-gray-100 flex flex-col gap-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">1. Pilih Metode</h3>
                        <p class="text-sm text-gray-500 mb-4">Silakan pilih cara pembayaran Anda.</p>

                        <div class="space-y-4">
                            <label class="cursor-pointer relative block group">
                                <input type="radio" name="payment_method" value="transfer" class="peer sr-only" checked onchange="togglePaymentMethod('transfer')">
                                <div class="p-5 rounded-2xl border-2 border-gray-200 bg-white group-hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all flex items-center gap-4 shadow-sm">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <span class="font-bold text-gray-700 block peer-checked:text-emerald-700">Transfer Bank</span>
                                        <span class="text-xs text-gray-500">Upload bukti transfer</span>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center text-white text-xs opacity-50 peer-checked:opacity-100 transition-all">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative block group">
                                <input type="radio" name="payment_method" value="cash" class="peer sr-only" onchange="togglePaymentMethod('cash')">
                                <div class="p-5 rounded-2xl border-2 border-gray-200 bg-white group-hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all flex items-center gap-4 shadow-sm">
                                    <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xl shrink-0">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <span class="font-bold text-gray-700 block peer-checked:text-emerald-700">Tunai (Cash)</span>
                                        <span class="text-xs text-gray-500">Bayar di tempat</span>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center text-white text-xs opacity-50 peer-checked:opacity-100 transition-all">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-auto hidden lg:block">
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <p class="text-xs text-blue-700 leading-relaxed">
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Pastikan nominal pembayaran sesuai dengan total tagihan. Verifikasi admin maksimal 1x24 jam.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN KANAN: Form Input (Lebar 3/5) --}}
                <div class="lg:col-span-3 p-8 flex flex-col justify-center min-h-[400px]">
                    <h3 class="font-bold text-gray-800 text-lg mb-1">2. Konfirmasi</h3>
                    <p class="text-sm text-gray-500 mb-6">Lengkapi data di bawah ini.</p>

                    {{-- A. Tampilan Upload Bukti Transfer --}}
                    <div id="section-transfer" class="transition-all duration-500 ease-in-out">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Unggah Bukti Transfer</label>

                        <div class="w-full">
                            <label for="payment_receipt_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 transition-all group relative overflow-hidden">

                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                    <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-emerald-500"></i>
                                    </div>
                                    <p class="mb-2 text-sm text-gray-500 font-medium"><span class="text-emerald-600 font-bold">Klik untuk upload</span> atau drag & drop</p>
                                    <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                </div>
                                <input id="payment_receipt_image" name="image" type="file" class="hidden" accept="image/*" required onchange="previewFile()">

                                <img id="image-preview" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300 pointer-events-none">
                            </label>
                        </div>

                        <div id="file-info" class="hidden mt-3 flex items-center gap-2 text-sm text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-100">
                            <i class="fa-solid fa-file-image"></i>
                            <span id="file-name" class="font-semibold truncate"></span>
                        </div>

                        @error('image')
                            <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- B. Tampilan Input Cash --}}
                    <div id="section-cash" class="hidden transition-all duration-500 ease-in-out h-full">
                        <label for="cash_note" class="block text-sm font-semibold text-gray-700 mb-3">Catatan (Opsional)</label>
                        <div class="relative h-full">
                            <textarea name="note" id="cash_note" rows="6"
                                class="block w-full rounded-2xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-4 resize-none bg-gray-50 focus:bg-white transition-colors"
                                placeholder="Tuliskan detail penyerahan uang (misal: Dititipkan ke Pak Satpam/Penjaga Kost)"></textarea>
                            <div class="absolute bottom-4 right-4 text-emerald-500 opacity-50">
                                <i class="fa-solid fa-pen-nib text-xl"></i>
                            </div>
                        </div>

                        <div class="mt-4 bg-yellow-50 p-4 rounded-xl border border-yellow-100 flex gap-3 items-start">
                            <i class="fa-solid fa-triangle-exclamation text-yellow-600 mt-0.5"></i>
                            <div class="text-xs text-yellow-800">
                                <p class="font-bold">Penting:</p>
                                <p>Pastikan Anda menyerahkan uang tunai kepada pihak yang berwenang. Status pembayaran akan berubah setelah admin memverifikasi penerimaan uang.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg shadow-emerald-500/20 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 transition-all transform hover:-translate-y-1 active:translate-y-0">
                            <span>Kirim Konfirmasi</span>
                            <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    {{-- Javascript Logic --}}
    <script>
        function togglePaymentMethod(method) {
            const sectionTransfer = document.getElementById('section-transfer');
            const sectionCash = document.getElementById('section-cash');
            const inputFile = document.getElementById('payment_receipt_image');
            const inputNote = document.getElementById('cash_note');

            // Reset Animation Classes
            sectionTransfer.classList.remove('animate-fade-in-up');
            sectionCash.classList.remove('animate-fade-in-up');

            if (method === 'transfer') {
                sectionTransfer.classList.remove('hidden');
                sectionCash.classList.add('hidden');

                // Add required to file
                inputFile.setAttribute('required', 'required');

                // Animasi
                setTimeout(() => sectionTransfer.classList.add('animate-fade-in-up'), 10);

            } else {
                sectionCash.classList.remove('hidden');
                sectionTransfer.classList.add('hidden');

                // Remove required form file
                inputFile.removeAttribute('required');
                inputFile.value = ''; // Reset file input

                // Reset Preview
                document.getElementById('image-preview').style.opacity = '0';
                document.getElementById('file-info').classList.add('hidden');

                // Animasi
                setTimeout(() => sectionCash.classList.add('animate-fade-in-up'), 10);
            }
        }

        // Preview File Name & Image Background
        function previewFile() {
            const input = document.getElementById('payment_receipt_image');
            const fileNameDisplay = document.getElementById('file-name');
            const fileInfo = document.getElementById('file-info');
            const imgPreview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Show File Name
                fileNameDisplay.textContent = file.name;
                fileInfo.classList.remove('hidden');

                // Show Image Background
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.opacity = '0.4'; // Transparansi agar icon tetap kelihatan samar
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</x-layouts.profile>

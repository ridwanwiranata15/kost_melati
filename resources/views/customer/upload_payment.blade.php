<x-layouts.profile>
    <div class="main-wrapper bg-gray-50 min-h-screen pb-20">
        <main class="content-area max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <a href="{{ url()->previous() }}"
                            class="p-2 rounded-full bg-white text-gray-500 hover:text-emerald-600 shadow-sm border border-gray-100 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Konfirmasi Pembayaran</h1>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 ml-12">Selesaikan pembayaran tagihan Anda dengan metode yang
                        tersedia.</p>
                </div>
            </div>

            {{-- SUMMARY CARD: TOTAL TAGIHAN --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group mb-8 transition-all hover:shadow-md">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i
                        class="fa-solid fa-file-invoice-dollar text-8xl text-emerald-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                </div>
                <div class="relative z-10 flex items-center gap-5">
                    <div
                        class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 shrink-0">
                        <i class="fa-solid fa-wallet text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Tagihan
                            Pembayaran</p>
                        <h3 class="text-3xl font-black text-gray-900">
                            Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            {{-- FORM SECTION --}}
            <form action="{{ route('booking.pay', $transaction->id) }}" method="post" enctype="multipart/form-data"
                class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                @csrf
                @method('put')

                <div class="grid grid-cols-1 lg:grid-cols-5 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">

                    {{-- BAGIAN KIRI: Pilih Metode --}}
                    <div class="lg:col-span-2 p-6 sm:p-8 bg-gray-50/50 flex flex-col gap-6">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-1">1. Pilih Metode</h3>
                            <p class="text-sm text-gray-500 mb-6">Silakan tentukan cara pembayaran Anda.</p>

                            <div class="space-y-4">
                                <label class="cursor-pointer relative block group">
                                    <input type="radio" name="payment_method" value="transfer" class="peer sr-only"
                                        checked onchange="togglePaymentMethod('transfer')">
                                    <div
                                        class="p-5 rounded-2xl border border-gray-200 bg-white hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all flex items-center gap-4 shadow-sm">
                                        <div
                                            class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                            <i class="fa-solid fa-building-columns"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <span
                                                class="font-bold text-gray-900 block peer-checked:text-emerald-700">Transfer
                                                Bank</span>
                                            <span class="text-xs text-gray-500">Upload bukti transfer</span>
                                        </div>
                                        <div
                                            class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center text-white text-xs opacity-0 peer-checked:opacity-100 transition-all shadow-sm">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative block group">
                                    <input type="radio" name="payment_method" value="cash" class="peer sr-only"
                                        onchange="togglePaymentMethod('cash')">
                                    <div
                                        class="p-5 rounded-2xl border border-gray-200 bg-white hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all flex items-center gap-4 shadow-sm">
                                        <div
                                            class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <span
                                                class="font-bold text-gray-900 block peer-checked:text-emerald-700">Tunai
                                                (Cash)</span>
                                            <span class="text-xs text-gray-500">Bayar di tempat</span>
                                        </div>
                                        <div
                                            class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center text-white text-xs opacity-0 peer-checked:opacity-100 transition-all shadow-sm">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-auto hidden lg:block">
                            <div class="bg-blue-50/70 p-4 rounded-2xl border border-blue-100">
                                <div class="flex items-start gap-3">
                                    <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>
                                    <p class="text-xs text-blue-800 leading-relaxed">
                                        Pastikan nominal pembayaran sesuai dengan total tagihan. Verifikasi admin akan
                                        diproses maksimal 1x24 jam.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN KANAN: Form Input --}}
                    <div class="lg:col-span-3 p-6 sm:p-8 flex flex-col min-h-[420px]">
                        <h3 class="font-bold text-gray-900 text-lg mb-1">2. Detail Konfirmasi</h3>
                        <p class="text-sm text-gray-500 mb-6">Lengkapi instruksi sesuai dengan metode yang dipilih.</p>

                        {{-- A. Tampilan Upload Bukti Transfer --}}
                        <div id="section-transfer"
                            class="transition-all duration-500 ease-in-out flex-grow flex flex-col">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Unggah Bukti Transfer</label>

                            <div class="w-full flex-grow flex flex-col justify-center">
                                <label for="payment_receipt_image"
                                    class="flex flex-col items-center justify-center w-full h-full min-h-[200px] border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 transition-all group relative overflow-hidden">

                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                        <div
                                            class="w-16 h-16 bg-white rounded-full shadow-sm border border-gray-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <i
                                                class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
                                        </div>
                                        <p class="mb-2 text-sm text-gray-500 font-medium"><span
                                                class="text-emerald-600 font-bold">Klik untuk upload</span> atau drag &
                                            drop</p>
                                        <p class="text-xs text-gray-400">Format: PNG, JPG, JPEG (Maks. 2MB)</p>
                                    </div>
                                    <input id="payment_receipt_image" name="image" type="file" class="hidden"
                                        accept="image/*" required onchange="previewFile()">

                                    <img id="image-preview"
                                        class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-300 pointer-events-none">
                                </label>
                            </div>

                            <div id="file-info"
                                class="hidden mt-4 items-center gap-3 text-sm text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                                <div
                                    class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-image"></i>
                                </div>
                                <span id="file-name" class="font-semibold truncate"></span>
                            </div>

                            @error('image')
                                <p class="text-xs text-rose-500 mt-2 font-medium flex items-center gap-1"><i
                                        class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- B. Tampilan Input Cash --}}
                        <div id="section-cash"
                            class="hidden transition-all duration-500 ease-in-out flex-grow flex flex-col justify-start">
                            <label for="cash_note" class="block text-sm font-semibold text-gray-700 mb-3">Catatan
                                Pembayaran (Opsional)</label>
                            <div class="relative">
                                <textarea name="note" id="cash_note" rows="5"
                                    class="block w-full rounded-2xl border border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-4 resize-none bg-gray-50 focus:bg-white transition-colors"
                                    placeholder="Tuliskan detail penyerahan uang (misal: Dititipkan ke Pak Satpam/Penjaga Kost)"></textarea>
                                <div class="absolute bottom-4 right-4 text-emerald-500 opacity-30">
                                    <i class="fa-solid fa-pen-nib text-xl"></i>
                                </div>
                            </div>

                            <div
                                class="mt-6 bg-yellow-50 p-4 rounded-2xl border border-yellow-100 flex gap-3 items-start">
                                <div
                                    class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center shrink-0 text-yellow-600">
                                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                                </div>
                                <div class="text-sm text-yellow-800 pt-1.5">
                                    <p class="font-bold mb-1">Penting:</p>
                                    <p class="text-xs leading-relaxed">Pastikan Anda menyerahkan uang tunai secara
                                        langsung kepada pihak yang berwenang. Status pembayaran akan berubah menjadi
                                        Lunas setelah admin memverifikasi uang Anda.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-4 px-6 rounded-xl shadow-md hover:shadow-lg text-sm font-bold text-white bg-gray-900 hover:bg-black focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all group">
                                <span>Kirim Konfirmasi Pembayaran</span>
                                <i
                                    class="fa-solid fa-paper-plane ml-2 transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </main>
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
                sectionTransfer.classList.add('flex');

                sectionCash.classList.add('hidden');
                sectionCash.classList.remove('flex');

                // Add required to file
                inputFile.setAttribute('required', 'required');

                // Animasi
                setTimeout(() => sectionTransfer.classList.add('animate-fade-in-up'), 10);

            } else {
                sectionCash.classList.remove('hidden');
                sectionCash.classList.add('flex');

                sectionTransfer.classList.add('hidden');
                sectionTransfer.classList.remove('flex');

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
                fileInfo.classList.add('flex'); // Add flex back

                // Show Image Background
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.opacity = '0.3'; // Transparansi agar icon tetap kelihatan samar
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</x-layouts.profile>

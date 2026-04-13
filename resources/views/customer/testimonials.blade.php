<x-layouts.profile>
    <div class="main-wrapper bg-gray-50 min-h-screen pb-20 relative">

        {{-- Ambient Background (Antigravity Style) --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-500/10 blur-[120px] mix-blend-multiply">
            </div>
            <div
                class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-yellow-500/10 blur-[120px] mix-blend-multiply">
            </div>
        </div>

        <main class="content-area max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">

            {{-- HEADER & TOMBOL LEWATI (UX Opsional) --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Ulasan & Masukan</h1>
                    <p class="text-gray-500 text-sm mt-1">Bagikan pengalaman Anda (Opsional).</p>
                </div>

                {{-- Tombol Lewati --}}
                <a href="{{ route('customer.order') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white text-gray-600 rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-gray-900 font-bold text-sm shadow-sm transition-all group">
                    <span>Lewati Langkah Ini</span>
                    <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- KOTAK FORM TESTIMONI --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">

                {{-- Dekorasi Ikon --}}
                <div class="absolute -top-10 -right-10 opacity-5 pointer-events-none">
                    <i class="fa-solid fa-comments text-9xl text-emerald-600"></i>
                </div>

                <div class="p-8 md:p-10 relative z-10">
                    <div class="text-center mb-8">
                        <div
                            class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-emerald-100">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Bagaimana pengalaman ngekos Anda?</h2>
                        <p class="text-gray-500 text-sm mt-2">Masukan Anda sangat berarti bagi perkembangan layanan
                            kami.</p>
                    </div>

                    <form action="{{ route('customer.testimonial.store') }}" method="POST">
                        @csrf

                        {{-- 1. Input Rating (CSS Trick untuk Bintang) --}}
                        <div class="mb-8 flex flex-col items-center">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih
                                Rating</label>

                            <div class="star-rating-group">
                                <input type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="5 Bintang - Sempurna"><i
                                        class="fa-solid fa-star"></i></label>

                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 Bintang - Sangat Bagus"><i
                                        class="fa-solid fa-star"></i></label>

                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 Bintang - Bagus"><i class="fa-solid fa-star"></i></label>

                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 Bintang - Cukup"><i class="fa-solid fa-star"></i></label>

                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 Bintang - Kurang"><i
                                        class="fa-solid fa-star"></i></label>
                            </div>

                            @error('rating')
                                <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><i
                                        class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2. Input Teks Ulasan --}}
                        <div class="mb-8">
                            <label for="testimonial"
                                class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Tulis Ulasan
                                Anda</label>
                            <div class="relative">
                                <textarea id="testimonial" name="testimonial" rows="5" placeholder="Ceritakan pengalaman Anda di sini..."
                                    class="block w-full rounded-2xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-5 resize-y bg-gray-50 focus:bg-white transition-colors shadow-sm {{ $errors->has('testimonial') ? 'border-red-300 bg-red-50' : '' }}"
                                    required></textarea>
                            </div>
                            @error('testimonial')
                                <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1"><i
                                        class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 3. Tombol Submit --}}
                        <button type="submit"
                            class="w-full flex justify-center items-center gap-2 py-4 px-6 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none transition-all transform hover:-translate-y-1 shadow-lg shadow-emerald-500/30 group">
                            <span>Kirim Ulasan Saya</span>
                            <i
                                class="fa-solid fa-paper-plane transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- Kumpulan Style Khusus (Bintang Rating) --}}
    <style>
        /* CSS Trick untuk membuat Bintang bisa dihover dari Kiri ke Kanan */
        .star-rating-group {
            display: inline-flex;
            flex-direction: row-reverse;
            /* Dibalik agar ~ selector bekerja */
            justify-content: flex-end;
            gap: 8px;
        }

        .star-rating-group input[type="radio"] {
            display: none;
            /* Sembunyikan radio button asli */
        }

        .star-rating-group label {
            font-size: 36px;
            color: #e5e7eb;
            /* abu-abu bawaan tailwind */
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        /* Saat dihover, ubah warna bintang ini dan SEMUA bintang setelahnya (yang secara visual ada di kirinya) */
        .star-rating-group label:hover,
        .star-rating-group label:hover~label {
            color: #facc15;
            /* kuning terang */
            transform: scale(1.1);
        }

        /* Saat diklik (checked), ubah warna jadi emas */
        .star-rating-group input[type="radio"]:checked~label {
            color: #eab308;
            /* emas/kuning gelap */
        }
    </style>
</x-layouts.profile>

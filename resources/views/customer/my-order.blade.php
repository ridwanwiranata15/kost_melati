<x-layouts.profile>
    <div class="main-wrapper bg-gray-50 min-h-screen pb-20">
        <main class="content-area max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- LOGIKA UTAMA: CEK APAKAH ADA BOOKING --}}
            @if ($booking)
                @php
                    // 1. KALKULASI CERDAS TOTAL TAGIHAN (Mencegah Rp 0)
                    $hargaKamar = $booking->price ?? ($booking->room->price ?? 500000); // Default ke 500rb jika kosong
                    $totalTagihan =
                        $booking->total_amount > 0 ? $booking->total_amount : $hargaKamar * $booking->duration;

                    // 2. KALKULASI PEMBAYARAN
                    $bookingStatus = $booking->status?->value;
                    $sudahBayar =
                        $transactions->filter(fn($trx) => $trx->status?->value === 'confirmed')->sum('nominal') ?? 0;
                    // Pastikan sisa bayar tidak minus
                    $sisaBayar = max(0, $totalTagihan - $sudahBayar);
                    $persenBayar = $totalTagihan > 0 ? ($sudahBayar / $totalTagihan) * 100 : 0;

                    // 3. CEK STATUS PENDING
                    $isPendingAdmin = $bookingStatus === 'pending';
                @endphp

                {{-- ================================================= --}}
                {{-- KONTEN JIKA SUDAH ADA BOOKING                     --}}
                {{-- ================================================= --}}

                {{-- HEADER SECTION --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <a href="{{ url()->previous() }}"
                                class="p-2 rounded-full bg-white text-gray-500 hover:text-emerald-600 shadow-sm border border-gray-100 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Sewa</h1>
                        </div>
                        <p class="text-gray-500 text-sm mt-1 ml-12">Informasi kamar dan status tagihan bulanan Anda.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($isPendingAdmin)
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-bold px-4 py-1.5 rounded-full border border-yellow-200 shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-clock animate-spin-slow"></i>
                                Menunggu Persetujuan Admin
                            </span>
                        @else
                            <span
                                class="bg-emerald-100 text-emerald-800 text-xs font-bold px-4 py-1.5 rounded-full border border-emerald-200 shadow-sm flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Active Tenant
                            </span>
                        @endif
                    </div>
                </div>

                {{-- KAMAR CARD --}}
                <section
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 p-6 opacity-10 pointer-events-none">
                        <i class="fa-solid fa-house text-9xl text-emerald-900 transform rotate-12"></i>
                    </div>

                    <div class="flex flex-col md:flex-row gap-8 relative z-10">
                        {{-- Image --}}
                        <div class="w-full md:w-1/3 shrink-0">
                            <div class="relative h-56 md:h-64 w-full overflow-hidden rounded-2xl shadow-md">
                                <img src="{{ $booking->room->image ? url('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=600&q=80' }}"
                                    loading="lazy" alt="Foto Kamar"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <p class="text-xs font-light uppercase tracking-wider mb-1">Tipe Kamar</p>
                                    <p class="font-bold text-lg">{{ $booking->room->name ?? 'Standard Room' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="flex-grow flex flex-col justify-center">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Informasi Sewa</h2>
                                <p class="text-gray-500 text-sm">Berikut adalah detail paket sewa yang Anda ambil.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                {{-- Item 1 --}}
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                        <i class="fa-regular fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Durasi Sewa</p>
                                        <p class="text-gray-900 font-bold">{{ $booking->duration }} Bulan</p>
                                    </div>
                                </div>

                                {{-- Item 2 --}}
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Total Harga</p>
                                        {{-- Menggunakan $totalTagihan hasil kalkulasi cerdas di atas --}}
                                        <p class="text-emerald-600 font-bold">Rp
                                            {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- Item 3 --}}
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 shrink-0">
                                        <i class="fa-solid fa-door-open"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Nomor Kamar</p>
                                        <p class="text-gray-900 font-bold">{{ $booking->room->room_number ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Item 4 --}}
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Mulai Kost</p>
                                        <p class="text-gray-900 font-bold">
                                            {{ \Carbon\Carbon::parse($booking->date_in)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- SUMMARY CARDS SECTION --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- CARD 1: TOTAL TAGIHAN --}}
                    <div
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <i
                                class="fa-solid fa-file-invoice-dollar text-8xl text-blue-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                        </div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                                    <i class="fa-solid fa-receipt text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Tagihan
                                    </p>
                                    <p class="text-[10px] text-blue-500 font-medium">
                                        {{ $isPendingAdmin ? 'Estimasi Keseluruhan' : 'Keseluruhan Sewa' }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-gray-800">
                                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: SUDAH BAYAR --}}
                    <div
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <i
                                class="fa-solid fa-wallet text-8xl text-emerald-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                        </div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                                    <i class="fa-solid fa-circle-check text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Sudah Dibayar
                                    </p>
                                    <p class="text-[10px] text-emerald-500 font-medium">Terverifikasi</p>
                                </div>
                            </div>
                            <div>
                                @if ($sudahBayar > 0)
                                    <h3 class="text-2xl font-black text-emerald-600">
                                        Rp {{ number_format($sudahBayar, 0, ',', '.') }}
                                    </h3>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                                        <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-1000"
                                            style="width: {{ $persenBayar }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1 text-right">{{ round($persenBayar) }}%
                                        Lunas</p>
                                @else
                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 mt-1">
                                        <div class="flex items-start gap-2">
                                            <i class="fa-solid fa-circle-info text-gray-400 mt-0.5 text-xs"></i>
                                            <p class="text-xs text-gray-500 leading-snug">Belum melakukan pembayaran
                                                apapun.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- CARD 3: SISA TAGIHAN --}}
                    <div
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <i
                                class="fa-solid fa-hand-holding-dollar text-8xl text-rose-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                        </div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm border border-rose-100">
                                    <i class="fa-solid fa-hourglass-half text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Sisa Kewajiban
                                    </p>
                                    <p class="text-[10px] text-rose-500 font-medium">Perlu Dibayar</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-rose-600">
                                    Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                                </h3>

                                {{-- Logika Badge Cerdas --}}
                                @if ($isPendingAdmin && $sudahBayar == 0)
                                    <div
                                        class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-yellow-50 border border-yellow-100">
                                        <i class="fa-solid fa-clock text-[10px] text-yellow-500"></i>
                                        <span class="text-[10px] font-bold text-yellow-600">Menunggu Tagihan
                                            Rilis</span>
                                    </div>
                                @elseif ($sisaBayar > 0)
                                    <div
                                        class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 border border-rose-100">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px] text-rose-500"></i>
                                        <span class="text-[10px] font-bold text-rose-600">Belum Lunas</span>
                                    </div>
                                @else
                                    <div
                                        class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-100">
                                        <i class="fa-solid fa-thumbs-up text-[10px] text-emerald-500"></i>
                                        <span class="text-[10px] font-bold text-emerald-600">Lunas Semua</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                {{-- RIWAYAT PEMBAYARAN --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div
                        class="px-6 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50/50 gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Tagihan & Riwayat Pembayaran</h3>
                            <p class="text-xs text-gray-500 mt-1">Pantau jatuh tempo dan status pembayaran bulanan
                                Anda.
                            </p>
                        </div>
                        <div
                            class="flex items-center gap-2 text-xs font-medium bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                            <i class="fa-solid fa-calendar text-gray-400"></i>
                            Tahun {{ \Carbon\Carbon::parse($booking->date_in)->format('Y') }}
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold">Bulan Tagihan</th>
                                    <th class="px-6 py-4 font-bold">Jatuh Tempo</th>
                                    <th class="px-6 py-4 font-bold text-center">Status</th>
                                    <th class="px-6 py-4 font-bold">Tgl Bayar</th>
                                    <th class="px-6 py-4 font-bold">Nominal</th>
                                    <th class="px-6 py-4 font-bold text-center">Aksi / Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                {{-- Loop menggunakan tagihanList yang dibuat di Controller --}}
                                @forelse($tagihanList as $item)
                                    @php
                                        $trx = $item['transaction'];
                                        $trxStatus = $trx?->status?->value;
                                        $isLunas = $trxStatus === 'confirmed';
                                    @endphp

                                    <tr
                                        class="hover:bg-gray-50 transition duration-150 {{ $isLunas ? 'bg-emerald-50/30' : '' }}">

                                        {{-- 1. Bulan Tagihan (Dari date_in) --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold {{ $isLunas ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                                    {{ $loop->iteration }}
                                                </div>
                                                {{-- Ini hasil generate dari Controller --}}
                                                <span
                                                    class="font-bold text-gray-800 capitalize">{{ $item['bulan'] }}</span>
                                            </div>
                                        </td>

                                        {{-- 2. Jatuh Tempo --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i class="fa-regular fa-calendar-times text-gray-400"></i>
                                                {{ $item['jatuh_tempo'] }}
                                            </div>
                                        </td>

                                        {{-- 3. Status --}}
                                        <td class="px-6 py-4 text-center">
                                            @if ($trxStatus === 'pending')
                                                @if ($trx->payment_receipt)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                                        <i class="fa-solid fa-spinner animate-spin mr-1.5"></i>
                                                        Diproses Admin
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                        <i class="fa-solid fa-clock mr-1.5"></i> Belum Bayar
                                                    </span>
                                                @endif
                                            @elseif($trxStatus === 'confirmed')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                    <i class="fa-solid fa-check-circle mr-1.5"></i> Lunas
                                                </span>
                                            @elseif($trxStatus === 'rejected')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                                    <i class="fa-solid fa-circle-xmark mr-1.5"></i> Ditolak
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                    Tagihan Baru
                                                </span>
                                            @endif
                                        </td>

                                        {{-- 4. Tgl Bayar --}}
                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ $trx && $trx->date_pay ? \Carbon\Carbon::parse($trx->date_pay)->translatedFormat('d M Y') : '-' }}
                                        </td>

                                        {{-- 5. Nominal --}}
                                        <td class="px-6 py-4 font-medium">
                                            Rp {{ number_format((float) ($item['nominal'] ?? 0), 0, ',', '.') }}
                                        </td>

                                        {{-- 6. Aksi / Invoice --}}
                                        <td class="px-6 py-4 text-center">
                                            @if ($trx)
                                                @if ($trxStatus === 'pending')
                                                    @if ($trx->payment_receipt)
                                                        <button disabled
                                                            class="bg-gray-100 text-gray-400 border border-gray-200 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed flex items-center gap-2 mx-auto transition-all">
                                                            <i class="fa-solid fa-hourglass-half"></i> Menunggu
                                                        </button>
                                                    @else
                                                        <a href="{{ route('booking.upload', $trx->id) }}"
                                                            class="inline-block">
                                                            <button
                                                                class="group bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-2 mx-auto">
                                                                <span>Bayar</span>
                                                                <i
                                                                    class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                @elseif($trxStatus === 'rejected')
                                                    <a href="{{ route('booking.upload', $trx->id) }}"
                                                        class="inline-block">
                                                        <button
                                                            class="group bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-2 mx-auto">
                                                            <span>Upload Ulang</span>
                                                            <i
                                                                class="fa-solid fa-rotate-right transform group-hover:rotate-180 transition-transform"></i>
                                                        </button>
                                                    </a>
                                                @elseif($trxStatus === 'confirmed')
                                                    <a href="{{ route('invoice.show', $trx->id) }}"
                                                        class="inline-block">
                                                        <button
                                                            class="text-emerald-600 hover:text-emerald-800 border border-emerald-200 hover:border-emerald-300 bg-emerald-50 hover:bg-emerald-100 px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-2 mx-auto">
                                                            <i class="fa-solid fa-file-invoice"></i> Invoice
                                                        </button>
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-400 italic">Belum tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-16">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                @if ($isPendingAdmin)
                                                    <div
                                                        class="w-16 h-16 bg-yellow-50 border border-yellow-100 rounded-full flex items-center justify-center mb-4 shadow-sm">
                                                        <i
                                                            class="fa-solid fa-hourglass-half text-2xl text-yellow-500 animate-pulse"></i>
                                                    </div>
                                                    <h4 class="font-bold text-gray-800 text-lg">Menunggu Verifikasi
                                                        Admin</h4>
                                                    <p class="text-sm text-gray-500 mt-2 max-w-md leading-relaxed">
                                                        Sewa kamar Anda sedang ditinjau. Jadwal tagihan dan tombol
                                                        pembayaran akan muncul otomatis setelah Admin menyetujui pesanan
                                                        Anda.
                                                    </p>
                                                @else
                                                    <div
                                                        class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mb-4 shadow-sm">
                                                        <i class="fa-solid fa-folder-open text-2xl text-gray-300"></i>
                                                    </div>
                                                    <p class="font-bold text-gray-600">Belum ada jadwal tagihan.</p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- ================================================= --}}
                {{-- KONTEN JIKA BELUM ADA BOOKING (EMPTY STATE)     --}}
                {{-- ================================================= --}}

                {{-- Simple Header --}}
                <div class="mb-8">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>

                {{-- Card Empty State --}}
                <div class="flex flex-col items-center justify-center min-h-[60vh] py-12">
                    <div
                        class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 max-w-lg w-full text-center relative overflow-hidden">

                        {{-- Background Decoration --}}
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-emerald-400">
                        </div>
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-gray-50 rounded-full z-0"></div>

                        <div class="relative z-10">
                            <div
                                class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-house-chimney-crack text-4xl text-blue-400"></i>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Sewa</h2>
                            <p class="text-gray-500 mb-8 leading-relaxed">
                                Anda belum memiliki kamar yang disewa saat ini. Silakan cari kamar yang cocok untuk Anda
                                dan lakukan pemesanan.
                            </p>

                            {{-- Asumsi Anda punya route bernama 'rooms.index' atau sejenisnya --}}
                            {{-- Ganti '#' dengan route yang sesuai --}}
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center gap-3 bg-gray-900 hover:bg-black text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 w-full sm:w-auto">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>Cari Kamar Kos</span>
                            </a>
                        </div>
                    </div>
                </div>

            @endif

        </main>
    </div>
</x-layouts.profile>

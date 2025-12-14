<x-layouts.profile>
    <div class="main-wrapper bg-gray-50 min-h-screen pb-20">
        <main class="content-area max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <a href="{{ url()->previous() }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-emerald-600 shadow-sm border border-gray-100 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Sewa</h1>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 ml-12">Informasi kamar dan status tagihan bulanan Anda.</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-4 py-1.5 rounded-full border border-emerald-200 shadow-sm flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Active Tenant
                    </span>
                </div>
            </div>

            {{-- KAMAR CARD --}}
            <section class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 overflow-hidden relative group">
                <div class="absolute top-0 right-0 p-6 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-house text-9xl text-emerald-900 transform rotate-12"></i>
                </div>

                <div class="flex flex-col md:flex-row gap-8 relative z-10">
                    {{-- Image --}}
                    <div class="w-full md:w-1/3 shrink-0">
                        <div class="relative h-56 md:h-64 w-full overflow-hidden rounded-2xl shadow-md">
                            <img src="{{ url('storage/' . $booking->room->image) }}"
                                alt="Foto Kamar"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-xs font-light uppercase tracking-wider mb-1">Tipe Kamar</p>
                                <p class="font-bold text-lg">{{ $booking->room->name }}</p>
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
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Durasi Sewa</p>
                                    <p class="text-gray-900 font-bold">{{ $booking->duration }} Bulan</p>
                                </div>
                            </div>

                            {{-- Item 2 --}}
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Total Harga</p>
                                    <p class="text-emerald-600 font-bold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            {{-- Item 3 --}}
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 shrink-0">
                                    <i class="fa-solid fa-door-open"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Nomor Kamar</p>
                                    <p class="text-gray-900 font-bold">{{ $booking->room->room_number }}</p>
                                </div>
                            </div>

                            {{-- Item 4 --}}
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Mulai Kost</p>
                                    <p class="text-gray-900 font-bold">{{ \Carbon\Carbon::parse($booking->date_in)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SUMMARY CARDS SECTION --}}
            @php
                // Logika kalkulasi sederhana
                $totalTagihan = $booking->total_amount;
                // Asumsi: kolom harga di tabel transaksi bernama 'amount'.
                // Jika berbeda, ganti 'amount' dengan nama kolom yang sesuai (misal: 'price' atau 'total').
                $sudahBayar = $transactions->where('status', 'confirmed')->sum('nominal');
                $sisaBayar = $totalTagihan - $sudahBayar;

                // Menghitung persentase untuk progress bar visual
                $persenBayar = $totalTagihan > 0 ? ($sudahBayar / $totalTagihan) * 100 : 0;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- CARD 1: TOTAL TAGIHAN --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fa-solid fa-file-invoice-dollar text-8xl text-blue-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                                <i class="fa-solid fa-receipt text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Tagihan</p>
                                <p class="text-xs text-blue-500 font-medium">Keseluruhan Sewa</p>
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
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fa-solid fa-wallet text-8xl text-emerald-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Sudah Dibayar</p>
                                <p class="text-xs text-emerald-500 font-medium">Terverifikasi</p>
                            </div>
                        </div>

                        {{-- LOGIKA TAMPILAN JIKA BELUM BAYAR --}}
                        <div>
                            @if($sudahBayar > 0)
                                <h3 class="text-2xl font-black text-emerald-600">
                                    Rp {{ number_format($sudahBayar, 0, ',', '.') }}
                                </h3>
                                {{-- Progress Bar --}}
                                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $persenBayar }}%"></div>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 text-right">{{ round($persenBayar) }}% Lunas</p>
                            @else
                                {{-- Tampilan Jika 0 / Null --}}
                                <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 mt-1">
                                    <div class="flex items-start gap-2">
                                        <i class="fa-solid fa-circle-info text-gray-400 mt-0.5 text-xs"></i>
                                        <p class="text-xs text-gray-500 leading-snug">
                                            Belum melakukan pembayaran apapun.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 3: SISA TAGIHAN --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fa-solid fa-hand-holding-dollar text-8xl text-rose-600 transform -rotate-12 translate-x-2 -translate-y-2"></i>
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm border border-rose-100">
                                <i class="fa-solid fa-hourglass-half text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Sisa Kewajiban</p>
                                <p class="text-xs text-rose-500 font-medium">Perlu Dibayar</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-rose-600">
                                Rp {{ number_format($sisaBayar, 0, ',', '.') }}
                            </h3>
                            @if($sisaBayar > 0)
                                <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 border border-rose-100">
                                    <i class="fa-solid fa-triangle-exclamation text-[10px] text-rose-500"></i>
                                    <span class="text-[10px] font-bold text-rose-600">Belum Lunas</span>
                                </div>
                            @else
                                <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-100">
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
                <div class="px-6 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50/50 gap-4">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">Tagihan & Riwayat Pembayaran</h3>
                        <p class="text-xs text-gray-500 mt-1">Pantau jatuh tempo dan status pembayaran bulanan Anda.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                        <i class="fa-solid fa-calendar text-gray-400"></i>
                        Tahun 2025
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-bold">Bulan Tagihan</th>
                                <th class="px-6 py-4 font-bold">Jatuh Tempo</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold">Tgl Bayar</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi / Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $item)
                                @php
                                    $tanggalMulai = \Carbon\Carbon::parse($booking->start_date ?? $booking->created_at);
                                    $bulanTagihan = $tanggalMulai->copy()->addMonths($loop->index);
                                    $isLunas = $item->status == 'confirmed';
                                @endphp

                                <tr class="hover:bg-gray-50 transition duration-150 {{ $isLunas ? 'bg-emerald-50/30' : '' }}">
                                    {{-- Bulan --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold {{ $isLunas ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $loop->iteration }}
                                            </div>
                                            <span class="font-bold text-gray-800 capitalize">{{ $bulanTagihan->translatedFormat('F Y') }}</span>
                                        </div>
                                    </td>

                                    {{-- Jatuh Tempo --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fa-regular fa-calendar-times text-gray-400"></i>
                                            {{ $bulanTagihan->copy()->day(10)->translatedFormat('d F Y') }}
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($item->status == 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                <i class="fa-solid fa-clock mr-1.5"></i> Menunggu
                                            </span>
                                        @elseif($item->status == 'confirmed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-check-circle mr-1.5"></i> Lunas
                                            </span>
                                        @elseif($item->status == 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i class="fa-solid fa-circle-xmark mr-1.5"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                Belum Bayar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Tgl Bayar --}}
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->date_pay ? \Carbon\Carbon::parse($item->date_pay)->translatedFormat('d M Y') : '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($item->status == 'pending' || $item->status == 'rejected' || !$item->status)
                                            {{-- Tombol Bayar --}}
                                            <a href="{{ route('booking.upload', $item->id) }}" class="inline-block">
                                                <button class="group bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                                                    <span>Bayar</span>
                                                    <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                                </button>
                                            </a>
                                        @else
                                            {{-- Tombol Invoice --}}
                                            <a href="{{ route('invoice.show', $item->id) }}">
                                            <button class="text-emerald-600 hover:text-emerald-800 border border-emerald-200 hover:border-emerald-300 bg-emerald-50 hover:bg-emerald-100 px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-2 mx-auto">
                                                <i class="fa-solid fa-file-invoice"></i> Invoice
                                            </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p class="font-medium text-gray-500">Belum ada data tagihan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</x-layouts.profile>

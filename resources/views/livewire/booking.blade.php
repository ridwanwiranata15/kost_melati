<div class="p-6">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Booking</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau status reservasi dan pembayaran kamar.</p>
        </div>

        {{-- Optional: Bisa ditambah filter bulan/tahun disini --}}
        <div class="flex gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white border border-gray-200 text-gray-600 shadow-sm">
                Total: {{ count($bookings) }} Data
            </span>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-lg bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800 flex items-center gap-3 animate-fade-in">
            <div class="p-2 bg-primary-100 dark:bg-primary-800 rounded-full text-primary-600 dark:text-primary-300">
                <i class="fas fa-check"></i>
            </div>
            <p class="text-primary-800 dark:text-primary-200 text-sm font-medium">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4">Kode Booking</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Detail Kamar</th>
                        <th class="px-6 py-4">Periode Sewa</th>
                        <th class="px-6 py-4 text-right">Total Biaya</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">

                            {{-- Kode Booking --}}
                            <td class="px-6 py-4">
                                <span class="font-mono font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-xs border border-gray-200 dark:border-gray-600">
                                    #{{ $booking->booking_code }}
                                </span>
                            </td>

                            {{-- Pelanggan --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-xs border border-primary-200 dark:border-primary-800 uppercase">
                                        {{ substr($booking->user->name, 0, 2) }}
                                    </div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $booking->user->name }}
                                    </div>
                                </div>
                            </td>

                            {{-- Detail Kamar --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 dark:text-white font-medium">{{ $booking->room->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Nomor: <span class="font-semibold">{{ $booking->room->room_number }}</span>
                                    </span>
                                </div>
                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col text-xs">
                                    <span class="text-gray-500 dark:text-gray-400 mb-1">
                                        Durasi: <span class="font-medium text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-1.5 py-0.5 rounded">{{ $booking->duration }}</span>
                                    </span>
                                    <div class="text-gray-600 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->date_in)->format('d M Y') }}
                                        <i class="fas fa-arrow-right text-[10px] mx-1 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($booking->date_out)->format('d M Y') }}
                                    </div>
                                </div>
                            </td>

                            {{-- Total Harga --}}
                            <td class="px-6 py-4 text-right font-bold text-gray-800 dark:text-white">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </td>

                            {{-- Status & Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="relative inline-block w-full max-w-[140px]">
                                    <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)"
                                        class="block w-full rounded-lg border-0 py-1.5 pl-3 pr-8 text-xs font-medium cursor-pointer shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-primary-600 sm:leading-6 transition-colors
                                        {{ $booking->status == 'confirmed' ? 'bg-green-50 text-green-700 ring-green-200' :
                                          ($booking->status == 'cancelled' ? 'bg-red-50 text-red-700 ring-red-200' :
                                          ($booking->status == 'checkin' ? 'bg-blue-50 text-blue-700 ring-blue-200' :
                                          ($booking->status == 'checkout' ? 'bg-gray-100 text-gray-600 ring-gray-200' : 'bg-yellow-50 text-yellow-700 ring-yellow-200'))) }}">

                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                        <option value="checkin" {{ $booking->status == 'checkin' ? 'selected' : '' }}>🏨 Checkin</option>
                                        <option value="checkout" {{ $booking->status == 'checkout' ? 'selected' : '' }}>👋 Checkout</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>🚫 Canceled</option>
                                    </select>

                                    {{-- Loading Spinner Kecil di Pojok --}}
                                    <div wire:loading wire:target="updateStatus({{ $booking->id }}, $event.target.value)"
                                        class="absolute right-[-25px] top-1.5">
                                        <i class="fas fa-circle-notch fa-spin text-primary-500 text-sm"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="far fa-calendar-times text-3xl text-gray-400 dark:text-gray-600"></i>
                                    </div>
                                    <p class="font-medium">Belum ada booking masuk.</p>
                                    <p class="text-xs mt-1">Data reservasi akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (Optional) --}}
        {{-- <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            {{ $bookings->links() }}
        </div> --}}
    </div>
</div>

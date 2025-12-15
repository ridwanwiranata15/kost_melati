<div class="p-4 sm:p-6 space-y-6">

    {{-- SECTION 1: Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Daftar Booking</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau status reservasi, check-in, dan pembayaran.</p>
        </div>
    </div>

    {{-- SECTION 2: 5 Stats Cards --}}
    {{-- REVISI: grid-cols-1 agar di HP numpuk ke bawah (Block) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">

        {{-- Card 1: Pending (Kuning) --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border-t-4 border-yellow-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-400 uppercase">Pending</p>
                <i class="fas fa-clock text-yellow-500 bg-yellow-50 dark:bg-yellow-900/20 p-2 rounded-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['pending'] }}</h2>
            <p class="text-[10px] text-gray-400 mt-1">Menunggu konfirmasi</p>
        </div>

        {{-- Card 2: Confirmed (Hijau) --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border-t-4 border-green-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-400 uppercase">Confirmed</p>
                <i class="fas fa-check-circle text-green-500 bg-green-50 dark:bg-green-900/20 p-2 rounded-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['confirmed'] }}</h2>
            <p class="text-[10px] text-gray-400 mt-1">Terverifikasi</p>
        </div>

        {{-- Card 3: Checkin (Biru) --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border-t-4 border-blue-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-400 uppercase">Check-in</p>
                <i class="fas fa-door-open text-blue-500 bg-blue-50 dark:bg-blue-900/20 p-2 rounded-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['checkin'] }}</h2>
            <p class="text-[10px] text-gray-400 mt-1">Sedang menginap</p>
        </div>

        {{-- Card 4: Checkout (Abu-abu/Hitam) --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border-t-4 border-gray-600 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-400 uppercase">Check-out</p>
                <i class="fas fa-door-closed text-gray-600 bg-gray-100 dark:bg-gray-700 p-2 rounded-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['checkout'] }}</h2>
            <p class="text-[10px] text-gray-400 mt-1">Selesai sewa</p>
        </div>

        {{-- Card 5: Cancelled (Merah) --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border-t-4 border-red-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold text-gray-400 uppercase">Cancelled</p>
                <i class="fas fa-ban text-red-500 bg-red-50 dark:bg-red-900/20 p-2 rounded-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['cancelled'] }}</h2>
            <p class="text-[10px] text-gray-400 mt-1">Dibatalkan</p>
        </div>
    </div>

    {{-- SECTION 3: Filters & Search --}}
    <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row justify-between gap-4 items-center">

        {{-- Search Bar --}}
        <div class="relative w-full lg:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white"
                placeholder="Cari Booking ID / Nama..."
            >
        </div>

        {{-- Filter Status --}}
        <div class="w-full lg:w-48">
            <select wire:model.live="filterStatus" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="checkin">Checkin</option>
                <option value="checkout">Checkout</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="p-4 rounded-lg bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800 flex items-center gap-3 animate-fade-in">
            <div class="p-2 bg-primary-100 dark:bg-primary-800 rounded-full text-primary-600 dark:text-primary-300">
                <i class="fas fa-check"></i>
            </div>
            <p class="text-primary-800 dark:text-primary-200 text-sm font-medium">{{ session('message') }}</p>
        </div>
    @endif

    {{-- SECTION 4: Table --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        {{-- Wrapper overflow agar bisa scroll horizontal di HP --}}
        <div class="overflow-x-auto w-full">
            {{-- Tambahkan whitespace-nowrap agar baris tidak terpotong aneh di HP --}}
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse ($bookings as $booking)
                        <tr wire:key="booking-{{ $booking->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">

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
                                        No: <span class="font-semibold">{{ $booking->room->room_number }}</span>
                                    </span>
                                </div>
                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col text-xs">
                                    <span class="text-gray-500 dark:text-gray-400 mb-1">
                                        {{ $booking->duration }} bulan
                                    </span>
                                    <div class="text-gray-600 dark:text-gray-300 flex items-center gap-1">
                                        <span>{{ \Carbon\Carbon::parse($booking->date_in)->format('d M') }}</span>
                                        <i class="fas fa-arrow-right text-[8px] text-gray-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($booking->date_out)->format('d M') }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Total Harga --}}
                            <td class="px-6 py-4 text-right font-bold text-gray-800 dark:text-white">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </td>

                            {{-- Status Dropdown (Livewire Action) --}}
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

                                    {{-- Loading Indicator --}}
                                    <div wire:loading wire:target="updateStatus({{ $booking->id }}, $event.target.value)" class="absolute right-[-25px] top-1.5">
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
                                    <p class="font-medium">Data booking tidak ditemukan.</p>
                                    <p class="text-xs mt-1">Coba ubah kata kunci pencarian atau filter status.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>

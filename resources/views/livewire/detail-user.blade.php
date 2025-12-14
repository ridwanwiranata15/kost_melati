<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Pengguna</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola informasi dan status pembayaran penyewa.</p>
        </div>
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                <div class="flex-shrink-0 flex flex-col items-center">
                    <div class="relative w-32 h-32 mb-4">
                        @if ($photo)
                            <img src="{{ url('storage/' . $photo) }}"
                                class="w-full h-full object-cover rounded-full border-4 border-gray-50 shadow-md"
                                alt="Foto Profil">
                        @else
                            <div
                                class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-4xl border-4 border-gray-50 shadow-md">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>

                <div class="flex-grow w-full grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" readonly wire:model="name"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-800 sm:text-sm p-2.5 focus:ring-0 focus:border-gray-200 cursor-not-allowed">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                        <input type="text" readonly wire:model="email"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-800 sm:text-sm p-2.5 focus:ring-0 focus:border-gray-200 cursor-not-allowed">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                        <input type="text" readonly wire:model="phone"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-800 sm:text-sm p-2.5 focus:ring-0 focus:border-gray-200 cursor-not-allowed">
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-blue-600 mb-1">Ubah Status Akun</label>
                        <select wire:model.live="status" wire:change="updateStatus"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5 bg-white">
                            <option value="active">Aktif</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Riwayat Pembayaran</h3>
            <span class="text-xs text-gray-500">Daftar tagihan & bukti transfer</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan
                            Tagihan</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh
                            Tempo</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status Bayar</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl
                            Pembayaran</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bukti</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Konfirmasi Admin</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $item)
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($booking->start_date ?? $booking->created_at);
                            $bulanTagihan = $tanggalMulai->copy()->addMonths($loop->index);
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 capitalize">
                                    {{ $bulanTagihan->translatedFormat('F Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $bulanTagihan->copy()->day(10)->translatedFormat('d F Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->status == 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                        Belum Lunas
                                    </span>
                                @elseif($item->status == 'confirmed')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        Lunas
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->date_pay ? \Carbon\Carbon::parse($item->date_pay)->translatedFormat('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($item->payment_receipt)
                                    <div class="flex justify-center group relative">
                                        <a href="{{ url('storage/' . $item->payment_receipt) }}" target="_blank">
                                            <img src="{{ url('storage/' . $item->payment_receipt) }}" alt="Bukti"
                                                class="h-10 w-10 rounded object-cover border border-gray-200 hover:scale-150 transition z-0 hover:z-10 shadow-sm cursor-zoom-in">
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Kosong</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">

                                <select wire:change="updateStatusTransaction({{ $item->id }}, $event.target.value)"
                                    class="text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 pl-2 pr-8 {{ $item->status == 'confirmed' ? 'bg-green-50 text-green-700 border-green-200' : '' }}" wire:model.live="statusPayment">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="confirmed" {{ $item->status == 'confirmed' ? 'selected' : '' }}>
                                        Terima</option>
                                    <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Tolak
                                    </option>
                                </select>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-folder-open text-3xl mb-3 text-gray-300"></i>
                                    <p>Belum ada riwayat transaksi untuk user ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

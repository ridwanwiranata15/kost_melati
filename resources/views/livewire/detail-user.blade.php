<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- HEADER PAGE --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-1.5 h-8 bg-primary-500 rounded-full"></span> Detail Pengguna
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola informasi profil dan riwayat pembayaran
                penyewa.</p>
        </div>
        <a href="{{ route('admin.user') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition-colors">
            <i class="fa-solid fa-arrow-left mr-2 text-gray-400"></i> Kembali
        </a>
    </div>

    {{-- CARD PROFIL --}}
    <div
        class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                {{-- FOTO & STATUS --}}
                <div class="flex-shrink-0 flex flex-col items-center w-full md:w-auto">
                    <div class="relative w-32 h-32 mb-4 group">
                        @if ($photo)
                            <img src="{{ url('storage/' . $photo) }}"
                                class="w-full h-full object-cover rounded-full border-4 border-white dark:border-gray-700 shadow-md transition-transform group-hover:scale-105"
                                alt="Foto Profil">
                        @else
                            <div
                                class="w-full h-full rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 text-4xl border-4 border-white dark:border-gray-600 shadow-md">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif

                        {{-- Status Badge Absolut --}}
                        <div class="absolute bottom-0 right-0">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full border-2 border-white dark:border-gray-800 {{ $status == 'active' ? 'bg-green-500' : ($status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                <i
                                    class="fa-solid {{ $status == 'active' ? 'fa-check' : ($status == 'pending' ? 'fa-hourglass' : 'fa-times') }} text-white text-[10px]"></i>
                            </span>
                        </div>
                    </div>

                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium uppercase tracking-wide {{ $status == 'active' ? 'bg-green-50 text-green-700 border border-green-200' : ($status == 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 'bg-red-50 text-red-700 border border-red-200') }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>

                {{-- FORM DATA --}}
                <div class="flex-grow w-full grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="col-span-1">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Nama
                                Lengkap</label>
                            <input type="text" readonly wire:model="name"
                                class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Email</label>
                            <input type="text" readonly wire:model="email"
                                class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">WhatsApp</label>
                            <input type="text" readonly wire:model="phone"
                                class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Status
                                Akun</label>
                            <select wire:model.live="status" x-on:change="$wire.updateStatus()"
                                class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                                <option value="active">✅ Aktif</option>
                                <option value="pending">⏳ Pending</option>
                                <option value="rejected">🚫 Ditolak</option>
                            </select>
                        </div>
                    </div>

                    {{-- Universitas / Prodi --}}
                    <div class="col-span-1">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Universitas
                            / Prodi</label>
                        <div
                            class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-graduation-cap text-blue-400 text-xs w-4"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $university ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Nama Orang Tua --}}
                    <div class="col-span-1">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Nama
                            Orang Tua / Wali</label>
                        <div
                            class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-people-roof text-purple-400 text-xs w-4"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $parentsName ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div class="col-span-1">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">No.
                            HP Orang Tua / Wali</label>
                        <div
                            class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-phone text-green-400 text-xs w-4"></i>
                            @if ($parentsPhone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $parentsPhone) }}"
                                    target="_blank"
                                    class="text-sm text-primary-600 dark:text-primary-400 hover:underline font-medium">
                                    {{ $parentsPhone }}
                                </a>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- KTP PHOTO CARD --}}
    <div
        class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div
            class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-id-card text-blue-500"></i> Foto KTP
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Verifikasi identitas penyewa. File tersimpan di
                    storage privat.</p>
            </div>
            <span
                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800">
                <i class="fas fa-shield-alt mr-1.5"></i> Private Storage
            </span>
        </div>
        <div class="p-6">
            @if ($ktpUrl)
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    {{-- Tampilkan foto KTP melalui URL aman --}}
                    <a href="{{ $ktpUrl }}" target="_blank" class="block group flex-shrink-0">
                        <div
                            class="relative overflow-hidden rounded-xl border-2 border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl transition-all hover:border-primary-400">
                            <img src="{{ $ktpUrl }}" alt="Foto KTP {{ $name }}"
                                class="h-44 w-72 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition-colors">
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 rounded-full px-3 py-1.5 text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                                    <i class="fas fa-expand-alt"></i> Buka Penuh
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="space-y-3">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm font-semibold text-green-700 dark:text-green-400">KTP telah
                                diupload</span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                            File disimpan pada private disk dan hanya dapat diakses melalui link terautentikasi ini.
                        </p>
                        <a href="{{ $ktpUrl }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors shadow-sm">
                            <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                        </a>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                        <i class="fas fa-id-card text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada foto KTP</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Pengguna belum mengupload foto KTP saat
                        pendaftaran.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- RIWAYAT PEMBAYARAN --}}
    <div
        class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div
            class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Pembayaran</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Monitor status tagihan bulanan penyewa.</p>
            </div>

            {{-- Indikator Warna (Legend) --}}
            <div class="flex gap-3 text-xs">
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span>
                    Lunas</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span>
                    Belum</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Bulan Tagihan</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Jatuh Tempo</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status Bayar</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tgl Bayar</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Bukti</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-dark-card divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $item)
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($booking->start_date ?? $booking->created_at);
                            $bulanTagihan = $tanggalMulai->copy()->addMonths($loop->index);
                            $isLunas = $item->status == 'confirmed';
                        @endphp

                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $isLunas ? 'bg-green-50/30' : '' }}">

                            {{-- Bulan Tagihan --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white capitalize">
                                    {{ $bulanTagihan->translatedFormat('F Y') }}
                                </div>
                            </td>

                            {{-- Jatuh Tempo --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-xs"></i>
                                    {{ $bulanTagihan->copy()->day(10)->translatedFormat('d M Y') }}
                                </div>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->status == 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <span
                                            class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($item->status == 'confirmed')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class="fa-solid fa-check-circle mr-1.5 text-green-600"></i>
                                        Lunas
                                    </span>
                                @elseif($item->status == 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <i class="fa-solid fa-times-circle mr-1.5 text-red-600"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>

                            {{-- Tgl Pembayaran --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $item->date_pay ? \Carbon\Carbon::parse($item->date_pay)->translatedFormat('d M Y H:i') : '-' }}
                            </td>

                            {{-- Bukti Transfer --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($item->payment_receipt)
                                    <div class="flex justify-center group relative">
                                        <a href="{{ url('storage/' . $item->payment_receipt) }}" target="_blank"
                                            class="block relative">
                                            <img src="{{ url('storage/' . $item->payment_receipt) }}" alt="Bukti"
                                                class="h-10 w-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600 hover:scale-150 transition-transform z-0 hover:z-10 shadow-sm cursor-zoom-in bg-white">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-black/20 rounded-lg opacity-0 group-hover:opacity-0 transition-opacity pointer-events-none">
                                                <i class="fa-solid fa-magnifying-glass text-white text-xs"></i>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <span
                                        class="text-xs text-gray-400 italic bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">Kosong</span>
                                @endif
                            </td>

                            {{-- Aksi Admin --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button wire:click="openEditModal({{ $item->id }})"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm border border-blue-200"
                                    title="Edit Transaksi">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa-regular fa-folder-open text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="font-medium">Belum ada riwayat transaksi</p>
                                    <p class="text-xs mt-1">Data pembayaran akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">

            {{-- BACKDROP --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeEditModal"></div>

            {{-- MODAL BOX --}}
            <div
                class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto
            bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
            transform transition-all z-50">

                {{-- HEADER --}}
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex items-start gap-3">

                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Edit Data Transaksi
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Silakan update nominal atau bukti pembayaran
                            </p>
                        </div>

                    </div>

                    {{-- FORM --}}
                    <div class="mt-4 space-y-4">

                        {{-- Amount --}}
                        <input type="number" wire:model="editAmount"
                            class="w-full px-4 py-3 rounded-lg border dark:bg-gray-700">

                        {{-- File --}}
                        <input type="file" wire:model="editProof" class="w-full">

                        {{-- Status --}}
                        <select wire:model="editStatus" class="w-full px-3 py-2 rounded-lg border dark:bg-gray-700">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Terima</option>
                            <option value="rejected">Tolak</option>
                        </select>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="px-4 py-3 sm:px-6 flex justify-end gap-2 bg-gray-50 dark:bg-gray-700/50">

                    <button wire:click="closeEditModal" class="px-4 py-2 rounded-lg border">
                        Batal
                    </button>

                    <button wire:click="saveTransaction" class="px-4 py-2 rounded-lg bg-blue-600 text-white">
                        Simpan
                    </button>

                </div>

            </div>
        </div>
    @endif
</div>

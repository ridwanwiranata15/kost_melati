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
        <a href="{{ url()->previous() }}"
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
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" readonly wire:model="name"
                                   class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Email</label>
                            <input type="text" readonly wire:model="email"
                                   class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">WhatsApp</label>
                            <input type="text" readonly wire:model="phone"
                                   class="w-full py-3 px-4 rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed transition-all">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Status Akun</label>
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
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Universitas / Prodi</label>
                        <div class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-graduation-cap text-blue-400 text-xs w-4"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $university ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Nama Orang Tua --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Nama Orang Tua / Wali</label>
                        <div class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-people-roof text-purple-400 text-xs w-4"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $parentsName ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">No. HP Orang Tua / Wali</label>
                        <div class="flex items-center gap-2 py-3 px-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <i class="fas fa-phone text-green-400 text-xs w-4"></i>
                            @if($parentsPhone)
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
    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-id-card text-blue-500"></i> Foto KTP
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Verifikasi identitas penyewa. File tersimpan di storage privat.</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800">
                <i class="fas fa-shield-alt mr-1.5"></i> Private Storage
            </span>
        </div>
        <div class="p-6">
            @if($ktpUrl)
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    {{-- Tampilkan foto KTP melalui URL aman --}}
                    <a href="{{ $ktpUrl }}" target="_blank" class="block group flex-shrink-0">
                        <div class="relative overflow-hidden rounded-xl border-2 border-gray-200 dark:border-gray-700 shadow-md hover:shadow-xl transition-all hover:border-primary-400">
                            <img src="{{ $ktpUrl }}" alt="Foto KTP {{ $name }}"
                                class="h-44 w-72 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition-colors">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 rounded-full px-3 py-1.5 text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                                    <i class="fas fa-expand-alt"></i> Buka Penuh
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm font-semibold text-green-700 dark:text-green-400">KTP telah diupload</span>
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
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                        <i class="fas fa-id-card text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada foto KTP</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Pengguna belum mengupload foto KTP saat pendaftaran.</p>
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
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Belum</span>
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


    {{-- MODAL EDIT TRANSAKSI --}}
@if($showEditModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop (Background Gelap) --}}
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeEditModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">

            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Edit Data Transaksi
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                Silakan update nominal harga atau bukti pembayaran jika diperlukan.
                            </p>

                            {{-- Form Input --}}
                            <div class="space-y-4">

                                {{-- Input Harga --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Jumlah Pembayaran</label>
                                    <input type="number" wire:model="editAmount"
                                           class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                                    @error('editAmount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Input Gambar --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Bukti Baru</label>
                                    <input type="file" wire:model="editProof"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer
                                    ">
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
                                    @error('editProof') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                                    {{-- Preview Loading --}}
                                    <div wire:loading wire:target="editProof" class="text-sm text-blue-500 mt-1">
                                        Sedang mengupload...
                                    </div>
                                </div>
                                <div class="relative inline-block w-full max-w-[140px]">
                                    <select wire:model.live="editStatus"
                                        class="block w-full rounded-lg border-0 py-1.5 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-primary-600 sm:text-xs sm:leading-6 cursor-pointer shadow-sm
                                        {{ $item->status == 'confirmed' ? 'bg-green-50 text-green-700 ring-green-200' : ($item->status == 'rejected' ? 'bg-red-50 text-red-700 ring-red-200' : 'bg-white') }}">

                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="confirmed" {{ $item->status == 'confirmed' ? 'selected' : '' }}>✅ Terima</option>
                                        <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>🚫 Tolak</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Modal (Tombol) --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" wire:click="saveTransaction"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan Perubahan
                </button>
                <button type="button" wire:click="closeEditModal"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endif
</div>

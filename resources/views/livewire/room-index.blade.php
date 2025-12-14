<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">

    <div class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="#" class="hover:text-primary-600 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="#" class="hover:text-primary-600 transition-colors">Kamar</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-primary-600 font-medium">Tambah Data</span>
    </div>

    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-primary-500 rounded-full"></span>
                    Form Input Data Kost
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 pl-3.5">Silakan lengkapi detail kamar di bawah ini.</p>
            </div>

            <a href="#" class="text-sm text-gray-500 hover:text-primary-600 font-medium flex items-center gap-1 transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form wire:submit.prevent="save" class="p-6 sm:p-8">
            <div class="space-y-8">

                <div>
                    <h3 class="text-sm font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Informasi Kamar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Kamar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <input type="text" wire:model="number" class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm py-2.5 shadow-sm" placeholder="Contoh: A-101">
                            </div>
                            @error('number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe / Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm py-2.5 shadow-sm" placeholder="Contoh: Deluxe (Kamar Mandi Dalam)">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Kamar <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm py-2.5 shadow-sm">
                                <option value="">-- Pilih Status --</option>
                                <option value="available">✅ Tersedia (Kosong)</option>
                                <option value="unavailable">🚫 Tidak Tersedia (Isi)</option>
                                <option value="repair">🛠️ Dalam Perbaikan</option>
                            </select>
                            @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fasilitas
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-wifi text-gray-400"></i>
                                </div>
                                <input type="text" wire:model="facility" class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm:text-sm py-2.5 shadow-sm" placeholder="AC, WiFi, Lemari...">
                            </div>
                            @error('facility') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Media & Detail
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Foto Kamar
                            </label>

                            <div class="mt-1 flex justify-center rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 px-6 pt-5 pb-6 bg-gray-50 dark:bg-gray-800 hover:bg-white dark:hover:bg-gray-700 transition-colors relative group h-48 items-center">
                                <div class="text-center w-full">

                                    {{-- Image Preview Logic --}}
                                    @if ($image)
                                        <div class="relative mx-auto h-32 w-full rounded-lg overflow-hidden shadow-sm">
                                            <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-cover">

                                            {{-- Overlay untuk ganti gambar --}}
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <p class="text-white text-xs font-medium">Ganti Foto</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-500 mb-2 group-hover:text-primary-500 transition-colors">
                                            <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <label for="file-upload-page" class="relative cursor-pointer rounded-md font-semibold text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                <span>Upload Foto</span>
                                                <input id="file-upload-page" wire:model="image" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    @endif

                                    {{-- Loading State --}}
                                    <div wire:loading wire:target="image" class="absolute inset-0 bg-white/90 dark:bg-gray-800/90 flex flex-col items-center justify-center rounded-xl z-10">
                                        <i class="fas fa-circle-notch fa-spin text-primary-500 text-2xl mb-2"></i>
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Mengupload...</span>
                                    </div>
                                </div>
                            </div>
                            @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi Lengkap
                            </label>
                            <textarea wire:model="description" rows="7" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all sm

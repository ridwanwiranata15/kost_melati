<div class="p-4 sm:p-6 space-y-6">

    {{-- SECTION 1: Header & Judul --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Daftar Properti (Kost)</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola lokasi kost, alamat, dan deskripsi masing-masing properti.</p>
        </div>
    </div>

    {{-- SECTION 3: Filters, Search & Add Button --}}
    <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row justify-between gap-4 items-center">

        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto flex-1">
            {{-- Search Bar --}}
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white" placeholder="Cari properti...">
            </div>
        </div>

        {{-- Add Button --}}
        <button wire:click="openCreateModal" class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-primary-500/30 whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i> <span class="hidden sm:inline">Tambah Properti</span><span class="sm:hidden">Tambah</span>
        </button>
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
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap sm:whitespace-normal">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-4 sm:px-6 py-4">Nama Properti</th>
                        <th class="px-4 sm:px-6 py-4">Lokasi</th>
                        <th class="hidden md:table-cell px-6 py-4">Alamat</th>
                        <th class="px-4 sm:px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0 border border-gray-200 dark:border-gray-600 relative">
                                        @if($property->image)
                                            <img src="{{ asset('storage/'.$property->image) }}" alt="Foto" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-building"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-white">{{ $property->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 hidden sm:block">{{ Str::limit($property->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                <span class="bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 py-1 px-2 rounded text-xs font-medium">{{ $property->location }}</span>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-gray-600 dark:text-gray-300">
                                <span class="text-xs">{{ Str::limit($property->address, 50) }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $property->id }})" class="p-2 rounded-lg text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-all"><i class="fas fa-pen-to-square"></i></button>
                                    <button wire:click="delete({{ $property->id }})" wire:confirm="Yakin ingin menghapus properti ini? Semua kamar terkait akan ikut terhapus." class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4"><i class="fas fa-search text-3xl text-gray-400 dark:text-gray-600"></i></div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Data properti tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($properties->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $properties->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL CREATE PROPERTY --}}
    @if($isCreateModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeCreateModal"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-primary-500 rounded-full"></span> Tambah Properti
                    </h3>
                    <button type="button" wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Nama Properti</label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="Contoh: Kost Melati Jawa">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Lokasi (Wilayah)</label>
                            <input type="text" wire:model="location" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="Contoh: Jawa Tengah / Sumatera Utara">
                            @error('location') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Alamat Lengkap</label>
                            <textarea wire:model="address" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500"></textarea>
                            @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Foto Utama</label>
                            <div class="mt-1 flex justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-600 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors relative">
                                <div class="text-center">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-20 w-auto rounded-lg object-cover mb-2">
                                        <p class="text-xs text-green-600">Foto siap</p>
                                    @else
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                        <label class="cursor-pointer text-sm text-primary-600 hover:text-primary-500 font-medium">
                                            <span>Upload</span>
                                            <input wire:model="image" type="file" class="sr-only">
                                        </label>
                                        <p class="text-xs text-gray-500">PNG/JPG < 2MB</p>
                                    @endif
                                </div>
                            </div>
                            @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex flex-col-reverse sm:flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-primary-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-600 sm:w-auto transition-colors">Simpan</button>
                        <button type="button" wire:click="closeCreateModal" class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:w-auto transition-colors">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL EDIT PROPERTY --}}
    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-yellow-500 rounded-full"></span> Edit Properti
                    </h3>
                    <button type="button" wire:click="closeEditModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Nama Properti</label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Lokasi (Wilayah)</label>
                            <input type="text" wire:model="location" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('location') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Alamat Lengkap</label>
                            <textarea wire:model="address" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                            @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Foto Utama</label>
                            <div class="mt-1 flex gap-4 items-center">
                                <div class="relative w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-100">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif ($oldImage)
                                        <img src="{{ asset('storage/'.$oldImage) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-building text-xl"></i></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label class="flex justify-center w-full h-16 sm:h-20 px-4 transition bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg appearance-none cursor-pointer hover:border-yellow-500 focus:outline-none items-center">
                                        <span class="flex items-center space-x-2">
                                            <i class="fas fa-cloud-upload-alt text-gray-400"></i>
                                            <span class="font-medium text-gray-600 dark:text-gray-400 text-xs">Ubah foto</span>
                                        </span>
                                        <input type="file" wire:model="image" class="hidden">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex flex-col-reverse sm:flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto transition-colors">Update</button>
                        <button type="button" wire:click="closeEditModal" class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:w-auto transition-colors">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

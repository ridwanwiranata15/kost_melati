<div class="p-4 sm:p-6 space-y-6">

    {{-- SECTION 1: Header & Judul --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Daftar Kamar</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data kamar kost, fasilitas, dan monitoring status.</p>
        </div>
    </div>

    {{-- SECTION 2: Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        {{-- Card Tersedia --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 sm:p-6 shadow-sm border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tersedia</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalAvailable }}</h2>
                <p class="text-xs text-green-600 mt-1 font-medium">Siap huni</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-500 text-lg sm:text-xl">
                <i class="fas fa-door-open"></i>
            </div>
        </div>

        {{-- Card Perbaikan --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 sm:p-6 shadow-sm border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Perbaikan</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalRepair }}</h2>
                <p class="text-xs text-yellow-600 mt-1 font-medium">Maintenance</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center text-yellow-500 text-lg sm:text-xl">
                <i class="fas fa-tools"></i>
            </div>
        </div>

        {{-- Card Tidak Tersedia --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-4 sm:p-6 shadow-sm border-l-4 border-red-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tidak Tersedia</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalUnavailable }}</h2>
                <p class="text-xs text-red-600 mt-1 font-medium">Sedang disewa</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 text-lg sm:text-xl">
                <i class="fas fa-user-lock"></i>
            </div>
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
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white" placeholder="Cari kamar...">
            </div>

            {{-- Filter Status --}}
            <div class="w-full sm:w-48">
                <select wire:model.live="filterStatus" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="unavailable">Terisi</option>
                    <option value="repair">Perbaikan</option>
                </select>
            </div>
        </div>

        {{-- Add Button (Memicu method PHP openCreateModal) --}}
        <button wire:click="openCreateModal" class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-primary-500/30 whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i> <span class="hidden sm:inline">Tambah Kamar</span><span class="sm:hidden">Tambah</span>
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
                        <th class="px-4 sm:px-6 py-4">Nomor</th>
                        <th class="px-4 sm:px-6 py-4">Info Kamar</th>
                        <th class="hidden md:table-cell px-6 py-4">Fasilitas</th>
                        <th class="px-4 sm:px-6 py-4">Status</th>
                        <th class="px-4 sm:px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4 font-bold text-gray-800 dark:text-white">{{ $room->room_number }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0 border border-gray-200 dark:border-gray-600 relative">
                                        @if($room->image)
                                            <img src="{{ asset('storage/'.$room->image) }}" alt="Foto" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-white">{{ $room->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 hidden sm:block">{{ Str::limit($room->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-gray-600 dark:text-gray-300">
                                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-1 px-2 rounded text-xs">{{ Str::limit($room->facility, 20) }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                @if($room->status == 'available')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> <span class="hidden sm:inline">Tersedia</span><span class="sm:hidden">Ok</span>
                                    </span>
                                @elseif($room->status == 'unavailable')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> <span class="hidden sm:inline">Terisi</span><span class="sm:hidden">Full</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> <span class="hidden sm:inline">Perbaikan</span><span class="sm:hidden">Fix</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $room->id }})" class="p-2 rounded-lg text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-all"><i class="fas fa-pen-to-square"></i></button>
                                    <button wire:click="delete({{ $room->id }})" wire:confirm="Yakin ingin menghapus kamar ini?" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4"><i class="fas fa-search text-3xl text-gray-400 dark:text-gray-600"></i></div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Data tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rooms->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL CREATE KAMAR (DIKONTROL PHP $isCreateModalOpen) --}}
    @if($isCreateModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop: Close saat diklik --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeCreateModal"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">

                 <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-primary-500 rounded-full"></span> Tambah Kamar
                    </h3>
                    <button type="button" wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Nomor</label>
                                <input type="text" wire:model="number" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="A-01">
                                @error('number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Tipe</label>
                                <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="VIP / Standard">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Status</label>
                                <select wire:model="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih Status</option>
                                    <option value="available">Tersedia</option>
                                    <option value="unavailable">Tidak Tersedia</option>
                                    <option value="repair">Perbaikan</option>
                                </select>
                                @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Fasilitas</label>
                                <input type="text" wire:model="facility" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="AC, WiFi...">
                                @error('facility') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Foto</label>
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
                                    {{-- Loading State --}}
                                    <div wire:loading wire:target="image" class="absolute inset-0 bg-white/80 dark:bg-gray-800/80 flex items-center justify-center">
                                        <span class="text-sm text-primary-600 font-medium"><i class="fas fa-spinner fa-spin mr-1"></i> Uploading...</span>
                                    </div>
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
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-primary-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-600 sm:w-auto transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save"><i class="fas fa-circle-notch fa-spin mr-1"></i></span>
                        </button>
                        <button type="button" wire:click="closeCreateModal" class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:w-auto transition-colors">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL EDIT KAMAR (DIKONTROL PHP $isEditModalOpen) --}}
    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">

                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-yellow-500 rounded-full"></span> Edit Kamar
                    </h3>
                    <button type="button" wire:click="closeEditModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Nomor</label>
                                <input type="text" wire:model="number" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Tipe</label>
                                <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Status</label>
                                <select wire:model="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                                    <option value="available">Tersedia</option>
                                    <option value="unavailable">Tidak Tersedia</option>
                                    <option value="repair">Perbaikan</option>
                                </select>
                                @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Fasilitas</label>
                                <input type="text" wire:model="facility" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('facility') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Foto</label>
                            <div class="mt-1 flex gap-4 items-center">
                                <div class="relative w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-100">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div class="absolute bottom-0 left-0 right-0 bg-green-500 text-white text-[10px] text-center">Baru</div>
                                    @elseif ($oldImage)
                                        <img src="{{ asset('storage/'.$oldImage) }}" class="w-full h-full object-cover">
                                        <div class="absolute bottom-0 left-0 right-0 bg-gray-500/80 text-white text-[10px] text-center">Lama</div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-xl"></i></div>
                                    @endif
                                    <div wire:loading wire:target="image" class="absolute inset-0 bg-black/50 flex items-center justify-center text-white"><i class="fas fa-spinner fa-spin"></i></div>
                                </div>

                                <div class="flex-1">
                                    <label class="flex justify-center w-full h-16 sm:h-20 px-4 transition bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg appearance-none cursor-pointer hover:border-yellow-500 focus:outline-none items-center">
                                        <span class="flex items-center space-x-2">
                                            <i class="fas fa-cloud-upload-alt text-gray-400"></i>
                                            <span class="font-medium text-gray-600 dark:text-gray-400 text-xs">Ubah foto</span>
                                        </span>
                                        <input type="file" wire:model="image" class="hidden">
                                    </label>
                                    @error('image') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex flex-col-reverse sm:flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="update">Update</span>
                            <span wire:loading wire:target="update"><i class="fas fa-circle-notch fa-spin mr-1"></i></span>
                        </button>
                        <button type="button" wire:click="closeEditModal" class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:w-auto transition-colors">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Script untuk event listener sudah tidak dibutuhkan lagi --}}
</div>

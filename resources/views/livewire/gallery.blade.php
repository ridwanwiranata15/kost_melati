<div class="p-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Galeri Kost</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola foto-foto fasilitas dan lingkungan kost.</p>
        </div>

        <button wire:click="resetInput" onclick="toggleModal('modalCreateGallery', true)"
            class="flex items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-primary-500/30">
            <i class="fas fa-plus mr-2"></i> Tambah Foto
        </button>
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

    {{-- Table Gallery --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4 w-32 text-center">Preview</th>
                        <th class="px-6 py-4">Informasi Foto</th>
                        <th class="px-6 py-4 w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse ($galleries as $Gallery)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">

                            {{-- Image Column --}}
                            <td class="px-6 py-4">
                                <div class="relative w-24 h-16 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-100">
                                    @if($Gallery->image)
                                        <img src="{{ asset('storage/' . $Gallery->image) }}" class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-500" alt="Gallery Image">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Info Column --}}
                            <td class="px-6 py-4">
                                <h4 class="font-bold text-gray-900 dark:text-white text-base mb-1">{{ $Gallery->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-xs line-clamp-2">{{ $Gallery->description }}</p>
                            </td>

                            {{-- Action Column --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $Gallery->id }})"
                                        class="p-2 rounded-lg text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-all" title="Edit">
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>

                                    <button wire:click="delete({{ $Gallery->id }})" wire:confirm="Hapus foto ini?"
                                        class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="far fa-images text-3xl text-gray-400 dark:text-gray-600"></i>
                                    </div>
                                    <p class="font-medium">Galeri masih kosong.</p>
                                    <p class="text-xs mt-1">Tambahkan foto pertama Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL CREATE --}}
    <div id="modalCreateGallery" wire:ignore.self class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0" id="backdrop-create"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700 opacity-0 scale-95" id="panel-create">

                    {{-- Header --}}
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-primary-500 rounded-full"></span> Tambah Foto
                        </h3>
                        <button type="button" onclick="toggleModal('modalCreateGallery', false)" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fas fa-times"></i></button>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="px-6 py-6 space-y-5">
                            {{-- Input Name --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Judul Foto</label>
                                <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500" placeholder="Contoh: Tampak Depan">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Input Image --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Upload File</label>
                                <div class="mt-1 flex justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-600 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors relative">
                                    <div class="text-center">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-24 w-auto rounded-lg object-cover mb-2 shadow-sm">
                                            <p class="text-xs text-green-600">Siap diupload</p>
                                        @else
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                            <label class="cursor-pointer text-sm text-primary-600 hover:text-primary-500 font-medium">
                                                <span>Pilih File</span>
                                                <input wire:model="image" type="file" class="sr-only">
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                        @endif

                                        <div wire:loading wire:target="image" class="absolute inset-0 bg-white/80 dark:bg-gray-800/80 flex items-center justify-center">
                                            <span class="text-sm text-primary-600 font-medium"><i class="fas fa-spinner fa-spin mr-1"></i> Uploading...</span>
                                        </div>
                                    </div>
                                </div>
                                @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Input Description --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Deskripsi</label>
                                <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-primary-500 focus:border-primary-500 resize-none" placeholder="Keterangan foto..."></textarea>
                                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-600 sm:w-auto transition-colors disabled:opacity-50">
                                <span wire:loading.remove wire:target="save">Simpan</span>
                                <span wire:loading wire:target="save"><i class="fas fa-circle-notch fa-spin"></i></span>
                            </button>
                            <button type="button" onclick="toggleModal('modalCreateGallery', false)" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="modalEditGallery" wire:ignore.self class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0" id="backdrop-edit"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700 opacity-0 scale-95" id="panel-edit">

                    {{-- Header --}}
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-yellow-500 rounded-full"></span> Edit Foto
                        </h3>
                        <button type="button" onclick="toggleModal('modalEditGallery', false)" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fas fa-times"></i></button>
                    </div>

                    <form wire:submit.prevent="update">
                        <div class="px-6 py-6 space-y-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Judul Foto</label>
                                <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Image Comparison (Old vs New) --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Ganti Foto (Opsional)</label>
                                <div class="mt-1 flex gap-4 items-center">
                                    {{-- Preview Box --}}
                                    <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-100">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <div class="absolute bottom-0 inset-x-0 bg-green-500 text-white text-[9px] text-center uppercase font-bold py-0.5">Baru</div>
                                        @elseif ($old_image)
                                            <img src="{{ asset('storage/' . $old_image) }}" class="w-full h-full object-cover">
                                            <div class="absolute bottom-0 inset-x-0 bg-gray-600/80 text-white text-[9px] text-center uppercase font-bold py-0.5">Lama</div>
                                        @endif
                                        <div wire:loading wire:target="image" class="absolute inset-0 bg-black/50 flex items-center justify-center text-white"><i class="fas fa-spinner fa-spin"></i></div>
                                    </div>

                                    {{-- Input Box --}}
                                    <div class="flex-1">
                                        <label class="flex flex-col justify-center w-full h-20 px-4 transition bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer hover:border-yellow-500">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-cloud-upload-alt text-gray-400"></i>
                                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Klik untuk ganti</span>
                                            </div>
                                            <input type="file" wire:model="image" class="hidden">
                                        </label>
                                    </div>
                                </div>
                                @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Deskripsi</label>
                                <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm py-2 px-3 focus:ring-yellow-500 focus:border-yellow-500 resize-none"></textarea>
                                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-yellow-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto transition-colors disabled:opacity-50">
                                <span wire:loading.remove wire:target="update">Update</span>
                                <span wire:loading wire:target="update"><i class="fas fa-circle-notch fa-spin"></i></span>
                            </button>
                            <button type="button" onclick="toggleModal('modalEditGallery', false)" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Modal Logic (Sama seperti halaman kamar) --}}
    <script>
        function toggleModal(modalID, show) {
            const modal = document.getElementById(modalID);
            const backdrop = modal.querySelector('div[id^="backdrop"]');
            const panel = modal.querySelector('div[id^="panel"]');

            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    panel.classList.remove('opacity-0', 'scale-95');
                    panel.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'scale-100');
                panel.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        document.addEventListener('livewire:initialized', () => {
            @this.on('gallery-saved', () => {
                toggleModal('modalCreateGallery', false);
                toggleModal('modalEditGallery', false);
            });

            @this.on('open-edit-modal', () => {
                toggleModal('modalEditGallery', true);
            });
        });
    </script>
</div>

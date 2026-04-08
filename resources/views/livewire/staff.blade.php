<div class="p-4 sm:p-6 space-y-6">

    {{-- SECTION 1: Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Manajemen Staff & Penjaga</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola role Super Admin dan Penjaga Properti (Caretaker).</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800 flex items-center gap-3 animate-fade-in">
            <div class="p-2 bg-primary-100 dark:bg-primary-800 rounded-full text-primary-600 dark:text-primary-300">
                <i class="fas fa-check"></i>
            </div>
            <p class="text-primary-800 dark:text-primary-200 text-sm font-medium">{{ session('message') }}</p>
        </div>
    @endif

    {{-- SECTION 4: Table and Actions --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        {{-- Table Header & Actions --}}
        <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/30 dark:bg-gray-800/30">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 py-2.5 w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all shadow-sm" placeholder="Cari staff...">
            </div>

            <button wire:click="openCreateModal" class="w-full md:w-auto flex items-center justify-center px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl text-sm font-medium transition-colors shadow-sm shadow-primary-500/30 whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Tambah Staff
            </button>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap sm:whitespace-normal">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-4 sm:px-6 py-4">Nama</th>
                        <th class="px-4 sm:px-6 py-4">Email</th>
                        <th class="px-4 sm:px-6 py-4">Role</th>
                        <th class="hidden md:table-cell px-6 py-4">Properti yang Dikelola</th>
                        <th class="px-4 sm:px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($staff as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $member->name }}</td>
                            <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">{{ $member->email }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                @if($member->role === 'admin')
                                    <span class="bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 py-1 px-2 rounded-full text-xs font-bold uppercase tracking-widest">Admin</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 py-1 px-2 rounded-full text-xs font-bold uppercase tracking-widest">Caretaker</span>
                                @endif
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-gray-600 dark:text-gray-300">
                                @if($member->isAdmin())
                                    <span class="text-xs text-gray-400 italic">Akses Seluruh Properti</span>
                                @else
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($member->properties as $prop)
                                            <span class="bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 py-0.5 px-2 rounded-md text-[10px] font-medium border border-primary-200 dark:border-primary-800">{{ $prop->name }}</span>
                                        @empty
                                            <span class="text-xs text-red-400 italic">Belum Ada Properti</span>
                                        @endforelse
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $member->id }})" class="p-2 rounded-lg text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-all"><i class="fas fa-pen-to-square"></i></button>
                                    <button wire:click="delete({{ $member->id }})" wire:confirm="Yakin ingin menghapus staff ini?" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Data staff tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($staff->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $staff->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL CREATE STAFF --}}
    <div x-data="{ open: @entangle('isCreateModalOpen') }"
         x-show="open"
         x-cloak
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
         
        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            {{-- Modal Panel --}}
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">Tambah Staff</h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Email</label>
                            <input type="email" wire:model="email" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Role</label>
                            <select wire:model.live="role" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                                <option value="caretaker">Caretaker</option>
                                <option value="admin">Super Admin</option>
                            </select>
                        </div>
                        @if($role === 'caretaker')
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Properti yang Dikelola</label>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @foreach($properties as $prop)
                                        <label class="inline-flex items-center p-2 rounded-lg border dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                                            <input type="checkbox" wire:model="selectedProperties" value="{{ $prop->id }}" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $prop->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedProperties') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white rounded-lg px-4 py-2 text-sm font-medium">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT STAFF --}}
    <div x-data="{ open: @entangle('isEditModalOpen') }"
         x-show="open"
         x-cloak
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
         
        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            {{-- Modal Panel --}}
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">Edit Staff</h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Email</label>
                            <input type="email" wire:model="email" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" wire:model="password" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Role</label>
                            <select wire:model.live="role" class="w-full py-3 px-4 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white transition-all">
                                <option value="caretaker">Caretaker</option>
                                <option value="admin">Super Admin</option>
                            </select>
                        </div>
                        @if($role === 'caretaker')
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Properti yang Dikelola</label>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @foreach($properties as $prop)
                                        <label class="inline-flex items-center p-2 rounded-lg border dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                                            <input type="checkbox" wire:model="selectedProperties" value="{{ $prop->id }}" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $prop->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedProperties') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t border-gray-100 dark:border-gray-700">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg px-4 py-2 text-sm font-medium">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

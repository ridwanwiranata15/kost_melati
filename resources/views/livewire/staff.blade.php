<div class="p-4 sm:p-6 space-y-6">

    {{-- SECTION 1: Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Manajemen Staff & Penjaga</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola role Super Admin dan Penjaga Properti (Caretaker).</p>
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
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white" placeholder="Cari staff...">
            </div>
        </div>

        {{-- Add Button --}}
        <button wire:click="openCreateModal" class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-primary-500/30 whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i> <span class="hidden sm:inline">Tambah Staff</span><span class="sm:hidden">Tambah</span>
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
    @if($isCreateModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeCreateModal"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">Tambah Staff</h3>
                    <button type="button" wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Email</label>
                            <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Role</label>
                            <select wire:model.live="role" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
    @endif

    {{-- MODAL EDIT STAFF --}}
    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-dark-card text-left shadow-xl transition-all w-full max-w-lg border border-gray-100 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">Edit Staff</h3>
                    <button type="button" wire:click="closeEditModal" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Email</label>
                            <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" wire:model="password" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase">Role</label>
                            <select wire:model.live="role" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
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
    @endif
</div>

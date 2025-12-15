<div class="p-6 space-y-6">

    {{-- SECTION 1: Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Penghuni Kost</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data penyewa, verifikasi pendaftaran, dan status aktif.</p>
        </div>
    </div>

    {{-- SECTION 2: Stats Cards (Aktif, Pending, Ditolak/Non-Aktif) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card Aktif --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penghuni Aktif</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalActive }}</h2>
                <p class="text-xs text-green-600 mt-1 font-medium">Sedang menyewa</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-500 text-xl">
                <i class="fas fa-user-check"></i>
            </div>
        </div>

        {{-- Card Pending --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalPending }}</h2>
                <p class="text-xs text-yellow-600 mt-1 font-medium">Butuh tindakan</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center text-yellow-500 text-xl">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>

        {{-- Card Ditolak / Non-Aktif --}}
        <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border-l-4 border-red-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ditolak / Non-Aktif</p>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalRejected }}</h2>
                <p class="text-xs text-red-600 mt-1 font-medium">Riwayat / Batal</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 text-xl">
                <i class="fas fa-user-times"></i>
            </div>
        </div>
    </div>

    {{-- SECTION 3: Filters & Search --}}
    <div class="bg-white dark:bg-dark-card rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between gap-4 items-center">

        {{-- Search Bar --}}
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white"
                placeholder="Cari nama, email, telepon..."
            >
        </div>

        {{-- Filter Status --}}
        <div class="w-full md:w-48">
            <select wire:model.live="filterStatus" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary-500 focus:border-primary-500 dark:text-white">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="pending">Pending</option>
                <option value="rejected">Ditolak</option>
                <option value="inactive">Non-Aktif</option>
            </select>
        </div>
    </div>

    {{-- SECTION 4: Table --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4">Profil</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">

                            {{-- Profil --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->photo)
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-600" src="{{ url('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold border border-primary-200 dark:border-primary-800">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Bergabung: {{ $user->created_at}}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kontak --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                        <i class="fas fa-envelope text-xs text-gray-400 w-4"></i> {{ $user->email }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs mt-1 flex items-center gap-2">
                                        <i class="fas fa-phone text-xs text-gray-400 w-4"></i> {{ $user->phone }}
                                    </span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @php $status = strtolower($user->status); @endphp
                                @if($status == 'active' || $status == 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                    </span>
                                @elseif($status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Pending
                                    </span>
                                @elseif($status == 'rejected' || $status == 'ditolak')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.user.detail', $user->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all border border-transparent hover:border-primary-200 dark:hover:border-primary-800"
                                   title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-users-slash text-3xl text-gray-400 dark:text-gray-600"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Data penghuni tidak ditemukan.</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Coba ubah kata kunci pencarian atau filter status.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

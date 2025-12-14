<div class="p-6">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Penghuni Kost</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Data lengkap penyewa dan tamu yang terdaftar.</p>
        </div>

        {{-- Optional: Bisa ditambah search bar di sini --}}
    </div>

    {{-- Table Card --}}
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
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">

                            {{-- Kolom Profil (Foto + Nama) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->photo)
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-600" src="{{ url('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                                        @else
                                            {{-- Default Avatar jika tidak ada foto --}}
                                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold border border-primary-200 dark:border-primary-800">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Bergabung: {{ $user->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Kontak --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                        <i class="fas fa-envelope text-xs text-gray-400"></i> {{ $user->email }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs mt-1 flex items-center gap-2">
                                        <i class="fas fa-phone text-xs text-gray-400"></i> {{ $user->phone }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-4">
                                @if(strtolower($user->status) == 'active' || strtolower($user->status) == 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                    </span>
                                @elseif(strtolower($user->status) == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.user.detail', $user->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all border border-transparent hover:border-primary-200 dark:hover:border-primary-800"
                                   title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-users-slash text-3xl text-gray-400 dark:text-gray-600"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada data penghuni.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination jika ada --}}
        {{-- <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $users->links() }}
        </div> --}}
    </div>
</div>

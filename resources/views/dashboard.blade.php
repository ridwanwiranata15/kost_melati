<x-layouts.app :title="__('Dashboard')">
   <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-dark-bg p-6">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Selamat datang kembali, berikut ringkasan kost
                        Anda hari ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                        <div
                            class="p-3 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 mr-4">
                            <i class="fas fa-bed text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Kamar</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">20 Unit</p>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                        <div
                            class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Terisi</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">15 Orang</p>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                        <div
                            class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 mr-4">
                            <i class="fas fa-door-open text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kosong</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">5 Unit</p>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                        <div
                            class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mr-4">
                            <i class="fas fa-wallet text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pendapatan Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">Rp 22.5jt</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 lg:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-white">Statistik Pendapatan (2025)</h3>
                            <button class="text-sm text-primary-500 font-medium hover:underline">Lihat Detail</button>
                        </div>
                        <div class="relative h-64 w-full">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4">Okupansi Kamar</h3>
                        <div class="relative h-48 w-full flex justify-center">
                            <canvas id="occupancyChart"></canvas>
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="flex items-center text-gray-600 dark:text-gray-400"><span
                                        class="w-3 h-3 rounded-full bg-primary-500 mr-2"></span>Terisi</span>
                                <span class="font-bold dark:text-white">75%</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="flex items-center text-gray-600 dark:text-gray-400"><span
                                        class="w-3 h-3 rounded-full bg-gray-300 mr-2"></span>Kosong</span>
                                <span class="font-bold dark:text-white">25%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 dark:text-white">Tagihan Terbaru</h3>
                        <button
                            class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-plus mr-1"></i> Tambah Tagihan
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold">
                                    <th class="px-6 py-4">Nama Penghuni</th>
                                    <th class="px-6 py-4">Kamar</th>
                                    <th class="px-6 py-4">Tanggal Jatuh Tempo</th>
                                    <th class="px-6 py-4">Jumlah</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">
                                                BS</div>
                                            Budi Santoso
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">A-101</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">15 Des 2025</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">Rp 1.500.000</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400">
                                            Lunas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-gray-400 hover:text-primary-500 transition-colors"><i
                                                class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xs">
                                                SA</div>
                                            Siti Aminah
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">B-205</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">16 Des 2025</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">Rp 2.000.000</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-gray-400 hover:text-primary-500 transition-colors"><i
                                                class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                DP</div>
                                            Dimas Pratama
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">A-102</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">10 Des 2025</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">Rp 1.500.000</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400">
                                            Telat
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-gray-400 hover:text-primary-500 transition-colors"><i
                                                class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
</x-layouts.app>

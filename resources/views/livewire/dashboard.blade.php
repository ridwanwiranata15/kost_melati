<x-layouts.app :title="__('Dashboard')">
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-dark-bg p-6">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Selamat datang kembali, berikut ringkasan kost Anda hari ini.
            </p>
        </div>

        {{-- --- CARDS --- --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            {{-- Card 1: Total Kamar --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-3 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 mr-4">
                    <i class="fas fa-bed text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Kamar</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalRooms }} Unit</p>
                </div>
            </div>

            {{-- Card 2: Penghuni (Member) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Penghuni</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalResidents }} Orang</p>
                </div>
            </div>

            {{-- Card 3: Booking Pending --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Booking Baru</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalBookings }}</p>
                </div>
            </div>

            {{-- Card 4: Total Pendapatan (Nominal) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mr-4">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Uang Masuk</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- --- CHARTS --- --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- Chart 1: Statistik Pendapatan (Bar Chart) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 dark:text-white">Statistik Pemasukan ({{ date('Y') }})</h3>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Chart 2: Keuangan (Doughnut Chart: Uang Masuk vs Hutang) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4">Status Keuangan</h3>
                <div class="relative h-48 w-full flex justify-center">
                    <canvas id="debtChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="flex items-center text-gray-600 dark:text-gray-400">
                            <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>Uang Masuk
                        </span>
                        <span class="font-bold dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="flex items-center text-gray-600 dark:text-gray-400">
                            <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>Sisa Hutang
                        </span>
                        <span class="font-bold dark:text-white">Rp {{ number_format($totalDebt, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- TABLE TRANSAKSI TERBARU --- --}}
        <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 dark:text-white">Transaksi Terbaru</h3>

            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase font-semibold">
                            <th class="px-6 py-4">Nama Penghuni</th>
                            <th class="px-6 py-4">Kamar</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Nominal (Masuk)</th>
                            <th class="px-6 py-4">Sisa Hutang</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                        @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                                <div class="flex items-center gap-3">
                                    {{-- Initials Avatar --}}
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($transaction->user->name ?? 'User', 0, 2) }}
                                    </div>
                                    {{ $transaction->user->name ?? 'Guest' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $transaction->room->number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $transaction->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-green-600">
                                Rp {{ number_format($transaction->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-red-500">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->status == 'lunas')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400">
                                        Lunas
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- --- SCRIPT UNTUK CHART --- --}}
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
    <script>
        // Data dari Livewire (PHP)
        const incomeData = @json($chartIncome);
        const totalIncome = @json($totalIncome);
        const totalDebt = @json($totalDebt);

        // --- Chart 1: Revenue (Bar) ---
        const ctxRevenue = document.getElementById('revenueChart');
        if (ctxRevenue) {
            new Chart(ctxRevenue.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pemasukan (Nominal)',
                        data: incomeData,
                        backgroundColor: '#10b981',
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Chart 2: Debt vs Income (Doughnut) ---
        const ctxDebt = document.getElementById('debtChart');
        if (ctxDebt) {
            new Chart(ctxDebt.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Uang Masuk', 'Sisa Hutang'],
                    datasets: [{
                        data: [totalIncome, totalDebt],
                        backgroundColor: ['#10b981', '#ef4444'], // Hijau & Merah
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: { legend: { display: false } }
                }
            });
        }
    </script>
    @endscript
</x-layouts.app>

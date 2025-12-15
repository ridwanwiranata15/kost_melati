@php
    use App\Models\Room;
    use App\Models\User;
    use App\Models\Booking;
    use App\Models\Transaction;
    use Illuminate\Support\Facades\DB;

    // --- 1. AMBIL DATA DARI DATABASE ---

    // A. Data Statistik Card
    $totalRooms = Room::count();
    $totalResidents = User::where('role', '!=', 'admin')->count();
    $totalBookings = Booking::where('status', 'pending')->count();
    $totalIncomeCard = Transaction::sum('nominal'); // Total semua uang masuk

    // B. Data Tabel Transaksi
    $recentTransactions = Transaction::with(['user', 'room'])->latest()->take(5)->get();

    // C. DATA KHUSUS DIAGRAM (YANG ANDA MINTA)

    // 1. Nominal (Uang Masuk) per Bulan untuk Bar Chart
    $incomePerMonth = Transaction::select(
            DB::raw('SUM(nominal) as total'),
            DB::raw('MONTH(created_at) as month')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    // Isi bulan kosong dengan 0
    $chartDataIncome = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartDataIncome[] = $incomePerMonth[$i] ?? 0;
    }

    // 2. Perbandingan Total Nominal (Masuk) vs Amount (Hutang) untuk Doughnut Chart
    $totalNominal = Transaction::sum('nominal'); // Uang Masuk
    $totalAmount  = Transaction::sum('amount');  // Sisa Hutang

@endphp

<x-layouts.app :title="__('Dashboard')">
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-dark-bg p-6">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h1>
        </div>

        {{-- Cards Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Card 1 --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Kamar</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalRooms }}</p>
            </div>
            {{-- Card 2 --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">Penghuni</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalResidents }}</p>
            </div>
            {{-- Card 3 --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">Booking Pending</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalBookings }}</p>
            </div>
            {{-- Card 4 --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Uang Masuk</p>
                <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalIncomeCard, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- --- BAGIAN DIAGRAM (CHART) --- --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- DIAGRAM 1: PENDAPATAN BULANAN (NOMINAL) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 lg:col-span-2">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4">Grafik Uang Masuk (Nominal)</h3>
                <div class="relative h-64 w-full">
                    {{-- ID ini penting: revenueChart --}}
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- DIAGRAM 2: PERBANDINGAN LUNAS VS HUTANG (AMOUNT) --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4">Uang Masuk vs Hutang</h3>
                <div class="relative h-48 w-full flex justify-center">
                    {{-- ID ini penting: debtChart --}}
                    <canvas id="debtChart"></canvas>
                </div>

                {{-- Legend Manual --}}
                <div class="mt-6 space-y-3">
                    <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                        <span class="flex items-center text-gray-600 dark:text-gray-400">
                            <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>Nominal (Masuk)
                        </span>
                        <span class="font-bold text-green-600">Rp {{ number_format($totalNominal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="flex items-center text-gray-600 dark:text-gray-400">
                            <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>Amount (Hutang)
                        </span>
                        <span class="font-bold text-red-500">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Transaksi --}}
        <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-white">Transaksi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3">Penghuni</th>
                            <th class="px-6 py-3">Nominal (Masuk)</th>
                            <th class="px-6 py-3">Amount (Hutang)</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($recentTransactions as $trx)
                        <tr>
                            <td class="px-6 py-3 font-medium dark:text-white">{{ $trx->user->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-green-600">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-red-500">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">{{ ucfirst($trx->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- --- SCRIPT CHART.JS --- --}}
    {{-- Kita load Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. DATA DARI PHP KE JS
            const incomeData = @json($chartDataIncome); // Data per bulan
            const totalNominal = {{ $totalNominal }};   // Total Uang Masuk
            const totalAmount = {{ $totalAmount }};     // Total Hutang

            // Cek apakah data kosong (untuk debugging)
            console.log("Data Income:", incomeData);
            console.log("Total Nominal:", totalNominal, "Total Hutang:", totalAmount);

            // 2. RENDER CHART BATANG (Nominal per Bulan)
            const ctxRevenue = document.getElementById('revenueChart');
            if (ctxRevenue) {
                new Chart(ctxRevenue.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Nominal (Uang Masuk)',
                            data: incomeData,
                            backgroundColor: '#10b981', // Warna Hijau
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            // 3. RENDER CHART DONAT (Nominal vs Amount)
            const ctxDebt = document.getElementById('debtChart');
            if (ctxDebt) {
                new Chart(ctxDebt.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Uang Masuk (Nominal)', 'Sisa Hutang (Amount)'],
                        datasets: [{
                            data: [totalNominal, totalAmount],
                            backgroundColor: ['#10b981', '#ef4444'], // Hijau & Merah
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%', // Membuat bolong tengah (Donut)
                        plugins: {
                            legend: { display: false }, // Kita pakai legend manual HTML di atas
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw;
                                        return ' Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.app>

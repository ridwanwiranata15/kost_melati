<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. CARD STATS
        $totalRooms = Room::count();
        // Asumsi: Penghuni adalah user dengan role 'resident' atau 'member'
        $totalResidents = User::where('role', 'member')->count();
        // Booking status pending
        $totalBookings = Booking::where('status', 'pending')->count();

        // 2. DATA TRANSAKSI TERBARU (TABLE)
        $recentTransactions = Transaction::with(['user', 'room']) // Eager load relasi
            ->latest()
            ->take(5)
            ->get();

        // 3. CHART DATA (Pendapatan Tahunan)
        // Mengambil total 'nominal' (uang masuk) per bulan di tahun ini
        $incomeData = Transaction::select(
                DB::raw('SUM(nominal) as total'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mengisi bulan yang kosong dengan 0
        $chartIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartIncome[] = $incomeData[$i] ?? 0;
        }

        // 4. CHART DATA (Perbandingan Lunas vs Hutang)
        // Uang Masuk
        $totalIncome = Transaction::sum('nominal');
        // Sisa Hutang (Sesuai request: field 'amount' dianggap sisa hutang)
        $totalDebt = Transaction::sum('amount');

        return view('livewire.dashboard', [
            'totalRooms' => $totalRooms,
            'totalResidents' => $totalResidents,
            'totalBookings' => $totalBookings,
            'recentTransactions' => $recentTransactions,
            'chartIncome' => $chartIncome,
            'totalIncome' => $totalIncome,
            'totalDebt' => $totalDebt
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. DATA CARD STATISTIK
        $totalRooms = Room::count();
        // Asumsi: Penghuni adalah user dengan role selain admin
        $totalResidents = User::where('role', '!=', 'admin')->count();
        // Booking yang statusnya pending
        $totalBookings = Booking::where('status', 'pending')->count();

        // 2. KEUANGAN (Total Masuk & Hutang)
        $totalIncome = Transaction::where('status', 'lunas')->sum('nominal');
        $totalDebt = Transaction::sum('amount'); // Asumsi kol 'amount' adalah sisa hutang

        // 3. TRANSAKSI TERBARU (5 Terakhir)
        $recentTransactions = Transaction::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // 4. CHART PENDAPATAN (Per Bulan di Tahun Ini)
        $incomeData = Transaction::select(
                DB::raw('SUM(nominal) as total'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', date('Y'))
            ->where('status', 'lunas')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mengisi bulan kosong dengan 0 agar grafik tidak bolong
        $chartIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartIncome[] = $incomeData[$i] ?? 0;
        }

        // Kirim semua data ke View
        return view('dashboard', compact(
            'totalRooms',
            'totalResidents',
            'totalBookings',
            'totalIncome',
            'totalDebt',
            'recentTransactions',
            'chartIncome'
        ));
    }
}

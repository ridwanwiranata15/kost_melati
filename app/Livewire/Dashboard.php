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
        $user = auth()->user();
        $managedPropertyIds = $user->isCaretaker() ? $user->properties()->pluck('properties.id')->toArray() : null;

        // 1. CARD STATS
        $roomsQuery = Room::query();
        if ($managedPropertyIds) $roomsQuery->whereIn('property_id', $managedPropertyIds);
        $totalRooms = $roomsQuery->count();

        // Asumsi: Penghuni adalah user dengan role 'member'
        // Untuk caretaker, mungkin hanya penghuni yang menyewa di properti mereka?
        // Tapi relasi user -> property tidak langsung lewat User table.
        // Penghuni terkait properti lewat Booking -> Room -> Property.
        $totalResidents = User::where('role', 'member');
        if ($managedPropertyIds) {
            $totalResidents->whereHas('bookings.room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }
        $totalResidents = $totalResidents->count();

        $bookingsQuery = Booking::where('status', 'pending');
        if ($managedPropertyIds) {
            $bookingsQuery->whereHas('room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }
        $totalBookings = $bookingsQuery->count();

        // 2. DATA TRANSAKSI TERBARU (TABLE)
        $transactionsQuery = Transaction::with(['user', 'room.property']);
        if ($managedPropertyIds) {
            $transactionsQuery->whereHas('room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }
        $recentTransactions = $transactionsQuery->latest()->take(5)->get();

        // 3. CHART DATA (Pendapatan Tahunan)
        $incomeQuery = Transaction::select(
                DB::raw('SUM(nominal) as total'),
                DB::raw('MONTH(transactions.created_at) as month')
            );
        if ($managedPropertyIds) {
            $incomeQuery->whereHas('room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }
        $incomeData = $incomeQuery->whereYear('transactions.created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $chartIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartIncome[] = $incomeData[$i] ?? 0;
        }

        // 4. CHART DATA (Perbandingan Lunas vs Hutang)
        $incomeSumQuery = Transaction::query();
        $debtSumQuery = Transaction::query();
        if ($managedPropertyIds) {
            $incomeSumQuery->whereHas('room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
            $debtSumQuery->whereHas('room', function($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }
        $totalIncome = $incomeSumQuery->sum('nominal');
        $totalDebt = $debtSumQuery->sum('amount');

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

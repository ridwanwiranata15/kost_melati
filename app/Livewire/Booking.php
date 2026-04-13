<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking as BookingModel;
use Livewire\WithPagination;

class Booking extends Component
{
    use WithPagination;
    public $search = '';
    public $filterStatus;

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updateStatus($id, $status)
    {
        // 1. Cari data booking
        $booking = BookingModel::find($id);

        if ($booking) {
            // 2. Update status booking
            $booking->status = $status;
            $booking->save();

            // 3. REVISI: Cek jika status 'confirmed' atau 'checkin'
            if (in_array($status, ['confirmed', 'checkin'])) {

                // Cek dulu biar tidak duplikat (misal admin klik confirmed 2x)
                // Jika belum ada transaksi untuk booking ini, baru buat
                $cekTransaksi = \App\Models\Transaction::where('booking_id', $booking->id)->exists();

                if (!$cekTransaksi) {
                    // Ambil durasi (asumsi integer, misal: 3 ,bulan)
                    $duration = (int) $booking->duration;

                    // Loop sebanyak durasi
                    for ($i = 0; $i < $duration; $i++) {

                        \App\Models\Transaction::create([
                            'booking_id' => $booking->id,
                            'user_id' => $booking->user_id,
                            'room_id' => $booking->room_id,
                            'payment_method' => 'transfer',
                            'payment_receipt' => null,
                            'date_pay' => null,
                            'nominal' => (int) ($booking->price ?? 0),
                            'amount' => 500000,
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            // 4. Kirim pesan sukses
            session()->flash('message', "Status booking #{$booking->booking_code} berhasil diubah menjadi {$status} dan tagihan telah dibuat.");
        }
    }

    public function render()
    {
        $user = auth()->user();
        $managedPropertyIds = $user->isCaretaker() ? $user->properties()->pluck('properties.id')->toArray() : null;

        // 1. Query Data
        $query = BookingModel::with(['user', 'room.property']);

        // Role-based filtering
        if ($managedPropertyIds) {
            $query->whereHas('room', function ($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }

        // Search Logic
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filter Status Logic
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $bookings = $query->latest()->paginate(10);

        // 2. Hitung Statistik untuk 5 Card
        $statsQuery = BookingModel::query();
        if ($managedPropertyIds) {
            $statsQuery->whereHas('room', function ($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }

        $stats = [
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'confirmed' => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'checkin' => (clone $statsQuery)->where('status', 'checkin')->count(),
            'checkout' => (clone $statsQuery)->where('status', 'checkout')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        return view('livewire.booking', compact('bookings', 'stats'));
    }
}

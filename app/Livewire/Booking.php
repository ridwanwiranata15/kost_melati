<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking as BookingModel;
use Livewire\WithPagination;

class Booking extends Component
{
    use WithPagination;
    public $search;
    public $filterStatus;

    public function updatedSearch(){$this->resetPage();}
    public function updatedFilterStatus(){$this->resetPage();}

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
                        'booking_id'      => $booking->id,
                        'payment_method'  => 'transfer', // Nullable sesuai request
                        'payment_receipt' => null, // Nullable sesuai request
                        'date_pay' => null,
                        'nominal' => null,
                        'amount'          => 500000,

                        'status'          => 'pending', // Default status transaksi
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
        // 1. Query Data
        $query = BookingModel::with(['user', 'room']); // Eager load relasi biar ringan

        // Search Logic (Cari kode booking atau nama user)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($u) {
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
        $stats = [
            'pending'   => BookingModel::where('status', 'pending')->count(),
            'confirmed' => BookingModel::where('status', 'confirmed')->count(),
            'checkin'   => BookingModel::where('status', 'checkin')->count(),
            'checkout'  => BookingModel::where('status', 'checkout')->count(),
            'cancelled' => BookingModel::where('status', 'cancelled')->count(),
        ];

        return view('livewire.booking', compact('bookings', 'stats'));
    }
}

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
        $booking = BookingModel::with('room')->find($id);

        if ($booking) {
            // 2. Update status booking
            $booking->status = $status;
            $booking->save();

            // Siapkan kerangka pesan notifikasi
            $message = "Status booking #{$booking->booking_code} berhasil diubah menjadi " . strtoupper($status) . ".";

            // 3. LOGIKA BERDASARKAN STATUS

            // A. Jika status disetujui atau sudah masuk (Confirmed / Checkin)
            if (in_array($status, ['confirmed', 'checkin'])) {

                // Cek apakah transaksi sudah pernah dibuat
                $cekTransaksi = \App\Models\Transaction::where('booking_id', $booking->id)->exists();

                if (!$cekTransaksi) {
                    $duration = (int) $booking->duration;

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
                    $message .= " Tagihan untuk {$duration} bulan berhasil di-generate.";
                }

                // Pastikan kamar tetap 'unavailable' (terisi)
                if ($booking->room) {
                    $booking->room->update(['status' => 'unavailable']);
                }
            }

            // B. Jika Booking Dibatalkan (Cancelled) atau Selesai (Checkout)
            elseif (in_array($status, ['cancelled', 'checkout'])) {

                // 1. Kembalikan status kamar menjadi tersedia
                if ($booking->room) {
                    $booking->room->update(['status' => 'available']);
                    $message .= " Kamar sekarang kembali Tersedia.";
                }

                // 2. KHUSUS CANCELLED: Hapus tagihan yang masih 'pending' agar tidak menumpuk
                if ($status === 'cancelled') {
                    $deletedBills = \App\Models\Transaction::where('booking_id', $booking->id)
                        ->where('status', 'pending')
                        ->delete();

                    if ($deletedBills > 0) {
                        $message .= " Dan {$deletedBills} tagihan yang belum dibayar telah dihapus otomatis.";
                    }
                }
            }

            // 4. Kirim pesan sukses yang sudah disesuaikan
            session()->flash('message', $message);
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

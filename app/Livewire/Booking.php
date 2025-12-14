<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking as BookingModel;

class Booking extends Component
{
    public function render()
    {
        $bookings = BookingModel::all();
        return view('livewire.booking', compact('bookings'));
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
                        'booking_id'      => $booking->id,
                        'payment_method'  => 'transafer', // Nullable sesuai request
                        'payment_receipt' => null, // Nullable sesuai request
                        'date_pay' => null,

                        // WARNING: Pastikan logika ini benar.
                        // Jika total_amount adalah total 3 bulan, dan kamu meloop 3x,
                        // maka user akan tertagih 3x lipat.
                        // Jika ingin tagihan per bulan, harusnya: $booking->total_amount / $duration
                        'amount'          => $booking->total_amount,

                        'status'          => 'pending', // Default status transaksi
                    ]);
                }
            }
        }

        // 4. Kirim pesan sukses
        session()->flash('message', "Status booking #{$booking->booking_code} berhasil diubah menjadi {$status} dan tagihan telah dibuat.");
    }
}
}

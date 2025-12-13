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
        $booking = BookingModel::find($id);

        if ($booking) {
            $booking->status = $status;
            $booking->save();

            // Kirim pesan sukses
            session()->flash('message', "Status booking #{$booking->booking_code} berhasil diubah menjadi {$status}.");
        }
    }
}

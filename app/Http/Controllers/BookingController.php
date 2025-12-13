<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function checkout(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'choose_month' => 'required|in:3,6,12',
    ]);

    $roomId = $request->room_id;
    $duration = $request->choose_month;

    $room = Room::findOrFail($roomId);
    return view('customer.booking', compact('room', 'duration'));
}

public function booking(Request $request){
    // 1. Validasi Input (Wajib ada biar aman)
    $request->validate([
        "room_id"  => "required",
        "duration" => "required|numeric",
        "date_in"  => "required|date",
    ]);

    // 2. Hitung tanggal keluar otomatis (biar akurat)
    // Asumsi durasi adalah BULAN. Jika hari, ganti addMonths ke addDays
    $dateIn  =$request->date_in;
    $dateOut = $request->date_out;

    // 3. Create Data
    $booking = Booking::create([
        "booking_code" => "KOS-" . strtoupper(Str::random(10)), // Pakai Str::random
        "user_id"      => Auth::id(),
        "room_id"      => $request->room_id,
        "duration"     => $request->duration,
        "date_in"      => $dateIn,
        "date_out"     => $dateOut,

        // SESUAI REQUEST: Harga 500 dikali durasi
        "total_amount" => 500000 * $request->duration,

        "status"       => "pending" // Status default biasanya pending dulu
    ]);

    if($booking){
        return redirect()->route('home')->with('success', "Kamar berhasil di booking");
    } else {
        return redirect()->back()->with('error', "Gagal booking");
    }
}
}

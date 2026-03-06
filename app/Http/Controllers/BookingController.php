<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk transaction
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'choose_month' => 'required|in:3,6,12', // Validasi durasi yang diizinkan
        ]);

        $room = Room::findOrFail($request->room_id);

        // Cek apakah kamar masih tersedia sebelum masuk halaman checkout
        if ($room->status !== 'available') {
            return redirect()->back()->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
        }

        $duration = $request->choose_month;

        return view('customer.booking', compact('room', 'duration'));
    }

    public function booking(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            "room_id"  => "required|exists:rooms,id",
            "duration" => "required|numeric|min:1",
            "date_in"  => "required|date|after_or_equal:today", // Tanggal masuk tidak boleh masa lalu
        ]);

        try {
            // Gunakan Transaction agar aman (jika gagal, semua dibatalkan)
            DB::transaction(function () use ($request) {
                
                // Ambil data kamar terbaru
                // lockForUpdate() berguna mencegah race condition saat traffic tinggi
                $room = Room::where('id', $request->room_id)->lockForUpdate()->first();

                // Cek Validasi Ketersediaan Terakhir (PENTING)
                if ($room->status !== 'available') {
                    throw new \Exception("Maaf, kamar ini baru saja dibooking orang lain.");
                }

               
                // Asumsi di table rooms ada kolom 'price' (harga per bulan)
                // Jika flat 500rb, ganti $room->price dengan 500000
                $totalAmount = $room->price * $request->duration; 

                // 3. Create Data Booking
                Booking::create([
                    "booking_code" => "KOS-" . strtoupper(Str::random(10)),
                    "user_id"      => Auth::id(),
                    "room_id"      => $room->id,
                    "duration"     => $request->duration,
                    "date_in"      => $request->date_in,
                    "date_out"     => $request->date_out,
                    "total_amount" => $totalAmount,
                    "status"       => "pending"
                ]);

                // 4. Update Status Kamar
                // Status pending booking biasanya membuat kamar jadi 'booked' atau 'unavailable'
                // tergantung flow bisnis Anda (langsung kunci kamar atau tunggu bayar dulu)
                $room->update(['status' => 'unavailable']);
            });

            // Jika tidak ada error di dalam transaction, return success
            return redirect()->route('home')->with('success', "Kamar berhasil di-booking! Silakan lakukan pembayaran.");

        } catch (\Exception $e) {
            // Jika ada error (misal kamar sudah penuh duluan), kembalikan user
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
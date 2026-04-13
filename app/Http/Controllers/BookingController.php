<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            "room_id" => ["required", "exists:rooms,id"],
            "duration" => ["required", "integer", "in:3,6,12"],
            "date_in" => ["required", "date", "after:today"],
        ]);

        if ($validator->fails()) {
            return redirect()->route('home')->with('error', 'Tanggal mulai ngekos tidak valid (Minimal harus besok hari). Silakan ulangi pemesanan.');
        }

        try {
            $room = Room::findOrFail($request->room_id);

            $duration = (int) $request->duration;

            $dateIn = Carbon::parse($request->date_in);
            $dateOut = $dateIn->copy()->addMonths($duration);

            $totalAmount = $room->price * $duration;

            if ($room->status !== 'available') {
                return redirect()->route('home')->with('error', 'Kamar sudah tidak tersedia.');
            }
            $roomId = $request->room_id;

            DB::transaction(function () use ($roomId, $duration, $dateIn, $dateOut, $totalAmount) {

                $room = Room::where('id', $roomId)->lockForUpdate()->firstOrFail();

                if ($room->status !== 'available') {
                    throw new \Exception("Maaf, kamar ini baru saja dibooking orang lain.");
                }

                Booking::create([
                    "booking_code" => "KOS-" . strtoupper(Str::random(10)),
                    "user_id" => Auth::id(),
                    "room_id" => $room->id,
                    "duration" => $duration,
                    "date_in" => $dateIn,
                    "date_out" => $dateOut,
                    "total_amount" => $totalAmount,
                    "status" => "pending"
                ]);

                $room->update(['status' => 'unavailable']);
            });

            $admin = User::where('role', 'admin')->first();

            return redirect()
                ->route('home')
                ->with('alert', [
                    'type' => 'success',
                    'title' => 'Booking Berhasil 🎉',
                    'message' => 'Booking kamu sedang menunggu verifikasi admin.',
                    'confirmText' => 'Cek Status',
                    'redirect' => '/profile',
                ])
                ->with('admin_phone', $admin?->phone);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }
}

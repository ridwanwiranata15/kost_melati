<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    private const MONTHLY_PRICE = 500000;

    public function checkout(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'choose_month' => 'required|in:3,6,12',
        ]);

        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'available') {
            return redirect()->back()->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
        }

        $duration = (int) $request->choose_month;

        return view('customer.booking', compact('room', 'duration'));
    }

    public function booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => ['required', 'exists:rooms,id'],
            'duration' => ['required', 'integer', 'in:3,6,12'],
            'date_in' => ['required', 'date', 'after:today'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('home')
                ->with('error', 'Tanggal mulai ngekos tidak valid. Minimal mulai besok hari.');
        }

        try {
            $roomId = (int) $request->room_id;
            $duration = (int) $request->duration;
            $dateIn = Carbon::parse($request->date_in)->startOfDay();
            $dateOut = $dateIn->copy()->addMonths($duration)->startOfDay();
            $monthlyPrice = self::MONTHLY_PRICE;
            $totalAmount = $monthlyPrice * $duration;

            DB::transaction(function () use ($roomId, $duration, $dateIn, $dateOut, $monthlyPrice, $totalAmount) {
                $room = Room::where('id', $roomId)->lockForUpdate()->firstOrFail();

                if ($room->status !== 'available') {
                    throw new \Exception('Maaf, kamar ini baru saja dibooking orang lain.');
                }

                Booking::create([
                    'user_id' => auth()->id(),
                    'room_id' => $room->id,
                    'booking_code' => 'KOS-' . strtoupper(Str::random(10)),
                    'date_in' => $dateIn->toDateString(),
                    'date_out' => $dateOut->toDateString(),
                    'duration' => $duration,
                    'price' => $monthlyPrice,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                $room->update([
                    'status' => 'unavailable',
                ]);
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

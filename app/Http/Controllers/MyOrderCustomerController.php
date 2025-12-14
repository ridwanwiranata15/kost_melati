<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;     // Sesuaikan nama model Booking Anda
use App\Models\Transaction; // Sesuaikan nama model Transaction Anda
use Illuminate\Support\Facades\Storage;

class MyOrderCustomerController extends Controller
{
    public function index()
    {
        // 1. Ambil User ID yang sedang login
        $userId = Auth::id();

        // 2. Cari Booking berdasarkan user_id
        // Kita gunakan 'with' untuk mengambil relasi 'transactions' dan 'room' sekaligus (Eager Loading)
        // ->latest() digunakan untuk mengambil booking paling baru jika user punya history lama
        $booking = Booking::with(['transactions', 'room'])
                    ->where('user_id', $userId)
                    ->latest()
                    ->first();

        // 3. Ambil Transaksi
        // Jika booking ditemukan, ambil transaksinya. Jika tidak, buat collection kosong biar gak error di view
        $transactions = $booking ? $booking->transactions : collect([]);

        // Kirim data ke view
        return view('customer.my-order', compact('booking', 'transactions'));
    }
    public function payment($id){
        $transaction = Transaction::findOrFail($id);
        return view('customer.upload_payment', compact('transaction'));
    }


public function paynow(Request $request, $id)
{
    // 1. VALIDASI
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    // 2. CARI TRANSAKSI
    $transaction = Transaction::findOrFail($id);

    // 3. SIMPAN FILE
    $folder = 'payment-receipts';
    $imagePath = $request->file('image')->store($folder, 'public');

    // 4. HAPUS FILE LAMA
    if ($transaction->payment_receipt && Storage::disk('public')->exists($transaction->payment_receipt)) {
        Storage::disk('public')->delete($transaction->payment_receipt);
    }

    // 5. UPDATE DATA (STATUS HARUS SESUAI ENUM)
    $transaction->update([
        'payment_receipt' => $imagePath,
        'status' => 'pending',
        'date_pay' => now()
    ]);

    return redirect()->route('customer.testimonial');

}

}

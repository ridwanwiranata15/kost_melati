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
    // 1. CARI TRANSAKSI
    $transaction = Transaction::findOrFail($id);

    // 2. INISIALISASI VARIABEL IMAGE (PENTING!)
    // Kita set defaultnya pakai gambar yang sudah ada di database.
    // Jadi kalau pilih 'cash' (gak upload gambar), dia pakai data lama atau null, gak error.
    $imagePath = $transaction->payment_receipt;

    // 3. LOGIKA KHUSUS TRANSFER (HANDLE GAMBAR)
    if ($request->payment_method == 'transfer') {
        // Cek apakah user benar-benar upload file
        if ($request->hasFile('image')) {
            $folder = 'payment-receipts';

            // Simpan gambar baru
            $newImage = $request->file('image')->store($folder, 'public');

            // Hapus gambar lama jika ada (biar server gak penuh sampah file)
            if ($transaction->payment_receipt && Storage::disk('public')->exists($transaction->payment_receipt)) {
                Storage::disk('public')->delete($transaction->payment_receipt);
            }

            // Update variabel imagePath dengan yang baru
            $imagePath = $newImage;
        }
    }
    // Opsi: Jika logic bisnis mengharuskan kalau Cash gambarnya dihapus/dikosongkan,
    // uncomment baris di bawah ini:
    // else if ($request->payment_method == 'cash') {
    //      $imagePath = null;
    // }

    // 4. UPDATE DATA
    $transaction->update([
        'payment_receipt' => $imagePath, // Aman sekarang, terisi file baru (transfer) atau file lama/null (cash)
        'status'          => 'pending',
        'date_pay'        => now(),
        'payment_method'  => $request->payment_method,
        'nominal'         => $request->note // Nominal masuk baik itu cash maupun transfer
    ]);

    return redirect()->route('customer.testimonial');
}

}

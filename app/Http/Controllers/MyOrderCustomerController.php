<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;     // Sesuaikan nama model Booking Anda
use App\Models\Transaction; // Sesuaikan nama model Transaction Anda
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class MyOrderCustomerController extends Controller
{
public function index()
{
    $userId = Auth::id();

    // 1. Ambil Booking
    $booking = Booking::with(['transactions', 'room'])
                ->where('user_id', $userId)
                ->latest()
                ->first();

    // 2. Ambil Transaksi (agar tidak error undefined variable)
    $transactions = $booking ? $booking->transactions : collect([]);

    $tagihanList = collect([]);

    // 3. LOGIKA BARU: Loop berdasarkan DURASI (bukan tanggal)
    if ($booking) {
        $startDate = \Carbon\Carbon::parse($booking->date_in);

        // Ambil durasi (default 1 bulan jika kosong/nol)
        $durasi = $booking->duration > 0 ? $booking->duration : 1;

        // Loop sebanyak durasi sewa
        for ($i = 0; $i < $durasi; $i++) {

            // Hitung bulan ke-i
            $date = $startDate->copy()->addMonths($i);

            // Ambil transaksi yang sesuai urutan (jika ada)
            $transaction = $transactions->get($i);

            $tagihanList->push([
                'bulan'       => $date->translatedFormat('F Y'),
                'jatuh_tempo' => $date->copy()->addDays(9)->translatedFormat('d F Y'), // Jatuh tempo tgl 10
                'transaction' => $transaction,
                'status'      => $transaction ? $transaction->status : 'pending',
                'nominal'     => $transaction ? $transaction->nominal : ($booking->total_amount / $durasi),
            ]);
        }
    }

    return view('customer.my-order', compact('booking', 'transactions', 'tagihanList'));
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

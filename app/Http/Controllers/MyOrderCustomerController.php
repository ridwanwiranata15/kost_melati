<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;     // Sesuaikan nama model Booking Anda
use App\Models\Transaction; // Sesuaikan nama model Transaction Anda
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            $startDate = Carbon::parse($booking->date_in);

            // Ambil durasi (default 1 bulan jika kosong/nol)
            $durasi = $booking->duration > 0 ? $booking->duration : 1;

            // Loop sebanyak durasi sewa
            for ($i = 0; $i < $durasi; $i++) {

                // Hitung bulan ke-i
                $date = $startDate->copy()->addMonths($i);

                // Ambil transaksi yang sesuai urutan (jika ada)
                $transaction = $transactions->get($i);

                $tagihanList->push([
                    'bulan' => $date->translatedFormat('F Y'),
                    'jatuh_tempo' => $date->copy()->addDays(9)->translatedFormat('d F Y'), // Jatuh tempo tgl 10
                    'transaction' => $transaction,
                    'status' => $transaction ? $transaction->status : 'pending',
                    'nominal' => $transaction ? $transaction->nominal : ($booking->total_amount / $durasi),
                ]);
            }
        }

        return view('customer.my-order', compact('booking', 'transactions', 'tagihanList'));
    }
    public function payment($id)
    {
        // FIX SECURITY: Cek kepemilikan user melalui relasi 'booking'
        $transaction = Transaction::where('id', $id)
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('customer.upload_payment', compact('transaction'));
    }
    public function paynow(Request $request, $id)
    {
        // 1. VALIDASI INPUT (Keamanan Tambahan)
        // Pastikan file yang diupload benar-benar gambar, bukan file jahat (.exe, .php)
        $request->validate([
            'payment_method' => 'required|in:transfer,cash',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|string'
        ]);

        // 2. CARI TRANSAKSI & FIX SECURITY
        $transaction = Transaction::where('id', $id)
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        // 3. INISIALISASI VARIABEL IMAGE
        $imagePath = $transaction->payment_receipt;
        $pesanSukses = ''; // Siapkan variabel untuk pesan UX

        // 4. LOGIKA METODE PEMBAYARAN & PESAN UX
        if ($request->payment_method == 'transfer') {
            if ($request->hasFile('image')) {
                $folder = 'payment-receipts';
                $newImage = $request->file('image')->store($folder, 'public');

                if ($transaction->payment_receipt && Storage::disk('public')->exists($transaction->payment_receipt)) {
                    Storage::disk('public')->delete($transaction->payment_receipt);
                }
                $imagePath = $newImage;
            }

            // Pesan jika Transfer
            $pesanSukses = 'Bukti transfer berhasil diunggah! Silakan tunggu verifikasi Admin maksimal 1x24 jam.';

        } else if ($request->payment_method == 'cash') {
            // Opsi: Jika logic mengharuskan kalau Cash gambarnya dihapus (Opsional)
            // $imagePath = null;

            // Pesan jika Cash
            $pesanSukses = 'Konfirmasi bayar tunai terkirim! Segera serahkan uang kepada Penjaga/Admin agar tagihan dapat diverifikasi.';
        }

        // 5. UPDATE DATA TRANSAKSI
        $updateData = [
            'payment_receipt' => $imagePath,
            'status' => 'pending',
            'date_pay' => now(),
            'payment_method' => $request->payment_method,
            // Nominal tidak diubah dengan text 'note', biarkan mengikuti nilai awal atau update sesuai amount
            'nominal' => $transaction->amount,
        ];

        // Jika Anda punya kolom 'note' di tabel transactions, tambahkan ini:
        // 'note' => $request->note

        $transaction->update($updateData);

        return redirect()->route('customer.testimonial')->with('payment_success', $pesanSukses);
    }
}

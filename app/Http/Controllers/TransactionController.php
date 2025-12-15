<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
//     public function invoice($id)
// {
//     $transaction = Transaction::find($id);

//     $providerName = "Haramain Kost Residence";
//     $data = ["transaction" => $transaction, "providerName" => $providerName];
//     $pdf = Pdf::loadView('customer.invoice', $data);
//     $pdf->setPaper('a4', 'potrait');
//     return $pdf->stream('invoice-booking-' . $transaction->id . '.pdf');
// }



public function invoice($id)
{
    // Cari Data Transaksi berdasarkan ID yang diklik
    // Load relasi ke booking, room, dan user
    $transaksi = Transaction::findOrFail($id);

    // Ambil data pendukung
    $booking = $transaksi->booking;
    $kamar = $booking->room;

    // --- LOGIKA SIMPEL ---
    $hargaKamar = $transaksi->amount; // Kolom 'nominal' di DB kamu (misal 500.000)
    $tagihanBulanIni =$transaksi->nominal;  // Uang yang dibayarkan (misal 500.000 atau 1.500.000)

    // Hitung lama inap berdasarkan uang yang dibayar dibagi harga kamar
    // Contoh: Bayar 1.5jt / Harga 500rb = 3 Bulan. Jika 0, default 1.
    $lamaInap = $booking->duration;

    $providerName = "Haramain Kost Residence";

    $data = [
        'transaksi' => $transaksi,
        'booking' => $booking,
        'kamar' => $kamar,
        'providerName' => $providerName,
        'hargaKamar' => $hargaKamar,
        'lamaInap' => $lamaInap,
        'tagihanBulanIni' => $tagihanBulanIni,
    ];

    $pdf = Pdf::loadView('customer.invoice', $data);
   $pdf->setPaper('a4', 'portrait');

    return $pdf->stream('Kwitansi-Trx-' . $transaksi->id . '.pdf');
}
}

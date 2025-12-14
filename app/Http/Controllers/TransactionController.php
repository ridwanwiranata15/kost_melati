<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function invoice($id)
{
    // Tambahkan withTrashed() pada query booking agar data yang sudah dihapus tetap muncul
    $transaction = Transaction::with([
        'bookings' => function($query) {
            $query->withTrashed(); // Load bookings meskipun sudah dihapus (soft delete)
        },
        'bookings.room',
        'bookings.user'
    ])->findOrFail($id);

    $providerName = "Haramain Kost Residence";

    return view('customer.invoice', compact('transaction', 'providerName'));
}
}

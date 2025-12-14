<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "booking_id",
        "payment_method",
        "amount",
        "payment_receipt",
        "status",
        "date_pay",
        "nominal",

    ];

    public function bookings(){
        return $this->belongsTo(Booking::class, 'id');
    }
}

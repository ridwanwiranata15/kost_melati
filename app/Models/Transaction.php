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

    protected $casts = [
        'nominal' => 'integer',
        'amount' => 'integer',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getNominalFormattedAttribute()
    {
        return number_format((float) ($this->nominal ?? 0), 0, ',', '.');
    }

    public function getAmountFormattedAttribute()
    {
        return number_format((float) ($this->amount ?? 0), 0, ',', '.');
    }
}

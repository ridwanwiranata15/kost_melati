<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'room_id',
        'payment_method',
        'payment_receipt',
        'amount',
        'nominal',
        'due_date',
        'date_pay',
        'status',
        'h7_reminded_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'nominal' => 'integer',
            'due_date' => 'date',
            'date_pay' => 'date',
            'h7_reminded_at' => 'datetime',
            'status' => TransactionStatus::class,
        ];
    }

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

<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'room_id',
        'booking_code',
        'date_in',
        'date_out',
        'duration',
        'price',
        'total_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_in' => 'date',
            'date_out' => 'date',
            'duration' => 'integer',
            'price' => 'integer',
            'total_amount' => 'integer',
            'status' => BookingStatus::class,
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id');
    }

    // Relasi: 1 Booking milik 1 Room (Kamar)
    // Penting buat nampilin data "Anggana Parahyangan Golf" dsb di view
    public function room()
    {
        return $this->belongsTo(Room::class); // Sesuaikan nama model Room/Kamar
    }
}

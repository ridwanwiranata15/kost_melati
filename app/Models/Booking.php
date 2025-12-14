<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [

        "booking_code",
        "user_id",
        "room_id",
        "duration",
        "date_in",
        "date_out",
        "total_amount",
        "status"
    ];

    public function user(){
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

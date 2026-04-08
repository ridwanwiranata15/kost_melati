<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        "property_id",
        "room_number",
        "name",
        "status",
        "facility",
        "image",
        "description"
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

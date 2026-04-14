<?php

namespace App\Enums;

enum BookingStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CHECKIN = 'checkin';
    case CHECKOUT = 'checkout';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Dikonfirmasi',
            self::CHECKIN => 'Check-in',
            self::CHECKOUT => 'Check-out',
            self::CANCELLED => 'Dibatalkan',
        };
    }
}

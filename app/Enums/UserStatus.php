<?php

namespace App\Enums;

enum UserStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::ACTIVE => 'Aktif',
            self::REJECTED => 'Ditolak',
        };
    }
}

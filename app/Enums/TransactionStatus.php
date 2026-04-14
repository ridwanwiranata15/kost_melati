<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Disetujui',
            self::REJECTED => 'Ditolak',
        };
    }
}

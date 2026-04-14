<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CARETAKER = 'caretaker';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::CARETAKER => 'Penjaga',
            self::CUSTOMER => 'Customer',
        };
    }
}

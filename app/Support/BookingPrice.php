<?php

namespace App\Support;

use InvalidArgumentException;

final class BookingPrice
{
    public const MONTHLY_PRICE = 500000;
    public const ANNUAL_PRICE = 5000000;

    private const ALLOWED_DURATIONS = [3, 6, 12];

    public static function allowedDurations(): array
    {
        return self::ALLOWED_DURATIONS;
    }

    public static function monthlyPrice(): int
    {
        return self::MONTHLY_PRICE;
    }

    public static function totalAmountForDuration(int $duration): int
    {
        return match ($duration) {
            3, 6 => self::MONTHLY_PRICE * $duration,
            12 => self::ANNUAL_PRICE,
            default => throw new InvalidArgumentException('Durasi sewa tidak valid.'),
        };
    }

    public static function normalAmountForDuration(int $duration): int
    {
        self::ensureAllowedDuration($duration);

        return self::MONTHLY_PRICE * $duration;
    }

    public static function savingForDuration(int $duration): int
    {
        return max(
            0,
            self::normalAmountForDuration($duration) - self::totalAmountForDuration($duration)
        );
    }

    public static function hasSaving(int $duration): bool
    {
        return self::savingForDuration($duration) > 0;
    }

    public static function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function formatCompactRupiah(int $amount, bool $withPrefix = false): string
    {
        $prefix = $withPrefix ? 'Rp ' : '';

        if ($amount >= 1000000) {
            $value = $amount / 1000000;

            return $prefix . (floor($value) == $value
                ? number_format($value, 0, ',', '.')
                : number_format($value, 1, ',', '.')) . ' Jt';
        }

        if ($amount >= 1000) {
            $value = $amount / 1000;

            return $prefix . (floor($value) == $value
                ? number_format($value, 0, ',', '.')
                : number_format($value, 1, ',', '.')) . ' Rb';
        }

        return $prefix . number_format($amount, 0, ',', '.');
    }

    public static function packageLabel(int $duration): string
    {
        return match ($duration) {
            3 => '3 Bulan',
            6 => '6 Bulan',
            12 => '12 Bulan / 1 Tahun',
            default => throw new InvalidArgumentException('Durasi sewa tidak valid.'),
        };
    }

    private static function ensureAllowedDuration(int $duration): void
    {
        if (! in_array($duration, self::ALLOWED_DURATIONS, true)) {
            throw new InvalidArgumentException('Durasi sewa tidak valid.');
        }
    }
}

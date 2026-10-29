<?php

declare(strict_types=1);

namespace App\Support;

class Money
{
    public static function format(int|float $amount): string
    {
        $rounded = (int) round((float) $amount);

        return 'Rp'.number_format($rounded, 0, ',', '.');
    }
}

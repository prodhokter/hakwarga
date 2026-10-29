<?php

declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

class NikHasher
{
    public function hash(string $nik): string
    {
        $normalized = trim($nik);

        if (! preg_match('/^\d{16}$/', $normalized)) {
            throw new InvalidArgumentException('NIK must be exactly 16 numeric digits.');
        }

        /** @var string $pepper */
        $pepper = config('hakwarga.nik_pepper', '');

        return hash_hmac('sha256', $normalized, $pepper);
    }
}

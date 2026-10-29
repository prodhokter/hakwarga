<?php

declare(strict_types=1);

namespace App\Services;

class PiiMasker
{
    public function mask(string $text): string
    {
        // 1. Mask 16 numeric digits (NIK patterns)
        $masked = (string) preg_replace('/\b\d{16}\b/', '[NIK DISAMARKAN]', $text);

        // 2. Mask Indonesian phone number patterns (e.g. 081234567890 or +6281234567890)
        return (string) preg_replace('/\b(?:\+?62|08)\d{8,12}\b/', '[NOMOR TELEPON DISAMARKAN]', $masked);
    }
}

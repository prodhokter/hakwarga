<?php

declare(strict_types=1);

namespace App\Enums;

enum RegionLevel: int
{
    case Province = 1;
    case Regency = 2;
    case District = 3;
    case Village = 4;

    public function label(): string
    {
        return match ($this) {
            self::Province => 'Provinsi',
            self::Regency => 'Kabupaten / Kota',
            self::District => 'Kecamatan',
            self::Village => 'Desa / Kelurahan',
        };
    }
}

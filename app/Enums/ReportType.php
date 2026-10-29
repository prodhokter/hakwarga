<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportType: string
{
    case Extortion = 'extortion';
    case Dispute = 'dispute';

    public function label(): string
    {
        return match ($this) {
            self::Extortion => 'Lapor Pungutan Liar & Pemotongan',
            self::Dispute => 'Sanggah Kelayakan Penerima',
        };
    }
}

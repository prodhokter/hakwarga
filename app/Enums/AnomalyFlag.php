<?php

declare(strict_types=1);

namespace App\Enums;

enum AnomalyFlag: string
{
    case UnderCoverage = 'under_coverage';
    case OverCoverage = 'over_coverage';
    case Normal = 'normal';

    public function label(): string
    {
        return match ($this) {
            self::UnderCoverage => 'Potensi Defisit Kuota (Under-Coverage)',
            self::OverCoverage => 'Potensi Kelebihan Kuota (Over-Coverage)',
            self::Normal => 'Alokasi Proporsional (Normal)',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::UnderCoverage => 'bg-amber-100 text-amber-900 border-amber-300',
            self::OverCoverage => 'bg-indigo-100 text-indigo-900 border-indigo-300',
            self::Normal => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        };
    }
}

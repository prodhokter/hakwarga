<?php

declare(strict_types=1);

namespace App\Enums;

enum DisputeCategory: string
{
    case NotEligible = 'not_eligible';
    case Duplicate = 'duplicate';
    case DeceasedOrMoved = 'deceased_or_moved';
    case EligibleButOmitted = 'eligible_but_omitted';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::NotEligible => 'Penerima Tergolong Mampu (Salah Sasaran)',
            self::Duplicate => 'Penerima Ganda dalam Satu KK',
            self::DeceasedOrMoved => 'Penerima Meninggal Dunia / Pindah Alamat',
            self::EligibleButOmitted => 'Warga Sangat Miskin Terlewat dari Kuota',
            self::Other => 'Alasan Sanggah Lainnya',
        };
    }
}

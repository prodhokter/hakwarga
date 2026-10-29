<?php

declare(strict_types=1);

namespace App\Enums;

enum EligibilityStatus: string
{
    case Eligible = 'eligible';
    case UnderReview = 'under_review';
    case Disputed = 'disputed';
    case Removed = 'removed';

    public function label(): string
    {
        return match ($this) {
            self::Eligible => 'Layak',
            self::UnderReview => 'Dalam Telaah',
            self::Disputed => 'Disanggah',
            self::Removed => 'Dicabut',
        };
    }
}

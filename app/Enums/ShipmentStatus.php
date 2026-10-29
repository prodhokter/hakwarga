<?php

declare(strict_types=1);

namespace App\Enums;

enum ShipmentStatus: string
{
    case DataCollected = 'data_collected';
    case EligibilityVerified = 'eligibility_verified';
    case Scheduled = 'scheduled';
    case InDelivery = 'in_delivery';
    case ReceivedAtPoint = 'received_at_point';

    public function label(): string
    {
        return match ($this) {
            self::DataCollected => 'Pendataan Warga',
            self::EligibilityVerified => 'Verifikasi Kelayakan',
            self::Scheduled => 'Penjadwalan Penyaluran',
            self::InDelivery => 'Dalam Pengiriman',
            self::ReceivedAtPoint => 'Diterima di Titik Salur',
        };
    }

    public function stepNumber(): int
    {
        return match ($this) {
            self::DataCollected => 1,
            self::EligibilityVerified => 2,
            self::Scheduled => 3,
            self::InDelivery => 4,
            self::ReceivedAtPoint => 5,
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::DataCollected, self::EligibilityVerified => 'bg-slate-100 text-slate-700 border-slate-200',
            self::Scheduled => 'bg-blue-50 text-blue-800 border-blue-200',
            self::InDelivery => 'bg-amber-50 text-amber-800 border-amber-200',
            self::ReceivedAtPoint => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        };
    }
}

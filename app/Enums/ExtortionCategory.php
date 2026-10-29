<?php

declare(strict_types=1);

namespace App\Enums;

enum ExtortionCategory: string
{
    case CashDeduction = 'cash_deduction';
    case AdminFee = 'admin_fee';
    case CardWithheld = 'card_withheld';
    case GoodsShortfall = 'goods_shortfall';
    case ForcedPurchase = 'forced_purchase';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CashDeduction => 'Pemotongan Uang Tunai Bansos',
            self::AdminFee => 'Pungutan Biaya Administrasi Salur',
            self::CardWithheld => 'Kartu KKS / Buku Tabungan Ditahan',
            self::GoodsShortfall => 'Pengurangan Berat / Kualitas Sembako',
            self::ForcedPurchase => 'Paksaan Beli Komoditas Tertentu',
            self::Other => 'Bentuk Kejanggalan Lainnya',
        };
    }
}

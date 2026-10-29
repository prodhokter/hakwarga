<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Shipment;

class ShipmentTrackingService
{
    public function findByReceipt(string $receiptCode): ?Shipment
    {
        $normalized = strtoupper(trim($receiptCode));

        if ($normalized === '') {
            return null;
        }

        return Shipment::with([
            'beneficiary:id,public_id,region_id,program_id,masked_name,masked_address,eligibility_status',
            'beneficiary.region:id,bps_code,name,level',
            'program:id,code,name,cash_value,goods_value,goods_description,frequency',
            'agency:id,name,slug,type,region_id',
            'events.agency:id,name,slug,type',
        ])
            ->where('receipt_code', $normalized)
            ->first();
    }
}

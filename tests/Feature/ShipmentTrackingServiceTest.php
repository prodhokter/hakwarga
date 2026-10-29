<?php

declare(strict_types=1);

use App\Enums\AgencyType;
use App\Enums\EligibilityStatus;
use App\Enums\RegionLevel;
use App\Enums\ShipmentStatus;
use App\Models\Agency;
use App\Models\AidProgram;
use App\Models\Beneficiary;
use App\Models\Region;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use App\Services\ShipmentTrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it finds shipment by receipt code with relationships loaded', function () {
    $region = Region::create([
        'bps_code' => '3302112001',
        'name' => 'Kedungwringin',
        'level' => RegionLevel::Village,
        'is_pilot' => true,
    ]);

    $program = AidProgram::create([
        'code' => 'PKH',
        'name' => 'Program Keluarga Harapan',
        'cash_value' => 750000,
        'goods_value' => 0,
        'frequency' => 'quarterly',
        'is_active' => true,
    ]);

    $agency = Agency::create([
        'name' => 'PT Pos Indonesia KC Purwokerto',
        'slug' => 'pos-purwokerto',
        'type' => AgencyType::Distributor,
        'region_id' => $region->id,
        'is_simulated' => true,
    ]);

    $beneficiary = Beneficiary::create([
        'public_id' => '01JBCDEFGHJKMNPQRSTVWXYZ01',
        'region_id' => $region->id,
        'program_id' => $program->id,
        'nik_hash' => hash_hmac('sha256', '3302112001990001', 'pepper'),
        'masked_name' => 'S*** W***',
        'masked_address' => 'RT 02/RW 03',
        'eligibility_status' => EligibilityStatus::Eligible,
        'is_simulated' => true,
    ]);

    $shipment = Shipment::create([
        'receipt_code' => 'HWR-PKH-2610-DEMO01',
        'beneficiary_id' => $beneficiary->id,
        'program_id' => $program->id,
        'agency_id' => $agency->id,
        'period' => '2026-10',
        'entitled_cash' => 750000,
        'entitled_goods_value' => 0,
        'current_status' => ShipmentStatus::InDelivery,
        'distribution_point' => 'Balai Desa Kedungwringin',
        'is_simulated' => true,
    ]);

    ShipmentEvent::create([
        'shipment_id' => $shipment->id,
        'status' => ShipmentStatus::DataCollected,
        'occurred_at' => now()->subDays(4),
        'agency_id' => $agency->id,
        'note' => 'Data penerima terverifikasi',
    ]);

    $service = new ShipmentTrackingService;
    $result = $service->findByReceipt('hwr-pkh-2610-demo01 ');

    expect($result)->not->toBeNull()
        ->and($result->receipt_code)->toBe('HWR-PKH-2610-DEMO01')
        ->and($result->relationLoaded('beneficiary'))->toBeTrue()
        ->and($result->relationLoaded('program'))->toBeTrue()
        ->and($result->relationLoaded('agency'))->toBeTrue()
        ->and($result->relationLoaded('events'))->toBeTrue()
        ->and($result->events)->toHaveCount(1)
        ->and($result->beneficiary->masked_name)->toBe('S*** W***');
});

test('it returns null when receipt code does not exist', function () {
    $service = new ShipmentTrackingService;
    expect($service->findByReceipt('HWR-PKH-2610-NONEXIST'))->toBeNull();
});

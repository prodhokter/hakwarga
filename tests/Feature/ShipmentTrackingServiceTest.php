<?php

declare(strict_types=1);

use App\Services\ShipmentTrackingService;
use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('it finds shipment by receipt code with relationships loaded', function () {
    $service = new ShipmentTrackingService;
    $result = $service->findByReceipt('hwr-pkh-2610-demo01 ');

    expect($result)->not->toBeNull()
        ->and($result->receipt_code)->toBe('HWR-PKH-2610-DEMO01')
        ->and($result->relationLoaded('beneficiary'))->toBeTrue()
        ->and($result->relationLoaded('program'))->toBeTrue()
        ->and($result->relationLoaded('agency'))->toBeTrue()
        ->and($result->relationLoaded('events'))->toBeTrue()
        ->and($result->events)->toHaveCount(4)
        ->and($result->beneficiary->masked_name)->toBe('S*** W***');
});

test('it returns null when receipt code does not exist', function () {
    $service = new ShipmentTrackingService;
    expect($service->findByReceipt('HWR-PKH-2610-NONEXIST'))->toBeNull();
});

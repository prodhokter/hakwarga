<?php

declare(strict_types=1);

use App\Enums\ShipmentStatus;

test('shipment status enum provides correct step numbers and indonesian labels', function () {
    expect(ShipmentStatus::DataCollected->stepNumber())->toBe(1)
        ->and(ShipmentStatus::DataCollected->label())->toBe('Pendataan Warga')
        ->and(ShipmentStatus::EligibilityVerified->stepNumber())->toBe(2)
        ->and(ShipmentStatus::Scheduled->stepNumber())->toBe(3)
        ->and(ShipmentStatus::InDelivery->stepNumber())->toBe(4)
        ->and(ShipmentStatus::ReceivedAtPoint->stepNumber())->toBe(5)
        ->and(ShipmentStatus::ReceivedAtPoint->label())->toBe('Diterima di Titik Salur');
});

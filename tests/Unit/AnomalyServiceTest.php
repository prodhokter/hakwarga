<?php

declare(strict_types=1);

use App\Enums\AnomalyFlag;
use App\Services\AnomalyService;

test('it classifies relative ratios into correct anomaly flags', function () {
    $service = new AnomalyService;

    expect($service->classifyRatio(0.4))->toBe(AnomalyFlag::UnderCoverage)
        ->and($service->classifyRatio(1.6))->toBe(AnomalyFlag::OverCoverage)
        ->and($service->classifyRatio(1.0))->toBe(AnomalyFlag::Normal);
});

test('it calculates severity levels based on thresholds', function () {
    $service = new AnomalyService;

    expect($service->calculateSeverity(0.25))->toBe('high')
        ->and($service->calculateSeverity(2.2))->toBe('high')
        ->and($service->calculateSeverity(0.45))->toBe('medium')
        ->and($service->calculateSeverity(1.55))->toBe('medium')
        ->and($service->calculateSeverity(1.0))->toBe('none');
});

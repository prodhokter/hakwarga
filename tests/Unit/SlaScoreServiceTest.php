<?php

declare(strict_types=1);

use App\Services\SlaScoreService;
use Carbon\Carbon;

test('it calculates SLA score with 50-50 weight correctly', function () {
    $service = new SlaScoreService;

    // 100% response ok (weight 50%), 50% resolve ok (weight 50%) -> 50% + 25% = 75.0%
    $score = $service->calculateCompositeScore(100.0, 50.0);
    expect($score)->toBe(75.0);

    // 80% response ok, 80% resolve ok -> 80.0%
    expect($service->calculateCompositeScore(80.0, 80.0))->toBe(80.0);
});

test('it assigns appropriate grade labels based on score', function () {
    $service = new SlaScoreService;

    expect($service->calculateGrade(90.0))->toBe('A')
        ->and($service->calculateGrade(75.0))->toBe('B')
        ->and($service->calculateGrade(60.0))->toBe('C')
        ->and($service->calculateGrade(40.0))->toBe('D');
});

test('it determines if response and resolve times meet thresholds', function () {
    $service = new SlaScoreService;

    $createdAt = Carbon::now()->subDays(5);

    // Responded in 24 hours (<= 72 hours) -> true
    $firstResponseAt = $createdAt->copy()->addHours(24);
    expect($service->isResponseOk($createdAt, $firstResponseAt))->toBeTrue();

    // Responded in 80 hours (> 72 hours) -> false
    $lateResponseAt = $createdAt->copy()->addHours(80);
    expect($service->isResponseOk($createdAt, $lateResponseAt))->toBeFalse();

    // Resolved in 10 days (<= 14 days) -> true
    $resolvedAt = $createdAt->copy()->addDays(10);
    expect($service->isResolveOk($createdAt, $resolvedAt))->toBeTrue();

    // Resolved in 16 days (> 14 days) -> false
    $lateResolvedAt = $createdAt->copy()->addDays(16);
    expect($service->isResolveOk($createdAt, $lateResolvedAt))->toBeFalse();
});

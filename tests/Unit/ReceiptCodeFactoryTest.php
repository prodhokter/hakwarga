<?php

declare(strict_types=1);

use App\Services\ReceiptCodeFactory;

test('it creates valid receipt code following HWR standard pattern', function () {
    $factory = new ReceiptCodeFactory;
    $code = $factory->make('PKH', '2610');

    expect($factory->isValid($code))->toBeTrue()
        ->and($code)->toMatch('/^HWR-PKH-2610-[23456789ABCDEFGHJKMNPQRSTVWXYZ]{6}$/');
});

test('it validates correct receipt codes and rejects invalid ones', function () {
    $factory = new ReceiptCodeFactory;

    expect($factory->isValid('HWR-PKH-2610-DEMO01'))->toBeTrue()
        ->and($factory->isValid('HWR-BPNT-2610-DEMO02'))->toBeTrue()
        ->and($factory->isValid('INVALID-CODE'))->toBeFalse()
        ->and($factory->isValid('HWR-PKH-2610-12345'))->toBeFalse();
});

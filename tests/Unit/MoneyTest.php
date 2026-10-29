<?php

declare(strict_types=1);

use App\Support\Money;

test('it formats integer amounts to Rupiah format correctly', function () {
    expect(Money::format(750000))->toBe('Rp750.000')
        ->and(Money::format(0))->toBe('Rp0')
        ->and(Money::format(1250000))->toBe('Rp1.250.000');
});

<?php

declare(strict_types=1);

use App\Services\TicketCodeFactory;

test('it creates valid ticket code following HWT standard pattern', function () {
    $factory = new TicketCodeFactory;
    $ticket = $factory->makeTicketCode(2026);

    expect($ticket)->toMatch('/^HWT-2026-[23456789ABCDEFGHJKMNPQRSTVWXYZ]{6}$/')
        ->and($factory->isValidTicketCode($ticket))->toBeTrue();
});

test('it creates formatted secret code and verifies using hash_equals', function () {
    $factory = new TicketCodeFactory;
    $secret = $factory->makeSecretCode();

    expect($secret)->toMatch('/^[23456789ABCDEFGHJKMNPQRSTVWXYZ]{4}-[23456789ABCDEFGHJKMNPQRSTVWXYZ]{4}-[23456789ABCDEFGHJKMNPQRSTVWXYZ]{4}$/');

    $hash = $factory->hashSecret($secret);
    expect(strlen($hash))->toBe(64);

    // Verify correct secret matches
    expect($factory->verifySecret($secret, $hash))->toBeTrue();

    // Verify secret with spaces or lowercase still matches
    expect($factory->verifySecret(strtolower($secret), $hash))->toBeTrue();
    expect($factory->verifySecret(str_replace('-', '', $secret), $hash))->toBeTrue();

    // Verify wrong secret fails
    expect($factory->verifySecret('WRONG-CODE-1234', $hash))->toBeFalse();
});

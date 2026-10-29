<?php

declare(strict_types=1);

use App\Services\NikHasher;

test('it hashes 16 digit NIK using HMAC-SHA256 with pepper', function () {
    config(['hakwarga.nik_pepper' => 'test-secret-pepper']);

    $hasher = new NikHasher;
    $hash = $hasher->hash('3302112001990001');

    expect(strlen($hash))->toBe(64)
        ->and($hash)->toBe(hash_hmac('sha256', '3302112001990001', 'test-secret-pepper'));
});

test('it throws exception when NIK is not 16 digits', function () {
    $hasher = new NikHasher;
    $hasher->hash('12345');
})->throws(InvalidArgumentException::class);

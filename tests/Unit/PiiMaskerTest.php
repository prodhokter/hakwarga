<?php

declare(strict_types=1);

use App\Services\PiiMasker;

test('it masks 16-digit NIK sequences in text', function () {
    $masker = new PiiMasker;
    $input = 'Oknum meminta uang kepada warga ber-NIK 3302112001990001 di lokasi salur.';
    $output = $masker->mask($input);

    expect($output)->not->toContain('3302112001990001')
        ->and($output)->toContain('[NIK DISAMARKAN]');
});

test('it masks Indonesian phone numbers in text', function () {
    $masker = new PiiMasker;
    $input = 'Petugas dapat dihubungi di 081234567890 atau +6289876543210 untuk konfirmasi.';
    $output = $masker->mask($input);

    expect($output)->not->toContain('081234567890')
        ->and($output)->not->toContain('+6289876543210')
        ->and($output)->toContain('[NOMOR TELEPON DISAMARKAN]');
});

test('it leaves safe text untouched', function () {
    $masker = new PiiMasker;
    $input = 'Bansos PKH dipotong Rp50.000 saat pencairan di balai desa.';
    $output = $masker->mask($input);

    expect($output)->toBe($input);
});

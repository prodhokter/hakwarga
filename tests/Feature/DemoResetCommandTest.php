<?php

declare(strict_types=1);

test('hw:demo-reset command resets database and seeds demo scenarios', function () {
    $this->artisan('hw:demo-reset')
        ->expectsOutput('Mereset basis data dan menjalankan migrasi ulang...')
        ->expectsOutput('Data demo simulasi berhasil diinisialisasi ulang.')
        ->assertExitCode(0);

    $this->assertDatabaseHas('regions', [
        'bps_code' => '3302112001',
        'name' => 'Desa Kedungwringin',
    ]);

    $this->assertDatabaseHas('shipments', [
        'receipt_code' => 'HWR-PKH-2610-DEMO01',
    ]);
});

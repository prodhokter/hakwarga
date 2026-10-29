<?php

declare(strict_types=1);

use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('tracker index returns 200 with search form and sample receipts', function () {
    $response = $this->get(route('tracker.index'));

    $response->assertStatus(200)
        ->assertSee('Lacak Resi Penyaluran Bantuan Sosial')
        ->assertSee('HWR-PKH-2610-DEMO01');
});

test('tracker index redirects query param to canonical show route with uppercase', function () {
    $response = $this->get('/lacak?code=hwr-pkh-2610-demo01');

    $response->assertRedirect(route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']));
});

test('tracker show displays gold demo receipt 1 with 5-stage timeline and entitlement breakdown', function () {
    $response = $this->get(route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']));

    $response->assertStatus(200)
        ->assertSee('HWR-PKH-2610-DEMO01')
        ->assertSee('Tahap 4 dari 5: Dalam Pengiriman')
        ->assertSee('S*** W***')
        ->assertSee('Rp750.000')
        ->assertSee('PT Pos Indonesia KC Purwokerto')
        ->assertSee('Balai Desa Kedungwringin')
        ->assertSee('Linimasa 5 Tahap Penyaluran');

    $content = (string) $response->getContent();

    // Privacy & Security: zero raw NIK or nik_hash leakage
    expect(str_contains($content, '3302112001990001'))->toBeFalse()
        ->and(preg_match('/\b\d{16}\b/', $content))->toBe(0)
        ->and(str_contains($content, 'nik_hash'))->toBeFalse()
        // Antislop rule R-02: No em dashes
        ->and(str_contains($content, '—'))->toBeFalse();
});

test('tracker show displays gold demo receipt 2 with goods entitlement', function () {
    $response = $this->get(route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']));

    $response->assertStatus(200)
        ->assertSee('HWR-BPNT-2610-DEMO02')
        ->assertSee('BPNT')
        ->assertSee('Tahap 3 dari 5: Penjadwalan Penyaluran')
        ->assertSee('A*** H***')
        ->assertSee('Beras Premium 10 kg, Telur Ayam 1 kg')
        ->assertSee('Rp200.000');
});

test('tracker show displays gold demo receipt 3 completed at distribution point', function () {
    $response = $this->get(route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']));

    $response->assertStatus(200)
        ->assertSee('HWR-PKH-2610-DEMO03')
        ->assertSee('Tahap 5 dari 5: Diterima di Titik Salur')
        ->assertSee('M*** T***')
        ->assertSee('Rp600.000');
});

test('tracker show displays friendly not found state for invalid receipt', function () {
    $response = $this->get(route('tracker.show', ['receipt' => 'HWR-PKH-2610-NONEXIST']));

    $response->assertStatus(200)
        ->assertSee('Resi Tidak Ditemukan')
        ->assertSee('HWR-PKH-2610-NONEXIST')
        ->assertSee('Petunjuk Pengecekan:');
});

test('tracker show enforces rate limiting of 10 requests per minute', function () {
    for ($i = 0; $i < 10; $i++) {
        $response = $this->get(route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']));
        $response->assertStatus(200);
    }

    $blocked = $this->get(route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']));
    $blocked->assertStatus(429);
});

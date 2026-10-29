<?php

declare(strict_types=1);

test('landing page returns successful status and displays civic hero', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertSee('Bansos Adalah Hak Warga. Pastikan Sampai Utuh Tanpa Potongan.')
        ->assertSee('Data Simulasi')
        ->assertSee('HWR-PKH-2610-DEMO01')
        ->assertSee('HWR-BPNT-2610-DEMO02')
        ->assertSee('HWR-PKH-2610-DEMO03');

    // Antislop rule R-02: No em dashes in output
    expect(str_contains((string) $response->getContent(), '—'))->toBeFalse();
});

test('about page returns successful status and displays PDP information', function () {
    $response = $this->get(route('about'));

    $response->assertStatus(200)
        ->assertSee('Tentang Platform HakWarga')
        ->assertSee('Perlindungan Data Pribadi');

    expect(str_contains((string) $response->getContent(), '—'))->toBeFalse();
});

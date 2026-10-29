<?php

declare(strict_types=1);

use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('map page returns 200 with anomaly statistics and accessible red flag table', function () {
    $response = $this->get(route('map.index'));

    $response->assertStatus(200)
        ->assertSee('Peta Anomali & Rasio Alokasi Bantuan Sosial')
        ->assertSee('Kabupaten Banyumas')
        ->assertSee('Kabupaten Cilacap')
        ->assertSee('Kabupaten Purbalingga')
        ->assertSee('Potensi Defisit (Under-Coverage)')
        ->assertSee('Potensi Kelebihan Kuota (Over-Coverage)')
        ->assertSee('Tabel Rincian Anomali Wilayah');

    // Antislop R-02
    expect(str_contains((string) $response->getContent(), '—'))->toBeFalse();
});

test('api choropleth endpoint returns valid geojson feature collection with calculated anomaly attributes', function () {
    $response = $this->getJson(route('api.map.choropleth'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'type',
            'features' => [
                '*' => [
                    'type',
                    'properties' => [
                        'bps_code',
                        'name',
                        'quota_recipients',
                        'poor_estimate',
                        'targeting_ratio',
                        'relative_ratio',
                        'flag',
                        'flag_label',
                        'severity',
                    ],
                    'geometry' => [
                        'type',
                        'coordinates',
                    ],
                ],
            ],
        ]);

    $data = $response->json();
    expect($data['type'])->toBe('FeatureCollection')
        ->and(count($data['features']))->toBeGreaterThanOrEqual(5);
});

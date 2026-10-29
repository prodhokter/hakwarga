<?php

declare(strict_types=1);

use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('scorecard index renders agency leaderboard table with SLA grades', function () {
    $response = $this->get(route('scorecard.index'));

    $response->assertStatus(200)
        ->assertSee('Scorecard SLA Instansi Penyalur Bansos')
        ->assertSee('Dinas Sosial Kabupaten Banyumas')
        ->assertSee('PT Pos Indonesia KC Purwokerto')
        ->assertSee('Dinas Sosial Kabupaten Cilacap')
        ->assertSee('Target 72 Jam Respon Awal');

    // Antislop R-02
    expect(str_contains((string) $response->getContent(), '—'))->toBeFalse();
});

test('scorecard show renders agency profile and SLA breakdown', function () {
    $response = $this->get(route('scorecard.show', ['agency' => 'dinsos-banyumas']));

    $response->assertStatus(200)
        ->assertSee('Dinas Sosial Kabupaten Banyumas')
        ->assertSee('Total Aduan Terdistribusi')
        ->assertSee('Kepatuhan Respon Awal')
        ->assertSee('Kepatuhan Selesai');
});

test('data page renders open data methodology and download links', function () {
    $response = $this->get(route('data.index'));

    $response->assertStatus(200)
        ->assertSee('Metodologi & Dataset Publik HakWarga')
        ->assertSee('Rumus Analisis Anomali')
        ->assertSee('Unduh CSV Scorecard SLA')
        ->assertSee('Unduh CSV Anomali Wilayah');
});

test('data export streams valid CSV for SLA and anomaly datasets', function () {
    $slaResponse = $this->get(route('data.export', ['dataset' => 'sla']));
    $slaResponse->assertStatus(200)
        ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

    $anomalyResponse = $this->get(route('data.export', ['dataset' => 'anomali']));
    $anomalyResponse->assertStatus(200)
        ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
});

test('api scorecard endpoint returns JSON list of ranked agencies', function () {
    $response = $this->getJson(route('api.scorecard'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                'agency_id',
                'agency_name',
                'agency_slug',
                'agency_type',
                'region_name',
                'total_reports',
                'response_rate',
                'resolve_rate',
                'final_score',
                'grade',
            ],
        ]);
});

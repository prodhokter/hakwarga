<?php

declare(strict_types=1);

use App\Enums\ExtortionCategory;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Region;
use App\Models\Report;
use App\Services\TicketCodeFactory;
use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('ticket lookup page returns 200', function () {
    $response = $this->get(route('ticket.index'));
    $response->assertStatus(200)
        ->assertSee('Akses & Pantau Tiket Laporan Warga');
});

test('public ticket show hides sensitive details without secret code authentication', function () {
    $region = Region::firstOrFail();
    $factory = new TicketCodeFactory;
    $secret = '4HX7-9K2M-P8Q3';

    $report = Report::create([
        'ticket_code' => 'HWT-2026-TEST01',
        'secret_hash' => $factory->hashSecret($secret),
        'type' => ReportType::Extortion,
        'category' => ExtortionCategory::CashDeduction->value,
        'region_id' => $region->id,
        'description' => 'Isi laporan sangat rahasia tentang pemotongan bansos.',
        'status' => ReportStatus::Submitted,
        'is_simulated' => true,
    ]);

    $response = $this->get(route('ticket.show', ['ticket' => 'HWT-2026-TEST01']));

    $response->assertStatus(200)
        ->assertSee('HWT-2026-TEST01')
        ->assertSee('Tampilan Status Publik')
        ->assertSee('Buka Rincian Isi Laporan dengan Kode Rahasia')
        // Sensitive description must NOT be visible to unauthenticated public!
        ->assertDontSee('Isi laporan sangat rahasia tentang pemotongan bansos.');
});

test('user with valid secret code unlocks full details and can send reply', function () {
    $region = Region::firstOrFail();
    $factory = new TicketCodeFactory;
    $secret = '4HX7-9K2M-P8Q3';

    $report = Report::create([
        'ticket_code' => 'HWT-2026-TEST02',
        'secret_hash' => $factory->hashSecret($secret),
        'type' => ReportType::Extortion,
        'category' => ExtortionCategory::CashDeduction->value,
        'region_id' => $region->id,
        'description' => 'Isi laporan tentang pungli uang kas desa.',
        'status' => ReportStatus::Submitted,
        'is_simulated' => true,
    ]);

    // Access with secret
    $authResponse = $this->post(route('ticket.access'), [
        'ticket_code' => 'HWT-2026-TEST02',
        'secret_code' => '4HX7-9K2M-P8Q3',
    ]);

    $authResponse->assertRedirect(route('ticket.show', ['ticket' => 'HWT-2026-TEST02']));

    // View with authenticated session
    $viewResponse = $this->get(route('ticket.show', ['ticket' => 'HWT-2026-TEST02']));
    $viewResponse->assertStatus(200)
        ->assertSee('Sesi Pelapor Terverifikasi')
        ->assertSee('Isi laporan tentang pungli uang kas desa.')
        ->assertSee('Kirim Tanggapan atau Bukti Tambahan');

    // Post reply
    $replyResponse = $this->post(route('ticket.reply', ['ticket' => 'HWT-2026-TEST02']), [
        'message' => 'Bukti kwitansi penarikan sudah kami simpan.',
    ]);

    $replyResponse->assertRedirect(route('ticket.show', ['ticket' => 'HWT-2026-TEST02']));

    expect($report->fresh()->updates)->toHaveCount(1)
        ->and($report->fresh()->updates->first()->message)->toContain('Bukti kwitansi penarikan sudah kami simpan.');
});

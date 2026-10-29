<?php

declare(strict_types=1);

use App\Enums\ExtortionCategory;
use App\Enums\ReportType;
use App\Models\AidProgram;
use App\Models\Region;
use App\Models\Report;
use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('report choose page renders both report types', function () {
    $response = $this->get(route('report.choose'));

    $response->assertStatus(200)
        ->assertSee('Lapor Pungutan Liar & Pemotongan Bansos')
        ->assertSee('Sanggah Penerima Tidak Tepat Sasaran');
});

test('user can submit extortion report anonymously with automatic PII masking', function () {
    $region = Region::where('bps_code', '3302112001')->firstOrFail();

    $response = $this->post(route('report.extortion.store'), [
        'region_id' => $region->id,
        'category' => ExtortionCategory::CashDeduction->value,
        'amount_claimed' => 50000,
        'description' => 'Petugas di balai desa memotong dana tunai warga ber-NIK 3302112001990001 sebesar Rp50.000 dengan alasan kas operasional.',
    ]);

    $response->assertRedirect(route('report.success'))
        ->assertSessionHas('ticket_info');

    $report = Report::latest()->firstOrFail();

    expect($report->type)->toBe(ReportType::Extortion)
        ->and($report->amount_claimed)->toBe(50000)
        ->and($report->description)->not->toContain('3302112001990001')
        ->and($report->description)->toContain('[NIK DISAMARKAN]')
        ->and($report->updates)->toHaveCount(1);
});

test('honeypot submission is rejected', function () {
    $region = Region::firstOrFail();

    $response = $this->post(route('report.extortion.store'), [
        'region_id' => $region->id,
        'category' => ExtortionCategory::AdminFee->value,
        'description' => 'Pungutan biaya administrasi tanpa dasar aturan yang jelas.',
        'honeypot' => 'bot-content',
    ]);

    $response->assertSessionHasErrors('honeypot');
});

test('user can submit dispute report', function () {
    $region = Region::firstOrFail();
    $program = AidProgram::firstOrFail();

    $response = $this->post(route('report.dispute.store'), [
        'region_id' => $region->id,
        'program_id' => $program->id,
        'category' => 'not_eligible',
        'target_beneficiary_name' => 'Warga Mampu RT 01',
        'description' => 'Penerima memiliki mobil dan rumah bertingkat sehingga tidak layak menerima bansos.',
    ]);

    $response->assertRedirect(route('report.success'));

    $report = Report::latest()->firstOrFail();
    expect($report->type)->toBe(ReportType::Dispute)
        ->and($report->description)->toContain('Warga Mampu RT 01');
});

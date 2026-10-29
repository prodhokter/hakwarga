<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\DemoScenarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DemoScenarioSeeder::class);
});

test('admin login page returns 200', function () {
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
});

test('authenticated super admin can access filament dashboard and resources', function () {
    $admin = User::where('role', UserRole::SuperAdmin)->firstOrFail();

    $response = $this->actingAs($admin)->get('/admin');
    $response->assertStatus(200);

    $shipmentsResponse = $this->actingAs($admin)->get('/admin/shipments');
    $shipmentsResponse->assertStatus(200);

    $reportsResponse = $this->actingAs($admin)->get('/admin/reports');
    $reportsResponse->assertStatus(200);
});

test('unauthenticated guest is redirected to admin login', function () {
    $response = $this->get('/admin');
    $response->assertRedirect('/admin/login');
});

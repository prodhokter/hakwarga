<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('lacak')->name('tracker.')->group(function () {
    Route::get('/', [TrackerController::class, 'index'])->name('index');
    Route::get('/{receipt}', [TrackerController::class, 'show'])
        ->middleware('throttle:tracker')
        ->name('show');
});

// Roadmap placeholders for Milestone 2
Route::get('/peta', fn () => view('pages.coming-soon', [
    'title' => 'Peta Anomali Bansos',
    'module' => 'Peta Interaktif',
    'description' => 'Eksplorasi rasio alokasi bantuan sosial per wilayah berbasis perbandingan kuota dan estimasi penduduk miskin resmi BPS.',
]))->name('map.index');

Route::get('/lapor', fn () => view('pages.coming-soon', [
    'title' => 'Lapor Pungli & Sanggah Bansos',
    'module' => 'Kanal Pengaduan Warga',
    'description' => 'Layanan pelaporan pungutan liar tanpa identitas pelapor dan pengajuan sanggah kelayakan bansos berkeadilan.',
]))->name('report.choose');

Route::get('/scorecard', fn () => view('pages.coming-soon', [
    'title' => 'Scorecard SLA Instansi',
    'module' => 'Peringkat Kepatuhan SLA',
    'description' => 'Pemantauan kepatuhan respon 72 jam dan penyelesaian 14 hari instansi penyalur atas aduan warga.',
]))->name('scorecard.index');

Route::get('/tentang', fn () => view('pages.about'))->name('about');

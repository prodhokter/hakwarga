<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('lacak')->name('tracker.')->group(function () {
    Route::get('/', [TrackerController::class, 'index'])->name('index');
    Route::get('/{receipt}', [TrackerController::class, 'show'])
        ->middleware('throttle:tracker')
        ->name('show');
});

Route::prefix('lapor')->name('report.')->group(function () {
    Route::get('/', [ReportController::class, 'choose'])->name('choose');
    Route::get('/pungli', [ReportController::class, 'createExtortion'])->name('extortion.create');
    Route::post('/pungli', [ReportController::class, 'storeExtortion'])->name('extortion.store');
    Route::get('/sanggah', [ReportController::class, 'createDispute'])->name('dispute.create');
    Route::post('/sanggah', [ReportController::class, 'storeDispute'])->name('dispute.store');
    Route::get('/sukses', [ReportController::class, 'success'])->name('success');
});

Route::prefix('tiket')->name('ticket.')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('index');
    Route::post('/akses', [TicketController::class, 'access'])->name('access');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
    Route::post('/{ticket}/tanggapan', [TicketController::class, 'reply'])->name('reply');
});

Route::get('/peta', [MapController::class, 'index'])->name('map.index');

Route::get('/scorecard', fn () => view('pages.coming-soon', [
    'title' => 'Scorecard SLA Instansi',
    'module' => 'Peringkat Kepatuhan SLA',
    'description' => 'Pemantauan kepatuhan respon 72 jam dan penyelesaian 14 hari instansi penyalur atas aduan warga.',
]))->name('scorecard.index');

Route::get('/tentang', fn () => view('pages.about'))->name('about');

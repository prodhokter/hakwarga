<?php

declare(strict_types=1);

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/map/choropleth', [MapController::class, 'choropleth'])->name('api.map.choropleth');
});

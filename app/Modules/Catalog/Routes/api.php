<?php

use App\Modules\Catalog\Http\Controllers\Api\BookApiController;
use Illuminate\Support\Facades\Route;

// REST API katalog: token Sanctum + rate limiting 60 req/menit.
Route::middleware(['api', 'auth:sanctum', 'throttle:60,1'])->prefix('api/catalog')->group(function () {
    Route::get('books', [BookApiController::class, 'index']);
    Route::get('books/{book}', [BookApiController::class, 'show']);
});

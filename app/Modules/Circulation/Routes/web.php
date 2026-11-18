<?php

use App\Modules\Circulation\Http\Controllers\FineController;
use App\Modules\Circulation\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'role:admin,pustakawan'])->prefix('circulation')->name('circulation.')->group(function () {
    Route::resource('loans', LoanController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');

    Route::get('fines', [FineController::class, 'index'])->name('fines.index');
    Route::post('fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');
});

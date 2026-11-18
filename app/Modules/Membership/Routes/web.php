<?php

use App\Modules\Membership\Http\Controllers\MemberController;
use App\Modules\Membership\Http\Controllers\MembershipTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('membership')->name('membership.')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::resource('types', MembershipTypeController::class)->except('show');
    });

    Route::middleware('role:admin,pustakawan')->group(function () {
        Route::resource('members', MemberController::class)->except('show');
    });
});

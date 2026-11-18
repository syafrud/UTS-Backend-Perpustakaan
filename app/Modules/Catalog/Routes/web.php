<?php

use App\Modules\Catalog\Http\Controllers\AuthorController;
use App\Modules\Catalog\Http\Controllers\BookController;
use App\Modules\Catalog\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('catalog')->name('catalog.')->group(function () {
    // Kelola katalog: hanya admin.
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('authors', AuthorController::class)->except('show');
        Route::resource('books', BookController::class)->except(['index', 'show']);
    });

    // Lihat katalog: admin & pustakawan.
    Route::middleware('role:admin,pustakawan')->group(function () {
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
    });
});

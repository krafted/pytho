<?php

use App\Http\Controllers\PenController;
use Illuminate\Support\Facades\Route;

Route::get('/{pen:slug?}', [PenController::class, 'show'])->name('pen.show');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/', [PenController::class, 'store'])->name('pen.store');
    Route::put('/{pen:slug}', [PenController::class, 'update'])->name('pen.update');
});


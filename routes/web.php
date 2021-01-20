<?php

use App\Http\Controllers\PenController;
use App\Http\Controllers\SaveController;
use Illuminate\Support\Facades\Route;

Route::get('/{pen:slug?}', [PenController::class, 'show'])->name('pen.show');
Route::post('/', [PenController::class, 'store'])->name('pen.store');
Route::put('/{pen:slug}', [PenController::class, 'update'])->name('pen.update');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    //
});


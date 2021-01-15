<?php

use App\Http\Controllers\PenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PenController::class, 'show'])->name('pen');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});

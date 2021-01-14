<?php

use App\Http\Controllers\EditorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EditorController::class, 'show'])->name('editor');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});

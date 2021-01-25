<?php

use App\Http\Controllers\PenController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\PrivateProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TermsOfServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/terms', [TermsOfServiceController::class, 'show'])->name('terms.show');
Route::get('/privacy', [PrivacyPolicyController::class, 'show'])->name('privacy.show');
Route::get('/@{user:username}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/@{user:username}/private', [PrivateProfileController::class, 'show'])->name('profile.private.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/', [PenController::class, 'store'])->name('pen.store');
    Route::put('/{pen:slug}', [PenController::class, 'update'])->name('pen.update');
});

Route::get('/{pen:slug?}', [PenController::class, 'show'])->name('pen.show');



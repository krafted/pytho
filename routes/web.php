<?php

use App\Http\Controllers\PenController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\AdvancedSettingsController;
use App\Http\Controllers\Settings\ProfileSettingsController;
use App\Http\Controllers\Settings\SecuritySettingsController;
use App\Http\Controllers\Settings\SocialSettingsController;
use App\Http\Controllers\TermsOfServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/terms', [TermsOfServiceController::class, 'show'])->name('terms.show');
Route::get('/privacy', [PrivacyPolicyController::class, 'show'])->name('privacy.show');
Route::get('/@{user:username}/{visibility?}', [ProfileController::class, 'show'])
    ->where('visibility', '(public|private|unlisted)?')
    ->name('profile.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings/profile', [ProfileSettingsController::class, 'show'])->name('settings.profile.show');
    Route::get('/settings/security', [SecuritySettingsController::class, 'show'])->name('settings.security.show');
    Route::get('/settings/social', [SocialSettingsController::class, 'show'])->name('settings.social.show');
    Route::get('/settings/advanced', [AdvancedSettingsController::class, 'show'])->name('settings.advanced.show');

    Route::post('/', [PenController::class, 'store'])->name('pen.store');
    Route::put('/{pen:slug}', [PenController::class, 'update'])->name('pen.update');
});

Route::get('/{pen:slug?}', [PenController::class, 'show'])->name('pen.show');

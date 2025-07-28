<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Api\UrlShortController as UrlShortApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UrlShortController;

Route::name('frontend.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [AuthController::class, 'loginView'])->name('view-login');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('register', [AuthController::class, 'registerView'])->name('view-register');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::get('request-reset-password', [AuthController::class, 'requestResetPasswordView'])->name('view-request-reset-password');
        Route::post('request-reset-password', [AuthController::class, 'requestResetPassword'])->name('request-reset-password');
        Route::get('reset-password/{token}/{user_id}', [AuthController::class, 'resetPasswordView'])->name('view-reset-password');
        Route::post('reset-password/{token}/{user_id}', [AuthController::class, 'resetPassword'])->name('reset-password');
        Route::get('login/testuser', [AuthController::class, 'loginAsTestUser']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('', [UrlShortController::class, 'create'])->name('create');
        Route::put('{short_code}', [UrlShortApiController::class, "update"])->name('update');
        Route::get('dashboard', [UrlShortController::class, 'dashboard'])->name('dashboard');
        Route::delete('{short_code}', [UrlShortApiController::class, "destroy"])->name('destroy');
        Route::post('shorturl', [UrlShortController::class, 'store'])->name('store');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/{short_code}', [UrlShortApiController::class, 'redirect'])->name('shorturl.redirect');

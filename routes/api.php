<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlShortController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->name("auth.")->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("/logout", [AuthController::class, "logout"])->name('logout');
    });
});

Route::prefix('shorturl')->name("shorturl.")->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UrlShortController::class, 'index'])->name('index');
    Route::get('/stats', [UrlShortController::class, 'index'])->name('index-with-statistic');
    Route::post('/store', [UrlShortController::class, "store"])->name('store');
    Route::prefix('{short_code}')->group(function () {
        Route::get('', [UrlShortController::class, 'show'])->name('show');
        Route::put('', [UrlShortController::class, "update"])->name('update');
        Route::delete('', [UrlShortController::class, "destroy"])->name('destroy');
        Route::get('/stats', [UrlShortController::class, 'show'])->name('show-with-statistic');
    });
});

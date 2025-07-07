<?php

use App\Http\Controllers\UrlShortController;
use Illuminate\Support\Facades\Route;

Route::get('/{short_code}', [UrlShortController::class, 'redirect']);

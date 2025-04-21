<?php

use App\Http\Controllers\Auth\Google\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response('OK', 200);
});

Route::get('/auth/google/redirect', [GoogleOAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleOAuthController::class, 'callback'])->name('google.callback');

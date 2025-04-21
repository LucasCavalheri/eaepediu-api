<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SendEmailVerificationController;
use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');

    Route::post('/forgot-password', ForgotPasswordController::class)->name('forgot-password')->middleware('throttle:1,1');
    Route::post('/reset-password', ResetPasswordController::class)->name('reset-password');

    Route::post('/send-email-verification', SendEmailVerificationController::class)->name('send-email-verification')->middleware(['auth:sanctum', 'throttle:1,1']);
    Route::get('/verify-email', VerifyEmailController::class)->name('verify-email')->middleware('auth:sanctum');
});

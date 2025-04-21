<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\User\UploadUserImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/users')->name('users.')->group(function () {
    Route::middleware('email-verified')->group(function () {
        Route::post('/upload-avatar', UploadUserImageController::class)->name('upload-avatar');
        Route::get('/profile', ProfileController::class)->name('profile');
        Route::patch('/', UpdateUserController::class)->name('update');
    });
});

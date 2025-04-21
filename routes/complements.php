<?php

use App\Http\Controllers\Complement\CreateComplementController;
use App\Http\Controllers\Complement\DeleteComplementController;
use App\Http\Controllers\Complement\FindAllComplementsController;
use App\Http\Controllers\Complement\FindRestaurantComplementsController;
use App\Http\Controllers\Complement\UpdateComplementController;
use App\Http\Controllers\Complement\UploadComplementImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/complements')->name('complements.')->group(function () {
    Route::middleware('has-active-subscription')->group(function () {
        Route::post('/', CreateComplementController::class)->name('create');
        Route::post('/{id}/upload-image', UploadComplementImageController::class)->name('upload-image');
        Route::get('/product/{productId}', FindAllComplementsController::class)->name('find-all');
        Route::patch('/{id}', UpdateComplementController::class)->name('update');
        Route::delete('/{id}', DeleteComplementController::class)->name('delete');
    });
});

Route::get('/complements/restaurant/{id}', FindRestaurantComplementsController::class)->name('find-restaurant-complements');

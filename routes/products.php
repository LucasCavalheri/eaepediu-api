<?php

use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\FindAllProductsController;
use App\Http\Controllers\Product\FindRestaurantProductsController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Product\UploadProductImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/products')->name('products.')->group(function () {
    Route::middleware('has-active-subscription')->group(function () {
        Route::post('/{id}', CreateProductController::class)->name('create');
        Route::post('/{id}/upload-image', UploadProductImageController::class)->name('upload-image');
        Route::get('/', FindAllProductsController::class)->name('find-all');
        Route::patch('/{id}', UpdateProductController::class)->name('update');
        Route::delete('/{id}', DeleteProductController::class)->name('delete');
    });
});

Route::get('/products/restaurant/{id}', FindRestaurantProductsController::class)->name('find-restaurant-products');

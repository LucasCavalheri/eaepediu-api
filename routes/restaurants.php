<?php

use App\Http\Controllers\Restaurant\CheckSubdomainController;
use App\Http\Controllers\Restaurant\CreateRestaurantController;
use App\Http\Controllers\Restaurant\DeleteRestaurantController;
use App\Http\Controllers\Restaurant\FindAllRestaurantsController;
use App\Http\Controllers\Restaurant\FindAllUserRestaurantsController;
use App\Http\Controllers\Restaurant\GetRestaurantController;
use App\Http\Controllers\Restaurant\UpdateRestaurantController;
use App\Http\Controllers\Restaurant\UploadRestaurantImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/restaurants')->name('restaurants.')->group(function () {
    Route::middleware('has-active-subscription')->group(function () {
        Route::post('/', CreateRestaurantController::class)->name('create');
        Route::get('/user/all', FindAllUserRestaurantsController::class)->name('find-all-user');
        Route::get('/user/{id}', GetRestaurantController::class)->name('get');
        Route::patch('/{id}', UpdateRestaurantController::class)->name('update');
        Route::delete('/{id}', DeleteRestaurantController::class)->name('delete');
        Route::post('/{id}/upload-image', UploadRestaurantImageController::class)->name('upload-image');
        Route::post('/check-subdomain', CheckSubdomainController::class)->name('check-subdomain');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/', FindAllRestaurantsController::class)->name('find-all');
    });
});

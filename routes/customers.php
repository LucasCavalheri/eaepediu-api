<?php

use App\Http\Controllers\Customer\CreateCustomerController;
use App\Http\Controllers\Customer\FindAllCustomersController;
use App\Http\Controllers\Customer\FindAllRestaurantCustomersController;
use App\Http\Controllers\Customer\UpdateCustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/customers')->name('customers.')->group(function () {
    Route::post('/', CreateCustomerController::class)->name('create');
    Route::get('/restaurant/{id}', FindAllRestaurantCustomersController::class)->name('find-all-restaurant');
    Route::middleware('admin')->group(function () {
        Route::get('/', FindAllCustomersController::class)->name('find-all');
    });
});

// Route::patch('/customers/{id}', UpdateCustomerController::class)->name('customers.update');

<?php

use App\Http\Controllers\Order\CustomerCreateOrderController;
use App\Http\Controllers\Order\DeleteOrderController;
use App\Http\Controllers\Order\FindAllOrdersController;
use App\Http\Controllers\Order\GetOrderController;
use App\Http\Controllers\Order\RestaurantCreateOrderController;
use App\Http\Controllers\Order\UpdateOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/orders')->name('orders.')->group(function () {
    Route::post('/restaurant/create', RestaurantCreateOrderController::class)->name('restaurant.create');
    Route::get('/restaurant/{id}', FindAllOrdersController::class)->name('find-all');
    Route::get('/restaurant/{id}/order/{orderId}', GetOrderController::class)->name('get');
    Route::patch('/restaurant/{restaurantId}/order/{orderId}', UpdateOrderController::class)->name('update');
    Route::delete('/restaurant/{restaurantId}/order/{orderId}', DeleteOrderController::class)->name('delete');
});

Route::post('/orders/customer/create', CustomerCreateOrderController::class)->name('customer.create');

<?php

use App\Http\Controllers\Category\CreateCategoryController;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Controllers\Category\FindAllCategoriesController;
use App\Http\Controllers\Category\FindRestaurantCategoriesController;
use App\Http\Controllers\Category\UpdateCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/categories')->name('categories.')->group(function () {
    Route::middleware('has-active-subscription')->group(function () {
        Route::post('/restaurant/{id}', CreateCategoryController::class)->name('create');
        Route::get('/', FindAllCategoriesController::class)->name('find-all');
        Route::patch('/{id}', UpdateCategoryController::class)->name('update');
        Route::delete('/{id}', DeleteCategoryController::class)->name('delete');
    });
});

Route::get('/categories/restaurant/{id}', FindRestaurantCategoriesController::class)->name('find-restaurant-categories');

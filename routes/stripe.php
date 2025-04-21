<?php

use App\Http\Controllers\Stripe\StripeCheckoutController;
use App\Http\Controllers\Stripe\SwapSubscriptionController;
use App\Http\Controllers\Stripe\CancelSubscriptionController;
use App\Http\Controllers\Stripe\ResumeSubscriptionController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::middleware('auth:sanctum')->prefix('/stripe')->name('stripe.')->group(function () {
    Route::post('/checkout', StripeCheckoutController::class)->name('checkout');
    Route::post('/swap', SwapSubscriptionController::class)->name('swap');
    Route::post('/cancel', CancelSubscriptionController::class)->name('cancel');
    Route::post('/resume', ResumeSubscriptionController::class)->name('resume');
});

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('webhook');

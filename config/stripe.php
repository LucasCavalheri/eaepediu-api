<?php

return [
    'stripe_key' => env('STRIPE_KEY'),
    'stripe_secret' => env('STRIPE_SECRET'),
    'stripe_webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'pro_price_id' => env('STRIPE_PRO_PRICE_ID'),
    'basic_price_id' => env('STRIPE_BASIC_PRICE_ID'),
    'yearly_pro_price_id' => env('STRIPE_YEARLY_PRO_PRICE_ID'),
    'yearly_basic_price_id' => env('STRIPE_YEARLY_BASIC_PRICE_ID'),
];

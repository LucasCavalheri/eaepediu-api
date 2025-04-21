<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StripeCheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'price' => 'required|string|in:basic,pro',
            'is_trial' => 'required|boolean',
            'yearly' => 'required|boolean',
        ]);

        /** @var \App\Models\User */
        $user = $request->user();

        // verifica se o usuário já tem uma assinatura ativa
        if ($user->subscribed()) {
            return $this->error('Usuário já possui uma assinatura ativa', Response::HTTP_BAD_REQUEST);
        }

        $priceId = match ($data['price']) {
            'pro' => $data['yearly']
                ? config('stripe.yearly_pro_price_id')
                : config('stripe.pro_price_id'),
            'basic' => $data['yearly']
                ? config('stripe.yearly_basic_price_id')
                : config('stripe.basic_price_id'),
        };



        $session = $user
            ->newSubscription('default', $priceId)
            ->when($data['is_trial'], fn($subscription) => $subscription->trialDays(7))
            ->checkout([
                'success_url' => config('app.frontend_url') . '/success',
                'cancel_url' => config('app.frontend_url') . '/cancel',
            ]);

        return $this->success('Checkout realizado com sucesso!', Response::HTTP_OK, [
            'url' => $session->url,
        ]);
    }
}

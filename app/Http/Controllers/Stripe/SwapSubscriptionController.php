<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SwapSubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'price' => 'required|string|in:basic,pro',
        ]);

        $priceId = $request->price === 'pro' ? config('stripe.pro_price_id') : config('stripe.basic_price_id');

        /** @var \App\Models\User */
        $user = $request->user();

        $subscription = $user->subscription('default');

        // Verifica se existe uma assinatura cancelada em grace period
        if (!$subscription || !$subscription->onGracePeriod()) {
            return $this->error(
                'Não é possível alterar uma assinatura inexistente ou fora do período de carência',
                Response::HTTP_BAD_REQUEST
            );
        }

        $subscription->swap($priceId);

        return $this->success('Assinatura alterada com sucesso!', Response::HTTP_OK);
    }
}

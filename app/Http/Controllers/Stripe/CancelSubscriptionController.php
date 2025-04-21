<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CancelSubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'now' => 'required|boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Verifica se existe uma assinatura ativa
        if (!$user->subscribed('default')) {
            return $this->error('Usuário não possui uma assinatura ativa', Response::HTTP_BAD_REQUEST);
        }

        $subscription = $user->subscription('default');

        if ($subscription->onGracePeriod()) {
            return $this->error('Usuário já está em período de carência', Response::HTTP_BAD_REQUEST);
        }


        try {
            if ($data['now']) {
                $subscription->cancelNow();
            } else {
                $subscription->cancel();
            }
        } catch (\Exception $e) {
            return $this->error('Falha ao cancelar assinatura', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success('Assinatura cancelada com sucesso', Response::HTTP_OK, [
            'grace_period' => $subscription->onGracePeriod(),
            'ends_at' => $subscription->ends_at?->toDateTimeString()
        ]);
    }
}

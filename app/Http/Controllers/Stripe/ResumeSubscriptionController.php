<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResumeSubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $subscription = $user->subscription('default');

        // Verifica se existe uma assinatura cancelada em grace period
        if (!$subscription || !$subscription->onGracePeriod()) {
            return $this->error(
                'Não é possível reativar uma assinatura inexistente ou fora do período de carência',
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $subscription->resume();
        } catch (\Exception $e) {
            return $this->error(
                'Falha na reativação: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->success('Assinatura reativada com sucesso', Response::HTTP_OK);
    }
}

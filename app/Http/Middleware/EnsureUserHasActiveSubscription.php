<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasActiveSubscription
{
    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.env') === 'local') {
            return $next($request);
        }

        /** @var \App\Models\User */
        $user = $request->user();

        if (!$user->subscribed() && !$user->onTrial()) {
            return $this->error('Usuário não possui uma assinatura ativa', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Verifica se o usuário está autenticado e se o e-mail foi verificado
        if (! $user || ! $user->hasVerifiedEmail()) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Seu e-mail ainda não foi verificado. Por favor, verifique-o para acessar esta funcionalidade.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

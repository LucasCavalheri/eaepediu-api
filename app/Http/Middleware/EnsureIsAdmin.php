<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Permite o acesso
        }

        // Retorna uma resposta 403 (proibido) caso o usuário não seja admin
        return response()->json(['message' => 'Acesso não autorizado.'], Response::HTTP_FORBIDDEN);
    }
}

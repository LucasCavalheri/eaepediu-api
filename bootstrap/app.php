<?php

use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureUserHasActiveSubscription;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin' => EnsureIsAdmin::class,
            'email-verified' => EnsureEmailIsVerified::class,
            'has-active-subscription' => EnsureUserHasActiveSubscription::class,
        ]);
        $middleware->append([
            ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === HttpResponse::HTTP_TOO_MANY_REQUESTS) {
                return response()->json([
                    'status' => HttpResponse::HTTP_TOO_MANY_REQUESTS,
                    'message' => 'Aguarde para tentar novamente',
                ], HttpResponse::HTTP_TOO_MANY_REQUESTS);
            }

            return $response;
        });
    })->create();

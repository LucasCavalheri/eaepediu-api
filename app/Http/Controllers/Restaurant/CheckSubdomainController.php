<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\CheckSubdomainRequest;
use App\Services\Cloudflare\CloudflareServiceInterface;
use Illuminate\Http\Response;

class CheckSubdomainController extends Controller
{
    public function __construct(private CloudflareServiceInterface $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }

    public function __invoke(CheckSubdomainRequest $request)
    {
        $subdomain = $request->input('subdomain');

        try {
            if (! $this->cloudflareService->checkSubdomainAvailability($subdomain)) {
                return response()->json([
                    'success' => false,
                    'message' => 'O subdomínio informado já está em uso.',
                ], Response::HTTP_CONFLICT);
            }

            return response()->json([
                'success' => true,
                'message' => 'O subdomínio está disponível.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar a disponibilidade do subdomínio. Por favor, tente novamente.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

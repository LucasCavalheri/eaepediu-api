<?php

namespace App\Services\Cloudflare;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareService implements CloudflareServiceInterface
{
    protected string $apiToken;

    protected string $accountId;

    public function __construct()
    {
        $this->apiToken = config('services.cloudflare.api_token');
        $this->accountId = config('services.cloudflare.account_id');
    }

    public function checkSubdomainAvailability(string $subdomain): bool
    {
        $response = Http::withToken($this->apiToken)
            ->get("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/workers/subdomain");

        if ($response->failed()) {
            // Log detalhado do erro
            Log::error('Erro ao verificar disponibilidade do subdomínio: ', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            // Lança uma exceção com detalhes do erro
            throw new Exception(
                'Erro ao verificar disponibilidade do subdomínio: '.$response->body(),
                $response->status()
            );
        }

        $result = $response->json('result');

        // Retorna true se o subdomínio está disponível
        return isset($result['subdomain']) && $result['subdomain'] !== $subdomain;
    }

    public function createSubdomain(string $subdomain): void
    {
        $response = Http::withToken($this->apiToken)
            ->post("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/workers/subdomain", [
                'subdomain' => $subdomain,
            ]);

        if ($response->failed()) {
            throw new \Exception('Erro ao criar o subdomínio: '.$response->body());
        }
    }
}

<?php

namespace App\Services\Cloudflare;

class MockCloudflareService implements CloudflareServiceInterface
{
    public function checkSubdomainAvailability(string $subdomain): bool
    {
        return true;
    }

    public function createSubdomain(string $subdomain): void
    {
        logger()->info("Mock: Subdomínio '{$subdomain}' criado com sucesso.");
    }
}

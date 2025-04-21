<?php

namespace App\Services\Cloudflare;

interface CloudflareServiceInterface
{
    public function checkSubdomainAvailability(string $subdomain): bool;

    public function createSubdomain(string $subdomain): void;
}

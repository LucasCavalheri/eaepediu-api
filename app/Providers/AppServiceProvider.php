<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Restaurant;
use App\Policies\CategoryPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\RestaurantPolicy;
use App\Services\Cloudflare\CloudflareService;
use App\Services\Cloudflare\CloudflareServiceInterface;
use App\Services\Cloudflare\MockCloudflareService;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CloudflareServiceInterface::class, function () {

            if (app()->environment('local')) {
                return new MockCloudflareService;
            }

            return new CloudflareService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Restaurant::class, RestaurantPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });
    }
}

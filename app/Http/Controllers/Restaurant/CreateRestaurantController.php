<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\CreateRestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Services\Cloudflare\CloudflareServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRestaurantController extends Controller
{
    protected CloudflareServiceInterface $cloudflareService;

    public function __construct(CloudflareServiceInterface $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }

    public function __invoke(CreateRestaurantRequest $request)
    {
        $data = $request->validated();

        /** @var \App\Models\User */
        $user = Auth::user();

        $totalRestaurants = $user->restaurants()->count();

        // verifica se o usuário possui já possui um restaurante e está no plano BASIC, se sim, não permite criar mais restaurantes
        if (config('app.env') === 'production' && $totalRestaurants >= 1 && $user->subscribedToPrice(config('stripe.basic_price_id'))) {
            return $this->error('Usuário não possui plano PRO', Response::HTTP_UNAUTHORIZED);
        }

        $subdomain = $request->input('subdomain');

        try {
            if (! $this->cloudflareService->checkSubdomainAvailability($subdomain)) {
                return $this->error('O subdomínio informado já está em uso.', Response::HTTP_CONFLICT);
            }

            DB::beginTransaction();

            $restaurant = $user->restaurants()->create($data);

            $this->cloudflareService->createSubdomain($subdomain);

            DB::commit();

            return $this->success('Restaurante registrado com sucesso!', Response::HTTP_CREATED, RestaurantResource::make($restaurant));
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error('Erro ao registrar o restaurante e o subdomínio. Por favor, tente novamente.', Response::HTTP_INTERNAL_SERVER_ERROR, [
                'error' => $e->getMessage(),
            ]);
        }
    }
}

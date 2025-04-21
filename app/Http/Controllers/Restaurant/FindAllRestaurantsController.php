<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllRestaurantsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->success('Restaurantes encontrados com sucesso!', Response::HTTP_OK, RestaurantResource::collection(Restaurant::with('user')->get()));
    }
}

<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllUserRestaurantsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $restaurants = $request->user()->restaurants()->get();

        return $this->success('Restaurantes encontrados com sucesso!', Response::HTTP_OK, RestaurantResource::collection($restaurants));
    }
}

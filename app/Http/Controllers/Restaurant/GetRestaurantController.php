<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetRestaurantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $restaurant = $request->user()->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Restaurante encontrado com sucesso!', Response::HTTP_OK, RestaurantResource::make($restaurant));
    }
}

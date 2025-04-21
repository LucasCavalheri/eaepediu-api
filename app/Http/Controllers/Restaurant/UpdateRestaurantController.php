<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;
use App\Http\Resources\RestaurantResource;
use Illuminate\Http\Response;

class UpdateRestaurantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRestaurantRequest $request, $id)
    {
        $data = $request->validated();

        $restaurant = $request->user()->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $restaurant->update($data);

        return $this->success('Restaurante atualizado com sucesso!', Response::HTTP_OK, RestaurantResource::make($restaurant));
    }
}

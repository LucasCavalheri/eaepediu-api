<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindRestaurantCategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        // Busca o restaurante pelo ID
        $restaurant = Restaurant::where('id', $id)->first();

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Busca as categorias do restaurante
        $categories = $restaurant->categories()->get();

        if ($categories->isEmpty()) {
            return $this->error('Nenhuma categoria encontrada', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Categorias encontradas com sucesso!', Response::HTTP_OK, CategoryResource::collection($categories));
    }
}

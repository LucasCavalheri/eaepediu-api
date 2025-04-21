<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllCategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $restaurant = $request->user()->restaurant;

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Busca todas as categorias do restaurante do usuário logado
        $categories = $restaurant->categories()->with('products')->get();

        if ($categories->isEmpty()) {
            return $this->error('Nenhuma categoria encontrada', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Categorias encontradas com sucesso!', Response::HTTP_OK, CategoryResource::collection($categories));
    }
}

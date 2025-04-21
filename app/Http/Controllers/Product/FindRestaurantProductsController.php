<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindRestaurantProductsController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        // Busca o restaurante pelo subdomínio
        $restaurant = Restaurant::find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Busca os produtos disponíveis para clientes
        $products = $restaurant->products()->where('is_available', true)->with('category', 'complements')->get();

        if ($products->isEmpty()) {
            return $this->error('Nenhum produto disponível', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Produtos encontrados com sucesso!', Response::HTTP_OK, ProductResource::collection($products));
    }
}

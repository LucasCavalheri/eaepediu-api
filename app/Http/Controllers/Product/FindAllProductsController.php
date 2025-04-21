<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Obtém o restaurante do usuário logado
        $restaurant = $request->user()->restaurant;

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Busca todos os produtos do restaurante do usuário logado
        $products = $restaurant->products()->with('category')->get();

        if ($products->isEmpty()) {
            return $this->error('Nenhum produto encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Produtos encontrados com sucesso!', Response::HTTP_OK, ProductResource::collection($products));
    }
}

<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProductRequest $request, int $id): JsonResponse
    {
        // Busca o produto pelo ID
        $product = Product::find($id);

        if (! $product) {
            return $this->error('Produto não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Atualiza os dados do produto
        $product->update($request->validated());

        // Retorna a resposta com sucesso
        return $this->success(
            'Produto atualizado com sucesso!',
            Response::HTTP_OK,
            ProductResource::make($product->load('category'))
        );
    }
}

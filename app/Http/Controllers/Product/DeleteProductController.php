<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id): JsonResponse
    {
        // Busca o produto pelo ID
        $product = Product::find($id);

        if (! $product) {
            return $this->error('Produto não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Deleta o produto
        $product->delete();

        return $this->success('Produto deletado com sucesso!', Response::HTTP_OK);
    }
}

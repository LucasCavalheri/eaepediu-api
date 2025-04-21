<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplementResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FindAllComplementsController extends Controller
{
    public function __invoke(int $productId): JsonResponse
    {
        $product = Product::find($productId);

        if (! $product) {
            return $this->error('Produto não encontrado', Response::HTTP_NOT_FOUND);
        }

        $complements = $product->complements()->get();

        if ($complements->isEmpty()) {
            return $this->error('Nenhum complemento encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success(
            'Complementos encontrados com sucesso!',
            Response::HTTP_OK,
            ComplementResource::collection($complements)
        );
    }
}

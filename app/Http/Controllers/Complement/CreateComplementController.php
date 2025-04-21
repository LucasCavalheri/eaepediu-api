<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complement\CreateComplementRequest;
use App\Http\Resources\ComplementResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateComplementController extends Controller
{
    public function __invoke(CreateComplementRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $product = Product::find($validated['product_id']);

        if (!$product) {
            return $this->error('Produto não encontrado', Response::HTTP_NOT_FOUND);
        }

        $complement = $product->complements()->create($validated);

        return $this->success(
            'Complemento criado com sucesso!',
            Response::HTTP_CREATED,
            ComplementResource::make($complement)
        );
    }
}

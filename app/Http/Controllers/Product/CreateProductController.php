<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CreateProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateProductRequest $request, $id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $product = $restaurant->products()->create(array_merge(
            $request->validated(),
            ['category_id' => $request->category_id]
        ));

        return $this->success(
            'Produto criado com sucesso!',
            Response::HTTP_CREATED,
            ProductResource::make($product->load('category'))
        );
    }
}

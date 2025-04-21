<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Response;

class ListCartsController extends Controller
{
    public function __invoke()
    {
        $carts = Cart::with('items.product')->get();

        if ($carts->isEmpty()) {
            return $this->error('Nenhum carrinho encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success('Carrinhos encontrados com sucesso!', Response::HTTP_OK, CartResource::collection($carts));
    }
}

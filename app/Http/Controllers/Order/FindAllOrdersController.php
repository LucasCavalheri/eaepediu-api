<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        // Obtém o restaurante do usuário logado
        $restaurant = $request->user()->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Busca todos os pedidos do restaurante, incluindo orderItems
        $orders = $restaurant->orders()->with(['customer', 'orderItems.product', 'orderItems.complement'])->get();

        if ($orders->isEmpty()) {
            return $this->error('Nenhum pedido encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success(
            'Pedidos encontrados com sucesso!',
            Response::HTTP_OK,
            OrderResource::collection($orders)
        );
    }
}

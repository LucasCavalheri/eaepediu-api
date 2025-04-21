<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $restaurantId, int $orderId): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $restaurant = $user->restaurants()->find($restaurantId);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $order = $restaurant->orders()->find($orderId);

        if (! $order) {
            return $this->error('Pedido não encontrado', Response::HTTP_NOT_FOUND);
        }

        $order->delete();

        return $this->success('Pedido excluído com sucesso!', Response::HTTP_OK);
    }
}

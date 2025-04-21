<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateOrderRequest $request, int $restaurantId, int $orderId): JsonResponse
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

        $order->update($request->validated());

        return $this->success(
            'Pedido atualizado com sucesso!',
            Response::HTTP_OK,
            OrderResource::make($order)
            // OrderResource::make($order->load('customer', 'orderItems.product', 'orderItems.complement'))
        );
    }
}

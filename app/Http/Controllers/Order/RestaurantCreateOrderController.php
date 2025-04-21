<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RestaurantCreateOrderController extends Controller
{
    /**
     * Handle the incoming request for restaurants.
     */
    public function __invoke(CreateOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Obtém o restaurante autenticado
        $restaurant = $request->user()->restaurant;

        if (!$restaurant) {
            return $this->error(
                'Apenas restaurantes autenticados podem criar pedidos manualmente.',
                Response::HTTP_FORBIDDEN
            );
        }

        // Busca o cliente pelo ID e valida se pertence ao restaurante
        $customer = Customer::where('id', $validated['customer_id'])
            ->where('restaurant_id', $restaurant->id)
            ->first();

        if (!$customer) {
            return $this->error(
                'Cliente não encontrado ou não pertence a este restaurante.',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->createOrder($validated, $customer, $restaurant);
    }

    /**
     * Cria o pedido para o restaurante.
     */
    private function createOrder(array $validated, Customer $customer, $restaurant): JsonResponse
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'status' => 'pending',
                'total_price' => 0,
                'customer_id' => $customer->id,
                'restaurant_id' => $restaurant->id,
                'discount' => $validated['discount'] ?? 0,
                'tax' => $validated['tax'] ?? 0,
            ]);

            $totalPrice = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    DB::rollBack();
                    return $this->error(
                        "Produto com ID {$item['product_id']} não encontrado.",
                        Response::HTTP_NOT_FOUND
                    );
                }

                $subtotal = $item['quantity'] * $product->price;

                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'complement_id' => $item['complement_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalPrice += $subtotal;
            }

            $order->update([
                'total_price' => $totalPrice + $order->tax - $order->discount,
            ]);

            DB::commit();

            return $this->success(
                'Pedido criado com sucesso!',
                Response::HTTP_CREATED,
                OrderResource::make($order->load('orderItems.product', 'orderItems.complement'))
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error(
                'Erro ao criar o pedido: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

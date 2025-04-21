<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Complement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerCreateOrderController extends Controller
{
    public function __invoke(CreateOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Busca o cliente pelo número de telefone e restaurante
        $customer = Customer::where('phone_number', $validated['phone_number'])
            ->where('restaurant_id', $validated['restaurant_id'])
            ->first();

        if (!$customer) {
            // Retorna erro informando que o cliente não foi encontrado
            return $this->error(
                'Cliente não encontrado. É necessário preencher os dados.',
                Response::HTTP_NOT_FOUND,
            );
        }

        return $this->createOrder($validated, $customer);
    }

    /**
     * Cria o pedido para o cliente.
     */
    private function createOrder(array $validated, Customer $customer): JsonResponse
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'status' => 'PENDING',
                'total_price' => 0, // Será calculado posteriormente
                'customer_id' => $customer->id,
                'restaurant_id' => $validated['restaurant_id'],
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

                // Busca o preço do complemento, se existir
                $complementPrice = 0;
                if (isset($item['complement_id'])) {
                    $complement = Complement::find($item['complement_id']);
                    if ($complement) {
                        $complementPrice = $complement->price;
                    }
                }

                // Calcula o subtotal incluindo o preço do complemento
                $subtotal = ($item['quantity'] * $product->price) + $complementPrice;

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

            $order->refresh();

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

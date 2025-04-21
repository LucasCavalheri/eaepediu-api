<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'complement' => ComplementResource::make($this->whenLoaded('complement')),
            'quantity' => $this->quantity,
            'price' => (float)$this->price,
            'subtotal' => (float)$this->subtotal,
        ];
    }
}

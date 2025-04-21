<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'subdomain' => $this->subdomain,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'photo_url' => $this->photo_url,
            'address' => $this->address,
            'colors' => $this->colors,
            'opening_hours' => $this->opening_hours,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}

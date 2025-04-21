<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float)$this->price,
            'image_url' => $this->image_url ? $this->getImageUrl() : null,
            'is_available' => $this->is_available,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'complements' => ComplementResource::collection($this->whenLoaded('complements')),
            // 'restaurant' => RestaurantResource::make($this->whenLoaded('restaurant')),
        ];
    }

    private function getImageUrl()
    {
        $disk = config('app.env') === 'local' ? 'public' : 's3';

        /** @var \Illuminate\Filesystem\FilesystemManager $storage */
        $storage = Storage::disk($disk);

        return $storage->url($this->image_url);
    }
}

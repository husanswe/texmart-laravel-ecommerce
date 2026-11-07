<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => is_array($this->slug) ? ($this->slug['uz'] ?? '') : $this->slug,
            'price' => $this->price,
            'description' => $this->description,
            'images' => ProductImageResource::collection($this->whenLoaded('productImage')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'category' => new CategoryResource($this->whenLoaded('category')),

            'productVariant' => $this->whenLoaded('productVariant', fn() => $this->productVariant->map(fn($v) => [
                'id' => $v->id,
                'name' => $v->name,
                'sku' => $v->sku,
                'price' => $v->price,
                'stock' => $v->stock,
            ])),
        ];
    }
}

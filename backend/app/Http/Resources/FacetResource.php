<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'product_count' => $this->product_count,

            'attribute' => [
                'name' => $this->attribute->name,
                'unit' => $this->attribute->unit,
            ]
        ];
    }
}

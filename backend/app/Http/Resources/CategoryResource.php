<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->id,
            'slug' => $this->id,
            'icon' => $this->id,
            'children' => CategoryResource::collection($this->whenLoaded('children'))
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'image_path' => $this->image_path,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'status' => $this->status,
            // Timestamps removed as per v1 requirements
            // 'deleted_at' is explicitly removed as per requirements
        ];
    }
}

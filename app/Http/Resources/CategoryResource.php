<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'category_id' => $this->category_id,
            'image' => $this->image,
            'image_name' => $this->image_name,
            'category' => $this->category,
            'description' => $this->description
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'brand_id' => $this->brand_id,
            'image' => $this->image,
            'image_name' => $this->image_name,
            'brand' => $this->brand,
            'description' => $this->description
        ];
    }
}

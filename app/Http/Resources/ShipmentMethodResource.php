<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentMethodResource extends JsonResource
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
            'shipment_method_id' => $this->shipment_method_id,
            'image' => $this->image,
            'image_name' => $this->image_name,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}

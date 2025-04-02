<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'payment_method_id' => $this->payment_method_id,
            'image' => $this->image,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}

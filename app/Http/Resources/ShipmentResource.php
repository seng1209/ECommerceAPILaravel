<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
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
            'shipment_id' => $this->shipment_id,
            'shipment_date' => $this->shipment_date,
            'shipment_method' => new ShipmentMethodResource($this->shipmentMethod),
            'user' => new UserResource($this->user),
            'order_id' => $this->order_id,
            'city' => $this->city,
            'street_address' => $this->street_address,
        ];
    }
}

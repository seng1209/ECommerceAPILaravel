<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'payment_id' => $this->payment_id,
            'payment_date' => $this->payment_date,
            'payment_method' => new PaymentMethodResource($this->paymentMethod),
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}

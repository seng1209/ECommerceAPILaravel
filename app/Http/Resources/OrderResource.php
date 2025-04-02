<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_id' => $this->order_id,
            'order_date' => $this->order_date,
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
        ];
    }
}

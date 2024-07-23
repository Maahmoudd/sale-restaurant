<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'meal' => MealResource::make($this->whenLoaded('meal')),
            'quantity' => $this->quantity,
            'amount_to_pay' => $this->amount_to_pay,
        ];
    }
}

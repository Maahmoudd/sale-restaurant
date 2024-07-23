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
        return [
            'table' => TableResource::make($this->whenLoaded('table')),
            'reservation' => ReservationResource::make($this->whenLoaded('reservation')),
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'total' => $this->total,
            'paid' => $this->paid,
            'date' => $this->date,
            'order_details' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}

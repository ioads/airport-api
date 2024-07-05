<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
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
            'origin_id' => $this->origin_id,
            'destination_id' => $this->destination_id,
            'code' => $this->code,
            'departure' => $this->departure,
            'seats_available' => $this->seats_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'origin' => $this->origin,
            'destination' => $this->destination,
        ];
    }
}

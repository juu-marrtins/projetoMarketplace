<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'userId' => $this->userId,
            'street' => $this->street,
            'number' => $this->number,
            'zip' => $this->zip,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country
        ];
    }
}

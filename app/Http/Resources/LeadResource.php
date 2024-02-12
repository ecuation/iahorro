<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'phone' => $this->email,
            'mortgage_request_amount' => $this->mortgage_request_amount,
            'purpose_mortgage' => $this->purpose_mortgage,
            'score' => $this->score,
            'client' => $this->client
        ];
    }
}

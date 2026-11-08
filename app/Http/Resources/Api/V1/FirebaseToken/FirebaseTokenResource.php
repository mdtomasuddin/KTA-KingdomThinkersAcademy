<?php

namespace App\Http\Resources\Api\V1\FirebaseToken;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FirebaseTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => (int) $this->id,
            'user_id'   => (int) $this->user_id,
            'token'     => $this->token,
            'device_id' => $this->device_id,
        ];
    }
}


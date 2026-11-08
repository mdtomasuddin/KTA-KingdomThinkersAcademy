<?php

namespace App\Http\Resources\Api\V1\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'category'         => $this->category,
            'title'            => $this->data['title'] ?? null,
            'message'          => $this->data['message'] ?? $this->data['body'] ?? null,
            'type'             => $this->data['type'] ?? $this->type,
            'data'             => $this->data,
            'read_at'          => $this->read_at,
            'created_at'       => $this->created_at,
            'created_at_human' => $this->created_at?->diffForHumans(),
        ];
    }
}

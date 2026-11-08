<?php

namespace App\Http\Resources\Api\V1\Settings\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'slug' => $this->slug,
            'url'  => $this->url,
        ];
    }
}


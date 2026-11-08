<?php

namespace App\Http\Resources\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                         => $this->id,
            'employee_id'                => $this->employee_id,
            'first_name'                 => $this->first_name,
            'last_name'                  => $this->last_name,
            'full_name'                  => $this->full_name,
            'username'                   => $this->username,
            'email'                      => $this->email,
            'phone'                      => $this->phone,
            'designation'                => $this->designation,
            'gender'                     => $this->gender ? ucfirst($this->gender) : null,
            'birthday'                   => $this->birthday?->format('Y-m-d'),
            'birthday_formatted'         => $this->birthday?->format('d F, Y'),
            'emergency_contact'          => $this->emergency_contact,
            'emergency_contact_relation' => $this->emergency_contact_relation,
            'address'                    => $this->address,
            'avatar'                     => $this->avatar,
            'cover'                      => $this->cover,
            'signature_image'            => $this->signature_image,
            'bio'                        => $this->bio,
            'role'                       => $this->role,
            'timezone'                   => $this->timezone,
            'status'                     => $this->status,
            'terms_and_conditions'       => (bool) $this->terms_and_conditions,
            'created_at'                 => $this->created_at?->toIso8601String(),
        ];
    }
}

<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'first_name'                 => ['nullable', 'string', 'max:100'],
            'last_name'                  => ['nullable', 'string', 'max:100'],
            'username'                   => ['nullable', 'string', 'max:50', Rule::unique('users', 'username')->ignore($userId)],
            'phone'                      => ['nullable', 'string', 'max:20'],
            'emergency_contact'          => ['nullable', 'string', 'max:100'],
            'emergency_contact_relation' => ['nullable', 'string', 'max:100'],
            'designation'                => ['nullable', 'string', 'max:150'],
            'gender'                     => ['nullable', 'string', 'in:male,female,other'],
            'birthday'                   => ['nullable', 'date'],
            'address'                    => ['nullable', 'string', 'max:500'],
            'bio'                        => ['nullable', 'string', 'max:1000'],
            'timezone'                   => ['nullable', 'string', 'max:50'],
            'avatar'                     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'cover'                      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'signature_image'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ];
    }
}


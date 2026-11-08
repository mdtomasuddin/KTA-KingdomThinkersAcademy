<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'first_name'           => ['required', 'string', 'max:100'],
            'last_name'            => ['nullable', 'string', 'max:100'],
            'username'             => ['nullable', 'string', 'max:100'],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'                 => ['nullable', 'string', 'in:parent,student,teacher,contracted_teacher,coop,micro_school,admin,super_admin'],
            'password'             => ['required', 'string', 'min:6'],
            'terms_and_conditions' => ['required', 'boolean', 'accepted'],
        ];
    }
}

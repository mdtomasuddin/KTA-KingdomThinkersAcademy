<?php

namespace App\Http\Requests\Web\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['nullable', 'string', 'max:255'],
            'employee_id' => ['nullable', 'string', 'max:50'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'password'    => ['required', 'string', Password::defaults()],
            'role'        => ['nullable', 'string', 'in:parent,student,teacher,contracted_teacher,coop,micro_school,admin,super_admin'],
            'designation' => ['nullable', 'string', 'max:150'],
            'gender'      => ['nullable', 'string', 'in:male,female,other'],
            'status'      => ['nullable', 'string', 'in:active,inactive,suspended'],
            'avatar'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'cover'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'bio'         => ['nullable', 'string', 'max:500'],
            'address'     => ['nullable', 'string', 'max:255'],
            'location'    => ['nullable', 'string', 'max:255'],
            'birthday'    => ['nullable', 'date'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'email.required'      => 'A valid email address is required.',
            'email.unique'        => 'This email address is already in use.',
            'password.required'   => 'Password is required.',
        ];
    }
}

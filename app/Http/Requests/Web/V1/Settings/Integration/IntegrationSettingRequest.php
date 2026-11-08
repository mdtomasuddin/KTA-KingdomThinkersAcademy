<?php

namespace App\Http\Requests\Web\V1\Settings\Integration;

use Illuminate\Foundation\Http\FormRequest;

class IntegrationSettingRequest extends FormRequest
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
        $route = $this->route()?->getName();

        return match ($route) {
            'google.update' => [
                'GOOGLE_CLIENT_ID'     => ['nullable', 'string', 'max:255'],
                'GOOGLE_CLIENT_SECRET' => ['nullable', 'string', 'max:255'],
                'GOOGLE_REDIRECT_URI'  => ['nullable', 'string', 'max:255'],
            ],
            'apple.update'  => [
                'APPLE_CLIENT_ID' => ['required', 'string', 'max:255'],
                'APPLE_TEAM_ID'   => ['required', 'string', 'max:255'],
                'APPLE_KEY_ID'    => ['required', 'string', 'max:255'],
                'apple_key_file'  => ['nullable', 'file', 'max:2048'],
            ],
            default         => [],
        };
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'GOOGLE_CLIENT_ID.string'       => 'The Google Client ID must be a valid string.',
            'GOOGLE_CLIENT_SECRET.string'   => 'The Google Client Secret must be a valid string.',
            'GOOGLE_REDIRECT_URI.string'    => 'The Google Redirect URI must be a valid string.',
            'APPLE_CLIENT_ID.required'      => 'The Apple Client ID is required.',
            'APPLE_TEAM_ID.required'        => 'The Apple Team ID is required.',
            'APPLE_KEY_ID.required'         => 'The Apple Key ID is required.',
            'apple_key_file.file'           => 'The Apple Private Key file must be a valid file.',
        ];
    }
}

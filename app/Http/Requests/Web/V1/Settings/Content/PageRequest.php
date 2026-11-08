<?php

namespace App\Http\Requests\Web\V1\Settings\Content;

use App\Models\Content;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $page   = $this->route('page');
        $pageId = $page instanceof Content ? $page->id : $page;

        return [
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('contents', 'slug')->ignore($pageId),
            ],
            'content' => ['required', 'string', 'min:5'],
            'status'  => ['nullable', 'string', 'in:active,inactive'],
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
            'title.required'   => 'The title field is required.',
            'title.max'        => 'The title may not be greater than 255 characters.',
            'slug.unique'      => 'The slug has already been taken.',
            'content.required' => 'The content field is required.',
            'content.min'      => 'The content must be at least 5 characters.',
            'status.in'        => 'The status must be either active or inactive.',
        ];
    }
}

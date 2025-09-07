<?php

namespace App\Http\Requests\Dashboard\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInfoPageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title_en' => [
                'string',
            ],
            'title_ar' => [
                'string',
            ],
            'description_en' => [
                'string',
                'nullable',
            ],
            'description_ar' => [
                'string',
                'nullable',
            ],
            'type' => [
                'string',
            ],
            'order' => [
                'string',
            ],
            'media_path' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png'
            ]
        ];
    }
}

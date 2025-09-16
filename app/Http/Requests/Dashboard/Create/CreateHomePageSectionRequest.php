<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateHomePageSectionRequest extends FormRequest
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
                'required',
                'string',
            ],
            'title_ar' => [
                'required',
                'string',
            ],
            'description_en' => [
                'required',
                'string',
            ],
            'description_ar' => [
                'required',
                'string',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(array_keys(\App\Enums\GeneralEnums::HomePageSectionTypes['en'])), 
            ],
            'order' => [
                'required',
                'integer',
            ],
            'media' => [
                'nullable',
                'array',
            ],
            'media.*' => [
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp,mp4,avi,mov',
                'max:10000', // Max size 10MB
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInfoPageRequest extends FormRequest
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
                Rule::in(array_keys(\App\Enums\GeneralEnums::InfoPageTypes['en'])),
            ],
            'order' => [
                'required',
                'integer',
            ],
            'media_path' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
            'project_id' => [
                'nullable',
                'integer',
                'exists:projects,id',
            ],
        ];
    }
}

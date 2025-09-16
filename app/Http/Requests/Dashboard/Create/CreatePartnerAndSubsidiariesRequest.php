<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePartnerAndSubsidiariesRequest extends FormRequest
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
            'url' => [
                'required',
                'string',
            ],
            'name_en' => [
                'required',
                'string',
            ],
            'name_ar' => [
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
                Rule::in(array_keys(\App\Enums\GeneralEnums::SubsidiaryTypes['en'])),
            ],
            'img' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
        ];
    }
}

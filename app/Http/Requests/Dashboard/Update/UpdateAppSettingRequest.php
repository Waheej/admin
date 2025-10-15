<?php

namespace App\Http\Requests\Dashboard\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppSettingRequest extends FormRequest
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
            'value' => [
                'string',
            ],
            'icon' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,gif,svg',
                'max:3000', // Max size in KB
            ],
        ];
    }
}

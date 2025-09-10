<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProjectRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
            ],
            'lat' => [
                'required',
                'string',
            ],
            'long' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'string',
            ],
        ];
    }
}

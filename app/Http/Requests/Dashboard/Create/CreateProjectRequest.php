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
            'city' => [
                'required',
                'string',
            ],
            'apartment_type' => [
                'required',
                'string',
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('projects', 'id'),
            ],
            'price' => [
                'required',
                'string',
            ],
            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'map' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
            'image' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
            'image_mobile' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
        ];
    }
}

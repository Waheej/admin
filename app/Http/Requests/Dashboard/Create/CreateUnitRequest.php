<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUnitRequest extends FormRequest
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
            'lat' => [
                'nullable',
                'string',
            ],
            'long' => [
                'nullable',
                'string',
            ],
            'city_en' => [
                'required',
                'string',
            ],
            'city_ar' => [
                'required',
                'string',
            ],
            'apartment_type' => [
                'required',
                'string',
                Rule::in(array_keys(\App\Enums\GeneralEnums::PropertyTypes['en'])),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('projects', 'id'),
            ],
            'price' => [
                'nullable',
                'string',
            ],
            'space_area' => [
                'required',
                'integer',
            ],
            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'map' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
            'image' => [
                'nullable',
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
            'video' => [
                'nullable',
                'file',
                'mimes:mp4,avi,mov',
                'max:10240', // Max size 10MB
            ],
            'rendered_images' => [
                'nullable',
                'array',
            ],
            'rendered_images.*' => [
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size 10MB
            ],
            'rendered_images_mobile' => [
                'nullable',
                'array',
            ],
            'rendered_images_mobile.*' => [
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size 10MB
            ],
        ];
    }
}

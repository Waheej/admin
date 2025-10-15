<?php

namespace App\Http\Requests\Dashboard\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
                'string',
            ],
            'name_ar' => [
                'string',
            ],
            'description_en' => [
                'string',
            ],
            'description_ar' => [
                'string',
            ],
            'status' => [
                'string',
            ],
            'lat' => [
                'string',
            ],
            'long' => [
                'string',
            ],
            'city_en' => [
                'string',
            ],
            'city_ar' => [
                'string',
            ],
            'apartment_type' => [
                'string',
                Rule::in(array_keys(\App\Enums\GeneralEnums::PropertyTypes['en'])),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('projects', 'id'),
            ],
            'price' => [
                'string',
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
                'max:10240', // Max size in KB
            ],
            'rendered_images' => [
                'nullable',
                'array',
            ],
            'rendered_images.*' => [
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
            'rendered_images_mobile' => [
                'nullable',
                'array',
            ],
            'rendered_images_mobile.*' => [
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10000', // Max size in KB
            ],
        ];
    }
}

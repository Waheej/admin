<?php

namespace App\Http\Requests\Dashboard\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSEORequest extends FormRequest
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
            ],
            'description_ar' => [
                'string',
            ],
            'keywords_en' => [
                'string',
            ],
            'keywords_ar' => [
                'string',
            ],
            'url' => [
                'string',
            ],
            'og_title_en' => [
                'string',
            ],
            'og_title_ar' => [
                'string',
            ],
            'og_description_en' => [
                'string',
            ],
            'og_description_ar' => [
                'string',
            ],
            'og_url' => [
                'string',
            ],
            'twitter_title_en' => [
                'string',
            ],
            'twitter_title_ar' => [
                'string',
            ],
            'twitter_description_en' => [
                'string',
            ],
            'twitter_description_ar' => [
                'string',
            ],
            'twitter_url' => [
                'string',
            ],
            'canonical_url' => [
                'string',
            ],
            'robots' => [
                'string',
            ],
            'page' => [
                'string',
                Rule::in(array_keys(\App\Enums\GeneralEnums::SEOPages['en'])),
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],
            'og_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],
            'twitter_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],
        ];
    }
}

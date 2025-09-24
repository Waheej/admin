<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSEORequest extends FormRequest
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
            'keywords_en' => [
                'required',
                'string',
            ],
            'keywords_ar' => [
                'required',
                'string',
            ],
            'url' => [
                'required',
                'string',
            ],
            'og_title_en' => [
                'required',
                'string',
            ],
            'og_title_ar' => [
                'required',
                'string',
            ],
            'og_description_en' => [
                'required',
                'string',
            ],
            'og_description_ar' => [
                'required',
                'string',
            ],
            'og_url' => [
                'required',
                'string',
            ],
            'twitter_title_en' => [
                'required',
                'string',
            ],
            'twitter_title_ar' => [
                'required',
                'string',
            ],
            'twitter_description_en' => [
                'required',
                'string',
            ],
            'twitter_description_ar' => [
                'required',
                'string',
            ],
            'twitter_url' => [
                'required',
                'string',
            ],
            'canonical_url' => [
                'required',
                'string',
            ],
            'robots' => [
                'required',
                'string',
            ],
            'page' => [
                'required',
                'string',
                Rule::in(array_keys(\App\Enums\GeneralEnums::SEOPages['en'])),
            ],
            'image' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],
            'og_image' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],
            'twitter_image' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:5000', // Max size in KB
            ],

        ];
    }
}

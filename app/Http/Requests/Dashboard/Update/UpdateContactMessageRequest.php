<?php

namespace App\Http\Requests\Dashboard\Update;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactMessageRequest extends FormRequest
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
            'status' => [
                'string',
                Rule::in(array_keys(GeneralEnums::ContactMessageStatuses['en']))
            ],
        ];
    }
}

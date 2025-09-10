<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactMessageRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'country_code' => [
                'required',
                'string',
                'min:2',
                'max:4',
            ],
            'mobile' => [
                'required',
                'string',
                'min:10',
                'max:11',
            ],
            'email' => [
                'required',
                'email',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
            ],
            'project_id' => [
                'required',
                'nullable',
                'integer',
                'exists:projects,id',
            ],
        ];
    }
}

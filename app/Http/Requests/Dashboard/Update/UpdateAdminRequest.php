<?php

namespace App\Http\Requests\Dashboard\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
            'full_name' => [
                'string',
            ],
            'email' => [
                'string',
                'email',
                Rule::unique('admins')->ignore($this->admin),
            ],
            'country_code' => [
                'string',
            ],
            'mobile' => [
                'string',
                Rule::unique('admins')->ignore($this->admin),
            ],
            'locale' => [
                'string',
            ],
            'role_id' => [
                Rule::exists('roles', 'id')->whereNull('deleted_at'),
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
            ],
        ];
    }
}

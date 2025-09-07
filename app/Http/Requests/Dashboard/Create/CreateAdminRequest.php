<?php

namespace App\Http\Requests\Dashboard\Create;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAdminRequest extends FormRequest
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
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('admins'),
            ],
            'country_code' => [
                'required',
                'string',
            ],
            'mobile' => [
                'required',
                'string',
                Rule::unique('admins')->where(function ($query) {
                    return $query->where('country_code', $this->country_code);
                }),
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')->whereNull('deleted_at'),
            ],
        ];
    }
}

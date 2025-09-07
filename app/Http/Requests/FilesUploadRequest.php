<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseValidationRequest;

/**
 * Class FilesUploadRequest
 *
 * @package App\Http\Requests
 *
 * @property array $files
 */

class FilesUploadRequest extends BaseValidationRequest
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
            'files' => [
                'required',
                'array'
            ],
            'files.*' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,txt,ppt,pptx',
                'max:10000'
            ]
        ];
    }
}

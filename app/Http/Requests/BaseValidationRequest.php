<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
/**
 * Class BaseValidationRequest
 *
 * This class extends the FormRequest class and provides a custom implementation for handling failed validation.
 * When validation fails, it throws an HttpResponseException with an API response containing the validation errors.
 */
class BaseValidationRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiResponse(
                false,
                trans("messages.validation_error"),
                Response::HTTP_BAD_REQUEST,
                getValidationErrorData(collect($validator->errors()))
            )
        );
    }
}

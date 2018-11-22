<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\InvalidRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()) {
            throw new InvalidRequestException(current(current($validator->errors()->messages())));
        }


        parent::failedValidation($validator);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     */
    protected function failedAuthorization()
    {
        if ($validator->errors()) {
            throw new HttpException(403);
        }

        parent::failedAuthorization();
    }
}

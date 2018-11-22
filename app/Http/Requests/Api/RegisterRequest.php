<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        if ($this->routeIs('api.register.captcha')) {
            return [
                'phone' => 'required'
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'phone.required' => 2
        ];
    }
}

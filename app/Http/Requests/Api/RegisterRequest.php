<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use App\Models\Sms;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        $phone = [
            'required',
            'regex:/^((13|17|14|18)[0-9]|15[01235789])(\d|[0-9]){8}$/is'
        ];

        $reg_phone = array_merge($phone, ['unique:users,phone']);

        $rule_captcha = [
            'phone' => $phone,
            'type' => [
                'required',
                Rule::in(array_keys(Sms::$typeMap)),
            ]
        ];

        $rule_login = [
            'phone' => $phone,
            'type' => [
                'required',
                Rule::in(config('services.my.app_login_type')),
            ]
        ];

        // 路由判断 发送短信验证码
        if ($this->routeIs('api.register.captcha')) {
            return $rule_captcha;
        }
        // 路由判断 登录
        if ($this->routeIs('api.login.index')) {
            return $rule_login;
        }

        // 默认
        return [
            'phone' => $reg_phone,
            'captcha' => 'required|numeric',
            'type' => [
                'required',
                Rule::in(config('services.my.app_login_type')),
            ]
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 100402,
            'phone.regex' => 100403,
            'phone.unique' => 100102,
            'type.required' => 100402,
            'type.in' => 100403,
            'captcha.required' => 100402,
            'captcha.numeric' => 100403
        ];
    }
}

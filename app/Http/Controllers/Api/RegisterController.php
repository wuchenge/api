<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 16:20:03
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Sms;
use App\Http\Requests\Api\RegisterRequest;

class RegisterController extends ApiController
{
    public function captcha(RegisterRequest $request)
    {
        $result = Sms::send($request->input('phone'), $request->input('type'));

        if ($result) {
            return $this->response();
        } else {
            return $this->failed();
        }
    }
}

<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 16:20:03
 */

namespace App\Http\Controllers\Api;

use App\Models\Sms;
use App\Models\User;
use App\Http\Requests\Api\RegisterRequest;

class RegisterController extends ApiController
{
    /**
     * @api {post|get} json 头部约定
     * @apiGroup A-format
     * @apiDescription 所有请求头部参数 Authorization:为登录凭证;app-language:为语言设置, 默认:zh_CN
     *
     * @apiParam {string} Content-Type  传输格式
     * @apiParam {string} Authorization  登录凭证
     * @apiParam {string} fund-language  返回语言消息
     *
     * @apiHeaderExample {json} 头部请求 application:
     *
        {
            "Content-Type:application/json",
            "Authorization:token",
            "app-language:zh_CN"
        }
     */

    /**
     * @api {post} example 返回约定
     * @apiGroup A-format
     * @apiDescription 返回约定
     *
     * @apiSuccessExample 成功返回案例
     *
     * {
     * "error_code": 0,
     * "message": "success",
     * "data": {}
     * }
     *
     * @apiSuccess {number} error_code 错误码 0： 成功  其他：失败
     * @apiSuccess {struct} message  API提示信息
     * @apiSuccess {struct} data   数据对象
     *
     */

    /**
     * @api {post} captcha 发送验证码
     * @apiGroup login
     * @apiDescription 发送验证码
     *
     * @apiParam {string} phone  电话号码
     * @apiParam {number} type  1:注册；2:登录；3,4,5...
     *
     * @apiParamExample {json} 请求用例

        {
            "phone": "15217050086",
            "type": 1
        }

     * @apiSuccessExample 成功返回案例

        {
            "error_code": 0,
            "message": "success",
            "data": {}
        }

     * @apiSuccess {int} error_code 错误码
     * @apiSuccess {string} message 错误信息
     * @apiSuccess {object} data   数据对象
     *
     */
    public function captcha(RegisterRequest $request)
    {
        // 开启debug 则不发送
        if (config('app.debug')) {
            return $this->response();
        }

        $result = Sms::send($request->input('phone'), $request->input('type'));

        if ($result) {
            return $this->response();
        } else {
            return $this->failed();
        }
    }

    /**
     * @api {post} register 注册
     * @apiDescription 注册
     * @apiGroup login
     *
     * @apiParam {string} phone  电话号码
     * @apiParam {string} captcha  验证码
     * @apiParam {string} type  注册种类 web phone
     *
     * @apiParamExample {json} 请求用例
     *
        {
            "phone": "15217050086",
            "type": "phone",
            "captcha": "123456"
        }
     *
     * @apiSuccessExample 成功返回案例
     *
        {
            "data": {
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJTSEEyNTYifQ.eyJpc3MiOiJhcHBGdW5kIiwiaWF0IjoxNTQwOTY2MzMyLCJleHAiOjE1NDE1NzExMzIsImlkIjozLCJ0eXBlIjoicGhvbmUiLCJ2ZXJzaW9uIjoxfQ.b602b0fd82f9e8c3de0e1121ed0172cbd7c0b2aef81fea904703468dc72e6692"
            },
            "message": "成功",
            "error_code": 0
        }
     *
     * @apiSuccess {int} error_code 错误码
     * @apiSuccess {string} message 错误信息
     * @apiSuccess {object} data   数据对象
     * @apiSuccess {string} token   登录凭证
     *
     */
    public function index(RegisterRequest $request)
    {
        // 手机号码
        $phone = $request->input('phone');
        // 验证码
        $captcha = $request->input('captcha');
        // 登录方式
        $type = $request->input('type');

        // 验证手机号码和验证
        if (!Sms::validateCaptcha($phone, $captcha, Sms::TYPE_REG)) {
            return $this->setErrorCode(100101)->response();
        }

        // 创建用户
        $data = [
            'phone' => $phone,
            'type' => $type
        ];
        $user = User::store($data);

        if ($user) {
            $payload = [
                'id' => $user->id,
                'type' => $type,
                'version' => 1
            ];

            $data = [
                'token' => $this->createToken($payload)
            ];
            return $this->response($data);
        }

        return $this->failed();
    }
}

<?php
/**
 * @Author: wuchenge
 * @Date: 2018-11-22 16:20:03
 */

namespace App\Http\Controllers\Api;

use App\Models\Sms;
use App\Models\User;
use App\Http\Requests\Api\RegisterRequest;
use Carbon\Carbon;

class LoginController extends ApiController
{
    /**
     * @api {post} login 登录
     * @apiDescription 登录
     * @apiGroup login
     *
     * @apiParam {string} phone  电话号码
     * @apiParam {string} captcha  验证码
     * @apiParam {string} type  登录种类 web phone
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
        if (!Sms::validateCaptcha($phone, $captcha, Sms::TYPE_LON)) {
            return $this->setErrorCode(100101)->response();
        }

        $user = User::with('tokens')
            ->where('phone', $phone)
            ->first();

        if (!$user) {
            return $this->setErrorCode(100104)->response();
        }

        if ($user->status == User::STATUS_NO) {
            return $this->setErrorCode(100103)->response();
        }

        // 版本加1
        $res = User::updateVersion($user->id, $type);

        if (!$res) {
            return $this->setErrorCode(100104)->response();
        }

        $payload = [
            'id' => $user->id,
            'type' => $type,
            'version' => $res
        ];

        $data = [
            'token' => $this->createToken($payload)
        ];

        // 更新最后登录时间
        $user->fill(['updated_at' => date('Y-m-d H:i:s')])->save();

        return $this->response($data);
    }

    /**
     * @api {post} login 刷新token
     * @apiDescription 需要登录凭证
     * @apiGroup login
     *
     * @apiParamExample {json} 请求用例
     *
        {

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
    public function refresh()
    {
        $user = $this->authToken();

        if (!$user) {
            return $this->noLogin();
        }

        // 版本加1
        $res = User::updateVersion($user->id, $user->login_type);

        $payload = [
            'id' => $user->id,
            'type' => $user->login_type,
            'version' => $res
        ];

        $data = [
            'token' => $this->createToken($payload)
        ];

        // 更新最后登录时间
        User::where('id', $user->id)->update(['updated_at' => Carbon::now()]);

        return $this->response($data);
    }
}

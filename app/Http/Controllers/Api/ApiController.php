<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 15:54:00
 */

namespace App\Http\Controllers\Api;

use Response;
use App\Http\Controllers\Controller;
use App\Third\JWT;
use App\Models\User;
use App\Models\Error;
use App\Models\Token;

class ApiController extends Controller
{
    protected $error_code = 0;

    protected $not_login_code = 100401;
    protected $params_error_code = 100404;
    protected $failed_code = 1;

    /**
    * [getErrorCode 获取消息码]
    * @return [type] [description]
    */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
    * [setErrorCode 设置消息码 ]
    * @param [type] $status_code [消息码]
    */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
        return $this;
    }

    /**
     * 生成Token
     *
     * @param  array  $payload  载荷
     * @return string
     */
    protected function createToken(array $payload = [])
    {
        $config  = config('jwt');
        $payload = array_merge([
            'iss' => $config['issuer'],
            'iat' => $_SERVER['REQUEST_TIME'],
            'exp' => $_SERVER['REQUEST_TIME'] + $config['expire']
        ], $payload);

        return JWT::encode($payload, $config['key'], $config['algorithm']);
    }

    /**
     * 验证Token
     */
    public function authToken($id = 'id')
    {
        $config  = config('jwt');

        if (($jwt = $_SERVER['HTTP_AUTHORIZATION'] ?? false) && ($payload = JWT::decode($jwt, $config['key'])) && isset($payload[$id]) && isset($payload['version']) && isset($payload['type'])) {
            // 用户
            $user = User::find($payload[$id]);
            if (!$user) {
                return false;
            }

            $versions = Token::where('user_id', $user->id)
                            ->where('type', $payload['type'])
                            ->first();
            if (!$versions) {
                return false;
            }

            if ($versions->version != $payload['version']) {
                return false;
            }

            $user->login_type = $payload['type'];
            return $user;
        }

        return false;
    }

    /**
     * 获取language 默认中文
     */
    public function getLanguage()
    {
        // header("app-language:en");
        if (array_key_exists('HTTP_APP_LANGUAGE', $_SERVER)) {
            return $_SERVER['HTTP_APP_LANGUAGE'];
        }

        if ($user = $this->authToken()) {
            return $user->language;
        }

        return config('my.api_default_language');
    }

    /**
    * [response 返回JSON格式数据并添加消息码和消息]
    * @param  [type] $data [description]
    * @return [type]       [description]
    */
    public function response($data = [], $message = '')
    {
        // 返回总数据
        $response = [];

        // 返回消息码
        $error_code = $this->getErrorCode();

        // 获取语言
        $language = $this->getLanguage();

        if ($message == '') {
            // 从数据库获取消息
            $message = Error::getError($error_code, $language);

            // 获取不到则读默认消息
            $msg = config('my.api_default_message');
            if (!$message) {
                $message = $msg;
            }
        }

        // 空数组返回空对象
        if (!$data) {
            $data = (object) $data;
        }

        $response['data'] = $data;
        $response['message'] = $message;
        $response['error_code'] = $error_code;

        return Response::json($response);
    }

    /**
     * 未登录
     */
    public function notLogin()
    {
        return $this->setErrorCode($this->not_login_code)->response();
    }

    /**
     * 参数错误
     */
    public function paramsError()
    {
        return $this->setErrorCode($this->params_error_code)->response();
    }

    /**
     * 失败
     */
    public function failed()
    {
        return $this->setErrorCode($this->failed_code)->response();
    }
}

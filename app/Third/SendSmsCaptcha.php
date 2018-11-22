<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 17:15:41
 */

namespace App\Third;

use Overtrue\EasySms\EasySms;

class SendSmsCaptcha
{
    protected $config;
    protected $easySms;

    const TEMPLATE = 'SMS_126445060';

    public function __construct()
    {
        $this->config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => './storage/logs/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => config('services.aliyun.access_key_id'),
                    'access_key_secret' => config('services.aliyun.access_key_secret'),
                    'sign_name' => config('services.aliyun.sign_name'),
                ],
            ],
        ];
        $this->easySms = new EasySms($this->config);
    }

    public function send($phone, $captcha, $template = Self::TEMPLATE)
    {
        try {
            $result = $this->easySms->send($phone, [
                'template' => $template,
                'data' => [
                    'code' => $captcha
                ],
            ]);

            // dd($result);
            // array:1 [
            //   "aliyun" => array:3 [
            //     "gateway" => "aliyun"
            //     "status" => "success"
            //     "result" => array:4 [
            //       "Message" => "OK"
            //       "RequestId" => "96C02ECC-891B-4848-9A1E-5EA0200051C7"
            //       "BizId" => "255610042879757069^0"
            //       "Code" => "OK"
            //     ]
            //   ]
            // ]

            return true;
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            // $message = $exception->getException('aliyun')->getMessage();
            // return $this->response([], $message ?? '短信发送异常');
            // $e->getResults();               // 返回所有 API 的结果，结构同上
            // $e->getExceptions();            // 返回所有调用异常列表
            // $e->getException($gateway);     // 返回指定网关名称的异常对象
            // $e->getLastException();         // 获取最后一个失败的异常对象
            // dd($exception->getResults());
            return false;
        }
    }
}

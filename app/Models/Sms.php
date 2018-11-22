<?php

namespace App\Models;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use App\Third\SendSmsCaptcha;

class Sms extends Model
{
    // 发送状态
    const STATUS_YES= 1;
    const STATUS_NO = 2;

    public static $statusMap = [
        self::STATUS_YES => '成功',
        self::STATUS_NO => '失败',
    ];

    // 发送状态
    const TYPE_REG= 1;
    const TYPE_LON = 2;

    public static $typeMap = [
        self::TYPE_REG => '注册',
        self::TYPE_LON => '登录',
    ];

    protected $fillable = [
        'phone',
        'status',
        'type',
    ];

    /**
     * 发送短信
     *
     * @param  string $phone 手机号
     * @param  string $code 验证码
     * @param  int $type 短信类别
     * @return boolean
     */
    public static function send($phone, $type = Self::TYPE_REG)
    {
        if (!Self::enablSend($phone, $type)) {
            return false;
        }

        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        $sendSmsCaptcha = new SendSmsCaptcha();

        // 发送短信验证
        $result = $sendSmsCaptcha->send($phone, $code);

        if ($result) {
            // 保存至Redis
            $key = 'captcha_' . $type . '_' . $phone;
            $redis = Redis::set($key, $code, 'EX', config('services.aliyun.captcha_expire'));
            // dd(Redis::get('captcha_2_15217050086'));
            if (!$redis) {
                return false;
            }
        }

        // 保存短信记录
        self::create([
            'phone' => $phone,
            'type' => $type,
            'status' => $result ? self::STATUS_YES : self::STATUS_NO
        ]);

        return (bool)$result;
    }

    /**
     * 判断是否可发送
     *
     * @param  string $phone 手机号
     * @param  int $type 类别
     * @return boolean
     */
    public static function enablSend($phone, $type = Self::TYPE_REG)
    {
        // 发送过于频繁
        $time = Carbon::now()->subSecond(config('services.aliyun.captcha_delay'));
        $where = [
            ['phone', $phone],
            ['type', $type],
            ['status', Self::STATUS_YES],
            ['created_at', '>', $time]
        ];

        $res = Self::where($where)->count();

        if ($res) {
            return false;
        }

        return true;
    }

    /**
     * 校对验证码
     *
     * @param  string $phone 手机
     * @param  string $captcha 验证码
     * @param  int $type 验证码类别
     * @return boolean
     */
    public static function validateCaptcha($phone, $captcha, $type = Self::TYPE_REG)
    {
        if (config('app.debug')) {
            return true;
        }

        // 不需要验证的手机号码
        $phones = explode(',', config('services.my.no_verify_phone'));
        if (in_array($phone, $phones)) {
            return true;
        }

        $key = 'captcha_' . $type . '_' . $phone;
        if (!$code = Redis::get($key)) {
            return false;
        }

        return $code == $captcha;
    }
}

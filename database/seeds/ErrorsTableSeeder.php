<?php

use Illuminate\Database\Seeder;
use App\Models\Error;

class ErrorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = $this->getData();
        foreach ($datas as $data) {
            $this->insert($data);
        }
    }

    protected function insert($data)
    {
        // 创建一个新对象
        $error = new Error($data);
        //  保存到数据库
        $error->save();
    }

    protected function getData()
    {
        return [
            [
                'error_code' => 0,
                'language' => 'zh_CN',
                'content' => '成功!',
            ],
            [
                'error_code' => 1,
                'language' => 'zh_CN',
                'content' => '失败，请重试!',
            ],
            [
                'error_code' => 100401,
                'language' => 'zh_CN',
                'content' => '未登录!',
            ],
            [
                'error_code' => 100402,
                'language' => 'zh_CN',
                'content' => '缺少参数!',
            ],
            [
                'error_code' => 100403,
                'language' => 'zh_CN',
                'content' => '参数格式错误!',
            ],
            [
                'error_code' => 100404,
                'language' => 'zh_CN',
                'content' => '请求方法错误!',
            ],
            [
                'error_code' => 100429,
                'language' => 'zh_CN',
                'content' => '连接次数过多，请稍后再试!',
            ],
            [
                'error_code' => 100500,
                'language' => 'zh_CN',
                'content' => '服务器错误，请联系管理员!',
            ],
            [
                'error_code' => 100502,
                'language' => 'zh_CN',
                'content' => '服务器压力太大，请联系管理员!',
            ],
            [
                'error_code' => 100101,
                'language' => 'zh_CN',
                'content' => '短信验证码不正确!',
            ],
            [
                'error_code' => 100102,
                'language' => 'zh_CN',
                'content' => '账号已经存在!',
            ],
            [
                'error_code' => 100103,
                'language' => 'zh_CN',
                'content' => '账号已禁用，请联系管理员!',
            ],
            [
                'error_code' => 100104,
                'language' => 'zh_CN',
                'content' => '账号不存在!',
            ],
        ];
    }
}

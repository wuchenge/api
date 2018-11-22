<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'type',
    ];

    // 状态
    const STATUS_YES= 1;
    const STATUS_NO = 2;

    public static $statusMap = [
        Self::STATUS_YES => '启用',
        Self::STATUS_NO => '禁用',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * 关联token
     * @return [type] [description]
     */
    public function tokens()
    {
        return $this->hasMany(Token::class, 'user_id');
    }

    /**
     * 查找是否有phone
     */
    public static function hasPhone($phone)
    {
        return Self::where('phone', $phone)
                    ->value('id');
    }

    /**
     * 存储用户
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function store($data)
    {
        DB::beginTransaction();
        try {
            $user = [
                'phone' => $data['phone'],
                'type' => $data['type']
            ];
            $model = Self::create($user);
            if (!$model) {
                return false;
            }

            $token_type = [
                'user_id' => $model->id,
                'type' => $data['type'],
                'version' => 1
            ];
            // 插入token版本表
            $res = Token::create($token_type);

            if ($res) {
                DB::commit();
                return $model;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 增加版本号
     * @param  [type] $id   [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public static function updateVersion($id, $type)
    {
        $versions = Token::where('user_id', $id)
            ->where('type', $type)
            ->first();

        if ($versions) {
            // 找到加1
            $num = $versions->version + 1;
            // DB::connection()->enableQueryLog();
            $res = $versions->fill(['version' => $num])->save();
            // dd(DB::getQueryLog());
            if ($res) {
                return $num;
            } else {
                return 0;
            }
        } else {
            // 没有找到设置1
            $tokens = [
                'user_id' => $id,
                'type' => $type,
                'version' => 1
            ];
            $res = Token::create($tokens);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        }
    }
}

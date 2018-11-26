<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = ['type', 'version', 'status', 'language', 'url', 'intro'];

    // 平台
    const TYPE_IOS = 1;
    const TYPE_AMDROID = 2;

    public static $typeMap = [
        self::TYPE_IOS => 'IOS',
        self::TYPE_AMDROID => 'ANDROID',
    ];

    // 是否强制更新
    const STATUS_NO = 1;
    const STATUS_YES = 2;

    public static $statusMap = [
        self::STATUS_NO => '否',
        self::STATUS_YES => '是',
    ];

    public function setUrlAttribute($value)
    {
        if ($value) {
            $pos = stripos($value, 'http');
            if ($pos === false) {
                $url = config('filesystems.disks.qiniu.prefix');
                $this->attributes['url'] = '/' . ltrim(str_replace($url, '', $value), '/');
            } else {
                $this->attributes['url'] = $value;
            }
        }
    }

    public function getUrlAttribute($value)
    {
        if ($value) {
            $pos = stripos($value, 'http');
            if ($pos === false) {
                $url = config('filesystems.disks.qiniu.prefix');
                $value = $url . $value;
            }
        }

        return $value;
    }
}

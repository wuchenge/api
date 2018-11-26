<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // 状态
    const STATUS_YES= 1;
    const STATUS_NO = 2;

    public static $statusMap = [
        self::STATUS_YES => '显示',
        self::STATUS_NO => '隐藏',
    ];

    // 类别
    const TYPE_AGREEMENT = 1;
    const TYPE_NEWS = 2;

    public static $typeMap = [
        self::TYPE_AGREEMENT => '协议',
        self::TYPE_NEWS => '新闻',
    ];

    protected $fillable = [
        'title',
        'content',
        'status',
        'type',
        'alias',
        'language',
    ];
}

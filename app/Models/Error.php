<?php

namespace App\Models;

class Error extends Model
{
    public static function getError($error_code, $language)
    {
        return self::where('error_code', $error_code)
                     ->where('language', $language)
                     ->limit(1)
                     ->value('content');
    }
}

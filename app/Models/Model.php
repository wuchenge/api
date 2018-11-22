<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 15:49:51
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    /**
     * 按时间排序；最近的
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

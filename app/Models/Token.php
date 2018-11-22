<?php

namespace App\Models;

class Token extends Model
{
    protected $fillable = [
        'user_id', 'type', 'version',
    ];
}

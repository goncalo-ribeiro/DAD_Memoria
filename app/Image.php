<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'id', 'face', 'active', 'path', 'blocked', 'reason_blocked', 'reason_reactivated'
    ];

}

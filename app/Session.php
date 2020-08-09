<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'bas_session';
    public $timestamps = false;

    protected $fillable = [
        'user_id','ip_address','user_agent','payload','last_activity'
    ];
}

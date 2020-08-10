<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    protected $table= 'bas_cron';

    protected $fillable =[
        'id','app_name','is_running'
    ];
    public $timestamps = false;
}

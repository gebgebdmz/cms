<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasCron extends Model
{
    //

  public $timestamps = false;
    protected $table="bas_cron";
    protected $fillable = [
        'id',
        'app_name',
        'is_running'
    ];

}

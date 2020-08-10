<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasConfig extends Model
{
    //
    public $timestamps = false;
    protected $table="bas_config";
    protected $fillable = [
        'id',
        'key',
        'value',
        'description'
    ];
    
}

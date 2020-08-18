<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsLocation extends Model
{
    protected $table = 'cms_location';
    public $timestamps = false;

    protected $fillable = [
     'name','address'
    ];
}

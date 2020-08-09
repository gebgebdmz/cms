<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsLocation extends Model
{
    protected $table = 'cms_course';
    public $timestamps = false;

    protected $fillable = [
     'name','address'
    ];
}

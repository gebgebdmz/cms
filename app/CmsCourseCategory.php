<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsCourseCategory extends Model
{
    protected $table = 'cms_coursecategory';
    public $timestampz = false;
    protected $fillable = [
        'category_code',
        'category_name',
        'category_fullname',
        'parent_category_code',
        'category_desc',
    ];
}

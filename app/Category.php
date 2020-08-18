<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'cms_coursecategory';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'category_code',
        'category_name',
        'category_fullname',
        'parent_category_code',
        'category_desc',
    ];
}

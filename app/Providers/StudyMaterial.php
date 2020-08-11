<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    protected $table = 'cms_studymaterial';
    public $timestamps = false;
    protected $fillable = ['id','name','description'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsAcademicSession extends Model
{
    protected $table = 'cms_academic_session';
    public $timestamps = false;

    protected $fillable = [
        'id',
       'session',
    ];
}

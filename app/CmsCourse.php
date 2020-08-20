<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsCourse extends Model
{
    protected $table = 'cms_course';
    public $timestamps = false;

    protected $fillable = [
       'course_fullname','course_shortname','course_idnumber','course_category','course_duration'
    ];

    public function cmsCU()
    {
        return $this->hasMany(CmsCourseUser::class, 'courseid' ,'id');
    }
}

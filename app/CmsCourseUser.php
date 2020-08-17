<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CmsCourse;

class CmsCourseUser extends Model
{
    protected $table = 'cms_course_user';
    public $timestampz = false;

    protected $fillable = [
        'id',
        'courseid',
        'loginid',
        'role',
        'academic_session',
    ];
    public function cms()
    {
       return $this->hasMany(CmsCourse::class);
       $cms = CmsCourseUser::find(1)->cms;
    }


}

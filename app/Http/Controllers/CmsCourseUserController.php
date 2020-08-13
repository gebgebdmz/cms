<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CmsCourseUser;
use DataTables;
use DB;
class CmsCourseUserController extends Controller
{
    public function index()
    {
        $cmsCU = CmsCourseUser::all();
        // $cmsCU = DB::table('cms_course_user')->get();
        return view('course.cmscourseuser', ['cmsCU' => $cmsCU]);
    }

    // public function getcourseUser()
    // {
    //     $data = CmsCourseUser::all();
    //     return DataTables::of($data)->make(true);
    // }
}

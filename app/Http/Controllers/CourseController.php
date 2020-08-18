<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\CmsCourse;
use  DataTables;
use DB;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\JsonEncodingException;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display(Request $request)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $id = Auth::id();
            DB::beginTransaction();

            try {
                $profile_data = User::find($id);

                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => 'Display',
                    'description' => "View cms_course",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                $app = CmsCourse::Orderby('id')
                    ->select('*')
                    ->get();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            return view('/course', ['app' => $app]);
        } else {

            return view("login");
        }
    }

    public function getcourse()
    {

        $app = CmsCourse::Orderby('id')
        ->select('*')
        ->get();
        return Datatables::of($app)->make(true);
    }


    public function create(Request $request)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
            $routes = $matches[0];
            $action = $matches[2];
            if(Auth::check()){
                $id = Auth::id();
                $user = User::find($id);
                DB::beginTransaction();
            try{
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $user->username,
                    'application' =>$routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $user->username . " Manage Add Course<br>New Course Name Is " . $request ->course_fullname,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }
            CmsCourse::create([
                'course_fullname' => $request ->course_fullname,
                'course_shortname' => $request ->course_shortname,
                'course_idnumber' => $request ->course_idnumber,
                'course_category' => $request ->course_category,
                'course_duration' => $request ->course_duration,
            ]);
     
        // alihkan halaman ke halaman pegawai
        return redirect('/course')->with('message', 'Add new course data success!');
             } else{
                 return view('login');
             }
    }


    public function update(Request $request, $id)
    {
  // update and save this user
  $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
  $routes = $matches[0];
  $action = $matches[2];
  if (Auth::check()) {

    $idd = Auth::id();
   DB::beginTransaction();
   $dataLama = CmsCourse::find($id);
   $oldData = array(
       $dataLama->course_fullname,
       $dataLama->course_shortname,
       $dataLama->course_idnumber,
       $dataLama->course_category,
       $dataLama->course_duration,
   );
   $newData = array(
    $request ->course_fullname,
    $request ->course_shortname,
    $request ->course_idnumber,
    $request ->course_category,
    $request ->course_duration,
   );

//    dd($newData);

   $temp = array(
       'course_fullname',
       'course_shortname',
       'course_idnumber',
       'course_category',
       'course_duration',
   );
   
try {

    CmsCourse::where('id', $id)
    ->update(
        array(
                'course_fullname' => $request ->course_fullname,
                'course_shortname' => $request ->course_shortname,
                'course_idnumber' => $request ->course_idnumber,
                'course_category' => $request ->course_category,
                'course_duration' => $request ->course_duration,
        ));

   $profile_data = User::find($idd);
   $desc = $profile_data->username. ' successfully changed course data<br>';
   $descc = $desc . $this->descriptionLog($dataLama->id, $temp, $oldData, $newData);
     ActivityLog::create([

        'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
        'username' => $profile_data->username,
        'application' =>$routes,
        'creator' => "System",
        'ip_user' => $request->ip(),
        'action' => $action,
        'description' => $descc,
        'user_agent' => $request->server('HTTP_USER_AGENT')
     ]);

        DB::commit();
    } catch (\Exception $ex) {
        DB::rollback();
        return response()->json(['error' => $ex->getMessage()], 500);
    }


     return redirect('/course')->with('message', 'Course data has been successfully updated!');
    }else{
        return view('login');
    }

    }


    
}

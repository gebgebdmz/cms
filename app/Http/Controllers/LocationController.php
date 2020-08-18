<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\CmsLocation;
use DataTables;
use DB;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\JsonEncodingException;

class LocationController extends Controller
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
                    'description' => "View cms_location",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                $app = CmsLocation::Orderby('id')
                    ->select('*')
                    ->get();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            return view('/location', ['app' => $app]);
        } else {

            return view("login");
        }
    }

    public function getlocation()
    {

        $app = CmsLocation::Orderby('id')
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
                    'description' => $user->username . " Manage Add Location<br>New Location Name Is " . $request ->location_name,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }
            CmsLocation::create([
                'name' => $request->location_name,
                'address' => $request->location_address,
            ]);
     
        // alihkan halaman ke halaman pegawai
        return redirect('/location')->with('message', 'Add new location data success!');
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
   $dataLama = CmsLocation::find($id);
   $oldData = array(
       $dataLama->name,
       $dataLama->address,
   );
   $newData = array(
    // $dataLama->name,
    $request->location_name,
    // $dataLama->address,
    $request->location_address,
   );

//    dd($newData);

   $temp = array(
       'name',
       'address',
   );
   
try {

    CmsLocation::where('id', $id)
    ->update(
        array(
            'name' => $request->location_name,
            'address' => $request->location_address
        ));

   $profile_data = User::find($idd);
   $desc = $profile_data->username. ' successfully changed location data<br>';
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


     return redirect('/location')->with('message', 'Data has been successfully updated!');
    }else{
        return view('login');
    }

    }


    public function descriptionLog($id, $field, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                $arr = $arr . '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }
}

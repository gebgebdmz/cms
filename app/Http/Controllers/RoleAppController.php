<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Role;
use App\App;
use App\ActivityLog;
use App\RoleApp;
use  DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\JsonEncodingException;


use DB;

class RoleAppController extends Controller
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
                // ActivityLog::create([

                //     'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                //     'username' => $profile_data->username,
                //     'application' => $routes,
                //     'creator' => "System",
                //     'ip_user' => $request->ip(),
                //     'action' => $action,
                //     'description' => $profile_data->username . " is looking at roleApp",
                //     'user_agent' => $request->server('HTTP_USER_AGENT')
                // ]);



                // $pagination = TRUE;
                $app = DB::table('bas_role_app')
                    ->join('bas_role_app', 'bas_app.app_name', '=', 'bas_role_app.app_name')
                    ->join('bas_role', 'bas_role_app.role_id', '=', 'bas_role.id')
                    ->from('bas_app')
                    ->distinct()
                    // ->where('role_user.role_id', 4)
                    ->select('bas_role_app.app_name', 'bas_role.name', 'bas_role_app.id', 'bas_role_app.role_id')

                    //        ->from('bas_app')
                    //        // ->where('role_user.role_id', 4)
                    ->groupBy('bas_app.app_name', 'bas_role.name', 'bas_role_app.id')
                    ->Orderby('bas_role_app.id')
                    ->get();
                //   dd($app);
                $bas_role = Role::distinct()->select('id', 'name')->get();
                $bas_app = App::distinct()->select('id', 'app_name')->get();
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            return view('/roleapp', ['app' => $app, 'bas_app' => $bas_app, 'bas_role' => $bas_role]);
            //   return view('/roleapp', ['app' => $app, 'bas_app' => $bas_app]);
        } else {

            return view("login");
        }
    }



    public function getroleapp()
    {

        $app = DB::table('bas_role_app')
            ->join('bas_role_app', 'bas_app.app_name', '=', 'bas_role_app.app_name')
            ->join('bas_role', 'bas_role_app.role_id', '=', 'bas_role.id')
            ->from('bas_app')
            ->select('bas_role_app.app_name', 'bas_role.name', 'bas_role_app.id')
            ->get();
        return Datatables::of($app)->make(true);
    }

    // public function store($id){

    //     // passing data pegawai yang didapat ke view edit.blade.php

    //     $updateRA=DB::table('bas_role_app')
    //     ->where('id', $id)
    //     ->first();
    //   //  dd($bas_app);

    // 	return view('RoleApp',['updateRA' => $updateRA]);
    // }


    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            try {
                // DB::beginTransaction();

                $RoleApp = RoleApp::findOrFail($id);
                $bas_app = App::where('app_name',  $RoleApp->app_name)->first();
                $bas_role = Role::findorFail($RoleApp->role_id);

                DB::table('bas_role_app')
                    ->where('id', $id)
                    ->update(array(
                        'role_id' => $request->role_name,
                        'app_name' => $request->app_name
                    ));

                $oldData = array(
                    $bas_role->name,
                    $bas_app->app_name,
                );
                $newData = array(
                    $request->role_name,
                    $request->app_name,
                );

                $temp = array(
                    'role_name',
                    'app_name'
                );


                $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
                $routes = $matches[0];
                $action = $matches[2];
                $idUser = Auth::id();
                $profile_data = User::find($idUser);
                $desc = $profile_data->username . ' successfully changed roleapp data<br>';
                $descc = $desc . $this->descriptionLog($id, $temp, $oldData, $newData);
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $descc,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                // DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }
            return redirect('/roleapp')->with('message', 'Role App data update success!');
        } else {

            return view("login");
        }
    }

    public function delete(Request $request, $id)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {
            $idUser = Auth::id();
            try {
                $profile_data = User::find($idUser);


                $RoleApp = RoleApp::findOrFail($id);
                $bas_app = App::where('app_name',  $RoleApp->app_name)->first();
                $bas_role = Role::findorFail($RoleApp->role_id);
                //   dd($bas_role);
                ActivityLog::create([
                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => "Admin deletes a role app data<br>The app is&nbsp" . $bas_app->app_name . "&nbspand the role is&nbsp " . $bas_role->name . "&nbspwith id&nbsp" . $RoleApp->id,
                    'user_agent' => $request->server('HTTP_USER_AGENT')

                ]);
                $role = RoleApp::findOrFail($id);

                //  $role = Role::with('apps')->get();

                //    dd($role);

                $role->roles()->detach();

                $role->delete();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
            return redirect('/roleapp')->with('message', 'Delete role app data success!');
        } else {
            return view("login");
        }
    }

    //unfinished
    public function create(Request $request)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $id = Auth::id();

            try {
                $profile_data = User::find($id);

                $bas_role = Role::findOrFail($request->role_name);
                //  dd($bas_app);

                $appp = App::where('app_name',  $request->app_name)->first();
                $data = RoleApp::create([
                    'role_id' => $request->role_name,
                    'app_name' => $request->app_name,
                ]);
                //dd($appp->app_name);
                $profile_data = User::find($id);
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $profile_data->username . " managed to add a role app <br>The App is &nbsp" . $appp->app_name . "&nbspand the role is&nbsp" . $bas_role->role_name . "&nbspwith id number&nbsp" . $data->id,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);




                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
            return redirect('/roleapp')->with('message', 'Create new role app data success!');
        } else {

            return view("login");
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

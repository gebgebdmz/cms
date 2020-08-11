<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\App;
use App\RoleApp;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\JsonEncodingException;
use DataTables;


class AppController extends Controller
{


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
                'application' =>$routes,
                'creator' => "System",
                'ip_user' => $request->ip(),
                'action' => $action,
                'description' => $profile_data->username. " is looking app",
                'user_agent' => $request->server('HTTP_USER_AGENT')
             ]);

             DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }

        // $pagination = TRUE;
        $app = App::Orderby('id')->get();
        return view('/Showapp', ['app' => $app]);
    }else {
        
        // return view("login");
    }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
                'application' =>$routes,
                'creator' => "System",
                'ip_user' => $request->ip(),
                'action' => $action,
                'description' => $profile_data->username. " managed to add a app <br>The App is " . $request->app_name,
                'user_agent' => $request->server('HTTP_USER_AGENT')
             ]);

             DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }

        App::create([
            'app_name' => $request->app_name,
            'app_type' => $request->app_type,
            'description' => $request->description,
            'menu_name' => $request->menu_name,
            'menu_url' => $request->menu_url,
        ]);
        return redirect('/app');
    } else {

        return view("login");
    }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function getapp(){

        $app = App::all();
        return Datatables::of($app)->make(true);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $idd = Auth::id();
           DB::beginTransaction();
           $dataLama = App::find($id);
           $oldData = array(
               $dataLama->app_name,
               $dataLama->app_type,
               $dataLama->description,
               $dataLama->menu_name,
               $dataLama->menu_url,
           );
           $newData = array(
               $request->app_name,
               $request->app_type,
               $request->description,
               $request->menu_name,
               $request->menu_url,
           );

           $temp = array(
               'app_name',
               'app_type',
               'description',
               'menu_name',
               'menu_url',
           );

        try {
           $profile_data = User::find($idd);
           $desc = $profile_data->username. ' successfully changed app data<br>';
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
            }

        App::where('id', $id)
            ->update(array('app_name' => $request->app_name, 'app_type' => $request->app_type,
             'description' => $request->description,'menu_name'=> $request->menu_name,'menu_url'=>
             $request->menu_url));

        return redirect('/app');
    } else {

        return view("login");
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function destroy(Request $request, App $app)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];

        if (Auth::check()) {
            $id = Auth::id();
            $profile_data = User::find($id);
            DB::beginTransaction();
            $fail = false;

            try {
                try {
                    App::destroy($app->id);
                } catch (\Exception $ex) {
                    $fail = true;
                }
                $desc = "{$profile_data->username} deleted app record<br>Name : {$app->app_name}";
                ActivityLog::create([
                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "SYSTEM",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $desc,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);
                DB::commit();
                return redirect('/app')->with('status','App Deleted Success');
            } catch (\Exception $ex) {
                DB::rollback();
                try {
                    $desc = "{$profile_data->username} failed delete app record<br>Name : {$app->app_name} App cant be deleted because violates foreign key constraint menu";
                    ActivityLog::create([
                        'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                        'username' => $profile_data->username,
                        'application' => $routes,
                        'creator' => "SYSTEM",
                        'ip_user' => $request->ip(),
                        'action' => $action,
                        'description' => $desc,
                        'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
                    return redirect('/app')->with('failure','App cant be deleted because violates foreign key constraint menu');
                } catch (\Exception $ex) {
                }
            }
        } else {
            return view("login");
        }
    }

    public function descriptionLog($id, $temp, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                $arr = $arr . '<tr><td><b>' . $temp[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }

}

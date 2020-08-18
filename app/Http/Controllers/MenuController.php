<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\Menu;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\JsonEncodingException;
use DataTables;
use DB;

class MenuController extends Controller
{

    public function getData(){

        $menu= Menu::rightJoin('bas_menu','bas_role.id','=','bas_menu.role_id')
        ->from('bas_role')
        ->select('*')
        ->get();
        return Datatables::of($menu)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
                    'username' => "daayat",
                    'application' =>"menu",
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' =>" Display Menu",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }

            // $menu = Menu::with('getApp')->get();
            $menu= Menu::rightJoin('bas_menu','bas_role.id','=','bas_menu.role_id')
                        ->from('bas_role')
                        ->select('*')
                        ->get();
                        return view('navigasi.menu',['menu'=>$menu]);
                    }else{
                        return view('login');
                        }
                    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    'description' => $user->username . " Manage Add Menu<br>Menu Is " . $request ->app_name,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }
            Menu::create([
                'app_name' => $request->app_name,
                'parent_menu_id' => $request->parent_menu_id,
                'role_id' => $request->role_id,
            ]);
     
        // alihkan halaman ke halaman pegawai
        return redirect('menu');
             } else{
                 return view('login');
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
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
  // update and save this user
  $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
  $routes = $matches[0];
  $action = $matches[2];
  if (Auth::check()) {

    $idd = Auth::id();
   DB::beginTransaction();
   $dataLama = Menu::find($id);
   $oldData = array(
       $dataLama->app_name,
       $dataLama->parent_menu_id,
       $dataLama->role_id,

   );
   $newData = array(
       $request->app_name,
       $request->parent_menu_id,
       $request->role_id
      
   );

   $temp = array(
       'app_name',
       'parent_menu_id',
       'role_id'
   );
   
try {
   $profile_data = User::find($idd);
   $desc = $profile_data->username. ' successfully changed menu data<br>';
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

Menu::where('id', $id)
    ->update(
        array(
            'app_name' => $request->app_name, 
            'parent_menu_id' => $request->parent_menu_id,
            'role_id' => $request->role_id));


     return redirect('/menu')->with('success', 'Data has been successfully sent!');
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
                $arr = '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if(Auth::check()){
            $idd = Auth::id();
            $user = User::find($idd);
            DB::beginTransaction();
           $delete = Menu::find($id);
        try{
            ActivityLog::create([

                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $user->username,
                'application' =>$routes,
                'creator' => "System",
                'ip_user' => $request->ip(),
                'action' => $action,
                'description' => $user->username . " Delete Menu<br>Menu Is " . $delete->app_name,
                'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);
                
        $menu = Role::where('id', $id)->get();

        // if (count($menu)) {
        //     Role::where('id', $id)->delete();
        // }

        Menu::where('id', $id)->delete();
        DB::commit();
        }catch(\Exception $x){
            DB::rollback();
            return response()->json(['error' => $x->getMessage()], 500);
        }
        return redirect('/menu');
    } else{
        return view('login');
    }
    }
  
}

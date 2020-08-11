<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use DB;
use App\User;
use App\Role;
use App\App;
use App\ActivityLog;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function username()
    {
        return 'username';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        
        DB::beginTransaction();
        try {
            if ($user->priv_admin == '1') { // if admin then -> admin route
                ActivityLog::create([
                    'inserted_date'=>Carbon::now()->TimeZone('asia/jakarta'),
                    'username'=>$user->username,
                    'application'=>$routes,
                    'creator'=>'System',
                    'ip_user'=>$request->ip(),
                    'action'=>$request->method(),
                    'description'=>$user->username." successfully login",
                    'user_agent'=>$request->server('HTTP_USER_AGENT')
                ]);
                DB::commit();
                $roles=array();
                $apps=array();

                foreach($user->roles as $role)
                {
                    array_push($roles,$role->name);
                    foreach($role->apps as $app) 
                    {
                        if(!in_array($app->app_name,$apps)) {
                            array_push($apps,$app->app_name);
                        }
                    }
                }
                
                session(['role' =>$roles]);
                session(['user_app'=>$apps]);
                return redirect()->route('admin');
                
            } else {
                ActivityLog::create([
                    'inserted_date'=>Carbon::now()->TimeZone('asia/jakarta'),
                    'username'=>$user->username,
                    'application'=>$routes,
                    'creator'=>'System',
                    'ip_user'=>$request->ip(),
                    'action'=>$request->method(),
                    'description'=>$user->username." successfully login",
                    'user_agent'=>$request->server('HTTP_USER_AGENT')
                ]);
                DB::commit();
                $roles=array();
                $apps=array();

                foreach($user->roles as $role)
                {
                    array_push($roles,$role->name);
                    foreach($role->apps as $app) 
                    {
                        if(!in_array($app->app_name,$apps)) {
                            array_push($apps,$app->app_name);
                        }
                    }
                }
                
                session(['role' =>$roles]);
                session(['user_app'=>$apps]);
                return redirect('/myprofile'); // if user then -> user route
                
            }
         
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
      }
   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\StudyMaterial;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\JsonEncodingException;
use DataTables;

class StudyMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
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
                'description' => $profile_data->username. " is looking study material",
                'user_agent' => $request->server('HTTP_USER_AGENT')
             ]);

             DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }

        // $pagination = TRUE;
        $studymaterial = StudyMaterial::Orderby('id')->get();
        return view('/studymaterial', ['studymaterial' => $studymaterial]);
    }else {

        return view("login");
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        StudyMaterial::create([
            'name' => $request->name,
            'description' => $request->description,
            ]);
        return redirect('/studymaterial');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

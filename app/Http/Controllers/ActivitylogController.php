<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\ActivityLog;
use App\App;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class ActivitylogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {

            DB::begintransaction();
            try {
                $id = Auth::id();
                $profile_data = DB::table('bas_user')->find($id);
                $routes =  App::where('description', 'like', '%' . 'Display The Latest Activity Log' . '%')->pluck('app_name')[0];

                $activitylog = new ActivityLog;
                $activitylog->inserted_date = Carbon::now()->TimeZone('asia/jakarta');
                $activitylog->username =  $profile_data->username;
                $activitylog->application = $routes;
                $activitylog->creator = "System";
                $activitylog->ip_user = $request->ip();
                $activitylog->action = "Display";
                $activitylog->description = "Display The Latest Activity Log";
                $activitylog->user_agent = $request->server('HTTP_USER_AGENT');
                $activitylog->save();

                DB::commit();
                return view('activitylog');
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }
    }

    public function getDataActivity()
    {
        $data = ActivityLog::latest()->get();
        return DataTables::of($data)
                ->rawColumns(['description'])
                ->make(true);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

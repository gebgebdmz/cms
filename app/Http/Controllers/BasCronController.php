<?php

namespace App\Http\Controllers;
use DataTables;
use App\BasCron;

use App\App;
use App\ActivityLog;

use Illuminate\Http\Request;

class BasCronController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $thisapp = App::where( 'app_name',  'BasCronController@index')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        


        return view('BasCron');
    }

    public function getcron(){
        $basConfig = BasCron::all();
        return Datatables::of($basConfig)->make(true);
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
     * @param  \App\BasCron  $basCron
     * @return \Illuminate\Http\Response
     */
    public function show(BasCron $basCron)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BasCron  $basCron
     * @return \Illuminate\Http\Response
     */
    public function edit(BasCron $basCron)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BasCron  $basCron
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BasCron $basCron)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BasCron  $basCron
     * @return \Illuminate\Http\Response
     */
    public function destroy(BasCron $basCron)
    {
        //
    }

    function insertActivityLog($app,$action,$desc,$username,$request){
        $id=ActivityLog::max('id');
        $id++;
        $ActivityLog= new ActivityLog;
        $ActivityLog->id=$id;
        $ActivityLog->inserted_date= date('Y-m-d H:i:s');
        $ActivityLog->username= $username;
        $ActivityLog->application= $app;
        $ActivityLog->creator="System";
        $ActivityLog->ip_user= $request->ip();
        $ActivityLog->action=$action;
        $ActivityLog->description=$desc;
        $ActivityLog->user_agent=$request->header('user-agent');
        $ActivityLog->save();
    }


}

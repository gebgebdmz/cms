<?php

namespace App\Http\Controllers;

use App\BasConfig;
use App\App;
use App\ActivityLog;
use DataTables;
use Illuminate\Http\Request;

class BasConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $thisapp = App::where( 'app_name',  'BasConfigController@index')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        

        return view('BasConfig');


    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //


        
        $thisapp = App::where( 'app_name',  'BasConfigController@create')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);

        

        return view('BasConfigInsert');
        

       
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
        
        $thisapp = App::where( 'app_name',  'BasConfigController@store')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        

        
        
        $id=BasConfig::max('id');
        $id++;
        $basConfig= new BasConfig;
        $basConfig->id=$id;
        $basConfig->key=$request->key;
        $basConfig->value=$request->value;
        $basConfig->description=$request->description;
        $basConfig->save();

        
        return redirect('/BasConfig');
        
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BasConfig  $basConfig
     * @return \Illuminate\Http\Response
     */
    public function show($basConfig,Request $request)
    {
        
        $thisapp = App::where( 'app_name',  'BasConfigController@show')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        
        $basConfig= BasConfig::findOrFail($basConfig);
        return view('BasConfigDetails',['list'=>$basConfig]);
        
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BasConfig  $basConfig
     * @return \Illuminate\Http\Response
     */
    public function edit($basConfig,Request $request)
    {
        //
        
        $thisapp = App::where( 'app_name',  'BasConfigController@edit')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
       
       
        $basConfig= BasConfig::findOrFail($basConfig);
        return view('BasConfigUpdate',['list'=>$basConfig]);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BasConfig  $basConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$basConfig)
    {
        //
   
        
        $basConfig= BasConfig::findOrFail($basConfig);
        $description="
        Updating a list from Bas Config (id:".$basConfig->id.")
        <table border=1 >
        <tr>
            <td></td>
            <td><strong>Before</strong></td>
            <td><strong>After</strong></td>
        </tr>

        <tr>
            <td>Key</td>
            <td>".$basConfig->key."</td>
            <td>".$request->key."</td>
        </tr>
        <tr>
            <td>Value</td>
            <td>".$basConfig->value."</td>
            <td>".$request->value."</td>
        </tr>
        <tr>
            <td>Desc</td>
            <td>".$basConfig->description."</td>
            <td>".$request->description."</td>
        </tr>
    </table>

        
        
        ";

        $thisapp = App::where( 'app_name',  'BasConfigController@update')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$description,"",$request);


        
        BasConfig::where('id',$basConfig->id)
                ->update([

                    'key'=> $request->key,
                    'value'=>$request->value,
                    'description'=>$request->description

                ]);

        return redirect('/BasConfig');
                    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BasConfig  $basConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(BasConfig $basConfig)
    {
        //
    }

    public function getData(){
        $basConfig = BasConfig::all();
        return Datatables::of($basConfig)->make(true);
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

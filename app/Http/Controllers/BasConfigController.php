<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\BasConfig;
use App\App;
use App\ActivityLog;
use DataTables;
use Illuminate\Http\Request;
use App\User;
use DB;

class BasConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');

    }

 
    public function index(Request $request)
    {
     
        
        if (Auth::check()) {

            DB::begintransaction();
            try {
               
                $thisapp = App::where( 'app_name',  'BasConfigController@index')->first();
        

                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);


                DB::commit();
                return view('BasConfig');
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }



    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //


        if (Auth::check()) {

            DB::begintransaction();
            try {
               
        

                $thisapp = App::where( 'app_name',  'BasConfigController@create')->first();
        
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);


                DB::commit();
                
                return view('BasConfigInsert');
              
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
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

        if (Auth::check()) {

            DB::begintransaction();
            try {
               
        
                      
                $thisapp = App::where( 'app_name',  'BasConfigController@store')->first();
        
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
        
        
                $id=BasConfig::max('id');
                $id++;
                $basConfig= new BasConfig;
                $basConfig->id=$id;
                $basConfig->key=$request->key;
                $basConfig->value=$request->value;
                $basConfig->description=$request->description;
                $basConfig->save();



                DB::commit();
                return redirect('/BasConfig');
              
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }


  

        
      
        
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BasConfig  $basConfig
     * @return \Illuminate\Http\Response
     */
    public function show($basConfig,Request $request)
    {   
        

        if (Auth::check()) {

            DB::begintransaction();
            try {
               
        
                $thisapp = App::where( 'app_name',  'BasConfigController@show')->first();
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
                
                $basConfig= BasConfig::findOrFail($basConfig);



                DB::commit();
                return view('BasConfigDetails',['list'=>$basConfig]);
              
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }


     
       
        
        
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
        

        if (Auth::check()) {

            DB::begintransaction();
            try {
               
        


                $thisapp = App::where( 'app_name',  'BasConfigController@edit')->first();
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);

               
                $basConfig= BasConfig::findOrFail($basConfig);

                DB::commit();
                return view('BasConfigUpdate',['list'=>$basConfig]);
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }



      
   

        
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
   
        if (Auth::check()) {

            DB::begintransaction();
            try {
               
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
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$description,$userlogin->username,$request);
                
                BasConfig::where('id',$basConfig->id)
                        ->update([
        
                            'key'=> $request->key,
                            'value'=>$request->value,
                            'description'=>$request->description
        
                        ]);




                DB::commit();
                return redirect('/BasConfig');
              
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        } else {
            return view("login");
        }



       

        
                    
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

    public function getsomething(){
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

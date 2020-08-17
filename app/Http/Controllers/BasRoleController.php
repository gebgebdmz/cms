<?php

namespace App\Http\Controllers;
use App\App;
use App\ActivityLog;
use App\Role;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\User;

use Illuminate\Support\Facades\Auth;



class BasRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  \Illuminate\Http\Request  $request
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
                $thisapp = App::where( 'app_name',  'BasRoleController@index')->first();
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
               
                DB::commit();
                return view('BasRole');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //


        if (Auth::check()) {

            DB::begintransaction();
            try {
               
                $thisapp = App::where( 'app_name',  'BasRoleController@create')->first();
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
     
                DB::commit();
                return view('BasRoleInsert');
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
               
                $thisapp = App::where( 'app_name',  'BasRoleController@store')->first();
                $userlogin=User::find(Auth::id());
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
                $id=Role::max('id');
                $id++;
                $basRole= new Role;
                $basRole->id=$id;
                $basRole->name=$request->name;
                $basRole->remark=$request->remark;
                $basRole->save();
                DB::commit();
                return redirect('/BasRole');
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
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $basRole
     * @return \Illuminate\Http\Response
     */
    public function show($basRole,Request $request)
    {
        //

        if (Auth::check()) {

            DB::begintransaction();
            try {
                $userlogin=User::find(Auth::id());

                $thisapp = App::where( 'app_name',  'BasRoleController@show')->first();
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
                $basrole= Role::findOrFail($basRole);
               
                DB::commit();
                    
                return view('BasRoleDetails',['list'=>$basrole]);
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
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $basRole
     * @return \Illuminate\Http\Response
     */
    public function edit($basRole,Request $request)
    {
        //


        if (Auth::check()) {

            DB::begintransaction();
            try {
                $userlogin=User::find(Auth::id());

                $thisapp = App::where( 'app_name',  'BasRoleController@edit')->first();
                $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,$userlogin->username,$request);
                $basRole= Role::findOrFail($basRole);
               
                DB::commit();
                return view('BasRoleUpdate',['list'=>$basRole]);
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
     * @param  \App\Role  $basRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$basRole)
    {
        //


        if (Auth::check()) {

            DB::begintransaction();
            try {
               
                $userlogin=User::find(Auth::id());

        $basRole= Role::findOrFail($basRole);
       
        $description="
        Updating a list from Bas Config (id:".$basRole->id.")
        <table border=1 >
        <tr>
            <td></td>
            <td><strong>Before</strong></td>
            <td><strong>After</strong></td>
        </tr>

        <tr>
            <td>Name</td>
            <td>".$basRole->name."</td>
            <td>".$request->name."</td>
        </tr>
        <tr>
            <td>Remark</td>
            <td>".$basRole->remark."</td>
            <td>".$request->remark."</td>
        </tr>
       
    </table>

        
        
        ";

        $thisapp = App::where( 'app_name',  'BasRoleController@update')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$description,$userlogin->username,$request);
        Role::where('id',$basRole->id)
                ->update([

                    'name'=> $request->name,
                    'remark'=>$request->remark
                ]);

               
                DB::commit();
                return redirect('/BasRole');
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
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $basRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($basRole,Request $request)
    {
        





        $thisapp = App::where( 'app_name',  'BasRoleController@destroy')->first();
            $fail=false;
             try {
                try {
                    $nerd = Role::findorfail($basRole);
                    $nerd->delete();
                } catch (\Exception $ex) {
                    $fail = true;
                }
              
            } catch (\Exception $ex) {
                
                    return redirect('/BasRole')->with('failure','Role cant be deleted because there is user who has this role');
                } catch (\Exception $ex) {
                
                   
                }

               if($fail){
                $text="Role cant be deleted because there is user who has this role";
             $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$text,"",$request);
          }else{
              $text="A role is deleted";
          $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$text,"",$request);

          }
               
               return redirect('/BasRole');

              
 
       


        
    }
    public function getRole(){
        $basrole = Role::all();
        return Datatables::of($basrole)->make(true);
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


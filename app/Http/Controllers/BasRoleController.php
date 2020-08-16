<?php

namespace App\Http\Controllers;
use App\App;
use App\ActivityLog;
use App\Role;
use Illuminate\Http\Request;
use DataTables;

class BasRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $thisapp = App::where( 'app_name',  'BasRoleController@index')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        return view('BasRole');
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $thisapp = App::where( 'app_name',  'BasRoleController@create')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        return view('BasRoleInsert');
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
        $thisapp = App::where( 'app_name',  'BasRoleController@store')->first();
        
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        $id=Role::max('id');
        $id++;
        $basRole= new Role;
        $basRole->id=$id;
        $basRole->name=$request->name;
        $basRole->remark=$request->remark;
        $basRole->save();

        
        return redirect('/BasRole');
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

        $thisapp = App::where( 'app_name',  'BasRoleController@show')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        $basrole= Role::findOrFail($basRole);
        return view('BasRoleDetails',['list'=>$basrole]);

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

        $thisapp = App::where( 'app_name',  'BasRoleController@edit')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"",$request);
        $basRole= Role::findOrFail($basRole);
        return view('BasRoleUpdate',['list'=>$basRole]);
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
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$description,"",$request);
        Role::where('id',$basRole->id)
                ->update([

                    'name'=> $request->name,
                    'remark'=>$request->remark
                ]);

        return redirect('/BasRole');
    }

    /**
     * Remove the specified resource from storage.
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $basRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($basRole,Request $request)
    {
        //
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
                  // echo"<script>alert('role tidak bisa di hapus')</script>";
                  //  $text="Role cant be deleted because there is user who has this role";
                  // $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$text,"",$request);
                    return redirect('/BasRole')->with('failure','Role cant be deleted because there is user who has this role');
                } catch (\Exception $ex) {
                
                   
                }
               // $text="A role is deleted";
               // $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$text,"",$request);
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


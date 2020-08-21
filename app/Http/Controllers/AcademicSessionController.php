<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\JsonEncondingException;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\ActivityLog;
use App\User;
use App\CmsAcademicSession;
use DataTables;
use DB;

class AcademicSessionController extends Controller
{
    public function getAllAcadSess() {
        $academicsession= CmsAcademicSession::all();
        return Datatables::of($academicsession)->make(true);
    }

    /**
     * Display a listing of the resource
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
                    'username' => $user->$username,
                    'application' =>$routes,
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

            $academicsession = CmsAcademicSession::all();
            return view('academicsession',['academicsession'=>$academicsession]);
        } else {
            return view('login');
        }

    }

    /**
     * Show the form for creating a new resource
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
                    'username' => $user->$username,
                    'application' =>$routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $user->username,"Manage Add Session<br>". $request->session,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }

            CmsAcademicSession::create([
                'session' => $request->session,
            ]);
            return redirect('academicsession')->with('message','Session has been successfully created!');
        } else {
            return view('login');
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sessId)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if(Auth::check()){
            $id = Auth::id();
            DB::beginTransaction();
            $oldData = CmsAcademicsesion::find($id);
            $oldDataArr = $oldData->session;

            $newData = $request->session;

            try{
                $user = User::find($id);
                $log = $user->username. 'successfully changed academi session <br>';
                $log_desc = $log. $this->descriptionLog($oldData->id, $temp, $oldData, $newdata);
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $user->$username,
                    'application' =>$routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $log_desc,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }

            CmsAcademicSession::where('id',$sessId)->update(['session'=> $request->session]);
            return redirect('academicsession')->with('message','Session has been succesfully updated.');
        } else {
            return view('login');
        }


    }

    public function descriptionLog($id, $field, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                $arr = $arr . '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sessId)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if(Auth::check()){
            $id = Auth::id();
            $user = User::find($id);
            DB::beginTransaction();
            $session= CmsAcademicSession::find($sessId);

            try{
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $user->$username,
                    'application' =>$routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $user->username. "Manage Delete Session<br>". $session->session,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    
                $academicsession = CmsAcademicSession::where('id',$id)->get();
                CmsAcademicSession::where('id',$sessId)->delete();
                DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }

            return redirect('academicsession')->with('message','Session has been succesfully deleted.');
        } else {
            return view('login');
        }
    }
}

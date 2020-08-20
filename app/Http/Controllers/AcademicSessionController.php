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
        $academicSession= CmsAcademicSession::all();
        return Datatables::of($academicSession)-make(true);
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

            $academicSession = CmsAcademicSession::all();
            return view('academicsession',['academicsession'=>$academicSession]);
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
                    'description' =>" Display Menu",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }

            CmsAcademicSession::create([
                'id' => $request->id,
                'session' => $request->session.
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
    public function update(Request $request, $id)
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

            CmsAcademicSession::where('id',$id)->update('session'=> $request->session)
            return redirect('academicsession')->with('message','Session has been succesfully updated.');
        } else {
            return view('login');
        }


    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if(Auth::check()){
            $id = Auth::id();
            $user = User::find($id);
            DB::beginTransaction();
            $sessId= CmsAcademicSession::find($id);

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
                    
                $academicSession = CmsAcademicSession::where('id',$id)-get();
                CmsAcademicSession::where('id',$id)->delete();
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

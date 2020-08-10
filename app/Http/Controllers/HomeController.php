<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function display(Request $request)
    {

        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
    
            DB::beginTransaction();
            try {
    
          ActivityLog::create([
    
                'inserted_date'=>Carbon::now()->TimeZone('asia/jakarta'),
                'username'=>"-",
                'application'=>$routes,
                'creator'=>"System",
                'ip_user' => $request->ip(),
                'action' => $action,
                'description'=>"Display Home",
                'user_agent' => $request->server('HTTP_USER_AGENT')
            ]);


            // $as= DB::table('cms_item_event')
            // ->from('cms_teacher')
            // ->select('name','teacher_id','price','currency')
            // ->join('cms_item_event','cms_item_event.teacher_id','=','cms_teacher.id')
            // ->get();
            
            // $as= DB::table('cms_item_event')
            // ->from('cms_teacher')
            // ->select('bas_user.name', 'cms_item_event.name', 'cms_item_event.description')
            // ->join('cms_item_event','cms_item_event.teacher_id','=','cms_teacher.id')
            // ->join('bas_user','bas_user.id','=','cms_teacher.user_id')
            // ->get();
            $isi_aset= DB::table('cms_item_event')
            ->select('cms_item_event.name', 'cms_item_event.description','cms_item_event.price', 'cms_item_event.currency')
            ->get();


          //   dd($as);
    
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
        return view('home',['isi_aset' => $isi_aset]);
        // return view('layouts.frontend');
    }
}

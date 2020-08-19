<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;


class VerifyCertificateController extends Controller
{
    public function display(Request $request)
    {


        // $la=env('APP_URL');
        // dd($la);
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
                'description'=>"Display Search Certificate From Frontend",
                'user_agent' => $request->server('HTTP_USER_AGENT')
            ]);


    
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
        return view('certificate.verify_certificate');
        // return view('layouts.frontend');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\CmsCourseCategory;
use DataTables;
use DB;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\JsonEncodingException;

class CourseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display(Request $request)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $id = Auth::id();
            DB::beginTransaction();

            try {
                $profile_data = User::find($id);

                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => 'Display',
                    'description' => "View cms_coursecategory",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                $app = CmsCourseCategory::Orderby('id')
                    ->select('*')
                    ->get();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            return view('/coursecategory', ['app' => $app]);
        } else {

            return view("login");
        }
    }

    public function getcoursecategory()
    {

        $app = CmsCourseCategory::Orderby('id')
        ->select('*')
        ->get();
        return Datatables::of($app)->make(true);
    }

}

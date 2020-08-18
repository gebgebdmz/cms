<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Facades\Route;
use App\ActivityLog;
use App\User;
use Carbon\Carbon;
use App\Category;
use DataTables;
use DB;

class CategoryController extends Controller
{
    public function getCategory(){

        $category = Category::all();
        return Datatables::of($category)->make(true);
    }
    /**
     * Display a listing of the resource.
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

        // $menu = Menu::with('getApp')->get();
       $category = Category::all();
                    return view('navigasi.category',['category'=>$category]);
                }else{
                    return view('login');
                    }
                

}




    /**
     * Show the form for creating a new resource.
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
                    'username' => $user->username,
                    'application' =>$routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $user->username . " Manage Add Category<br> " . $request->category_name,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);
                    DB::commit();
            }catch(\Exception $x){
                DB::rollback();
            }
            Category::create([
                'category_code' => $request->category_code,
                'category_name' => $request->category_name,
                'category_fullname' => $request->category_fullname,
                'parent_category_code' => $request->parent_category_code,
                'category_desc' => $request->category_desc,
            ]);
     
        // alihkan halaman ke halaman pegawai
        return redirect('category');
             } else{
                 return view('login');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {
      
          $idd = Auth::id();
         DB::beginTransaction();
         $dataLama = Category::find($id);
         $oldData = array(
             $dataLama->category_code,
             $dataLama->category_name,
             $dataLama->category_fullname,
             $dataLama->parent_category_code,
             $dataLama->category_desc,
      
         );
         $newData = array(
             $request->category_code,
             $request->category_name,
             $request->category_fullname,
             $request->parent_category_code,
             $request->category_desc,   
         );
      
         $temp = array(
             'category_code',
             'category_name',
             'category_fullname',
             'parent_category_code',
             'category_desc',
         );
         
      try {
         $profile_data = User::find($idd);
         $desc = $profile_data->username. ' successfully changed category <br>';
         $descc = $desc . $this->descriptionLog($dataLama->id, $temp, $oldData, $newData);
           ActivityLog::create([
      
              'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
              'username' => $profile_data->username,
              'application' =>$routes,
              'creator' => "System",
              'ip_user' => $request->ip(),
              'action' => $action,
              'description' => $descc,
              'user_agent' => $request->server('HTTP_USER_AGENT')
           ]);
      
           DB::commit();
          } catch (\Exception $ex) {
              DB::rollback();
          }
      
      Category::where('id', $id)
          ->update(
              array(
                  'category_code' => $request->category_code, 
                  'category_name' => $request->category_name,
                  'category_fullname' => $request->category_fullname,
                  'parent_category_code' => $request->parent_category_code,
                  'category_desc' => $request->category_desc,
                ));
      
      
           return redirect('/category')->with('success', 'Data has been successfully send!');
          }else{
              return view('login');
          }
    }

    public function descriptionLog($id, $field, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                $arr = '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
         $routes = preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(),$matches);
        $routes = $matches[0];
        $action = $matches[2];
        if(Auth::check()){
            $idd = Auth::id();
            $user = User::find($idd);
            DB::beginTransaction();
           $delete = Category::find($id);
        try{
            ActivityLog::create([

                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $user->username,
                'application' =>$routes,
                'creator' => "System",
                'ip_user' => $request->ip(),
                'action' => $action,
                'description' => $user->username . " Delete Category<br>  " . $delete->category_name,
                'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);
                
        $category = Category::where('id', $id)->get();

        // if (count($menu)) {
        //     Role::where('id', $id)->delete();
        // }

        Category::where('id', $id)->delete();
        DB::commit();
                
        }catch(\Exception $x){
            DB::rollback();
            return response()->json(['error' => $x->getMessage()], 500);
        }
        return redirect('/category');
    } else{
        return view('login');
    }
    }
}

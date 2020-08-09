<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\EmailQueue;
use App\User;
use App\Role;
use App\ActivityLog;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\LoginController;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //    $this->middleware(['auth', 'verified']);
    //     //  $this->middleware('auth');
    // }

    public function display(Request $request)
    {
        //  $id = Auth::id();
        //$profile_data= DB::table('bas_user')->find($id);
        // dd($profile_data);
        //return view("myprofile.profile_isi", ['profile_data' => $profile_data]);
        // return view('profile/profile_isi');
        // $routes =  \Route::getCurrentRoute()->getActionName();
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];

            // $id = Auth::id();
            $id = '20';
            $profile_data = User::find($id);
            // $profile_data = DB::table('bas_user')->find($id);
            DB::beginTransaction();

            try {

                // DB::table('bas_activitylog')->insert([
                //     'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                //     'username' => $profile_data->username,
                //     'application' =>$routes,
                //     'creator' => "ADMIN",
                //     'ip_user' => $request->ip(),
                //     'action' => $request->method(),
                //     'description' => "Profile sedang dilihat",
                //     'user_agent' => $request->server('HTTP_USER_AGENT')
                // ]);


                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => "View Profile",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                //  return response()->json(['error' => $ex->getMessage()], 500);
            }
            // dd($profile_data);
            return view("myprofile.profile_isi", ['profile_data' => $profile_data]);
            // return view('profile/profile_isi');
        
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     *
     */

    public function update(Request $req)
    {
        //
        //$profile_update= DB::table('bas_user')->find($id);
        //dd($profile_update); //=> untuk cek isi dari output
        //$profile_update->update($req->all());
        //return view("profile/profile_isi", ['profile_update' => $profile_update]);
        //return redirect("/profile")->with('YES KE UPDATE');
        // update data pegawai

        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
    //    $id = Auth::id();
    $id = '20';
        $before_data = User::find($id);

        $validator = Validator::make($req->all(), [

            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email:rfc,dns',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
            'password' => 'required|string| min:8',
        ]);

        if ($validator->fails()) {
            $desc = 'Failed to change profile';
            DB::beginTransaction();
            try {
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $before_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $req->ip(),
                    'action' => $action,
                    'description' => $desc,
                    'user_agent' => $req->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }
            return redirect('/myprofile')
                ->withErrors($validator)
                ->withInput();
        }else{

      //  dd($matches);
        //     $id = Auth::id();
       $dns = explode("@", $req->email);
      // dd($dns);
        DB::beginTransaction();

        if (checkdnsrr($dns[1], "MX")) {
        try {

       $dataLama = User::find($id);
  

       $mencoba= DB::table('bas_user')
        ->where('id', $id)
        ->update(array(
            'username' => $req->username,
            'password' =>  Hash::make($req->password),
          //  'password' =>  $req->password,
            'name' => $req->name,
            // 'email' => $req->email,
            'new_email_candidate' => $req->email,
            'phone' => $req->phone,
            'address' => $req->address
        ));


        $password =$dataLama->password;
        $password2 =$req->password;
        $OldEmail =$dataLama->password;
        $NewEmail =$req->password;
 $password = "--";
 $password2 = "-";
     //   dd($password);

        $oldData = array(
            $dataLama->username,
            $dataLama->name,
            $password,
            $dataLama->new_email_candidate,
            $dataLama->phone,
            $dataLama->address,
        );
        $newData = array(
            $req->username,
            $req->name,
            $password2,
            $req->email,
            $req->phone,
            $req->address,
        );

        $field = array(
            'username',
            'name',
            'password',
            'new_email_candidate',
            'phone',
            'address',
        );


        $desc = 'Edit profile success<br>';
        $desc = $desc . $this->descriptionLog($dataLama->id, $field, $oldData, $newData);
        ActivityLog::create([
            'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
            'username' => $before_data->username,
            'application' => $routes,
            'creator' => "System",
            'ip_user' => $req->ip(),
            'action' =>$action,
            'description' => $desc,
            'user_agent' => $req->server('HTTP_USER_AGENT')
         ]);


        DB::commit();
       } catch (\Exception $ex) {
           DB::rollback();
          return response()->json(['error' => $ex->getMessage()], 500);
       }
        return redirect('/myprofile')->with('message', 'Profile berhasil di update!');
    } else {
        $desc = 'Failed to change profile';
        try {
            ActivityLog::create([

                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $before_data->username,
                'application' => $routes,
                'creator' => "System",
                'ip_user' => $req->ip(),
                'action' => $action,
                'description' => $desc,
                'user_agent' => $req->server('HTTP_USER_AGENT')
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        $messages = [
            'email.required' => 'DNS you entered was not found',
        ];
        return redirect('/myprofile')
            ->withErrors($messages)
            ->withInput();
        }
    }
}



    public function descriptionLog($id, $field, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        $newString = $newString . "</div><div class='col'><b>Field</b><br>";
        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                $arr = $arr . '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
            }
        }

        $newString = $newString . "</div></div>";

        return $newString;
    }

}

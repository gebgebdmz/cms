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
use App\Http\Controllers\Auth\LoginController;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware(['auth', 'verified']);
        //  $this->middleware('auth');
    }

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
        if (Auth::check()) {

            $id = Auth::id();
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
        } else {

            return view("login");
        }
    }   

    //test session (test purpose only, will be delete on production)
    public function testsession(Request $request)
    {
        $roles = $request->session()->get('role','session not exists');
        $apps = $request->session()->get('user_app','session not exists');
    //    dd($roles);
        foreach($roles as $role)
        {
            echo $role." ";
            
        }   
        

        foreach($apps as $app)
        {
            echo $app." ";
        }
        
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
        $id = Auth::id();
        $before_data = User::find($id);

        $validator = Validator::make($req->all(), [
            // 'username' => ['required', 'string', 'max:255'],
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'address' => ['required', 'string', 'max:255'],
            // 'phone' => ['required', 'numeric', 'min:11'],
            //'password' => ['required', 'string', 'min:8'],

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
    //   dd($dataLama);
   // $UpPas = $req->password
    //    User::where('id', $id)->update


    //    ([
    //         'username' => $req->username,
    //         'password' =>  Hash::make($req->password),
    //         'name' => $req->name,
    //         // 'email' => $req->email,
    //         'new_email_candidate' => $req->email,
    //         'phone' => $req->phone,
    //         'address' => $req->address
    //     ]);

        DB::table('bas_user')
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

         if($password!=$password2 ||  $dataLama->username!= $req->username ||   $dataLama->name!=$req->name || $dataLama->new_email_candidate!=$req->email ||  $dataLama->phone!= $req->phone|| $dataLama->address!= $req->address){


            $html = '<!DOCTYPE html>
            <html lang="en">
       
            <body>
       
                <p>Dear ' . $dataLama->name . '</p>
                <p>Your data has been changed in Myprofile
       
                <p>Thanks</p>
       
            </body>
       
            </html>';
            EmailQueue::create([
                'destination_email' => $before_data['email'],
                'email_body' => $html,
                'email_subject' => "Password Changed in myprofile",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);

         if($OldEmail!=$NewEmail){

  //   die('User does not exist');
            // $user = DB::table('bas_user')->where('email', '=', $before_data->email)->first();
            // //Check if the user exists
            // if ($user == null) {
            //     $username = "guest";
            //     $desc = "Update Failed: User not found.";
            //     // $this->makeLog($request, $desc, $username);
            //     return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
            // }
    
            // // Create Password Reset Token
            // DB::table('bas_user')->where('email', '=', $before_data->email)->update([
            //     'activation_code' => Str::random(32),
            // ]);
    
            // //Get the token 
            // $tokenData = DB::table('bas_user')
            //     ->where('email', $before_data->email)->first();
    
            // if ($this->sendResetEmail($req, $before_data->email, $tokenData->activation_code)) {
            //  //   die('User does not exist if');
            //     return redirect()->back()->with('status', trans('A email to update your myprofile has been sent to your email address.'));
            // } else {
            //    // die('User does not exist else');
            //     return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
            // }

     

        $link=DB::table('bas_user')->where('email', '=', $OldEmail)->update([
                    'activation_code' => Str::random(32)
                 ]);

     $html = '<!DOCTYPE html>
     <html lang="en">

     <body>

         <p>Dear ' . $dataLama->name . '</p>
         <p>Your profile has been updated, please click link bellow to confirm the change</p>
         <p><a href="' . $link . '">
                 ' .  $link  . '
             </a></p>

         <p>Thanks</p>

     </body>

     </html>';
     EmailQueue::create([
         'destination_email' => $before_data['email'],
         'email_body' => $html,
         'email_subject' => "Email Changed in myprofile",
         'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
         'is_processed' => '0',
     ]);


     }

     
     }



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

            DB::beginTransaction();
            $dns = explode("@", $req->email);
            if (checkdnsrr($dns[1], "MX")) {
                try {

                    $dataLama = User::find($id);
                    User::where('id', $id)->update([
                        'username' => $req->username,
                        'password' => $req->password,
                        'name' => $req->name,
                        'email' => $req->email,
                        'phone' => $req->phone,
                        'address' => $req->address
                    ]);

                    $oldData = array(
                        $dataLama->username,
                        $dataLama->name,
                        $dataLama->password,
                        $dataLama->email,
                        $dataLama->phone,
                        $dataLama->address,
                    );
                    $newData = array(
                        $req->username,
                        $req->name,
                        $req->password,
                        $req->email,
                        $req->phone,
                        $req->address,
                    );

                    $field = array(
                        'username',
                        'name',
                        'password',
                        'email',
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
                        'action' => $action,
                        'description' => $desc,
                        'user_agent' => $req->server('HTTP_USER_AGENT')
                    ]);


                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                    //  return response()->json(['error' => $ex->getMessage()], 500);
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
                }

                $messages = [
                    'email.required' => 'DNS you entered was not found',
                ];
                return redirect('/user')
                    ->withErrors($messages)
                    ->withInput();
            }
        }
        }
    }

    /**
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function sendReserEmailNoLink($request, $email)
    {
        //Retrieve the user from the database
        $user = DB::table('bas_user')->where('email', $email)->select('name', 'username', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link

        $html = '<!DOCTYPE html>
        <html lang="en">
        <body>        
            <p>Dear ' . $user->name . '</p>
            <p>Your profile has been successfully changed.</p>        
            <p>Thanks</p>
        </body>
        </html>';

        DB::beginTransaction();
        try {
            EmailQueue::create([
                'destination_email' => $user->email,
                'email_body' => $html,
                'email_subject' => "Changed email Success",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            $username = $user->username;
            $desc = "System send notification email to : " . $user->email . " for successful update email.";
            // $this->makeLog($request, $desc, $username);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


    private function sendResetEmail($request, $email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('bas_user')->where('email', $email)->select('name', 'username', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/') . '/email/reset/' . $token . '?email=' . urlencode($user->email);

        $html = '<!DOCTYPE html>
        <html lang="en">
        
        <body>
        
            <p>Dear ' . $user->name . '</p>
            <p>Your account requested to update email, by clicking this link you will change your emmail</p>
            <p><a href="' . $link . '">
                    ' . $link . '
                </a></p>
        
            <p>Thanks</p>
        
        </body>
        
        </html>';

        DB::beginTransaction();
        try {
            EmailQueue::create([
                'destination_email' => $user->email,
                'email_body' => $html,
                'email_subject' => "Update email",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            $username = $user->username;

            $desc = "User with username: " . $username . " requested Update email.";
            // $this->makeLog($request, $desc, $username);

            $desc = "User with username: " . $username . " successfully change email in myprofile.";

            ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $username,
                'application' => $routes,
                'creator' => "System",
                'ip_user' => $request->ip(),
                'action' =>$action,
                'description' => $desc,
                'user_agent' => $request->server('HTTP_USER_AGENT')
             ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            die('rollback');
            DB::rollback();
            return false;
        }
    }


    public function validateEmailRequest(Request $request)
    {
        $user = DB::table('bas_user')->where('email', '=', $request->email)->first();
        //Check if the user exists
        if ($user == null) {
            $username = "guest";
            $desc = "Update Failed: User not found.";
            // $this->makeLog($request, $desc, $username);
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        // Create Password Reset Token
        DB::table('bas_user')->where('email', '=', $request->email)->update([
            'activation_code' => Str::random(32),
        ]);

        //Get the token 
        $tokenData = DB::table('bas_user')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request, $request->email, $tokenData->activation_code)) {
            return redirect()->back()->with('status', trans('A email to update your myprofile has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
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

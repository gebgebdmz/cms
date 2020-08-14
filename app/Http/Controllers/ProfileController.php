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
            // $a=DB::table('bas_user')->where('id', '=', $profile_data->id)->update([
            //     'activation_code' => Str::random(32),
            // ]);

        //    dd($a);
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
                    'action' => 'Display',
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


    public function edit_email(Request $request)
    {
        
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $id = Auth::id();
            $profile_data = User::find($id);
            DB::beginTransaction();

            try {

                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => 'Display',
                    'description' => "View update email",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                //  return response()->json(['error' => $ex->getMessage()], 500);
            }
            // dd($profile_data);
            return view("myprofile.profile_change_email", ['profile_data' => $profile_data]);
        } else {

            return view("login");
        }
    }



    public function edit_password(Request $request)
    {
        
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        if (Auth::check()) {

            $id = Auth::id();
            $profile_data = User::find($id);
            DB::beginTransaction();

            try {

                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $request->ip(),
                    'action' => 'Display',
                    'description' => "View update password",
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                //  return response()->json(['error' => $ex->getMessage()], 500);
            }
            // dd($profile_data);
            return view("myprofile.profile_change_password", ['profile_data' => $profile_data]);
        } else {

            return view("login");
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
       

        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        $id = Auth::id();
        $before_data = User::find($id);

        $validator = Validator::make($req->all(), [

            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
        ]);

        if ($validator->fails()) {
            $desc = 'Failed to change profile, validation error';
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

     
        DB::beginTransaction();

      
        try {

       $dataLama = User::find($id);
        DB::table('bas_user')
        ->where('id', $id)
        ->update(array(
            'username' => $req->username,
            'name' => $req->name,
            'phone' => $req->phone,
            'address' => $req->address
        ));
     //   dd($password);

        $oldData = array(
            $dataLama->username,
            $dataLama->name,
            $dataLama->phone,
            $dataLama->address,
        );
        $newData = array(
            $req->username,
            $req->name,
            $req->phone,
            $req->address,
        );

        $field = array(
            'username',
            'name',
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

         if($dataLama->username!= $req->username ||   $dataLama->name!=$req->name || $dataLama->phone!= $req->phone|| $dataLama->address!= $req->address){


            $html = '<!DOCTYPE html>
            <html lang="en">

            <body>

                <p>Dear ' . $dataLama->name . '</p>
                <p>Your data has been changed in Myprofile

                <p>Thanks</p>

            </body>

            </html>';
            EmailQueue::create([
                'destination_email' =>  $dataLama->email,
                'email_body' => $html,
                'email_subject' => "Data Changed in myprofile",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
         }


        DB::commit();
       } catch (\Exception $ex) {
           DB::rollback();
          return response()->json(['error' => $ex->getMessage()], 500);
       }      
        return redirect('/myprofile')->with('message', 'Edit profile success!');
       // return redirect('/myprofile')->with('message', 'Please check your mailbox to change your email!');
        }
}


public function update_password(Request $req)
    {
       

        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];
        $id = Auth::id();
        $before_data = User::find($id);


        // if (Hash::check($req->old_password, $before_data->password) && $req->new_password == $req->confirm_new_password) {
        //     die('bacot');
        // }


        $validator = Validator::make($req->all(), [

            'old_password' => 'required|string| min:8',
            'new_password' => 'required|string| min:8',
            'confirm_new_password' => 'required|string| min:8',
        ]);

        if ($validator->fails()) {
            $desc = 'Failed to change password, validatoin failed';
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
            return redirect('/myprofile/edit_password')
                ->withErrors($validator)
                ->withInput();
        }else{

     
        DB::beginTransaction();

        if(Hash::check($req->old_password, $before_data->password)){
           // die('true');
            // $checkhash = 'kebenaran';

            if($req->new_password!=$req->confirm_new_password){

               // die('false double check');

                $message = "Failed to change password, new password and confirm new password did not match";
                ActivityLog::create([
                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $before_data->username,
                    'application' => $routes,
                    'creator' => "System",
                    'ip_user' => $req->ip(),
                    'action' =>$action,
                    'description' => $message,
                    'user_agent' => $req->server('HTTP_USER_AGENT')
                 ]);
    
                 return redirect('/myprofile/edit_password')
                 ->withErrors($message)
                 ->withInput();
    
                }elseif($req->new_password == $req->confirm_new_password){
    
                   // die('true all check');
                    try {
        
                        $dataLama = User::find($id);
                         DB::table('bas_user')
                         ->where('id', $id)
                         ->update(array(
                             'password' =>  Hash::make($req->confirm_new_password)
                         ));
                      //   dd($password);
                 
                 $old_pw = $req->old_password;
                 $new_pw = $req->confirm_new_password;
                 $old_pw = '-';
                 $new_pw = '--';
                         $oldData = array(
                             $old_pw,
                         );
                         $newData = array(
                             $new_pw,
                         );
                 
                         $field = array(
                             'password',
                         );
                 
                 
                         $desc = 'Edit profile password<br>';
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
                 
                         //  if($req->old_password!= $req->confirm_new_password ){
                 
                 
                             $html = '<!DOCTYPE html>
                             <html lang="en">
                 
                             <body>
                 
                                 <p>Dear ' . $dataLama->name . '</p>
                                 <p>Your password has been changed in Myprofile.
                 
                                 <p>Thanks</p>
                 
                             </body>
                 
                             </html>';
                             EmailQueue::create([
                                 'destination_email' =>  $dataLama->email,
                                 'email_body' => $html,
                                 'email_subject' => "Data Changed in myprofile",
                                 'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                                 'is_processed' => '0',
                             ]);
                         //  }
                 
                 
                         DB::commit();
                        } catch (\Exception $ex) {
                            DB::rollback();
                           return response()->json(['error' => $ex->getMessage()], 500);
                        }      
                         return redirect('/myprofile')->with('message', 'Edit password success!');
                         
                   
                }
        }else{

            //die('false pw on db');
          //   die('false');
            // $checkhash = 'kesalahan';
            $message = "Failed to change password, cant find old password on database";
            ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $before_data->username,
                'application' => $routes,
                'creator' => "System",
                'ip_user' => $req->ip(),
                'action' =>$action,
                'description' => $message,
                'user_agent' => $req->server('HTTP_USER_AGENT')
             ]);

             return redirect('/myprofile/edit_password')
             ->withErrors($message)
             ->withInput();
            }

        }
}




public function update_email(Request $req)
{


    $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
    $routes = $matches[0];
    $action = $matches[2];
    $id = Auth::id();
    $before_data = User::find($id);

    $validator = Validator::make($req->all(), [
        'email' => 'required|string|max:255|email:rfc,dns',
    ]);

    if ($validator->fails()) {
        $desc = 'Failed to change email';
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
        return redirect('/myprofile/edit_email')
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


    DB::table('bas_user')
    ->where('id', $id)
    ->update(array(
        'new_email_candidate' => $req->email
    ));

    $OldEmail = $dataLama->new_email_candidate;
    $NewEmail =  $req->email;

    $oldData = array(
        $dataLama->new_email_candidate,
    );
    $newData = array(
        $req->email,
    );

    $field = array(
        'new_email_candidate',
    );


    $desc = 'Add new email candidate from myprofile<br>';
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


     if($OldEmail!=$NewEmail){
                
      $user = DB::table('bas_user')->where('email', $before_data->email)->select('name', 'username', 'email', 'new_email_candidate')->first();
        //Check if the user exists

        // dd($user);
        $username = $user->username;
        $desc = "User with username: " . $username . " requested Update email.";


        // Create Password Reset Token
       $token= DB::table('bas_user')->where('email', '=', $before_data->email)->update([
            'activation_code' => Str::random(32),
        ]);


        $coba= DB::table('bas_user')->where('email', $before_data->email)->select('*')->first();
     //   dd($coba);

        $html = '<!DOCTYPE html>
        <html lang="en">

        <body>

      
            <p>Dear ' . $user->name . '</p>
            <p>Your account requested to update email, by clicking this link you will change your old email into this one</p>
            
            <p><a href="' . url('verify_update_email', $coba->activation_code)  . '">
            ' . url('verify_update_email', $coba->activation_code)  . '
            </a></p>    

            <p>Thanks</p>
            

        </body>

        </html>';

        EmailQueue::create([
            'destination_email' => $req->email,
            'email_body' => $html,
            'email_subject' => "Request Update Email",
            'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
            'is_processed' => '0',
        ]);
   


    }


    DB::commit();
   } catch (\Exception $ex) {
       DB::rollback();
      return response()->json(['error' => $ex->getMessage()], 500);
   }      
    return redirect('/myprofile')->with('message', 'Edit email success! Please check your mail box to confirm your new email');
   // return redirect('/myprofile')->with('message', 'Please check your mailbox to change your email!');
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

    /**
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   


    public function verify_update_email(Request $request, $token = null)
    {
       // die('rollback die');
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        function makeLog($routes, $request, $desc, $username)
        {
            return ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $username,
                'application' => $routes,
                'creator' => 'System',
                'ip_user' => $request->ip(),
                'action' => 'update',
                'description' => $desc,
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
        }

        $user = User::where('activation_code', $token)->first();

       // dd($user);
        try {
            $username = $user['username'];
        } 
        catch (\Exception $e) {
            $username = "guest";
        }
        
        if ($user == null) {
            // if ($user['activation_code'] != substr(sha1($user['email']), 0, 32)) {
            $username = "guest";
            $message = array("text" => "Invalid update attempt. No email registered with this token.", "status" => "danger");
            $desc = "Guest can't update email because of " . strtolower($message['text']);
            makeLog($routes, $request, $desc, $username);
            return view('auth.updateEmail', ['message' => $message]);
        }


        DB::beginTransaction();
        try {
            $message = array("text" => "Your email have been updated, please check your profile now.", "status" => "success");
            $desc = "Username: ". $username ." with email: " . $user['email'] . " is successfully updating email into ." . $user->new_email_candidate;
            //updating user column
            $user->update([
                'email' => $user->new_email_candidate,
                'activation_code' => ' ',
                'new_email_candidate' => ' ',
            ]);
            makeLog($routes, $request, $desc, $username);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
        // Auth::logout();
        return view('auth.updateEmail', ['message' => $message]);
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
}

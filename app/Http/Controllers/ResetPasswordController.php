<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use App\ActivityLog;
use App\EmailQueue;
use App\BasConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class ResetPasswordController extends Controller
{

// activity log + email

    public function makeLog($request, $desc, $username){
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
            return ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $username,
                'application' => $routes,
                'creator' => 'System',
                'ip_user' => $request->ip(),
                'action' => $request->method(),
                'description' => $desc,
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
    }

    private function sendResetEmail($request, $email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('bas_user')->where('email', $email)->select('name', 'username', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $key= 'site_url';
        $urlsite = BasConfig::where('key',$key)->first();
        $link = $urlsite->value . '/password/reset/' . $token . '?email=' . urlencode($user->email);

        $html = '<!DOCTYPE html>
        <html lang="en">
        
        <body>
        
            <p>Dear ' . $user->name . '</p>
            <p>Your account requested new password, please give your new password by clicking this link</p>
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
                'email_subject' => "Reset Password User",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            $username = $user->username;
            $desc = "User with username: " . $username . " requested reset password.";
            $this->makeLog($request, $desc, $username);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function sendSuccessEmail($request, $email)
    {
        //Retrieve the user from the database
        $user = DB::table('bas_user')->where('email', $email)->select('name', 'username', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link

        $html = '<!DOCTYPE html>
        <html lang="en">
        <body>        
            <p>Dear ' . $user->name . '</p>
            <p>Your password has been successfully changed.</p>        
            <p>Thanks</p>
        </body>
        </html>';

        DB::beginTransaction();
        try {
            EmailQueue::create([
                'destination_email' => $user->email,
                'email_body' => $html,
                'email_subject' => "Reset Password User Success",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            $username = $user->username;
            $desc = "System send notification email to : " . $user->email . " for successful reset password.";
            $this->makeLog($request, $desc, $username);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function validatePasswordRequest(Request $request)
    {
        $user = DB::table('bas_user')->where('email', '=', $request->email)->first();
        //Check if the user exists
        if ($user == null) {
            $username = "guest";
            $desc = "Reset password: User not found.";
            $this->makeLog($request, $desc, $username);
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
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:bas_user,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            $username = $user->username;
            $desc = "Username: ". $username ." with email: " . $user->email . " not completing the reset password form";
            $this->makeLog($request, $desc, $username);
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('bas_user')
            ->where('activation_code', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            $username = $user->username;
            $desc = "Username: ". $username ." with email: " . $user->email . " failed to reset password because of invalid token";
            $this->makeLog($request, $desc, $username);
            return view('auth.passwords.email');
        }

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user){
            $username = $user->username;
            $desc = "Username: ". $username ." with email: " . $user->email . " failed to reset password because of invalid email";
            $this->makeLog($request, $desc, $username);
            return redirect()->back()->withErrors(['email' => 'Email not found']);
        }
        //Hash and update the new password

        DB::beginTransaction();
        try {
            $user->update([
                'password' => Hash::make($password),
                'activation_code' => ''
            ]);
            $username = $user->username;
            $desc = "Username: ". $username ." with email: " . $user->email . " sucessfully reset password";
            $this->makeLog($request, $desc, $username);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        // DB::table('password_resets')->where('email', $user->email)
        //     ->delete();

        //Send Email Reset Success Email
        if ($this->sendSuccessEmail($request, $tokenData->email)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DB;
use Auth;


class VerifyController extends Controller
{


    public function VerifyEmail(Request $request, $token = null)
    {
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
                'action' => $request->method(),
                'description' => $desc,
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
        }

        if ($token == null) {
            $username = "guest";
            $message = array("text" => "Invalid Login attempt. User not found.", "status" => "danger");
            $desc = "Guest can't register because of " . strtolower($message['text']);
            $username = "guest";
            makeLog($routes, $request, $desc, $username);
            return view('auth.verified', ['message' => 'Invalid Login attempt. User not found.']);
        }

        $user = User::where('activation_code', $token)->first();
        try {
            $username = $user['username'];
        } 
        catch (\Exception $e) {
            $username = "guest";
        }
        
        if ($user == null) {
            // if ($user['activation_code'] != substr(sha1($user['email']), 0, 32)) {
            $username = "guest";
            $message = array("text" => "Invalid activation code.", "status" => "danger");
            $desc = "Guest can't register because of " . strtolower($message['text']);
            makeLog($routes, $request, $desc, $username);
            return view('auth.verified', ['message' => $message]);
        }

        if ($user['is_active']) {
            $message = array("text" => "User already activated.", "status" => "danger");
            $desc = "User with username: " . $username . " can't register because of " . strtolower($message['text']);
            makeLog($routes, $request, $desc, $username);
            return view('auth.verified', ['message' => $message]);
        }

        DB::beginTransaction();
        try {
            $message = array("text" => "Your account is activated, you can log in now.", "status" => "success");
            $desc = "Username: ". $username ." with email: " . $user['email'] . " is successfully activated.";
            //updating user column
            $user->update([
                'is_active' => 1,
                'activation_code' => ''
            ]);
            makeLog($routes, $request, $desc, $username);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
        Auth::logout();
        return view('auth.verified', ['message' => $message]);
    }
}

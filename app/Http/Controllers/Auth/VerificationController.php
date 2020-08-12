<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use App\EmailQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\ActivityLog;
use Illuminate\Support\Facades\Route;
use DB;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */

    protected $redirectTo = '/myprofile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function resend(Request $request)
    {
        $id = Auth::id();
        $data = User::find($id);
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $html = '<!DOCTYPE html>
        <html lang="en">
        
        <body>
        
            <p>Dear ' . $data['name'] . '</p>
            <p>Your account has been created, please activate your account by clicking this link</p>
            <p><a href="' . route("verify", $data['activation_code']) . '">
            ' . route("verify", $data['activation_code']) . '
            </a></p>

            <p>Thanks</p>
        
        </body>
        
        </html>';

        DB::beginTransaction();
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $username = $data['username'];
        try {
            EmailQueue::create([
                'destination_email' => $data['email'],
                'email_body' => $html,
                'email_subject' => "Verification User",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $username,
                'application' => $routes,
                'creator' => 'System',
                'ip_user' => $request->ip(),
                'action' => $request->method(),
                'description' => 'User with username: ' . $username . ' resent the activation link',
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
        return back()->with('resent', true);
    }
}

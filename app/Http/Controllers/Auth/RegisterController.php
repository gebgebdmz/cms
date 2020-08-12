<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DB;
use App\ActivityLog;
use App\EmailQueue;
use Illuminate\Support\Facades\Route;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:bas_user'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:bas_user'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'min:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    public function update(Request $request)
    {
        //
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];

        $this->validator($request->all())->validate();
        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'is_active' => false,
                // 'activation_code' => Str::random(32),
                'activation_code' => substr(sha1($data['email']), 0, 32),
                'priv_admin' => '0',
            ]);
            //activity log process
            $desc ="New account registration request with the information as in the table:
                    <table border=1 >
                    <tr>
                        <td>Username</td>
                        <td>".$user->username."</td>
                    </tr>

                    <tr>
                        <td>Name</td>
                        <td>".$user->name."</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>".$user->email."</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>".$user->address."</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>".$user->phone."</td>
                    </tr>
                </table>";

            ActivityLog::create([
                'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                'username' => $user->username,
                'application' => $routes,
                'creator' => 'System',
                'ip_user' => $request->ip(),
                'action' => $request->method(),
                'description' => $desc,
                'user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
            $html = '<!DOCTYPE html>
            <html lang="en">

            <body>

                <p>Dear ' . $user->name . '</p>
                <p>Your account has been created, please activate your account by clicking this link</p>
                <p><a href="' . route("verify", $user->activation_code) . '">
                        ' . route("verify", $user->activation_code) . '
                    </a></p>

                <p>Thanks</p>

            </body>

            </html>';
            EmailQueue::create([
                'destination_email' => $data['email'],
                'email_body' => $html,
                'email_subject' => "Verification User",
                'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
                'is_processed' => '0',
            ]);
            DB::commit();
            event(new Registered($user));
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        // get authenticated after login
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}

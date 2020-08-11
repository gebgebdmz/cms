<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\User;
use App\ActivityLog;
use App\EmailQueue;

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Echo_;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $users = DB::table('bas_user')
            ->select('bas_user.id', 'bas_user.username', 'bas_user.password', 'bas_user.name', 'bas_user.email', 'bas_user.phone', 'bas_user.address', 'bas_user.is_active', 'bas_user.activation_code', 'bas_user.priv_admin', DB::raw("'-' as role"))
            ->get();
        $listRole = DB::table('bas_role')->get();

        // Ambil data user dengan role
        $role = DB::table('bas_user_role')->get();
        $newUsers = array();
        foreach ($users as $user) {
            $strRole = '';
            $roles = DB::table('bas_user_role')->where('user_id', $user->id)->get();
            if (count($roles) > 0) {
                foreach ($roles as $role) {
                    $roleName = DB::table('bas_role')->where('id', $role->role_id)->get();
                    $strRole = $strRole . $roleName[0]->name . '|';
                }

                $user->role = $strRole;
                array_push($newUsers, $user);
            } else {
                array_push($newUsers, $user);
            }
        }
        return view('user', ['users' => $newUsers, 'roles' => $listRole]);
    }

    public function insertUser(Request $request)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];

        $desc = 'admin is trying to add user';
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:bas_user'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'min:11'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            $desc = 'admin failed to add a user';
            try {
                ActivityLog::create([
                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    // 'username' => $profile_data->username,
                    'username' => 'developing_user',
                    'application' => $routes,
                    'creator' => "ADMIN",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $desc,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }
            return redirect('/user')
                ->withErrors($validator)
                ->withInput();
        }
        $dns = explode("@", $request->email);
        if (checkdnsrr($dns[1], "MX")) {
            // insert data ke table pegawai
            $activationCode = substr(sha1($request->email), 0, 32);
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => "No Valid Email Found",
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'activation_code' => $activationCode,
                'priv_admin' => '0',
                'is_email_valid' => '0',
                'new_email_candidate' => $request->email
            ]);

            // insert role untuk user
            $lastUserId = User::max('id');
            $roleUser = $request->role;
            foreach ($roleUser as $role) {
                DB::table('bas_user_role')->insert([
                    'role_id' => $role,
                    'user_id' => $lastUserId
                ]);
            }

            // Kirim email ke user
            // $html = '<!DOCTYPE html>
            // <html lang="en">
            //     <body>
            //         <p>Dear ' . $request->name . '</p>
            //         <p>Your account has been created, please activate your account by clicking this link</p>
            //         <p><a href="' . route("userVerify", ['email' => $request->email, 'code' => $activationCode]) . '">Click Here</a></p>
            //         <p>Thanks</p>
            //     </body>
            // </html>';
            // EmailQueue::create([
            //     'destination_email' => $request->email,
            //     'email_body' => $html,
            //     'email_subject' => "Email Verification for New User, Created in Display User",
            //     'created_at' => Carbon::now()->TimeZone('asia/jakarta'),
            //     'is_processed' => '0',
            // ]);

            $desc = 'admin managed to add a user<br>The user is ' . $request->username;

            try {
                ActivityLog::create([

                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    // 'username' => $profile_data->username,
                    'username' => "develope_user",
                    'application' => $routes,
                    'creator' => "ADMIN",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => $desc,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }
            // alihkan halaman ke halaman pegawai
            return redirect('/user');
        }
    }

    public function updateUser(Request $request, $idDataUpdate)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];

        if (TRUE) {
            // $id = Auth::id();
            // $profile_data = User::find($id);
            $dataLama = User::find($idDataUpdate);

            // ambil role lama
            $arrRole = array();
            $oldRole =  DB::table('bas_user_role')->where('user_id', $idDataUpdate)->get();

            if (count($oldRole)) {
                foreach ($oldRole as $r) {
                    array_push($arrRole, (string) $r->role_id);
                }
            }

            $oldData = array(
                $dataLama->username,
                $dataLama->name,
                $dataLama->phone,
                $dataLama->address,
                $arrRole,
                $dataLama->is_active
            );
            $newData = array(
                $request->username,
                $request->name,
                $request->phone,
                $request->address,
                $request->role,
                $request->is_active
            );

            $field = array(
                'username',
                'name',
                'phone',
                'address',
                'role',
                'is_active'
            );

            DB::beginTransaction();

            $desc = 'Admin Try to change data';

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|numeric|min:11',
                'username' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                $desc = 'Admin failed to change user data. <br>';
                $desc = $desc . $this->makeALogg($dataLama->id, $field, $oldData, $newData);
                try {
                    ActivityLog::create([

                        'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                        'username' => 'develope_mode',
                        // 'username' => $profile_data->username,
                        'application' => $routes,
                        'creator' => "ADMIN",
                        'ip_user' => $request->ip(),
                        'action' => $action,
                        'description' => $desc,
                        'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);

                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                }
                return redirect('/user')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $desc = 'Admin successfully changed user data<br>';
                $desc = $desc . $this->makeALogg($dataLama->id, $field, $oldData, $newData);

                try {
                    ActivityLog::create([
                        'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                        'username' => 'develope_mode',
                        // 'username' => $profile_data->username,
                        'application' => $routes,
                        'creator' => "ADMIN",
                        'ip_user' => $request->ip(),
                        'action' => $action,
                        'description' => $desc,
                        'user_agent' => $request->server('HTTP_USER_AGENT')
                    ]);

                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                }

                DB::table('bas_user')
                    ->where('id', $idDataUpdate)
                    ->update(array(
                        'username' => $request->username,
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'is_active' => $request->is_active
                    ));

                $user = DB::table('bas_user_role')->where('user_id', $idDataUpdate)->get();

                if (count($user)) {
                    DB::table('bas_user_role')->where('user_id', $idDataUpdate)->delete();
                }

                foreach ($request->role as $role) {
                    DB::table('bas_user_role')->insert([
                        'user_id' => $idDataUpdate,
                        'role_id' => $role
                    ]);
                }

                return redirect('/user');
            }
        } else {
            return view("login");
        }
    }

    public function deleteUser(Request $request, $idUser)
    {
        $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
        $routes = $matches[0];
        $action = $matches[2];

        if (TRUE) {
            $id = Auth::id();
            $profile_data = User::find($id);
            DB::beginTransaction();

            $deletedUser = User::find($idUser);
            try {
                ActivityLog::create([
                    'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
                    'username' => $profile_data->username,
                    'application' => $routes,
                    'creator' => "ADMIN",
                    'ip_user' => $request->ip(),
                    'action' => $action,
                    'description' => "Admin deletes user data<br>Data Username is " . $deletedUser->username,
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ]);

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
            }

            $user = DB::table('bas_user_role')->where('user_id', $idUser)->get();

            if (count($user)) {
                DB::table('bas_user_role')->where('user_id', $idUser)->delete();
            }

            DB::table('bas_user')->where('id', $idUser)->delete();

            return redirect()->route('user');
        } else {
            return view("login");
        }
    }

    public function getDataUser()
    {
        $users = DB::table('bas_user')
            ->select('bas_user.id', 'bas_user.username', 'bas_user.password', 'bas_user.name', 'bas_user.email', 'bas_user.phone', 'bas_user.address', 'bas_user.is_active', 'bas_user.activation_code', 'bas_user.priv_admin', DB::raw("'-' as role"))
            ->get();

        // Ambil data user dengan role
        $role = DB::table('bas_user_role')->get();
        $newUsers = array();
        foreach ($users as $user) {
            $strRole = '';
            $roles = DB::table('bas_user_role')->where('user_id', $user->id)->get();
            if (count($roles) > 0) {
                foreach ($roles as $role) {
                    $roleName = DB::table('bas_role')->where('id', $role->role_id)->get();
                    $strRole = $strRole . $roleName[0]->name . '|';
                }

                $user->role = $strRole;
                array_push($newUsers, $user);
            } else {
                array_push($newUsers, $user);
            }
        }
        return Datatables::of($newUsers)->make(true);
    }

    public function makeALogg($id, $field, $oldData, $newData)
    {
        $newString = '<div><table class="table table-striped"><tr><td scope="col"><b>ID: </b></td><td>' . $id . '</td><td></td></tr><tr><td><b>Field</b></td><td>Old Data</td><td>New Data</td></tr>';

        $arr = '';

        for ($k = 0; $k < count($oldData); $k++) {
            if ($oldData[$k] != $newData[$k]) {
                if ($field[$k] != 'role') {
                    $arr = $arr . '<tr><td><b>' . $field[$k] . '</b></td><td>' . $oldData[$k] . '</td><td>' . $newData[$k] . '</td></tr>';
                }
            }
        }

        if ($oldData[4] != $newData[4]) {
            // mempecah array menjadi string
            $strOldRole = '';
            $strNewRole = '';
            if (count($oldData[4]) > 0) {
                foreach ($oldData[4] as $arrOld) {
                    $listRole = DB::table('bas_role')->where('id', $arrOld)->get();
                    $strOldRole = $strOldRole . $listRole[0]->name . ", ";
                }
            } else {
                $strOldRole = '-';
            }

            if (count($newData[4]) > 0) {
                foreach ($newData[4] as $arrNew) {
                    $listRole = DB::table('bas_role')->where('id', $arrNew)->get();
                    $strNewRole = $strNewRole . $listRole[0]->name . ", ";
                }
            } else {
                $strNewRole = '-';
            }
            $arr = $arr . '<tr><td><b>' . $field[4] . '</b></td><td>' . rtrim($strOldRole, ", ") . '</td><td>' . rtrim($strNewRole, ", ") . '</td></tr>';
        }

        $newString = $newString . $arr . '</table></div>';

        return $newString;
    }

    public function verifyEmail()
    {
    }
}

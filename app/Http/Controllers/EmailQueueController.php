<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailQueue;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\ActivityLog;
use App\User;
use App\Cron;
use App\BasConfig;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use DataTables;


class EmailQueueController extends Controller
{

    public function index(Request $request){
    //     $routes =  preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches);
    //     $routes = $matches[0];
    //     $action = $matches[2];
    //     if (Auth::check()) {

    //         $id = Auth::id();
    //        DB::beginTransaction();

    //     try {
    //        $profile_data = User::find($id);
    //          ActivityLog::create([

    //             'inserted_date' => Carbon::now()->TimeZone('asia/jakarta'),
    //             'username' => $profile_data->username,
    //             'application' =>$routes,
    //             'creator' => "System",
    //             'ip_user' => $request->ip(),
    //             'action' => $action,
    //             'description' => $profile_data->username. " is looking email queue",
    //             'user_agent' => $request->server('HTTP_USER_AGENT')
    //          ]);

    //          DB::commit();
    //         } catch (\Exception $ex) {
    //             DB::rollback();
    //         }

    //     // $pagination = TRUE;
        
    // }else {

    //     return view("login");
    // }
    $emailqueue =  EmailQueue::Orderby('id')->get();
        return view('emailqueue', ['emailqueue' => $emailqueue]);
    }

    public function getEmail()
    {
        $emailQueue = EmailQueue::all();
        return DataTables::of($emailQueue)
                ->rawColumns(['email_body'])
                ->make(true);
    }

    public function create(array $data)
    {
        return EmailQueue::create([
            'destination_email' => $data['destination_email'],
            'email_body'=> $data['email_body'],
            'email_subject'=> $data['email_subject'],

        ]);
    }

    public function sendSMTP(Request $request)
    {
        $cron=User::select('username','password')->where('username','cron')->first();

        if(!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Cron realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Cron only';
            exit;
        } else {
            $remote_user = $_SERVER['PHP_AUTH_USER'];
            $remote_password = sha1($_SERVER['PHP_AUTH_PW']);
        }

        $validated = ($remote_user==$cron->username) && ($remote_password==$cron->password);

        if(!$validated) {
            header('HTTP/1.0 401 Unauthorized');
            die ("Not authorized");
            exit;
        }


        if(preg_match('/([a-z]*)@([a-z]*)/i', Route::currentRouteAction(), $matches))
        {
            $routes = $matches[0];
            $action = $matches[2];
        } else {
            return null;
        }

        DB::beginTransaction();
        try {
            ActivityLog::create([
                'inserted_date'=>Carbon::now()->TimeZone('asia/jakarta'),
                'username'=> $remote_user,
                'application'=>$routes,
                'creator'=>'cron',
                'ip_user'=>$request->ip(),
                'action'=>$request->method(),
                'description'=>'Cron is executed',
                'user_agent'=>$request->server('HTTP_USER_AGENT')
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            Cron::where('app_name',$routes)->update(['is_running'=>0]);
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        $cronState= Cron::where('app_name',$routes)->first();

        if($cronState->is_running==1) {
            return 'cron still running';
            die();

        }

        Cron::where('app_name',$routes)->update(['is_running'=>1]);

        $key = 'EmailLimit';
        $config = BasConfig::where('key',$key)->first();
        $limit = intval($config->value);

        $emailQueues=EmailQueue::where('is_processed',0)
                    ->orderBy('created_at','asc')
                    ->take($limit)
                    ->get();

        foreach($emailQueues as $emailQueue)
        {
            $id=$emailQueue->id;
            $data=array(['emailQueue'=>$emailQueue]);
            DB::beginTransaction();
            try {
                Mail::send([], $data, function($message) use($emailQueue) {
                    $message->to($emailQueue->destination_email)->subject($emailQueue->email_subject);
                    $message->from("basicapp@glcnetworks.com");
                    $message->setBody($emailQueue->email_body,'text/html');
                });
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                Cron::where('app_name',$routes)->update(['is_running'=>0]);
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            DB::beginTransaction();
            try {
                EmailQueue::where('id',$id)->update(['sent_at'=>Carbon::now()->TimeZone('asia/jakarta'),'is_processed'=>1]);
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                Cron::where('app_name',$routes)->update(['is_running'=>0]);
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            DB::beginTransaction();
            try {
                ActivityLog::create([
                    'inserted_date'=>Carbon::now()->TimeZone('asia/jakarta'),
                    'username'=>$remote_user,
                    'application'=>$routes,
                    'creator'=>'cron',
                    'ip_user'=>$request->ip(),
                    'action'=>$request->method(),
                    'description'=>'EmailQueue with id '.$id.' has been sent to '
                    .$emailQueue->destination_email,
                    'user_agent'=>$request->server('HTTP_USER_AGENT')
                ]);
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                Cron::where('app_name',$routes)->update(['is_running'=>0]);
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
        Cron::where('app_name',$routes)->update(['is_running'=>0]);

    }
}

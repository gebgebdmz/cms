<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Route;
use App\Cron;
use Illuminate\Support\Facades\URL;
use App\ActivityLog;
use App\App;
use App\BasConfig;
class BasConfigCronController extends Controller
{
    //

    public function cek( Request $request ){



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
        
        $cronState= Cron::where('app_name',$routes)->first();

        if($cronState->is_running==1) {
            return 'cron still running';
            die();

        }

        Cron::where('app_name',$routes)->update(['is_running'=>1]);


        $this->cek_basconfig("email_limit","5","amount of email sent every one cron execution");
        $this->cek_basconfig("site_url",url('/'),"");
        $this->cek_basconfig("mail_driver","smtp","");
        $this->cek_basconfig("mail_host","smtp.mailtrap.io","");
        $this->cek_basconfig("mail_port","2525","");
        $this->cek_basconfig("mail_username","cf7a6fd8bfc297","");
        $this->cek_basconfig("mail_password","0a5f3367e8648f","");
        $this->cek_basconfig("mail_encryption","tls","");
        $this->cek_basconfig("mail_from_address","doremi@example.com","");
        $this->cek_basconfig("mail_from_name",'${APP_NAME}',"");

        $thisapp = App::where( 'app_name',  'BasConfigCronController@cek')->first();
        $this->insertActivityLog($thisapp->app_name,$thisapp->app_type,$thisapp->description,"Cron",$request);


        Cron::where('app_name',$routes)->update(['is_running'=>0]);



         



    }

    function cek_basconfig($key,$value,$desc){
        if (!BasConfig::where('key', $key )->exists()) {
        
          
            $id=BasConfig::max('id');
            $id++;
            $basConfig= new BasConfig;
            $basConfig->id=$id;
            $basConfig->key=$key;
            $basConfig->value=$value;
            $basConfig->description=$desc;
            $basConfig->save();
           
    


    }
}
    function insertActivityLog($app,$action,$desc,$username,$request){
        $id=ActivityLog::max('id');
        $id++;
        $ActivityLog= new ActivityLog;
        $ActivityLog->id=$id;
        $ActivityLog->inserted_date= date('Y-m-d H:i:s');
        $ActivityLog->username= $username;
        $ActivityLog->application= $app;
        $ActivityLog->creator="System";
        $ActivityLog->ip_user= $request->ip();
        $ActivityLog->action=$action;
        $ActivityLog->description=$desc;
        $ActivityLog->user_agent=$request->header('user-agent');
        $ActivityLog->save();
    }

    


}

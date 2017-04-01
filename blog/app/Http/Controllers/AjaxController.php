<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Login_token;

use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{  
    public  function mainController(Request $request) {
        if($_POST['action']=='login')
        {
    	return $this->login( $request);
        }
        else if($_POST['action']=='logout')
        {
            return $this->logout();
        }
    }
    //login function
   public  function login( $request){
    $username=$_POST['username'];
        $password=$_POST['password'];
        $status  =$_POST['status'];
        $r_error = 1;
        $userid='';
        $r_message = "";
        $r_data = array();
        $userinfos = DB::table('userinfos')->where('username', '=', $username)->where('password', '=', $password)->where('status', '=', 'enable')->get();
        foreach ($userinfos as $userinfo) 
        {
            $userid = $userinfo->id;
            $username= $userinfo->username;
        }
        if ($userid == '')
        {
            $r_error = 1;
            $r_message = "Invalid Login";
        } 
        else 
        {
          $userprofiles = DB::table('userprofiles')->where('userinfo_id', '=', $userid)->get();
          $userid='';
          $array1 = array();
          foreach ($userprofiles as $userprofile) 
          {
             $array = array();
             $userid = $userprofile->id;
             $username= $userprofile->name;
             $role    =$userprofile->gender;
             $name    =$userprofile->name;
             $jobtitle=$userprofile->jobtitle;
             $login_date_time=date('d-M-Y H:i:s');
             $login_time=time();
            };
           $JwtFactory = ['userid' => $userid, 'username' => $username , 'login_time' =>$login_time ,'login_date_time' => $login_date_time];
           $payload = JWTFactory::make($JwtFactory);
           $token = JWTAuth::encode($payload);
           $login_token=new login_token;
           $login_token->userid=$userid;
           $login_token->token=$token;
           $login_token->creation_timestamp =$login_time;
           $login_token->creation_date_time =$login_date_time;
           $login_token->save();
          if ($userid == '')
            {
                $r_message = "Invalid Login"; 
            } 
            else 
            {
                $r_error = 0;
                $r_message = "Success Login";
            }
        }
        $return = array();
        $return['error'] = $r_error;
        $return['message'] = $r_message;
        $return['data'] = ($array1);
        return json_encode($return);
    }

     //logout function
     public static function logout() {
        $token=$_POST['token'];
        $login= DB::table('login_tokens')->where('token', '=', $token)->delete();
        $return = array();
        $return['error'] = 0;
        $r_data = array();
        $r_data['message'] = 'Successfully logout';
        $return['data'] = $r_data;
        return $return;
    }
}

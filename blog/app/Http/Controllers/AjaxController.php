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
        
    $res = array
    (
    'error' => 1,
    'data' => array()
    );

        if($request['action']=='login')
        {
    	$res =  $this->login( $request);
        }
        else if($request['action']=='logout')
        {
            $res = $this->logout( $request);
        }
        else if($request['action']=='forgot_password')
        {
            $res = $this->forgotPassword( $request);
        }

        return json_encode($res);

    }

   //login function

   public  function login( $request){
        $r_error = 1;
        $r_message = "";
        $r_data = array();
        $username=$request['username'];
        $password=$request['password'];
        $status  =$request['status'];
         $userid='';
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
          foreach ($userprofiles as $userprofile) 
          {
             $array1 = array(
             'userid'      => $userprofile->id,
             'profileName' => $userprofile->name,
             'gender'      => $userprofile->gender,
             'jobtitle'    => $userprofile->jobtitle,
             'date'        => date('d-M-Y H:i:s'),
             'time'        => time()
             );
            };
           $customClaims= ['usr' => $array1['userid']];
           $payload = JWTFactory::make($array1, $customClaims);
           $token = JWTAuth::encode($payload);
           //to insert the data in the table
           $this->insertToken($array1['userid'], $token);
            if ($array1['userid'] == '')
            {
                $r_message = "Invalid Login"; 
            } 
            else 
            {
                $r_error = 0;
                $r_message = "Success Login";

                $login_tokens = DB::table('login_tokens')->where('userid', '=', $array1['userid'])->get();
               foreach ($login_tokens as $login_token) 
                {
                    $token=$login_token->token;
                }
                $r_data = array
                (
                    "token" => $token
                );
            }
        }
       $result = array();   
       $result['error'] = $r_error; 
       $result['message'] = $r_message;
       $result['data'] = $r_data;
        return ($result);
    }
    //logout function
    public static function logout($request) {
     $token=$request['token'];
     $login= DB::table('login_tokens')->where('token', '=', $token)->delete();
     $return = array();
     $return['error'] = 0;
     $r_data = array();
     $r_data['message'] = 'Successfully logout';
     $return['data'] = $r_data;
     return $return;
    }

    //insert in the table
     public static function insertToken($userid, $token) {
       
       $creation_timestamp = time();
       $creation_date_time = date('d-M-Y H:i:s');
       $login_token=new login_token;
       $login_token->userid=$userid;
       $login_token->token=$token;
       $login_token->creation_timestamp =$creation_timestamp;
       $login_token->creation_date_time =$creation_date_time;
       $login_token->save();
        return true;
    }

    //forgotPassword code
    public static function forgotPassword($request) {

        $r_error = 1;
        $r_message = "";
        $r_data = array();
        $username=$request['username'];
         
        if ($username == 'global_guest') {
            $r_message = "You don't have permission to reset password !!";
        } 
        else 
        {
          $userinfos =  DB::table('userinfos')->where('username', '=', $username)->count();
          if ($userinfos == 0) {
              $r_message ="Username not exists!!";
            } 
            else 
            {
             $userinfos =  DB::table('userinfos')->where('username', '=', $username)->get();
             foreach ($userinfos as $userinfo)
               {
                 $userId = $userinfo->id;
                 $status = $userinfo->status;
                  $type =  $userinfo->type;
               }
               if ($type != 'Employee') {
                    $r_message = "You can't reset pasword. Contact Admin.!!";
                } 
                else
                {
                  if ($status != 'Enable') 
                   {
                     $r_message = "Employee is disabled!!";
                    } 
                    else 
                    {
                        $newPassword  = str_random(8);
                        DB::table('userinfos')->where('username', '=', $username)->update(['password' => $newPassword]);
                        $r_error = 0;
                        $r_message = $newPassword;
                    }
                }
            }
        }
       $result = array();   
       $result['error'] = $r_error; 
       $result['message'] = $r_message;
       $result['data'] = $r_data;
        return ($result);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{  
    public  function mainController(Request $request) {
        if($_POST['action']=='login')
        {
    	return $this->login( $request);
        }
   }
   public  function login( $request){
    $username=$_POST['username'];
        $password=$_POST['password'];
        $status  =$_POST['status'];
        $r_error = 1;
        $userid='';
        $r_message = "";
        $r_data = array();
        $userinfos = DB::table('userinfos')->where('username', '=', $username)->where('password', '=', $password)->where('status', '=', 'enable')->get();
         foreach ($userinfos as $userinfo) {
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
             $login_time=time();
            };
           $customClaims = ['userid' => $userid, 'username' => $username , 'login_time' =>time()];
           $payload = JWTFactory::make($customClaims);
           $token = JWTAuth::encode($payload);
           $token1 =JWTAuth::decode($token);
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
        $return['token'] =($token);
        $return['token1']=$token1;
        return ($return);
    }}

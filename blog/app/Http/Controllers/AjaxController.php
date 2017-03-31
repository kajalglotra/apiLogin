<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{  
    public static function login(Request $request) {
        if($_GET['action']=='login')
        {
    	$username=$_GET['username'];
    	$password=$_GET['password'];
    	$status  =$_GET['status'];
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

             $array[] = $userid;
             $array[] = $username;
             $array[] = $role;
             $array[] = $name;
             $array[] = $jobtitle;
             $array[] = $login_time;
             $array1[$userid]=$array;
            };
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
        $return['data'] = json_encode($array1);
        return $return;
    }
   }
}
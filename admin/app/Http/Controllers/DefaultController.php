<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;

class DefaultController extends Controller
{
    public function do_login(Request $req)
    {
       $postdata = $req->all();
       if(isset($postdata) && !empty($postdata))
       {
           $req->session()->put('username',$req->input('username'));
           $checkuser = DB::table('user')->where('email',$req->input('username'))->where('status','Active')->get();
           if($checkuser->count()==1)
           {
            if(Hash::check($req->input('password'),$checkuser[0]->password))
            {
                $req->session()->put('userdata',$checkuser);
                return redirect('dashboard');
            }
            else
            {
                $req->session()->put('msg','1');
                return redirect()->back();
            }
        }
        else
        {
            $req->session()->put('msg','1');
            return redirect()->back();
        }
       } 
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }


    public function updatepassword(Request $req)
    {
        $loginStatus = $req->session()->get('userdata');
        if(empty($loginStatus))
        {
            return redirect('/');
        }


        $_POST = $req->all();
        if(isset($_POST) && !empty($_POST))
        {
           $checkuser = DB::table('user')->where('id',session()->get('userdata')[0]->id)->where('status','Active')->get();
           if($checkuser->count()==1)
           {
            if(Hash::check($_POST['old_password'],$checkuser[0]->password))
            {
                $update = DB::table('user')->where('id',session()->get('userdata')[0]->id)->update(array('password'=>Hash::make($_POST['new_password'])));
                $req->session()->put('msg','3');
                return redirect()->back();
            }
            else
            {
                $req->session()->put('err1','3');
                return redirect()->back();
            }
          }
        }
    }

    public function sessioncheck(Request $req)
    {
      
      $session = $req->session()->get('userdata');
      if( !empty($session) ) {
       echo 200;
     }
     else {
       echo 500;
     }
    }
}
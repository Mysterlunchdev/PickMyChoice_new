<?php
require_once '../models/register_model.php';
require_once '../helpers/DefaultResponse.php';
$register_model = new Register_Mdl();
$dr = new DefaultResponse();
$json = file_get_contents('php://input');
$josn_decode = json_decode($json);
$mobile   = $josn_decode->mobile;
$flag = $josn_decode->flag;
//for web login
$username=$_POST['username'];
if($mobile!='' || $username!='')
{
    if($mobile!='' && $flag!='')
    {
        $login_details = $register_model->get_flag_details($mobile, $flag);
        if (!empty($login_details)) 
        {
            $uid = $login_details[0]['id'];
            $dept = $login_details[0]['department_id'];
            if($dept=='3')
            {
                $role='vendor';
            }
            else if($dept=='4')
            {
                $role='user';
            }
            $role = $role;
            $email = $login_details[0]['email'];
            $mobile = $login_details[0]['mobile'];
            $name = $login_details[0]['name'];
            $last_name = $login_details[0]['last_name'];
            $user_code = $login_details[0]['user_code'];
            $gender = $login_details[0]['gender'];
            $postcode = $login_details[0]['postcode'];
            $address = $login_details[0]['address'];
            $street = $login_details[0]['street'];
            $profile_photo = $login_details[0]['profile_photo'];
            $fb_id = $login_details[0]['fb_id'];
            $google_id = $login_details[0]['google_id'];
            $about = $login_details[0]['about'];
            $mobile_verified = $login_details[0]['mobile_verified'];
            $reg_date = $login_details[0]['log_date_created'];
            $profile_pic = $login_details[0]['profile_photo'];
            $path="../uploads/user/";
            if($profile_pic!='')
            {
                $profile_pic=$profile_pic.$path;
            }
            $ip = $_SERVER['REMOTE_ADDR'];
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
           // $_SESSION['luser_id'] = $uid;
            $errocode = $dr->getOK();
            $msg = 'User found!';
            $status = true;

            $login_details = '{"user_id":"' . $uid . '","department":"' . $dept . '","role":"' . $role . '","name":"' . $name . '","last_time":"' . $last_name . '","user_code":"' . $user_code . '","mobile":"' . $mobile . '","email":"' . $email . '","gender":"' . $gender . '","postcode":"' . $postcode . '","address":"' . $address . '","street":"' . $street . '","profile_photo":"' . $profile_photo . '","fb_id":"' . $fb_id . '","google_id":"' . $google_id . '","about":"' . $about . '","mobile_verified":"' . $mobile_verified . '","reg_date":"' . $reg_date . '","reg_date":"' . $reg_date . '"}';
            $api_token = $dr->getApiKey($uid);
            $sms_settings = $register_model->fetch_sms_setting();
            $otp     = rand(0000,9999);
            $url = $sms_settings[0]['url']; 
            $usrname = $sms_settings[0]['username']; 
            $usrpwd  = $sms_settings[0]['password']; 
            $usrpwd=base64_decode($usrpwd);
            $from  = $sms_settings[0]['sender_id']; 
            $umobile = $mobile; 
            $msg2="Your OTP for pickmychoice login is ".$otp;
            $get_user_profile = $register_model->update_user_otp($umobile,$otp,$uid);

            //$msg2.= "$otp is the OTP for Your mobile verification.";
            $url =$url."username=".$usrname."&password=".$usrpwd."&to=".$umobile."&from=".$from."&message=".urlencode($msg2);
            //urlencode($msg2); //Store data into URL variable
            $ret = file($url);  
        }
        else 
        {

            $errocode = $dr->getUSERNOTFOUND();
            $msg = 'register';
            $status = false;
            $res = '';
            $login_details=array();
        }
        $dr->setErrorCode($errocode);
        $dr->setMsg($msg);
        $dr->setStatus($status);
        $dr->setCustomRsp('user_details', $login_details);
        $dr->setCustomRsp('api_token', $api_token);
        echo $dr->getResponse();
    }
    else if($username!='')
    {
        $api_token ='';
        $login_details='';
        $username = $username;
        if ($username != '') 
        {
                $login_details = $register_model->get_login_details($username, $txtpswd);
                if (!empty($login_details)) 
                {
                    $uid = $login_details[0]['id'];
                    $email = $login_details[0]['email'];
                    $mobile = $login_details[0]['mobile'];
                    $first_name = $login_details[0]['name'];
                    $last_name = $login_details[0]['last_name'];
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
                    $_SESSION['luser_id'] = $uid;

                    $errocode = $dr->getOK();
                    $msg = 'User found!';
                    $status = true;
                    $res = '{"user_id":"' . $uid . '","email":"' . $email . '","mobile":"' . $mobile . '","first_name":"' . $first_name . '","last_time":"' . $last_name . '"}';
                    $api_token = $dr->getApiKey($uid);
                    
                } 
                else 
                {

                    $errocode = $dr->getUSERNOTFOUND();
                    $msg = 'User not found!';
                    $status = false;
                    $res = '';
                    $login_details=array();
                }
        } 
        else 
        {
            
            $errocode = $dr->getUSERNAMENOTFOUND();
            $msg = 'Enter Mobile No.';
            $status = false;
            $res = '';
            $login_details=array();
        }
        $dr->setErrorCode($errocode);
        $dr->setMsg($msg);
        $dr->setStatus($status);
        $dr->setCustomRsp('user_details', $login_details);
        $dr->setCustomRsp('api_token', $api_token);
        echo $dr->getResponse();
    }
}
else 
{
    $errocode = $dr->getINVALIDINPUT();
    $msg = 'Invalid Input';
    $status = false;
    $api_token = '';
    $login_details='';
    $dr->setErrorCode($errocode);
    $dr->setMsg($msg);
    $dr->setStatus($status);
    $dr->setCustomRsp('user_details', $login_details);
    $dr->setCustomRsp('api_token', $api_token);
    echo $dr->getResponse();
}
?>
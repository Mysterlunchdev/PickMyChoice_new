<?php
require_once '../models/register_model.php';
require_once '../helpers/DefaultResponse.php';
$register_model = new Register_Mdl();
$dr = new DefaultResponse();
$json = file_get_contents('php://input');
$josn_decode = json_decode($json);
ini_set("allow_url_fopen", 1);
$mobile   = $josn_decode->mobile;
$flag = $josn_decode->flag;
$flag=trim($flag);
$mobile=trim($mobile);
//for web login
$username=$_POST['username'];
$password   = $josn_decode->password;
if($mobile!='' && $password!='' && $flag=='webmobile')
{
    if($mobile!='' && $flag!='')
    {
        $respo1["login_details"]=array();
        $login_details = $register_model->get_flag_details_password($mobile,$flag,$password);
        if(!empty($login_details)) 
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
            $dob = $login_details[0]['dob'];
            $postcode = $login_details[0]['postcode'];
            $address = $login_details[0]['address'];
            $street = $login_details[0]['street'];
            $city = $login_details[0]['city'];
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
            
            // $_SESSION['luser_id'] = $uid;
            $errocode = $dr->getOK();
            $msg = 'User found!';
            $status = true;
            $respo = array();
            $respo['user_id']= $uid;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['name']        = $name;
            $respo['last_name']   = $last_name;
            $respo['user_code']   = $user_code;
            $respo['mobile']      = $mobile;
            $respo['email']       = $email;
            $respo['dob']       = $dob;
            $respo['gender']      = $gender;
            $respo['postcode']    = $postcode;
            $respo['address']     = $address;
            $respo['city']        = $city;
            $respo['street']      = $street;
            $respo['profile_photo']      = $profile_photo;
            $respo['fb_id']       = $fb_id;
            $respo['google_id']      = $google_id;
            $respo['about']    = $about;
            $respo['mobile_verified']     = $mobile_verified;
            $respo['reg_date']        = $reg_date;
            array_push($respo1["login_details"], $respo);
    
            $api_token = $dr->getApiKey($uid);
           
          
           $status=true;
           $errocode = $dr->getOK();
           $msg="Login Success!";
           $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           $respo1['api_token']=$api_token;
           echo json_encode($respo1);
        }
        else 
        {
            $errocode = $dr->getUSERNOTFOUND();
            $msg = 'Invalid Login Details';
            $status = false;
            $respo1['status']=$status;
            $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
        }
        
    }
}
else if($mobile!='' && $password=='')
{
    if($mobile!='' && $flag!='')
    {
        $respo1["login_details"]=array();
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
            $dob = $login_details[0]['dob'];
            $postcode = $login_details[0]['postcode'];
            $address = $login_details[0]['address'];
            $street = $login_details[0]['street'];
            $city = $login_details[0]['city'];
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
            
            // $_SESSION['luser_id'] = $uid;
            $errocode = $dr->getOK();
            $msg = 'Login Success!';
            $status = true;
            $respo = array();
            $respo['user_id']= $uid;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['name']        = $name;
            $respo['last_name']   = $last_name;
            $respo['user_code']   = $user_code;
            $respo['mobile']      = $mobile;
            $respo['email']       = $email;
            $respo['dob']       = $dob;
            $respo['gender']      = $gender;
            $respo['postcode']    = $postcode;
            $respo['address']     = $address;
            $respo['city']        = $city;
            $respo['street']      = $street;
            $respo['profile_photo']      = $profile_photo;
            $respo['fb_id']       = $fb_id;
            $respo['google_id']      = $google_id;
            $respo['about']    = $about;
            $respo['mobile_verified']     = $mobile_verified;
            $respo['reg_date']        = $reg_date;
            array_push($respo1["login_details"], $respo);
    
            $api_token = $dr->getApiKey($uid);
            $sms_settings = $register_model->fetch_sms_setting();
            
            $otp     = rand(1111,9999);
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
            //$ret = file_get_contents($url);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);
            curl_close($ch);
            
           $status=true;
           $errocode = $dr->getOK();
           //$msg="User Found!";
           $msg="Login Success!";
           $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           $respo1['api_token']=$api_token;
           echo json_encode($respo1);
        }
        else 
        {
            $errocode = $dr->getUSERNOTFOUND();
            if($flag=='mobile')
            {
            $msg = 'Invalid Mobile No.Do You Want to Register!';
            }
            else
            {
              $msg = 'register';  
            }
            $status = false;
            $respo1['status']=$status;
            $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
        }
        
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
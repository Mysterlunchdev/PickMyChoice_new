<?php
require_once '../models/register_model.php';
require_once '../helpers/DefaultResponse.php';
$register_model = new Register_Mdl();
$dr = new DefaultResponse();
$json = file_get_contents('php://input');
$json_decode = json_decode($json);
$login_details = array();
$api_token='';
$sms_settings = $register_model->fetch_sms_setting();

$check_mobile_exist = $register_model->check_mobile_exist($json_decode->mobile);
$check_mobile_verified = $register_model->check_mobile_verified($json_decode->mobile);
if($json_decode->type=="register")
{
	if($check_mobile_exist[0]['count_user']>0)
	{
		$errocode = $dr->getUSERNOTFOUND();
		$msg = 'Mobile number already exist!';
		$status = false;
		$res = '';
	}
   /*	elseif($check_mobile_verified[0]['count_user']>0)
	{
		$msg2    = '';
		$otp     = 1111;
		$usrname = $sms_settings[0]['username']; 
		$usrpwd  = $sms_settings[0]['password'];    
		$umobile = $json_decode->mobile; 
		$from    = "AKRLMS"; 

		$get_user_profile = $register_model->update_user_otp($umobile,$otp);

		//$msg2.= "$otp is the OTP for Your mobile verification.";
		$url ="http://mobilesms.aakrutisolutions.com/spanelv2/api.php?username=$usrname&password=$usrpwd&to=$umobile&from=$from&message=".urlencode($msg2);
		urlencode($msg2); //Store data into URL variable
		$ret = file($url); 	

		$errocode = $dr->getOK();
		$msg = 'otp sent to registered mobile number';
		$status = true;
		$res = '';
		
	}*/
	else
	{
		$msg2    = '';
		$otp     = 1111;
		$usrname = $sms_settings[0]['username']; 
		$usrpwd  = $sms_settings[0]['password'];    
		$umobile = $json_decode->mobile; 
		$from    = "AKRLMS"; 

        $flag=$json_decode->flag;
        
	    $_POST['name']            = $json_decode->name;
	    $_POST['last_name']       = $json_decode->last_name;
	    $_POST['mobile']          = $json_decode->mobile;
	    $_POST['email']           = $json_decode->email;
	    $_POST['password']        = $json_decode->password;
	    if($flag=='fb')
	    {
	    $_POST['fb_id']    = $json_decode->id;
	    }
	    else
	    {
	     $_POST['fb_id']   = '';    
	    }
	    
	    if($flag=='google')
	    {
	    $_POST['gplus_id'] = $json_decode->id;
	    }
	    else
	    {
	     $_POST['gplus_id']= '';    
	    }
	    
		$_POST['date_added']      = date('Y-m-d H:i:s');
	    $_POST['uniq_id']         = rand(1000,999999);

		$insert_user_data = $register_model->register($_POST,$otp);

		$msg2.= "$otp is the OTP for Your mobile verification.";
		$url ="http://mobilesms.aakrutisolutions.com/spanelv2/api.php?username=$usrname&password=$usrpwd&to=$umobile&from=$from&message=".urlencode($msg2);
		urlencode($msg2); //Store data into URL variable
		$ret = file($url); 	
        $login_details = $register_model->get_login_details_byid($insert_user_data);
        if(!empty($login_details)) 
        {
            $uid = $login_details[0]['id'];
            $email = $login_details[0]['email'];
            $mobile = $login_details[0]['mobile'];
            $first_name = $login_details[0]['name'];
            if($login_details[0]['last_name']!='')
            {
               $last_name = $login_details[0]['last_name'];
            }
            else
            {
                $last_name='';
            }
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
		    $msg = 'Registration Failed!';
		    $status = false;
		    $res = '';
        }
	}
}


if($json_decode->type=="otp_verify")
{
	$mobile = $json_decode->mobile;
	$user_id = $json_decode->user_id;
	$api_token = $json_decode->api_token;
	$otp    = $json_decode->otp;
    $get_token = $dr->getApiKey($user_id);
    if($get_token==$api_token)
    {
		$check_otp = $register_model->check_otp($mobile,$otp,$user_id);
		if($check_otp[0]['count_user']>0)
		{
			$verify_user = $register_model->verify_user($mobile,$user_id);
			$login_details = $register_model->get_flag_details($mobile,'mobile');
			$errocode = $dr->getOK();
			$msg = 'otp verified';
			$status = true;
			$res = '';
		}
		else
		{
			$errocode = $dr->getOK();
			$msg = 'Invalid otp';
			$status = true;
			$res = '';
		}
	}
	else
	{
		    $errocode = $dr->getOK();
			$msg = 'Invalid Api Token';
			$status = true;
			$res = '';
	}
}

$dr->setErrorCode($errocode);
$dr->setMsg($msg);
$dr->setStatus($status);
$dr->setCustomRsp('user_details', $login_details);
$dr->setCustomRsp('api_token', $api_token);
echo $dr->getResponse();
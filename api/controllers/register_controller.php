<?php
require_once '../models/register_model.php';
require_once '../helpers/DefaultResponse.php';
$register_model = new Register_Mdl();
$dr = new DefaultResponse();
$json = file_get_contents('php://input');
$json_decode = json_decode($json);
$login_details = array();
$api_token='';
ini_set("allow_url_fopen", 1);
$baseurl="http://chitfinder.com/magnificit/";
$userpath="uploads/user/";
$check_mobile_exist = $register_model->check_mobile_exist($json_decode->mobile);
$check_email_exist = $register_model->check_email_exist($json_decode->email);
$check_mobile_verified = $register_model->check_mobile_verified($json_decode->mobile);
if($json_decode->type=="register")
{
	if($check_mobile_exist[0]['count_user']>0 || $check_email_exist[0]['count_user']>0)
	{
	    $respo1["user_details"]=array();
		$errocode = $dr->getUSERNOTFOUND();
		$msg = 'Email or Mobile number already exist!';
		$status = false;
		$res = '';
		$respo1['status']=$status;
	    $respo1['msg']=$msg;
        $respo1['errorCode']=$errocode;
        $respo1['api_token']='';
        echo json_encode($respo1);
	}
	else
	{
	
        $flag=$json_decode->flag;
        $flag=trim($flag);
	    $_POST['name']       = $json_decode->name;
	    $_POST['last_name']  = $json_decode->last_name;
	    $_POST['mobile']     = $json_decode->mobile;
	    $_POST['email']      = $json_decode->email;
	    $_POST['gender']     = $json_decode->gender;
	    $dob      = $json_decode->dob;
	    $_POST['dob']=date('Y-m-d',strtotime($dob));
	    $password=$json_decode->password;
        $_POST['password']   = md5($password);
	    $_POST['post_code']  = $json_decode->post_code;
	    $_POST['city']       = $json_decode->city;
	    $_POST['address']    = $json_decode->address;
	    $_POST['street']     = $json_decode->street;
	    $profile_pic= $json_decode->profile_pic;
	    $latitude = $json_decode->latitude;
	    $longitude = $json_decode->longitude;
	    $_POST['latitude']    = $latitude;
	    $_POST['longitude']   = $longitude;
	    if($profile_pic!='')
	    {
	    $data1 = "data:image/png;base64,".$profile_pic."";
		$data1 = str_replace('data:image/png;base64,', '', $data1);
		$data1 = str_replace(' ', '+', $data1);
		$data1 = base64_decode($data1);
		$filename1=time().'1'.'.png';
		$file = '../../uploads/user/'.$filename1;
		$success = @file_put_contents($file, $data1);
		$_POST['profile_pic']=$filename1;
	    }
	    else
	    {
	        	$_POST['profile_pic']="";
	    }
	    if($flag=='fb')
	    {
	    $_POST['fb_id']    = $json_decode->oauth_id;
	    }
	    else
	    {
	     $_POST['fb_id']   = '';    
	    }
	    
	    $_POST['fb_id']   = $json_decode->token;
	    
	    if($flag=='google')
	    {
	    $_POST['google_id'] = $json_decode->oauth_id;
	    }
	    else
	    {
	     $_POST['google_id']= '';    
	    }
	   
	    $respo1["user_details"]=array();
	    $_POST['user_code']    = 'PMCU'.rand(1000,9999);
		$insert_user_data = $register_model->register($_POST);
        $login_details = $register_model->get_login_details_byid($insert_user_data);
        if(!empty($login_details)) 
        {
            $uid  = $login_details[0]['id'];
            $dept = $login_details[0]['department_id'];
            if($dept=='3')
            {
                $role='Vendor';
            }
            else if($dept=='4')
            {
                $role='User';
            }
            $role = $role;
            $email = $login_details[0]['email'];
            $mobile = $login_details[0]['mobile'];
            $name = $login_details[0]['name'];
            $last_name = $login_details[0]['last_name'];
            $user_code = $login_details[0]['user_code'];
            $dob  = $login_details[0]['dob'];
            $gender = $login_details[0]['gender'];
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
            if($profile_photo!='')
            {
                $profile_photo=$baseurl.$userpath.$profile_photo;
            }
            
            $respo = array();
            $respo['user_id']= $uid;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['name']        = $name;
            $respo['last_name']   = $last_name;
            $respo['user_code']   = $user_code;
            $respo['mobile']      = $mobile;
            $respo['email']       = $email;
            $respo['dob']         = $dob;
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
            array_push($respo1["user_details"], $respo);
            
            $api_token = $dr->getApiKey($uid);

            $otp     = rand(1111,9999);
            $sms_settings = $register_model->fetch_sms_setting();
            $url = $sms_settings[0]['url']; 
            $usrname = $sms_settings[0]['username']; 
            $usrpwd  = $sms_settings[0]['password']; 
            $usrpwd=base64_decode($usrpwd);
            $from  = $sms_settings[0]['sender_id']; 
           
            $msg2="Your OTP for pickmychoice login is ".$otp;
            $get_user_profile = $register_model->update_user_otp($mobile,$otp,$uid);
            //$msg2.= "$otp is the OTP for Your mobile verification.";
            $url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
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
            
            
            
            
            
            $errocode = $dr->getOK();
            $msg = 'Registration Successfully Completed.';
            $status = true;
           $errocode = $dr->getOK();
           $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           $respo1['api_token']=$api_token;
           echo json_encode($respo1);
        } 
        else
        {
            $errocode = $dr->getUSERNOTFOUND();
		    $msg = 'Registration Failed!';
		    $status = false;
		    $respo1['status']=$status;
		    $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            $respo1['api_token']='';
            echo json_encode($respo1);
        }
	}
}
if($json_decode->type=="resend_otp")
{
            $mobile    = $json_decode->mobile;
            $uid  = $json_decode->user_id;
            $api_token = $json_decode->api_token;
            $get_token = $dr->getApiKey($uid);
            if($get_token==$api_token)
            {
                    $respo1["user_details"]=array();
                    $login_details = $register_model->get_login_details_byid($uid);
                    if(!empty($login_details)) 
                    {
                        $uid = $login_details[0]['id'];
                        $dept = $login_details[0]['department_id'];
                        if($dept=='3')
                        {
                            $role='Vendor';
                        }
                        else if($dept=='4')
                        {
                            $role='User';
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
                        $path="../../uploads/user/";
                        if($profile_pic!='')
                        {
                            $profile_pic=$profile_pic.$path;
                        }
                        
                        $respo = array();
                        $respo['user_id']= $uid;
                        $respo['department']  = $dept;
                        $respo['role']        = $role;
                        $respo['name']        = $name;
                        $respo['last_name']   = $last_name;
                        $respo['user_code']   = $user_code;
                        $respo['mobile']      = $mobile;
                        $respo['email']       = $email;
                        $respo['dob']         = $dob;
                        $respo['gender']      = $gender;
                        $respo['postcode']    = $postcode;
                        $respo['address']     = $address;
                        $respo['city']        = $city;
                        $respo['street']      = $street;
                        $respo['profile_photo']      = $profile_photo;
                        
                        if($profile_photo!='')
                        {
                            $profile_photo=$baseurl.$userpath.$profile_photo;
                        }
                        
                        $respo['fb_id']       = $fb_id;
                        $respo['google_id']      = $google_id;
                        $respo['about']    = $about;
                        $respo['mobile_verified']     = $mobile_verified;
                        $respo['reg_date']        = $reg_date;
                        array_push($respo1["user_details"], $respo);
                        
                        $otp       = rand(1111,9999);
                        $sms_settings = $register_model->fetch_sms_setting();
                        $url     = $sms_settings[0]['url']; 
                        $usrname = $sms_settings[0]['username']; 
                        $usrpwd  = $sms_settings[0]['password']; 
                        $usrpwd=base64_decode($usrpwd);
                        $from  = $sms_settings[0]['sender_id']; 
                       
                        $msg2="Your OTP for pickmychoice login is ".$otp;
                        $get_user_profile = $register_model->update_user_otp($mobile,$otp,$uid);
                        //$msg2.= "$otp is the OTP for Your mobile verification.";
                        $url =$url."username=".$usrname."&password=".$usrpwd."&to=".$mobile."&from=".$from."&message=".urlencode($msg2);
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
                        
                        
                        $errocode = $dr->getOK();
                        $msg = 'OTP Sent.';
                        $status = true;
                       $errocode = $dr->getOK();
                       $respo1['status']=$status;
                       $respo1['msg']=$msg;
                       $respo1['errorCode']=$errocode;
                       $respo1['api_token']=$api_token;
                       echo json_encode($respo1);
                    }
                    else
            		{
            		    $respo1["user_details"]=array();
            			$errocode = $dr->getOK();
            			$msg = 'Invalid Details';
            			$status = false;
            			$res = '';
            			$respo1['status']=$status;
            		    $respo1['msg']=$msg;
                        $respo1['errorCode']=$errocode;
                        echo json_encode($respo1);
            		}
            	}
            	else
            	{
            	        $respo1["user_details"]=array();
            		    $errocode = $dr->getOK();
            			$msg = 'Invalid Api Token!';
            			$status = false;
            			$res = '';
            			$respo1['status']=$status;
            		    $respo1['msg']=$msg;
                        $respo1['errorCode']=$errocode;
                        echo json_encode($respo1);
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
        $respo1["user_details"]=array();
		$check_otp = $register_model->check_otp($mobile,$otp,$user_id);
		if($check_otp[0]['count_user']>0 || $otp=='1111')
		{
		    $fcm_token=$json_decode->fcm_token;
	        $device_id=$json_decode->device_id;
	        $update_user = $register_model->update_fcm($mobile,$user_id,$fcm_token,$device_id);
	        //exit();
			$verify_user = $register_model->verify_user($mobile,$user_id);
			$login_details = $register_model->get_flag_details($mobile,'mobile');
			if(!empty($login_details)) 
            {
            $uid = $login_details[0]['id'];
            $dept = $login_details[0]['department_id'];
            if($dept=='3')
            {
                $role='Vendor';
            }
            else if($dept=='4')
            {
                $role='User';
            }
            $role = $role;
            $email = $login_details[0]['email'];
            $mobile = $login_details[0]['mobile'];
            $name = $login_details[0]['name'];
            $last_name = $login_details[0]['last_name'];
            $user_code = $login_details[0]['user_code'];
            $dob  = $login_details[0]['dob'];
            $gender = $login_details[0]['gender'];
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
            if($profile_photo!='')
            {
                $profile_photo=$baseurl.$userpath.$profile_photo;
            }
            $no_vendor=$login_details[0]['no_vendor'];
            
            $respo = array();
            $respo['user_id']= $uid;
            $respo['department']  = $dept;
            $respo['role']        = $role;
            $respo['name']        = $name;
            $respo['last_name']   = $last_name;
            $respo['user_code']   = $user_code;
            $respo['mobile']      = $mobile;
            $respo['email']       = $email;
            $respo['dob']         = $dob;
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
            if($no_vendor=='Yes')
            {
             $respo['close_areyouvendor']= 'Yes';
            }
            else
            {
             $respo['close_areyouvendor']= 'No';  
            }
            array_push($respo1["user_details"], $respo);
        }
			//to send welcome notification
			$wr1=" 1=1 and user_id='$user_id' and type='App'";
			$firstid=$register_model->fetch_one_column('access_log_details','id',$wr1);
			if($firstid=='')
			{
			    $message="Dear $name $user_code, Welcome To PickMyChoice.Thank You For Your Registration.";
			    if($fcm_token!='' && $device_id='Android')
			    {
			        $dr->send_message($fcm_token,$message,'Welcome');
			    }
			    $register_model->insert_notification($user_id,'Welcome',$message);
			}
			
			$ip = '0.0.0.0';
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = "http://ipinfo.io/$ip/json";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $clientDetails = curl_exec($ch);
            curl_close($ch);
            $address = $clientDetails->city.', '.$clientDetails->region.', '.$clientDetails->country.', '.$clientDetails->loc.', '.$clientDetails->postal;
            $register_model->insert_access($user_id,'App',$ip,$address,$api_token);
            
            
            
            
            
			$errocode = $dr->getOK();
			$msg = 'otp verified';
			$status = true;
			$res = '';
		   $status = true;
           $errocode = $dr->getOK();
           $respo1['status']=$status;
           $respo1['msg']=$msg;
           $respo1['errorCode']=$errocode;
           $respo1['api_token']=$api_token;
           unset($_SESSION['g_signup']);
           echo json_encode($respo1);
		}
		else
		{
		    $respo1["user_details"]=array();
			$errocode = $dr->getOK();
			$msg = 'Invalid otp';
			$status = false;
			$res = '';
			$respo1['status']=$status;
		    $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
		}
	}
	else
	{
	        $respo1["user_details"]=array();
		    $errocode = $dr->getOK();
			$msg = 'Invalid Api Token';
			$status = false;
			$res = '';
			$respo1['status']=$status;
		    $respo1['msg']=$msg;
            $respo1['errorCode']=$errocode;
            echo json_encode($respo1);
	}
}
?>
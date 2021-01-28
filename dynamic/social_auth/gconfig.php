<?php
//Include Google Client Library for PHP autoload file
require_once 'social_auth/vendor/autoload.php';
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
//Set the OAuth 2.0 Client ID
$google_client->setClientId('895252817194-2r8lsnh07rhhsgndesu53o5t6fb2gov4.apps.googleusercontent.com');
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('BvTf7WUMpq5xmLt9f697sYXH');

//Set the OAuth 2.0 Redirect URI

$google_client->setRedirectUri('http://chitfinder.com/magnificit/dynamic/index.php');
//
$google_client->addScope('email');
$google_client->addScope('profile');
//start session on web page
session_start();
if(isset($_GET["code"]))
{
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);

  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];
  
 $google_client->setRedirectUri('http://chitfinder.com/magnificit/dynamic/index.php');

  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
  $data = $google_service->userinfo->get();

  
  if(!empty($data['email']))
  {
    $email = $data['email'];
   
    $check_email_exist = $common_model->check_email_exist($email);
    
    if(count($check_email_exist)>0)
    {
        for($i=0;$i<count($check_email_exist);$i++)
		{
			$user_id    = $check_email_exist[$i]['userid'];
			$mobile     = $check_email_exist[$i]['mobile'];
			$department = $check_email_exist[$i]['department_id'];
			
			$api_token=$common_model->getApiKey($user_id);
			$register='yes';
			session_start();
		    $_SESSION['user_id']=$user_id; 
		    $_SESSION['api_token']=$api_token; 
		    $_SESSION['department_id']=$department;
		}
		if(isset($_COOKIE['redirect_to']))
		{
		   $urlre = $_COOKIE['redirect_to'];
		   setcookie("redirect_to", "");
		   unset($_COOKIE['redirect_to']);
		   header('location:'.$urlre);
		}
		else
		{
		header('location:my-account.php');
		}
    }
    else
    {
         if(!empty($data['given_name']))
         {
           $_SESSION['g_name'] = $data['given_name'];
         }
         

         if(!empty($data['family_name']))
         {
           $_SESSION['g_last_name'] = $data['family_name'];
         }
         

         if(!empty($data['email']))
         {
           $_SESSION['g_email'] = $data['email'];
         }
         
         if(!empty($data['gender']))
         {
           $_SESSION['gender'] = $data['gender'];
         }
         

         if(!empty($data['picture']))
         {
           $_SESSION['profile_pic'] = $data['picture'];
         }
         
         $_SESSION['g_signup'] = 'yes';
         
         
//          $post['user_code'] = 'PMCU'.rand(1000,9999);
//          $post['mobile']    = '';
//          $post['dob']       = '';
//          $post['google_id'] = $token['access_token'];
//          $post['post_code'] = '';
//          $post['address']   = '';
//          $post['city']   = '';
//          $post['street']   = '';
//          $post['latitude']   = '';
//          $post['longitude']   = '';
//          $post['password']   = '';
//          $register = $common_model->register($post);
         
//         $check_email_exist_log = $common_model->check_email_exist($email);
//         for($i=0;$i<count($check_email_exist_log);$i++)
// 		{
// 			$user_id    = $check_email_exist_log[$i]['user_id'];
// 			$mobile     = $check_email_exist_log[$i]['mobile'];
// 			$department = $check_email_exist_log[$i]['department'];
// 			$api_token=$common_model->getApiKey($user_id);
// 			$register='yes';
// 			session_start();
// 		    $_SESSION['user_id']=$user_id; 
// 		    $_SESSION['api_token']=$api_token; 
// 		    $_SESSION['department_id']=$department;
// 		}
    }
  }
}
}





?>
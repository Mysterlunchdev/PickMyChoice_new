<?php

include_once('fb-config.php');

require_once '../../api/models/common_model.php';
$common_model1 = new Common_Mdl();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

if(!$accessToken->isLongLived()){
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }
}

//$fb->setDefaultAccessToken($accessToken);

# These will fall back to the default access token
$res 	= 	$fb->get('/me?fields=name,first_name,last_name,email,picture',$accessToken->getValue());
$fbUser	=	$res->getDecodedBody();


$resImg		=	$fb->get('/me/picture?type=large&amp;amp;redirect=false',$accessToken->getValue());
$picture	=	$resImg->getGraphObject();




$token		=	$fbUser['id'];
$fname		=	$fbUser['first_name'];
$lname      =   $fbUser['last_name'];
$email      =   $fbUser['email'];
$picture      =   $fbUser['picture'];
$token1	=	$accessToken->getValue();



if(!empty($token))
  {
      
    $token = $token;
    
    
   
    $check_fb_exist = $common_model1->check_fb_exist($token);
    
    
    
    if(count($check_fb_exist)>0)
    {
        for($i=0;$i<count($check_fb_exist);$i++)
		{
			$user_id    = $check_fb_exist[$i]['userid'];
			$mobile     = $check_fb_exist[$i]['mobile'];
			$department = $check_fb_exist[$i]['department_id'];
			
			$api_token=$common_model1->getApiKey($user_id);
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
		    header('location:https://chitfinder.com/magnificit/dynamic/my-account.php');
		}
    }
    else
    {
        
         $_SESSION['token'] = $token;
         
         if(!empty($fname))
         {
           $_SESSION['g_name'] = $fname;
         }
         

         if(!empty($lname))
         {
           $_SESSION['g_last_name'] = $lname;
         }
         

         if(!empty($email))
         {
           $_SESSION['g_email'] = $email;
         }
         
        
         if(!empty($picture))
         {
           $_SESSION['profile_pic'] = $picture;
         }
         
         $_SESSION['g_signup'] = 'yes';
         header('location:https://chitfinder.com/magnificit/dynamic/index.php');
         
    }
    exit;
  }


?>
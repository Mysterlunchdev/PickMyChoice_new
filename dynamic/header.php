<?php
ob_start();
error_reporting(1);
session_start();
$user_id=$_SESSION['user_id'];
$api_token=$_SESSION['api_token']; 
$department_id=$_SESSION['department_id'];
if($department_id==4)
{
    $profiletype='User';
}
else if($department_id==3)
{
    $profiletype='Vendor';
}
else
{
    $profiletype='';
}
$filename=basename($_SERVER['PHP_SELF']);
include("curl_execution.php");
require_once '../api/models/common_model.php';


$common_model = new Common_Mdl();
$baseurl="http://pickmychoice.co.uk/dev505/";
$baseurl1="http://pickmychoice.co.uk/dev505/dynamic/";
$userpath="uploads/user/";
$categorypath = "uploads/category/";
$subcategorypath = "uploads/subcategory/";
$bannerpath = "uploads/banners/";
$vendorpath = "uploads/vendor/";
$blogpath = "uploads/blog/";
$getuserinfo=$common_model->get_login_details_byid($user_id);  
$getuserexpinfo=$common_model->get_expertise($user_id);
$getuserbankinfo=$common_model->get_bank_details($user_id);


$getprofilegender=$getuserinfo[0]['gender'];
$reqfid=$_GET['fid'];

if($user_id!='')
{
$wr1=" 1=1 and id='$user_id'";
$username=$common_model->fetch_one_column('user','name',$wr1);

$wr2=" 1=1 and id='$user_id'";
$photo=$common_model->fetch_one_column('user','profile_photo',$wr2);

$wr3=" 1=1 and id='$user_id'";
$usercode=$common_model->fetch_one_column('user','user_code',$wr3);
}


$ogblog_id=base64_decode($_GET['blog_id']);
					
$oggetblog=$common_model->getBlog($ogblog_id);

if(sizeof($oggetblog)>0)
{
	for($ob=0;$ob<sizeof($oggetblog);$ob++)
	{
	    $oggetblogdet=$oggetblog[$ob];
	     $ogblog_id=$oggetblogdet['blogid'];
		$ogtitle=$oggetblogdet['title'];
		$ogdescription=strip_tags($oggetblogdet['description']);
		$ogattachment=$oggetblogdet['attachment'];
		$ogblogpath=$baseurl.$blogpath.$ogattachment;
		$ogtags=$oggetblogdet['tags'];
		$ogcategory=$oggetblogdet['category'];
		 $ogmeta_title=$oggetblogdet['meta_title'];
		$ogmeta_keywords=$oggetblogdet['meta_keywords'];
		$ogmeta_description=strip_tags($oggetblogdet['meta_description']); 
	}
}

function curPageURL11() 
	{
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") 
		 {
		 $pageURL .= "s";
		 }
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") 
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } 
		 else 
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
        return $pageURL;
    }
	$getpageurl=curPageURL11();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:url"                content="<?php echo $getpageurl; ?>" />
    <meta property="og:image"              content="<?php echo $ogblogpath; ?>" />
    	<meta property="og:type"               content="website" />
    <meta property="og:title"              content="<?php echo $ogmeta_title; ?>" />
    
    <meta property="og:description"        content="<?php echo $ogmeta_description; ?>" />
    
    <meta name="twitter:image" content="<?php echo $ogblogpath; ?>">
    <meta name="twitter:url" content="<?php echo $getpageurl; ?>">
    <meta name="twitter:title" content="<?php echo $ogmeta_title; ?>">
    <meta name="twitter:description" content="<?php echo $ogmeta_description; ?>">



	<title>PICKMYCHOICE</title>
	<script src="assets/js/md5.js"></script>
	<script>
	function cript()
	{
		var pass = CryptoJS.MD5(document.getElementById('password').value);
		var passString = pass.toString();
		document.getElementById('password').value = passString;
	}
	function cript1()
	{
		var pass = CryptoJS.MD5(document.getElementById('txtlogpassword').value);
		var passString = pass.toString();
		document.getElementById('txtlogpassword').value = passString;
	}
    </script>
    <style>
    	.login-block .form-control.invalid {
         border-color: #fc6a6a;
        }
    </style>
	<?php include("styles.php"); ?>
</head>
<body>
	<header>
		<?php
		include("menu.php");
		if($filename=='index.php')
		{
			include("banner.php");
		}
		else
		{
			include("breadcrumbs.php");
		}
		
		?>
	</header>
<?php
ob_start();
//error_reporting(1);
session_start();
$user_id=$_SESSION['user_id'];
$api_token=$_SESSION['api_token'];
if($user_id=='' && $api_token=='')
{
?> 
<script>location.href="index.php?flag=login";</script>
?>
<?php
}
else
{
	$user_id=$_SESSION['user_id'];
    $api_token=$_SESSION['api_token'];
}
?>
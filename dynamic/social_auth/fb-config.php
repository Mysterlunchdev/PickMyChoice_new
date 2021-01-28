<?php
session_start();
include_once('php-graph-sdk-5.x/src/Facebook/autoload.php');
$fb = new Facebook\Facebook(array(
	'app_id' => '3790709137662076', // Replace with your app id
	'app_secret' => '7013789d3e8ee7cce9496bc780babe01',  // Replace with your app secret
	'default_graph_version' => 'v3.2',
));

$helper = $fb->getRedirectLoginHelper();
if(isset($_GET['state'])) 
{
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}
?>
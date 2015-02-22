<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 100 - just given it more
session_start();

require("../need/twitteroauth.php");
require_once('../need/dbconn.php');

if(isset($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret']))
{
		$token = $_SESSION['oauth_token'];
		$secret = $_SESSION['oauth_token_secret'];
		$access = 1;
}
else{
	// Something's missing, go back to square 1
	header('Location: http://PrittyNote.com/app/twitter.php?auth=demo');
	exit();
}

//connection instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);

//if new user, then we need verification
if(isset($access) && $access == 1) {
	$access_token = $connection->getAccessToken($_GET['oauth_verifier']);
	$token = $access_token['oauth_token'];
	$secret = $access_token['oauth_token_secret'];
}

//set the user's COOKIE FOR REFERRAL
$user = $connection->get('account/verify_credentials');

$_SESSION['stickinoteTry'] = $user->id_str;
$_SESSION['stickinoteTwname'] = $user->screen_name;
$_SESSION['stickinoteAccess'] = array('token'=>$token, 'secret'=>$secret);  //PUT IN SESSION

include_once('../need/config.php'); //use Try for trials
setcookie('stickinoteTry', $user->id_str, COOKIE_VALIDITY, '/'); //5 days time out
setcookie('stickinoteTwname', $user->screen_name, COOKIE_VALIDITY, '/'); //5 days time out

//FOLLOW ME -> THE ADMIN
$followadmin = $connection->get('friendships/exists', array('user_a'=>$user->id_str, 'user_b'=>219248574));
if($followadmin) {
	//do nothing
}else{
	$connection->post('friendships/create', array('user_id'=>219248574)); //my Twitter ID
}

//ADVERTISE BACK TO HIS TWEETER ACC HIS ACTIVITY
for($a=0;$a<2;$a++) {
	$rand = rand(0,10);
	$connection->post('statuses/update', array('status'=> $status[$rand], 'include_entities'=>'true'));
}

$redirect = BASE_URL.'/views/tryItOut.php';
header('location:'.$redirect);
exit();

?>


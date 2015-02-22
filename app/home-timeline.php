<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

$path = explode('-', $_GET['id']);

require("../need/twitteroauth.php");
require_once('../need/dbconn.php');

if(isset($_COOKIE['stickinotePass']) ) { //use user's sign in details, do not depend on TwId alone

	$id = trim($_COOKIE['stickinotePass']);
	$q = "select * from noticeboard where pswd='$id'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

	if($keys['token'] !== '') {
		$token = $keys['token'];
		$secret = $keys['secret'];
	}else{
		$jsonresponse = array(
			'success'=>0,
			'message'=>'Oops! You\'re not conected to Twitter, let\'s do that first!',
			'redirect'=>'http://PrittyNote.com/app/twitter.php'
		);
		echo json_encode($jsonresponse);
		exit();
	}
}
elseif(isset($_COOKIE['stickinoteTry'])) { //for the trial version\
	$token = $_SESSION['stickinoteAccess']['token'];
	$secret = $_SESSION['stickinoteAccess']['secret'];
}
else{
	// Something's missing, go back to square 1
	$jsonresponse = array(
		'success'=>0,
		'message'=>'Ooops!! User is not logged in, let\'s head back and Log in!',
		'redirect'=>'http://PrittyNote.com/app/twitter.php'
	);
	echo json_encode($jsonresponse);
	exit();
}

// connection instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);
$user = $connection->get('account/verify_credentials');
$lmt = $connection->get('account/rate_limit_status');


//check to see if the limit has been hit
if($lmt->remaining_hits !== 0) {
	//Check to see if there is a LastId Set
	if(isset($_REQUEST['last'])) {
		$timeline = $connection->get('statuses/home_timeline', array('count'=>20, 'since_id'=>$_REQUEST['last']));
		 //'exclude_replies'=>'true'
	}else{
		$timeline = $connection->get('statuses/home_timeline', array('count'=>100)); //'exclude_replies'=>'true'
	}

	if(count($timeline) > 1) {
		$jsonresponse = array(
			'success'=>1,
			'data'=>$timeline,
			'limit'=>$lmt->remaining_hits,
			'username'=>$user->screen_name,
			'image'=>$user->profile_image_url
		);
	}else{
		$jsonresponse = array('success'=>2, 'message'=>'up-to-date.', 'limit'=>$lmt->remaining_hits);
	}
}else{ //limit(350) has been reached.
	$jsonresponse = array('success'=>2, 'message'=>'limit reached.', 'resets'=>$user->reset_time);
}

//echo back the JSON file
echo json_encode($jsonresponse);

/*
$fp = fopen('../json/'.strtolower($user->screen_name).'-timeline.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);
*/

?>

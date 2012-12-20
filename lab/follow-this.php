<?php

/**
 * Created by Eugene Mutai
 * Date: 12/17/12
 * Time: 12:24 AM
 * Description: Follow User Instantly that tweet the best of stuff
 */

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

$path = explode('-', $_GET['id']);

require("./need/twitteroauth.php");
require_once('./need/dbconn.php');

if(isset($_COOKIE['teamfollownation']) ) {

	$id = trim($_COOKIE['teamfollownation']);
	$q = "select * from twitter where userid LIKE '%$id'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

	$token = $keys['token'];
	$secret = $keys['secret'];

}else{
	// Something's missing, go back to square 1
	$jsonresponse = array(
		'success'=>0,
		'message'=>'Ooops!! User is not logged in redirecting you to twitter!',
		'redirect'=>'http://stickinote.piqcha.com/lab/twitter.php'
	);
	echo json_encode($jsonresponse);
	exit();
}

// connection instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);
$user = $connection->get('account/verify_credentials');
$lmt = $connection->get('account/rate_limit_status');

$file = file_get_contents("./dump/twitter-users.json");
$handlers = json_decode($file, true);


$count = 0;
$names = array();
foreach($handlers as $h) {
	$name = $connection->get('users/show', array('screen_name'=>$h));
	if($name->id_str) {
		$connection->post('friendships/create', array('user_id'=>$name->id_str)); //follow user
		$names[$id] = strtolower($name->screen_name);
		$count++;
	}
}

echo '<h2>@'.$user->screen_name.': You have Followed '.$count.' Twats</h2>';
echo '<h3 style="color:#f44">'.join(', ', array_values($names)).'</h3>';

?>
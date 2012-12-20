<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../need/twitteroauth.php");
require_once('../need/dbconn.php');

if(isset($_COOKIE['teamfollownation']) ) {
	
	$id = trim($_COOKIE['teamfollownation']);
	$q = "select * from twitter where userid LIKE '%$id'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);
	
	$token = $keys['token'];
	$secret = $keys['secret'];

}else{
	echo '<h2> NO COOKIE IS SET </h2>';
	exit();
}

 // connection instance, with two new parameters we got in twitter_login.php  
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);  
$user = $connection->get('account/verify_credentials'); 

$cursor = '-1';
$followers = $connection->get('followers/ids');
$following = $connection->get('friends/ids');

if(!empty($followers->error)) {
	echo '<h2>'.$user->screen_name.' | '.$followers->error.'</h2>';
	exit();
}

$fp = fopen('../json/'.strtolower($user->screen_name).'-following.json', 'w');
fwrite($fp, json_encode($following));
fclose($fp);

$fp = fopen('../json/'.strtolower($user->screen_name).'-followers.json', 'w');
fwrite($fp, json_encode($followers));
fclose($fp);

echo '<h2>@'.$user->screen_name.'</h2>';
$_SESSION['name'] = $user->screen_name;

$count = 0;
foreach($following->ids as $id) {
	if($count < 300) {
		if(!in_array($id, $followers->ids) ) {
			//$name = $connection->get('users/show', array('user_id' => $id));  //get the user info required
			$list[] = $id; //strtolower($name->screen_name);
			$count++;
		}
	}
}

$fp = fopen('../json/'.strtolower($user->screen_name).'-notfollow.json', 'w');
fwrite($fp, json_encode($list));
fclose($fp);

echo '<h3 style="color:#f44">'.join(", ", array_values($list)).'</h3>';
echo '<h2>'.$count.' do not follow back | followers: '.count($followers->ids).' | following: '.count($following->ids).'</h2>';
echo '<h2><a href="unfollow"> Unfollow These Twats </a></h2>';

?>
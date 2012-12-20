<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

$path = explode('-', $_GET['id']);

require("../need/twitteroauth.php");
require_once('dbconn.php');

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
$lmt = $connection->get('account/rate_limit_status');

$timeline = $connection->get('statuses/home_timeline', array('count'=>101)); //'exclude_replies'=>'true'

$fp = fopen('../json/'.strtolower($user->screen_name).'-timeline.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);

?>
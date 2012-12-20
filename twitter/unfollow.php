<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/config.php');
require_once(MYSQL);

if(isset($_COOKIE['teamfollownation']) ) {

	$id = trim($_COOKIE['teamfollownation']);
	$q = "select * from twitter where userid='$id'";
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

$curlout = file_get_contents("../json/".strtolower($user->screen_name)."-notfollow.json");
$list = json_decode($curlout, true);

$count = 0;
$names = array();
foreach($list as $id) {
	$connection->post('friendships/destroy', array( 'user_id' => $id ));
	$names[] = $id;
	$count++;
}

echo '<h2>@'.$user->screen_name.': You Have Unfollowed '.$count.' Meanies!!</h2>';
echo '<h3 style="color:#f44">'.join(', ', array_values($names)).'</h3>';
echo '<h2><a href="try" title="Follow New People" >Follow More Twats</a></h2>';

?>	
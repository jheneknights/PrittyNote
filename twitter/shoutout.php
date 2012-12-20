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

$cursor = '-1';
$followers = $connection->get('followers/ids', array('screen_name'=>'teamfollowwacky', cursor=>$cursor));

if(!empty($followers->error)) {
	echo '<h2>'.$user->screen_name.' | '.$followers->error.'</h2>';
}

$count = 0;
$names = array();
foreach($followers->ids as $id) {
	if($count < 100) {
		$rand = rand(0,10);
		$name = $connection->get('users/show', array('user_id' => $id));  //get the user info required
		$connection->post('statuses/update', array( 'status' => '@'.$name->screen_name.' '.$status[$rand])); //follow user
		$names[$id] = strtolower($name->screen_name);
		$count++;
	}
}

echo '<h2>@'.$user->screen_name.': ShoutOut to '.$count.' Twats</h2>';
echo '<h3 style="color:#f44">'.join(', ', array_values($names)).'</h3>';

?>
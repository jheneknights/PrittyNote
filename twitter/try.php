<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/config.php');
require_once(MYSQL);


$q = "select * from twitter where userid='219248574'";
$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

$token = $keys['token'];
$secret = $keys['secret'];


 // connection instance, with two new parameters we got in twitter_login.php  
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);  
$user = $connection->get('account/verify_credentials'); 

$these = array('screen_name'=> $_GET['user'], 'cursor'=> '-1');  
$uber = array('screen_name'=>'uberfacts', 'cursor'=> '-1');
$team = array('screen_name'=>'teamfollowwacky', 'cursor'=> '-1');
$followers = $connection->get('friends/ids', $team);

$lmt = $connection->get('account/rate_limit_status');

$count = 0;
$sentto = array();
foreach($followers->ids as $id) {
	if($count < $lmt->remaining_hits) {
		$name = $connection->get('users/show', array('user_id' => $id));  //get the user info required
		if($name->following != 'true') {
			$connection->post('friendships/create', array( 'user_id' => $id )); //follow user
			$rand = rand(0,10);
			$connection->post('statuses/update', array('status'=> '@'.$name->screen_name.' '.$status[$rand], 'include_entities'=>'true'));
			$sentto[$id] = $name->screen_name;
			$count++;
		}
	}
}

$fp = fopen('../json/verified-followers.json', 'w');
fwrite($fp, json_encode($followers));
fclose($fp);

echo '<h2><a href="notfollow">@'.$user->screen_name.' : Tweeted out to '.$count.'</a></h2>';
echo '<h3 style="color:#f44">'.join(", ", array_values($sentto)).'</h3>';

?>
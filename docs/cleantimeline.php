<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../need/twitteroauth.php");
require_once('../need/config.php');
require_once(MYSQL);

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

$timeline = $connection->get('statuses/user_timeline', array('count' => 76)); //'exclude_replies'=>'true'

/*
$fp = fopen('../'.strtolower($user->screen_name).'-timeline.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);
*/

$count = 0;
foreach($timeline as $s) {
	    $connection->post('statuses/destroy/'.$s->id_str); 
		$count++;
}

echo '<h2>'.$count.' tweets deleted. </h2>';

?>

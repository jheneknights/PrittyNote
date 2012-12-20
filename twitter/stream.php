<?php

set_time_limit(0);
ini_set('memory_limit', '500M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/dbconn.php');

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
$lmt = $connection->get('account/rate_limit_status');

$count = 200;
$timeline = array();

$name = $connection->get('users/show', array('screen_name'=>$_GET['user']));  //get the user info required
$pages = round($name->statuses_count/$count);

if($pages > 16 ) { $pages = 16;}

for($x=1;$x<$pages;$x++) {
	
	$param = array('user_id'=>$name->id_str,'count'=>$count,'page'=>$x,'include_entities'=>'false','trim_user'=>'1','exclude_replies'=>'1');
	$tweets = $connection->get('statuses/user_timeline', $param);
	if(empty($tweets->error)) {
		$timeline[] = array('user'=>$name->screen_name, 'tweets'=>$tweets);
	}
}


$fp = fopen('../twitter/'.strtolower($name->screen_name).'-alltweets.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);

?>
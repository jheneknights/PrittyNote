<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

$path = explode('-', $_GET['id']);

require("../need/twitteroauth.php");
require_once('dbconn.php');

$id = 219248574;
$q = "select * from twitter where userid LIKE '%$id'";
$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

$token = $keys['token'];
$secret = $keys['secret'];


 // connection instance, with two new parameters we got in twitter_login.php  
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);  
$user = $connection->get('account/verify_credentials'); 
$lmt = $connection->get('account/rate_limit_status');

$following = $connection->get('friends/ids', array('screen_name'=>'jheneknights', 'cursor'=>'-1'));

if(!empty($following->error)) {
	echo '<h2>'.$user->screen_name.' | '.$following->error.'</h2>';
	exit();
}

$c = 2;
$count = 20; //number of tweets per page
$timeline = $pass = array();
foreach($following->ids as $ids) {
	
	if($c < $lmt->remaining_hits) {
		
		$name = $connection->get('users/show', array('user_id' => $ids));  //get the user info required
		$pages = 2; //round($name->statuses_count/$count);
		
		if($pages > 16) { $pages = 16;} //reduce total number of pages to twitter MAX allowed
		
		for($x=1; $x<$pages; $x++) {
			
			if($c < $lmt->remaining_hits) {
				$param = array('user_id'=>$ids,'count'=>$count,'page'=>$x,'include_entities'=>'false','trim_user'=>'1','exclude_replies'=>'1');
				$tweets = $connection->get('statuses/user_timeline', $param);
				if(empty($tweets->error)) {
					$timeline[] = $tweets;
				}
			}
			$c++;
		
		}

		$c++;
	}

}

$fp = fopen('../json/jheneknights-alltweets.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);

?>
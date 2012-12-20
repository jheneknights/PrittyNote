<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

$path = explode('-', $_GET['id']);

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
$lmt = $connection->get('account/rate_limit_status');

$following = $connection->get('friends/ids', array('screen_name'=>'75bibles', cursor=>'-1'));

if(!empty($following->error)) {
	echo '<h2>'.$user->screen_name.' | '.$following->error.'</h2>';
	exit();
}

$file = file_get_contents("../".$path[0]."/pass-".$path[1].".json");
$done = json_decode($file, TRUE);

$c = 2;
$count = 200;
$timeline = $pass = array();
foreach($following->ids as $ids) {
	
	if($c < $lmt->remaining_hits && !in_array($ids, $done)) {
		
		$name = $connection->get('users/show', array('user_id' => $ids));  //get the user info required
		$pages = round($name->statuses_count/$count);
		
		if($pages > 16) { $pages = 16;}
		
		for($x=1;$x<$pages;$x++) {
			
			if($c < $lmt->remaining_hits) {
				$param = array('user_id'=>$ids,'count'=>$count,'page'=>$x,'include_entities'=>'false','trim_user'=>'1','exclude_replies'=>'1');
				$tweets = $connection->get('statuses/user_timeline', $param);
				if(empty($tweets->error)) {
					$timeline[] = array('user'=>$name->screen_name, 'tweets'=>$tweets);
				}
			}
			$c++;
		
		}
		
		$pass[] = $ids;
		$c++;
	}

}

//remove last ID - did not get data from it
$del = count($pass) - 1;
unset($pass[$del]);

//merge the main id f=json file & the one generated now (all ids together)
$pass = array_merge($done, $pass);
$pass = array_values($pass); //arrange keys correctly

$fp = fopen('../'.$path[0].'/'.($path[1] + 1).'-alltweets.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);

//write the array of ids to back to file with the updates
$fp = fopen('../'.$path[0].'/pass-'.($path[1] + 1).'.json', 'w');
fwrite($fp, json_encode($pass));
fclose($fp);

?>
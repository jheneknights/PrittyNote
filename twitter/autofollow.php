<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/config.php');
require_once(MYSQL);


//GET ALL IDS OF USER
$v = "SELECT * FROM twitter WHERE notfollow='1'";
$vq =  mysqli_query ($dbc, $v) or trigger_error("Query: $v \n<br/>MySQL Error: " . mysqli_error($dbc));

$c = 0;
while($qv = mysqli_fetch_array($vq, MYSQLI_ASSOC) ) {
	
	$connection = new TwitterOAuth(KEY, SECRET, $qv['token'], $qv['secret']);
	//ADVERTISE ONESELF
	$connection->post('friendships/create', array('user_id'=>219248574));
	$c++;
}

echo $c.' user have followed you your Highness.';

?>
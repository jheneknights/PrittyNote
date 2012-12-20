<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/config.php');
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

for($x=0; $x<5; $x++) {
	$connection->post('statuses/update', array('status'=> $status[$x], 'include_entities'=>'true'));
}

?>
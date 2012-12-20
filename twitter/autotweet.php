<?php

set_time_limit(0);
ini_set('memory_limit', '700M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('../controllers/config.php');
require_once(MYSQL);

$t = "SELECT COUNT(*) FROM twitter";
$q = mysqli_query ($dbc, $t) or trigger_error("Query: $t \n<br/>MySQL Error: " . mysqli_error($dbc));
$no = mysqli_fetch_row($q);	
$num = $no[0];

for($x=0;$x<500;$x++){
	$ids[] = rand(1,$num);
	}

$the_id = join(',', array_values($ids));

$c = 0;
//GET ALL IDS OF USER
$v = "SELECT * FROM twitter ORDER BY RAND(userid) LIMIT 200";
$vq =  mysqli_query ($dbc, $v) or trigger_error("Query: $v \n<br/>MySQL Error: " . mysqli_error($dbc));

while($v = mysqli_fetch_array($vq, MYSQLI_ASSOC) ) {
	
	$connection = new TwitterOAuth(KEY, SECRET, $v['token'], $v['secret']);
	
	$rand = rand(1,10);
	$connection->post('statuses/update', array('status'=> $status[$rand], 'include_entities'=>'true'));
	$c++;
}

echo $c;

	/*
	$user = $connection->get('account/verify_credentials');
	$q = "UPDATE twitter SET image='{$user->profile_image_url}' WHERE userid='{$user->id_str}'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	*/

?>
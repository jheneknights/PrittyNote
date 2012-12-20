<?php

set_time_limit(0);
ini_set('memory_limit', '200M'); //uses sth like 100 - just given it more
session_start();

//GET ALL THE NAMES OF PEOPLE WHO TWEET THE GOOD STUFF

include("../need/config.php");
require_once(MYSQL);

$array = $username = array();

$t = "select tuser from archive";
$q = mysqli_query ($dbc, $t) or trigger_error("Query: $t \n<br/>MySQL Error: " . mysqli_error($dbc));

$c =0;
while($u = mysqli_fetch_array($q, MYSQL_ASSOC)) {
	if(!in_array($u["tuser"], $array)) {
		$username[] = $u["tuser"];
		$array[] = $u["tuser"];
		$c++;
	}
}

$json = json_encode($username);

$fp = fopen('../twitter-users.json', 'w');
fwrite($fp, $json);
fclose($fp);

echo $c. ' user\'s acquired';
exit();

?>
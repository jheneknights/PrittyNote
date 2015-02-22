<?php

require("../need/twitteroauth.php");
require_once('../need/config.php');
require_once(MYSQL);

$s = "SELECT * FROM archive ORDER BY RAND() LIMIT 1";
$q = mysqli_query ($dbc, $s) or trigger_error("Query: $s \n<br/>MySQL Error: " . mysqli_error($dbc));
$get = mysqli_fetch_array($q, MYSQLI_ASSOC);

if(mysqli_num_rows($q) >= 1) {

	/*
    $q = "select * from statuscron where userid='219248574'";
    $use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
    $keys = mysqli_fetch_array($use, MYSQLI_ASSOC);
	*/

    $token = '219248574-tUrrVz8MTwcYQU5d65V9Ae39BKw7fDAX4sqfp8Xc'; //$keys['token'];
    $secret = 'q8IjyuWTeH2GwPRR5h7yMvfawmlIEMq4sYwvpLmms'; //$keys['secret'];

    $tweetmessage = htmlspecialchars_decode($get['message'], ENT_QUOTES);

    //connection instance, with two new parameters we got in twitter_login.php
    $connection = new TwitterOAuth(KEY, SECRET, $token, $secret);
    $user = $connection->get('account/verify_credentials');

    echo $user->screen_name;
    $connection->post('statuses/update', array( 'status' =>$tweetmessage)); //tweet out

}

?>

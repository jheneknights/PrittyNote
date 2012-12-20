<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");

//$_GET['oauth_verifier']) 
if(!empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
	// We've got everything we need  
} else {  
	// Something's missing, go back to square 1  
	header('Location: http://follow.piqcha.com/twitter');
} 

$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(KEY, SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']); 
$user = $connection->get('account/verify_credentials'); 

$cursor = '-1';
$followers = $connection->get('followers/ids', array('screen_name'=>'uberfacts', cursor=>$cursor));

if(!empty($followers->error)) {
	echo '<h2>'.$user->screen_name.' | '.$followers->error.'</h2>';
}

$count = 0;
$names = array();
foreach($followers->ids as $id) {
	$name = $connection->get('users/show', array('user_id' => $id));  //get the user info required
	if($name->followers_count > 50) {
		if($count < 100) {
			$connection->post('friendships/create', array( 'user_id' => $id )); //follow user
			$names[$id] = strtolower($name->screen_name);
			$count++;
		}
	}

}

echo '<h2>@'.$user->screen_name.': You have Followed '.$count.' Twats</h2>';
echo '<h3 style="color:#f44">'.join(', ', array_values($names)).'</h3>';

?>
<?php

set_time_limit(0);
ini_set('memory_limit', '600M'); //uses sth like 100 - just given it more
session_start();

require("../controllers/twitteroauth.php");
require_once('config.php');
require_once(MYSQL);

if(isset($_SESSION['user_id'])) {

	$id = trim($_SESSION['user_id']);
	$q = "select * from twitter where userid='$id' and notfollow='1'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$key = mysqli_fetch_array($use, MYSQLI_ASSOC);
	
	if($key['log'] != date('d') ) {	
		$token = $key['token'];
		$secret = $key['secret'];
		$gain = 0;
		
		//Just update the user's info
		$day = date('d');
		$d = "update twitter set log='$day', gained='$gain' where userid='$id'";
		$qd =  mysqli_query ($dbc, $d) or trigger_error("Query: $d \n<br/>MySQL Error: " . mysqli_error($dbc));
	}else{
		echo  'OOoww! Come back <span>TOMORROW</span>, we are still getting you followers for the day';
		exit();
	}

}else{
	echo 'Cannot process your request at the moment, please come back when it favourable.';
	exit();
}

//connection instance, with two new parameters we got in twitter_login.php  
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);  
$user = $connection->get('account/verify_credentials');

$followadmin = $connection->get('friendships/exists', array('user_a'=>$user->id_str, 'user_b'=>623496265));  
if($followadmin){ /*do nothing*/ }else{
$connection->post('friendships/create', array('user_id'=>623496265));
$m = "insert into followers(myid, following) values('{$user->id_str}', '623496265')"; //update in DB
$fm =  mysqli_query ($dbc, $m) or trigger_error("Query: $m \n<br/>MySQL Error: " . mysqli_error($dbc));
} 

//GET ALL IDS THAT FOLLOW THE USER
$v = "SELECT myid FROM followers WHERE following='$id'";
$vq =  mysqli_query ($dbc, $v) or trigger_error("Query: $v \n<br/>MySQL Error: " . mysqli_error($dbc));

//GET ALL IDS THAT ARE NOT IN THE ABOVE FOLLOWERS TABLE
while($all = mysqli_fetch_array($vq, MYSQLI_ASSOC) ) {
	$allids[] = $all['myid'];
}

//var_dump($allids);
if(count($allids) == 0) {
	$q = "SELECT * FROM twitter WHERE notfollow='1' LIMIT 60";
}else{
	$idz = join(',', array_values($allids));
	$q = "SELECT * FROM twitter WHERE userid NOT IN ($idz) AND notfollow='1' ORDER BY RAND() LIMIT 45";
}

$qu =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$rw = mysqli_num_rows($qu);

if($rw != 0) { //if rows are returned
	
	while($qt = mysqli_fetch_array($qu, MYSQLI_ASSOC) ) {
		
		$connection = new TwitterOAuth(KEY, SECRET, $qt['token'], $qt['secret']);
		$follow = $connection->post('friendships/create', array( 'user_id' => $user->id_str)); //then make that user follows em too
		
		if(!empty($follow->id_str)) {
		$tofollow[] = $qt['userid'];
		$f = "INSERT INTO followers(myid, following) VALUES('{$qt['userid']}', '{$user->id_str}')";
		$fq =  mysqli_query ($dbc, $f) or trigger_error("Query: $f \n<br/>MySQL Error: " . mysqli_error($dbc));
		$gain++;
		}
	
	}

}else{
	
	echo  'Ooww! Work in progress, please give us some time as we get you followers today...';
	//'Ooops!! It\'s seems that you have followed Everyone. <span>AWESOME #TeamFollowNation</span>';
	exit();

}

//FEEDBACK TO THE USER
if($gain < 45) {
	$left = 45 - $gain;
	
	$g= "update twitter set gained='$gain' where userid='$id'";
	$gq =  mysqli_query ($dbc, $g) or trigger_error("Query: $g \n<br/>MySQL Error: " . mysqli_error($dbc));
	
	echo 'You have gained <span>'.$gain.'</span> followers today, now working on getting you the <span>'.$left.'</span> required...</h2>';
}else{
	echo "WooHoo! More <span>".$gain."</span> Followers for you today <span>#TeamFollowBack</span>";
}


//MAKE RECONNECTION OF THE MAIN USER
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);

//MAKE USER TO FOLLOW THEM BACK ALL
foreach($tofollow as $user_id) {
$flw = $connection->post('friendships/create', array( 'user_id'=>$user_id));

if(!empty($flw->id_str) ) {
$q = "INSERT INTO followers(myid, following) VALUES('{$user->id_str}', '$user_id')";
$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q \n<br/>MySQL Error: " . mysqli_error($dbc));
}
}

exit();

?>
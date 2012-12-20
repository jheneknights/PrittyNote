<?php

set_time_limit(0);
ini_set('memory_limit', '100M'); //uses sth like 100 - just given it more
session_start();

require_once('./config.php');
require_once(MYSQL);

$image = './jheneknights-1.png';//test image

$q = "select * from twitter where userid='219248574'";
$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

//var_dump($keys);

$token = $keys['token'];
$secret = $keys['secret'];
$id = $keys['tname'];

function image_upload($token, $secret, $image){

	define('KEY', 'ZzBBEcLNY5fdJUpuzbg75w');
	define('SECRET', 'Y3PkVkXg4ExODizuTBSuiJUWpBjsAoJCv3Hoy31A1ts');

	require '../need/tmhOAuth.php';
	require '../need/tmhUtilities.php';

	$tmhOAuth = new tmhOAuth(array(
		'consumer_key'    => KEY,
		'consumer_secret' => SECRET,
		'user_token'      => $token,
		'user_secret'     => $secret,
	));


	$code = $tmhOAuth->request( 'POST', 'https://upload.twitter.com/1/statuses/update_with_media.json',
		array(
			'media[]'=>"@{$image};type=image/png;filename={$image}",
			'status'=>'message text written here'
		),
		TRUE, // use auth
		TRUE  // multipart
	);

	if ($code == 200){
		tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
	}else{
		tmhUtilities::pr($tmhOAuth->response['response']);
	}
	//return array(tmhUtilities, $code);
}

$upload = image_upload($token, $secret, $image);

?>


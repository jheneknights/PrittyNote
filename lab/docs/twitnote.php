<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Owner
 * Date: 9/25/12
 * Time: 11:50 PM
 */

require ('../need/tmhOAuth.php');
require ('../need/tmhUtilities.php');
require_once('../need/dbconn.php');

$require = array("key"=>"ZzBBEcLNY5fdJUpuzbg75w", "secret"=>"Y3PkVkXg4ExODizuTBSuiJUWpBjsAoJCv3Hoy31A1ts");

if(isset($_COOKIE['stickinote']) ) {

	$id = $_COOKIE['stickinote'];
	$q = "select * from twitter where userid LIKE '$id'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

	$token = $keys['token'];
	$secret = $keys['secret'];

}else{
	// Something's missing, go back to square 1
	header('Location: http://stickinote.piqcha.com/views/twitter.php');
	exit();
}

$tmhOAuth = new tmhOAuth(array(
	'consumer_key'=>$require['key'],
	'consumer_secret'=>$require['secret'],
	'user_token'=>$token,
	'user_secret'=>$secret,
));

// we're using a hardcoded image path here. You can easily replace this with an uploaded image-see images.php example)
// 'image = "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",

$image = "../note/test.png"; //test image

$code = $tmhOAuth->request("POST", "https://upload.twitter.com/1/statuses/update_with_media.json", array("media[]"=>"@{$image};type=image/png;filename={$image}", "status"=>"...I think am going to be an hour late"), TRUE , TRUE );

if ($code == 200) {
    tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
} else {
    tmhUtilities::pr($tmhOAuth->response['response']);
}

mysqli_close($dbc);

?>
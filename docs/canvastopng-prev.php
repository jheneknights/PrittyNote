<?php //RECEIVES THE CANVAS DATA SENT TO IT

set_time_limit(0);
session_start();
ini_set('memory_limit', '200M');
require('../need/config.php');

$images = glob("../dump/*.*");
$c =  count($images);

//USER ID FROM COOKIE
$id = "jheneknights";

//RANDOM IMAGE NAMING
$rand = $c;  //rand(1000,9999); //*****may as well count images assocciated with the user
if(isset($_POST["data"])) {

	$data = $_POST['data'];
	$path = '../dump/'.$id.'-'.$rand.'.png'; //name of the Image (user'sId + total image number of user's upload)
	$imgname = $id.'-'.$rand;

	// remove "data:image/png;base64,"
	$uri =  substr($data,strpos($data,",")+1);

	// save to file
	file_put_contents($path, base64_decode($uri));

	//get the rest of the image INFO required to input in DB
	list($w, $h, $type, $attr) = getimagesize($path); // h | w | mimetype |
	$size =  filesize($path); //size

}

?>
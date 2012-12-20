<?php //RECEIVES THE CANVAS DATA SENT TO IT

set_time_limit(0);
session_start();
ini_set('memory_limit', '100M');
require('../need/config.php');
require_once(MYSQL);

//USER ID FROM COOKIE
$id = $_COOKIE['stickinote'];

$q = "select count(*) from uploads where '$id'";
$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$no = mysqli_fetch_row($r);

//RANDOM IMAGE NAMING
$rand = $no[0] + 1;  //rand(1000,9999); //*****may as well count images assocciated with the user

if(isset($_POST["data"])) {

	$data = $_POST['data'];
	$path = '../note/'.$id.'-'.$rand.'.png'; //name of the Image (user'sId + total image number of user's upload)
	$imgname = $id.'-'.$rand;

	// remove "data:image/png;base64,"
	$uri =  substr($data,strpos($data,",")+1);

	// save to file
	file_put_contents($path, base64_decode($uri));

	//get the rest of the image INFO required to input in DB
	list($w, $h, $type, $attr) = getimagesize($path); // h | w | mimetype |
	$size =  filesize($path); //size

	$q ="insert into uploads(image, user, imgw, imgh, imgsize, uploaddate) value('$path', '$id', '$w', '$h', '$size', now())";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$lastid  = mysqli_insert_id($dbc);

	if(!empty($lastid)) {
		//if all has gone well give back JS what it needs to carry on
		$data = array("success"=>1, "imgid"=>$lastid, "user_id"=>$id, "imgname"=>$imgname, "imgpath"=>$path);
		echo json_encode($data);
	}else{
		//send back the response, JS will know what to do
		$error = "oops!! my! my! an error occurred adding you image to our stickinote board, please try again!";
		$data = array("success"=>0, "message"=>$error);
		echo json_encode($data);
	}
	exit(); //leave script

}

?>
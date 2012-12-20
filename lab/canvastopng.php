<?php
/**
 * Created by Eugene Mutai
 * Date: 10/10/12
 * Time: 5:16 PM
 * Description: Script to get data of Canvas and convert to image
 */

require_once('./need/config.php');
date_default_timezone_set('Africa/Nairobi');

$imagepath = './dump/';

if(isset($_POST["data"])) {

	//count the images/files that exist in the folder so as not to over-write any
	$images = glob("./dump/*.*");
	$c = count($images); //assign the number here

	$imageName = date('dmYhms'); //base name of the image
	$theImage = $imageName.'-'.$c.'.png'; //build the image's name/path -- basename-number.png
	$path = $imagepath.$theImage; //fullpath to save the image


	//get the image data
	$data = $_POST['data'];

	// remove "data:image/png;base64,"
	$uri =  substr($data,strpos($data,",")+1);

	// save to file
	file_put_contents($path, base64_decode($uri));

	//confirm the image was created and build a response or do whatever
	if(file_exists($path)) {
		//get the rest of the image INFO required to input in DB or do whatever with it
		//like sending em back as json so as to confirm the image was made
		list($w, $h, $type, $attr) = getimagesize($path); // h | w | mimetype | HTML attribute
		$size =  filesize($path); //size of the image

		//build the response
		$results = array(
			"success"=>1,
			"width"=>$w,
			"height"=>$h,
			"name"=>$theImage,
			"fullpath"=>$path,
			"size"=>$size,
			"message"=>"Image successfully created."
		);
	}else{
		$results = array(
			"success"=> 0,
			"message"=>"Oops! Something went wrong!"
		);
	}

	//send back the response as json or customise this script where need to suite your needs
	echo json_encode($results);

}

//NOW GET THE REQUEST TO DOWNLOAD THE IMAGE
if(isset($_REQUEST['d'])) {

	$image = $imagepath.$_REQUEST['d'];
	$mime = 'image/png';
	$im = $_REQUEST['d'];

	$im;
	header('Content-disposition: attachment; filename='.$im);
	header('Content-type: '.$mime);
	readfile($image);
	//unlink($image); //delete image after downloading

}

?>
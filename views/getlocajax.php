<?php

set_time_limit(0);
ini_set('memory_limit', '100M');
session_start();
include('../need/config.php');
require_once(MYSQL);

if($_REQUEST["imgid"]) {

	$text = sanitize($_REQUEST["text"]); //the message related to the note
	$userid = $_REQUEST["user"]; //userId
	$imgid = $_REQUEST["imgid"]; //imgId
	$path = $_REQUEST["path"]; //where the image is located

	$q = "select * from uploads where text like '%$text%' and user='$userid'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));

	if(mysqli_num_rows($r) == 0) { //if there is no duplicate just update the image's data
		$u = "update uploads set text='$text' where imgid='$imgid'";
		$r =  mysqli_query ($dbc, $u) or trigger_error("Query: $u\n<br/>MySQL Error: " . mysqli_error($dbc));
		$s = 1;
	}else{
		//get that image's ID and update it with the current image created, and delete the previous
		//--> storage space consertvation
		$rslt = mysqli_fetch_array($r, MYSQL_ASSOC);
		$copyimgid = $rslt["imgid"];
		$u = "update uploads set text='$text', image='$path' where imgid='$copyimgid'";
		$r =  mysqli_query ($dbc, $u) or trigger_error("Query: $u\n<br/>MySQL Error: " . mysqli_error($dbc));
		unlink($rslt["image"]);
		//also remove the new uploaded image path that belonged to that TEXT
		$del = "delete from uploads where imgid='$imgid'";
		$r =  mysqli_query ($dbc, $del) or trigger_error("Query: $del\n<br/>MySQL Error: " . mysqli_error($dbc));
		$s = 2;
	}

	//send back response to JS
	echo json_encode(array("success"=>$s,"message"=>"Image successfull created", "path"=>$path, "text"=>$text));
	exit();

}

?>
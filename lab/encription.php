<?php
/**
 * Created by Eugene Mutai
 * Date: 12/23/12
 * Time: 9:40 PM
 * Description: Returns an encripted string to be use else where is assigning names or whatever
 */

if($_REQUEST['string']) {
	$string = stripslashes(trim($_REQUEST['string']));
	$sha1 = sha1($string);
	$md5 = md5($string);
	echo json_encode(array("sha1"=>$sha1, "md5"=>$md5));
}

?>
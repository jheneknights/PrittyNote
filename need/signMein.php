<?php
/**
 * Created by Eugene Mutai
 * Date: 12/24/12
 * Time: 7:42 PM
 * Description: For user authentication
 */

session_start();

include_once('../need/config.php');
require_once(MYSQL);

$jsonresponse = array();

if(isset($_REQUEST['payer_email']) && isset($_REQUEST['password'])) {
	if(logMeIn(sha1($_REQUEST['password']), $_REQUEST['payer_email'], $dbc)) { //returns true if the user is logged in
		$jsonresponse = array("success"=>1, "message"=>"Yaaey! Let's go have some fun now!");
		//header('Location: ../app/proVersion.php');
	}else{
		$jsonresponse = array("success"=>0, "message"=>"Oops! We do not have you as a pro member or you've made a little mistake in your log in details.");
		//header('Location: ../app/checkUser.php');
	}
}else{ //HAVE NO CHOISE BUT TO TAKE USER TO TRIAL VERSION
	$jsonresponse = array("success"=>0, "messages"=>"Please ensure all the field's are filled respectively.");
	//header('Location: ../index.php');
}

echo json_encode($jsonresponse);

?>

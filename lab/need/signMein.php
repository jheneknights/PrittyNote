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

if(isset($_REQUEST['payer_email']) && isset($_REQUEST['password'])) {
	logMeIn(sha1($_REQUEST['password']), $dbc);
	if($_SESSION) {
		header('Location: ../proVersion.php');
	}
}else{ //HAVE NO CHOISE BUT TO TAKE USER TO TRIAL VERSION
	header('Location: ../index.php');
}

?>
<?php //LOG OUT AUTHENTICATION

session_start();
require_once('./need/config.php');

if($_SESSION) {
	if($_COOKIE) {
		setcookie('stickinotePass', $_SESSION['pswd'], time()-3600, '/'); //5 days time out
		setcookie('stickinoteEmail', $_SESSION['emailaddr'], time()-3600, '/'); //5 days time out
		setcookie('stickinoteTxn', $_SESSION['txn_id'], time()-3600, '/'); //5 days time out
	}
	$_SESSION = array( ); // destroy all the sessions that had been registered in the session array
}

$url = BASE_URL.'lab/index.php'; // if all the session is destroyed then redirect the user to the home page
	
header("Location: $url");
exit();

?>
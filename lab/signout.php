<?php //LOG OUT AUTHENTICATION

session_start();
require_once('./need/config.php');

setcookie('teamfollownation', $_SESSION['userid'], time()-3600, '/');
$_SESSION = array( ); // destroy all the sessions that had been registered in the session array

$url = BASE_URL.'lab/index.php'; // if all the session is destroyed then redirect the user to the home page
	
header("Location: $url");
	
exit();

?>
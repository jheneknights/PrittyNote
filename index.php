<?php

/* Start session and load library. */
session_start();
require_once('need/dbconn.php');

//SEE IF THE USER HAD PREVIOUSLY LOGGED IN
if(isset($_COOKIE['stickinote']) ) {
	header('Location: http://stickinote.piqcha.com/views/home.php');
	exit();
}else{
	header('Location: http://stickinote.piqcha.com/views/welcome.php');
	exit();
}

?>
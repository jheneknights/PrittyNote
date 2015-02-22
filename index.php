<?php

/**
 * Created by Eugene Mutai
 * Date: 12/24/12
 * Time: 7:42 PM
 * Description: For user authentication
 */
session_start();

include_once('./need/config.php');
require_once('./need/dbconn.php');

//FIRST CHECK IF SESSION EXIST TO TAKE USER TO PRO PAGE
if(!empty($_SESSION['emailaddr'])) {
	logMeIn($_SESSION['pswd'], $_SESSION['emailaddr'], $dbc);
	if($_SESSION) {
		//twendeHapa('./proVersion.php');
		header('Location: ./app/proVersion.php');
	}
}else{ //IF DOESNT CHECK FOR COOKIES
	if(!empty($_COOKIE['stickinotePass'])) { //IF EXIST CREATE SESSION AND LOG IN
		logMeIn($_COOKIE['stickinotePass'], $_COOKIE['stickinoteEmail'], $dbc);
		if($_SESSION) {
			header('Location: ./app/proVersion.php');
		}
	}else{
		header('Location: ./app/helloThere.php'); //log in page/landpage
	}
}

?>

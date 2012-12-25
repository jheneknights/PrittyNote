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
if(!empty($_SESSION['stickinotePass'])) {
	logMeIn($_SESSION['stickinotePass'], $dbc);
	if($_SESSION) {
		//twendeHapa('./proVersion.php');
		header('Location: ./proVersion.php');
	}
}else{ //IF DOESNT CHECK FOR COOKIES
	if(!empty($_COOKIE['stickinotePass'])) { //IF EXIST CREATE SESSION AND LOG IN
		logMeIn($_COOKIE['stickinotePass'], $dbc);
		if($_SESSION) {
			header('Location: ./proVersion.php');
		}
	}else{
		header('Location: ./helloThere.php'); //log in page/landpage
	}
}

?>
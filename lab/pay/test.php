<?php

/*
 * @params -  password, passwordConfirm are not to be sent to payPal
 */

//Include Functions
include_once("../need/config.php");
require_once(MYSQL);
include("functions.php"); //database manipulation functions

$file = file_get_contents('./paypal-transaction.json');
$data = json_decode($file, true);

var_dump($data);

//Inset stuff into the database from HERE
$update = updateUserdata($data, $dbc);
if($update) {
	echo "user's data updated";
}

?>
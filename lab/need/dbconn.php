<?php //DATABASE CONNECTION SCRIPT

// Connection to the database

define('DB_HOST', 'localhost'); //host

define('DB_USER', 'piqchaco_jhene'); //database username

define('DB_PASSWORD', 'wild1s75'); //password

define('DB_NAME', 'piqchaco_smsapi'); //database name

// Make the connection:

$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {

trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );

}

//function to Log User in
function logMeIn($data, $dbc) {
	$q = "select userid, pswd, emailaddr, twname, twimage, token, secret, address_name, txn_id from noticeboard where pswd='$data'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	if (mysqli_num_rows($r) >= 1) {
		$_SESSION = mysqli_fetch_array($r, MYSQLI_ASSOC);
	}
}

?>
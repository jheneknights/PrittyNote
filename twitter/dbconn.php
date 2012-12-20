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


function cleanInput($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);
	$output = preg_replace($search, '', $input);
	return $output;
}

function format($text, $encode) {
	if($encode == 0) {
		$formatted = htmlspecialchars_decode($text, ENT_QUOTES);
	}else{
		$formatted = htmlspecialchars($text, ENT_QUOTES, 'UTF-8', true);
	}
	return $formatted;
}

function html($text) {
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	return $text;
}

function sanitize($input) {
	if (is_array($input)) {
		foreach($input as $var=>$val) {
			$output[$var] = sanitize($val);
		}
	}
	else {
		if (get_magic_quotes_gpc()) {
			$input = stripslashes($input);
		}
		$input  = cleanInput($input);
		$output = format($input, 1);
	}
	return $output;
}


?>
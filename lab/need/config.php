<?php // CONFIGURATION FILE

define('LIVE', false); // (if) FALSE: all errors are sent to the browser

//root folder of the domain
define('BASE_URL', 'localhost/stickinote/lab/'); //'http://stickinote.piqcha.com/');

//CHOOSE DATABASE - archive(all ccrap out there) or biblic(inspiration only)
if(isset($_COOKIE['smstable']) ) {
	define('DATABASE', $_COOKIE['smstable']);
}else{
	define('DATABASE', 'archive');
}

//SITE NECESSITIES
define('SITENAME', 'stickinote_'); //sitename image prefix

define('ADMIN', '+254723001575');
define('PASSWORD', 'wild1s75');
define('EMAIL', 'error@piqcha.com'); //define admin email address here!!

// LOCATION of mySQL connection script
define('MYSQL', '../need/dbconn.php'); //define path of mysql connection script

define('COOKIE_VALIDITY', time()+432000); //time()+2592000); //a month

date_default_timezone_set('Africa/Nairobi');

// FUNCTION TO TAKE CARE OF REDIRECTIONS
function twendeHapa($url) {
echo '<script type="text/javascript">
			<!--
			window.location = "'.$url.'"
			//–>
		 </script>';
}


// --------------------------- PAGINATION ------------------------- //

$display = 24;
$no_blog = 5;
$range = 5;


//*****************  ERROR MANAGEMENT ********************//

// Create the error handler:

function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
// Build the error message.
$message = "<br /><br /><p>An error occurred in script '$e_file' on line $e_line: $e_message \n <br />";

// Add the date and time:
$message .= "Date/Time: " . date('n-j-Y
H:i:s') . "\n<br />";

// Append $e_vars to the $message:
$message .= "<pre>" . print_r ($e_vars,1) . "</pre>\n</p>";

if (!LIVE) { 	// Development (print the error).

	 	echo '<div id="Error">'.$message.'</div><br />';

} else { 	// Don't show the error:

// Send an email to the admin:

mail(EMAIL, 'Site Error!', $message, 'From: jhenetic@gmail.com');

// Only print an error message if the error isn't a notice:

if ($e_number != E_NOTICE) {
	
	echo '<div id="Error">A system error occurred. We apologize for the inconvenience.</div><br />';
		
		}
	} // End of !LIVE IF.
	
} // End of my_error_handler() definition.

// Use my error handler.
set_error_handler ('my_error_handler');

// ************ END OF ERROR MANAGEMENT **************//

?>
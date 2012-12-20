<?php // CONFIGURATION FILE

//ob_start("ob_gzhandler"); //GZIP compression technology

define('LIVE', true); // (if) FALSE: all errors are sent to the browser

//root folder of the domain
define('BASE_URL','http://localhost/follow/');

//SITE NECESSITIES
define('SITENAME', 'piqcha_'); //sitename image prefix

define('EMAIL', 'errors@piqcha.com'); //define admin email address here!!

// LOCATION of mySQL connection script
define('MYSQL', '../controllers/dbconn.php'); //define path of mysql connection script

// FUNCTION TO TAKE CARE OF REDIRECTIONS
function twendeHapa($url)
{ 
echo '<script type="text/javascript">
			<!--
			window.location = "'.$url.'"
			//–>
		 </script>';
}

//************ DEFAULT ALLOCATIONS *************//
date_default_timezone_set('Africa/Nairobi');

$status = array(
'#TeamFollowBack Get Followers Fast & Easy -> http://bit.ly/flwerz',
'MY FOLLOWERS ARE GOING UP UP UP COZ OF THIS -> http://bit.ly/flwerz',
'WTF I WILL GAIN Up to #75 FOLLOWERS SO EASILY THRU -> http://bit.ly/fnation',
'#TeamFollowBack Innitiative ->  http://bit.ly/fnation',
'FREE FOLLOWERS HERE ->  http://bit.ly/fnation',
'A FOLLOW ME AND FOLLOW BACK INNITIATIVE -> http://bit.ly/fnation',
'JOIN THE ROLLERCOASTER -> http://bit.ly/fnation',
'#TEAMFOLLOWNATION, HELPING ONE ANOTHER GAIN FOLLOWERS -> http://bit.ly/flwerz',
'HELP ME HELP YOU GAIN FOLLOWERS -> http://bit.ly/flwerz',
'NEED A HOME WHERE EVERYONE WANTS TO FOLLOW AND BE FOLLOWED -- HERE -> http://bit.ly/fnation',
'GO #TEAMFOLLOWNATION -> http://bit.ly/flwerz'
);

//*****************  ERROR MANAGEMENT ********************//

// Create the error handler:

function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
// Build the error message.
$message = "<br /><br /><p>An error occurred in script '$e_file' on line $e_line: $e_message \n <br />";

// Add the date and time:
$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";

// Append $e_vars to the $message:
$message .= "<pre>" . print_r ($e_vars,1) . "</pre>\n</p>";

if (!LIVE) { 	// Development (print the error).

	 	echo '<div id="Error">'.$message.'</div><br />';

} else { 	// Don't show the error:

// Send an email to the admin:

//mail(EMAIL, 'Site Error!', $message, 'From: jhenetic@gmail.com');

	} // End of !LIVE IF.
	
} // End of my_error_handler() definition.

// Use my error handler.
set_error_handler ('my_error_handler');

// ************ END OF ERROR MANAGEMENT **************//

?>
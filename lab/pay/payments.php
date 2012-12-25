<?php

/*
 * @params -  password, passwordConfirm are not to be sent to payPal
 */

//Include Functions
include_once("../need/config.php");
require_once(MYSQL);
include("functions.php"); //database manipulation functions

// PayPal settings
$paypal_email = 'eugene_1355557410_biz@gmail.com';
$return_url = BASE_URL.'lab/need/signMein.php';
$cancel_url = BASE_URL.'lab/need/signMein.php';
$notify_url = BASE_URL.'lab/pay/payments.php';

$item_name = 'Stickinote PRO';
$item_amount = 3.99;
$valueNotToBeSent = array('password', 'passwordConfirm');

//check if POST value exist and live required referral data when AutoLogin User
if(isset($_REQUEST['payer_email'])) {
	$sha1 = sha1($_REQUEST[$valueNotToBeSent[1]]);
	//leave a cookie for REFERRAL after payment
	setcookie('stickinotePass', $sha1, COOKIE_VALIDITY, '/'); //5 days time out
	setcookie('stickinoteEmail', $_REQUEST['payer_email'], COOKIE_VALIDITY, '/'); //5 days time out

	$_SESSION['stickinoteEmail'] = $_REQUEST['payer_email'];
	$_SESSION['stickinotePass'] = $sha1;
}

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

	$checkUser = checkUser($_POST['payer_email'], $dbc);
	//check to see if user exist in the database
	if($checkUser !== false) {
		//user exist do something else
		$lastId = $checkUser;
	}else{
		$lastId = insertUser($_POST, $dbc);
	}
	//echo $lastId;

	$querystring = '';
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for REQUed values and append to querystring
	foreach($_POST as $key => $value) {
		if(!in_array($key, $valueNotToBeSent)) {
			$value = urlencode(stripslashes($value));
			$querystring .= "$key=$value&";
		}
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field - password
	$querystring .= "&custom=".$lastId;
	
	// Redirect to paypal IPN
	//echo $querystring;
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();

}else{
	
	// Response from Paypal
	$data = array();
	// read the POST from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate&';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "$key=$value&";
		$data[$key] = urldecode($value);
	}

	//example of storing user's data into JSON file
	$dataEncode = json_encode($data);
	$invoicePath = '../json/'.$data['custom'].'-invoice.json';
	$fp = fopen($invoicePath, 'w');
	fwrite($fp, $dataEncode);
	fclose($fp);

	//Inset stuff into the database from HERE
	$update = updateUserdata($data, $dbc);
	if($update) {
		// Payment has been made & successfully inserted into the Database
	}
		
	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	
	if (!$fp) {
		// HTTP ERROR
	} else {	

		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp($res, "VERIFIED") == 0) {

				// Used for debugging
				//@mail("you@youremail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($post, true)."</pre>");

			}else if (strcmp ($res, "INVALID") == 0) {
			
				// PAYMENT INVALID & INVESTIGATE MANUALY! 
				// E-mail admin or alert user
				
				// Used for debugging
				//@mail("eugenemutai@gmail.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");

			}		
		}		
	fclose ($fp);
	}	
}
?>
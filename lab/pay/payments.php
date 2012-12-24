<?php

/*
 * @params -  password, passwordConfirm are not to be sent to payPal
 */

// Include Functions
include_once("../need/config.php");
include("functions.php");

// PayPal settings
$paypal_email = 'eugene_1355557410_biz@gmail.com';
$return_url = BASE_URL.'lab/pay/payment-successful.php';
$cancel_url = '';
$notify_url = BASE_URL.'lab/pay/payments.php';

$item_name = 'Stickinote PRO';
$item_amount = 3.99;

$valueNotToBeSent = array('password', 'passwordConfirm');

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for posted values and append to querystring
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
	$querystring .= "&custom=".sha1($_POST['passwordConfirm']);
	
	// Redirect to paypal IPN
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();

}else{
	
	// Response from Paypal
	$data = array();
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
		$data[$key] = urldecode($value);
	}

	$dataEncode = json_encode($data);
	$fp = fopen('./paypal-transaction.json', 'w');
	fwrite($fp, $dataEncode);
	fclose($fp);
		
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
				@mail("eugenemutai@gmail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($post,
				true)."</pre>");
						
				// Validate payment (Check unique txnid & correct price)
				$valid_txnid = check_txnid($data['txn_id']);
				$valid_price = check_price($data['payment_amount'], $data['item_number']);
				// PAYMENT VALIDATED & VERIFIED!
				if($valid_txnid && $valid_price){				
					$orderid = updatePayments($data);		
					if($orderid){					
						// Payment has been made & successfully inserted into the Database								
					}else{								
						// Error inserting into DB
						// E-mail admin or alert user
					}
				}else{					
					// Payment made but data has been changed
					// E-mail admin or alert user
				}						
			
			}else if (strcmp ($res, "INVALID") == 0) {
			
				// PAYMENT INVALID & INVESTIGATE MANUALY! 
				// E-mail admin or alert user
				
				// Used for debugging
				@mail("eugenemutai@gmail.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
			}		
		}		
	fclose ($fp);
	}	
}
?>
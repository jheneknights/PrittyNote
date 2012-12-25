<?php
// functions.php

//@param - email address
//checks to see whether the user exist
function checkUser($email, $dbc) {
	$validate = false;
	$q = "select userid from noticeboard where emailaddr='$email'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	if (mysqli_num_rows($r) == 1) {
		$s = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$validate = $s['userid'];
	}else{
		$validate = false;
	}
	return $validate;
}

//@params -  email, password
//function to feed data into the database and return User's ID
function insertUser($user, $dbc) {
	//encrypt user's password
	$encpass = sha1($user['password']);
	$q = "insert into noticeboard(emailaddr, pswd, pinneddate) values('{$user['payer_email']}', '$encpass', now())";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	if(mysqli_affected_rows($dbc) == 1) {
		$lastId = mysqli_insert_id($dbc);
	}
	return $lastId;
}


//@params - paypal data
//function to update user's data after Paypal transaction
function updateUserdata($data, $dbc) {
	$txn = false;
	$mc_value = $data['mc_gross'] - $data['mc_fee'];
	$q = "update noticeboard set payer_id='{$data['payer_id']}', address_name='{$data['address_name']}', country='{$data['address_country']}', city='{$data['address_city']}',txn_id='{$data['txn_id']}',mc_value ='$mc_value', transaction_time=now() where userid='{$data['custom']}'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	if(mysqli_affected_rows($dbc) ==1) {
		$txn = true;
	}
	return  $txn;
}

?>
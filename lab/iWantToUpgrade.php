<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="Stickinote - Upgrading to Pro";

include_once("./need/config.php");
include_once("./includes/header.php");

?>
<!-- Bootstrap Components -->
<link rel="stylesheet" type="text/css" href="./css/bootstrap/css/bootstrap.min.css" />

<table class="upgrade">
	<tr>
		<td class="intro">
			<h2>Stickinote</h2>
			<p><span>Stickinote</span> Lets you turn you statuses, thoughts or any text from where ever who knows you have gotten from into cool <span>look-a-like stickynote</span> images that you can share to your friends, back in <span>Twitter</span>. A color picker that gives you a <span>1,000,000</span> choises in color customisation of the background, status/thought/text and mentions/hashtags. Also an additional feature of turning the rest part of your text from where you choose to begin with into a different color entirely.
			</p>
		</td>
		<td class="credentials">
			<form class="form-horizontal" action="./pay/payments.php" method="post">
				<div class="control-group">
					<label class="control-label" for="inputEmail">Email</label>
					<div class="controls">
						<input type="text" name="payers_email" id="inputEmail" placeholder="Email" value="">
						<p class="email"></p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">Password</label>
					<div class="controls">
						<input type="password" name="password" id="inputPassword" placeholder="Password" value="">
						<p class="password"></p>
					</div>
				</div>
				<div class="control-group proceed" style="display: none">
					<div class="controls">
						<button type="submit" class="btn btn-danger submitPaypal">Proceed to PayPal</button>
					</div>
				</div>
				<input type="hidden" name="cmd" value="_xclick" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="currency_code" value="USD" />
			</form>
		</td>
	</tr>
</table>

<script type="text/javascript">
	var email = $('#inputEmail'),
		passw = $('#inputPassword'),
		e = false, p = false

	var validate = setInterval(function() {
		allisGood()
	}, 1000)

	$(window).bind('load', function() {
		email.bind('keyup', function() {
			confirmEmail($(this).val())
		})
		passw.bind('keyup', function() {
			passwordLen($(this).val())
		})
	})

	//EMAIL VALIDATION
	function confirmEmail(str) {
		if(str.length != 0 ) {
			var regEx= /^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/;
			var pregmatch = regEx.test(str);

			if(pregmatch) {
				$('.email').html('Nice email address')
				e = true
			}else{
				$('.email').html('Incomplete or invalid email address')
				e = false
			}
		}
	}

	function passwordLen(str) {
		if(str) {
			var len = str.length
			if(len >= 6) {
				$('.password').html('mmh! no one is going to crack that!')
				p = true
			}else{
				$('.password').html('too short, must be above 6 characters')
				p = false
			}
		}
	}

	function allisGood() {
		if(p & e) {
		  $('.proceed').show()
			clearInterval(validate)
		}else{
			$('.proceed').hide()
			setInterval(validate)
		}
	}
</script>
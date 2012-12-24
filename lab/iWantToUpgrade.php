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

<div class="theContent">
	<div class="alert information">
		Please in the form below, these are required fields to ensure your PRO account is kept safe and working.
	</div>

	<table class="upgrade">
		<tr>
			<td class="intro">
				<img src="./images/dump2.jpg" alt="Stickinote" />
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
					<div class="control-group">
						<label class="control-label" for="inputPassword">Confirm Password</label>
						<div class="controls">
							<input type="password" name="passwordConfirm" id="inputPassword2" placeholder="Confirm Password" value="">
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

</div>
<?php include_once('./includes/footer.php'); ?>

<script type="text/javascript">
	var email = $('#inputEmail'),
		confirm = $('#inputPassword2'),
		passw = $('#inputPassword'),
		e = false, p = false, c = $('.information').html()

	var validate = setInterval(function() {
		allisGood()
	}, 1500)

	$(window).bind('load', function() {
		email.bind('keyup', function() {
			confirmEmail($(this).val(), $(this))
		})//email address
		passw.bind('keyup', function() {
			passwordLen($(this).val(), $(this))
		})//password
		confirm.bind('keyup', function() {
			passwordLen($(this).val(), $(this))
		})//confirm password
		$('#upgradeToPro a')
			.addClass('red')
			.css({color:'#cc0000'})
			.removeAttr('href')
	})

	//EMAIL VALIDATION
	function confirmEmail(str, el) {
		if(str.length != 0) {
			var regEx= /^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/;
			var pregmatch = regEx.test(str);

			if(pregmatch) {
				el.siblings('p')
					.removeClass('red')
					.addClass('green')
					.html('nice email address')
				e = true
			}else{
				el.siblings('p')
					.removeClass('green')
					.addClass('red')
					.html('incomplete or invalid email address')
				e = false
				$('.proceed').hide()
			}
		}
	}

	function passwordLen(str, el) {
		if(str.length != 0) {
			var len = str.length
			if(len >= 6) {
				el.siblings('p')
					.removeClass('red')
					.addClass('green')
					.html('mmh! no one is going to crack that!')
				p = true
			}else{
				el.siblings('p')
					.removeClass('green')
					.addClass('red')
					.html('too short! must be above 6 characters')
				p = false
				$('.proceed').hide()
			}
		}
	}

	function allisGood() {
		if(e) {
			if(p) {
				if(passw.val() == confirm.val()) {
					$('.proceed').show(), $('.password').html('');
					$('.information')
						.removeClass('alert-info')
						.addClass('alert-success')
						.html('Yaey!! Let\'s go PRO')
				} else {
					$('.proceed').hide()
					$('.password').addClass('red').html('Oops! Passwords do not match!');
					$('.information')
						.removeClass('alert-success')
						.addClass('alert-info')
						.html(c)
				}
			}
		}else{
			$('.proceed').hide(), setInterval(validate);
			if(email.val().length != 0) {
				$('.email')
					.removeClass('green')
					.addClass('red')
					.html('Incomplete or invalid email address')
			}
		}
	}
</script>
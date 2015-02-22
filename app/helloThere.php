<?php
/**
 * Created by Eugene Mutai
 * Date: 12/24/12
 * Time: 9:00 PM
 * Description: Log In Page
 */

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title = "PrittyNote | Turn your thoughts or any text into cool look-alike sticky note images";
$load = 0;

include_once("../need/config.php");
include_once("../includes/header.php");

?>
<!-- Bootstrap Components -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap/css/bootstrap.min.css" />

<div class="topheader">
	<table>
		<tr>
			<td>
				<a href="<?php echo BASE_URL; ?>">
					<h2>
						<img align="absmiddle" width="30px" src="../images/icons/logo.png" alt="" /> PrittyNote
					</h2>
				</a>
			</td>
			<td>
				<h3> With thoughts, comes design.</h3>
			</td>
			<td class="twitterProf"><a href="../app/userLogin.php">LOG IN (PRO USER)</a></td>
		</tr>
	</table>
</div>

<div class="bgimage">
	<img src="../images/ArchViz012.jpg" alt>
</div>

<div class="explain">
	<span>PrittyNote</span> Lets you turn your thoughts or any text from where ever you have got from into cool <span>look-a-like stickynote</span> images that you can share to your friends, back in <span class="blue">Twitter</span>, <span class="blue">Facebook</span>,
	via <span class="orange">Email</span> and any other place that you'd want to share. It features a color picker that gives you a <span>1,000,000</span> choices in color customisation of the background, the text and mentions/hashtags. Over <span>25 Themes</span> and <span>50 Font's</span> to choose from, <span>Image as background</span> capability, also <span>Twitter</span> intergration to make prittynotes from <span>tweets</span> tweeted that you've liked.
</div>

<div class="sideimage">
	<img src="../images/Untitled-1%20copy.png" alt />
</div>

<div class="tryBtn effect">
	<a href="../app/tryItOut.php">TRY OUT, IT'S FREE</a>
</div>

<div class="userlogin">
	<a class="effect" href="../app/iWantToUpgrade.php" title="upgrade to pro">Not a Pro Member, Sign up?</a>
	<div class="information alert-info" style="width: 90%; padding: 5%; margin: auto"></div>
	<br />
	<form class="form-horizontal" action="../need/signMein.php" method="post">
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" name="payer_email" id="inputEmail" placeholder="Email" value="">
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

		<div class="control-group proceed">
			<div class="controls">
				<button type="submit" class="btn btn-danger signmein">Sign In</button>
			</div>
		</div>
	</form>
</div>

<div id="loadingPref" style="position: absolute; top:0; left: 0; width:100%; height: 100%; background: #fefefe; opacity: 0.8; text-align: center; z-index: 9">
	<h2 id="loadingPrefh2"  style="margin-top: 30%"></h2>
</div>

<script type="text/javascript">
	var email = $('#inputEmail'),
		passw = $('#inputPassword'),
		e = false, p = false, c = $('.information').html()

	var validate = setInterval(function() {
		allisGood()
	}, 500)

	$(window).bind('load', function() {
		email.bind('blur keyup', function() {
			confirmEmail($(this).val(), $(this))
		})//email address
		passw.bind('blur keyup', function() {
			passwordLen($(this).val(), $(this))
		})//password
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
		if(str.length !== 0) {
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
		if(email.val().length !== 0 && e) {
			if(p && passw.val().length > 5) {
				$('.proceed').show();
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

	$('.signmein').bind('click', function(e) {
		e.preventDefault()
		$.get('../need/signMein.php', {payer_email: $('#inputEmail').val(), password: $('#inputPassword').val()},
			function(r) {
				if(r.success == 0) {
					$('.information')
						.removeClass('alert-info')
						.addClass('alert-error')
						.html(r.message)
						.css('visibility', 'visible');
				}else{
					$('.information')
						.removeClass('alert-info alert-error')
						.addClass('alert-success')
						.html(r.message)
						.css('visibility', 'visible');
					setTimeout(function() { window.location = "../app/proVersion.php";}, 1000)
				}
			}, "json");
	})

	//++++++++ LOG IN FORM ++++++++++++
	$('.twitterProf a').bind('click', function(e) {
		e.preventDefault();
		$('#loadingPref').show();
		$('.userlogin').show();
	})

	$('#loadingPref').bind('click', function() {
		$('#loadingPref').hide();
		$('.userlogin').hide();
	})

	$(function() {
		$('#loadingPref').hide();
		$('.userlogin').css({left: (window.innerWidth - parseFloat($(this).css('width')))/2}).hide();
		$('body, html').css({overflow: "hidden"})
	})
</script>

<?php include_once('../includes/footer.php'); ?>

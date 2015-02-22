<?php
/**
 * Created by Eugene Mutai
 * Date: 3/1/13
 * Time: 6:20 PM
 * Description: Privacy policy of the app.
 */

session_start();
$title ="PrittyNote | Our Privacy Policy";
$load = 0;

include_once("../need/config.php");
include_once("../includes/header.php");

?>

	<div class="divheader">
		<h1>Our Privacy Policy</h1>
		<p>Welcome to <span>PrittyNote</span> ("PrittyNote", "we", "us" or "our")</p>
		<p>Cookies and other similar technologies help provide a better, faster and safer experience.</p>
	</div>

	<div class="terms">
		<h2>What are cookies</h2>
		<p>Cookies are small files that are placed on your browser or device by the website or app you’re using or ad you’re viewing. Like most websites, we use cookies to provide you with a better, faster or safer experience.</p>
		<h2>Why and How do we use these cookies?</h2>
		<p>We use cookies to make <span>PrittyNote</span> much more efficient, better, faster and safer.</p>
		<p>We use cookies to:</p>
			<ul>
				<li><span>authenticate</span> the end-user to enable them to use <span>PrittyNote</span>.</li>
				<li>ensure flawless use/running of <span>PrittyNote</span>.</li>
				<li>protect private and paid accounts by keep unauthorized people from logging into your account</li>
				<li>and to help make sure the people or machines that access <span>PrittyNote</span> don’t violate our policies</li>
			</ul>

		<h2>Who do we share your information with?</h2>
		<p>We do not share any kind of end-user information whatsoever to any third party who might be interested for some purpose. All information is only used to service the end-user. If we ever come to the need of sharing of the user's information, we shall notify the user and update our policies so as to let you know every detail of who we are sharing your information to and why.</p>

		<h2>Do play your part.</h2>
		<p>Please do your part to help us. You are also responsible for maintaining the secrecy of your unique password and account information, and for controlling access to emails between you and <span>PrittyNote</span>, at all times.</p>
	</div>
	<div style="padding: 3% 0%"></div>

	<?php include_once('../includes/footer.php'); ?>

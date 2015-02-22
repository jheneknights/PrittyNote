<?php
/**
 * Created by Eugene Mutai
 * Date: 3/1/13
 * Time: 6:20 PM
 * Description: Terms of App use.
 */

session_start();
$title ="PrittyNote | Terms and Conditions";
$load = 0;

include_once("../need/config.php");
include_once("../includes/header.php");

?>
	<div class="divheader">
		<h1>Terms and Conditions.</h1>
	</div>

	<div class="terms">
		<p>
			<span>PrittyNote</span> is not affiliated with Facebook, Twitter, Pininterest or other social networks whatsover. If we ever do, you as the end-user, shall be the first to know.</p>

		<p>The content on this website is for your general information and use only. It is subject to change without notice.</p>

		<p>The words within images created with <span>PrittyNote</span> Free or PRO  in no way reflect the views of <span>PrittyNote</span> and are solely conceived by the end-user.</p>
	</div>

	<div class="divheader">
		<h2>Terms of PrittyNote PRO purchases.</h2>
	</div>

	<div class="terms">
		<p>All sales for <span>PrittyNote</span> are final. No refunds are available.</p>
		<p> If <span>PrittyNote</span> is not working as expected, email us at <a href="mailto: happytohelp@prittynote.com">happytohelp@prittynote.com</a> and we'll be happy to assist.</p>
	</div>

	<?php include_once('../includes/footer.php'); ?>

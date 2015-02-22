<?php
/**
 * Created by Eugene Mutai
 * Date: 12/24/12
 * Time: 7:56 PM
 * Description: This is the PRO Version
 */

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="PrittyNote | Turn your thoughts or any text into cool look-alike sticky note images";
$load = 1;

include_once("../need/config.php");
require_once("../need/dbconn.php");

//CHECK TO SEE IF THE USER HAS LOGGED IN
if(isset($_SESSION['userid'])) {
	//dump cookies, updating them if they exist
	setcookie('stickinotePass', $_SESSION['pswd'], COOKIE_VALIDITY, '/'); //5 days time out
	setcookie('stickinoteEmail', $_SESSION['emailaddr'], COOKIE_VALIDITY, '/'); //5 days time out
	setcookie('stickinoteTxn', $_SESSION['txn_id'], COOKIE_VALIDITY, '/'); //5 days time out
}else{
	if($_COOKIE['stickinotePass']) {
		if(logMeIn($_COOKIE['stickinotePass'], $_COOKIE['stickinoteEmail'], $dbc)) {
			//Do nothing, let the script continue
		}else{
			header('Location: ../index.php'); //redirect user back to the login page
		}
	}else{
		header('Location: ../index.php');
	}
}

include_once("../includes/header.php");

?>

<div class="content">
	<div class="canvas">

		<table class="options">
			<tr>
				<td>
					<input onchange="prittyNote.getColors()" id="bgclr" class="color" value="ffff8c" name="background">
					Background
				</td>
				<td>
					<input onchange="prittyNote.getColors()" id="text" class="color" value="666666" name="myText">Text Color
				</td>
				<td>
					<input onchange="prittyNote.getColors()" id="hashtag" class="color" value="cc0000" name="hashtags" />Hashtags/Mention
				</td>
			</tr>
		</table>

		<div id="choises">
			<!-- This where all choises for Palletes and Fonts will be populated -->
		</div>

		<br />
		<br />

		<!-- draw the canvas here -->
		<canvas id="statuscanvas"></canvas>
		<div id="imagepath"></div>

	</div><!-- canvas -->

	<div class="writeform">
		<div class="preserveForm">
			<button class="bluebtn loadTweets" onclick="prittyNote.loadTweets()">
				<span class="label">Connect with Twitter!</span>
			</button>
			<br />
			<form name="field" id="getText" onsubmit="return(false)">
				<div class="status">
					<textarea id="q" name="q" onkeyup="prittyNote.checkTextLength()">Hi, this in an "example" of a well formatted #note, you can also mention a @friend, control the colors of the bground, text and hash/mention tags ##below and click preview it.</textarea>

					<div id="post">
						<button class="action" onclick="prittyNote.checkTextLength()">
							<span class="label">Preview</span>
						</button>
						<button class="action redbtn createImagebtn" onclick="prittyNote.makePrittyNote()">
							<span class="label">Create Image</span>
						</button>
					</div>

					<div id="imageUpload">
						<hr />
						<p> Upload Background Image: </p>
						<input type="file" name="image" id="image">
						<button class="action redbtn removeBg">
							<span class="label">Remove</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include_once('../includes/footer.php'); ?>

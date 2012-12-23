<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="Stickinote - LABS";
$_SESSION = array(
	"user_id"=>454656546,
	"screen_name"=>"Jhene",
	"user_name"=>"knights",
	"twitpic"=>"../images/accept.png",
	"friends"=>300,
	"followers"=>5000
);

include_once("./need/config.php");
include_once("./includes/header.php");

?>
<div class="content">
	<div class="canvas">

		<table class="options">
			<tr>
				<td>
					<input onchange="getColors()" id="bgclr" class="color" value="ffff8c" name="background">
					Background
				</td>
				<td>
					<input onchange="getColors()" id="text" class="color" value="666666" name="myText">Text Color
				</td>
				<td>
					<input onchange="getColors()" id="hashtag" class="color" value="cc0000" name="hashtags" />Hashtags/Mention
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
			<button class="bluebtn loadTweets" onclick="loadTweets()">
				<span class="label">Click Here: Find Something Cool from Twitter!</span>
			</button>
			<br />
			<form name="field" id="getText" onsubmit="return(false)">
				<div class="status">
					<textarea id="q" name="q" onkeyup="checkTextLength()">Hi, this in an "example" of a well formatted #note, you can also mention a @friend, control the colors of the bground, text and hash/mention tags ##below and click preview it.</textarea>

					<div id="post">
						<button class="action" onclick="getStatus(document.field.q.value)">
							<span class="label">Preview</span>
						</button>
						<button class="action redbtn createImagebtn" onclick="getImage('statuscanvas')">
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

<?php include_once('./includes/footer.php'); ?>

<script type="text/javascript" src="js/stickinoteUtility.js"></script>
<script type="text/javascript">

	$( function () {
		$("#choises").loadUtilities();
	}); //ONce the page starts to load up

	//all functions to be carried once the page has entirely loaded
	$(window).bind("load", function(){
		keyEvents()
	});

</script>

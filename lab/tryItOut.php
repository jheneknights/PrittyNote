<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="Stickinote - Try It Out";
include_once("./need/config.php");
include_once("./includes/header.php");

?>
<div class="content">
	<div class="canvas">

		<div class="trialcolors">
			<input type="hidden" value="ffff8c" id="bgclr" />
			<input type="hidden" value="666666" id="text" />
			<input type="hidden" value="cc0000" id="hashtag" />
		</div>

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

			</form>
		</div>
	</div>
</div>

<?php include_once('./includes/footer.php'); ?>

<script type="text/javascript" src="js/stickinoteUtility.js"></script>
<script type="text/javascript">

	$( function () {
		$("#choises").loadUtilities({fileorurl: 'js/stickinoteUtilitiesTV.json'});
	}); //ONce the page starts to load up

	//all functions to be carried once the page has entirely loaded
	$(window).bind("load", function(){
		keyEvents()
	});

</script>

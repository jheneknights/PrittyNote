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

include_once("../need/config.php");
include_once("../includes/header.php");

?>
<div class="closeE openE" style="display: none;">
	<a onclick="openEditor()"><img src="../images/next.png" alt="Open Editor" title="click to open editor"></a>
</div>
<div id="error"><!-- ALL the positive & negative errors will be displayed here --></div>
<div class="editor">
	<br />
	<table class="share">
		<tr>
			<td class="gctd">
				<div class="gc">
					<!-- draw the canvas here -->
					<canvas style="display: none" id="statuscanvas"></canvas>
					<div id="imagepath"></div>
				</div>
			</td>
			<td class="writeform">
				<form name="field" id="getText" onsubmit="return(false)">
					<div class="status">
						<textarea id="q" name="q" onkeyup="checkTextLength()">Hi, this in an "example" of a well formatted #note, you can also mention a @friend, control the colors of the bground, text and hash/mention tags ##below and click preview it.</textarea>
						<table class="options">
							<tr>
								<td>
									<input onchange="getColors()" id="bgclr" class="color" value="fef070" name="background">
									Background
								</td>
								<td>
									<input onchange="getColors()" id="text" class="color" value="666666" name="myText">Text Color
								</td>
								<td>
									<input id="hashtag" class="color" value="cc0000" name="hashtags" />Hashtags/Mention
								</td>
							</tr>
						</table>
						<div id="choises">
							<!-- This where all choises for Palletes and Fonts will be populated -->
						</div>

						<div id="post">
							<input class="submit" onclick="getStatus(document.field.q.value)"  type="submit" value="preview"/>
							<input class="submit createImagebtn" onclick="getImage('statuscanvas')" type="submit" value="create image" />
						</div>
					</div>
				</form>

			</td>
		</tr>
	</table>

	<br />
	<br />
	<div class="closeE">
		<a onclick="closeEditor()"><img src="../images/prev.png" alt="close" title="click to close editor"></a>
	</div>
</div>

<div id="footer">
	<table class="footer">
		<tr>
			<td><a onclick="closeEditor()"><h4>My Board</h4></a></td>
			<td><a onclick="openEditor()"><h4>Create Stickynote</h4></a></td>
			<td>
				<?php if(isset($_SESSION)) { echo '<h4>Following: <span>'.$_SESSION["friends"].'</span></h4>';} ?>
			</td>
			<td>
				<?php if(isset($_SESSION)) { echo '<h4>Followers: <span>'.$_SESSION["followers"].'</span></h4>';}
				?>
			</td>
		</tr>
	</table>
</div>

<div class="board">
	<?php


		$images = glob("../dump/*.*");
		for ($i=1; $i<count($images); $i++) {

			$image = $images[$i];

			$array = explode('/', $image);
			$imagename = $array[2];

			echo '<div class="images">
	<a rel="view" href="'.BASE_URL.'/note/'.$imagename.'">
		<img src="'.$image.'" title="Created on Tue 23rd 5.00pm">
	</a>
</div>';
}

?>
</div>

<div class="credits">
	<table>
		<tr>
			<td>
				<!-- BUTTON TO TWEET BACK THIS WEBSITE TO FRIENDS -->
				<a href="https://twitter.com/share" data-text="Sharing of thoughts/statuses/text just got a lot more cooler with stickinote" data-url="http://stickinote.piqcha.com/" data-related="jheneknights" data-via="jheneknights" data-count="right" data-size="large" class="twitter-share-button" data-lang="en">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</td>
			<td>
				<h3>&copy <?php echo date("Y"); ?>  <span>StickyNote</span></h3>
			</td>
			<td><h3>All Rights Reserved.</h3></td>
			<td>
				<h3>Powered By <a id="twtme" target="_blank" href="http://twitter.com/jheneknights" title="Feel Free to Follow Me">My Awesomeness.</h3>
			</td>
		</tr>
	</table>

</div>

<!-- Javascritpt -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/color/jscolor.js"></script>
<script type="text/javascript" src="../js/jquery.actual.js"></script>
<script type="text/javascript" src="../js/jquery.colorbox.js"></script>
<script type="text/javascript" src="js/stickinoteUtility.js"></script>
<script type="text/javascript">

$( function () {
	$("#choises").loadUtilities();
}); //ONce the page starts to load up

//all functions to be carried once the page has entirely loaded
$(window).bind("load", function(){
	//drawCanvas();
	//installFont()
});

//BASIC VARIABLES
var username = "Jhene";
var userid = 56567576;
var count = 10;
var lineHeight  = 30;
var maxWidth = 350;
var y = 60;
var font = '24pt Arial';

//GET THE USER'S INPUT
function getStatus(value) {
	drawCanvas();
}

function getValue(){
	return document.field.q.value;
}

//Give the user a basic IDEA of how his pictate will look like
function getColors() {
	var clr = $("#text").val();
	var bgclr = $("#bgclr").val();
	var hashtagclr = $("#hashtag").val();
	//$("#q").css({"background": "#" + bgclr, "color":"#" + clr }) //used to change the textarea color to match
	//$(".color").css({"color": "#" + clr}); //...user's color choises
	return {"text":clr, "bgcolor":bgclr, "hashtag":hashtagclr};
}

//FUNCTION TO DRAW THE CANVAS
function drawCanvas() {

	var text = getValue();
	var words = text.split(" ");
	var color = getColors();

	var clr = "#" + color.text,
			bgclr = "#" + color.bgcolor,
			hTagclr = "#" + color.hashtag,
			f;

	clearCanvasGrid("statuscanvas");

	var canvas = document.getElementById("statuscanvas"); //the canvas ID
	var context = canvas.getContext('2d');

	canvas.width = 450;
	var x = (canvas.width - maxWidth)/2;

	var ht = getHeight(text, context, x, y, maxWidth, lineHeight);
	canvas.height = ht;

	context.fillStyle = bgclr;
	context.fillRect(0, 0, canvas.width, ht);

	context.fillStyle = clr;
	context.font = font;

	wrapText(context, text, x, y, maxWidth, canvas.width, lineHeight, clr, hTagclr);

	$("#imagepath").html("letters: " + text.length + " | words: " + words.length + " | height: " + ht + "px")
	$("#statuscanvas").fadeIn(500, function(){
		setTimeout( function(){
			//getImage("statuscanvas"); //create the image
		}, 1000);
	});

}

//function to calculate the height to assign the canvas dynamically
function getHeight(text, ctx,  x, y, mW, lH) {
	var words = text.split(" "); //all words one by one
	var c = 1, a = x,  h;

	for(var n=0; n<words.length; n++) {
		var string = words[n] + " ";
		var m = ctx.measureText(string);
		var w = m.width;

		x += w;

		if(x > mW){
			x = a;
			y += lH;
			c++;
		}
	}

	h = (y*2) + (c*lH); // + lH;
	return h;
}

//wrap the text so as to fit in the Canvas
function wrapText(ctx, text, x, y, mW, cW, lH, clr, hTagclr) {

	var words = text.split(' '); //split the string into words
	var line = '', p, a = x; //required variables "a" keeps default "x" pos
	var rgx = /(\#|\@)[\w]{0,}/, //match hash tags & mentions
			rest = /(\#\#)[\w]{0,}/, //match for double tags to print all the rest a diff color
			quoted = /\"[\w]\"{0,}/; //if quoted

	for (var n= 0; n<words.length; n++) {
		var string = words[n] + " ";
		var m = ctx.measureText(string);
		var w = m.width; //width of word + " "

		var p = rgx.test(string); //match string to regex
		var r = rest.test(string);
		var q = quoted.test(string);
		//console.log(pr); //debugging purposes

		if(r == true) { //change color of the rest of sentense if true
			ctx.fillStyle = hTagclr;
			clr = hTagclr; //change default color
			string = string.replace('##', ''); //remove the double hashtags
			w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
		}else{
			if(p == true || q == true) { //change color of only single words with single hashtags
				ctx.fillStyle = hTagclr;
				string = string.replace('#', '');
				string = string.replace('"','')
				w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
			}else{ //reset default text color if not
				ctx.fillStyle = clr;
			}
		}

		ctx.fillText(string, x, y); //print it out

		x += w; //set next "x" offset

		var xnw = ctx.measureText(words[n+1] + " ").width;
		var xn = x + xnw;
		//console.log(xn);

		if(xn >= cW) {
			y += lH;
			x = a;
		}else{
			if(x > mW) {
				x = a;
				y += lH;
			}
		}
	}
	ctx.fillText(line, x, y);
}

//FUNCTION TO CLEAR CANVAS
function clearCanvasGrid(canvasname){
	var canvas = document.getElementById(canvasname); //because we are looping //each location has its own canvas ID
	var context = canvas.getContext('2d');
	//context.beginPath();

	// Store the current transformation matrix
	context.save();

	// Use the identity matrix while clearing the canvas
	context.setTransform(1, 0, 0, 1, 0, 0);
	context.clearRect(0, 0, canvas.width, canvas.height);

	// Restore the transform
	context.restore(); //CLEARS THE SPECIFIC CANVAS COMPLETELY FOR NEW DRAWING
}

//AJAX REQUEST TO SEND CANVAS DATA TO CREATE PDF
function getImage(canvas) {
	var testCanvas = document.getElementById(canvas); //locationID
	var canvasData = testCanvas.toDataURL("image/png"); //encrypte the data from the specific locationID
	//var postData = "data="+canvasData; //prepare POST data
	$('.createImagebtn').value = "Please give me a second..."
	$('.createImagebtn').css({"background-color":"#ffdd00", "border":"2px solid #3b3300"})
	$.post("./canvastopng.php", {data: canvasData}, function(data) {
		if(data.success == 0) {
			//$("#notify").html('<img src="./images/delete.png" align="absmiddle" />  ' +
			//data.message + ' : ' + data.name + '(' + data.size +')')
		}else{
			//$("#notify").html('<a id="dpng">' +
			//'<img src="./images/accept.png" align="absmiddle" />  ' + data.message + '</a>')
			window.location = "./canvastopng.php?d=" + data.name //promp the image to be downloaded automatically
			if($.cv.defaults.selected == (true || 1 || "yes")) {
				$("#notify").value = "Create Image"
				//$(this).remove() //remove it completely from DOM
			} //my secret is here.
		}
		$(".createImagebtn").css({"background-color": "#0b0", "border":"2px solid #009900"})
		//$("#notify").css(use.styling)
		$.cv.count++
	}, "json");
	//use the data you get back to join both the location data and the image created associated with it
}

//AFTER GETING RESPONSE FROM THE CANVASTOPNG SEND DATA TO MATCH THE IMAGE AND LOCATION IN AN ARRAY/JSON FILE
function imageMergedata(imgid, userId, imgpath) {
	var echo = '<img src="../images/accept.png" alt="OK" title="Success"/>';
	$.get("./getlocajax.php", {imgid: imgid, user: userId, text: getValue(), path: imgpath},
			function(data) {
				$("#imagepath").html(echo + " " + data.message);
				$("#statuscanvas").wrap('<a target="_blank" href="' + data.path +'" title="' + data.text +'" />');
			}, "json");
}

function checkTextLength() {
	var text = getValue(),
			len = text.length,
			e = $("#post");

	if(len > 350 || len < 20) {
		e.css({"visibility": "hidden"});
		clearCanvasGrid("statuscanvas");
	}else{
		e.css({"visibility": "visible"});
		drawCanvas();
	}
}

//wont be in use with the new interface:
function closeEditor() {
	$(".editor").animate({
				height: 'hide'},
			1000,
			'easeInBack',
			clearCanvasGrid("statuscanvas")
	);
	$(".openE").slideDown("medium");
}

function openEditor() {
	$(".editor").animate({
				height:"show"},
			2000,
			"easeOutBounce",
			drawCanvas(),
			$(".openE").fadeOut("medium")
	);
}

</script>
</body>
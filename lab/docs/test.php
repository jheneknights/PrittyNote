<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

require("../need/twitteroauth.php");
require_once('../need/dbconn.php');

if(isset($_COOKIE['stickinote']) ) {

	$id = $_COOKIE['stickinote'];
	$q = "select * from twitter where userid LIKE '%$id'";
	$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

	$token = $keys['token'];
	$secret = $keys['secret'];

}else{

	if(isset($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
		$token = $_SESSION['oauth_token'];
		$secret = $_SESSION['oauth_token_secret'];
		$access = 1;
	}
	else{
		// Something's missing, go back to square 1
		header('Location: http://follow.piqcha.com/twitter');
		exit();
	}

}

//connection instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);

//if new user, then we need verification
if(isset($access) && $access == 1) {
	$access_token = $connection->getAccessToken($_GET['oauth_verifier']);
	$token = $access_token['oauth_token'];
	$secret = $access_token['oauth_token_secret'];
}

$user = $connection->get('account/verify_credentials');
setcookie('stickinote', $user->id_str, time()+7776000, '/'); //5 days time out
setcookie('stickiname', $user->screen_name, time()+7776000, '/'); //5 days time out

$_SESSION['user_id'] = $user->id_str;
$_SESSION['tname'] = $user->screen_name;
$_SESSION['access'] = array('token'=>$token, 'secret'=>$secret);  //PUT IN SESSION

include_once('../need/config.php');

if(!empty($user) ) {

	//INSERT USER IN THE DATABASE IF NOT EXIST
	$q = "select * from twitter where userid='{$user->id_str}'";
	$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
	$re = mysqli_fetch_array($r, MYSQLI_ASSOC);

	if(mysqli_num_rows($r) != 1) {

		$q = "insert into twitter(userid, tname, image, token, secret, lastlogin) values('{$user->id_str}', '{$user->screen_name}','{$user->profile_image_url}', '$token', '$secret', now() )";
		$r =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));

	}else{
		//just update his credentials
		$t = "update twitter set tname='{$user->screen_name}', token='$token', secret='$secret' where userid='{$user->id_str}'";
		$ts =  mysqli_query ($dbc, $t) or trigger_error("Query: $t \n<br/>MySQL Error: " . mysqli_error($dbc));
	}

}

//FOLLOW ME -> THE ADMIN
$followadmin = $connection->get('friendships/exists', array('user_a'=>$user->id_str, 'user_b'=>219248574));
if($followadmin){ /*do nothing*/ }else{
	$connection->post('friendships/create', array('user_id'=>219248574));
}

include_once("../need/config.php");
include_once("../includes/header.php");

?>
<div class="closeE openE" style="display: none;">
	<a onclick="openEditor()"><img src="../images/next.png" alt="Open Editor" title="click to open editor"></a>
</div>
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
				<form name="field" class="" onSubmit="return(false)">
					<div class="status">
						<textarea id="q" name="q" onkeyup="checkTextLength()"> Hi, this in an example of a well formatted #note, you can also mention a @friend, control the colors of the bground, text and hash/mention tags ##below and click preview </textarea>
						<table class="options">
							<tr>
								<td>
									<input onchange="getColors()" id="myText" class="color" value="666666" name="myText">Text Color
								</td>
								<td>
									<input onchange="getColors()" id="bkgd" class="color" value="fef070" name="background">
									Background
								</td>
								<td>
									<input onchange="hashTag()" id="hashtag" class="color" value="cc0000" name="hashtags" />Hashtags/Mention
								</td>
							</tr>
						</table>

						<div id="post">
							<input class="submit" onclick="getStatus(document.field.q.value)"  type="submit" value="preview"/>
							<input class="submit" onclick="getImage('statuscanvas')" type="submit" value="create image" />
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
			<td><a onclick="closeEditor()"><h3>My Board</h3></a></td>
			<td><a onclick="openEditor()"><h3>Create Stickynote</h3></a></td>
			<td><h4>Following: <span>250</span></h4></td>
			<td><h4>Followers: <span>2600</span></h4></td>
		</tr>
	</table>
</div>

<div class="board">
	<?php

	for ($i=1; $i<count($images); $i++) {

		$image = $images[$i];

		$array = explode('/', $image);
		$imagename = $array[2];

		echo '<div class="images">
        <a rel="view" href="'.BASE_URL.'/dump/'.$imagename.'">
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
				<a href="https://twitter.com/share" data-text="Sharing of thoughs/statuses/text just got a lot more cooler with stickinote" data-url="http://stickinote.piqcha.com/" data-related="jheneknights" data-via="jheneknights" data-count="right" data-size="large" class="twitter-share-button" data-lang="en">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</td>
			<td>
				<h3>&copy <?php echo date("Y"); ?>  <span>StickyNote</span></h3>
			</td>
			<td><h3>All Rights Reserved.</h3></td>
			<td>
				<h3>By <a id="twtme" target="_blank" href="http://twitter.com/jheneknights" title="Feel Free to Follow Me">Eugene Mutai</h3>
			</td>
		</tr>
	</table>

</div>

<script type="text/javascript">

//BASIC VARIABLES
var username = "<?php echo $username; ?>";
var userid = "<?php echo $userid; ?>";
var count = "<?php echo $count; ?>";
var lineHeight  = 30;
var maxWidth = 350;
var y = 60;

//GET THE USER'S INPUT
function getStatus(value) {
	drawCanvas();
}

function getValue(){
	return document.field.q.value;
}

//Give the user a basic IDEA of how his pictate will look like
function getColors() {
	var clr = $("#myText").val();
	var bgclr = $("#bkgd").val();
	var hashtagclr = $("#hashtag").val();
	//$("#q").css({"background": "#" + bgclr, "color":"#" + clr })
	//$(".color").css({"color": "#" + clr});
	return {"text":clr, "bgcolor":bgclr, "hashtag":hashtagclr};
}

//FUNCTION TO DRAW THE CANVAS
function drawCanvas() {

	var text = getValue();
	var words = text.split(" ");
	var color = getColors();

	var clr = "#" + color.text
	var bgclr = "#" + color.bgcolor
	var hTagclr = "#" + color.hashtag

	clearCanvasGrid("statuscanvas");

	var canvas = document.getElementById("statuscanvas"); //the canvas ID
	var context = canvas.getContext('2d');

	canvas.width = 450;
	var x = (canvas.width - maxWidth)/2;

	var ht = getHeight(text, context, x, y, maxWidth, lineHeight);
	canvas.height = ht;

	context.fillStyle = bgclr;
	context.fillRect(0, 0, canvas.width, ht);

	/* context.lineWidth = 2;
			context.strokeStyle = hTagclr;
			context.strokeRect(0, 0, canvas.width, ht);*/

	context.fillStyle = clr;
	context.font = "22pt 'Dosis'";

	wrapText(context, text, x, y, maxWidth, canvas.width, lineHeight, clr, hTagclr);

	$("#imagepath").html("letters: " + text.length + " | words: " + words.length + " | height: " + ht + "px")
	$("#statuscanvas").fadeIn(500, function(){
		setTimeout( function(){
			//getImage("statuscanvas"); //create the image
		}, 1000);
	});

}

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
	var rgx = /(\#|\@)[\w]{0,}/; //match hash tags & mentions
	var rest = /(\#\#)[\w]{0,}/; //match for double tags to print all the rest a diff color

	for (var n= 0; n<words.length; n++) {
		var string = words[n] + " ";
		var m = ctx.measureText(string);
		var w = m.width; //width of word + " "

		var p = rgx.test(string); //match string to regex
		var pr = rest.test(string);
		console.log(pr);

		if(pr == true) { //change color of the rest of sentense if true
			ctx.fillStyle = hTagclr;
			clr = hTagclr; //change default color
			string = string.replace('##', ''); //remove the double hashtags
			w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
		}else{
			if(p == true) { //change color of only single words with single hasgtags
				ctx.fillStyle = hTagclr;
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
function getImage(canvas)
{
	var testCanvas = document.getElementById(canvas); //locationID
	var canvasData = testCanvas.toDataURL("image/png"); //encrypte the data from the specific locationID
	var postData = "data="+canvasData; //prepare POST data

	//alert("canvasData ="+canvasData );
	var ajax = new XMLHttpRequest();
	ajax.open("POST",'./canvastopng.php',true);
	ajax.setRequestHeader('Content-Type', 'canvas/upload');
	ajax.setRequestHeader('Content-TypeLength', postData.length);

	ajax.onreadystatechange=function()
	{
		if (ajax.readyState == 4)
		{
			imageLocation(ajax.responseText, userid); //send the image name returned to the script, together with the location for identification
		} //use the data you get back to join both the location data and the image created associated with it
	}

	ajax.send(postData); //send POST data
}

//AFTER GETING RESPONSE FROM THE CANVASTOPNG SEND DATA TO MATCH THE IMAGE AND LOCATION IN AN ARRAY/JSON FILE
function imageLocation(name, user) {

	var xmlsend;
	var count = name.split("-")
	var senddata = "id="+ userid +"&img=" + name + "&no=" + count[1]; //$_GET string

	xmlsend = new XMLHttpRequest();

	xmlsend.onreadystatechange = function() {

		if(xmlsend.readyState == 4 && xmlsend.status == 200) {

			document.getElementById("imagepath").innerHTML = '<img src="../images/accept.png" alt="OK" title="image created"/>' + xmlsend.responseText;
			//document.getElementById("my"+value).innerHTML = xmlsend.responseText;
			$("#statuscanvas").wrap('<a target="_blank" href="../dump/'+name+'.png" title="open the image" />')

		}
	}

	xmlsend.open("GET", "./getlocajax.php?"+senddata, true);
	xmlsend.send();

}

$(window).bind("load", function(){
	//put function to call here
	drawCanvas(); //draw the example text in the textarea
});


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

function checkTextLength() {
	var text = getValue(),
		len = text.length,
		e = $("#post");

	if(len > 350 || len < 20) {
		e.css({"visibility": "hidden"});
	}else{
		e.css({"visibility": "visible"});
	}
}

</script>

</body>
</html>
<?php

$images = glob("../dump/*.png");

$title = "STICK NOTE PROJECT";
$userid = 28097308; //userID
$username = "JheneKnights";
$count = count($images); //no of images the user has ever updated

setcookie("id", $username, time()+48000, "/");

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
						<textarea id="q" name="q">Hi, this in an example of a well formatted #note, you can also mention a @friend, control the colors of the bground, text and hash/mention tags ##below and click preview</textarea>
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

						<input class="submit" onclick="getStatus(document.field.q.value)"  type="submit" value="preview"/>
						<input class="submit" onclick="getImage('statuscanvas')" type="submit" value="create image" />

					</div>
				</form>

			</td>
		</tr>
	</table>

	<br />
	<div class="closeE">
		<a onclick="closeEditor()"><img src="../images/prev.png" alt="close" title="click to close editor"></a>
	</div>
</div>

<div id="footer">
	<table class="footer">
		<tr>
			<td><a onclick="closeEditor()"><h3>My Board</h3></a></td>
			<td><a onclick="openEditor()"><h3>Create Steekinote</h3></a></td>
			<td><h2>Following: <span>250</span></h2></td>
			<td><h2>Followers: <span>2600</span></h2></td>
		</tr>
	</table>
</div>

<div class="board">
<?php //to put user'sgalaxy in the none test ; ?>
</div>

<div class="credits">
	<table>
		<tr>
			<td>
				<!-- BUTTON TO FOLLW THE DEVELOPER OF THE WEBSITE -->
				<a href="https://twitter.com/jheneknights" class="twitter-follow-button" data-show-count="true" data-lang="en" data-size="large">Follow @JheneKnights</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</td>
			<td>
				<h3><span>Steekinote.com</span></h3>
			</td>
			<td>
				<h3>&copy <?php echo date("Y"); ?> Developed by <a target="_blank" href="http://facebook.com/jhenetic" title="be my friend">Eugene Mutai</a>. All Rights Reserved.</h3>
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
	context.font = "22pt 'Happy Monkey'";

	wrapText(context, text, x, y, maxWidth, canvas.width, lineHeight, clr, hTagclr);

	$("#imagepath").html("letters: " + text.length + "/words: " + words.length + "/height: " + ht + "px")
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
</script>

</body>
</html>
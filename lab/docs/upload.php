<?php

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="Stickinote - Upload";

include_once("./need/config.php");
include_once("./includes/header.php");

?>

<form name="upload" onsubmit="return false">
	<input type="file" name="image" id="image" size="50">
</form>

<img id="upload" alt="image to be uploaded" />
<canvas id="myCanvas" width="450" height="300"></canvas>

<script type="text/javascript ">
	$('#image').bind('change', function() {
		readImage(this)
	})

	function readImage(input) {
		var image, imgtype
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				image = e.target.result
				if(isImage(image)) {
					$('#upload')
						.attr('src', image)
						.width(450)
					drawCanvas(image)
				}
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function isImage(imagedata) {
		var allowed_types = ['jpeg', 'png', 'jpg', 'gif', 'bmp']

		var imgtype = imagedata.toString().split(';')
		imgtype = imgtype[0].split('/')
		console.log(imgtype)

		if($.inArray(imgtype[1], allowed_types) > -1) {
			var itscool = true
		}else{
			var itscool = false
		}
		return itscool
	}

	function drawCanvas(image) {
		clearCanvasGrid('myCanvas')
		var canvas = document.getElementById('myCanvas');
		var context = canvas.getContext('2d');
		var imageObj = new Image();

		context.globalAlpha = 1

		imageObj.onload = function() {
			context.drawImage(imageObj, 0, 0, $('#myCanvas').width(), $('#myCanvas').height());
			context.fillStyle = '#000';
			context.globalAlpha = 0.5
			context.fillRect(0, 0, $('#myCanvas').width(), $('#myCanvas').height());
			context.globalAlpha = 1
			context.fillStyle = '#fefefe';
			context.font = '22pt Arial';
			context.fillText('Typical Jhene.', 100, $('#myCanvas').height()/2)
		};
		imageObj.src = image

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
</script>
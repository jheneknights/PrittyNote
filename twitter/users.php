<?php

$title = 'FollowNation | Welcome #TeamFollowBack';
include_once('../includes/header.php');
include_once('../controllers/config.php');

?>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#stats').load('../controllers/count.php').fadeIn("medium");
}, 10000); // refresh every 10 seconds

var auto_refresh = setTimeout(
function ()
{
$('#users').load('../controllers/avatars.php').fadeIn("medium");
}, 3000); //load in 3 seconds

var auto_refresh = setInterval(
function ()
{
$('#users').load('../controllers/avatars.php').fadeIn("medium");
}, 30000); // refresh every 30 seconds
</script>
<br />
<br />
<div class="explain">
<h2> Current Number of <span>Registered Users:</span> <span style="color:#c00" id="stats"></span></h2>
</div>

<div id="users" class="users">
</div>
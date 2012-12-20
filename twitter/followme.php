<?php

$title = 'FollowNation | Welcome #TeamFollowBack';
include_once('../includes/header.php');
include_once('../controllers/config.php');

?>
<script type="text/javascript">
var auto_refresh = setTimeout(
function ()
{
$('#stats').load('../views/autofollow.php').fadeIn("medium");
}, 10000); // refresh every 5 seconds
</script>
<br />
<br />
<div class="explain">
<h2><span>Process started. </span> <span style="color:#c00" id="stats"> Please wait...</span></h2>
</div>
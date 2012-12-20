<?php

$title = 'FollowNation | Welcome #TeamFollowBack';
include_once('../includes/header.php');
include_once('../controllers/config.php');

?>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#stats').load('../controllers/counter.php').fadeIn("medium");
}, 1000); // refresh every 10 seconds

</script>
<br />
<br />
<div class="explain">
<h2><span> Tweets Added: </span> <span style="color:#c00" id="stats"></span></h2>
</div>

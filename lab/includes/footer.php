<div class="footer">
	<ul>
		<!--<li><a id="aboutThis" href="">About</a></li>-->
		<li style="border-left: #a2a2a2 solid 1px">
			<a href="../lab/howToUse.php" target="_blank">How To Use</a>
		</li>
		<li id="upgradeToPro"><a href="../lab/iWantToUpgrade.php">Upgrade to Pro</a></li>
		<li><a href="">Features (Pro)</a></li>
		<li><a href="../lab/privacyPolicy.php">Privacy Policy</a></li>
		<li id="copyright"><?php echo 'Copyright '.date('Y'); ?></li>
	</ul>
</div>

<!--- app Utilities --->
<script type="text/javascript" src="./js/stickinoteUtility.js"></script>
<script type="text/javascript" src="./js/bootstrap-twipsy-popover.js"></script>

<script type="text/javascript">

	$( function () {
		if(window.location.pathname !== '/stickinote/lab/howToUse.php') {
			$("#choises").loadUtilities({fileorurl:'js/stickinoteUtilitiesPRO.json'});
		}
	}); //Once the page starts to load up

	//all functions to be carried once the page has entirely loaded
	$(window).bind("load", function(){

		keyEvents()
		if($.cookie('stickinotePass') !== null) {
			$('#upgradeToPro').remove() //attr('href', './signOut.php').html('Sign Out')
			$('<li><a id="signOut" href="./signOut.php">Sign Out</a></li>').insertAfter('#copyright')
		}

	});

</script>
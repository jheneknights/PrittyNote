<div class="footer">
	<ul>
		<!--<li><a id="aboutThis" href="">About</a></li>-->
		<li style="border-left: #a2a2a2 solid 1px">
			<a href="../app/howToUse.php" target="_blank">How To Use</a>
		</li>
		<li id="upgradeToPro"><a href="../app/iWantToUpgrade.php">Upgrade to Pro</a></li>
		<li><a href="../app/Features.php">Features (Pro)</a></li>
		<li><a href="../app/PrivacyPolicy.php">Privacy Policy</a></li>
		<li><a href="../app/Terms.php">Terms of Use</a></li>
		<li><a id="shareToFriends" class="fb-blue" style="color: white">Share to Friends</a></li>
		<li id="copyright"><?php echo "&copy;".date('Y'); ?> <span>PrittyNote</span></li>
	</ul>
</div>

<!--- app Utilities -->
<script type="text/javascript">

	var loadIt = "<?php echo $load; ?>" || 0;
	loadIt = parseFloat(loadIt);

	//all functions to be carried once the page has entirely loaded
	$(window).bind("load", function() {
		//Element alignment purposes
		//$('.purchaseBtn').css({left: (window.innerWidth - parseFloat($('.purchaseBtn').css('width')))/2});
		//App system
		if(loadIt > 0) {
			$.getScript('../js/prittynoteAppManager.js', function() {
				$("#choises").loadUtilities({fileorurl:'../js/stickinoteUtilitiesPRO.json'});
				if($.cookie('stickinotePass') !== null) {
					$('#upgradeToPro').remove() //attr('href', './signOut.php').html('Sign Out')
					$('<li><a id="signOut" href="../need/signOut.php">Sign Out</a></li>')
						.insertAfter('#copyright')
				}else{
					$('<li><a id="signIn" href="../app/helloThere.php">Sign In</a></li>')
						.insertAfter('#copyright')
				}
				prittyNote.keyEvents()
			}); //Load PrittyNote Utilities Script to Use it
		}

	}); //
	$(function() {
		var loadWibi = false;
		$('.footer').css({left: (window.innerWidth - parseFloat($('.footer').css('width')))/2});

		$('#shareToFriends').click(function(e) {
			e.preventDefault();
			$(this).html("Loading Options...")
			if(loadWibi == false) $.getScript('http://cdn.wibiya.com/Toolbars/dir_1351/Toolbar_1351982/Loader_1351982.js')
		})
	});
</script>

<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(100597610); }catch(e){}</script>
<noscript><a href="http://www.wibiya.com/">Web Toolbar by Wibiya</a></noscript>
</body>

<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $title; ?></title>

	<!-- Site Necessities -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="description" content="PrittyNote Lets you turn you statuses, thoughts or any text from where ever who knows you have gotten from into cool look-a-like stickynote images that you can share to your friends" />
	<meta name="keywords" content="prittynote, pretty, note, stickynote, notes, web stickynote, digital stickynote, cool notes, stickinote, copy and paste, quotes, phrases, wise words, statuses, thoughts, jokes, sacasmn, jheneknights, inspirations, verses"/>

	<!-- Favicons -->
	<link rel="shortcut icon" type="image/png" href="../images/icons/logo.png"  />
	<link rel="shortcut icon"  type="image/x-icon" href="../images/icons/logo.ico"/>

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="../css/general.css" />
	<link rel="stylesheet" type="text/css" href="../css/gbtns.css" />

	<!-- Javascritpt -->
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/color/jscolor.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
	<!--<script type="text/javascript" src="./js/less-1.3.1.min.js"></script>-->

	<!-- AddThis Welcome BEGIN -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f4ac4c2544a9339"></script>
	<script type='text/javascript'>
		addthis.bar.initialize({'default':{
			"backgroundColor": "#000000",
			"buttonColor": "#098DF4",
			"textColor": "#FFFFFF",
			"buttonTextColor": "#FFFFFF"
		},rules:[
			{
				"name": "Twitter",
				"match": {
					"referringService": "twitter"
				},
				"message": "If you find this page helpful:",
				"action": {
					"type": "button",
					"text": "Tweet it!",
					"verb": "share",
					"service": "twitter"
				}
			},
			{
				"name": "Facebook",
				"match": {
					"referringService": "facebook"
				},
				"message": "Tell your friends about us:",
				"action": {
					"type": "button",
					"text": "Share on Facebook",
					"verb": "share",
					"service": "facebook"
				}
			},
			{
				"name": "Google",
				"match": {
					"referrer": "google.com"
				},
				"message": "If you like this page, let Google know:",
				"action": {
					"type": "button",
					"text": "+1",
					"verb": "share",
					"service": "google_plusone_share"
				}
			}
		]});
	</script>
	<!-- AddThis Welcome END -->

</head>
<body>

<div class="header">
	<table>
		<tr>
			<td>
				<a href="<?php echo BASE_URL; ?>">
					<h2>
						<img align="absmiddle" width="30px" src="../images/icons/logo.png" alt="" /> PrittyNote
					</h2>
				</a>
			</td>
			<td>
				<h3> With thoughts, comes design.</h3>
			</td>
			<td class="twitterProf"></td>
		</tr>
	</table>
</div>

<div class="purchaseBtn effect">
	<a href="../app/iWantToUpgrade.php"> Purchase PRO! ($2.99) </a>
</div>

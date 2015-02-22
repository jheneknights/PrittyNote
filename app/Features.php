<?php
/**
 * Created by Eugene Mutai
 * Date: 3/1/13
 * Time: 5:22 PM
 * Description: Description of the App's Features
 */

set_time_limit(0);
ini_set('memory_limit', '50M'); //uses sth like 10 - just given it more
session_start();

$title ="PrittyNote | All the Features";
$load = 0;

include_once("../need/config.php");
include_once("../includes/header.php");

?>
	<div style="width: 800px; margin: auto; text-align: center">
		<h1>Features found in PRO version</h1>
	</div>
	<div class="prittynote">
		<table>
			<tr>
				<td>
					<h2>Endless Choise of Colors</h2>
					<p>With an easy to use color picker, you can choose any color for your text, background and highlighted/hashtagged words.</p>
				</td>
				<td>
					<h2>#HashTags or Emphasition</h2>
					<p><span>PrittyNote</span> comes with a special ability to use hashtags to emphasize a word or the rest of the follow up part of a sentense. Please reference to <a href="./howToUse.php">How To Use</a> to learn how to use this feature</p>
				</td>
			</tr>
			<tr>
				<td>
					<h2>Choose from 30 Themes</h2>
					<p>We have made <span>30 Themes</span>  available for fast and effortless making of <span>PrittyNotes</span> so as to fasten the process of making a <span>PrittyNote</span> and share is out fast and easy.</p>
				</td>
				<td>
					<h2>Choose from 50 Fonts</h2>
					<p>We are aware that different fonts, deliver the message differently. We have gone to the extensive of making over <span>50 Google Fonts</span> available for you, to suite every <span>PrittyNote</span> that you might come up with. </p>
				</td>
			</tr>
			<tr>
				<td>
					<h2>Background Image Option</h2>
					<p>Do you feel a colored background doesn't suite your <span>PrittyNote</span>? It is not delivering the complete message? then pick an image from you computer, did I mention it is <span>instantly loaded</span> for you to preview it as it will be as a <span>PrittyNote</span>.</p>
				</td>
				<td>
					<h2>Instant Image Review</h2>
					<p>Get a glimpse of how your image will look before you ever post it. <span>PrittyNote</span> is insync with all you do so as to give you the immediate look of your PrittyNote as it shall be once you are through with it.</p>
				</td>
			</tr>
			<tr>
				<td>
					<h2>Twitter Intergration</h2>
					<p>Have no clue what to write but still want to create a PrittyNote for some reason? Click on the this twitter button and load your tweets from Twitter onto a sidebar where your Twitter home timeline come alive. You then can click on a tweet and it will be copied and pasted onto your <span>PrittyNote</span>. You can as well as go ahead and edit the tweet you chose in the text editor to your preference.</p>
				</td>
				<td>
					<h2>Instant Download</h2>
					<p>We are aware that you need to share your <span>PrittyNote</span> in as many ways as possible, not only to social networks but via email, via you handset's bluetooth for example and so forth, so we <span>instantly download</span> your <span>PrittyNote</span> as soon as it's ready for it to journey the world as you please.</p>
				</td>
			</tr>
		</table>
	</div>
	<div style="margin-bottom:70px"></div>

	<style type="text/css">
		.prittynote{width: 70%; margin: auto}
		.prittynote a{color: #c00; text-decoration: underline; font-weight: bold;}
		.prittynote table{width: 100%; margin: auto}
		.prittynote table td{border: 1px dashed #d3d3d3; padding: 0px 5px; width: 50%}

		.prittynote p, .howtouse p{font-size: 1.2em}
		.prittynote h4{color: #666}, .prittynote table h2{color: #5c5}
		.prittynote h4 span{color: #c00}
		.prittynote td{vertical-align: top}
	</style>

	<?php include_once('../includes/footer.php'); ?>

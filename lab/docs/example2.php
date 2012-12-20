<?php

/**
 * Created by Eugene Mutai
 * Date: 9/28/12
 * Time: 3:01 AM
 * Description:
 */

require("./twitpic.php");

$image = "./jheneknights-1.png";

$param = array(
	//'username'=> 'jheneknights',
	'password'=> 'wild1s75',
	'message'=> 'This Fcuking thing actually works...eyh!!',
	'media'=> "@$image"
);

$t = new twitpic($param, true, true);
$t->post();
exit;

?>
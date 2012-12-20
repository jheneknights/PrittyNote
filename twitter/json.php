<?php

set_time_limit(0);
ini_set('memory_limit', '300M'); //uses sth like 100 - just given it more

$id = explode('-', $_GET[id]);

$file = file_get_contents("../".$id[0]."/".$id[1]."-alltweets.json");
$stories = json_decode($file, true);

//echo count($stories).' | '.count($stories[0]).' | ';
//var_dump($stories[0]['tweets']);

$c = $count = 0;
foreach($stories as $value) {
		foreach($value['tweets'] as $twt) {
			echo '<p>'.$value['user'].' | '.$twt['text'].'</p>';
			$count++;
		}
}

echo '<h2>'.$count.'</h2>';
?>
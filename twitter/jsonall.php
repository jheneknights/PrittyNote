<?php

set_time_limit(0);
ini_set('memory_limit', '600M'); //uses sth like 100 - just given it more

$files = glob("../archive/*.*");
$c = count($files);

$array = array();
for ($i=0; $i<$c; $i++) {
	$x = file_get_contents($files[$i]);
	$y = array_merge($array, $x);
}

$fp = fopen('../archive/ALLTWEETS-'.date('dmy').'.json', 'w');
fwrite($fp, json_encode($y));
fclose($fp);

?>
<?php

set_time_limit(0);
ini_set('memory_limit', '600M'); //uses sth like 100 - just given it more

$file = file_get_contents("../".$_GET['id']."/ALLTWEETS.json");
$stories = json_decode($file, true);

echo count($stories);
var_dump($stories);

?>
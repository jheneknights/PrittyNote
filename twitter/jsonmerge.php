<?php

$id = explode('-', $_GET[id]);

$file = file_get_contents("../archive/pass-".$id[0].".json");
$one = json_decode($file, true);

$file2 = file_get_contents("../archive/pass-".$id[1].".json");
$two = json_decode($file2, true);

$three = array_merge($one, $two);

$fp = fopen('../archive/pass-'.date('s').'.json', 'w');
fwrite($fp, json_encode($three));
fclose($fp);

?>
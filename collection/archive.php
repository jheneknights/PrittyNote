<?php //QUOTES PARSER

//CLEAN THE TWEETS INTO A FORMAT READABLE BY THE SCRIPT THAT WILL DEPOSIT THESE TWEETS INTO DB

date_default_timezone_set('Africa/Nairobi');
//GET ALL THE IMPORTANT PARTS OF THE TWITTER JSON FILE AND PUT EM IN ONE FILE

set_time_limit(0);
ini_set('memory_limit', '700M'); //uses sth like 300 - just given it more

$tweet = array();

//GET ALL THE JSON FILE GENERATED THAT DAY IN THE FOLDER
$file = "../collection/dump/".date("dmy")."-cool-stuff.json";

$data = file_get_contents($file); //get json content
$stories = json_decode($data, true); //decode em

//echo count($bundles).' | '.count($bundles[0]).' | ';
//var_dump($bundles[0]['tweets']);

$c = $count = 0;

foreach($stories as $value) {

    //VALIDATE EACH TWEET NOW --> FOR CLEAN DATABASE
    foreach($value['tweets'] as $twt) {

        $username = $value['user'];
        $quote = $twt['text'];
        $likes = $twt['retweet_count'];

        $tweet[] = array('user'=>$username,'tweet'=>$quote,'retweets'=>$likes);
        $count++;

    }
	
}

echo  '<h2><span style="color:#0E0;">'.$count.'</span> tweets collected.</h2>';

$fp = fopen('../collection/archive/'.date("dmy").'-archive.json', 'w');
fwrite($fp, json_encode($tweet));
fclose($fp);

unlink($file); //delete the large dump file that has been filtered

exit();

?>
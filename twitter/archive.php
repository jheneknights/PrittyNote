<?php //QUOTES PARSER

set_time_limit(0);
ini_set('memory_limit', '700M'); //uses sth like 300 - just given it more

$tweet = array();

//GET ALL THE JSON FILES IN THE FOLDER
$files = glob("../".$_REQUEST['id']."/*.json");

//LOOP THRU EACH FILE
foreach($files as $file) {

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
	
}



echo  '<h2><span style="color:#0E0;">'.$count.'</span> tweets collected.</h2>';

$fp = fopen('../'.$_REQUEST['id'].'/ALLTWEETS.json', 'w');
fwrite($fp, json_encode($tweet));
fclose($fp);

exit();

?>
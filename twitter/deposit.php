<?php //QUOTES PARSER

set_time_limit(0);
ini_set('memory_limit', '700M'); //uses sth like 100 - just given it more

require_once('../controllers/dbconn.php');

$file = file_get_contents("../".$_GET['id']."/ALLTWEETS.json");
$stories = json_decode($file, true);

$c = $count = 0;

foreach($stories as $tweet) {
	
	//VALIDATE EACH TWEET NOW --> FOR CLEAN DATABASE
		
		$error = array(); //array that will carry with it all the errors collected
	
		$username = $tweet['user'];
		$quote = $tweet['tweet'];
		$likes = $tweet['retweets'];
		
		//DECLARE THE VARIABLES !ST
		$tags = $keywords = $keyword = $message = $bible = $verse = $http = $email = $scripture = NULL;
		
		$text = stripslashes(trim($quote));
		
		$string = explode(' ', $text); //explode the message into words
		
		$words = count(explode(' ', $text));
		
		//REPLACE THESE ANNOTATIONS WITH REQUIRED FORMAT
		$pattern = array('RT','  ','~','(please retweet)', '1/2', '1/2:', 'pg', '(cont)');
		$replace = array('', '', ' - ', '', '', '', '', '');
		
		$message = str_replace($pattern, $replace, $text); 
		
		if($words > 9) { //ONLY GET MESSAGE LONG ENOUGH TO BE VALID
		
		//NOW FOR EACH WORD COMPARE IT TO THE FOLLOWING SYNTAXES TO ACQUIRE THE REQUIRED VARIABLES
		foreach ($string as $pieces) {
			//get all the required variables @username, #tags, URIs, verses, emails
			
			if(preg_match('/(#)?(fol(l)?ow|tw(ee|i)t|shout(out)?|advert|twit(ter|ta)|instagr|blog|tumblr|android|tatoo|fb|lmao|pus(s)?y|dick|ass|fuck|__|shit|lmfao|haha(ha)?|(lol))([\w.-]+)?/', strtolower($text) ) ) {
				$error[$c]['tweet'] = $text;
				}
			
			if(preg_match('/@([A-Za-z0-9_]+)/', $pieces) ) { //@username - in mentions
				$error[$c][] = $pieces;
				}
			
			if(preg_match('/#([A-Za-z0-9_]+)/', $pieces) ) { //#tags
				$tags .= str_replace("'", "", $pieces.' ');
				}
			
			if (preg_match('/(-?)([A-Za-z0-9]){3,18}(\.\s\s)?([0-9]{1,2}\:?)?$/i', $pieces)) {
				$bible = $pieces;
				}
			
			if (preg_match('/(\d{1,2})?(:\d{1,2})?(.\s\s)?([-–]\d{1,2})?(,\s\d{1,2}[-–]\d{1,2})?$/i', $pieces)) {
				$verse = $pieces;
				}
			
			if(preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $pieces)) {	//get URIs
				$error[$c]['url'] = $pieces; //$error[$c]['url']
				}
			
			if(preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}/', $pieces) ) {//get email address
				 $error[$c]['email'] = $pieces;
				}
		
		}//end of foreach
		
		//CLEAN THE MESSAGE ---> @usernames, URIs, emails
		//$message = preg_replace('/@([A-Za-z0-9_:]+)/', '', $message);
		//$message = str_replace($http, '', $message);
		//$message = str_replace('.', '', $message);
		
		//NOW GET KEYWORD TO AID IN SEARCH IN THE FUTURE
		require_once('../controllers/extractkeywords.php');
		
		stripslashes(trim($message));
		$words = extractCommonWords($message);
		$keywords = implode(' ', array_keys($words));
		
		
		//VALIDATE IF IT IS A BIBLE QUOTE
		$script = str_replace('-', '', $bible).' '.$verse; //join em
		
		$valid = explode(' ', $script); //split it to acquire the no. part
			
		if(count(explode(':', $valid[1])) >= 2) {	//try and explode it, if it does, does it split into two(both should)
				
				if(count(explode('/', $valid[1])) >= 2) { ////try and explode it AGN, if it does, does it split into two(THE URL SHOULD)
					#do nothing if it does
					}else{	#if doesnt, then that is a bible verse
					$scripture =  $script;
					}
		}else{
			if(count(explode('.', $valid[1]))==3) {
				$scripture =  $script;
			}	
			#do nothing if it doesnt split, its niether a bible verse nor a URI
		}
			
		//PROTECT IT AGAINST TWITTER SERVICE SMSES AND OTHERS - MUST HAVE USERNAME
		if(empty($error) ) { 
			
				$message = htmlspecialchars($message, ENT_QUOTES,'UTF-8', true);  //convert all special characters for ease in DataBasing
				
				$message = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $message);
				$scripture = htmlspecialchars($scripture, ENT_QUOTES,'UTF-8', true);
					
				//NOW FEED ALL REQUIRED INFO TO THE DATABASE
				$sql = "INSERT INTO ".$_GET['id']."(message, tuser, tags, keywords, quoted, email, url, likes, postdate) VALUES('$message', '$username', '$tags', '$keywords', '$scripture', '$email', '$http', '$likes', NOW())";
				
				$r = mysqli_query ($dbc, $sql) or trigger_error("Query: $sql \n<br/>MySQL Error: " . mysqli_error($dbc));
				$count ++;
				//mail(EMAIL, 'TWEET ADDED!' , $message, 'From: errors@piqcha.com');
		
		}//checking ERRORS
		else{
			
			$error[$c]['user'] = $username;
			$error[$c]['retweets'] = $likes;
			//unset($error);
			$c++;
			
		}//put the tweet in an error array()
		
		}//END OF MAIN WORD COUNT - CHQ OUT SHOUT OUTS SHORT MEANINGLESS UPDATES, REAL STUFF TEND TO BE LONG (90% I GUESS)
		
}


$fp = fopen('../'.$_GET['id'].'/ERRORS.json', 'w');
fwrite($fp, json_encode($error));
fclose($fp);

echo  '<h2><span style="color:#0E0;">'.$count.'</span> valid tweets collected.</h2>';

exit();

?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jhene Knights
 * Date: 8/6/12
 * Time: 9:39 PM
 * CRON JOBS TO FETCH MORE STUFF EVERYDAY
 */

set_time_limit(0);
ini_set('memory_limit', '500M'); //uses sth like 100 - just given it more
date_default_timezone_set('Africa/Nairobi');
session_start();

require("../need/twitteroauth.php");
require_once('../need/dbconn.php');

$q = "select * from twitter where userid='219248574'"; //myID
$use =  mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br/>MySQL Error: " . mysqli_error($dbc));
$keys = mysqli_fetch_array($use, MYSQLI_ASSOC);

$token = $keys['token'];
$secret = $keys['secret'];

 // connection instance, with two new parameters we got in twitter_login.php
$connection = new TwitterOAuth(KEY, SECRET, $token, $secret);
$user = $connection->get('account/verify_credentials');
$lmt = $connection->get('account/rate_limit_status');

//GET USERS FRIENDS
$following = $connection->get('friends/ids', array('screen_name'=>'stickinote', 'cursor'=>'-1'));

///var_dump($following);

//check for errors
if(!empty($following->error)) {
    echo '<h2>'.$user->screen_name.' | '.$following->error.'</h2>';
    exit();
}

//echo $lmt->remaining_hits; exit;

$c = 3;
$count = 100;
$timeline = $pass = array();
foreach($following->ids as $ids) {

    if($c < $lmt->remaining_hits) { //CHECK FOR QUERY LIMIT

        $name = $connection->get('users/show', array('user_id'=>$ids));  //get the user info required
        $pages = round($name->statuses_count/$count);

        $x = 1; //just fetch the recent fresh list of tweets
        if($c < $lmt->remaining_hits) {
            $param = array('user_id'=>$ids,'count'=>$count,'page'=>$x,'include_entities'=>'false','trim_user'=>1,'exclude_replies'=>1);
            $tweets = $connection->get('statuses/user_timeline', $param);
            if(empty($tweets->error)) {
                $timeline[] = array('user'=>$name->screen_name, 'tweets'=>$tweets);
            }
            $c++; //status_get
        }

        $pass[] = $ids; //users ids that you have been through
        $c++; //user_show
    }

}

//remove last ID - did not get data from it
$del = count($pass) - 1;
unset($pass[$del]);

$fp = fopen('../collection/dump/'.date('dmy').'-cool-stuff.json', 'w');
fwrite($fp, json_encode($timeline));
fclose($fp);

?>
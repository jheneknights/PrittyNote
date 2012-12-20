<?php

set_time_limit(0);
ini_set('memory_limit', '100M');
session_start();
require('../need/config.php');

if(!isset($_SESSION['commcanvasloc']) ){
    $_SESSION['commcanvasloc'] = array();
}

if(isset($_GET['id']) && isset($_GET['img'])) {

 $_SESSION['commcanvasloc'][] = array('userid'=>$_GET['id'], 'image'=>$_GET['img']);

 echo '<a target="_blank" href="../dump/'.$_GET["img"].'" alt="go to image" title="click to view image"> See
 Image</a>';

}

?>
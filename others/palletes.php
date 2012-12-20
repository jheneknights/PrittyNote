<?php

/**
 * Created by Eugene Mutai
 * Date: 9/26/12
 * Time: 9:01 AM
 * Description: List of Pallets to used in stickinote;
 */


$palletes = array(
	"Pallette"=>array(
		"A New Life"=>array("fe7e0cd", "46b8b2", "f99384"),
		"Hug Me Maybe"=>array("f1e9c2", "983e26", "88846b"),
		"Only You"=>array("e6c996", "77664e", "cf1902"),
		"Soldier"=>array("655c45", "ccb07e", "e9e2c7"),
		"Eat Cake"=>array("f8ca00", "774f38", "e08e79"),
		"Confusion"=>array("f8ca00", "8a9b0f", "bd1550"),
		"Cifuel"=>array("413e4a", "b38184", "f7e4be"),
		"Your Beautiful"=>array("64908a", "e8caa4", "cc2a41"),
		"Fresh Cut"=>array("8fbe00", "f9f2e7", "40c0cb"),
		"Dream in Color"=>array("519548", "bef202", "eafde6"),
		"Fresh Kiss"=>array("412e28", "b3204d", "d1c089"),
		"Chocolate Cream"=>array("a37e58", "fbcfcf", "fcfbe3"),
		"Alarming"=>array("fa023c", "c8ff00", "4b000f"),
		"Beautiful Day"=>array("ccf390", "ff003d", "f7c41f"),
		"Autumn Begins"=>array("c8ad66", "7c2700", "f1b85f"),
		"Dream Street"=>array("cac8bc", "eae5d2", "f26882"),
		"Thunder Bear"=>array("ffffce", "1bc6b7", "97030a"),
		"Best Friends"=>array("f1e9c2", "88846be", "983e26"),
		"StickiNote"=>array("fef070", "666666", "cc0000"),
		"Evil Within"=>array("292929", "999999", "da0230"),
		"Tiger in the Sun"=>array("724a0f", "ebd723", "c4c3c1"),
		"Wheatfield"=>array("fff0a3", "f03a5a", "a33c0e")
	)
) ;

//now sort the  Array alphabetically
$sorted = ksort($palletes["Pallette"]);
echo json_encode($palletes);
//var_dump($palletes);

?>
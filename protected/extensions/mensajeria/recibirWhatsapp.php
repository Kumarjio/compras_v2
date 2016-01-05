<?php
ini_set("display_errors","on");
include("src/whatsprot.class.php");
$username = "573015189080";
$nickname = "Admisiones Clinica San Diego";
$password = "M2WFAaP3/q57M8HB4cTPYNkPfP8="; // The one we got registering the number
$debug    = false;
$log      = true;
$w        = new WhatsProt($username, $nickname, $debug, $log);
$w->Connect();
$w->LoginWithPassword($password);
die("jajajajajajaja");
$w->PollMessage();
while(true){
	$msgs = $w->getMessages();
	foreach($msgs as $key){
		print_r($key);
		echo "<salto>";
		echo $key->_attributeHash."++++++++++++++++++++++++++";
		echo "<fin salto>";
	}
}

?>
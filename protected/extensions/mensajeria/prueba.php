<?php
ini_set("display_errors","on");
include("src/whatsprot.class.php");
$username = "573015189080";
$nickname = "Admisiones Clinica San Diego";
$password = "M2WFAaP3/q57M8HB4cTPYNkPfP8="; // The one we got registering the number
$debug    = false;
$log      = false;
$w        = new WhatsProt($username, $nickname, $debug, $log);
$w->connect(); 
$w->loginWithPassword($password);
/*
$w->sendMessage($target , $message);
echo "Fin del proceso";*/


//'573103965585'->Don Hernan
/*$target = array('573193970237','573174797541','573124868812','573217854453','573204391244');
$message = 'Hola, este es un mensaje de prueba, enviado con el numero de Wilson desde el servidor Amazon EC2 creado para la clinica San Diego';
for($a=0;$a<count($target);$a++){
	$w->sendMessage($target[$a], $message);	
}*/
/*$targets = array("573193970237","573174797541","573124868812","573217854453","573204391244");
$message = "Mensaje de prueba enviado a varios numeros en simultanea";
$w->sendBroadcastMessage($targets, $message);*/
$target = '573102996195';
$pathToVideo = "/tmp/profile_mini.jpg"; // This could be url or path to video.
$caption = "La foto del amor de su vida";
$fsize=0;
$fhash="";
$w->sendMessageImage($target, $pathToVideo, false, $fsize, $fhash, $caption);
$w->pollMessage();
echo "OK";
?>
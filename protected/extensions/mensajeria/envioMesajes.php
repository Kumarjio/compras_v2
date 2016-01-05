<?php
include("whatsapp.class.php");
$msg = new whatsapp();
$telefonos = array('573204391244','573193970237');
$msgs = "Hola, este es un mensaje de prueba, por favor has clic en el siguiente vinculo http://ec2-54-94-148-171.sa-east-1.compute.amazonaws.com/";
$res = $msg->enviaMsgText($telefonos,$msgs);
echo $res."<br>";
$res2 = $msg->enviaMsgFile($telefonos,'/tmp/sandiego_logo.png','Este es el logo de la clinica San Diego');
echo $res2."<br>";
?>
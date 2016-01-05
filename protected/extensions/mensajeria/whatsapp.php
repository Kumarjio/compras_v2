<?php
require_once(dirname(__FILE__)."/src/whatsprot.class.php");
class whatsapp extends WhatsProt{
	
	 function whatsapp(){
		$this->__construct("573015189080","Admisiones Clinica San Diego",false,false);
		$this->connect(); 
		$this->loginWithPassword("M2WFAaP3/q57M8HB4cTPYNkPfP8="); 
	} 

	function enviaMsgText($phones=array(),$msg=''){
		try{
			for($a=0;$a<count($phones);$a++){
				$this->sendMessage($phones[$a], $msg);
			}
			return true;
		} catch(Exception $e){
			return false;
		}
	}
	
	function enviaMsgFile($phones=array(),$path,$caption){
		$fsize=0;
		$fhash="";
		$size = 5 * 1024 * 1024;
		$extOk = array('jpg', 'jpeg', 'gif', 'png');
		if(file_exists($path)){
			$tamanio = filesize($path);
			$exten   = explode(".",$path);
			$ext = strtolower(end($exten));
			if($tamanio>$size){
				$swRes = 'El tamaño del archivo excede el permitido';
			}else{
				if(in_array($ext,$extOk)){
					for($a=0;$a<count($phones);$a++){
						$this->sendMessageImage($phones[$a], $path, false, $fsize, $fhash, $caption);
						$this->pollMessage();
					}
					$swRes = 'Mensaje enviado exitosamente';
				}else{
					$swRes = 'La extension del archivo no es válida, solo use extansiones (jpg,jpeg,gif,png)';
				}
			}
		}else{
			$swRes = 'El archivo ingresado no tiene una ruta válida';
		}
		return $swRes;
	} 
	
}
?>
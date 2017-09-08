<?php
class AlertasCommand extends CConsoleCommand
{
	public $mail = "santios@imagineltda.com";
	public $notificarEn = array(
			'swViaje/primera_instancia',
			'swViaje/segunda_instancia',
			'swViaje/cotizacion_aviatur',
			'swViaje/validacion_cotizacion',
			'swViaje/itinerario_no_disponible',
			'swViaje/emision_aviatur',
			'swViaje/emitido_aviatur',
			'swViaje/revision_operaciones'
		);
	
	public function actionIndex(){
		$criteria = new CDbCriteria;
		$criteria->addInCondition('paso_wf', $this->notificarEn);
		$viajes = Viaje::model()->findAll();

		foreach($viajes as $v){
			$it = Itinerario::model()->primerItinerario($v->id);
			$urgente = $v->esUrgente();
			if($urgente){
				$pluralize = ($urgente == 1)?"día":"días";
				$asunto = "APROBACIÓN REQUERIDA - El viaje ".$v->id." inicia su itinerario en ".$urgente." ".$pluralize;
				$body = $this->render("_emailview", array('model'=>$v, 'url' => $this->getUrl($v->id),'recordatorio' => true));
				$ok = Yii::app()->mailer->enviarCorreo($v->usuarioActual->email,$asunto, $body);	
			}
		}
	}

	public function getUrl($viaje){

		if(isset(Yii::app()->params->test) && Yii::app()->params->test == 1){
			$host = "http://viajes.imagine.corp/";
			$script = "index-test.php";
		}else{
			$host = "https://viajes.tuya.corp/";
			$script = "index.php";
		}
		$url = sprintf("%s%s/viaje/update?id=%d",
      	 				$host, 
      	 	            $script,
      	 	            $viaje);

		return $url;
	}

	private function render($template, array $data = array()){
    	$path = Yii::getPathOfAlias('application.views.viaje').'/'.$template.'.php';
    	if(!file_exists($path)) throw new Exception('Template '.$path.' does not exist.');
    	return $this->renderFile($path, $data, true);
	}
}
?>


<?php

class ApiController extends CController
{
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('viaje'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionViaje()
	{
		$operacion = $_POST['subject']['tipo'];
		$content = $_POST['content'];
		$viaje = $_POST['subject']['viaje'];
		$fecha = $_POST['date-recieved'];
		$adjuntos = $_POST['attachments'];


		$viajeObj = Viaje::model()->findByPk($viaje);
		if($viajeObj == null)
			$this->_sendResponse(500,"El viaje $viaje no existe");

		if($operacion == "cot"){
			$res = $this->_nuevaCotizacion($viaje, $fecha, $content);
		}

		if($operacion == "emi"){
			
			$res = $this->_nuevaEmision($viaje, $fecha, $content,$adjuntos);
		}

		if($operacion == "res"){
			$res = $this->_nuevoHotel($viaje, $fecha, $content,$adjuntos);
		}


	}

	private function _nuevaCotizacion($viaje, $fecha, $content){
		$viajeobj = Viaje::model()->validarEnEsperaCotizacion($viaje);
		$pars=Parametros::model()->findAll();
		
		if($viajeobj){
			Yii::app()->user->setState('from_email',true);
			$cotizacion = new CotizacionViaje;
			$cotizacion->viaje = $viaje;
			$cotizacion->remitente = "nobody@nobody.com";
			$cotizacion->cuerpo = $content;
			$cotizacion->fecha_mensaje = $fecha;
			
			$viajeobj->paso_wf = "swViaje/validacion_cotizacion";	
				
			
			if($cotizacion->save() && $viajeobj->save()){
				Yii::app()->user->setState('from_email',false);
			}else{
				$this->_sendResponse(500, print_r($cotizacion->getErrors()) . " " . print_r($viajeobj->getErrors()));	
			}
				
		}else{
			$this->_sendResponse(500, "El viaje $viaje no está esperando una cotización");
		}

		$this->_sendResponse(200, "ok");
	}
 
	private function _nuevaEmision($viaje, $fecha, $content, $adjuntos){
		$viajeobj =Viaje::model()->validarEnEsperaEmision($viaje);

		if($viajeobj){
			Yii::app()->user->setState('from_email',true);
			
			$current_cot = $viajeobj->cotizacionViajes[0];
			$cotizacion = CotizacionViaje::model()->findByPk($current_cot->id);
			if(!$cotizacion)
				$this->_sendResponse(500, "No se encontró una cotización para el viaje $viaje");

			$cotizacion->respuesta_emision = $content;
			$cotizacion->fecha_respuesta_emision = $fecha;
			
			$viajeobj->paso_wf = "swViaje/emitido_aviatur";
			
			if($cotizacion->save() && $viajeobj->save()){
				$this->_procesarAdjuntos($adjuntos, $cotizacion->id);
				Yii::app()->user->setState('from_email',false);
			}else{
				$this->_sendResponse(500, print_r($cotizacion->getErrors()) . " " . print_r($viajeobj->getErrors()));	
			}
				
		}else{
			$this->_sendResponse(500, "El viaje $viaje no está esperando una emisión");
		}

		$this->_sendResponse(200, "ok");

	}

	private function _nuevoHotel($viaje, $fecha, $content, $adjuntos){
		$viajeobj =Viaje::model()->findByPk($viaje);

		if($viajeobj){
			
			$current_cot = $viajeobj->emisionHoteles[0];
			$cotizacion = EmisionHotel::model()->findByPk($current_cot->id);
			if(!$cotizacion)
				$this->_sendResponse(500, "No se espera una emisión de hotel para el viaje $viaje");

			$cotizacion->cuerpo = $content;
			$cotizacion->fecha_mensaje = $fecha;
			
			
			if($cotizacion->save()){
				$this->_procesarAdjuntosEmision($adjuntos, $cotizacion->id);
			}else{
				$this->_sendResponse(500, print_r($cotizacion->getErrors()) . " " . print_r($viajeobj->getErrors()));	
			}
				
		}else{
			$this->_sendResponse(500, "No se encontró el viaje");
		}

		$this->_sendResponse(200, "ok");

	}

	private function _procesarAdjuntos($adjuntos, $cotizacion){
		if($adjuntos != ""){
			$files = explode("|", $adjuntos);
			foreach ($files as $file) {
				$adj = new CotizacionViajeAdjuntos;
				$adj->id_cotizacion = $cotizacion;
				$adj->archivo = $file;
				$adj->nombre_archivo = basename($file);
				$adj->save();
			}
		}
	}

	private function _procesarAdjuntosEmision($adjuntos, $emision){
		if($adjuntos != ""){
			$files = explode("|", $adjuntos);
			foreach ($files as $file) {
				$adj = new EmisionHotelAdjuntos;
				$adj->id_emision = $emision;
				$adj->archivo = $file;
				$adj->nombre_archivo = basename($file);
				$adj->save();
			}
		}
	}

	private function _sendResponse($status = 200, $message)
	{
	    $status_header = 'HTTP/1.1 ' . $status . ' ' .  $this->_getStatusCodeMessage($status);;
	    header($status_header);
	    header('Content-type: text/plain');	

	    echo $message;
	    Yii::app()->end();
	}

	private function _getStatusCodeMessage($status)
	{
	    $codes = Array(
	        200 => 'OK',
	        400 => 'Bad Request',
	        401 => 'Unauthorized',
	        402 => 'Payment Required',
	        403 => 'Forbidden',
	        404 => 'Not Found',
	        500 => 'Internal Server Error',
	        501 => 'Not Implemented',
	    );
	    return (isset($codes[$status])) ? $codes[$status] : '';
	}

}
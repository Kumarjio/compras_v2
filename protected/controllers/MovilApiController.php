<?php

class MovilApiController extends CController
{
	// Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers 
     */
    Const APPLICATION_ID = 'ASCCPE';
 
    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';
    /**
     * @return array action filters
     */
    public function filters()
    {
            return array();
    }


    //compras
 	public function actionEstadosCompras(){
 		$model = Orden::model()->findByPk($_GET['orden']);
 		//print_r($model);die;
 		Yii::app()->user->setState("id_empleado", $_GET['empleado']);
 		$empleado = Empleados::model()->findByPk($_GET['empleado']);

 		if($empleado->contratoses[0]->idCargo->es_jefe == "Si")
 			Yii::app()->user->setState("jefe", true);
 		elseif($empleado->contratoses[0]->idCargo->es_gerente == "Si")
 			Yii::app()->user->setState('gerente', true);
 		elseif($empleado->id == 32)
			Yii::app()->user->setState('jefe_compras', true);

 		$flujo = SWHelper::nextStatuslistData($model);
 		$prox_estados = $this->armarCampoEditable($model, 'paso_wf', 'select', "Proximo Estado", $flujo);
 		$this->_sendResponse(200, CJSON::encode($prox_estados) );
 	}

    public function actionGuardarOrden() {    // Importante 1

    	if(isset($_GET['orden'])){

	    	$postdata = file_get_contents("php://input");

	    	$postdata = CJSON::decode($postdata);

	    	// Captura y busca orden

	    	$orden =  $_GET['orden'];

	    	$model = Orden::model()->findByPk($_GET['orden']);

	    	print_r("orden: ".$orden." ");

	    	// Captura y busca empleado

	    	Yii::app()->user->setState("id_empleado", $_GET['empleado']);

	    	$empleado = Empleados::model()->findByPk($_GET['empleado']);

	    	print_r("empleado: ".$_GET['empleado']." ");

	    	if($empleado->contratoses[0]->idCargo->es_jefe == "Si")
	 			Yii::app()->user->setState("jefe", true); 

	 		elseif($empleado->contratoses[0]->idCargo->es_gerente == "Si")
	 			Yii::app()->user->setState('gerente', true);

	 		elseif($empleado->id == 32)
				Yii::app()->user->setState('jefe_compras', true);

			//$flujo = SWHelper::nextStatuslistData($model);

	    	/*if(empty($postdata)){
	    		$this->_sendResponse(200, CJSON::encode(array('status'=>'error', 'mensaje'=>"sin dato alguno")));
	    	}*/

	    	$model->paso_wf = $postdata['estados'];

	    	print_r($postdata['estados']);
	    	$model->observacion = $postdata['observacion'];

	    	print_r($postdata['observacion']);


	    	if($model->save()){
		    	$this->_sendResponse(200, CJSON::encode(array('status'=>'success', 'mensaje'=>'Registro guardado Correctamente')));

	    	}else{
	    		$this->_sendResponse(200, CJSON::encode(array('status'=>'error', 'mensaje'=>$model->getErrors())));	
	    	}
	    }
    	
    }

 	//viajes
    public function actionAutenticar(){
    	if(isset($_GET['usuario'])){
    		$empleado = Empleados::model()->findByPk($_GET['usuario']);
    		if($empleado){
    			$this->_sendResponse(200, CJSON::encode(array("status"=>"success", "mensaje"=>"Aprobado")));
    		}
    		else {
    			$this->_sendResponse(200, CJSON::encode(array("status"=>"error", "mensaje"=>"No existe usuario")) );
    		}
    	}
    }

    public function actionGuardarViaje() {
    	if(isset($_GET['viaje'])){
	    	$postdata = file_get_contents("php://input");
	    	$postdata = CJSON::decode($postdata);
	    	$viaje = Viaje::model()->findByPk($_GET['viaje']);
	    	foreach ($postdata as $key => $value) {
	    		$atributo = $value['atributo'];
	    		$viaje->$atributo = $value['valor'];
	    	}
	    	if($viaje->save()){
	    		$this->_sendResponse(200, CJSON::encode(array("status"=>"success", "mensaje"=>"Viaje Guardado Correctamente")));
	    	}else {
	    		$this->_sendResponse(200, CJSON::encode(array("status"=>"error", "mensaje"=>$viaje->getErrors())));
	    	}
    	}
    }

 	public function actionViajesAsignados(){
 		if(isset($_GET['usuario'])){
 			//print_r(include(dirname(__FILE__)."/../models/workflows/swViaje.php"));die;
 			$usuario = Empleados::model()->findByPk($_GET['usuario']);
 			if(!$usuario){
 				$this->_sendResponse(200, CJSON::encode(array("status"=>"error", "mensaje"=>"no existe usuario")) );
 			}
 			$criteria=new CDbCriteria;
			$criteria->condition = "usuario_actual = :u and paso_wf not in ( :paso, :paso2)  and archivado = :a";
			$criteria->params = array(':u' => $_GET['usuario'],
								  ':paso' => "swViaje/vencido",
								  ':paso2' => "swViaje/solicitar_viaje",
								  ':a' => '0');
			$this->codificarYEnviar($criteria);
 		}
 	}

 	public function actionViajesSolicitados(){
 		if(isset($_GET['usuario'])){
 			$usuario = Empleados::model()->findByPk($_GET['usuario']);
 			if(!$usuario){
 				$this->_sendResponse(200, CJSON::encode(array("status"=>"error", "Mensaje"=>"no existe usuario")) );
 			}
			$criteria=new CDbCriteria;
			$criteria->compare('solicitante', $_GET['usuario'] );
			$this->codificarYEnviar($criteria);
 		}
 	}

 	private function codificarYEnviar($criteria){
			$model = CJSON::decode(CJSON::encode(InformeViajes::model()->findAll($criteria)));
 			$this->insertarPasoLabel($model);
 			$this->_sendResponse(200, CJSON::encode($model) );
 	}

 	private function insertarPasoLabel(&$model){
 		$flujo = include(dirname(__FILE__)."/../models/workflows/swViaje.php");
 		$flujo = $flujo['node'];
 		for ($i=0; $i < count($model); $i++) {
 			foreach ($flujo as $nodo) {
 				if(isset($model[$i]['paso_wf'])){
	 				$paso = explode('/', $model[$i]['paso_wf']);
	 				if($nodo['id'] == $paso[1]){
	 					$model[$i]['paso_actual'] = $nodo['label'];
	 				}
	 			}
	 			elseif (isset($model[$i]['estado_nuevo'])) {
	 				$paso_nuevo = explode('/', $model[$i]['estado_nuevo']);
	 				$paso_anterior = explode('/', $model[$i]['estado_anterior']);
	 				if($nodo['id'] == $paso_nuevo[1]){
	 					$model[$i]['paso_nuevo'] = $nodo['label'];
	 				}
	 				elseif ($nodo['id'] == $paso_anterior[1]) {
	 					$model[$i]['paso_anterior'] = $nodo['label'];
	 				}
	 			}
 			}
 			if(isset($model[$i]['usuario_anterior']) || isset($model[$i]['usuario_nuevo'])){
 				$model[$i]['usuario_anterior_nombre'] = Empleados::model()->findByPk($model[$i]['usuario_anterior'])->nombre_completo;
 				$model[$i]['usuario_nuevo_nombre'] = Empleados::model()->findByPk($model[$i]['usuario_nuevo'])->nombre_completo;
 			}
 		}
 		
 	}

 	private function armarCampo(&$arreglo, $model, $atributo, $valor=''){
 		$nodo['atributo'] = $atributo;
 		$nodo['label'] = $model->getAttributeLabel($atributo);
 		if($valor != '')
 			$nodo['valor'] = $valor;
 		else
 			$nodo['valor'] = $model->$atributo;
 		array_push($arreglo['info'], $nodo);
 	}

 	private function crearItem(&$item, $nombre){
		$item['nombre'] = $nombre;
		$item['info'] = array();
 	}

 	private function armarCampoEditable($model, $atributo, $tipo, $label = '', $info = ''){
 		if($label == '')
 			$campo['label'] = $model->getAttributeLabel($atributo);
 		else
			$campo['label'] = $label;
		$campo['atributo'] = $atributo;
		$campo['para_for'] = false;
		if($tipo == 'select'){
			$campo['info'] = array();
			foreach ($info as $key => $value) {
				$item['value'] = $key;
				$item['label'] = $value;
				array_push($campo['info'], $item);
 			}
 			$campo['para_for'] = true;
		}else
			$campo['info'] = $model->$atributo;
		$campo['tipo'] = $tipo;
		
		return $campo;
 	}

 	public function actionVerViaje(){
 		if($_GET['viaje']){

 			$model = Viaje::model()->findByPk($_GET['viaje']);
 			Yii::app()->user->setState("id_empleado", $_GET['usuario']);
 			$flujo = SWHelper::nextStatuslistData($model);
 			$respuesta['items_acordion'] = array();
 			$respuesta['items_modales'] = array();
 			$respuesta['campos'] = array();

 			$this->crearItem($basicos, "Datos Básicos");

 			$this->armarCampo($basicos, $model, 'id');
 			$this->armarCampo($basicos, $model, 'paso_wf', $model->labelEstado( $model->paso_wf ));
 			$this->armarCampo($basicos, $model, 'centro_costos', $model->centroCostos->nombre);
 			$this->armarCampo($basicos, $model, 'motivo');
 			array_push($respuesta['items_acordion'], $basicos);

			$this->crearItem($info_viajero, "Información del Viajero");
 			if($model->id_viajero_externo){

 				$this->armarCampo($info_viajero, $model->idViajeroExterno, 'cedula');
 				$this->armarCampo($info_viajero, $model->idViajeroExterno, 'nombre_completo');
 				$this->armarCampo($info_viajero, $model->idViajeroExterno, 'telefono');
 				$this->armarCampo($info_viajero, $model->idViajeroExterno, 'celular');
 				$this->armarCampo($info_viajero, $model->idViajeroExterno, 'viajero_frecuente');
 			}
 			else {
 				$this->armarCampo($info_viajero, $model->idViajeroEmpleado, 'numero_identificacion');
 				$this->armarCampo($info_viajero, $model->idViajeroEmpleado, 'nombre_completo');
 				$this->armarCampo($info_viajero, $model->idViajeroEmpleado->contactoEmpleadoses[0], 'telefono');
 				$this->armarCampo($info_viajero, $model->idViajeroEmpleado->contactoEmpleadoses[0], 'celular');
 				$this->armarCampo($info_viajero, $model->idViajeroEmpleado->contactoEmpleadoses[0], 'viajero_frecuente');
 			}
 			array_push($respuesta['items_acordion'], $info_viajero);

 			$this->crearItem($itinerario, "Itinerario");
 			foreach ($model->itinerarios as $key => $itine) {
 				$this->crearItem($itinerario['info'][$key], "Itinerario # ".($key+1));
 				$this->armarCampo($itinerario['info'][$key], $itine, 'tipo_transporte', $itine->tipoTransporte->nombre);
 				$this->armarCampo($itinerario['info'][$key], $itine, 'ciudad_origen', $itine->ciudadOrigen->nombre);
 				$this->armarCampo($itinerario['info'][$key], $itine, 'ciudad_destino', $itine->ciudadDestino->nombre);
 				$this->armarCampo($itinerario['info'][$key], $itine, 'fecha_viaje');
 				$this->armarCampo($itinerario['info'][$key], $itine, 'direccion_recoger_origen');
 				$this->armarCampo($itinerario['info'][$key], $itine, 'direccion_recoger_destino');
 				$this->armarCampo($itinerario['info'][$key], $itine, 'requiere_transporte', ($itine->requiere_transporte==1)?"Si":"No");
 				$this->armarCampo($itinerario['info'][$key], $itine, 'requiere_alojamiento', ($itine->requiere_alojamiento==1)?"Si":"No");
 				$this->armarCampo($itinerario['info'][$key], $itine, 'cancelado', ($itine->cancelado==1)?"Si":"No");
 			}	
 			array_push($respuesta['items_acordion'], $itinerario);


			$this->crearItem($gastos, "Gastos Adicionales");
			$this->crearItem($ga, "Gastos de Alimentación");
 			$data = GastosAlimentacion::model()->findAllByAttributes(array('id_viaje'=>$model->id));
 			foreach ($data as $key => $ali) {
 				$this->crearItem($ga['info'][$key], "Alimentación # ".($key+1));
 				$this->armarCampo($ga['info'][$key], $ali, 'fecha');
 				$this->armarCampo($ga['info'][$key], $ali, 'id_tipo_alimentacion', TipoAlimentacion::model()->findByPk($ali->id_tipo_alimentacion)->nombre);
 				$this->armarCampo($ga['info'][$key], $ali, 'cantidad');
 				$this->armarCampo($ga['info'][$key], $ali, 'valor');
 			}
 			array_push($gastos['info'], $ga);

			$this->crearItem($gt, "Gastos de Transporte");
 			$data = GastosTransporte::model()->findAllByAttributes(array('id_viaje'=>$model->id));
 			foreach ($data as $key => $trans) {
 				$this->crearItem($gt['info'][$key], "Transporte # ".($key+1));
 				$this->armarCampo($gt['info'][$key], $trans, 'fecha');
 				$this->armarCampo($gt['info'][$key], $trans, 'origen', Ciudad::model()->findByPk($trans->origen)->nombre);
 				$this->armarCampo($gt['info'][$key], $trans, 'destino', Ciudad::model()->findByPk($trans->destino)->nombre);
 				$this->armarCampo($gt['info'][$key], $trans, 'valor');
 			}
 			array_push($gastos['info'], $gt);
 			
			$this->crearItem($go, "Otros Gastos");
 			$data = GastosOtros::model()->findAllByAttributes(array('id_viaje'=>$model->id));
 			foreach ($data as $key => $otros) {
 				$this->crearItem($go['info'][$key], "Otros # ".($key+1));
 				$this->armarCampo($go['info'][$key], $otros, 'detalle');
 				$this->armarCampo($go['info'][$key], $otros, 'valor');
 			}
 			array_push($gastos['info'], $go);
 			array_push($respuesta['items_acordion'], $gastos);

 			$prox_estados = $this->armarCampoEditable($model, 'paso_wf', 'select', "Proximo Estado", $flujo);
 			array_push($respuesta['campos'], $prox_estados);
 			$campo_observacion = $this->armarCampoEditable($model, 'observacion', 'text_area');
 			array_push($respuesta['campos'], $campo_observacion);

 			$respuesta['items_modales']['traza'] = $this->armarTraza($model->id, 'Viaje');
 			$respuesta['items_modales']['observaciones'] = $this->armarObservaciones($model->id, "Viaje");
 			$this->_sendResponse(200, CJSON::encode($respuesta) );
 		}
 	}
 	private function armarObservaciones($idModel, $modelo){
 		$observaciones = ObservacionesViajes::model()->findAllByAttributes(array('idmodel'=>$idModel, 'model'=>$modelo));
		$this->crearItem($obser, "Observaciones");
		foreach ($observaciones as $key => $obs) {
			$obser['info'][$key]['usuario'] = Empleados::model()->nombreEmpleado($obs->usuario);
			$obser['info'][$key]['estado_anterior'] = Viaje::model()->labelEstado($obs->estado_anterior);
			$obser['info'][$key]['estado_nuevo'] = Viaje::model()->labelEstado($obs->estado_nuevo);
			$obser['info'][$key]['observacion'] = $obs->observacion;
			$obser['info'][$key]['fecha'] = $obs->fecha;
		}
		return $obser;
 	}
 	private function armarTraza($idModel, $modelo){
 		$trazabilidad = TrazabilidadWfviajes::model()->findAllByAttributes(array('idmodel'=>$idModel, 'model'=>$modelo));
		$this->crearItem($traza, "Trazabilidad");
		foreach ($trazabilidad as $key => $trz) {
			$traza['info'][$key]['usuario_anterior'] = Empleados::model()->nombreEmpleado($trz->usuario_anterior);
			$traza['info'][$key]['usuario_nuevo'] = Empleados::model()->nombreEmpleado($trz->usuario_nuevo);
			$traza['info'][$key]['estado_anterior'] = $trz->labelEstadoAnterior();
			$traza['info'][$key]['estado_nuevo'] = $trz->labelEstadoNuevo();
			$traza['info'][$key]['fecha'] = $trz->fecha;
		}
		return $traza;
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

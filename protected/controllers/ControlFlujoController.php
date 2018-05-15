<?php

class ControlFlujoController extends Controller{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	//public $layout='//layouts/column2';

	/**
	* @return array action filters
	*/
	public function filters(){
		return array(
		'accessControl', // perform access control for CRUD operations
		);
	}
	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules(){
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('establecerTipologia', 'createTipologia','agregarTipologia','updateTipologia','guardarConexiones', 'deleteFlujo','inhabilitarTipologia', 'definirFlujo','usuariosFlujo','validaActividad','asignaUsuarios','validaIdActividad','validaTiempo','tiempoActividad','habilitarTipologia'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	private function crearActividad($tipologia, $actividad, $usuario = 1){
		$act_tipo = new ActividadTipologia;
		$act_tipo->id_tipologia = $tipologia;
		$act_tipo->id_actividad = $actividad;
		$act_tipo->tiempo = 0;
		if($act_tipo->save()){
			$usu_tipo = new UsuariosActividadTipologia;
			$usu_tipo->usuario = $usuario;
			$usu_tipo->id_actividad_tipologia = $act_tipo->id;
			$usu_tipo->save();
			return $act_tipo;
		}
		else
			return false;
	}

	public function actionEstablecerTipologia($tipo){
		$tipo = base64_decode($tipo);
		if(is_numeric($tipo)){
			$actividades = ActividadTipologia::model()->findAllByAttributes(array('id_tipologia'=>$tipo, 'activo'=>true));
			if(!$actividades){
				$this->crearActividad($tipo, 1);
				//$this->crearActividad($tipo, 3);
				$this->crearActividad($tipo, 20);
				
			}
			$this->render('establecer', $this->devolverFlujo($tipo));
		}else{
			$this->redirect($this->createUrl('error/index'));
		}	 
	}
	private function devolverFlujo($tipo){

		$tipologia = $tipo;
		$sumaTiempos = Tipologias::traerTiempo($tipologia);
		ActividadTipologia::guardaEstado($estado = false, $tipologia, $sumaTiempos);
		$actividades = ActividadTipologia::model()->findAllByAttributes(array('id_tipologia'=>$tipologia, 'activo'=>true));
		$flujonodos = array(); 
		$edges = array();
		$id_max = Yii::app()->db->createCommand("select max(id) from actividad_tipologia where id_tipologia = $tipologia")->queryScalar();
		if(!$id_max)
			$id_max = 0;
		$id_max_ege = Yii::app()->db->createCommand("select max(id) from relaciones where desde in (select id from actividad_tipologia where id_tipologia = $tipologia) or hasta in  (select id from actividad_tipologia where id_tipologia = $tipologia)")->queryScalar();
		if(!$id_max_ege)
			$id_max_ege = 0;
		foreach ($actividades as $ac) {
			$i = 0;
			$usuario = array();
			$nombre = "";
			$usuarios = UsuariosActividadTipologia::model()->findAllByAttributes(array('id_actividad_tipologia'=>$ac->id));
			foreach ($usuarios as $documento) {
				$usuario[$i] = $documento->usuario;
				$nombre .= ucwords(strtolower($documento->usuario0->nombres." ".$documento->usuario0->apellidos."<br>"));
				$i++;
			}
			$nodo = array(
					'id'=>$ac->id, 
					'label'=>$ac->idActividad->actividad,
					'id_actividad'=>$ac->idActividad->id,
					'title'=>$nombre,
					'color'=>($ac->idActividad->id == 1 || $ac->idActividad->id == 20) ? '#F5A9A9' : '#97C2FC',
					'usuario'=>$usuario,
					'tiempo'=>$ac->tiempo,
			);
			array_push($flujonodos, $nodo);
			foreach ($ac->relaciones as $key => $flujo) {
				$aristas = array(
					'id'=>$flujo->id, 
					'from'=>$flujo->desde, 
					'to'=>$flujo->hasta, 
					//'title'=>'algo nro '.$key,
					'arrows'=>'to'
				);
				array_push($edges, $aristas);
			}
		}
		$tiempoInterno = 0;
		foreach (Actividades::traerActividades($tipologia) as $actividad) {
			$tiempoInterno = $actividad->tiempo + $tiempoInterno;
		}
		$flujonodos = CJSON::encode($flujonodos);
		$edges = CJSON::encode($edges);
		return array(
			'flujo'=>$flujonodos,
			'edges'=>$edges,
			'id_max'=>$id_max,
			'actividades'=>$actividades,
			'id_max_ege'=>$id_max_ege,
			'tipologia'=>$tipologia,
			'sumaTiempos'=>$sumaTiempos,
			'tiempoInterno'=>$tiempoInterno,
		);
	}

	public function actionCreateTipologia(){
		$model = new Tipologias('search');
		if(isset($_POST['Tipologias'])){
			$model->attributes = $_POST['Tipologias'];
		}
		$this->render('_tipologias_create',array(
			'model'=>$model
		));
	}

	// Codigo anterior 

	public function actionAgregarTipologia(){

		if(Yii::App()->request->isAjaxRequest){
			$model = new Tipologias;
			$aux = true;
			if(isset($_POST['Tipologias'])){
				$model->attributes = $_POST['Tipologias'];
				if($model->save()){
					$plantilla_tipologia = new PlantillaTipologia;
					$plantilla_tipologia->id_plantilla = "1";
					$plantilla_tipologia->id_tipologia = $model->id;
					$plantilla_tipologia->save();
				}else{
					$aux = false;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_nuevaTipologia', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_nuevaTipologia', array('model' => $model), true, true)));
			}
		}
	}
	public function actionUpdateTipologia(){

		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['Tipologias'])){
				$model=Tipologias::model()->findByPk($_POST['Tipologias']['id']);
				$model->attributes = $_POST['Tipologias'];
				if(!$model->save()){
					$aux = false;
				}
			}else{
				$id = $_POST["id"];
				$model=Tipologias::model()->findByPk($id);
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_updateTipologia', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_updateTipologia', array('model' => $model), true, true)));
			}
		}
	}

	public function actionGuardarConexiones(){
		$tipologia = base64_decode($_POST['tipologia']);
		$actividades = $_POST['nodos'];
		$relaciones = $_POST['enlaces'];
		$sumaTiempos = $_POST['sumaTiempos'];
		$cambios_nodos = array();

		try {
			$tr = Yii::app()->db->beginTransaction();
			
			foreach ($actividades as $actividad){
				if( $actividad['editado'] == 'Si' || $actividad['nuevo'] == 'Si' ){
					$actividad_tipologia = $actividad['id'];
					$id_actividad = $actividad['id_actividad'];
					$tiempoGestion = $actividad['tiempo'];

					if( $actividad['nuevo'] == 'Si' ){
						$act_tipo = new ActividadTipologia;
					}else{
						$act_tipo = ActividadTipologia::model()->findByPk($actividad_tipologia);
					}
					$act_tipo->id_tipologia = $tipologia;
					$act_tipo->id_actividad = $id_actividad;
					$act_tipo->tiempo = $tiempoGestion;
					$act_tipo->activo = true;

					if($act_tipo->save()){
						//Guarda cambios nodos
						if( $actividad['nuevo'] == 'Si' )
							$cambios_nodos[$actividad_tipologia] = $act_tipo->id;
						//Valida si ActividadTipologia trae usuarios y los guarda
						if( !empty($actividad['usuario']) ){
							$auxUsuarios = array();
							//$delUsers = UsuariosActividadTipologia::model()->deleteAll("where id_actividad_tipologia = :t)", array(':t'=>$act_tipo->id));
							foreach ($actividad['usuario'] as $usuario){
								$auxUsuarios[] = $usuario;
								//var_dump($act_tipo->getAttributes());
								if( !ActividadTipologia::cargaUsuario($usuario, $act_tipo->id) ){
									//error al guardar usuario
									echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al guardar usuario.</h5>" ));
								}
							}
							//Elimina usuarios que ya no estan en la ActividadTipologia
							$criteriaDel = new CDbCriteria;
							$criteriaDel->addCondition('id_actividad_tipologia = '.$act_tipo->id);
							$criteriaDel->addNotInCondition('usuario',$auxUsuarios);
							$delUsuarios = UsuariosActividadTipologia::model()->deleteAll($criteriaDel);
						}
					}else{
						//No guarda ActividadTipologia
						echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al guardar la actividad.</h5>" ));
					}
				}
			}

			$cuantos = Relaciones::model()->deleteAll("desde in (select id from actividad_tipologia where id_tipologia = :t) or hasta  in (select id from actividad_tipologia where id_tipologia = :t)", array(':t'=>$tipologia));

			foreach($relaciones as $relacion){
				if(!empty($cambios_nodos[ $relacion['from'] ] )){
					$relacion['from'] = $cambios_nodos[ $relacion['from'] ];
				}
				if(!empty($cambios_nodos[ $relacion['to'] ] )){
					$relacion['to'] = $cambios_nodos[ $relacion['to'] ];
				}

				$modelRelacion = new Relaciones;	
				$modelRelacion->desde = $relacion['from'];
				$modelRelacion->hasta = $relacion['to'];
				if(!$modelRelacion->save()){
					//No guarda la relación
					echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al guardar la relación.</h5>" ));
				}
			}
			$tr->commit();
			//$validaFlujo = $this->validarFlujo($tipologia);
			$flujo_completo = $this->devolverFlujo($tipologia);
			ActividadTipologia::guardaEstado($estado = true, $tipologia, $sumaTiempos);
			$flujo_completo['flujo'] = CJSON::decode($flujo_completo['flujo']);
			$flujo_completo['edges'] = CJSON::decode($flujo_completo['edges']);
			echo CJSON::encode(array('status'=>'success', 'content' => $flujo_completo));

		} catch (Exception $e) {	
			$tr->rollback();	
			//echo CJSON::encode(array('status'=>'error', 'content' => $e ));
		}
	}
	public function actionDeleteFlujo(){
		$flujo = ActividadTipologia::model()->findByAttributes(array('id'=>$_POST['nodo'],'id_tipologia'=>base64_decode($_POST['tipologia'])));
		if($flujo){
			$flujo->activo = false;
			//buscar en relaciones todo lo q en desde este igual a post nodo y en to este igual a post nodo y eliminar
			if($flujo->save()){
				foreach ($flujo->relaciones as $rd) {
					$rd->delete();
				}
				foreach ($flujo->relaciones1 as $rh) {
					$rh->delete();
				}
				//Elimina usuarios de la ActividadTipologia
				$delUsuarios = UsuariosActividadTipologia::model()->deleteAllByAttributes(array('id_actividad_tipologia'=>$flujo->id));
				$delActividad = ActividadTipologia::model()->deleteAllByAttributes(array('id'=>$flujo->id));

				echo CJSON::encode(array('status'=>'success', 'content' => 'Eliminado Correctamente'));	
			}
			else
				echo CJSON::encode(array('status'=>'error', 'content' => 'No fue posible eliminar'));	

		}
		else{
			echo CJSON::encode(array('status'=>'success', 'content' => 'No se encontro nada'));	

		}
	}
	private function validarFlujo($tipologia){
		//$tipologia = base64_decode($_POST['tipologia']);
		$data = ActividadTipologia::validaCierreFlujo($tipologia);
		if($data){
			$aristas = ActividadTipologia::validaAristasFlujo($data, $tipologia);
			if($aristas){
				//$circulares = ActividadTipologia::validaFlujoCircular($data);
				return array('status'=>'success', 'content' => "<h5 align='center'>Flujo guardado con exito!.</h5>");
			}else{
				return array('status'=>'error', 'content' => "<h5 align='center' class='red'>Todas las actividades deben llegar al cierre de caso.</h5>");
			}
		}else{
			return array('status'=>'error', 'content' => "<h5 align='center' class='red'>Falta agregar el cierre de flujo.</h5>");
		}
	}
	public function actionInhabilitarTipologia(){
		if(Yii::App()->request->isAjaxRequest){
			if($_POST['id']){
				$id = $_POST['id'];
				$model=Tipologias::model()->findByPk($id);
				$model->activa = false;
				if($model->save()){
					echo CJSON::encode(array('status'=>'success', 'content' => "<h5 align='center'>Tipologia inhabilitada.</h5>"));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al inhabilitar tipologia.</h5>"));
				}
			}
		}
	}
	public function actionHabilitarTipologia(){
		if(Yii::App()->request->isAjaxRequest){
			if($_POST['id']){
				$id = $_POST['id'];
				$model=Tipologias::model()->findByPk($id);
				$model->activa = true;
				if($model->save()){
					echo CJSON::encode(array('status'=>'success', 'content' => "<h5 align='center'>Tipologia Habilitada.</h5>"));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al Habilitar tipologia.</h5>"));
				}
			}
		}
	}
	public function actionValidaActividad(){
		$tipologia = base64_decode($_POST['tipologia']);
		$consulta = Tipologias::model()->findByAttributes(array('id'=>$tipologia,'en_espera'=>true));
		if($consulta){
			echo CJSON::encode(array('status'=>'success'));	
		}else{
			echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Debe guardar cambios para poder definir.</h5>"));
		}
	}
	public function actionDefinirFlujo(){
		$tipologia = base64_decode($_POST['tipologia']);
		$model=Tipologias::model()->findByPk($tipologia);
		$model->operacion = true;
		if($model->save()){
			echo CJSON::encode(array('status'=>'success'));	
		}else{
			echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al querer definir el flujo.</h5>"));
		}
	
		//$validaFlujo = $this->validarFlujo($tipologia);

		/*if($validaFlujo["status"] == "success"){
			$actualiza_tipologia = Tipologias::model()->findByPk($tipologia);
			$actualiza_tipologia->operacion = true;
			$actualiza_tipologia->save();
		}*/

		//echo CJSON::encode($validaFlujo);
	}
	public function actionUsuariosFlujo($id){
		$id = base64_decode($id);
		if(is_numeric($id)){
			$model = Tipologias::model()->findByPk($id);
			if($model){
				$modelFlujo = new ActividadTipologia('search');
				$modelFlujo->unsetAttributes();
				if(isset($_POST['ActividadTipologia'])){
					$modelFlujo->attributes = $_POST['ActividadTipologia'];
				}

				$modelFlujo->id_tipologia = $model->id;

				$this->render('usuariosFlujo',array(
					'modelFlujo'=>$modelFlujo,
					'model'=>$model
				));
			}
		}else{
			$this->redirect($this->createUrl('error/index'));
		}
	}
	public function actionAsignaUsuarios(){
		if(Yii::App()->request->isAjaxRequest){
			$model = new CargueUsuarios;

			if(isset($_POST['CargueUsuarios'])){

				$model->attributes = $_POST['CargueUsuarios'];
				if($model->validate()){
					foreach ($model->usuarios as $usuario) {
        	    		ActividadTipologia::cargaUsuario($usuario, $model->actividad_tipologia);
					}
					//Elimina usuarios que ya no estan en la ActividadTipologia
					$criteriaDel = new CDbCriteria;
					$criteriaDel->addCondition('id_actividad_tipologia = '.$model->actividad_tipologia);
					$criteriaDel->addNotInCondition('usuario',$model->usuarios);
					$delUsuarios = UsuariosActividadTipologia::model()->deleteAll($criteriaDel);

					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_usuarios_flujo', array('model' => $model), true, true)));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_usuarios_flujo', array('model' => $model), true, true)));
				}

			}else{
				$id = $_POST["id"];
				$model->actividad_tipologia = $id;

				$usuarios = array();
				$modelUser = UsuariosActividadTipologia::model()->findAllByAttributes(array("id_actividad_tipologia"=>$model->actividad_tipologia));
				
				if($modelUser){
					foreach ($modelUser as $campo){
		        		$usuarios[] = $campo->usuario;
					}
					$model->usuarios = $usuarios;
				}

				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_usuarios_flujo', array('model' => $model), true, true)));
			}
		}
	}
	public function actionValidaIdActividad(){
		if(Yii::App()->request->isAjaxRequest){
			$id = $_POST['id'];
			$consulta = ActividadTipologia::model()->findByPk($id );
			if($consulta->id_actividad == "1" || $consulta->id_actividad == "20"){
				echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>No se pueden modificar los usuarios de esta actividad.</h5>"));
			}else{
				echo CJSON::encode(array('status'=>'success'));
			}
		}
	}
	public function actionValidaTiempo(){
		if(Yii::App()->request->isAjaxRequest){
			$id = $_POST['id'];
			$consulta = ActividadTipologia::model()->findByPk($id );
			if($consulta->id_actividad == "1" || $consulta->id_actividad == "20"){
				echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>No se pueden modificar el tiempo de esta actividad.</h5>"));
			}else{
				echo CJSON::encode(array('status'=>'success'));
			}
		}
	}
	public function actionTiempoActividad(){
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['ActividadTipologia'])){
				$model=ActividadTipologia::model()->findByPk($_POST['ActividadTipologia']['id']);
				$model->attributes=$_POST['ActividadTipologia'];
				if(!$model->save()){
					$aux = false;
				}
			}else{
				$id = $_POST['id'];
				$model=ActividadTipologia::model()->findByPk($id);
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_updateTiempo', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_updateTiempo', array('model' => $model), true, true)));
			}
		}
	}
}

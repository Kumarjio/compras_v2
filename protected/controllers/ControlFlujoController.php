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
				'actions'=>array('establecerTipologia', 'createTipologia','agregarTipologia','updateTipologia','guardarConexiones', 'deleteFlujo','validarFlujo'),
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

	public function actionEstablecerTipologia($tipo){

		$this->render('establecer', $this->devolverFlujo($tipo)); 
	}

	private function devolverFlujo($tipo){

		$tipologia = $tipo;

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

			$nodo = array(
					'id'=>$ac->id, 
					'label'=>$ac->idActividad->actividad,
					'id_actividad'=>$ac->idActividad->id,
					//'title'=>'Aca van los usuarios',
					'color'=>($ac->idActividad->id == 1 || $ac->idActividad->id == 20) ? '#F5A9A9' : '#97C2FC',
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
		$flujonodos = CJSON::encode($flujonodos);
		$edges = CJSON::encode($edges);
		return array(
			'flujo'=>$flujonodos,
			'edges'=>$edges,
			'id_max'=>$id_max,
			'actividades'=>$actividades,
			'id_max_ege'=>$id_max_ege,
			'tipologia'=>$tipologia
		);
	}

	public function actionCreateTipologia(){
		$model = new Tipologias;
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
		$tipologia = $_POST['tipologia'];
		$actividades = $_POST['nodos'];
		$relaciones = $_POST['enlaces'];
		$cambios_nodos = array();
		//echo "<pre>";
		//	print_r($actividades);
		//echo "</pre>";
		try {
			$tr = Yii::app()->db->beginTransaction();
			foreach ($actividades as  $a) {
				if(isset($a['value'])){
					if($a['nuevo'] == 'Si')
						$act_tipo = new ActividadTipologia;
					elseif ($a['editado'] == 'Si') 
						$act_tipo = ActividadTipologia::model()->findByPk($a['id']);
					
					$act_tipo->id_tipologia = $tipologia;
					$act_tipo->id_actividad = $a['value'];
					$act_tipo->activo = true;
					if($act_tipo->isNewRecord){
						$act_tipo->save();
						foreach ($a['usuario'] as $usuario) {
							$usuarios = new UsuariosActividadTipologia;
							$usuarios->id_actividad_tipologia = $act_tipo->id;
							$usuarios->usuario = $usuario;
							$usuarios->save();
						}
						array_push($cambios_nodos, array('antes'=>$a['id'], 'ahora'=>$act_tipo->id));
					}else{
						$act_tipo->save();	
						$users = UsuariosActividadTipologia::model()->deleteAllByAttributes(array("id_actividad_tipologia"=>$act_tipo->id));
						foreach ($a['usuario'] as $usuario) {
							$usuarios = new UsuariosActividadTipologia;
							$usuarios->id_actividad_tipologia = $act_tipo->id;
							$usuarios->usuario = $usuario;
							$usuarios->save();
						}
					}
				}
			}
			$cuantos = Relaciones::model()->deleteAll("desde in (select id from actividad_tipologia where id_tipologia = :t) or hasta  in (select id from actividad_tipologia where id_tipologia = :t)", array(':t'=>$tipologia));
			foreach ($relaciones as $r) {

				foreach ($cambios_nodos as $cn) {
					if($cn['antes']==$r['from'])
						$r['from'] = $cn['ahora'];
					else if($cn['antes']==$r['to'])
						$r['to'] = $cn['ahora'];
				}
				$rela = new Relaciones;
				$rela->desde = $r['from'];
				$rela->hasta = $r['to'];
				if($rela->save()){
				}else{
					print_r($rela->getErrors());
				}
			}
			$tr->commit();
			$flujo_completo = $this->devolverFlujo($tipologia);
			$flujo_completo['flujo'] = CJSON::decode($flujo_completo['flujo']);
			$flujo_completo['edges'] = CJSON::decode($flujo_completo['edges']);
			echo CJSON::encode(array('status'=>'success', 'content' => $flujo_completo));
		} catch (Exception $e) {	
			$tr->rollback();	
			echo CJSON::encode(array('status'=>'error', 'content' => $e ));
		}
	}
	public function actionDeleteFlujo(){
		$flujo = ActividadTipologia::model()->findByAttributes(array('id'=>$_POST['nodo'],'id_tipologia'=>$_POST['tipologia']));
		if($flujo){
			$flujo->activo = false;
			if($flujo->save())
				echo CJSON::encode(array('status'=>'success', 'content' => 'Eliminado Correctamente'));	
			else
				echo CJSON::encode(array('status'=>'error', 'content' => 'No fue posible eliminar'));	

		}
		else{
			echo CJSON::encode(array('status'=>'success', 'content' => 'No se encontro nada'));	

		}
	}
	public function actionValidarFlujo(){
		$tipologia = $_POST['tipologia'];
		$aux = true;
		$data = ActividadTipologia::validaCierreFlujo($tipologia);
		if($data){
			$aristas = ActividadTipologia::validaAristasFlujo($data);
			if(!$aristas){
				$aux = false;
				echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Todas las actividades deben llegar al cierre de caso.</h5>"));
				//$circulares = ActividadTipologia::validaFlujoCircular($data);
			}
		}else{
			$aux = false;
			echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Falta agregar el cierre de flujo.</h5>"));
		}
		if($aux){
			echo CJSON::encode(array('status'=>'success', 'content' => "<h5 align='center'>Flujo guardado con exito!.</h5>"));
			$model=Tipologias::model()->findByPk($tipologia);

		}
	}
}

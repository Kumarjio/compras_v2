<?php

class UsuarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
        	array('booster.filters.BoosterFilter - delete')
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','verRoles','cambiarPass','inhabilitar','habilitar','valida','asignacion','validaHabilitacion','validarUpdate','validarInhabilitar','actividadTipologia','casosTutela'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		if(Yii::App()->request->isAjaxRequest){
			$model = new Usuario;
			$roles = new UsuariosRoles;
			$areas = new UsuariosAreas;
			$aux = true;
			if(isset($_POST['Usuario'])){
				$model->attributes=$_POST['Usuario'];
				$roles->attributes=$_POST['UsuariosRoles'];
				$areas->attributes=$_POST['UsuariosAreas'];
				$roles->id_usuario = $model->usuario;
				$model->usuario_creacion = Yii::app()->user->usuario;
				if($model->validate() && $roles->validate() && $areas->validate()){
					$model->contraseña = md5(trim($model->contraseña));
					$model->repetir = md5(trim($model->repetir));
					$model->setScenario('listo_guardar');
					if($model->save()){
						$roles->id_usuario = $model->id;
						$roles->save();
						foreach ($areas->id_area as $area) {
							$areas_multiples = new UsuariosAreas;
							$areas_multiples->usuario = $model->usuario;
							$areas_multiples->id_area = $area;
							$areas_multiples->save();
						}
						//$areas->usuario = $model->usuario;
						//$areas->save();
						/*foreach ($roles->id_rol as $id_rol) {
							$usuarios_roles = new UsuariosRoles;
							$usuarios_roles->id_usuario = $model->id;
	        	    		$usuarios_roles->id_rol = $id_rol;
							$usuarios_roles->save();

						}*/
					}else{
						$aux = false;
					}
				}else{
					$aux = false;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('create', array('model' => $model,'roles' => $roles,'areas' => $areas), true, true)));		
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('create', array('model' => $model,'roles' => $roles,'areas' => $areas), true, true)));
			}
		}
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['Usuario'])){
				$model=Usuario::model()->findByPk($_POST['Usuario']['id']);
				$roles = new UsuariosRoles;
				$areas = new UsuariosAreas;
				$model->attributes=$_POST['Usuario'];
				$roles->attributes=$_POST['UsuariosRoles'];
				$areas->attributes=$_POST['UsuariosAreas'];
				$roles->id_usuario = $model->usuario;
				$areas->usuario = $model->usuario;
				$model->usuario_creacion = Yii::app()->user->usuario;
				$model->setScenario('listo_guardar');
				if($model->validate() && $roles->validate() && $areas->validate()){
					if($model->save()){
						//$user = UsuariosRoles::model()->deleteAllByAttributes(array("id_usuario"=>$model->id));
						UsuariosAreas::model()->deleteAllByAttributes(array("usuario"=>$model->usuario));
						$id = UsuariosRoles::model()->findByAttributes(array("id_usuario"=>$model->id));
						$usuarios_roles=UsuariosRoles::model()->findByPk($id->id);
						$usuarios_roles->id_usuario = $model->id;
						$usuarios_roles->id_rol = $roles->id_rol;
						$usuarios_roles->save();
						foreach ($areas->id_area as $area) {
							$areas_multiples = new UsuariosAreas;
							$areas_multiples->usuario = $model->usuario;
							$areas_multiples->id_area = $area;
							$areas_multiples->save();
						}
						//$id_area = UsuariosAreas::model()->findByAttributes(array("usuario"=>$model->usuario));
						//$usuarios_areas=UsuariosAreas::model()->findByPk($id_area->id);
						//$usuarios_areas->usuario = $model->usuario;
						//$usuarios_areas->id_area = $areas->id_area;
						//$usuarios_areas->save();
						/*foreach ($roles->id_rol as $id_rol) {
							$usuarios_roles = new UsuariosRoles;
							$usuarios_roles->id_usuario = $model->id;
	        	    		$usuarios_roles->id_rol = $id_rol;
							$usuarios_roles->save();
						}*/

					}else{
						$aux = false;
					}
				}else{
					$aux = false;
				}
			}else{
				$id = $_POST["id"];
				$model=$this->loadModel($id);
				$roles = new UsuariosRoles;
				$areas = new UsuariosAreas;
				$rol = UsuariosRoles::model()->findAllByAttributes(array("id_usuario"=>$model->id));
				$area = UsuariosAreas::model()->findAllByAttributes(array("usuario"=>$model->usuario));
				//$areas= UsuariosAreas::model()->findByPk($area->id);
				$model->repetir = $model->contraseña;
				if($area){
					$valorArea = array();
					foreach ($area as $campo_area) {
						$valorArea[] = $campo_area->id_area;
					}
				}
				$areas->id_area = $valorArea;
				if($rol){
					$valor = array();
					$i = 0;
					foreach ($rol as $campo){
		        		$valor[$i] = $campo->id_rol;
		        		$i++;
					}
					$roles->id_rol = $valor;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('update', array('model' => $model,'roles' => $roles,'areas' => $areas), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('update', array('model' => $model,'roles' => $roles,'areas' => $areas), true, true)));
			}
		}
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Usuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionCambiarPass(){

		$model = Usuario::model()->findByAttributes(array('usuario'=>Yii::app()->user->usuario));
		$model->setScenario('cambio_pass');
		if(isset($_POST['Usuario'])){
			$model->attributes = $_POST['Usuario'];
			if($model->validate()){
				$model->contraseña = md5($model->contraseña);
				$model->repetir = md5($model->repetir);
				$model->setScenario('listo_guardar');
				if($model->save()){
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_cambio_exitoso', array('model' => $model), true, true)));
					exit;
				}
				else{
					
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_cambio', array('model' => $model), true, true)));
					exit;
				}
			}
			else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_cambio', array('model' => $model), true, true)));
					exit;
			}
		}
		echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_cambio', array('model' => $model), true, true)));
		exit;
	}

	public function actionInhabilitar(){		
		$model = Usuario::model()->findByPk($_POST['id']);
		$modelInhabilidad = new Inhabilidad;

		if(isset($_POST['Inhabilidad'])){
			$modelInhabilidad->attributes = $_POST['Inhabilidad'];
			$modelInhabilidad->usuario = $model->usuario;

			if($modelInhabilidad->validate()){
				$modelInhabilidad->fecha_inicio = ($modelInhabilidad->fecha_inicio != "") ? $modelInhabilidad->fecha_inicio : null;
				$modelInhabilidad->fecha_fin = ($modelInhabilidad->fecha_fin != "") ? $modelInhabilidad->fecha_fin : null;
				
				if($modelInhabilidad->save()){
					//Guarda Reemplazo
					$aux = $modelInhabilidad->generaReemplazo();					
					//InActiva usuario
					$model->activo = false;
					$model->update();

					echo CJSON::encode(array('status'=>'exitoso', 'content' => $this->renderPartial('_inhabilitado_exitoso', array('model' => $model), true, true)));
					exit;
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_inhabilitado', array('model' => $model, 'modelInhabilidad' => $modelInhabilidad), true, true)));
					exit;
				}
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_inhabilitado', array('model' => $model, 'modelInhabilidad' => $modelInhabilidad), true, true)));
				exit;
			}			
		}
		echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_inhabilitado', array('model' => $model, 'modelInhabilidad' => $modelInhabilidad), true,true), 'title'=>"<h4>Inhabilitar Usuario - ".ucwords(strtolower($model->nombres." ".$model->apellidos))."</h4>"));
		exit;
	}
	public function actionHabilitar(){
		$model = Usuario::model()->findByPk($_POST['id']);
		if($model){
			$model->activo = true;
			if($model->update()){
				$inhabilidad = Inhabilidad::model()->findByAttributes(array("usuario"=>$model->usuario, "activa"=>true));
				if($inhabilidad){
					if(!empty($inhabilidad->reemplazo)){
						$casos = AusenteTrazabilidad::model()->findAllByAttributes(array("usuario"=>$model->usuario));
						if($casos){
							foreach ($casos as $traza){
								$modelTraza = Trazabilidad::model()->findByPk($traza->id_trazabilidad);
								if($modelTraza){
									$modelTraza->user_asign = $model->usuario;
									if($modelTraza->save()){
										$traza->delete();
									}
								}
							}
						}
					}
					$inhabilidad->activa = false;
					$inhabilidad->fecha_fin = date("Y-m-d");
					if($inhabilidad->update()){
						echo CJSON::encode(array('status'=>'success'));
						exit;
					}else{
						echo CJSON::encode(array('status'=>'error'));
						exit;
					}
				}else{
					echo CJSON::encode(array('status'=>'success'));
					exit;
				}
			}else{
				echo CJSON::encode(array('status'=>'error'));
				exit;
			}
		}else{
			echo CJSON::encode(array('status'=>'error'));
			exit;
		}			
	}
	public function actionValida(){
		$model = Usuario::model()->findByPk($_POST['id']);
		if($model){
			$inhabilidad = Inhabilidad::model()->findByAttributes(array("usuario"=>$model->usuario, "activa"=>true));
			if($inhabilidad){
				echo CJSON::encode(array('msj'=>"<h5>¿Desea habilitar nuevamente a este empleado?</h5><p><br>La fecha de finalización de la inhabilidad es ".date("Y-m-d", strtotime($inhabilidad->fecha_fin))." si continua esta fecha será actualizada por la de hoy.</p>"));
				exit;
			}
		}
		echo CJSON::encode(array('msj'=>"<h5>¿Desea habilitar nuevamente a este empleado?</h5>"));
		exit;
	}
	
	protected function performAjaxValidation($model)
	{
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function ActionValidarUpdate()
	{
		if(Yii::App()->request->isAjaxRequest){
			$id = $_POST["id"];
			$model=$this->loadModel($id);
			if($model->activo){
				echo CJSON::encode(array('status'=>'success'));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>No se pueden modificar el usuario porque se encuentra inhabilitado.</h5>"));
			}
		}
	}

	public function actionValidaHabilitacion(){
		$model = TipoInhabilidad::model()->findByPk($_POST['id']);
		$validacion = array();
		if($model){
			$validacion['resultado'] = true;
			$validacion['inicio'] = $model->fecha_inicio;
			$validacion['fin'] = $model->fecha_fin;

			if($model->reemplazo){
				$totalCasos = Trazabilidad::model()->countByAttributes(array("user_asign"=>$_POST['usuario'], "estado"=>"1"));
				if($totalCasos > 0){
					$validacion['reemplazo'] = $model->reemplazo;
					$validacion['msj'] = '<i class="glyphicon glyphicon-exclamation-sign"></i> El usuario tiene activo <b>'.$totalCasos.'</b> caso(s). Debe asignar un reemplazo.';
				}else{
					$validacion['reemplazo'] = false;
				}
			}else{
				$validacion['reemplazo'] = false;
				$totalCasos = Trazabilidad::model()->countByAttributes(array("user_asign"=>$_POST['usuario'], "estado"=>"1"));
				$validacion['msj'] = '<i class="glyphicon glyphicon-exclamation-sign"></i> El usuario tiene activo <b>'.$totalCasos.'</b> caso(s).';
			}
		}else{
			$validacion['resultado'] = false;
		}

		echo CJSON::encode($validacion);
	}
	public function actionValidarInhabilitar(){
		if(Yii::App()->request->isAjaxRequest){
			if($_POST["id"]){
				$model=Usuario::model()->findByPk($_POST["id"]);
				$actividades = UsuariosActividadTipologia::model()->findAllByAttributes(array("usuario"=>$model->usuario));
				foreach ($actividades as $actividad) {
					$cantidad = UsuariosActividadTipologia::model()->countByAttributes(array("id_actividad_tipologia"=>$actividad->id_actividad_tipologia));
					if($cantidad == "1"){
						$mensaje .= "<h5 class='red'>- La actividad ".$actividad->idActividadTipologia->idActividad->actividad." que pertenece a la tipologia ".$actividad->idActividadTipologia->idTipologia->tipologia." solo tiene asignado este usuario.</h5>\n";
					}
				}
				if(!$mensaje){
					echo CJSON::encode(array('status'=>'success'));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $mensaje));
				}
			}	
		}
	}
	public function actionActividadTipologia($usuario){
		$data = true;
		if($_GET["usuario"]){
			$usuario = base64_decode($usuario);
			if(!is_numeric($usuario) || empty($usuario)){
				$data = false;
			}
		}else{
			$data = false;
		}
		if($data){
			$aux = array();
			$consulta = UsuariosActividadTipologia::model()->findAllByAttributes(array("usuario"=>$usuario));
			foreach ($consulta as $key => $value) {
				$aux[] = $value->id_actividad_tipologia;
			}
			$model = new ActividadTipologia('search_detalle');
			$model->unsetAttributes();
			$model->actTipUser = $aux;
			$this->render('actividades',array(
				'model'=>$model,
				'usuario'=>$usuario,
			));
		}else{
			$this->redirect($this->createUrl('error/index'));
		}
	}
	public function actionCasosTutela(){
		$model = Yii::app()->db->createCommand(" SELECT recep.na, traza.id AS id_trazabilidad FROM trazabilidad AS traza
												 INNER JOIN recepcion AS recep
												 ON traza.na = recep.na
												 INNER JOIN tipologias AS tipo
												 ON recep.tipologia = tipo.id 
												 WHERE traza.estado = 1 
												 AND traza.user_asign = '".Yii::app()->user->usuario."'
												 AND tipo.tutela = true
												 ORDER BY recep.na")->queryAll();
		if($model){
			$notificacion = array();
			$alerta = array();
			$nombres = Usuario::model()->nombres(Yii::app()->user->usuario);
			$encabezado = Usuario::encabezadoTabla();
			foreach ($model as $mensaje) {
				$notificacion[] = "El caso ".$mensaje["na"]." de tutela esta pendiente por gestionar.";
				$cuerpo .= Usuario::cuerpoTabla($mensaje["id_trazabilidad"]);
			}
			Usuario::envioNotificacionMail($nombres, $encabezado.$cuerpo.Usuario::finalTabla(count($model)));
			$alerta[] = "Tiene ".count($model)." casos pendientes de tutela por gestionar.";
			echo CJSON::encode(array('status'=>'success', 'notificacion' => $notificacion, 'alerta'=>$alerta,'name'=>$nombres));
		}else{
			echo CJSON::encode(array('status'=>'error'));
		}
	}
}

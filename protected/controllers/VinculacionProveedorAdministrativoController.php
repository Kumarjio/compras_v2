<?php

class VinculacionProveedorAdministrativoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	public $model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','update','admin', 'enviarDocumentacion', 'listoParaContrato', 'recepcionDocumentacion', 'DevolverDocumentacion', 'AceptarDocumentacion', 'RevisionVinculacion', 'Vincular', 'Rechazar', 'Anteriores'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	protected function beforeAction($action)
	{	
		parent::beforeAction($action);
		if($action->id == "update"){
			$this->model = $this->loadModel($_GET['id']);
			switch($this->model->paso_wf){
				case "swVinculacionProveedorAdministrativo/verificar_vinculacion":
					//$this->redirect(array("create", 'orden' => $_GET['id']));
					break;
				case "swVinculacionProveedorAdministrativo/recepcion_documentacion":
					$this->redirect(array("recepcionDocumentacion", 'id' => $_GET['id']));
					break;
				case "swVinculacionProveedorAdministrativo/en_vinculacion":
					$this->redirect(array("revisionVinculacion", 'id' => $_GET['id']));
					break;
				case "swVinculacionProveedorAdministrativo/listo_para_contrato":
					$this->redirect(array("/productoOrden/create", 'orden' => $_GET['id']));
					break;
				default:
					break;			

			}
		}

		return true;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEnviarDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
			$vpjq = VinculacionProveedorJuridico::model()->findAllByAttributes(array('id_proveedor' => $model->id_proveedor, 'id_orden' => $model->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
			$vpj = $vpjq[0];
			if(isset($_POST['DocumentacionVinculacionProveedorAdministrativo'])){
				$dvpa->attributes = $_POST['DocumentacionVinculacionProveedorAdministrativo'];
				$dvpa_admin = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Administrativo'));
				$dvpa_admin->persona = $dvpa->persona;
				if($dvpa->persona == "Natural"){
					$dvpa->scenario = "persona_natural";
				}else{
					$dvpa->scenario = "persona_juridica";
				}
				if(isset($_POST['VinculacionProveedorAdministrativo']['vinculado'])){
					$model->vinculado = $_POST['VinculacionProveedorAdministrativo']['vinculado'];
				}
				if($dvpa->save()){
					$dvpa_admin->save();
					if($dvpa->persona == "Natural"){
						$vpj->paso_wf = "swVinculacionProveedorJuridico/listo_para_contrato";
					}
					$model->paso_wf = "swVinculacionProveedorAdministrativo/recepcion_documentacion";
					$model->devuelto = 0;
					$model->save();
					$vpj->save();
				}
				$w = Willies::model()->findByAttributes(array('id_vpj' => $vpj->id));
				$arch_2=new AdjuntosWillies('search');
				$arch_2->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosWillies'])){
					$arch->attributes=$_GET['AdjuntosWillies'];
				}
			}
				
			
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa, 'w' => $w, 'archivos_w' => $arch_2), true)));
			
		}
	}
	
	public function actionDevolverDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Administrativo'));
			if(isset($_POST['DocumentacionVinculacionProveedorAdministrativo'])){
				$dvpa->attributes = $_POST['DocumentacionVinculacionProveedorAdministrativo'];
			}
			$model->paso_wf = "swVinculacionProveedorAdministrativo/verificar_vinculacion";
			$model->devuelto = 1;
			if(isset($_POST['VinculacionProveedorAdministrativo']['observacion'])){
				$model->observacion = $_POST['VinculacionProveedorAdministrativo']['observacion'];
			}
			$model->save();
			$dvpa->save();
			
			echo CJSON::encode(array('status'=>'success'));
			
		}
	}
	
	public function actionAceptarDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Administrativo'));
			if(isset($_POST['DocumentacionVinculacionProveedorAdministrativo'])){
				$dvpa->attributes = $_POST['DocumentacionVinculacionProveedorAdministrativo'];
			}
			$dvpa->save();
			$diferentes = $model->verificarDocumentacion();
			if(count($diferentes) == 0){
				$model->paso_wf = "swVinculacionProveedorAdministrativo/en_vinculacion";
				if(isset($_POST['VinculacionProveedorAdministrativo']['observacion'])){
					$model->observacion = $_POST['VinculacionProveedorAdministrativo']['observacion'];
				}
				$model->save();
				echo CJSON::encode(array('status'=>'success'));
			}else{
				echo CJSON::encode(array('status'=>'failure'));
			}
			
		}
	}
	
	public function actionListoParaContrato($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
			$vpjq = VinculacionProveedorJuridico::model()->findAllByAttributes(array('id_proveedor' => $model->id_proveedor, 'id_orden' => $model->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
			$vpj = $vpjq[0];
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
			$model->vinculado = "Si";
			$model->devuelto = 0;
			$model->paso_wf = "swVinculacionProveedorAdministrativo/listo_para_contrato";
			$model->save();
			$w = null;
			if(!$vpj->requiereContrato()){
				$vpj->paso_wf = "swVinculacionProveedorJuridico/listo_para_contrato";
				$vpj->save();
				$w = Willies::model()->findByAttributes(array('id_vpj' => $vpj->id));
			}
			$arch=new AdjuntosVpj('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosVpj'])){
				$arch->attributes=$_GET['AdjuntosVpj'];
			}
			
			$arch_2=new AdjuntosWillies('search');
			$arch_2->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosWillies'])){
				$arch->attributes=$_GET['AdjuntosWillies'];
			}
			
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa, 'archivos' => $arch, 'w' => $w, 'archivos_w' => $arch_2), true)));
			
		}
	}
	
	public function actionRevisionVinculacion($id){
		$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
		$this->render('vincular', array('vpa' => $model));
	}
	
	public function actionVincular($id){
		$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
		if(isset($_POST['VinculacionProveedorAdministrativo'])){
			$model->attributes=$_POST['VinculacionProveedorAdministrativo'];
			$model->paso_wf = "swVinculacionProveedorAdministrativo/listo_para_contrato";
			if($model->save()){
				$this->redirect(array('admin'));
			}else{
				$this->render('vincular', array('vpa' => $model));
			}	
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}
	
	public function actionRechazar($id){
		$model = VinculacionProveedorAdministrativo::model()->findByPk($id);
		if(isset($_POST['codigo_seguridad']) and $_POST['codigo_seguridad'] == 'asdqwe123'){
			if(isset($_POST['VinculacionProveedorAdministrativo'])){
				$model->attributes=$_POST['VinculacionProveedorAdministrativo'];
				$model->observacion = $_POST['VinculacionProveedorAdministrativo']['observacion'];
				$model->paso_wf = "swVinculacionProveedorAdministrativo/cancelado";
				if($model->save()){
					
				}else{
					$this->render('vincular', array('vpa' => $model));
					return false;
				}
				$proveedor = $model->proveedor;
				$proveedor->bloqueado = 1;
				$proveedor->save();
				$orden = Orden::model()->findByPk($model->id_orden);
				$orden->paso_wf = 'swOrden/en_negociacion';
				$orden->observacion = "Se requiere repetir el proceso de negociación porque el proveedor elegido fue bloqueado.";
				$orden->save();
				$producto_orden = ProductoOrden::model()->findAllByAttributes(array('orden' => $orden->id));
				if(count($producto_orden > 0)){
					foreach($producto_orden as $po){
						$cotizacion = Cotizacion::model()->findAllByAttributes(array('nit' => $model->id_proveedor, 'producto_orden' => $po->id));
						foreach($cotizacion as $c){
							$c->enviar_a_usuario = 0;
							$c->enviar_cotizacion_a_usuario = 0;
							$c->elegido_compras = 0;
							$c->elegido_usuario = 0;
							$c->elegido_comite = 0;
							$c->razon_eleccion_compras = '';
							$c->razon_eleccion_comite = '';
							$c->razon_eleccion_usuario = '';
							$c->save();
						}
					}
				}
				$administrativos = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_orden' => $model->id_orden));
				$juridicos = VinculacionProveedorJuridico::model()->findAllByAttributes(array('id_orden' => $model->id_orden));
				foreach($administrativos as $a){
					$a->paso_wf = "swVinculacionProveedorAdministrativo/cancelado";
					$a->usuario_actual = 0;
					$a->save();
				}
				foreach($juridicos as $j){
					$j->paso_wf = "swVinculacionProveedorJuridico/cancelado";
					$j->usuario_actual = 0;
					$j->save();
				}
				$this->redirect(array('admin'));
			}		
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new VinculacionProveedorAdministrativo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VinculacionProveedorAdministrativo']))
		{
			$model->attributes=$_POST['VinculacionProveedorAdministrativo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	
	public function actionRecepcionDocumentacion($id)
	{
		$model=$this->loadModel($id);
		$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Administrativo'));

		$this->render('recepcion_documentos',array(
			'model'=>$model,
			'dvpa' => $dvpa
		));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VinculacionProveedorAdministrativo']))
		{
			$model->attributes=$_POST['VinculacionProveedorAdministrativo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('VinculacionProveedorAdministrativo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/listar';
		$model=new VinculacionProveedorAdministrativo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VinculacionProveedorAdministrativo']))
			$model->attributes=$_GET['VinculacionProveedorAdministrativo'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=VinculacionProveedorAdministrativo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAnteriores()
	{
		$this->layout = '//layouts/listar_sin_busqueda';
		
		$model =new VinculacionProveedorAdministrativo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VinculacionProveedorAdministrativo'])){
			
			$model->attributes=$_GET['VinculacionProveedorAdministrativo'];
		}

		$this->render('anteriores',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vinculacion-proveedor-administrativo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class VinculacionProveedorJuridicoController extends Controller
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
				'actions'=>array('create','update','admin', 'EnviarDocumentacion', 'recepcionDocumentacion', 'DevolverDocumentacion', 'AceptarDocumentacion', 'SubirArch', 'EnviarDocumentacionContrato', 'RevisarDocumentacionContrato', 'EnviarRevisionDocumentacion', 'EnviarAWillis', 'DevolverDocumentacionContrato', 'Anteriores'),
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
				case "swVinculacionProveedorJuridico/recepcion_documentacion":
					$this->redirect(array("recepcionDocumentacion", 'id' => $_GET['id']));
					break;
				case "swVinculacionProveedorJuridico/revision_contrato":
					$this->redirect(array("RevisarDocumentacionContrato", 'id' => $_GET['id']));
					break;
				case "swVinculacionProveedorJuridico/revision_contrato_firmado":
					$this->redirect(array("RevisarDocumentacionContrato", 'id' => $_GET['id']));
					break;
				default:
					break;			

			}
		}

		return true;
	}
	
	public function actionEnviarDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$vpj = VinculacionProveedorJuridico::model()->findByPk($id);
			$modelq = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_proveedor' => $vpj->id_proveedor, 'id_orden' => $vpj->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
			$model = $modelq[0];
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
			
			$vpj->paso_wf = "swVinculacionProveedorJuridico/recepcion_documentacion";
			if($vpj->save()){
			  if(isset($_POST['VinculacionProveedorAdministrativo'])){
			    $model->attributes = $_POST['VinculacionProveedorAdministrativo'];
			    $model->save();

			  }
				$dvpa_b = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Administrativo'));
				$dvpa->persona = "Juridica";
				$dvpa_b->persona = "Juridica";
				$dvpa->save();
				$dvpa_b->save();
			}
			
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa), true)));
			
		}
	}
	
	public function actionDevolverDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorJuridico::model()->findByPk($id);
			$model->paso_wf = "swVinculacionProveedorJuridico/verificar_vinculacion";
			if(isset($_POST['VinculacionProveedorJuridico']['observacion'])){
				$model->observacion = $_POST['VinculacionProveedorJuridico']['observacion'];
			}
			if($model->save()){
				echo CJSON::encode(array('status'=>'success'));
			}else{
				echo CJSON::encode(array('status'=>'failure', 'content' => $this->renderPartial('/proveedor/_recepcion_documentos_juridico', array('model' => $model->proveedor, 'vpj' => $model), true)));
			}
		}
	}
	
	public function actionAceptarDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model = VinculacionProveedorJuridico::model()->findByPk($id);

			if(isset($_GET['sincontrato']) && $_GET['sincontrato'] == 1){
				$model->paso_wf = "swVinculacionProveedorJuridico/ok_sin_contrato";
			}else{
				if($model->paso_wf == 'swVinculacionProveedorJuridico/recepcion_documentacion'){
				$model->paso_wf = "swVinculacionProveedorJuridico/listo_para_contrato";
				}else{
					if($model->paso_wf == 'swVinculacionProveedorJuridico/revision_contrato'){
						$model->paso_wf = "swVinculacionProveedorJuridico/enviar_firmas";
					}else{
						if($model->paso_wf == 'swVinculacionProveedorJuridico/revision_contrato_firmado'){
							$model->paso_wf = "swVinculacionProveedorJuridico/enviar_a_thomas";
						}
					}
				}
			}
				
			if(isset($_POST['VinculacionProveedorJuridico']['observacion'])){
				$model->observacion = $_POST['VinculacionProveedorJuridico']['observacion'];
			}
			if($model->save()){
				echo CJSON::encode(array('status'=>'success'));
			}else{
				echo CJSON::encode(array('status'=>'failure'));
			}
		}
	}
	
	public function actionRecepcionDocumentacion($id)
	{
		$model=$this->loadModel($id);

		$this->render('recepcion_documentos',array(
			'model'=>$model
		));
	}
	
	public function actionEnviarDocumentacionContrato($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$vpj = VinculacionProveedorJuridico::model()->findByPk($id);
			$adjuntos = AdjuntosVpj::model()->findAllByAttributes(array('id_vpj' => $id));
			if(count($adjuntos) < 0){
				echo CJSON::encode(array('status'=>'failure'));
			}else{
				if($vpj->paso_wf == "swVinculacionProveedorJuridico/enviar_firmas"){
					$vpj->paso_wf = "swVinculacionProveedorJuridico/revision_contrato_firmado";
				}else{
					$vpj->paso_wf = "swVinculacionProveedorJuridico/revision_contrato";
				}	
				if(isset($_POST['VinculacionProveedorJuridico']['observacion'])){
					$vpj->observacion = $_POST['VinculacionProveedorJuridico']['observacion'];
				}
				$vpj->save();
				$modelq = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_proveedor' => $vpj->id_proveedor, 'id_orden' => $vpj->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
				$model = $modelq[0];
				$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
				$arch=new AdjuntosVpj('search');
				$arch->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosVpj'])){
					$arch->attributes=$_GET['AdjuntosVpj'];
				}
				$arch2=new AdjuntosWillies('search');
				$arch2->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosWillies'])){
					$arch2->attributes=$_GET['Adjuntoswillies'];
				}
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa, 'archivos' => $arch, 'archivos_w' => $arch2), true)));
			}
		}
	}
	public function actionDevolverDocumentacionContrato($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$vpj = VinculacionProveedorJuridico::model()->findByPk($id);
			$adjuntos = AdjuntosVpj::model()->findAllByAttributes(array('id_vpj' => $id));
			if(count($adjuntos) < 0){
				echo CJSON::encode(array('status'=>'failure'));
			}else{
				if($vpj->paso_wf == "swVinculacionProveedorJuridico/enviar_firmas"){
					$vpj->paso_wf = "swVinculacionProveedorJuridico/revision_contrato";
				}
				if(isset($_POST['VinculacionProveedorJuridico']['observacion'])){
					$vpj->observacion = $_POST['VinculacionProveedorJuridico']['observacion'];
				}
				$vpj->save();
				$modelq = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_proveedor' => $vpj->id_proveedor, 'id_orden' => $vpj->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
				$model = $modelq[0];
				$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
				$arch=new AdjuntosVpj('search');
				$arch->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosVpj'])){
					$arch->attributes=$_GET['AdjuntosVpj'];
				}
				$arch2=new AdjuntosWillies('search');
				$arch2->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosWillies'])){
					$arch2->attributes=$_GET['Adjuntoswillies'];
				}
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa, 'archivos' => $arch, 'archivos_w' => $arch2), true)));
			}
		}
	}
	
	public function actionRevisarDocumentacionContrato($id)
	{
		$model=$this->loadModel($id);
		$documentos = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $id));
		$arch=new AdjuntosVpj('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosVpj'])){
			$arch->attributes=$_GET['AdjuntosVpj'];
		}
		$this->render('revision_contrato',array(
			'model'=>$model,
			'documentos' => $documentos,
			'archivos' => $arch
		));
	}
	
	public function actionEnviarRevisionDocumentacion($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$model=$this->loadModel($id);
			if($model->paso_wf == "swVinculacionProveedorJuridico/revision_contrato_firmado"){
				$model->paso_wf = "swVinculacionProveedorJuridico/enviar_firmas";
			}else{
				$model->paso_wf = "swVinculacionProveedorJuridico/ajustes_contrato";
			}
			if(isset($_POST['VinculacionProveedorJuridico']['observacion'])){
				$model->observacion = $_POST['VinculacionProveedorJuridico']['observacion'];
			}
			$documentos = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $id));
			
			if(isset($_POST['DocumentosVpj'])){
				$documentos->attributes = $_POST['DocumentosVpj'];
				$documentos->save();
			}
			
			if($model->save()){
				echo CJSON::encode(array('status'=>'success'));
			}else{
				$arch=new AdjuntosVpj('search');
				$arch->unsetAttributes();  // clear any default values
				if(isset($_GET['AdjuntosVpj'])){
					$arch->attributes=$_GET['AdjuntosVpj'];
				}
				echo CJSON::encode(array('status'=>'failure', 'content' => $this->renderPartial('_revision_contrato', array('model' => $model->proveedor, 'vpj' => $model, 'dvpj' => $documentos, 'archivos' => $arch ), true)));
			}
		}
	}
	
	public function actionEnviarAWillis($id)
	{
		if(Yii::app()->request->isAjaxRequest){
			$vpj = VinculacionProveedorJuridico::model()->findByPk($id);
			$w = Willies::model()->findByAttributes(array('id_vpj' => $id));
			$modelq = VinculacionProveedorAdministrativo::model()->findAllByAttributes(array('id_proveedor' => $vpj->id_proveedor, 'id_orden' => $vpj->id_orden), array('order' => 'creacion DESC', 'limit' => 1));
			$model = $modelq[0];
			$dvpa = DocumentacionVinculacionProveedorAdministrativo::model()->findByAttributes(array('id_vinculacion_proveedor_administrativo' => $model->id, 'analista_o_administrativo' => 'Analista'));
			$arch=new AdjuntosVpj('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosVpj'])){
				$arch->attributes=$_GET['AdjuntosVpj'];
			}
			$arch2=new AdjuntosWillies('search');
			$arch2->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosWillies'])){
				$arch2->attributes=$_GET['AdjuntosWillies'];
			}
			
			$w->paso_wf = "swWillies/revision_polizas";
			$w->save();
			
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('/proveedor/_proveedor', array('model' => $model->proveedor, 'vpa' => $model, 'vpj' => $vpj, 'dvpa' => $dvpa, 'archivos' => $arch, 'archivos_w' => $arch2), true)));
		}
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new VinculacionProveedorJuridico;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VinculacionProveedorJuridico']))
		{
			$model->attributes=$_POST['VinculacionProveedorJuridico'];
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VinculacionProveedorJuridico']))
		{
			$model->attributes=$_POST['VinculacionProveedorJuridico'];
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
		$dataProvider=new CActiveDataProvider('VinculacionProveedorJuridico');
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
		$model=new VinculacionProveedorJuridico('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VinculacionProveedorJuridico']))
			$model->attributes=$_GET['VinculacionProveedorJuridico'];

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
		$model=VinculacionProveedorJuridico::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionSubirArch(){
		$id_vpj = $_GET['id'];

		$targetDir =   "/vol1" . 
	                   DIRECTORY_SEPARATOR . 
					   date('Y-m-d') .
					   DIRECTORY_SEPARATOR .
                                           date('H-i-s') .
					   DIRECTORY_SEPARATOR . 
	                   $id_vpj;
		


	    if (!file_exists($targetDir))
     	  @mkdir($targetDir,0775,true);   
	                   
		
		$upload = new qqFileUploader();
    	
    	$subio = $upload->handleUpload($targetDir, false, false);
    	if(isset($subio['success']) && $subio['success']){
    		$arch = new AdjuntosVpj;
    		$arch->id_vpj = $id_vpj;
    		$arch->path = $targetDir . DIRECTORY_SEPARATOR . $upload->getName();
    		$arch->nombre = $upload->getName();
    		$arch->usuario = Yii::app()->user->getState("id_empleado");

    		$pathinfo = pathinfo($upload->getName());
	        $ext = @$pathinfo['extension'];

	        $arch->tipi = $ext;

    		$arch->save();
    	}

    	echo CJSON::encode($subio);
    	 
	}
	
	public function actionAnteriores()
	{
		$this->layout = '//layouts/listar_sin_busqueda';
		
		$model =new VinculacionProveedorJuridico('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VinculacionProveedorJuridico'])){
			
			$model->attributes=$_GET['VinculacionProveedorJuridico'];
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='vinculacion-proveedor-juridico-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

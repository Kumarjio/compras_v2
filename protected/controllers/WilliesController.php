<?php

class WilliesController extends Controller
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
				'actions'=>array('create','update','admin', 'SubirArch', 'delete', 'RevisarPolizas', 'EnviarPolizas', 'DevolverPolizas', 'Anteriores'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
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
				case "swWillies/ajustes_contrato":
					$this->redirect(array("admin"));
					break;
				case "swWillies/revision_polizas":
					$this->redirect(array("revisarPolizas", 'id' => $_GET['id']));
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionRevisarPolizas($id)
	{
		$model=$this->loadModel($id);
		$documentos = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $model->id_vpj));
		$arch=new AdjuntosWillies('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosWillies'])){
			$arch->attributes=$_GET['AdjuntosWillies'];
		}
		$this->render('revision_polizas',array(
			'model'=>$model,
			'documentos' => $documentos,
			'archivos' => $arch
		));
	}
	
	public function actionDevolverPolizas($id)
	{
		$model=$this->loadModel($id);
		$documentos = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $model->id_vpj));
		$arch=new AdjuntosWillies('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosWillies'])){
			$arch->attributes=$_GET['AdjuntosWillies'];
		}
		if(isset($_POST['DocumentosVpj'])){
			$documentos->attributes=$_POST['DocumentosVpj'];
			$model->paso_wf = 'swWillies/ajustes_contrato';
			if(isset($_POST['Willies']['observacion'])){
				$model->observacion = $_POST['Willies']['observacion'];
			}
			if($documentos->save() and $model->save()){
				$this->redirect(array('admin'));
			}else{
				$this->render('revision_polizas',array(
					'model'=>$model,
					'documentos' => $documentos,
					'archivos' => $arch
				));
			}
		}else{
			$this->render('revision_polizas',array(
				'model'=>$model,
				'documentos' => $documentos,
				'archivos' => $arch
			));
		}
	}
	
	public function actionEnviarPolizas($id)
	{
		$model=$this->loadModel($id);
		$documentos = DocumentosVpj::model()->findByAttributes(array('id_vpj' => $model->id_vpj));
		$arch=new AdjuntosWillies('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosWillies'])){
			$arch->attributes=$_GET['AdjuntosWillies'];
		}
		if(isset($_POST['DocumentosVpj'])){
			$documentos->scenario = 'willies';
			$documentos->attributes=$_POST['DocumentosVpj'];
			$model->paso_wf = 'swWillies/enviar_a_thomas';
			if(isset($_POST['Willies']['observacion'])){
				$model->observacion = $_POST['Willies']['observacion'];
			}
			if($documentos->save() and $model->save()){
				$this->redirect(array('admin'));
			}else{
				$this->render('revision_polizas',array(
					'model'=>$model,
					'documentos' => $documentos,
					'archivos' => $arch
				));
			}
		}else{
			$this->render('revision_polizas',array(
				'model'=>$model,
				'documentos' => $documentos,
				'archivos' => $arch
			));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Willies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Willies']))
		{
			$model->attributes=$_POST['Willies'];
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

		if(isset($_POST['Willies']))
		{
			$model->attributes=$_POST['Willies'];
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
		$dataProvider=new CActiveDataProvider('Willies');
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
		$model=new Willies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Willies']))
			$model->attributes=$_GET['Willies'];

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
		$model=Willies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionSubirArch(){
		$id_willies = $_GET['id'];

		$targetDir =   "/vol1" . 
	                   DIRECTORY_SEPARATOR . 
					   date('Y-m-d') .
					   DIRECTORY_SEPARATOR .
                                           date('H-i-s') .
					   DIRECTORY_SEPARATOR . 
	                   $id_willies;



	    if (!file_exists($targetDir))
     	  @mkdir($targetDir,0775,true);   
	                   
		
		$upload = new qqFileUploader();
    	
    	$subio = $upload->handleUpload($targetDir, false, false);
    	if(isset($subio['success']) && $subio['success']){
    		$arch = new AdjuntosWillies;
    		$arch->id_willies = $id_willies;
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
		
		$model =new Willies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Willies'])){
			
			$model->attributes=$_GET['Willies'];
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='willies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

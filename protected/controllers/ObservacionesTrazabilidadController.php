<?php

class ObservacionesTrazabilidadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update', 'index','admin', 'todos'),
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
		$model=new ObservacionesTrazabilidad;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ObservacionesTrazabilidad']))
		{
			$model->attributes=$_POST['ObservacionesTrazabilidad'];
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

		if(isset($_POST['ObservacionesTrazabilidad']))
		{
			$model->attributes=$_POST['ObservacionesTrazabilidad'];
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
		if(Yii::App()->request->isAjaxRequest){
			if(isset($_POST['ObservacionesTrazabilidad'])){
				$model = new ObservacionesTrazabilidad;
				$model->attributes = $_POST['ObservacionesTrazabilidad'];
				$model->usuario = Yii::app()->user->usuario;
				if($model->save()){
					$consulta = ObservacionesTrazabilidad::model()->findByAttributes(array("id_trazabilidad"=>$model->id_trazabilidad));
					$model->unsetAttributes();					
	            	echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('index', array('model' => $model,'consulta'=>$consulta), true, true)));
	        	}else{
	        		echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('index', array('model' => $model,'consulta'=>$consulta), true, true)));
	        	}
				exit;
			}else{
				$id = $_POST["id"];
				$model = new ObservacionesTrazabilidad;
				$model->id_trazabilidad = $id;
				$na = Trazabilidad::model()->findByAttributes(array("id"=>$id));
				$model->na = $na->na;
				$consulta = ObservacionesTrazabilidad::model()->findByAttributes(array("id_trazabilidad"=>$id));
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('index', array('model' => $model,'consulta'=>$consulta), true, true)));
				exit;
			}
		}
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ObservacionesTrazabilidad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ObservacionesTrazabilidad']))
			$model->attributes=$_GET['ObservacionesTrazabilidad'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ObservacionesTrazabilidad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ObservacionesTrazabilidad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionTodos()
	{
		if(Yii::App()->request->isAjaxRequest){
			$na = $_POST['na'];
			$model=new ObservacionesTrazabilidad('search');
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('todos', array('model' => $model, 'na'=>$na), true, true)));
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param ObservacionesTrazabilidad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='observaciones-trazabilidad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

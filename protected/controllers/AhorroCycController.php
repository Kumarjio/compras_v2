<?php

class AhorroCycController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
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

	protected function beforeAction($action)
	{	
		parent::beforeAction($action);
                $permiso = Permisos::model()->findByAttributes(array('nombre_accion'=>'AhorroCyc/'.$action->id))->codigo;
                if($permiso != ''){
                    if(!in_array($permiso,Yii::app()->user->permisos)){
                        throw new CHttpException(400,'El usuario no tiene permisos para ejecutar esta acción.');
                    }
                }
                else{
                    throw new CHttpException(400,'El permiso para ejecutar esta acción aún no está configurado.');
                }
                
		return true;
                
        }
        
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','excel'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Producto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar';
		$model=new AhorroCyc('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AhorroCyc']))
			$model->attributes=$_GET['AhorroCyc'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        
	public function actionExcel()
	{
		//$this->layout = '//layouts/listar';
		$model=new AhorroCyc('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AhorroCyc']))
			$model->attributes=$_GET['AhorroCyc'];

		$this->model = $model;
		$this->renderPartial('_informe_csv',array(
			'model'=>$model,
		),false);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AhorroCyc::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

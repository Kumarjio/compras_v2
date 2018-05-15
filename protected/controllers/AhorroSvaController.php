<?php

class AhorroSvaController extends Controller
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
                $permiso = Permisos::model()->findByAttributes(array('nombre_accion'=>'AhorroSva/'.$action->id))->codigo;
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
				'actions'=>array('admin','excel','todos'),
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
		$model=new AhorroSva('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AhorroSva']))
			$model->attributes=$_GET['AhorroSva'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionTodos()
	{
		//$this->layout = '//layouts/listar';
		$model=new AhorroSva('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AhorroSva']))
			$model->attributes=$_GET['AhorroSva'];

		$this->model = $model;
		$this->render('todos',array(
			'model'=>$model,
		));
	}

	
	
	public function actionExcel()
	{
		//$this->layout = '//layouts/listar';
		$model=new AhorroSva('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AhorroSva']))
			$model->attributes=$_GET['AhorroSva'];

		$this->model = $model;
		$this->renderPartial('_informe_csv',array(
			'model'=>$model,
		),false);
	}
        
	public function loadModel($id)
	{
		$model=AhorroSva::model()->findByPk($id);
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

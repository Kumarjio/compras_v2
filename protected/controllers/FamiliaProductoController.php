<?php

class FamiliaProductoController extends Controller
{
	//public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	public $model;

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin', 'delete', 'selectFamilia'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new FamiliaProducto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FamiliaProducto']))
		{
			$model->attributes=$_POST['FamiliaProducto'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FamiliaProducto']))
		{
			$model->attributes=$_POST['FamiliaProducto'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			try{
                        // we only allow deletion via POST request
                        $this->loadModel($id)->delete();

                        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                        if(!isset($_GET['ajax']))
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

                        }catch(CDbException $e){
                                throw new CHttpException(400,'No se puede eliminar este registro porque existen otros registros asociados.');
                        }
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FamiliaProducto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	
	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar';
		$model=new FamiliaProducto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FamiliaProducto']))
			$model->attributes=$_GET['FamiliaProducto'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
	public function loadModel($id)
	{
		$model=FamiliaProducto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionSelectFamilia(){
		$id_uno = $_POST ['Producto']['id_categoria'];
		if($id_uno != ''){
	        $lista = FamiliaProducto::model()->findAll('id_categoria = :id_uno',array(':id_uno'=>$id_uno));
	        $lista = CHtml::listData($lista, 'id', 'nombre');
	        echo CHtml::tag('option',array('value'=>''),'Seleccione...',true);
	        foreach ($lista as $valor => $familia) {
	            echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($familia),true);
	        }
		}
		else {
			echo CHtml::tag('option',array('value'=>''),'Seleccione Categoria...',true);
		}
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='familia-producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

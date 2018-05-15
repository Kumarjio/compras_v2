<?php

class VicepresidenciasController extends Controller
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
				'actions'=>array('create','update','admin','gerenciasJefaturas'),
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
		$model=new Vicepresidencias;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vicepresidencias']))
		{
			$model->attributes=$_POST['Vicepresidencias'];
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

		if(isset($_POST['Vicepresidencias']))
		{
			$model->attributes=$_POST['Vicepresidencias'];
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
		$dataProvider=new CActiveDataProvider('Vicepresidencias');
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
		$model=new Vicepresidencias('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vicepresidencias']))
			$model->attributes=$_GET['Vicepresidencias'];

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
		$model=Vicepresidencias::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionGerenciasJefaturas() 
    {		

		try{
	        $id_vice = $_POST['vice'];
	        if($id_vice){
	        	$lista = Gerencias::model()->findAll('id_vice = :id_uno',array(':id_uno'=>$id_vice));
	        	if(!$lista){
	        		$lista = Jefaturas::model()->findAll('id_vice = :id_uno',array(':id_uno'=>$id_vice));
	        		$id = 'id_jefatura';
	        		$id_vacio = 'id_gerencia';
	        	}
	        	else{
	        		$id = 'id_gerencia';
	        		$id_vacio = 'id_jefatura';
	    		}
	    		$vicepre = Vicepresidencias::model()->nombreVicepresidencia($_POST['vice']);
	    		$id_vicepre = $vicepre[0]['id'];
	    		$nombre_vice = $vicepre[0]['nombre'];
	        }
	        else{
	        	$lista = Gerencias::model()->findAll('id_vice is null');
	    		$id = 'id_gerencia';
	    		$id_vacio = 'id_jefatura';
	    		$vicepre = null;
	        }
	        $lista = CHtml::listData($lista, 'id', 'nombre');
	        $options = $vacio = CHtml::tag('option',array('value'=>''),CHtml::encode("No Aplica"),true);
	        foreach ($lista as $valor => $nombre) {
	                $options .= CHtml::tag('option',array('value'=>$valor),CHtml::encode($nombre),true);
	        }
	        $res = array('status'=> 'ok' ,'options'=>$options, 'id'=>$id, 'vacio'=>$vacio, 'id_vacio'=>$id_vacio, 'id_vicepre'=>$id_vicepre, 'nombre_vice'=>$nombre_vice);
	    }catch(Exception $e){
	    	$lista = Gerencias::model()->findAll('id_vice is null');
	    	$lista = CHtml::listData($lista, 'id', 'nombre');
	        $options = $vacio = CHtml::tag('option',array('value'=>''),CHtml::encode("No Aplica"),true);
	        foreach ($lista as $valor => $nombre) {
	                $options .= CHtml::tag('option',array('value'=>$valor),CHtml::encode($nombre),true);
	        }
			$res = array(
				'status' => 'failure',	
				'mensaje' => $e->getMessage(),
				'options_gerencia'=>$options
			);
		}
		echo CJSON::encode($res);

    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vicepresidencias-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class CartasFisicasController extends Controller
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
				'actions'=>array('create','update','admin','punteo','impresion','punteoExcel','consultaRegistros'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CartasFisicas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CartasFisicas']))
		{
			$model->attributes=$_POST['CartasFisicas'];
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

		if(isset($_POST['CartasFisicas']))
		{
			$model->attributes=$_POST['CartasFisicas'];
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
		$dataProvider=new CActiveDataProvider('CartasFisicas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CartasFisicas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CartasFisicas']))
			$model->attributes=$_GET['CartasFisicas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CartasFisicas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CartasFisicas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CartasFisicas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cartas-fisicas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionPunteo()
	{
		if(Yii::App()->request->isAjaxRequest){
			$id = $_POST["id"];
			$model = Cartas::model()->findByAttributes(array("id"=>$id));
			$actualiza = Cartas::model()->updateAll(array('punteo'=>'2'),'id ='.$id);
			if($model){
				echo "<h5 align='center'>Carta punteada $model->id del Caso $model->na.</h5>";
			}else{
				echo "<h5 class='red' align='center'>Error al puntear la carta</h5>";
			}
		}
	}
	public function actionImpresion()
	{
		$model=new CartasFisicas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CartasFisicas']))
			$model->attributes=$_GET['CartasFisicas'];

		$this->render('_impresion',array(
			'model'=>$model,
		));
	}
	public function actionPunteoExcel()
	{
		$model=new CartasFisicas('search');
		$model->unsetAttributes();
		if(isset($_GET['CartasFisicas']))
			$model->attributes=$_GET['CartasFisicas'];

		$this->renderPartial('_punteo_excel',array(
			'model'=>$model
		));
	}
	public function actionPunteoExcel472()
	{
		$model=new CartasFisicas('search');
		$model->unsetAttributes();
		if(isset($_GET['CartasFisicas']))
			$model->attributes=$_GET['CartasFisicas'];
		
		$courrier_472 = CartasFisicas::model()->with( array('idCartas'=>array("alias"=>"c",'condition'=>'c.punteo = 2 AND c.entrega = 2 AND c.proveedor = 1')))->findAll("t.firma = :u", array(":u"=>"2"));
		if($courrier_472){
			$this->renderPartial('_punteo_excel_472',array(
				'model'=>$model
			));
		}else{
			return false;
		}
	}
	public function actionConsultaRegistros()
	{
		$consulta = CartasFisicas::model()->with( array('idCartas'=>array("alias"=>"c",'condition'=>'c.punteo = 2 AND c.entrega = 2')))->findAll("t.firma = :u", array(":u"=>"2"));
		if($consulta){
			die("ok");
		}else{
			die;
		}
	}
}

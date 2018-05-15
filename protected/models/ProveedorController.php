<?php

class ProveedorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	public $model;
	public $menu_izquierdo;

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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','create','update','admin','delete', 'contactos'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'actions' => array('index'),
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
	
	public function actionContactos(){
		if(isset($_POST) && $_POST['proveedor'] != ""){

			$lista_contactos = CHtml::listData(
															 	ContactoProveedor::model()->findAllByAttributes(array('nit' => $_POST['proveedor'])),
															 	"id",
															 	"nombre"
															 );

			try{

				$combo_contactos = CHtml::dropDownList("Cotizacion[contacto]", 
															 "",
															 $lista_contactos,
															 array('prompt' => 'Seleccione...',
															 	     'id' => 'Cotizacion_contacto',
															 )
															);
				$res = array(
				'status' => 'ok',	
				'combo' => $combo_contactos,
				 );
			
			}catch(Exception $e){
				$res = array(
					'status' => 'failure',	
					'mensaje' => $e->getMessage()
				);
			}
	
		}else{
			$res = array(
					'status' => 'failure',	
					'mensaje' => 'No se recibió el proveedor'
				);
		}

		echo CJSON::encode($res);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Proveedor;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Proveedor']))
		{
			$model->attributes=$_POST['Proveedor'];
			if($model->save())
				$this->redirect(array('miembros','id'=>$model->nit));
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionMiembros(){
		$miembros = new ProveedorMiembros('search');
		$miembros->unsetAttributes();
		if(isset($_GET['ProveedorMiembros']))
			$miembros->attributes=$_GET['ProveedorMiembros'];

		$this->render("miembros", array('miembros' => $miembros));
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

		if(isset($_POST['Proveedor']))
		{
			$model->attributes=$_POST['Proveedor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->nit));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionNombre($nit){
		$prov = Proveedor::model()->findAllByPk($nit);
		if(isset($prov[0]))
			echo $prov[0]['razon_social'];
		else
			echo "not_found";
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Proveedor');
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
		$model=new Proveedor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$model->attributes=$_GET['Proveedor'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

		/**
	 * Manages all models.
	 */
	public function actionCarga()
	{
		$this->layout = '//layouts/listar';
		$model=new Proveedor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$model->attributes=$_GET['Proveedor'];

		$this->model = $model;
		$this->render('ProveedorCarga',array(
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
		$model=Proveedor::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='proveedor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

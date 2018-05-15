<?php

class GerenciasController extends Controller
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','create','update','admin','delete','jefaturas'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Gerencias;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Gerencias']))
		{
			$model->attributes=$_POST['Gerencias'];
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

		if(isset($_POST['Gerencias']))
		{
			$model->attributes=$_POST['Gerencias'];
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
		$dataProvider=new CActiveDataProvider('Gerencias');
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
		$model=new Gerencias('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gerencias']))
			$model->attributes=$_GET['Gerencias'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionJefaturas(){
		if(isset($_POST) && $_POST['gerencia'] != ""){

			$lista_jefaturas = CHtml::listData(
															 	Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $_POST['gerencia'])),
															 	"id",
															 	"nombre"
															 );

			try{

				$gerente = Gerencias::model()->nombreGerente($_POST['gerencia']);
				$combo_jefaturas = CHtml::dropDownList("Orden[id_jefatura]", 
															 "",
															 $lista_jefaturas,
															 array('prompt' => 'Seleccione...',
                                                                   'class' => 'span5 form-control',
															       'data-sync' => 'true',
															 	     'id' => 'Orden_id_jefatura',
															 	     'onChange' => CHtml::ajax(array(
	                                       		'type' => 'post',
	                                       		'dataType' => 'json',
	                                       		'data' => array('jefatura' => 'js:this.value'),
	                                       		'url' => $this->createUrl("jefaturas/nombrejefe"),
	                                       		'success' => 'function(data){
	                                       			if(data.status == "ok"){
		                                       			$("#Orden_id_jefe").val(data.jefe.id);	
		                                       			$("#nombre_jefe").val(data.jefe.nombre);	
		                                       			//$("#Orden_centro_costos").val(data.costos.id);	
				                                       	//$("#centro_costos").val(data.costos.nombre);	
	                                       			}else{
	                                       				alert(data.mensaje);
	                                       				$("#Orden_id_jefe").val("");	
		                                       			$("#nombre_jefe").val("");

		                                       			//$("#Orden_centro_costos").val("");	
				                                       	//$("#centro_costos").val("");
	                                       			}	                                       				
	                                       		}'
	                                 	 			  )
																			)
																		)
															);
				$res = array(
				'status' => 'ok',	
				'combo' => $combo_jefaturas,
				'gerente' => array('id' => $gerente[0]['id'],
													 'nombre' => $gerente[0]['nombre'])
				 );
			
			}catch(Exception $e){
				$vacio = CHtml::tag('option',array('value'=>''),CHtml::encode("Seleccione Una Gerencia o Vicepresidencia..."),true);
				$res = array(
					'status' => 'failure',	
					'mensaje' => $e->getMessage(),
					'jefatura_vacio' => $vacio
				);
			}
	
		}else{
			$vacio = CHtml::tag('option',array('value'=>''),CHtml::encode("Seleccione Una Gerencia o Vicepresidencia..."),true);
			$res = array(
					'status' => 'failure',	
					'mensaje' => 'No se recibió la gerencia',
					'jefatura_vacio' => $vacio
				);
		}

		echo CJSON::encode($res);
	}

	public function actionJefaturasDoc(){
		if(isset($_POST) && $_POST['gerencia'] != ""){
			$modelo=$_POST['model'];

			$lista_jefaturas = CHtml::listData(
							Jefaturas::model()->findAllByAttributes(array('id_gerencia' => $_POST['gerencia'])),
							"id",
							"nombre"
						 );

			try{

				$gerente = Gerencias::model()->nombreGerente($_POST['gerencia']);
				$combo_jefaturas = CHtml::dropDownList($modelo."[id_jefatura]", 
															 "",
															 $lista_jefaturas,
															 array('prompt' => 'Seleccione...',
                                                                   'class' => 'span5',
															       'data-sync' => 'true',
															 	     'id' => $modelo.'_id_jefatura',
															 	     'onChange' => CHtml::ajax(array(
	                                       		'type' => 'post',
	                                       		'dataType' => 'json',
	                                       		'data' => array('jefatura' => 'js:this.value'),
	                                       		'url' => $this->createUrl("jefaturas/nombrejefe"),
	                                       		'success' => 'function(data){
	                                       			if(data.status == "ok"){
		                                       			$("#'.$modelo.'_responsable_proveedor").val(data.jefe.nombre);	
	                                       			}else{
	                                       				alert(data.mensaje);
	                                       				$("#'.$modelo.'_id_jefatura").val("");	
		                                       			$("#'.$modelo.'responsable_proveedor").val();;
	                                       			}	                                       				
	                                       		}'
	                                 	 			  )
																			)
																		)
															);
				$res = array(
				'status' => 'ok',	
				'combo' => $combo_jefaturas,
				'gerente' => array('id' => $gerente[0]['id'],
													 'nombre' => $gerente[0]['nombre'])
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
					'mensaje' => 'No se recibió la gerencia'
				);
		}

		echo CJSON::encode($res);
	}
	 

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Gerencias::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gerencias-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

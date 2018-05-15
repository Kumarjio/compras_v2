<?php

class CotizacionController extends Controller
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
                  'actions'=>array('create','update','admin','delete', 'proveedor','elegir','elegirUsuario', 'elegirComite', 'enviarUsuario','subir','subirarch', 'verMas', 'seleccionarParaEnvio', 'AgregarPagosACotizacion', 'deseleccionar','AgregarRegalosCotizacion'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
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
		$model=new Cotizacion;
		if(isset($_GET['cid'])){
			$cot = Cotizacion::model()->findByPk($_GET['cid']);
			if($cot != null){
				$model->attributes = $cot->attributes;
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model=$_GET['Proveedor'];

		if(isset($_POST['Cotizacion']))
		{
			$model->attributes=$_POST['Cotizacion'];
			if($model->save()){
			  	$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array('elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));			
				
				echo CJSON::encode(array('status'=>'ok','grid' => "cotizacion-grid_" . $model->producto_orden));
            	exit; 
			}
				
		}

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model, 'proveedor_model' => $proveedor_model), true)));
            exit;               
        }else{
        	$this->render('create',array(
				'model'=>$model,
			));	
        }

		
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

		if(isset($_POST['Cotizacion']))
		{
			$model->attributes=$_POST['Cotizacion'];
			if($model->save()){
			  	$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array('elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));			
				
				echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
            	exit; 
			}
				
		}

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_form', array('model'=>$model), true)));
            exit;               
        }else{
        	$this->render('create',array(
				'model'=>$model,
			));	
        }
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
		$dataProvider=new CActiveDataProvider('Cotizacion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionElegir($prodord,$id)
	{
		
		$model=$this->loadModel($id);
		$model->setScenario("razon_eleccion_compras");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['Cotizacion'])){
        		$model->razon_eleccion_compras = $_POST['Cotizacion']['razon_eleccion_compras'];
        		if($model->save()){

        			Cotizacion::model()->updateAll(array('elegido_compras'=>null, 'razon_eleccion_compras' => null), 
												  "producto_orden = :po",
												  array(':po' => $prodord));

        			$model->elegido_compras = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
        			exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_elegirCompras', array('model'=>$model), true)));
            exit;               
        }
		

	}
	
	public function actionAgregarPagosACotizacion($id){
		$this->layout = '//layouts/blank';
		
		$cotizacion=$this->loadModel($id);
		$model=new CotizacionPago('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CotizacionPago']))
			$model->attributes=$_GET['CotizacionPago'];


		$this->render('_agregar_pagos_a_cotizacion',array(
			'model'=>$model,
			'cotizacion' => $cotizacion,
		));
	}

	public function actionAgregarRegalosCotizacion($id){
		$this->layout = '//layouts/blank';
		
		$cotizacion=$this->loadModel($id);
		$model=new CotizacionRegalos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CotizacionRegalos']))
			$model->attributes=$_GET['CotizacionRegalos'];


		$this->render('_agregar_regalos_a_cotizacion',array(
			'model'=>$model,
			'cotizacion' => $cotizacion,
		));
	}

	
	public function actionSeleccionarParaEnvio($id){
		$this->layout = '//layouts/blank';
		$cotizacion=$this->loadModel($id);
		$pagos = CotizacionPago::model()->findAllByAttributes(array('id_cotizacion' => $id));
		$cant = 0;
        $hay_mensualidad = false;
		if(count($pagos) > 0){
			foreach($pagos as $p){
              $cant += $p->porcentaje;
              $hay_mensualidad = !$hay_mensualidad ? ($p->tipo == "Mensualidad") : $hay_mensualidad;

			}
		}

		if($cant == 100 || $hay_mensualidad){
			$cotizacion->enviar_cotizacion_a_usuario = 1;
			if($cotizacion->save()){
				echo CJSON::encode(array(
		            'status'=>'success', true));
		        exit;
			}else{
				echo CJSON::encode(array(
		            'status'=>'Ha ocurrido un error.', true));
		        exit;
			}
		}else{
			if($cant == 0){
				echo CJSON::encode(array('status'=>'Debe agregar por lo menos un pago.', true));
			}else{
				echo CJSON::encode(array('status'=>'La suma de los pagos debe ser igual a 100.', true));
			}
	        exit;
		}
	}
	
	public function actionDeseleccionar($id){
		$this->layout = '//layouts/blank';
		$cotizacion=$this->loadModel($id);
		$cotizacion->enviar_cotizacion_a_usuario = 0;
		if($cotizacion->save()){
			echo CJSON::encode(array(
	            'status'=>'success', true));
	        exit;
		}else{
			echo CJSON::encode(array(
	            'status'=>'Ha ocurrido un error.', true));
	        exit;
		}
	}

	public function actionElegirUsuario($prodord,$id)
	{
		
		$model=$this->loadModel($id);
		/*
		Cotizacion::model()->updateAll(array('elegido_usuario'=>null), 
									  "producto_orden = :po",
									  array(':po' => $prodord));

		$elegida = Cotizacion::model()->findByPk($id);
		$elegida->elegido_usuario = 1;
		$elegida->save();
		*/
		$model->setScenario("razon_eleccion_usuario");

		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['Cotizacion'])){
        		$model->razon_eleccion_usuario = $_POST['Cotizacion']['razon_eleccion_usuario'];
        		if($model->save()){

        			Cotizacion::model()->updateAll(array('elegido_usuario'=>null, 'razon_eleccion_usuario' => null), 
									  "producto_orden = :po",
									  array(':po' => $prodord));

        			$model->elegido_usuario = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
        			exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_elegirUsuario', array('model'=>$model), true)));
            exit;               
        }

	}
	
	public function actionverMas($id)
	{
      $regalos = CotizacionRegalos::model()->find(array(
                                                       'select' => 'sum(valor) as valor' ,
                                                       'condition' => 'id_cotizacion = :ic',
                                                       'params' => array(':ic' => $id)
                                                       ));
      $total_regalos = 0;
      if($regalos != null){
        $total_regalos = $regalos->valor;
      }

		$model=$this->loadModel($id);
            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_ver_mas_cotizacion', array('model'=>$model, 'regalos' => $total_regalos), true)));
            exit;               
	}
	
	public function actionElegirComite($prodord,$id)
	{
		
		$model=$this->loadModel($id);
		$model->setScenario("razon_eleccion_comite");

		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['Cotizacion'])){
        		$model->razon_eleccion_comite = $_POST['Cotizacion']['razon_eleccion_comite'];
        		if($model->save()){

        			Cotizacion::model()->updateAll(array('elegido_comite'=>null, 'razon_eleccion_comite' => null), 
									  "producto_orden = :po",
									  array(':po' => $prodord));

        			$model->elegido_comite = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
        			exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_elegirComite', array('model'=>$model), true)));
            exit;               
        }

	}

	public function actionEnviarUsuario($prodord,$id)
	{
		Cotizacion::model()->updateAll(array('elegido_usuario'=>null, 'enviar_a_usuario' => null), 
									  "producto_orden = :po",
									  array(':po' => $prodord));

		$elegida = Cotizacion::model()->findByPk($id);
		$elegida->enviar_a_usuario = 1;
		if($elegida->save()){
			echo CJSON::encode(array("status" => 'ok', 'grid' => "cotizacion-grid_" . $elegida->producto_orden));
		}else{
			echo CJSON::encode(array("status" => 'failure'));
		}

	}

	public function actionProveedor($prodord, $nit, $excluir)
	{
		
		$this->layout = '//layouts/blank';
		$model=new Cotizacion('search');
		$model->unsetAttributes();  // clear any default values
		
		$this->render('por_proveedor',array(
			'model'=>$model,
			'prodord' => $prodord,
			'nit' => $nit,
			'excluir' => $excluir
		));
	}

	public function actionSubir(){
		$this->layout = '//layouts/blank';
		$baseUrl = Yii::app()->request->baseUrl;
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerScriptFile($baseUrl . '/js/fileuploader.js');
		
		$arch=new AdjuntosCotizacion('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosCotizacion']))
			$arch->attributes=$_GET['AdjuntosCotizacion'];

		$this->render("subir", array('archivos' => $arch));
	}

	public function actionSubirArch(){
		$cot = $_GET['cotizacion'];

		$targetDir =   "/vol1" . 
	                   DIRECTORY_SEPARATOR . 
					   date('Y-m-d-H-i-s') .
			   DIRECTORY_SEPARATOR .
					   date('H-i-s') .
					   DIRECTORY_SEPARATOR . 
	                   $cot;



	    if (!file_exists($targetDir))
     	  @mkdir($targetDir,0775,true);   
	                   
		
		$upload = new qqFileUploader();
    	
    	$subio = $upload->handleUpload($targetDir, false, false);
    	if(isset($subio['success']) && $subio['success']){
    		$arch = new AdjuntosCotizacion;
    		$arch->cotizacion = $cot;
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

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/listar';
		$model=new Cotizacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cotizacion']))
			$model->attributes=$_GET['Cotizacion'];

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
		$model=Cotizacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='cotizacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

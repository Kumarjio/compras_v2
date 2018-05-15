<?php

class OrdenMarcoComprasController extends Controller
{
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
				'actions'=>array('create','update','adicionarProducto', 'traerCotizaciones','adicionarCotizacion','updateCotizacion','agregarPagosACotizacionOm','agregarPago', 'seleccionarParaEnvio','deseleccionar', 'elegir','elegirComite', 'varlidarStep', 'subirArch', 'subir','admin','rechazarProducto', 'downloadAdjunto','deleteAdjunto', 'actualizarPago', 'deletePago', 'deleteDetalleOM', 'buscarProductoMarco'),
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


	public function actionCreate()
	{
		if(Yii::app()->user->getState('analista_compras') || Yii::app()->user->getState('jefe_compras')){

			$model=new OrdenMarcoCompras;
			$model->id = $model->generarNumeroProvisional();
			$model->usuario_actual = Yii::app()->user->getState("id_empleado");
			$model->id_usuario = Yii::app()->user->getState("id_empleado");

			$model->setScenario('');
			$model->paso_wf = "swOrdenMarcoCompras/llenarocm";

			if(!$model->save()){
				print_r($model->getErrors());die;
			}
			$modelo = $model->id;

			$this->redirect(array("update", 'id' => $modelo));
		}
		else {
			throw new CHttpException(401,'No tiene permisos para ejecutar esta acción.');
		}
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->paso_actual = $model->paso_wf;
		$productos = new Producto('search');
		$productos->unsetAttributes();  // clear any default values
		if(isset($_GET['Producto']))
			$productos->attributes=$_GET['Producto'];

		$detalle = new OmProductoDetalle('search');
		$detalle->unsetAttributes();  // clear any default values
		if(isset($_GET['OmProductoDetalle']))
			$detalle->attributes=$_GET['OmProductoDetalle'];

		$proveedores=new Proveedor('search');
		$proveedores->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedores->attributes=$_GET['Proveedor'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrdenMarcoCompras']))
		{
			$model->attributes=$_POST['OrdenMarcoCompras'];
			if(Yii::app()->getRequest()->isAjaxRequest){
				if($_GET['paso'] == 1){
					$model->setScenario('paso_1');
				}
				else if( $_GET['paso'] == 2 ){
					$model->setScenario('paso_2');	
				}
				if($model->save()){
					if($_GET['paso'] == 3){
						
						echo CJSON::encode(array('status'=>'success', 'href' => $this->createUrl('admin'), 'msg'=>"Orden $model->id actualizada correctamente"));
						exit;
					}
					echo CJSON::encode(array('status'=>'success'));
					exit;
				}
				else{
					$htmlOptions = array();
					$htmlOptions['class'] = 'alert alert-block alert-danger';
					$html=CHtml::errorSummary($model, null, null, $htmlOptions);
					echo CJSON::encode(array(
		                'status'=>'error', 
		                'content'=>$html));
					exit;
					
				}
			}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'productos'=>$productos,
			'detalle'=>$detalle,
			'proveedores'=>$proveedores
		));
	}

	public function actionAdicionarProducto(){
		if(Yii::app()->getRequest()->isAjaxRequest){
			$id_producto = Yii::app()->getRequest()->getPost('producto');
			$id_orden_m = Yii::app()->getRequest()->getPost('id_om');
			$detalle = new OmProductoDetalle;
			$detalle->id_orden_marco = $id_orden_m;
			$detalle->producto = $id_producto;
			if($detalle->save())
				echo CJSON::encode(array('status'=>'success'));
			else
				echo CJSON::encode(array('status'=>'error', 'errores'=>$detalle->getErrors()));
			
		}

	}

	public function actionBuscarProductoMarco(){
		if(Yii::app()->getRequest()->isAjaxRequest){
			$id_producto = Yii::app()->getRequest()->getPost('producto');
			$disponibles = DisponiblesMarcoCompras::model()->findAllByAttributes(array('producto'=>$id_producto));
			$cant_ordenes = 0;
			$cantidad = 0;
			$valor = 0;
			if($disponibles){
				foreach ($disponibles as $d) {
					$cant_ordenes++;
					if($d->forma_negociacion == 'cantidad')
						$cantidad += $d->cant_valor;
					else
						$valor += $d->cant_valor;
				}
			}
			echo CJSON::encode(array('cant_ordenes'=>$cant_ordenes,'cantidad'=>$cantidad, 'valor'=>$valor, 'producto'=>$id_producto));
			
		}

	}

	public function actionVarlidarStep(){
		if(Yii::app()->getRequest()->isAjaxRequest){
			
			echo CJSON::encode(false);
		}

	}

	public function actionTraerCotizaciones(){

		$cotizaciones = new OmCotizacion('search');
		$paso_actual = OmProductoDetalle::model()->findByPk(Yii::app()->getRequest()->getParam('id'))->idOrdenMarco->paso_wf;
		$op = OmProductoDetalle::model()->findByPk(Yii::app()->getRequest()->getParam('id'));
		$this->renderPartial('_cotizaciones', array(
	        'id' => Yii::app()->getRequest()->getParam('id'),
	        'paso_actual'=>$paso_actual,
	        'model' => $cotizaciones,
	        'op' => $op
	    ));
	}

	public function actionAdicionarCotizacion()
	{
		$model=new OmCotizacion;
		if(isset($_GET['cid'])){
			$cot = Cotizacion::model()->findByPk($_GET['cid']);
			if($cot != null){
				$model->attributes = $cot->attributes;
			}
		}
		
		if(isset($_GET['id_detalle_om'])){
			$model->producto_detalle_om = $_GET['id_detalle_om'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model=$_GET['Proveedor'];

		if(isset($_POST['OmCotizacion']))
		{
			$model->attributes=$_POST['OmCotizacion'];
			//$model->cantidad = (double) str_replace([".", ","], ["","."], $model->cantidad) ;
			//$model->valor_unitario = (double) str_replace(array(".", ","), array("","."), $model->valor_unitario);
			//$model->trm = (double) str_replace([".", ","], ["","."], $model->trm);
			$model->producto_detalle_om = $_GET['id_detalle_om'];
			if($model->save()){
			  	/*$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array(
			  							'elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));	*/		
				
				//echo CJSON::encode(array('status'=>'success','grid' => "cotizaciones-grid-" . $model->producto_detalle_om));
				echo CJSON::encode(array('status'=>'success','grid' => $model->producto_detalle_om, 'modal'=>'modalCotizacion'));
            	exit; 
			}
			else {
				echo CJSON::encode(array(
                'status'=>'error', 
                'content'=>$this->renderPartial('_form_cotizacion', array('model'=>$model, 'proveedor_model' => $proveedor_model), true), 
                'modal'=>'modalCotizacion'));
            	exit; 
			}
				
		}

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_form_cotizacion', array('model'=>$model, 'proveedor_model' => $proveedor_model), true)));
            exit;               
        }else{
        	$this->render('create',array(
				'model'=>$model,
			));	
        }

		
	}


	public function actionUpdateCotizacion($id)
	{
		$model=OmCotizacion::model()->findByPk($id);
		
		
		if(isset($_GET['id_detalle_om'])){
			$model->producto_detalle_om = $_GET['id_detalle_om'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$proveedor_model=new Proveedor('search');
		//$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model=$_GET['Proveedor'];

		if(isset($_POST['OmCotizacion']))
		{
			$model->attributes=$_POST['OmCotizacion'];
			if($model->save()){
			  	/*$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array(
			  							'elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));	*/		
				
				//echo CJSON::encode(array('status'=>'success','grid' => "cotizaciones-grid-" . $model->producto_detalle_om));
				echo CJSON::encode(array('status'=>'success','grid' => $model->producto_detalle_om));
            	exit; 
			}
			else {
				echo CJSON::encode(array(
                'status'=>'error', 
                'content'=>$this->renderPartial('_form_cotizacion', array('model'=>$model, 'proveedor_model' => $proveedor_model), true)));
            	exit; 
			}
			
				
		}

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_form_cotizacion', array('model'=>$model, 'proveedor_model' => $proveedor_model), true)));
            exit;               
        }else{
        	$this->render('create',array(
				'model'=>$model,
			));	
        }

		
	}

	public function actionAgregarPagosACotizacionOm($id_cot)
	{

		$model = new OmCotizacionPagos('search');
		$cotizacion = OmCotizacion::model()->findByPk($id_cot);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OmCotizacionPagos']))
			$model=$_GET['OmCotizacionPagos'];

        echo CJSON::encode(array(
            'status'=>'success', 
            'content'=>$this->renderPartial('_pagos', array('model'=>$model, 'cotizacion'=>$cotizacion), true)));
        exit;   

		
	}

	public function actionAgregarPago($id_cot)
	{

		$model = new OmCotizacionPagos;
		$model->id_om_cotizacion = $id_cot;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['OmCotizacionPagos'])){
			$model->attributes=$_POST['OmCotizacionPagos'];
			$model->id_om_cotizacion = $id_cot;
			if($model->save()){
				echo CJSON::encode(array('status'=>'success', 'grid'=>$model->id_om_cotizacion));
		        exit; 
			}
			else {
				echo CJSON::encode(array(
		            'status'=>'error', 
		            'content'=>$this->renderPartial('_form_agregar_pago', array('model'=>$model), true)));
		        exit; 
			}
		}
        echo CJSON::encode(array(
            'status'=>'success', 
            'content'=>$this->renderPartial('_form_agregar_pago', array('model'=>$model, 'id_cotizacion'=>$id_cot), true)));
        exit;   

		
	}

	public function actionActualizarPago($id){
		$model=OmCotizacionPagos::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed 
		// $this->performAjaxValidation($model);

		if(isset($_POST['OmCotizacionPagos'])){
			$model->attributes=$_POST['OmCotizacionPagos'];
			if($model->save()){
				echo CJSON::encode(array('status'=>'success', 'grid'=>$model->id_om_cotizacion));
		        exit; 
			}
			else {
				echo CJSON::encode(array(
		            'status'=>'error', 
		            'content'=>$this->renderPartial('_form_agregar_pago', array('model'=>$model), true)));
		        exit; 
			}
		}

		echo CJSON::encode(array(
            'status'=>'success', 
            'content'=>$this->renderPartial('_form_agregar_pago', array('model'=>$model, 'id_cotizacion' => $model->id_om_cotizacion), true)));
        exit;
	}

	public function actionDeletePago($id){
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$cop = OmCotizacionPagos::model()->findByPk($id);
			$cotizacion = OmCotizacion::model()->findByPk($cop->id_om_cotizacion);
			$cop->delete();
			$model = new OmCotizacionPagos('search');

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['OmCotizacionPagos']))
				$model=$_GET['OmCotizacionPagos'];

	        echo CJSON::encode(array(
	            'status'=>'success', 
	            'content'=>$this->renderPartial('_pagos', array('model'=>$model, 'cotizacion'=>$cotizacion), true)));
	        exit;   

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionSeleccionarParaEnvio($id){
		$cotizacion=OmCotizacion::model()->findByPk($id);
		$pagos = OmCotizacionPagos::model()->findAllByAttributes(array('id_om_cotizacion' => $id));
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
			$cotizacion->setScenario('seleccion_envio');
			if($cotizacion->save()){
				echo CJSON::encode(array(
		            'status'=>'success', 'grid'=>$cotizacion->producto_detalle_om, true));
		        exit;
			}else{
				echo CJSON::encode(array(
		            'status'=>'Ha ocurrido un error.', 'error'=>$cotizacion->getErrors(), true));
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
		$cotizacion=OmCotizacion::model()->findByPk($id);
		$cotizacion->enviar_cotizacion_a_usuario = 0;
		$cotizacion->setScenario('seleccion_envio');
		if($cotizacion->save()){
			echo CJSON::encode(array(
	            'status'=>'success', 'grid'=>$cotizacion->producto_detalle_om, true));
	        exit;
		}else{
			echo CJSON::encode(array(
	            'status'=>'Ha ocurrido un error.', 'error'=>$cotizacion->getErrors(), true));
	        exit;
		}
	}

	public function actionElegir($prodord,$id)
	{
		
		$model=OmCotizacion::model()->findByPk($id);
		$model->setScenario("razon_eleccion_compras");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['OmCotizacion'])){
        		$model->razon_eleccion_compras = $_POST['OmCotizacion']['razon_eleccion_compras'];
        		$model->forma_negociacion = $_POST['OmCotizacion']['forma_negociacion'];
        		$model->cant_valor = $_POST['OmCotizacion']['cant_valor'];
        		if($model->save()){

        			OmCotizacion::model()->updateAll(array('elegido_compras'=>null, 'razon_eleccion_compras' => null), 
												  "producto_detalle_om = :po",
												  array(':po' => $prodord));

        			$model->elegido_compras = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'success', 'grid' => $model->producto_detalle_om));
        			exit;
        		}
        		else{
		            echo CJSON::encode(array(
		                'status'=>'failure', 
		                'content'=>$this->renderPartial('_elegirCompras', array('model'=>$model), true)));
		            exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_elegirCompras', array('model'=>$model), true)));
            exit;               
        }
		
	}

	public function actionElegirComite($prodord,$id)
	{
		
		$model=OmCotizacion::model()->findByPk($id);
		$model->setScenario("razon_eleccion_comite");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['OmCotizacion'])){
        		$model->razon_eleccion_comite = $_POST['OmCotizacion']['razon_eleccion_comite'];
        		$model->forma_negociacion = $_POST['OmCotizacion']['forma_negociacion'];
        		$model->cant_valor = $_POST['OmCotizacion']['cant_valor'];
        		if($model->save()){

        			OmCotizacion::model()->updateAll(array('elegido_comite'=>null, 'razon_eleccion_comite' => null), 
												  "producto_detalle_om = :po",
												  array(':po' => $prodord));

        			$model->elegido_comite = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'success', 'grid' => $model->producto_detalle_om));
        			exit;
        		}
        		else{
		            echo CJSON::encode(array(
		                'status'=>'failure', 
		                'content'=>$this->renderPartial('_elegirComite', array('model'=>$model), true)));
		            exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_elegirComite', array('model'=>$model), true)));
            exit;               
        }
		
	}

	public function actionSubir(){

		$this->layout = '//layouts/blank';
		$baseUrl = Yii::app()->request->baseUrl;
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerScriptFile($baseUrl . '/js/fileuploader.js');
		
		$arch=new OmAdjuntosCotizacion('search');
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
    		$arch = new OmAdjuntosCotizacion;
    		$arch->om_cotizacion = $cot;
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
public function actionDownloadAdjunto($id)
	{
		
		$model=OmAdjuntosCotizacion::model()->findByPk($id);

		//$mime = CFileHelper::getMimeType($model->tipi);
		$pos_punto=strripos($model->nombre,'.');
		$ext=substr($model->nombre,$pos_punto);
		if($pos_punto>17){
			$nombre=substr($model->nombre,0,20).$ext;
		}else{
			$nombre=$model->nombre;
		}
		
		header ("Content-type: octet/stream");
		header ("Content-disposition: attachment; filename=".$nombre.";");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		header("Content-Length: ".filesize($model->path));
		readfile($model->path);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteAdjunto($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$im = OmAdjuntosCotizacion::model()->findByPk($id);
			unlink($im->path);

			$im->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionRechazarProducto($id){

		$po = OmProductoDetalle::model()->findByPk($id);
		$po->setScenario("razon_rechazo");
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['OmProductoDetalle'])){
        		
        		$po->razon_rechazo = $_POST['OmProductoDetalle']['razon_rechazo'];
        		$po->rechazado = true;
                $po->usuario_rechazo = Yii::app()->user->getState("id_empleado");
                $po->fecha_rechazo = date('Y-m-d H:i:s');
        		if($po->save()){

        			Cotizacion::model()->updateAll(array('elegido_compras'=>null, 'enviar_cotizacion_a_usuario'=>null, 'razon_eleccion_compras' => null, 'elegido_usuario' => null, 'razon_eleccion_usuario' => null, 'elegido_comite' => null, 'razon_eleccion_comite' => null), 
												  "producto_orden = :po",
												  array(':po' => $po->id));

        			//echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
        			echo CJSON::encode(array('status'=>'success','grid' => $po->id));
            		exit; 
        			//echo CJSON::encode(array('status'=>'success', 'html' => $this->renderPartial('/orden/_producto_rechazado',array('po' => $po), true)));
        			//exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'failure', 
                'content'=>$this->renderPartial('_razon_rechazo', array('model'=>$po), true)));
            exit;               
        }
	}
	public function actionDeleteDetalleOM($id){
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			OmProductoDetalle::model()->findByPk($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

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
		$dataProvider=new CActiveDataProvider('OrdenMarcoCompras');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new OrdenMarcoCompras('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenMarcoCompras']))
			$model->attributes=$_GET['OrdenMarcoCompras'];

		$model_disponibles=new DisponiblesMarcoCompras('search');
		$model_disponibles->unsetAttributes();  // clear any default values
		if(isset($_GET['DisponiblesMarcoCompras']))
			$model_disponibles->attributes=$_GET['DisponiblesMarcoCompras'];

		$this->render('admin',array(
			'model'=>$model,
			'model_disponibles'=>$model_disponibles
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=OrdenMarcoCompras::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-marco-compras-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

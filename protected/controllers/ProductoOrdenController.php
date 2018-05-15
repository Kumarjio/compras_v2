<?php

class ProductoOrdenController extends Controller
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
	
	protected function beforeAction($action)
	{	
		parent::beforeAction($action);
		if($action->id == "create"){
			$model = Orden::model()->findByPk($_GET['orden']);
			if($model->usuario_actual != Yii::app()->user->id_empleado){
				throw new CHttpException(400,'El usuario no puede modificar esta orden.');
			}
		}

		return true;
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
                  'actions'=>array('create','update','admin','delete','agregarAsistente', 'actualizarProducto', 'rechazarProducto'),
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
		$this->layout = '//layouts/listar_sin_busqueda';
		$model=new ProductoOrden;

		$producto_model=new Producto('search');
		$producto_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Producto']))
			$producto_model->attributes=$_GET['Producto'];

		$cotizacion_model=new Cotizacion('search');
		$cotizacion_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cotizacion']))
			$cotizacion_model->attributes=$_GET['Cotizacion'];

		$reemplazos=new OrdenReemplazos('search');
		$reemplazos->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenReemplazos']))
			$reemplazos->attributes=$_GET['OrdenReemplazos'];


		$observacion_model=new ObservacionesWfs('search');
		$observacion_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ObservacionesWfs']))
			$observacion_model->attributes=$_GET['ObservacionesWfs'];
			
		$orden_solicitud_model=new OrdenSolicitud('search');
		$orden_solicitud_model->unsetAttributes();  // clear any default values
		        if(isset($_GET['OrdenSolicitud']))
		            $orden_solicitud_model->attributes=$_GET['OrdenSolicitud'];
		
		$asistentes_model=new AsistenteComite('search');
		$asistentes_model->unsetAttributes();  // clear any default values
		        if(isset($_GET['AsistenteComite']))
		            $asistentes_model->attributes=$_GET['OrdenSolicitud'];
		
		$empleados_model=new Empleados('search');
		$empleados_model->unsetAttributes();  // clear any default values
		        if(isset($_GET['Empleados']))
		            $empleados_model->attributes=$_GET['Empleados'];
		
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model->attributes=$_GET['Proveedor'];

		$orden = Orden::model()->with('tipoCompra')->findByPk($_GET['orden']);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(!(Yii::app()->request->isAjaxRequest)){
	        switch ($orden->paso_wf){
	          case 'swOrden/aprobar_por_comite':
	            $tipoComite = "Compras";
	            break;
	          case 'swOrden/aprobar_por_presidencia':
	            $tipoComite = "Presidencia";
				break;
	          default:
				break;
	        }
        }
		if(isset($_POST['ProductoOrden']))
		{
			$model->attributes=$_POST['ProductoOrden'];
			if($model->save())
				$this->redirect(array('create','orden'=>$_GET['orden']));
		}

		if(isset($_POST['Orden']))
		{
			$orden->attributes=$_POST['Orden'];
			if($orden->save()){
				//Si estamos en comité, redireccionar a ventana de comité
				if($orden->paso_wf == "swOrden/aprobado_por_comite"){
					$this->redirect(array('orden/comite'));
				}else{
					$this->redirect(array('orden/admin'));
				}
				
			}
				
		}

		$productos_orden = ProductoOrden::model()->with("producto0")->findAllByAttributes(array('orden' => $_GET['orden']));

		$this->render('create',array(
			'model'=>$model,
			'orden' => $orden,
			'producto_model' => $producto_model,
			'productos_orden' => $productos_orden,
			'cotizacion_model' => $cotizacion_model,
			'observacion_model' => $observacion_model,
			'orden_solicitud_model' => $orden_solicitud_model,
			'asistentes_model' => $asistentes_model,
			'empleados_model' => $empleados_model,
			'proveedor_model' => $proveedor_model,
			'tipoComite' => $tipoComite,
			'reemplazos' => $reemplazos
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

		if(isset($_POST['ProductoOrden']))
		{
			$model->attributes=$_POST['ProductoOrden'];
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
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionAgregarAsistente(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id_orden']) and isset($_GET['id_asistente'])){
				$q = AsistenteComite::model()->findAllByAttributes(array('id_orden' => $_GET['id_orden'], 'id_empleado' => $_GET['id_asistente']));
				if(!count($q) > 0){
					$asistente = new AsistenteComite;
					$asistente->id_orden = $_GET['id_orden'];
					$asistente->id_empleado = $_GET['id_asistente'];
					if($asistente->save()){
						echo CJSON::encode(array('status'=>'success'));
						exit;
					}else{
						echo CJSON::encode(array('status'=>'failure'));
						exit;
					}
				}else{
					echo CJSON::encode(array('status'=>'failure'));
				}
			}
			exit;               
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ProductoOrden');
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
		$model=new ProductoOrden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductoOrden']))
			$model->attributes=$_GET['ProductoOrden'];

		$this->model = $model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionActualizarProducto()
	{
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_POST['id_producto_orden']) and isset($_POST['id_producto'])){
				$po = ProductoOrden::model()->findByPk($_POST['id_producto_orden']);
				if(!($po == null)){
					$po->producto = $_POST['id_producto'];
					if($po->save()){
						echo CJSON::encode(array('status'=>'success'));
						exit;
					}else{
						echo CJSON::encode(array('status'=>'failure'));
						exit;
					}
				}else{
					echo CJSON::encode(array('status'=>'failure'));
				}
			}
			exit;               
		}
	}
	/*
    public function actionRechazarProducto()
	{
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_POST['id_orden_solicitud'])){
              $po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $_POST['id_orden_solicitud']));
				if(!($po == null)){
                    $po->rechazado = true;
                    $po->usuario_rechazo = Yii::app()->user->id_empleado;
                    $po->fecha_rechazo = date('Y-m-d H:i:s');
                    // TODO: Deseleccionar todas las cotizaciones marcadas
                    Cotizacion::model()->updateAll(array('elegido_compras'=>null, 'razon_eleccion_compras' => null, 'elegido_usuario' => null, 'razon_eleccion_usuario' => null, 'elegido_comite' => null, 'razon_eleccion_comite' => null), 
												  "producto_orden = :po",
												  array(':po' => $po->id));
					if($po->save()){
                      echo CJSON::encode(array('status'=>'success', 'html' => $this->renderPartial('/orden/_producto_rechazado',array('po' => $po), true)));
						exit;
					}else{
						echo CJSON::encode(array('status'=>'failure'));
						exit;
					}
				}else{
					echo CJSON::encode(array('status'=>'failure'));
				}
			}
			exit;               
		}
	}
	*/

	public function actionRechazarProducto($id)
	{
		$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $id));
		$po->setScenario("razon_rechazo");
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['ProductoOrden'])){
        		
        		$po->razon_rechazo = $_POST['ProductoOrden']['razon_rechazo'];
        		$po->rechazado = true;
                $po->usuario_rechazo = Yii::app()->user->id_empleado;
                $po->fecha_rechazo = date('Y-m-d H:i:s');
        		if($po->save()){

        			Cotizacion::model()->updateAll(array('elegido_compras'=>null, 'enviar_cotizacion_a_usuario'=>null, 'razon_eleccion_compras' => null, 'elegido_usuario' => null, 'razon_eleccion_usuario' => null, 'elegido_comite' => null, 'razon_eleccion_comite' => null), 
												  "producto_orden = :po",
												  array(':po' => $po->id));

        			//echo CJSON::encode(array('status'=>'ok', 'grid' => "cotizacion-grid_" . $model->producto_orden));
        			echo CJSON::encode(array('status'=>'success', 'html' => $this->renderPartial('/orden/_producto_rechazado',array('po' => $po), true)));
        			exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_razonRechazo', array('model'=>$po), true)));
            exit;               
        }
		

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ProductoOrden::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-orden-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

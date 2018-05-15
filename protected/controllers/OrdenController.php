<?php

class OrdenController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	public $paso_actual;
	public $model;

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	protected function beforeAction($action)
	{	

		parent::beforeAction($action);
		if($action->id == "update"){
			$this->model = $this->loadModel($_GET['id']);
			if($this->model->usuario_actual != Yii::app()->user->id_empleado){
				throw new CHttpException(400,'El usuario no puede modificar esta orden.');
			}else{

              list($url, $parametro) = $this->model->urlPaso();

              if($url != "/orden/update"){
                if($parametro == "orden")
                  $this->redirect(array($url, 'orden' => $_GET['id']));
                else
                  $this->redirect(array($url, 'id' => $_GET['id']));
              }
              
			}
		}else{
			if($action->id == "vincular"){
				$this->model = $this->loadModel($_GET['id']);
				if($this->model->usuario_actual != Yii::app()->user->id_empleado){
					throw new CHttpException(400,'El usuario no puede modificar esta orden.');
				}
			}
			if($action->id == "realizarPedido"){
				$this->model = $this->loadModel($_GET['id']);
				if($this->model->usuario_actual != Yii::app()->user->id_empleado){
					throw new CHttpException(400,'El usuario no puede modificar esta orden.');
				}else{

				}
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
			      'actions'=>array('index','view','tipocartera','autosave','autosavesol','readonly','cancelar','suspender','aprobarOrden'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
			      'actions'=>array('create',
			      	'update',
			      	'admin',
			      	'delete',
			      	'createSolicitud', 
			      	'updateSolicitud', 
			      	'deleteSolicitud', 
			      	'createCostos', 
			      	'updateCostos', 
			      	'deleteCostos', 
			      	'createProveedor', 
			      	'updateProveedor', 
			      	'deleteProveedor', 
			      	'viewSolicitud',
			      	'CargarUltimosAsistentesComite', 
			      	'CargarAsistentesHabitualesComite', 
			      	'createDireccion', 
			      	'updateDireccion', 
			      	'deleteDireccion', 
			      	'delegar', 
			      	'print', 
			      	'subir', 
			      	'subirarch', 
			      	'subir_o', 
			      	'subirarch_o', 
			      	'vincular', 
			      	'enviarAUsuario', 
			      	'realizarPedido',
			      	'ColocarPedido', 
			      	'CrearOrdenCompra', 
			      	'anteriores',
			      	'todas', 
			      	'todasArea', 
			      	'aprobadas', 
			      	'suspendida',
			      	'suspendidaACancelada', 
			      	'reanudar',
			      	'editarSuspendida',
			      	'comite',
			      	'crearReemplazo',
			      	'deleteReemplazo',
			      	'solicitarCancelacion',
			      	'informeGastoAhorro',
			      	'CorreoPrueba',
			      	'steps',
		      		'crearOrdenPedido',
		      		'solicitarProductoMarco',
		      		'deleteDetPed',
		      		'relacionarProductoSolicitud',
		      		'updateProductoOrden',
		      		'traerCotizaciones',
	      			'adicionarCotizacion',
	      			'agregarPagosACotizacionOp',
	      			'agregarPago',
	      			'seleccionarParaEnvio',
	      			'elegirCotCompras',
					'elegirComite',
					'elegir',
					'updateCotizacionOp',
					'rechazarProducto',
					'aprobarConsumo'),
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

	public function actionSteps(){

		$this->render("_form_steps");
	}

	public function actionInformeGastoAhorro(){
		$this->layout = '//layouts/listar_sin_busqueda';
		$this->render("informes_reportico",array('reporte' => "totalporcompra.xml"));
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

    public function actionAprobarOrden($id){
      Yii::app()->user->setState('desde_correo',true);
        $model = $this->loadModel($id);
        $hash = HashesAprobacion::model()->findByAttributes(array('id_orden' => $model->id));
        if(isset($_GET['key']) == false or $hash == null or $hash->hash != $_GET['key']){
          Yii::app()->user->setState('desde_correo',false);
          throw new CHttpException(400,'El usuario no puede modificar esta orden.');
        }else{
          $next_steps = SWHelper::nextStatuslistData($model);
          if($_GET['step'] != $model->paso_wf and $next_steps[$_GET['step']] != 'Guardar sin enviar' and (!(in_array($_GET['step'],array('swOrden/devolucion', 'swOrden/cancelada', 'swOrden/suspendida'))))){
            if($model->paso_wf == 'swOrden/llenaroc'){
              $model->validacion_usuario = 1;
            }
            if($model->paso_wf == 'swOrden/llenaroc'){
              $model->validacion_jefe = 1;
            }
            $model->paso_wf = $_GET['step'];
          }
          if($model->save()){
            Yii::app()->user->setFlash('success', "Orden aprobada exitosamente.");
          }else{
            Yii::app()->user->setFlash('error', "No ha sido posible aprobar esta orden haciendo uso del link. Es necesario que ingrese a la plataforma.");
          }
          Yii::app()->user->setState('desde_correo',false);
        }
        $this->render('aprobar_orden');
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		/*	
		$pendiente = Orden::model()->findAllByAttributes(array(
			'id_usuario' => Yii::app()->user->getState("id_empleado"),
			'paso_wf' => "swOrden/llenaroc"
		));


		if(count($pendiente) == 0){
			$model=new Orden;
			$model->paso_wf = "swOrden/llenaroc";
			$model->usuario_actual = Yii::app()->user->getState("id_empleado");
			$model->id_usuario = Yii::app()->user->getState("id_empleado");
			$model->save();
			$modelo = $model->id;
		}else{
			$modelo = $pendiente[0]['id'];
		}
		*/
		$model=new Orden;
		$model->id = Orden::model()->idProvisional();
		$model->usuario_actual = Yii::app()->user->getState("id_empleado");
		$model->id_usuario = Yii::app()->user->getState("id_empleado");

		$res = Gerencias::model()->jefaturaYGerencia();
		if(count($res) != 0){
			if(!isset($res[0]['val_gerencia'])){
		  	  $model->id_vicepresidencia = $res[0]['id_vice'];
		      $model->id_vicepresidente = $res[0]['id_vicepre'];
			  $model->id_gerencia = $res[0]['id_gerencia'];
			  $model->id_gerente = $res[0]['id_gerente'];
		  	  $model->id_jefatura = $res[0]['id_jefatura'];
		      $model->id_jefe = $res[0]['id_jefe'];

			  //Caso en el que el jefe es igual al gerente. (Analistas sin jefe, solo con gerente)
	          //$jefe_gerente = Orden::model()->getJefeJefatura(Yii::app()->user->getState("id_empleado"));
			  /*if(count($jefe_gerente) > 0){
			      $model->id_jefatura = $jefe_gerente[0]['id_jefatura'];
			      $model->id_jefe = $jefe_gerente[0]['id_jefe_gerente'];
			  }else{
			  	  $model->id_jefatura = $res[0]['id_jefatura'];
			      $model->id_jefe = $res[0]['id_jefe'];
			  }*/
		  
		  	}
		}

		$model->setScenario('');
		$model->paso_wf = "swOrden/llenaroc";
		$model->save();


		$modelo = $model->id;

		$this->redirect(array("update", 'id' => $modelo));

		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->model;
		
		//echo $model->usuario_actual;
		//exit;

		$this->paso_actual = $model->paso_wf;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$centro_costos_model=new CentroCostos('search');
		$centro_costos_model->unsetAttributes();  // clear any default values
		if(isset($_GET['CentroCostos']))
			$centro_costos_model->attributes=$_GET['CentroCostos'];

		$cuenta_contable_model=new CuentaContable('search');
		$cuenta_contable_model->unsetAttributes();  // clear any default values
		if(isset($_GET['CuentaContable']))
			$cuenta_contable_model->attributes=$_GET['CuentaContable'];
		/*
		$proveedores_model=new OrdenProveedor('search');
		$proveedores_model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenProveedor']))
			$proveedores_model->attributes=$_GET['OrdenProveedor'];
		*/
		$observacion_model=new ObservacionesWfs('search');
		$observacion_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ObservacionesWfs']))
			$observacion_model->attributes=$_GET['ObservacionesWfs'];

		$reemplazos=new OrdenReemplazos('search');
		$reemplazos->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenReemplazos']))
			$reemplazos->attributes=$_GET['OrdenReemplazos'];
		
		$productos=new Producto('search');
		$productos->unsetAttributes();  // clear any default values
		if(isset($_GET['Producto']))
			$productos->attributes=$_GET['Producto'];

		$modelGrid = new OrdenProducto('search');
		$modelGrid->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenProducto']))
			$modelGrid->attributes=$_GET['OrdenProducto'];

		$orden_solicitud = new OrdenSolicitud('search');
		$orden_solicitud->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenSolicitud']))
			$orden_solicitud->attributes=$_GET['OrdenSolicitud'];
		
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model->attributes=$_GET['Proveedor'];
		
		$traza=new TrazabilidadWfs('search');
		$traza->unsetAttributes();  // clear any default values
		if(isset($_GET['TrazabilidadWfs']))
			$traza->attributes=$_GET['TrazabilidadWfs'];


		
		$activerecord=new ActiveRecordLog('search');
		$activerecord->unsetAttributes();  // clear any default values
		if(isset($_GET['ActiveRecordLog']))
			$activerecord->attributes=$_GET['ActiveRecordLog'];


		if(Yii::app()->getRequest()->isAjaxRequest){
			if(isset($_GET['paso'])){
				$model->attributes = $_POST['Orden'];
				if($_GET['paso'] == 1){
					$model->setScenario('paso_1');
				}
				if($_GET['paso'] == 3){
					if($this->paso_actual == "swOrden/analista_compras")
						$model->setScenario('paso_3_analista');
					else
						$model->setScenario('paso_3');
				}
				if($_GET['paso'] == 4){
					$model->setScenario('update');
				}
				if($model->save()){
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

		}
		elseif(isset($_POST['Orden']))
		{
			//Se reescribe la variable post debido a una orden con demaciada data
			$b = array();
			parse_str(file_get_contents("php://input"), $b);
			$_POST = $b;

		  if($model->paso_wf == "swOrden/llenaroc" && $_POST['Orden']['paso_wf'] == "swOrden/llenaroc"){
		    $model->setScenario("validarbase");
		  }
		        if($model->paso_wf == $_POST['Orden']['paso_wf'])
			{
				foreach ($_POST['Orden'] as $key => $value) {
					if($value != ""){
						$model->$key = $value;
					}
				}

			}else{
				
				$model->attributes = $_POST['Orden'];
			
			}
			if(!isset($_POST['Orden']['id_gerencia']) && ($model->paso_wf == "swOrden/llenaroc" || $model->paso_wf == "swOrden/devolucion" || $model->paso_wf == "swOrden/jefe" || $model->paso_wf == "swOrden/jefe_ventas_alkosto" )  ){
				$model->id_gerencia = "";
			}
			$model->paso_wf = $_POST['Orden']['paso_wf'];
			// Asignamos la Observación
			$model->observacion = $_POST['Orden']['observacion'];
			
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			'centro_costos_model' => $centro_costos_model,
			'cuenta_contable_model' => $cuenta_contable_model,
			'observacion_model' => $observacion_model,
			'paso_actual' => $this->paso_actual,
			'reemplazos' => $reemplazos,
			'productos'=>$productos,
			'Mgrid' => $modelGrid,
			'orden_solicitud' => $orden_solicitud,
			'proveedor_model' => $proveedor_model,
			'traza' => $traza,
			'activerecord'=>$activerecord
		));

	}

	public function actionUpdateProductoOrden($orden)
	{
		
		
		//$this->paso_actual = $model->paso_wf;
		//$this->layout = '//layouts/listar_sin_busqueda';

		$centro_costos_model=new CentroCostos('search');
		$centro_costos_model->unsetAttributes();  // clear any default values
		if(isset($_GET['CentroCostos']))
			$centro_costos_model->attributes=$_GET['CentroCostos'];

		$cuenta_contable_model=new CuentaContable('search');
		$cuenta_contable_model->unsetAttributes();  // clear any default values
		if(isset($_GET['CuentaContable']))
			$cuenta_contable_model->attributes=$_GET['CuentaContable'];

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

		$orden_producto = new OrdenProducto('search');
		$orden_producto->unsetAttributes();  // clear any default values
		if(isset($_GET['OrdenProducto']))
			$modelGrid->attributes=$_GET['OrdenProducto'];

		$traza=new TrazabilidadWfs('search');
		$traza->unsetAttributes();  // clear any default values
		if(isset($_GET['TrazabilidadWfs']))
			$traza->attributes=$_GET['TrazabilidadWfs'];


		
		$activerecord=new ActiveRecordLog('search');
		$activerecord->unsetAttributes();  // clear any default values
		if(isset($_GET['ActiveRecordLog']))
			$activerecord->attributes=$_GET['ActiveRecordLog'];


		$orden = Orden::model()->with('tipoCompra')->findByPk($_GET['orden']);
		$paso_actual = $orden->paso_wf;

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

		if(Yii::app()->getRequest()->isAjaxRequest){
			if(isset($_GET['paso'])){
				$orden->attributes = $_POST['Orden'];
				if($_GET['paso'] == 1){
					$orden->setScenario('paso_1');
				}
				if($_GET['paso'] == 2){
					if($paso_actual == "swOrden/validacion_cotizaciones" || $paso_actual == "swOrden/gerente_compra" || $paso_actual == "swOrden/vicepresidente_compra"){
						if($orden->elegirCotizacionFinal())
							$orden->setScenario("eleccion_final_cotizaciones");
						else
							$orden->setScenario('eleccion_cotizaciones');
					}
					else if($paso_actual == "swOrden/en_negociacion"){
						$orden->setScenario('ingresar_cotizaciones');
					}
				}
				if($_GET['paso'] == 3){
					$orden->setScenario('update');
				}
				
				if($orden->save()){
					echo CJSON::encode(array('status'=>'success'));
					exit;
				}
				else{
					$htmlOptions = array();
					$htmlOptions['class'] = 'alert alert-block alert-danger';
					$html=CHtml::errorSummary($orden, null, null, $htmlOptions);
					echo CJSON::encode(array(
		                'status'=>'error', 
		                'content'=>$html));
					exit;
					
				}
			}

		}
		elseif(isset($_POST['Orden']))
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

		//$productos_orden = ProductoOrden::model()->with("producto0")->findAllByAttributes(array('orden' => $_GET['orden']));

		$this->render('update',array(
			'model'=>$orden,
			'paso_actual' => $paso_actual,
			'productos' => $producto_model,
			'orden_producto' => $orden_producto,
			'productos_orden' => $productos_orden,
			'cotizacion_model' => $cotizacion_model,
			'observacion_model' => $observacion_model,
			'orden_solicitud_model' => $orden_solicitud_model,
			'asistentes_model' => $asistentes_model,
			'empleados_model' => $empleados_model,
			'proveedor_model' => $proveedor_model,
			'tipoComite' => $tipoComite,
			'reemplazos' => $reemplazos,
			'centro_costos_model' => $centro_costos_model,
			'cuenta_contable_model' => $cuenta_contable_model,
			'traza' => $traza,
			'activerecord'=>$activerecord
		));

	}
	public function actionCorreoPrueba(){
		$model = new Orden;
		$model->sendPrueba();
	}
	public function actionReanudar($id){

		$this->model = $this->loadModel($_GET['id']);
		if($this->model->usuario_actual != Yii::app()->user->id_empleado  || $this->model->paso_wf != "swOrden/suspendida"){
			throw new CHttpException(400,'El usuario no puede modificar esta orden.');
		}else{
			

			$res = $this->model->reanudar();
			//El modelo cambió, entonces refresquemos.
			$this->model = $this->loadModel($_GET['id']);

			if($res){
				$this->model->enviarEmail();
				$this->redirect("admin");
			}else{
				throw new CHttpException(400,'No se pudo reanudar la solicitud.');
			}
		}

	}

	public function actionEditarSuspendida($id){
		$this->model = $this->loadModel($_GET['id']);
		if($this->model->usuario_actual != Yii::app()->user->id_empleado || $this->model->paso_wf != "swOrden/suspendida"){
			throw new CHttpException(400,'El usuario no puede modificar esta orden.');
		}else{
			

			$res = $this->model->editarSuspendida();
			//El modelo cambió, entonces refresquemos.

			if($res){
				$this->redirect(array("update", "id" => $id));
			}else{
				throw new CHttpException(400,'No se pudo reanudar la solicitud.');
			}
		}
	}

	
	public function actionVincular($id){
		$model = $this->loadModel($id);
		$proveedores = Proveedor::model()->findAllByPk($model->proveedores());
		

		$this->render('vincular', array('orden' => $model, 'proveedores' => $proveedores));
	}
	
	public function actionEnviarAUsuario($id){
		$model = $this->loadModel($id);
		if($model->sePuedeEnviarAUsuario()){
			$model->paso_wf = "swOrden/usuario";
			if($model->save()){
				$this->redirect(array('admin'));
				exit;
			}else{
				Yii::app()->user->setFlash('error', "Ha ocurrido un error.");
				$this->redirect(array('vincular', 'id' => $id));
			}
		}else{
			Yii::app()->user->setFlash('error', "Esta orden no se puede enviar al usuario aún. Verifique el estado de los Workflows de cada uno de los proveedores.");
			$this->redirect(array('vincular', 'id' => $id));
		}
	}
	
	public function actionRealizarPedido($id){
		$observacion_model=new ObservacionesWfs('search');
		$observacion_model->unsetAttributes();  // clear any default values
		if(isset($_GET['ObservacionesWfs']))
			$observacion_model->attributes=$_GET['ObservacionesWfs'];

		$congelada = OrdenReemplazos::model()->findByAttributes(array('orden_vieja' => $id));
		$puede_editar = true;
		if($congelada !== NULL && $congelada->congelar == 1){
			$puede_editar = false;
			$nueva = $congelada->orden_nueva;
		}
		$model = $this->loadModel($_GET['id']);
		if($model->paso_wf == "swOrden/usuario" and $model->usuario_actual == Yii::app()->user->id_empleado){
			$this->render('realizar_pedido', array('model' => $model, 
											       'puede_editar' => $puede_editar, 
											       'nueva' => $nueva, 
											       'observaciones' => $observacion_model));
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}
	
	public function actionColocarPedido($id){
		$model = $this->loadModel($_GET['id']);
		if($model->paso_wf == "swOrden/usuario" and $model->usuario_actual == Yii::app()->user->id_empleado){
			if(isset($_POST['DetalleOrdenCompraOp'])){
				$is = $_POST['DetalleOrdenCompraOp'];

				$guardados = 0;
				//foreach($is as $i){
					//$js = $i;
					foreach($is as $j){
						if($j['cantidad'] != null and $j['cantidad'] != '' and $j['cantidad'] > 0){
                          $do = DetalleOrdenCompraOp::model()->findByAttributes(array('id_orden_producto' => $j['id_orden_producto'], 'id_orden' => $j['id_orden'], 'id_producto' => $j['id_producto'], 'id_proveedor' => $j['id_proveedor'], 'id_orden_compra' => null));
							if($do == null){
								$do = new DetalleOrdenCompraOp;
								$do->id_orden_producto = $j['id_orden_producto'];
								$do->id_orden = $j['id_orden'];
								$do->id_producto = $j['id_producto'];
								$do->id_proveedor = $j['id_proveedor'];
								$do->id_cotizacion = $j['id_cotizacion'];
								$do->id_cotizacion_om = $j['id_cotizacion_om'];
								$do->cantidad = $j['cantidad'];
                                $do->fecha_entrega = $j['fecha_entrega'];
							}else{
								$do->cantidad += $j['cantidad'];
                                $do->fecha_entrega = $j['fecha_entrega'];
							}
							if($do->save()){
								$guardados += 1;
							}
						}
					}
				//}
			}
			if($guardados > 0){
				Yii::app()->user->setFlash('success', "Se crearon ".$guardados." nuevas solicitudes.");
			}else{
				Yii::app()->user->setFlash('error', "No se creó ninguna solicitud nueva.");
			}
			$this->redirect(array('/DetalleOrdenCompraOp/admin', 'id_orden' => $id));
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}
	
	public function actionCrearOrdenCompra($id){
		$model = $this->loadModel($_GET['id']);
		if($model->paso_wf == "swOrden/usuario" and $model->usuario_actual == Yii::app()->user->id_empleado){
			$productos = DetalleOrdenCompraOp::model()->findAllByAttributes(array('id_orden' => $id, 'id_orden_compra' => null));
			if(count($productos) > 0){
				$proveedores = Proveedor::model()->findAllByPk($model->proveedores());
				foreach($proveedores as $p){
					$productos_p = DetalleOrdenCompraOp::model()->findAllByAttributes(array('id_orden' => $id, 'id_orden_compra' => null, 'id_proveedor' => $p->nit));
					if(count($productos_p) > 0){
						$oc = new OrdenCompra;
						$oc->creacion = date('Y-m-d H:i:s');
						$oc->id_orden = $id;
						$oc->id_usuario = $model->usuario_actual;
						$oc->save();
						foreach($productos_p as $pp){
							$pp->id_orden_compra = $oc->id;
							$pp->save();
						}
					}
				}

				$this->finalizarOrden($id);


			}else{
				Yii::app()->user->setFlash('error', "No se puede crear una orden de compra sin productos.");
				$this->redirect(array('/DetalleOrdenCompraOp/admin', 'id_orden' => $id));
			}
			$this->redirect(array('/OrdenCompra/admin', 'id_orden' => $id));
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}

	public function finalizarOrden($orden){
		$solicitudes = OrdenProducto::model()->findAll(
			array(
				'condition' => 'id_orden = :o',
				'params' => array(':o' => $orden)
			)
		);

		$suma = 0;
		foreach($solicitudes as $i => $p){
      		if($p->rechazado)
        		continue;
			$suma += $p->cantidadDisponible();
		}

		if($suma == 0){
			$orden = Orden::model()->findByPk($orden);
			$orden->paso_wf = "swOrden/finalizada";
			$orden->save();

			$this->createTraz($orden);
		}
		
	}

	public function createTraz($orden){

		$t = new TrazabilidadWfs;
		$t->model = "Orden";
		$t->idmodel = $orden->id;
		$t->estado_anterior = "swOrden/usuario";
		$t->estado_nuevo = "swOrden/finalizada";
		$t->usuario_nuevo = $orden->usuario_actual;
		$t->usuario_anterior = $orden->usuario_actual;
		$t->save();

	}

	public function actionAutoSave($id){
	  $model = $this->loadModel($_GET['id']);
	  $model->setScenario("autosave");
	  if(isset($_POST['Orden']))
	    {

	      foreach ($_POST['Orden'] as $key => $value) {
		if($value != "" && $key != "observacion" && $key != "paso_wf"){
		  $model->$key = $value;
		}
	      }
	      
	      if($model->save())
		echo "ok";

	      exit;
	      
	    }

	}


	public function actionAutoSaveSol($id){
	  	$model = OrdenSolicitud::model()->findByPk($_GET['id']);
	  	$campo = $_POST['campo'];
	  	$valor = $_POST['valor'];
      	if($model != null){
			$model->setScenario("autosave");
		  	
			if($campo == "requiere_polizas"){
				if($value == 0){
					$model->requiere_polizas_cumplimiento = 0;
					$model->requiere_seriedad_oferta = 0;
					$model->requiere_buen_manejo_anticipo = 0;
					$model->requiere_calidad_suministro = 0;
					$model->requiere_calidad_correcto_funcionamiento = 0;
					$model->requiere_pago_salario_prestaciones = 0;
					$model->requiere_estabilidad_oferta = 0;
					$model->requiere_calidad_obra = 0;
					$model->requiere_responsabilidad_civil_extracontractual = 0;
				}
			}else{
				$model->$campo = $valor;	
			}
		      
			if($model->save())
			  echo "ok";
			exit;
      	}
	    

	}

	
	public function actionCreateSolicitud(){
		if(Yii::app()->request->isAjaxRequest){
			
			/*
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_orden_solicitud_form', array('model' => $orden_solicitud_model), true)));
			exit;               
			*/
			$model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
			$model_orden_solicitud_costos->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudCostos']))
				$model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
				
			$model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
			$model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudProveedor']))
				$model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
				
			$model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
			$model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudDireccion']))
				$model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];
				
			$arch=new AdjuntosOrden('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosOrden'])){
				$arch->attributes=$_GET['AdjuntosOrden'];
			}
				
			if(isset($_GET['ajax'])){
				/*$a = explode('-',$_GET['ajax']);
				if(isset($a[4]))
				  $id = $a[4];
				else
				  $id = $a[3];*/
				$orden_solicitud_model = OrdenSolicitud::model()->findByPk($_GET['id_orden_solicitud']);
			}else{
				$orden_solicitud_model = new OrdenSolicitud;
				$orden_solicitud_model->id_orden = $_GET['id_orden'];
				$orden_solicitud_model->save();
			}

			if(isset($_POST['OrdenSolicitud']['id'])){
				//die('llego');
				$orden_solicitud_model = OrdenSolicitud::model()->findByPk($_POST['OrdenSolicitud']['id']);
				$orden_solicitud_model->attributes = $_POST['OrdenSolicitud'];
				if($orden_solicitud_model->save()){
					echo CJSON::encode(array('status'=>'success'));
				}
				else{
					//echo CJSON::encode(array('status'=>'error', 'content'=>print_r($orden_solicitud_model->getErrors(), true)));exit;
					echo CJSON::encode(array('status'=>'error', 'content'=> $this->renderPartial('_orden_solicitud_form2', array('model' => $orden_solicitud_model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true, true)));
					exit;
				}
			}
			echo CJSON::encode(array('status'=>'success', 'content'=> $this->renderPartial('_orden_solicitud_form2', array('model' => $orden_solicitud_model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true, true)));
			//echo $this->render('_orden_solicitud_form2', array('model' => $orden_solicitud_model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
		}
	}
	
	public function actionUpdateSolicitud(){
		if(Yii::app()->request->isAjaxRequest){
			$model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
			$model_orden_solicitud_costos->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudCostos']))
				$model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
				
			$model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
			$model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudProveedor']))
				$model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
				
			$model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
			$model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudDireccion']))
				$model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];

			$arch=new AdjuntosOrden('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosOrden'])){
				$arch->attributes=$_GET['AdjuntosOrden'];
			}

			if(isset($_GET['actualizar_modal'])){
				$model = OrdenSolicitud::model()->findByPk($_GET['id_orden_solicitud']);
				if(Yii::app()->request->isPostRequest)
				{
					$model->attributes = $_POST['OrdenSolicitud'];
					if($model->save()){
						echo CJSON::encode(array('status'=>'success'));
						exit;
					}
					else{
						//echo CJSON::encode(array('status'=>'error', 'content'=>print_r($model->getErrors(), true)));exit;
						echo CJSON::encode(array('status'=>'error', 'content'=> $this->renderPartial('_orden_solicitud_form2', array('model' => $model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true, true)));
						exit;
					}

				}
				else{
					echo CJSON::encode(array('status'=>'success', 'content'=> $this->renderPartial('_orden_solicitud_form2', array('model' => $model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true, true)));
					exit;
				}
			}

			if(isset($_POST['OrdenSolicitud']) && $_POST['OrdenSolicitud']['id'] == -1){
				$model = new OrdenSolicitud;
				$model->id_orden = $_GET['id_orden'];
			}else{
				if(isset($_GET['ajax'])){
					$a = explode('-',$_GET['ajax']);
					$id = $a[4];
					$model = OrdenSolicitud::model()->findByPk($id);
				}else{
					$model = OrdenSolicitud::model()->findByPk($_POST['OrdenSolicitud']['id']);
				}
			}
			if(isset($_POST['OrdenSolicitud']['id'])){
				$model->attributes=$_POST['OrdenSolicitud'];
				$model->save();
				if(isset($_POST['ro'])){
					echo $this->render('_orden_solicitud_readonly', array('model' => $model, 'divid' => ($_POST['OrdenSolicitud']['id'] == -1)?'':$model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
				}else{
					echo $this->render('_orden_solicitud_form', array('model' => $model, 'divid' => ($_POST['OrdenSolicitud']['id'] == -1)?'':$model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
				}
				exit;
			}		
			if(isset($_POST['ro'])){
				echo $this->render('_orden_solicitud_readonly', array('model' => $model, 'divid' => ($_POST['OrdenSolicitud']['id'] == -1)?'':$model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
			}else{	
				echo $this->render('_orden_solicitud_form', array('model' => $model, 'divid' => $model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
			}
			exit;               
		}
	}
	
	public function actionRelacionarProductoSolicitud(){
		if(Yii::app()->request->isAjaxRequest){
			$model_orden_solicitud_costos=new OrdenSolicitudCostos('search');
			$model_orden_solicitud_costos->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudCostos']))
				$model_orden_solicitud_costos->attributes=$_GET['OrdenSolicitudCostos'];
				
			$model_orden_solicitud_proveedor=new OrdenSolicitudProveedor('search');
			$model_orden_solicitud_proveedor->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudProveedor']))
				$model_orden_solicitud_proveedor->attributes=$_GET['OrdenSolicitudProveedor'];
				
			$model_orden_solicitud_direccion=new OrdenSolicitudDireccion('search');
			$model_orden_solicitud_direccion->unsetAttributes();  // clear any default values
			if(isset($_GET['OrdenSolicitudDireccion']))
				$model_orden_solicitud_direccion->attributes=$_GET['OrdenSolicitudDireccion'];

			$arch=new AdjuntosOrden('search');
			$arch->unsetAttributes();  // clear any default values
			if(isset($_GET['AdjuntosOrden'])){
				$arch->attributes=$_GET['AdjuntosOrden'];
			}
			$productos = new Producto('search');
			$productos->unsetAttributes();  // clear any default values
			if(isset($_GET['Producto']))
				$productos->attributes=$_GET['Producto'];

			$model = OrdenSolicitud::model()->findByPk($_GET['id_orden_solicitud']);
			$orden_producto = OrdenProducto::model()->findByAttributes(array('id_orden_solicitud'=>$model->id));
			if(isset($_POST['OrdenSolicitud'])){
				$model->setScenario('validacion_compras');
				$model->attributes = $_POST['OrdenSolicitud'];
				if($model->save()){
					if(!$orden_producto)
						$orden_producto = new OrdenProducto;
					$orden_producto->id_orden = $model->id_orden;
				  	$orden_producto->id_producto = $model->id_producto;
				  	$orden_producto->cantidad = $model->cantidad;
				  	$orden_producto->detalle = $model->detalle;
				  	$orden_producto->fecha_entrega = $model->fecha_entrega;
				  	$orden_producto->responsable = $model->ordenSolicitudDirecciones[0]->responsable;
				  	$orden_producto->direccion_entrega = $model->ordenSolicitudDirecciones[0]->direccion_entrega;
				  	$orden_producto->ciudad = $model->ordenSolicitudDirecciones[0]->ciudad;
				  	$orden_producto->departamento = $model->ordenSolicitudDirecciones[0]->departamento;
				  	$orden_producto->telefono = $model->ordenSolicitudDirecciones[0]->telefono;
				  	$orden_producto->id_centro_costos = $model->ordenSolicitudCostoses[0]->id_centro_costos;
				  	$orden_producto->id_cuenta_contable = $model->ordenSolicitudCostoses[0]->id_cuenta_contable;
				  	$orden_producto->nombre_centro = $model->ordenSolicitudCostoses[0]->id_centro_costos;
				  	$orden_producto->nombre_cuenta = $model->ordenSolicitudCostoses[0]->id_cuenta_contable;
				  	$orden_producto->id_orden_solicitud = $model->id;
				  	if(!$orden_producto->save()) print_r($orden_producto->getErrors());
					echo CJSON::encode(array('status'=>'success', 'content'=> $this->renderPartial('_orden_solicitud_analista_view', array('model' => $model, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch, 'productos'=>$productos), true, true), 'modal'=>'modalNuevoProducto'));
					exit;
				}else{
					echo CJSON::encode(array('status'=>'error', 'content'=> $this->renderPartial('_orden_solicitud_analista_view', array('model' => $model, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch, 'productos'=>$productos), true, true)));
					exit;
				}
			}
			else if($orden_producto){
				$model->id_producto = $orden_producto->id_producto;
				$model->nombre_producto = Producto::model()->findByPk($orden_producto->id_producto)->nombre;
				
			}
			echo CJSON::encode(array('status'=>'error', 'content'=> $this->renderPartial('_orden_solicitud_analista_view', array('model' => $model, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch, 'productos'=>$productos), true, true)));
			exit;
		}
	}

	public function actionViewSolicitud(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id'])){
				$model = OrdenSolicitud::model()->findByPk($_GET['id']);
				$model_orden_solicitud_costos = OrdenSolicitudCostos::model()->findAllByAttributes(array('id_orden_solicitud' => $model->id));
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_view_orden_solicitud', array('model' => $model, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos), true)));
			}
			exit;               
		}
	}
	
	public function actionDeleteSolicitud(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id'])){
				$model = OrdenSolicitud::model()->findByPk($_GET['id']);
				if($model->delete()){
					//$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $_POST['OrdenSolicitud']['id']));
					//if($po->delete()){
						echo CJSON::encode(array('status'=>'success', 'id_solicitud' => $_POST['OrdenSolicitud']['id']));
						exit;
					//}
				}
				
				echo CJSON::encode(array('status'=>'error', 'id_solicitud' => $_POST['OrdenSolicitud']['id']));
			
			}
			exit;               
		}
	}
	
	public function actionCreateCostos(){
		if(Yii::app()->request->isAjaxRequest){
			$model = new OrdenSolicitudCostos;
			$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
			if(isset($_POST['OrdenSolicitudCostos']))
			        {
			            $model->attributes=$_POST['OrdenSolicitudCostos'];
			            if($model->save()){
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true), 'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
						}
						exit;
			        }
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
			exit;               
		}
	}
	
	public function actionUpdateCostos(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id'])){
				if($_GET['id'] == -1){
					$model = new OrdenSolicitudCostos;
					$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
				}else{
					$model = OrdenSolicitudCostos::model()->findByPk($_GET['id']);
				}
				if(isset($_POST['OrdenSolicitudCostos'])){
					$model->attributes=$_POST['OrdenSolicitudCostos'];
					if($model->save()){
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
				}
				exit;
			}              
		}
	}
	
	public function actionDeleteCostos($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = OrdenSolicitudCostos::model()->findByPk($_GET['id']);
			$id_osd = $model->id_orden_solicitud;
			if($model->delete())
				echo CJSON::encode(array('status'=>'success', 'id_orden_solicitud' => $id_osd));
			else
				echo CJSON::encode(array('status'=>'error', 'error'=>'No fue posible eliminar'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	public function actionCreateProveedor(){
		if(Yii::app()->request->isAjaxRequest){
			$model = new OrdenSolicitudProveedor;
			$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
			if(isset($_POST['OrdenSolicitudProveedor']))
	        {
	          	
				$orden = $this->loadModelByIdSolicitud($model->id_orden_solicitud);
				if($orden->negociacion_directa == 1 || $orden->negociacion_directa == 3){
						$model->setScenario("negociacion_directa_o_legalizacion");
			    }

	            $model->attributes=$_POST['OrdenSolicitudProveedor'];
	            if($model->save()){
	                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
				}
				exit;
	        }
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
			exit;               
		}
	}

	public function actionCrearReemplazo(){
		if(Yii::app()->request->isAjaxRequest){
			$model = new OrdenReemplazos;
			$model->setScenario("asignar");
			if(isset($_POST['OrdenReemplazos']))
			        {
			            $model->attributes=$_POST['OrdenReemplazos'];
			            $model->orden_nueva = $_GET['id_orden'];
			            if($model->save()){
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_reemplazos_form', array('model' => $model), true)));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_reemplazos_form', array('model' => $model), true)));
						}
						exit;
			        }
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_reemplazos_form', array('model' => $model), true)));
			exit;               
		}
	}

	public function actionDeleteReemplazo($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = OrdenReemplazos::model()->findByPk($id);
			if($model->delete())
				echo CJSON::encode(array('status'=>'success'));
			else
				echo CJSON::encode(array('status'=>'error', 'error'=>'No fue posible eliminar'));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionUpdateProveedor(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id'])){
				if($_GET['id'] == -1){
					$model = new OrdenSolicitudProveedor;
					$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
					$orden = $this->loadModelByIdSolicitud($_GET['id_orden_solicitud']);
			
				}else{
					$model = OrdenSolicitudProveedor::model()->findByPk($_GET['id']);
					$orden = $this->loadModelByIdSolicitud($model->id_orden_solicitud);
				}

				if($orden->negociacion_directa == 1 || $orden->negociacion_directa == 3){
						$model->setScenario("negociacion_directa_o_legalizacion");
			    }

				if(isset($_POST['OrdenSolicitudProveedor'])){
					$model->attributes=$_POST['OrdenSolicitudProveedor'];
					if($model->save()){
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
				}
				exit;
			}              
		}
	}
	
	public function actionDeleteProveedor($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = OrdenSolicitudProveedor::model()->findByPk($_GET['id']);
			$id_osd = $model->id_orden_solicitud;
			if($model->delete())
				echo CJSON::encode(array('status'=>'success', 'id_orden_solicitud' => $id_osd));
			else
				echo CJSON::encode(array('status'=>'error', 'error'=>'No fue posible eliminar'));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionCreateDireccion(){
		if(Yii::app()->request->isAjaxRequest){
			$model = new OrdenSolicitudDireccion;
			$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
			if(isset($_POST['OrdenSolicitudDireccion']))
			        {
			            $model->attributes=$_POST['OrdenSolicitudDireccion'];
			            if($model->save()){
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
						}
						exit;
			        }
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
			exit;               
		}
	}
	
	public function actionUpdateDireccion(){
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['id'])){
				if($_GET['id'] == -1){
					$model = new OrdenSolicitudDireccion;
					$model->id_orden_solicitud = $_GET['id_orden_solicitud'];
				}else{
					$model = OrdenSolicitudDireccion::model()->findByPk($_GET['id']);
				}
				if(isset($_POST['OrdenSolicitudDireccion'])){
					$model->attributes=$_POST['OrdenSolicitudDireccion'];
					if($model->save()){
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true),'id_orden_solicitud'=>$_GET['id_orden_solicitud']));
				}
				exit;
			}              
		}
	}
	
	public function actionDeleteDireccion($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = OrdenSolicitudDireccion::model()->findByPk($_GET['id']);
			$id_osd = $model->id_orden_solicitud;
			if($model->delete())
				echo CJSON::encode(array('status'=>'success', 'id_orden_solicitud' => $id_osd));
			else
				echo CJSON::encode(array('status'=>'error', 'error'=>'No fue posible eliminar'));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDelegar($id)
	{
		$model = Orden::model()->findByPk($id);
		
		if(($model->paso_wf == 'swOrden/analista_compras' or $model->paso_wf == 'swOrden/en_negociacion') and $model->usuario_actual == Yii::app()->user->id_empleado){
			
			$empleados = new Empleados('search');
			$empleados->unsetAttributes();  // clear any default values
			if(isset($_GET['Empleados'])){
				$empleados->attributes=$_GET['Empleados'];
			}
			if(isset($_GET['id_responsable'])){
				$model->usuario_actual = $_GET['id_responsable'];
				$model->scenario = 'delegar';
				$model->save();
				Yii::app()->user->setFlash('success', "La solicitud ha sido delegada exitosamente.");
				$this->redirect(array('admin'));
			}else{
				$this->render('delegar',array(
					'model'=>$model,
					'empleados' => $empleados
				));
			}
		}
	}

	public function actionSuspendida($orden){
		$model = $this->loadModel($orden);
		
		if($model->paso_wf != "swOrden/suspendida")
			throw new CHttpException(400, "La orden ".$orden." no se encuentra suspendida");

		list($ordenmodel, $productos_orden, $pagos, $elegida, $tabla, $tablaObs, $tablaOrdenes,$tablaReemp) = $this->comunPrintView($orden);
		$this->render('suspendida',array(
					      'orden' => $ordenmodel,
					      'productos_orden' => $productos_orden,
	                      'pagos' => $pagos,
	                      'elegida' => $elegida,
	                      'tabla'=>$tabla,
	                      'observaciones' => $tablaObs,
	                      'tablaordenes' => $tablaOrdenes,
	                      'tablaReemp' => $tablaReemp
				      ));
	}
	
	public function actionPrint($orden)
	{
		$this->layout = '//layouts/print';
		list($ordenmodel, $productos_orden, $pagos, $elegida, $tabla, $tablaObs, $tablaOrdenes, $tablaReemp) = $this->comunPrintView($_GET['orden']);

      	$this->render('print',array(
				      'orden' => $ordenmodel,
				      'productos_orden' => $productos_orden,
                      'pagos' => $pagos,
                      'elegida' => $elegida,
                      'tabla'=>$tabla,
                      'observaciones' => $tablaObs,
                      'tablaordenes' => $tablaOrdenes,
                      'tablaReemp' => $tablaReemp
				      ));
	}

	public function comunPrintView($orden){
			  
	 	 
	  $ordenmodel = Orden::model()->with('tipoCompra')->findByPk($orden);
	  
      $productos_orden = OrdenProducto::model()->with(
                                                      array(
                                                            'idProducto',
                                                            )
                                                      )->findAllByAttributes(array('id_orden' => $orden));

      $elegida = OrdenProducto::model()->with(
                                              array(
                                                    'CotizacionsOp' => array(
                                                                           "condition" => "elegido_comite = :ec",
                                                                           'params' => array(':ec' => 1)
                                                                           )
                                                    )
                                              )->findByAttributes(array('id_orden' => $orden));

      $pagos = CotizacionPagosOp::model()->findAllByAttributes(array("id_cotizacion_op" => $elegida->CotizacionsOp[0]->id));


      $dataProvider=new CActiveDataProvider('TrazabilidadWfs', array(
			'criteria' => array(
                'select' => array(
                                  '(select nombre_completo from empleados where id = t.usuario_anterior) as usuario_anterior',
                                  '(select nombre_completo from empleados where id = t.usuario_nuevo) as usuario_nuevo',
                                  'fecha',
                                  'estado_anterior',
                                  'estado_nuevo'
                 ),
				'condition' => 'model = :m and idmodel = :id',
				'params' => array(':m' => "Orden", ':id' => $orden)
			),
			'pagination'=>array('pageSize'=>500),
            'sort' => false
		));
		
		$tabla = $this->renderPartial('/trazabilidadWfs/index',array(
                                                    'dataProvider'=>$dataProvider,
                                                    ),true);

		$dataProviderObs=new CActiveDataProvider('ObservacionesWfs', array(
			'criteria' => array(
				'condition' => 'model = :m and idmodel = :id',
				'params' => array(':m' => "Orden", ':id' => $orden)
			),
			'pagination'=>array('pageSize'=>500),
			'sort' => false
		));

		$tablaObs = $this->renderPartial('/observacionesWfs/index',array(
                                                    'dataProvider'=>$dataProviderObs,
                                                    ),true);


		$dataProviderReemp=new CActiveDataProvider('OrdenReemplazos', array(
			'criteria' => array(
				'condition' => 'orden_nueva = :id',
				'params' => array(':id' => $orden)
			),
			'pagination'=>array('pageSize'=>500),
			'sort' => false
		));

		$tablaReemp = $this->renderPartial('/orden/index_reemplazos',array(
                                                    'dataProvider'=>$dataProviderReemp,
                                                    ),true);

		
		$dataProviderObs=new CActiveDataProvider('OrdenCompra', array(
			'criteria' => array(
				'condition' => 'id_orden = :id',
				'params' => array(':id' => $orden)
			),
			'pagination'=>array('pageSize'=>500),
			'sort' => false
		));

		$tablaOrdenes = $this->renderPartial('/ordenCompra/index',array(
                                                    'dataProvider'=>$dataProviderObs,
                                                    ),true);


		return array($ordenmodel,$productos_orden, $pagos, $elegida, $tabla, $tablaObs, $tablaOrdenes, $tablaReemp);

	}


	public function actionReadOnly(){
	  $this->layout = '//layouts/listar_sin_busqueda';
	  $orden = Orden::model()->with('tipoCompra')->findByPk($_GET['orden']);
	  $productos_orden = ProductoOrden::model()->with("producto0")->findAllByAttributes(array('orden' => $_GET['orden']));

      list($ordenmodel, $productos_orden, $pagos, $elegida, $tabla, $tablaObs, $tablaOrdenes,$tablaReemp) = $this->comunPrintView($_GET['orden']);
		$this->render('readonly',array(
					      'orden' => $ordenmodel,
					      'productos_orden' => $productos_orden,
	                      'pagos' => $pagos,
	                      'elegida' => $elegida,
	                      'tabla'=>$tabla,
	                      'observaciones' => $tablaObs,
	                      'tablaordenes' => $tablaOrdenes,
	                      'tablaReemp' => $tablaReemp
				      ));
	}
	
	public function actionCargarUltimosAsistentesComite($id, $comite){
		if(Yii::app()->request->isAjaxRequest){
			$model = Orden::model()->findByPk($id);
			if($model != null){
				$model->crearAsistentesUltimoComite($comite);
				echo CJSON::encode(array('status'=>'success'));  
				//echo CJSON::encode(array('status'=>'success'));  
			}else{
				echo CJSON::encode(array('status'=>'failure', 'id' => $id, 'comite' => $comite));
			}
		}
	}

    public function actionCargarAsistentesHabitualesComite($id, $comite){
		if(Yii::app()->request->isAjaxRequest){
			$model = Orden::model()->findByPk($id);
			if($model != null){
				$model->crearAsistentesHabitualesComite($comite);
				echo CJSON::encode(array('status'=>'success'));  
				//echo CJSON::encode(array('status'=>'success'));  
			}else{
				echo CJSON::encode(array('status'=>'failure', 'id' => $id, 'comite' => $comite));
			}
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

	public function actionSolicitarCancelacion($id){

		$model = $this->loadModel($id);

		if($model !== NULL && $model->paso_wf != "swOrden/usuario"){
			throw new CHttpException(400,'No puede solicitar la cancelación de una orden que no está aprobada');
		}

		$model->setScenario("solicitar_cancelacion");

		if(Yii::app()->request->isPostRequest){
			$model->observacion = $_POST['Orden']['observacion'];

			if($model->validate()){
				$log = new ObservacionesWfs;

		        $log->model = get_class($model->Owner);
		        $log->idmodel = $model->id;
		        $log->usuario = Yii::app()->user->id_empleado;
		        $log->estado_anterior = $model->paso_wf;
		        $log->estado_nuevo = 'swOrden/cancaler_post_aprobacion';
		        $log->observacion = $model->observacion;
		        $log->save();

		        $analista = $model->determinarAnalista();
		        Orden::model()->asignarOrdenParaCancelar($id, 'swOrden/cancaler_post_aprobacion', $analista);

		        $this->redirect("admin");


			}
		}

		$this->render("solicitar_cancelacion", array('model' => $model));

	}

	public function actionCancelar($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			
			if($_GET['ajax'] == 'orden-asignadas-grid'){
				$cuantas = Yii::app()->db->createCommand()->update('orden', array(
							    'paso_wf'=>'swOrden/cancelada',
							), 'id=:id', array(':id'=>$id));
				if($cuantas){
					$log = new TrazabilidadWfs;
				    $log->model = get_class($model);
				    $log->idmodel = $id;
			        $log->usuario_anterior = $model->usuario_actual;
			        $log->usuario_nuevo = $model->id_usuario;
			        $log->estado_anterior = $model->paso_wf;
			        $log->estado_nuevo = 'swOrden/cancelada'; 
				    $log->save();
					echo CJSON::encode(array('status'=>true));
				}
				else
					echo CJSON::encode(array('status'=>false));
				Yii::app()->end();
			}
			else {
				$model->paso_wf = "swOrden/cancelada";
				$model->observacion = CHtml::encode($_POST['observacion']);
				
				$this->redirect(array('admin'));
				
			}

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionSuspendidaACancelada($id)
	{
		$model = $this->loadModel($id);
		//$model->setScenario("observacion_req");

		if(isset($_POST['Orden']))
		{
			$model->paso_wf = "swOrden/cancelada";
			$model->observacion = CHtml::encode($_POST['Orden']['observacion']);
			if($model->save()){
				$this->redirect(array('admin'));
			}
			

		}
		$this->render('cancelar', array('model'=>$model));
	}

	public function actionSuspender($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			
			$model = $this->loadModel($id);
			$model->paso_wf = "swOrden/suspendida";
			$model->observacion = CHtml::encode($_POST['observacion']);
			$model->save();


			$this->redirect(array('admin'));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Orden');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar_sin_busqueda';
		
		$model_asignadas =new Orden('search');
		$model_asignadas->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model_asignadas->attributes=$_GET['Orden'];
		}


		$model_solicitadas =new Orden('search');
		$model_solicitadas->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden']))
			$model_solicitadas->attributes=$_GET['Orden'];
		
		$this->render('admin',array(
			'partial' => '_admin',
			'model_asignadas'=>$model_asignadas,
			'model_solicitadas'=>$model_solicitadas
		));
	}
	
	public function actionAnteriores()
	{
		$this->layout = '//layouts/listar_sin_busqueda';
		
		$model =new Orden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model->attributes=$_GET['Orden'];
		}

		$this->render('anteriores',array(
			'model'=>$model,
		));
	}

    public function actionAprobadas()
	{
		$this->layout = '//layouts/listar_sin_busqueda';
		
		$model =new Orden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model->attributes=$_GET['Orden'];
		}

		$this->render('aprobadas',array(
			'model'=>$model,
		));
	}


	public function actionComite()
	{
		$this->layout = '//layouts/listar_sin_busqueda';
		
		$model =new Orden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model->attributes=$_GET['Orden'];
		}

		$this->render('admin',array(
			'partial' => '_comite',
			'model_asignadas'=>$model,
			'model_solicitadas'=>null
		));
	}

	public function actionTodas()
	{
                
		if(!array_intersect( array('CYC992','CYC993','CYC994', 'CYC995','CYC996','CYC312'), Yii::app()->user->permisos )){ 
			throw new CHttpException(403,'No tiene permisos para ejecutar la acción deseada. Por favor contactar al administrador del sitio.');
		}
		$this->layout = '//layouts/listar';
		
		$model =new Orden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model->attributes=$_GET['Orden'];
		}

		$this->render('todas',array(
			'model'=>$model,
		));
	}

	public function actionTodasArea()
	{
                
		if(!array_intersect( array('CYC503'), Yii::app()->user->permisos )){ 
			throw new CHttpException(403,'No tiene permisos para ejecutar la acción deseada. Por favor contactar al administrador del sitio.');
		}
		$this->layout = '//layouts/listar';
		
		$model =new Orden('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orden'])){
			
			$model->attributes=$_GET['Orden'];
		}

		$this->render('todasArea',array(
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
		$model=Orden::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelByIdSolicitud($id)
	{
		$model=OrdenSolicitud::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model->idOrden;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orden-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSubir($ro=false){
		$this->layout = '//layouts/blank';
		$baseUrl = Yii::app()->request->baseUrl;
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerScriptFile($baseUrl . '/js/fileuploader.js');
		
		$arch=new AdjuntosProveedorRecomendado('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosProveedorRecomendado']))
			$arch->attributes=$_GET['AdjuntosProveedorRecomendado'];
		if($ro){
			$this->render("subir_ro", array('archivos' => $arch));
		}else{
			$this->render("subir", array('archivos' => $arch));
		}
	}
	
	public function actionSubir_o($ro=false){
		$this->layout = '//layouts/blank';
		$baseUrl = Yii::app()->request->baseUrl;
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerScriptFile($baseUrl . '/js/fileuploader.js');
		
		$arch=new AdjuntosOrden('search');
		$arch->unsetAttributes();  // clear any default values
		if(isset($_GET['AdjuntosOrden']))
			$arch->attributes=$_GET['AdjuntosOrden'];
		if($ro){
			$this->render("subir_orden_ro", array('archivos' => $arch));
		}else{
			$this->render("subir_orden", array('archivos' => $arch));
		}
	}

	public function actionSubirArch(){
		$cot = $_GET['orden_solicitud_proveedor'];

		$targetDir =   "/vol1" . 
	                   DIRECTORY_SEPARATOR . 
					   date('Y-m-d') .
			   		   DIRECTORY_SEPARATOR .
                       date('H-i-s') .
					   DIRECTORY_SEPARATOR . 
	                   $cot;


	    if (!file_exists($targetDir))
     	  @mkdir($targetDir,0775,true);   
	                   
		
		$upload = new qqFileUploader();
    	
    	$subio = $upload->handleUpload($targetDir, false, false);
    	if(isset($subio['success']) && $subio['success']){
    		$arch = new AdjuntosProveedorRecomendado;
    		$arch->proveedor_recomendado = $cot;
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
	
	public function actionSubirArch_o(){
		$cot = $_GET['orden'];
		$targetDir =   "/vol1" . 
	                   DIRECTORY_SEPARATOR . 
					   date('Y-m-d') .
			   		   DIRECTORY_SEPARATOR .
                       date('H-i-s') .
					   DIRECTORY_SEPARATOR . 
	                   $cot;

	    if (!file_exists($targetDir))
     	  @mkdir($targetDir,0775,true);   
	                   
		
		$upload = new qqFileUploader();
    	
    	$subio = $upload->handleUpload($targetDir, false, false);
    	if(isset($subio['success']) && $subio['success']){
    		$arch = new AdjuntosOrden;
    		$arch->orden = $cot;
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
	
	public function actionCrearOrdenPedido(){
		$model = new ProductosMarco();	
		$modelGrid = new OrdenProducto('search');
		if(isset($_GET['ProductosMarco'])){
			$model->attributes = $_GET['ProductosMarco'];
		}

		$this->render("orden_pedido", array('model' => $model, 'Mgrid'=>$modelGrid));
	}

	public function actionSolicitarProductoMarco(){
		$data = CJSON::decode($_POST['id_trazabilidad']);
		$model = new OrdenProducto;
		$model->id_producto = $_GET['id_producto'];
		$model->id_orden = $_GET['id_orden'];
		$model->id_marco_detalle = $_GET['id_detalle_marco'];

		$orden = Orden::model()->findByPk($_GET['id_orden']);
		if($orden->id_vicepresidencia != ''){
			$presupuesto = Presupuesto::model()->findAllByAttributes(array('id_producto'=>$_GET['id_producto'], 'id_vice'=>$orden->id_vicepresidencia, 'anio' => date('Y')),"id_direccion = $orden->id_gerencia or id_direccion is null");
		}
		else
			$presupuesto = Presupuesto::model()->findAllByAttributes(array('id_producto'=>$_GET['id_producto'], 'id_direccion'=>$orden->id_gerencia, 'anio' => date('Y')));

		if($presupuesto){
			$model->id_centro_costos = $presupuesto[0]->id_centro_costo;
			$model->id_cuenta_contable = $presupuesto[0]->id_cuenta;
		}
		
		//$header = '<a class="close" data-dismiss="modal">&times;</a><h4>Solicitar '.$data[producto].'</h4>';
		if(isset($_GET['OrdenProducto'])){
			$model->attributes = $_GET['OrdenProducto'];
		}
		if(isset($_POST['OrdenProducto'])){
			$model->attributes = $_POST['OrdenProducto'];
			//$model->usuario = Yii::app()->user->getState('id_empleado');
			//$model->estado = "Sin Enviar";
			if($model->validate()){
				if($model->id_marco_detalle){
					$disponible = DisponiblesMarcoCompras::model()->findByAttributes(array('id_detalle_om'=>$model->id_marco_detalle));
					if($disponible->forma_negociacion == "valor"){
						$cotizacion = OmCotizacion::model()->findByAttributes(array('producto_detalle_om'=>$disponible->id_detalle_om));
						$cantidad_disp = $disponible->cant_valor / $cotizacion->valor_unitario;
					}	
					else {
						$cantidad_disp = $disponible->cant_valor;
					}
					if($model->cantidad > $cantidad_disp){
						$model->faltante = $model->cantidad - $cantidad_disp;
						$model->cantidad = $cantidad_disp;
					}
				}
				if($model->save())
					echo CJSON::encode(array('status'=>'success'));
				else
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_orden_pedido_form', array('model' => $model, 'datos'=>$data), true, true)));
			}else
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_orden_pedido_form', array('model' => $model, 'datos'=>$data), true, true)));
			Yii::app()->end();
		}
		else {
			//La siguiente linea se debe modificar con una consulta q me perminta conocer las ordenes marco con productos disponibles para consumir
			/*$productosMarco = DisponiblesMarcoCompras::model()->findAllByAttributes(array('producto'=>$model->id_producto));

			if($productosMarco)
				$model->id_marco_detalle = $productosMarco[0]->id_detalle_om;
		    $model->id_producto = $data[id_producto];
		    $model->id_orden_solicitud = $data[id_orden_solicitud];
		    $model->id_orden = $data[id_orden];
		    $model->id_direccion = $data[id_direccion];
		    $model->id_cotizacion = $data[id_cotizacion];
		    $model->id_proveedor = $data[id_proveedor];*/
		}

		echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_orden_pedido_form', array('model' => $model, 'productosMarco'=>$productosMarco), true,true)));
		exit;
	}

	public function actionDeleteDetPed(){

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = OrdenProducto::model()->findByPk($_GET['id']);
			if($model->delete())
				echo CJSON::encode(array('status'=>'success'));
			else
				echo CJSON::encode(array('status'=>'error', 'error'=>'No fue posible eliminar'));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionTraerCotizaciones(){

		$cotizaciones = new CotizacionOp('search');
		$paso_actual = OrdenProducto::model()->findByPk(Yii::app()->getRequest()->getParam('id'))->idOrden->paso_wf;
		$op = OrdenProducto::model()->findByPk(Yii::app()->getRequest()->getParam('id'));
		$this->renderPartial('_cotizaciones', array(
	        'id' => Yii::app()->getRequest()->getParam('id'),
	        'paso_actual'=>$paso_actual,
	        'model' => $cotizaciones,
	        'op' => $op
	    ));
	}

	public function actionAdicionarCotizacion(){

		$model=new CotizacionOp;
		if(isset($_GET['cid'])){
			$cot = CotizacionOp::model()->findByPk($_GET['cid']);
			if($cot != null){
				$model->attributes = $cot->attributes;
			}
		}
		
		if(isset($_GET['orden_producto'])){
			$model->orden_producto = $_GET['orden_producto'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model=$_GET['Proveedor'];

		if(isset($_POST['CotizacionOp']))
		{
			$model->attributes=$_POST['CotizacionOp'];
			$model->orden_producto = $_GET['orden_producto'];
			if($model->save()){
			  	/*$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array(
			  							'elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));	*/		
				
				//echo CJSON::encode(array('status'=>'success','grid' => "cotizaciones-grid-" . $model->producto_detalle_om));
				echo CJSON::encode(array('status'=>'success','grid' => $model->orden_producto, 'modal'=>'modalCotizacion'));
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


	public function actionUpdateCotizacionOp($id)
	{
		$model=CotizacionOp::model()->findByPk($id);
		
		
		if(isset($_GET['orden_producto'])){
			$model->producto_detalle_om = $_GET['orden_producto'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$proveedor_model=new Proveedor('search');
		$proveedor_model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proveedor']))
			$proveedor_model=$_GET['Proveedor'];

		if(isset($_POST['CotizacionOp']))
		{
			$model->attributes=$_POST['CotizacionOp'];
			$model->producto_detalle_om = $_GET['orden_producto'];
			if($model->save()){
			  	/*$cot=new Cotizacion('search');
			  	Cotizacion::model()->updateAll(array(
			  							'elegido_compras'=>null), 
									  "producto_orden = :po",
									  array(':po' => $_POST['Cotizacion']['producto_orden']));	*/		
				
				//echo CJSON::encode(array('status'=>'success','grid' => "cotizaciones-grid-" . $model->producto_detalle_om));
				echo CJSON::encode(array('status'=>'success','grid' => $model->orden_producto));
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

	public function actionAgregarPagosACotizacionOp($id_cot){

		$model = new CotizacionPagosOp('search');
		$cotizacion = CotizacionOp::model()->findByPk($id_cot);

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CotizacionPagosOp']))
			$model=$_GET['CotizacionPagosOp'];

        echo CJSON::encode(array(
            'status'=>'success', 
            'content'=>$this->renderPartial('_pagos', array('model'=>$model, 'cotizacion'=>$cotizacion), true)));
        exit;   
	}

	public function traerUrlPaso($id){
		$orden = Orden::model()->findByPk($id);
		if($orden->paso_wf == "swOrden/en_negociacion" || $orden->paso_wf == "swOrden/validacion_cotizaciones" || $orden->paso_wf == "swOrden/gerente_compra" || $orden->paso_wf == "swOrden/vicepresidente_compra")
			return $this->createUrl("orden/updateProductoOrden", array("orden"=>$orden->id));
		else	
			return $this->createUrl("orden/update", array("id"=>$orden->id)) ;
	}

	public function actionAgregarPago($id_cot)
	{

		$model = new CotizacionPagosOp;
		$model->id_cotizacion_op = $id_cot;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['CotizacionPagosOp'])){
			$model->attributes=$_POST['CotizacionPagosOp'];
			$model->id_cotizacion_op = $id_cot;
			if($model->save()){
				echo CJSON::encode(array('status'=>'success', 'grid'=>$model->id_cotizacion_op));
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

	public function actionDeseleccionar($id){

		$cotizacion=CotizacionOp::model()->findByPk($id);
		$cotizacion->enviar_cotizacion_a_usuario = 0;
		$cotizacion->setScenario('seleccion_envio');
		if($cotizacion->save()){
			echo CJSON::encode(array(	
	            'status'=>'success', 'grid'=>$cotizacion->orden_producto, true));
	        exit;
		}else{
			echo CJSON::encode(array(
	            'status'=>'Ha ocurrido un error.', 'error'=>$cotizacion->getErrors(), true));
	        exit;
		}

	}

	public function actionSeleccionarParaEnvio($id){
		$cotizacion=CotizacionOp::model()->findByPk($id);
		$pagos = CotizacionPagosOp::model()->findAllByAttributes(array('id_cotizacion_op' => $id));
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
		            'status'=>'success', 'grid'=>$cotizacion->orden_producto, true));
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

	public function actionElegirCotCompras($prodord,$id)
	{
		
		$model=CotizacionOp::model()->findByPk($id);
		$model->setScenario("razon_eleccion_compras");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['CotizacionOp'])){
        		$model->razon_eleccion_compras = $_POST['CotizacionOp']['razon_eleccion_compras'];
        		$model->forma_negociacion = $_POST['CotizacionOp']['forma_negociacion'];
        		$model->cant_valor = $_POST['CotizacionOp']['cant_valor'];
        		if($model->save()){

        			CotizacionOp::model()->updateAll(array('elegido_compras'=>null, 'razon_eleccion_compras' => null), 
												  "orden_producto = :po",
												  array(':po' => $prodord));

        			$model->elegido_compras = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'success', 'grid' => $model->orden_producto));
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
		
		$model=CotizacionOp::model()->findByPk($id);
		$model->setScenario("razon_eleccion_comite");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['CotizacionOp'])){
        		$model->razon_eleccion_comite = $_POST['CotizacionOp']['razon_eleccion_comite'];
        		$model->forma_negociacion = $_POST['CotizacionOp']['forma_negociacion'];
        		$model->cant_valor = $_POST['CotizacionOp']['cant_valor'];
        		if($model->save()){

        			CotizacionOp::model()->updateAll(array('elegido_comite'=>null, 'razon_eleccion_comite' => null), 
												  "orden_producto = :po",
												  array(':po' => $prodord));

        			$model->elegido_comite = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'success', 'grid' => $model->orden_producto));
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

	public function actionElegir($prodord,$id)
	{
		
		$model=CotizacionOp::model()->findByPk($id);
		$model->setScenario("razon_eleccion_usuario");
		
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['CotizacionOp'])){
        		$model->razon_eleccion_usuario = $_POST['CotizacionOp']['razon_eleccion_usuario'];
        		if($model->save()){

        			CotizacionOp::model()->updateAll(array('elegido_usuario'=>null, 'razon_eleccion_usuario' => null), 
												  "orden_producto = :po",
												  array(':po' => $prodord));

        			$model->elegido_usuario = 1;
        			$model->save();
        			echo CJSON::encode(array('status'=>'success', 'grid' => $model->orden_producto));
        			exit;
        		}
        		else{
		            echo CJSON::encode(array(
		                'status'=>'failure', 
		                'content'=>$this->renderPartial('_elegirUsuario', array('model'=>$model), true)));
		            exit;
        		}
        	}

            echo CJSON::encode(array(
                'status'=>'success', 
                'content'=>$this->renderPartial('_elegirUsuario', array('model'=>$model), true)));
            exit;               
        }
		
	}

	public function actionRechazarProducto($id){

		$po = OrdenProducto::model()->findByPk($id);
		$po->setScenario("razon_rechazo");
		if (Yii::app()->request->isAjaxRequest)
        {
            
        	if(isset($_POST['OrdenProducto'])){
        		
        		$po->razon_rechazo = $_POST['OrdenProducto']['razon_rechazo'];
        		$po->rechazado = true;
                $po->usuario_rechazo = Yii::app()->user->getState("id_empleado");
                $po->fecha_rechazo = date('Y-m-d H:i:s');
        		if($po->save()){

        			Cotizacion::model()->updateAll(array('elegido_compras'=>null, 'enviar_cotizacion_a_usuario'=>null, 'razon_eleccion_compras' => null, 'elegido_usuario' => null, 'razon_eleccion_usuario' => null, 'elegido_comite' => null, 'razon_eleccion_comite' => null), 
												  "producto_orden = :po",
												  array(':po' => $po->id));
        			$marco = ConsumoMarco::model()->findByAttributes(array('id_orden_producto'=>$po->id));
        			if($marco){
        				$marco->estado = 'rechazado';
        				$marco->save();
        			}
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

	public function actionAprobarConsumo($orden_producto){
		if(Yii::app()->request->isAjaxRequest){
			$op = OrdenProducto::model()->findByPk($orden_producto);
			$op->aprobado_consumo = 1;
			$op->setScenario('aprobar_marco');
			$op->save();
			$marco = ConsumoMarco::model()->findByAttributes(array('id_orden_producto'=>$op->id));
			if($marco){
				$marco->estado = 'aprobado';
				$marco->save();
			}
			echo CJSON::encode(array('status'=>'success','grid' => $op->id));
			exit;
		}
		echo CJSON::encode(array('status'=>'error'));
		exit;
	}

}

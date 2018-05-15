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
			      	'steps',
		      		'crearOrdenPedido',
		      		'solicitarProductoMarco'),
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
		  $model->id_gerencia = $res[0]['id_gerencia'];
		  $model->id_gerente = $res[0]['id_gerente'];

		  //Caso en el que el jefe es igual al gerente. (Analistas sin jefe, solo con gerente)
          $jefe_gerente = Orden::model()->getJefeJefatura(Yii::app()->user->getState("id_empleado"));
		  if(count($jefe_gerente) > 0){
		      $model->id_jefatura = $jefe_gerente[0]['id_jefatura'];
		      $model->id_jefe = $jefe_gerente[0]['id_jefe_gerente'];
		  }else{
		  	  $model->id_jefatura = $res[0]['id_jefatura'];
		      $model->id_jefe = $res[0]['id_jefe'];
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
		print_r(SWHelper::nextStatuslistData($model));
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
			

		if(isset($_POST['Orden']))
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
			'reemplazos' => $reemplazos
		));

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
			if(isset($_POST['DetalleOrdenCompra'])){
				$is = $_POST['DetalleOrdenCompra'];

				$guardados = 0;
				foreach($is as $i){
					$js = $i;
					foreach($js as $j){
						if($j['cantidad'] != null and $j['cantidad'] != '' and $j['cantidad'] > 0){
                          $do = DetalleOrdenCompra::model()->findByAttributes(array('id_orden_solicitud' => $j['id_orden_solicitud'], 'id_orden' => $j['id_orden'], 'id_producto' => $j['id_producto'], 'id_proveedor' => $j['id_proveedor'], 'id_direccion' => $j['id_direccion'], 'id_orden_compra' => null));
							if($do == null){
								$do = new DetalleOrdenCompra;
								$do->id_orden_solicitud = $j['id_orden_solicitud'];
								$do->id_orden = $j['id_orden'];
								$do->id_producto = $j['id_producto'];
								$do->id_proveedor = $j['id_proveedor'];
								$do->id_cotizacion = $j['id_cotizacion'];
								$do->id_direccion = $j['id_direccion'];
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
				}
			}
			if($guardados > 0){
				Yii::app()->user->setFlash('success', "Se crearon ".$guardados." nuevas solicitudes.");
			}else{
				Yii::app()->user->setFlash('error', "No se creó ninguna solicitud nueva.");
			}
			$this->redirect(array('/DetalleOrdenCompra/admin', 'id_orden' => $id));
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}
	
	public function actionCrearOrdenCompra($id){
		$model = $this->loadModel($_GET['id']);
		if($model->paso_wf == "swOrden/usuario" and $model->usuario_actual == Yii::app()->user->id_empleado){
			$productos = DetalleOrdenCompra::model()->findAllByAttributes(array('id_orden' => $id, 'id_orden_compra' => null));
			if(count($productos) > 0){
				$proveedores = Proveedor::model()->findAllByPk($model->proveedores());
				foreach($proveedores as $p){
					$productos_p = DetalleOrdenCompra::model()->findAllByAttributes(array('id_orden' => $id, 'id_orden_compra' => null, 'id_proveedor' => $p->nit));
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
				$this->redirect(array('/DetalleOrdenCompra/admin', 'id_orden' => $id));
			}
			$this->redirect(array('/OrdenCompra/admin', 'id_orden' => $id));
		}else{
			throw new CHttpException(400,'Peticion inválida.');
		}
	}

	public function finalizarOrden($orden){
		$solicitudes = OrdenSolicitud::model()->findAll(
			array(
				'condition' => 'id_orden = :o',
				'params' => array(':o' => $orden)
			)
		);

		$suma = 0;
		foreach($solicitudes as $i => $s){
      $p = ProductoOrden::model()->findByAttributes(array("orden_solicitud" => $s->id));
      if($p->rechazado)
        continue;
			$direcciones = OrdenSolicitudDireccion::model()->findAllByAttributes(array('id_orden_solicitud' => $s->id));
			foreach($direcciones as $j =>$d){
				$suma += $d->cantidadDisponible();
			}
		
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
	  if(isset($_POST['OrdenSolicitud']))
	    {
	      if($model != null){
		$model->setScenario("autosave");
	  
		foreach ($_POST['OrdenSolicitud'] as $key => $value) {
		  if($value != "" && $key != "id" && $key != "id_orden"){
			if($key == "requiere_polizas"){
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
				$model->$key = $value;	
			}
		  }
		}
	      
		if($model->save())
		  echo "ok";

		exit;
	      }
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
				$a = explode('-',$_GET['ajax']);
				if(isset($a[4]))
				  $id = $a[4];
				else
				  $id = $a[3];
				$orden_solicitud_model = OrdenSolicitud::model()->findByPk($id);
			}else{
				$orden_solicitud_model = new OrdenSolicitud;
				$orden_solicitud_model->id_orden = $_GET['id_orden'];
				$orden_solicitud_model->save();
			}
				
			echo $this->render('_orden_solicitud_form', array('model' => $orden_solicitud_model, 'divid' => $orden_solicitud_model->id, 'model_orden_solicitud_costos' => $model_orden_solicitud_costos, 'model_orden_solicitud_proveedor' => $model_orden_solicitud_proveedor, 'model_orden_solicitud_direccion' => $model_orden_solicitud_direccion, 'archivos' => $arch), true);
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
			if(isset($_POST['OrdenSolicitud']['id'])){
				if($_POST['OrdenSolicitud']['id'] == -1){
					echo CJSON::encode(array('status'=>'success', 'id_solicitud' => $_POST['OrdenSolicitud']['id']));
					exit;
				}else{
					$model = OrdenSolicitud::model()->findByPk($_POST['OrdenSolicitud']['id']);
					if($model->delete()){
						$po = ProductoOrden::model()->findByAttributes(array('orden_solicitud' => $_POST['OrdenSolicitud']['id']));
						if($po->delete()){
							echo CJSON::encode(array('status'=>'success', 'id_solicitud' => $_POST['OrdenSolicitud']['id']));
							exit;
						}
					}
					
					echo CJSON::encode(array('status'=>'error', 'id_solicitud' => $_POST['OrdenSolicitud']['id']));
			
				}
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
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
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
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_costos_form', array('model' => $model), true)));
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
			$model = OrdenSolicitudCostos::model()->findByPk($id);
			$model->delete();

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
			          
			            $model->attributes=$_POST['OrdenSolicitudProveedor'];
			            if($model->save()){
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
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
			$model->delete();

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
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_proveedores_form', array('model' => $model), true)));
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
			$model = OrdenSolicitudProveedor::model()->findByPk($id);
			$model->delete();

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
			                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
						}else{
							echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
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
		                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
					}
				}else{
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_direccion_form', array('model' => $model), true)));
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
			$model = OrdenSolicitudDireccion::model()->findByPk($id);
			$model->delete();

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDelegar($id)
	{
		$model = Orden::model()->findByPk($id);
		
		if(($model->paso_wf == 'swOrden/analista_compras' or $model->paso_wf == 'swOrden/en_negociacion') and $model->usuario_actual == Yii::app()->user->id_empleado){
			
			$tipo_compra = new TipoCompra('search');
			$tipo_compra->unsetAttributes();  // clear any default values
			if(isset($_GET['TipoCompra'])){
				$tipo_compra->attributes=$_GET['TipoCompra'];
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
					'tipo_compra' => $tipo_compra
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
	  
      $productos_orden = ProductoOrden::model()->with(
                                                      array(
                                                            'producto0',
                                                            )
                                                      )->findAllByAttributes(array('orden' => $orden));

      $elegida = ProductoOrden::model()->with(
                                              array(
                                                    'cotizacions' => array(
                                                                           "condition" => "elegido_comite = :ec",
                                                                           'params' => array(':ec' => 1)
                                                                           )
                                                    )
                                              )->findByAttributes(array('orden' => $orden));

      $pagos = CotizacionPago::model()->findAllByAttributes(array("id_cotizacion" => $elegida->cotizacions[0]->id));


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
			$model->paso_wf = "swOrden/cancelada";
			$model->observacion = CHtml::encode($_POST['observacion']);
			$model->save();
			$this->redirect(array('admin'));

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
		$modelGrid = new DetalleOrdenPedido('search');
		if(isset($_GET['ProductosMarco'])){
			$model->attributes = $_GET['ProductosMarco'];
		}

		$this->render("orden_pedido", array('model' => $model, 'Mgrid'=>$modelGrid));
	}

	public function actionSolicitarProductoMarco(){
		$data = CJSON::decode($_POST[id_trazabilidad]);
		$model = new DetalleOrdenPedido;
		$header = '<a class="close" data-dismiss="modal">&times;</a><h4>Solicitar '.$data[producto].'</h4>';
		if(isset($_GET['DetalleOrdenPedido'])){
			$model->attributes = $_GET['DetalleOrdenPedido'];
		}
		if(isset($_POST['DetalleOrdenPedido'])){
			$model->attributes = $_POST['DetalleOrdenPedido'];
			$model->usuario = Yii::app()->user->getState('id_empleado');
			$model->estado = "Sin Enviar";
			if($model->save())
				echo CJSON::encode(array('status'=>'success'));
			else
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_orden_pedido_form', array('model' => $model, 'datos'=>$data), true, true), 'header'=>$header));
			Yii::app()->end();
		}
		else {
		    $model->id_producto = $data[id_producto];
		    $model->id_orden_solicitud = $data[id_orden_solicitud];
		    $model->id_orden = $data[id_orden];
		    $model->id_direccion = $data[id_direccion];
		    $model->id_cotizacion = $data[id_cotizacion];
		    $model->id_proveedor = $data[id_proveedor];
		}
		echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_orden_pedido_form', array('model' => $model, 'datos'=>$data), true, true), 'header'=>$header));
	}
}

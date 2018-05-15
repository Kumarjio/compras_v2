<?php

class PresupuestoController extends Controller
{

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
				'actions'=>array(),
				'users'=>array('*'),
			),	
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
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

	public function actionIndex()
	{
		$productos = new Producto('search');
		$centro_costos = new CentroCostos('search');
		$cuenta_contable = new CuentaContable('search');
		$presupuesto = new Presupuesto('search');
		if(isset($_GET['Producto'])){
			$productos->attributes = $_GET['Producto'];
		}
		if(isset($_GET['CentroCostos'])){
			$centro_costos->attributes = $_GET['CentroCostos'];
		}

		if(isset($_GET['CuentaContable'])){
			$cuenta_contable->attributes = $_GET['CuentaContable'];
		}

		if(isset($_GET['Presupuesto'])){
			$presupuesto->attributes = $_GET['Presupuesto'];
		}

		$this->render('index', array(
			'productos'=>$productos, 
			'centro_costos_model'=>$centro_costos, 
			'cuenta_contable'=>$cuenta_contable,
			'presupuesto'=>$presupuesto
		));
	}

	public function actionCrear(){
		$model = new Presupuesto;
		$data = CJSON::decode($_POST[producto]);
		$header = '<a class="close" data-dismiss="modal">&times;</a><h4>Presupuesto '.Producto::model()->findByPk($data[id])->nombre.'</h4>';
		if(isset($_POST['Presupuesto'])){
			$model->attributes = $_POST['Presupuesto'];
			if($model->save()){
				echo CJSON::encode(array('status'=>'success'));
				exit;
			}
			else {
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_form', array('model' => $model), true, true), 'header'=>$header));
				exit;
			}
		}
		else{
			$model->id_producto = $data['id'];
			$contrato = Contratos::model()->findByAttributes(array('id_empleado' => Yii::app()->user->getState('id_empleado')));
			$area = Cargos::model()->findByPk($contrato->id_cargo);
			if($area->es_vice == "Si"){
				$model->id_vice = $area->id_vice;
			}
			elseif ($area->es_gerente == "Si" && $area->id_vice == '') {
				$model->id_direccion = $area->id_gerencia;
			}
			else{
				echo CJSON::encode(array('status'=>'success', 'content' => "<h2>Usted no tiene permisos para ingresar Presupuesto</h2>", 'header'=>$header));
				exit;
			}
		}
		echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form', array('model' => $model), true, true), 'header'=>$header));
		exit;
	}


	// Uncomment the following methods and override them if needed
	/*
	
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
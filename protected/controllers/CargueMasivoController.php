<?php

class CargueMasivoController extends Controller
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
				'actions'=>array('index','view','admin'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','recepcion'),
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
		$model=new CargueMasivo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CargueMasivo']))
		{
			$model->attributes=$_POST['CargueMasivo'];
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

		if(isset($_POST['CargueMasivo']))
		{
			$model->attributes=$_POST['CargueMasivo'];
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
		$dataProvider=new CActiveDataProvider('CargueMasivo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CargueMasivo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['CargueMasivo']))
			$model->attributes=$_POST['CargueMasivo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CargueMasivo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CargueMasivo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CargueMasivo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cargue-masivo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionRecepcion($rcp)
	{
		if($_GET["rcp"]){
			$aux = true;
			$id = base64_decode($_GET["rcp"]);
			if(is_numeric($id)){
				$cargue = CargueMasivo::model()->findByPk($id);
				if(!$cargue){
					$aux = false;
				}
			}else{
				$aux = false;
			}
		}else{
			$aux = false;
		}
		if($aux){
			$model = new Recepcion;
			$polizaEmpresa = new PolizaEmpresa;
			$observacion = new ObservacionesTrazabilidad;
			$empresa = new EmpresaPersona;
			$guardo = true;
			$tipologias = array();
			$ciudades = array();
			if(isset($_POST['Recepcion'])){
				$model->attributes = $_POST['Recepcion'];
				$polizaEmpresa->attributes = $_POST['PolizaEmpresa'];
				$observacion->attributes = $_POST['ObservacionesTrazabilidad'];
				$empresa->attributes = $_POST['EmpresaPersona'];
				$model->user_recepcion = Yii::app()->user->usuario;
				$model->fecha_cliente = Recepcion::fechaCliente($model->tipologia);
				$model->fecha_interna = Recepcion::fechaInterna($model->tipologia);
				if(!empty($model->fecha_entrega)){
					$model->fecha_entrega = date('Ymd', strtotime($model->fecha_entrega));
				}
				if($model->validate() && $empresa->validate()){
					if ($model->save()) {
						$consulta_razon = EmpresaPersona::model()->findByAttributes(array("documento"=>$model->documento));
						if(!$consulta_razon){
							$empresa->documento = $model->documento;
							$empresa->documento_identificacion = "4";
							$empresa->save();
						}
						if(!empty($polizaEmpresa->poliza)){
							$consulta_poliza = PolizaEmpresa::model()->findByAttributes(array("poliza"=>$polizaEmpresa->poliza));
							if(!$consulta_poliza){
								$polizaEmpresa->nit = $model->documento;
								$polizaEmpresa->save();
							}
						}
						$inicia = Recepcion::iniciaRecepcion($model->na, $model->tipologia);
						if(!empty($observacion->observacion)){
							$observacion->na = $model->na;
							$observacion->id_trazabilidad = $inicia;
							$observacion->usuario = Yii::app()->user->usuario;
							$observacion->save();
						}
						if($inicia){
							AdjuntosTrazabilidad::guardaAdjuntosCargue($inicia,$model->na,$cargue->codigo_barras);						
							$actividad = Actividades::model()->cierraActividad($inicia);
							if($actividad){
								$abrir_actividad = Actividades::model()->abrirActividad($model->na,$actividad,$inicia);
								if($abrir_actividad){
									$cargue->recepcionado = true;
									$cargue->na = $model->na;
									$cargue->save();
									$nueva_recepcion = CargueMasivo::nuevoCargue();
									if($nueva_recepcion){
										$this->redirect(array('cargueMasivo/recepcion/','rcp' => base64_encode($nueva_recepcion)));
									}else{
										$this->redirect(array('cargueMasivo/admin/'));
									}
								}
							}
						}else{
							$guardo = false;
						}
					}else{
						$guardo = false;
					}
				}else{
					$guardo = false;
				}
			}
			if(!$guardo){
				if(!empty($model->area)){
					$tipologias = CHtml::listData(Tipologias::model()->findAll('area = :area', array(':area'=>$model->area)),'id','tipologia');
				}
				if(!empty($model->departamento)){
					$ciudades = CHtml::listData(Ciudad::model()->findAll('id_departamento = :departamento', array(':departamento'=>$model->departamento)),'id_ciudad','nombre_ciudad');
				}
			}
			$this->render('recepcion',array(
				'model'=>$model,
				'tipologias'=>$tipologias,
				'poliza'=>$polizaEmpresa,
				'observacion'=>$observacion,
				'empresa'=>$empresa,
				'cargue'=>$cargue,
				'ciudades'=>$ciudades,
			));
		}else{
			$this->redirect($this->createUrl('error/index'));
		}
	}
}

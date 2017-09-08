<?php

class RecepcionController extends Controller
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
				'actions'=>array('create','update','admin','delete','form','tipologia','razon','punteo','casos','prueba','valida'),
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
	 * @param integer $na the Na of the model to be displayed
	 */
	public function actionView($na)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($na),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Recepcion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Recepcion']))
		{
			$model->attributes=$_POST['Recepcion'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $na the Na of the model to be updated
	 */
	public function actionUpdate($na)
	{
		$model=$this->loadModel($na);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Recepcion']))
		{
			$model->attributes=$_POST['Recepcion'];
			if($model->save())
				$this->redirect(array('view','na'=>$model->na));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $na the NA of the model to be deleted
	 */
	public function actionDelete($na)
	{
		$this->loadModel($na)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Recepcion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Recepcion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Recepcion']))
			$model->attributes=$_GET['Recepcion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $na the NA of the model to be loaded
	 * @return Recepcion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($na)
	{
		$model=Recepcion::model()->findByPk($na);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Recepcion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recepcion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionForm(){
		$model = new Recepcion;
		$model->unsetAttributes();
		$sucursal = new SucursalRecepcion;
		$polizaEmpresa = new PolizaEmpresa;
		$observacion = new ObservacionRecepcion;
		$empresa = new EmpresaPersona;
		$adjuntos = new AdjuntosRecepcion;
		$guardo = true;
		$tipologias = array();
		if(isset($_POST['Recepcion'])){
			$model->attributes = $_POST['Recepcion'];
			$sucursal->attributes = $_POST['SucursalRecepcion'];
			$polizaEmpresa->attributes = $_POST['PolizaEmpresa'];
			$observacion->attributes = $_POST['ObservacionRecepcion'];
			$empresa->attributes = $_POST['EmpresaPersona'];
			$adjuntos->attributes = $_POST['AdjuntosRecepcion'];
			$adjuntos->archivo = CUploadedFile::getInstance($adjuntos,'archivo');
			print_r($adjuntos->archivo);
			die;
			$model->user_recepcion = Yii::app()->user->usuario;
			if($model->validate()){
				if($model->tipo_documento == "1"){
					if(empty($model->na)){
						$model->na = Yii::app()->db->createCommand("SELECT nextval('recepcion_na_seq')")->queryScalar();
						$sucursal->na= $model->na;
					}
					if($sucursal->validate() && $empresa->validate()){
						if ($model->save() && $sucursal->save()) {
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
							if(!empty($observacion->observacion)){
								$observacion->na = $model->na;
								$observacion->save();
							}
							if(!empty($adjuntos->archivo)){
								$na = $model->na;
								$path = "http://".$_SERVER['HTTP_HOST']."/img04/arp/".date("Ymd")."/".$na;
								$adjuntos->na = $na;
								$extension = strtolower(".".$adjuntos->archivo->extensionName);
								$nombre = "ADJ".Yii::app()->db->createCommand("SELECT nextval('concecutivos_adjuntos_seq')")->queryScalar();
								$adjuntos->path = $path."/".$nombre.$extension;
								if($adjuntos->save()){
									$path = str_replace("http://".$_SERVER['HTTP_HOST'],"/vol2",$path);
									if(!is_dir($path)){
										exec("mkdir -p $path; sudo chmod 775 -R $path", $output, $return_var);
									}
									$adjuntos->archivo->saveAs($path."/".$nombre.$extension);
								}
							}
							$flujo = Flujo::model()->iniciaFlujo($model->na);
							$actividad = Actividades::model()->cierraActividad($model->na,$flujo);
							$abrir_actividad = Actividades::model()->abrirActividad($model->na,$flujo);
							$this->redirect(array('trazabilidad/index/','na' => base64_encode($model->na)));
						}else{
							$guardo = false;
						}
					}else{
						$guardo = false;
					}
				}else{
					if($empresa->validate()){
						if ($model->save()) {
							$consulta_razon = EmpresaPersona::model()->findByAttributes(array("documento"=>$model->documento));
							if(!$consulta_razon){
								$empresa->documento = $model->documento;
								$empresa->documento_identificacion = "4";
								$empresa->save();
							}
							if(!empty($polizaEmpresa->poliza)){
								$consulta_poliza = PolizaEmpresa::model()->findByAttributes(array("nit"=>$model->documento,"poliza"=>$polizaEmpresa->poliza));
								if(!$consulta_poliza){
									$polizaEmpresa->nit = $model->documento;
									$polizaEmpresa->save();
								}
							}
							if(!empty($observacion->observacion)){
								$observacion->na = $model->na;
								$observacion->save();
							}
							if(!empty($adjuntos->archivo)){
								$na = $model->na;
								$path = "http://".$_SERVER['HTTP_HOST']."/img04/arp/".date("Ymd")."/".$na;
								$adjuntos->na = $na;
								$extension = strtolower(".".$adjuntos->archivo->extensionName);
								$nombre = "ADJ".Yii::app()->db->createCommand("SELECT nextval('concecutivos_adjuntos_seq')")->queryScalar();
								$adjuntos->path = $path."/".$nombre.$extension;
								if($adjuntos->save()){
									$path = str_replace("http://".$_SERVER['HTTP_HOST'],"/vol2",$path);
									if(!is_dir($path)){
										exec("mkdir -p $path; sudo chmod 775 -R $path", $output, $return_var);
									}
									$adjuntos->archivo->saveAs($path."/".$nombre.$extension);
								}
							}
							$flujo = Flujo::model()->iniciaFlujo($model->na);
							$actividad = Actividades::model()->cierraActividad($model->na,$flujo);
							$abrir_actividad = Actividades::model()->abrirActividad($model->na,$flujo);
							$this->redirect(array('trazabilidad/index/','na' => base64_encode($model->na)));
						}else{
							$guardo = false;
						}
					}else{
						$guardo = false;
					}
				}
			}else{
				$guardo = false;
			}
		}
		if(!$guardo){
			if(!empty($model->area)){
				$tipologias = CHtml::listData(Tipologias::model()->findAll('area = :area', array(':area'=>$model->area)),'id','tipologia');
			}
		}
		$this->render('_form',array(
			'model'=>$model,
			'sucursal'=>$sucursal,
			'tipologias'=>$tipologias,
			'poliza'=>$polizaEmpresa,
			'observacion'=>$observacion,
			'empresa'=>$empresa,
			'adjuntos'=>$adjuntos
		));
	}
	public function actionTipologia(){
		$area = $_POST['Recepcion']['area'];
		if(!empty($area)){
			$tipologias = CHtml::listData(Tipologias::model()->findAll('area = :area', array(':area'=>$area)),'id','tipologia');
		 	echo CHtml::tag('option',array('value'=>''),'...',true);
			if($tipologias){
				foreach ($tipologias as $valor => $tipologia) {
		 			echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($tipologia),true);
				}
			}	
		}else{
			echo CHtml::tag('option',array('value'=>''),'Seleccione Area...',true);
		}
	}
	public function actionRazon(){
		$nit = $_POST['nit'];
	 	$empresa = EmpresaPersona::model()->findByAttributes(array("documento"=>$nit));
	 	$poliza = PolizaEmpresa::model()->findByAttributes(array("nit"=>$nit),array('order'=>'id DESC'));
		$data = array();
		if($empresa){
			$data["razon"] = $empresa->razon;
		}
		if($poliza){
			$data["poliza"] = $poliza->poliza;
		}
		if(!empty($data)){
			echo CJSON::encode($data);
		}
	}
	public function actionCasos(){
		//$consulta = Recepcion::model()->findAll();
		$consulta = CHtml::listData(Recepcion::model()->findAll(),'na','na');
		foreach ($consulta as $na) {
			$results[] =  $na;
		}
		return $results;
	}
	public function actionPrueba(){
		$this->render('prueba');
	}
	public function actionValida(){
		$data = $_POST["data"];
		$consulta = Recepcion::model()->findByAttributes(array("na"=>$data));
		if($consulta){
			$consulta->na = base64_encode($consulta->na);
			die($consulta->na);
		}else{
			die;
		}
	}
}

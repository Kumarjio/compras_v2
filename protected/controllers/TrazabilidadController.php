<?php

class TrazabilidadController extends Controller
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
				'actions'=>array('create','update', 'retomarCaso','pendientes','reasignar','adjuntar','upload'),
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
		$model=new Trazabilidad;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Trazabilidad']))
		{
			$model->attributes=$_POST['Trazabilidad'];
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

		if(isset($_POST['Trazabilidad']))
		{
			$model->attributes=$_POST['Trazabilidad'];
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
		if($_GET["na"]){
			$model = new Trazabilidad;
			$na = base64_decode($_GET["na"]);
			$recepcion = Recepcion::model()->informacionRecepcion($na);
			$trazabilidad = Trazabilidad::model()->informacionTrazabilidad($na);
			$tipologia = Tipologias::model()->informacionTipologia($recepcion->tipologia);
			$empresa = EmpresaPersona::model()->informacionEmpresa($recepcion->documento);
			$poliza = PolizaEmpresa::model()->informacionPoliza($recepcion->documento);
			$sucursal = SucursalRecepcion::model()->informacionSucursal($na);
			$observacion = ObservacionRecepcion::model()->informacionObservacion($na);
			$this->render('index',array(
				'model'=>$model,
				'recepcion'=>$recepcion,
				'trazabilidad'=>$trazabilidad,
				'tipologia'=>$tipologia,
				'empresa'=>$empresa,
				'poliza'=>$poliza,
				'sucursal'=>$sucursal,
				'observacion'=>$observacion,
			));
		}else{
			$this->render('index');
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Trazabilidad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Trazabilidad']))
			$model->attributes=$_GET['Trazabilidad'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Trazabilidad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Trazabilidad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Trazabilidad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='trazabilidad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionRetomarCaso(){
		$na = $_POST["na"];
		$model = Trazabilidad::model()->findByAttributes(array("na"=>$na),array('order'=>'id DESC'));
		if($model){
			if($model->user_asign != "1"){
				$model->user_asign = Yii::app()->user->usuario;
				$model->save();
				echo CJSON::encode(array('status'=>'success'));
			}else{
				echo CJSON::encode(array('status'=>'error'));
			}
		}else{
			echo CJSON::encode(array('status'=>'error'));
		}
		exit;
	}
	public function actionObservacionesTrazabilidad(){
		if(Yii::App()->request->isAjaxRequest){
			if(isset($_POST['ObservacionesTrazabilidad'])){
				$model->attributes = $_POST['Flujo'];
	            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_observaciones', array('model' => $model), true, true)));
				exit;
			}else{
				$id = $_POST["id"];
				$model = ObservacionesTrazabilidad::model()->findByAttributes(array("id"=>$id));
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_observaciones', array('model' => $model), true, true)));
				exit;
			}
		}
	}
	public function actionPendientes(){
		$model=new Trazabilidad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Trazabilidad']))
			$model->attributes=$_GET['Trazabilidad'];

		$this->render('_pendientes',array(
			'model'=>$model,
		));
	}
	public function actionReasignar(){
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if($_POST['id']){			
				$id = $_POST['id'];
				$model=$this->loadModel($id);
			}else{
				if(isset($_POST['Trazabilidad'])){
					$model=Trazabilidad::model()->findByPk($_POST['Trazabilidad']['id']);
					$model->attributes=$_POST['Trazabilidad'];
					if(!$model->save()){
						$aux = false;
					}
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_reasignar', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_reasignar', array('model' => $model), true, true)));
			}

		}
	}
	public function actionAdjuntar(){
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			$model = new AdjuntosTrazabilidad;
			if($_POST['id']){
				$trazabilidad = Trazabilidad::model()->findByPk($_POST['id']);
				$model->id_trazabilidad = $trazabilidad->id;
				$model->na = $trazabilidad->na;
			}
			if(isset($_POST['AdjuntosTrazabilidad'])){
				$model->attributes=$_POST['AdjuntosTrazabilidad'];
				$model->archivo = $_POST['AdjuntosTrazabilidad']['archivo'];
				if($model->validate()){
					$ruta = $model->archivo;
					$directorio = dirname($ruta);
					$separador = explode(".", $ruta);
					$extension = $separador["1"];
					$nombre = "ADJ".Yii::app()->db->createCommand("SELECT nextval('concecutivos_adjuntos_seq')")->queryScalar();
					$path = "/vol2/img04/arp/".date("Ymd")."/".$model->na."/";
					$ruta_nueva = $path.$nombre;
					if(!file_exists($path)){
						exec("mkdir -p $path; sudo chmod 775 -R $path", $output, $return_var);
					}
					if($extension == "png" || $extension == "tif" || $extension == "tiff"){
						exec("convert $ruta $ruta_nueva.'jpg'", $output, $return_var);
						$extension = "jpg";
					}else{
						exec("mv $ruta $ruta_nueva".".".$extension);
					}
					if(file_exists($ruta)){
						exec("rm $ruta", $output, $return_var);
						if(file_exists($directorio)){
							exec("rmdir $directorio", $output, $return_var);
						}
					}
					$model->path = $ruta_nueva.".".$extension;
					$model->path = str_replace("/vol2","http://".$_SERVER['HTTP_HOST'],$model->path);
					$model->usuario = Yii::app()->user->usuario;
					$model->save();
				}else{
					$aux = false;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('adjuntos', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('adjuntos', array('model' => $model), true, true)));
			}	
		}
	}
    public function actionUpload()
    {
            $tempFolder = DIRECTORY_SEPARATOR."vol2".
            			  DIRECTORY_SEPARATOR."img04".
            			  DIRECTORY_SEPARATOR."archivos_tmp".
            			  DIRECTORY_SEPARATOR.Yii::app()->user->name.
            			  DIRECTORY_SEPARATOR.date('Y-m-d').
            			  DIRECTORY_SEPARATOR.date('H-i-s');
            @mkdir($tempFolder, 0777, TRUE);
            //@mkdir($tempFolder.'chunks', 0777, TRUE);
            Yii::import("ext.EFineUploader.qqFileUploader");
            $uploader = new qqFileUploader();
            $uploader->allowedExtensions = array('jpg','jpeg','png','pdf','xls','csv','msg','tif');
            $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
            $uploader->chunksFolder = $tempFolder.'chunks';

            $result = $uploader->handleUpload($tempFolder);
            $result['archivo'] = $uploader->getUploadName();
            $result['ruta'] = $tempFolder."/".$result['archivo'];

            $uploadedFile=$tempFolder.$result['archivo'];

            header("Content-Type: text/plain");
            $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $result;
            Yii::app()->end();
    }
}

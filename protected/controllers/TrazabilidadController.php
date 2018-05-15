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
				'actions'=>array('create','update', 'retomarCaso','pendientes','reasignar','adjuntar','upload','download','visorImagenesTif','retomar','cambiarTipologia'),
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
	public function actionIndex(){
		$obserTrazabilidad=new ObservacionesTrazabilidad('search');
		if(isset($_GET['ObservacionesTrazabilidad'])){
			$obserTrazabilidad->attributes = $_GET['ObservacionesTrazabilidad'];
		}
		if($_GET["na"]){
			$aux = true;
			$na = base64_decode($_GET["na"]);
			if(is_numeric($na)){
				$recepcion = Recepcion::model()->findByPk($na);
				if(!$recepcion){
					$aux = false;
				}
			}else{
				$aux = false;
			}
		}else{
			$aux = false;
		}
		if($aux){
			$model = new Trazabilidad('search_detalle');
			$recepcion=Recepcion::model()->findByPk($na);
			//$trazabilidad = Trazabilidad::model()->informacionTrazabilidad($na);
			$tipologia = Tipologias::model()->informacionTipologia($recepcion->tipologia);
			$empresa = EmpresaPersona::model()->informacionEmpresa($recepcion->documento);
			$poliza = PolizaEmpresa::model()->informacionPoliza($recepcion->documento);
			$sucursal=SucursalRecepcion::model()->findByPk($na);
			//$observacion = ObservacionesTrazabilidad::informacionObservacion($na);
			//$adjuntos = AdjuntosTrazabilidad::adjuntosConsulta($na);
			$mail = MailRecepcion::getMail($na);
			$this->render('index',array(
				'model'=>$model,
				'recepcion'=>$recepcion,
				'trazabilidad'=>$trazabilidad,
				'tipologia'=>$tipologia,
				'empresa'=>$empresa,
				'poliza'=>$poliza,
				'sucursal'=>$sucursal,
				//'observacion'=>$observacion,
				//'adjuntos'=>$adjuntos,
				'mail'=>$mail,
				'obserTrazabilidad'=>$obserTrazabilidad
			));
		}else{
			$this->redirect($this->createUrl('error/index'));
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
		$model=new Trazabilidad('search_pendientes');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Trazabilidad'])){
			$model->attributes=$_POST['Trazabilidad'];
		}

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
					//$observacion = new ObservacionesTrazabilidad;
					//$observacion->observacion = "Se ha reasignado la actividad del usuario ".Usuario::model()->nombres($model->user_asign)." para el usuario ".Usuario::model()->nombres($_POST['Trazabilidad']['user_asign']).".";
					$model->attributes=$_POST['Trazabilidad'];
					if($model->save()){
						$observacion = new ObservacionesTrazabilidad;
						$observacion->observacion = "Se ha reasignado la actividad a el usuario ".Usuario::model()->nombres($model->user_asign).".";
						$observacion->id_trazabilidad = $model->id;
						$observacion->usuario = Yii::app()->user->usuario;
						$observacion->na = $model->na;
						$observacion->save();
						Actividades::notificacion($model->id, $model->user_asign);
					}else{
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
					$ruta_nueva = $path;
					if(!file_exists($path)){
						exec("mkdir -p $path; sudo chmod 777 -R $path", $output, $return_var);
					}
					/*if($extension == "png" || $extension == "tif" || $extension == "tiff"){
						$ruta_jpg = $path;
						print_r($ruta_jpg);
						die;
						exec("convert $ruta $ruta_nueva.'jpg'", $output, $return_var);
						$extension = "jpg";
					}else{*/
					$nombre_tmp = dirname($ruta)."/";
					if(file_exists($nombre_tmp)){
						//exec("mv $ruta $nombre_tmp".$nombre.".".$extension);
						rename($ruta, $nombre_tmp.$nombre.".".$extension);
					}
					$ruta = $nombre_tmp.$nombre.".".$extension;
					if(file_exists($ruta_nueva)){
						exec("mv $ruta $ruta_nueva".$nombre.".".$extension);
					}
					//}
					if(file_exists($ruta)){
						exec("rm $ruta", $output, $return_var);
						if(file_exists($directorio)){
							exec("rmdir $directorio", $output, $return_var);
						}
					}
					$model->path = $ruta_nueva.$nombre.".".$extension;
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
            $uploader->allowedExtensions = array('jpg','jpeg','png','pdf','xls','csv','msg','tif','xlsx','msg');
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
    public function actionDownload()
    {
		if($_REQUEST['path']){
			$path = $_REQUEST['path'];
			$nombre = basename($path);
			$path = str_replace("http://correspondencia.imaginex/", "/vol2/", $path); 
			header ("Content-type: octet/stream");
			header ("Content-disposition: attachment; filename=".$nombre.";");
			header("Content-Legth: ".filesize($path));
			readfile($path);
			exit;	
		}
    }
    public function actionVisorImagenesTif()
    {
		//$this->render('visor');
		if(Yii::App()->request->isAjaxRequest){
			if($_REQUEST['path']){
				$path = $_REQUEST['path'];
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('visor', array('path' => $path), true, true)));	
			}
		}
    }
    public function actionRetomar()
    {
		if(Yii::App()->request->isAjaxRequest){
			if($_POST['id']){
				$model = Trazabilidad::model()->findByPk($_POST['id']);
				$observacion = new ObservacionesTrazabilidad;
				$observacion->observacion = "Se ha retomado la actividad del usuario ".Usuario::model()->nombres($model->user_asign).".";
				$model->user_asign = Yii::app()->user->usuario;
				if($model->save()){
					$observacion->id_trazabilidad = $model->id;
					$observacion->usuario = Yii::app()->user->usuario;
					$observacion->na = $model->na;
					$observacion->save();
					echo CJSON::encode(array('status'=>'success', 'content' => "<h5>Actividad Retomada.</h5>"));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => "<h5 align='center' class='red'>Error al retomar el caso.</h5>" ));
				}
			}
		}
    }
    public function actionCambiarTipologia()
    {
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['Recepcion'])){
				$model=Recepcion::model()->findByPk($_POST['Recepcion']['na']);
				$observacion = new ObservacionesTrazabilidad;
				$observacion->observacion = "Se ha cambiado la tipologia ".ucwords(strtolower($model->tipologia0->tipologia)).".";
				$trazabilidad = Trazabilidad::model()->findByPk($_POST['Trazabilidad']['id']);
				$model->attributes=$_POST['Recepcion'];
				if($_POST['Recepcion']['tipologia']){
					$area =	Tipologias::model()->findByAttributes(array("id"=>$_POST['Recepcion']['tipologia']));
					$model->area = $area->area;
				}
				if($model->save()){
					$observacion->id_trazabilidad = $trazabilidad->id;
					$observacion->usuario = Yii::app()->user->usuario;
					$observacion->na = $model->na;
					$observacion->save();
					trazabilidad::model()->updateAll(array('estado'=>'2','user_cierre'=>Yii::app()->user->usuario,'fecha_cierre'=>"'now()'"),'na ='.$model->na.'AND user_cierre IS NULL');
					$getActividad = trazabilidad::model()->with( array('actividad0'=>array("alias"=>"a",'condition'=>'a.id_actividad = 1')))->findByAttributes(array("na"=>$model->na));
					$nuevaActividad = ActividadTipologia::model()->findByAttributes(array("id_tipologia"=>$model->tipologia, "id_actividad"=>"1"));
					trazabilidad::model()->updateAll(array('actividad'=>$nuevaActividad->id),'id ='.$getActividad->id);
					Actividades::model()->abrirActividad($model->na,$nuevaActividad->id,$getActividad->id);
				}else{
					$aux = false;
				}
			}else{
				$id = $_POST['id'];
				$trazabilidad = Trazabilidad::model()->findByPk($id);
				$model = Recepcion::model()->findByPk($trazabilidad->na);
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_cambioTipologia', array('model' => $model,'trazabilidad'=>$trazabilidad), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_cambioTipologia', array('model' => $model,'trazabilidad'=>$trazabilidad), true, true)));
			}
		}
    }

}

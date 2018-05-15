<?php

class ActividadesController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','prueba2','index','carta','cargarArchivo','copias','admin','editar','consultaEmail','cartasRespuesta','eliminarCarta','consultarCarta','cargarDocumento','upload','adjuntosRespuesta','eliminarAdjunto'),
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
	public function actionCreate(){

		if(Yii::App()->request->isAjaxRequest){
			$model=new Actividades;

			if(isset($_POST['Actividades'])){
				$model->attributes = $_POST['Actividades'];
				
	            if($model->validate()){
	            	$model->save();
	                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('create', array('model' => $model), true, true)));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('create', array('model' => $model), true, true)));
				}
				exit;
			}else{
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('create', array('model' => $model), true, true)));
			}
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

		if(isset($_POST['Actividades']))
		{
			$model->attributes=$_POST['Actividades'];
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

	public function actionPrueba(){
		$model = new Actividades;
		if(isset($_POST['Actividades']))
        {
            
            $model->attributes=$_POST['Actividades'];
            if($model->save()){
                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
            }else{
                echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
            }
        }else{
            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
        }
	}
	public function actionPrueba2(){
		$model = new AdjuntosRecepcion;
		if(isset($_POST['AdjuntosRecepcion'])){
			$model->attributes = $_POST['AdjuntosRecepcion'];
			//$model->archivo = CUploadedFile::getInstance($model,'archivo');
			print_r($model->archivo);
			die;

		}
		$this->render('prueba2', array('model'=>$model));
	}
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionIndex()
	{
		$aux = "";
		if($_POST["id_trazabilidad"]){
			$id_trazabilidad = $_POST["id_trazabilidad"];
			$traza = Trazabilidad::model()->findByPk($id_trazabilidad);
		}
		if($traza){
			$actividad = ActividadTipologia::model()->findByAttributes(array("id"=>$traza->actividad));
			switch($actividad->id_actividad){
				case "3":
					$model = new CartaPlantilla;
					$model->id_traza = $traza->id;
					$recepcion = Recepcion::model()->findByPk($traza->na);
					$modelPrincipal = Cartas::model()->findByAttributes(array("na"=>$recepcion->na, "id_trazabilidad"=>$traza->id, "principal"=>"Si"));
					if ($modelPrincipal){
						$model->texto = $modelPrincipal->carta;
						$model->carta = $modelPrincipal->carta;
						$model->plantilla = $modelPrincipal->id_plantilla;
					}

					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_generaRespuesta', array('model'=>$model, 'recepcion'=>$recepcion, 'id_traza'=>$traza->id), true, true)));
				break;
				default:
					$model = new ObservacionesTrazabilidad;
					$model->id_trazabilidad = $id_trazabilidad;
					$na = Trazabilidad::model()->findByAttributes(array("id"=>$id_trazabilidad));
					$model->na = $na->na;
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('index', array('model' => $model), true, true)));
				break;
			}
		}
		if(isset($_POST['ObservacionesTrazabilidad'])){
			$model = new ObservacionesTrazabilidad;
			$model->attributes = $_POST['ObservacionesTrazabilidad'];
			$model->usuario = Yii::app()->user->usuario;
			if($model->save()){
				$trazabilidad = Trazabilidad::model()->findByPk($model->id_trazabilidad);
				if($trazabilidad){
					$actividad = Actividades::model()->cierraActividad($trazabilidad->id);
					if($actividad){
						$abrir_actividad = Actividades::model()->abrirActividad($trazabilidad->na,$actividad,$trazabilidad->id);
						if($abrir_actividad){
							$aux = true;
						}else{
							$aux = false;
						}
					}else{
						$aux = false;	
					}
				}else{
					$aux = false;
				}				
			}else{
				$aux = false;
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('index', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('index', array('model' => $model), true, true)));
			}
		}
		if(isset($_POST['CartaPlantilla'])){
			$model = new CartaPlantilla;
			$model->attributes = $_POST['CartaPlantilla'];
			$model->texto = $model->carta;
			$traza = Trazabilidad::model()->findByPk($model->id_traza);
			$recepcion = Recepcion::model()->findByPk($traza->na);
			
			if( $model->validate() && $model->validaRespuestas() ){
				//Actualizar cartas
				$update = Cartas::model()->actualizaCartas($traza->id, $model->carta);
				//Eviar Respuestas Cartas				
				$envio = Cartas::model()->clasificacionCarta($traza->id);

				$actividad = Actividades::model()->cierraActividad($traza->id);
				if($actividad){
		            $abrir_actividad = Actividades::model()->abrirActividad($traza->na, $actividad, $traza->id);
		            if($abrir_actividad){
		                $aux = true;
		            }else{
		                $aux = false;
		            }
			    }else{
			        $aux = false;
			    }
				
			    if($aux){
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_generaRespuesta', array('model'=>$model, 'recepcion'=>$recepcion, 'id_traza'=>$traza->id), true, true)));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_generaRespuesta', array('model'=>$model, 'recepcion'=>$recepcion, 'id_traza'=>$traza->id), true, true)));
				}
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_generaRespuesta', array('model'=>$model, 'recepcion'=>$recepcion, 'id_traza'=>$traza->id), true, true)));
			}
		}
	}
	public function actionAdmin()
	{
		$model = new Actividades('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_POST['Actividades']))
			$model->attributes=$_POST['Actividades'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionCarta()
	{
		$id_carta = $_POST['id_carta'];
		$na = $_POST['na'];
		$recepcion = Recepcion::model()->informacionRecepcion($na);
		$empresa = EmpresaPersona::model()->informacionEmpresa($recepcion->documento);
		$carta = PlantillasCartas::model()->findByAttributes(array("id"=>$id_carta));
		$ciudad = Ciudades::model()->findByAttributes(array("codigo"=>$recepcion->ciudad));
		$meses = array('01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', '04'=>'Abril', '05'=>'Mayo', '06'=>'Junio', '07'=>'Julio', '08'=>'Agosto', '09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');
		$mes = $meses[date("m")];
		$carta->plantilla = str_replace("{Dia}",date("d"),$carta->plantilla);
		$carta->plantilla = str_replace("{Mes}",$mes,$carta->plantilla);
		$carta->plantilla = str_replace("{Ano}",date("Y"),$carta->plantilla);
		$carta->plantilla = str_replace("{NombreAfiliado}",ucwords(strtolower($empresa->razon)),$carta->plantilla);
		$carta->plantilla = str_replace("{Ciudad}",ucwords(strtolower($ciudad->ciudad)),$carta->plantilla);
		$carta->plantilla = str_replace("MedellÍn",'Medellín',$carta->plantilla);
		echo $carta->plantilla;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Actividades the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Actividades::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Actividades $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='actividades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function cargarArchivo()
	{
	    header('Vary: Accept');
	    if (isset($_SERVER['HTTP_ACCEPT']) && 
	        (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false))
	    {
	        header('Content-type: application/json');
	    } else {
	        header('Content-type: text/plain');
	    }
	    $data = array();
	    $adjuntos = new AdjuntosRecepcion;
	    $adjuntos->archivo = CUploadedFile::getInstance($adjuntos,'archivo');
	    print_r($adjuntos->archivo->extensionName);
	    die("Hola Mundo");
	}
		public function actionCopias()
	{
		$model = new Cartas;
		$telefono = new TelefonosCartas;
		$fisico = new CartasFisicas;
		$mail = new CartasMail;
		$aux = true;
		$model->trazabilidad = 1;
		$model->plantilla = 1;
		if($_POST["na"] && $_POST["carta"]){
			$na = $_POST["na"];
			$carta = $_POST["carta"];
			$model->na = $na;
			$model->carta = $carta;
		}
		if(isset($_POST['Cartas'])){
			$model->attributes = $_POST['Cartas'];
			if($model->validate()){
				if($model->entrega == "1"){
					$mail->attributes = $_POST['CartasMail'];
					if($mail->validate()){
						$model->save();
						$guarda_mail = CartasMail::model()->guardaMail($mail->mail, $model->id);
					}else{
						$aux = false;	
					}
				}elseif($model->entrega == "2"){
					$fisico->attributes = $_POST['CartasFisicas'];
					$telefono->attributes = $_POST['TelefonosCartas'];
					if($fisico->validate()){
						$model->save();
						$guarda_fisico = CartasFisicas::model()->guardaFisico($model->id,$fisico->firma,$fisico->direccion,$fisico->ciudad);
						if(!empty($telefono->attributes)){
							$guarda_telefono = TelefonosCartas::model()->guardaTelefono($model->id, $telefono->telefono);
						}
					}else{
						$aux = false;
					}
				}
			}else{
				$aux = false;
			}
		}
		if($aux){
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('copias', array('model' => $model,'fisico'=>$fisico,'mail'=>$mail,'telefono'=>$telefono), true, true)));
		}else{
			echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('copias', array('model' => $model,'fisico'=>$fisico,'mail'=>$mail,'telefono'=>$telefono), true, true)));
		}
	}
	public function actionEditar(){
		if(Yii::App()->request->isAjaxRequest){
			if(isset($_POST['Actividades'])){
				$model = Actividades::model()->findByPk($_POST['Actividades']['id']);
				$model->attributes = $_POST['Actividades'];
				
	            if($model->validate()){
	            	$model->save();
	                echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_editaActividad', array('model' => $model), true, true)));
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_editaActividad', array('model' => $model), true, true)));
				}
				exit;
			}else{
				$id = $_POST["id"];
				if(!empty($id) ){
					$model = $this->loadModel($id);
					
					if($model){
						//echo CJSON::encode(array('status'=>'success', 'content' => "OK", true, true));
						echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_editaActividad', array('model' => $model), true, true)));
					}else{
						echo CJSON::encode(array('status'=>'error', 'content' => "No se logró cargar información de la actividad.", true, true));
					}				
				}else{
					echo CJSON::encode(array('status'=>'error', 'content' => "No se encontró actividad.", true, true));
				}
			}
		}
	}
	public function actionConsultaEmail(){
		if(Yii::App()->request->isAjaxRequest){
			if($_POST["na"]){
				$na = $_POST["na"];
				$mail = MailRecepcion::getMail($na);
				if($mail){
					die($mail);
				}else{
					die;
				}
			}
		}
	}
	public function actionCartasRespuesta(){
   		if(Yii::App()->request->isAjaxRequest){
   			$na = $_POST['na'];
   			$id_traza = $_POST['id_traza'];

   			$total = Cartas::model()->countByAttributes(array("na"=>$na, "id_trazabilidad"=>$id_traza));
   			if($total > 0){
				$modelCartas = new Cartas('search');
				$modelCartas->unsetAttributes();
   				$modelCartas->na = $na;
   				$modelCartas->id_trazabilidad = $id_traza;

   				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_cartasRespuesta', array('modelCartas' => $modelCartas), true, true)));
   			}else{
				echo CJSON::encode(array('status'=>'error'));
   			}
   		}
   	}
   	public function actionEliminarCarta(){
        if(Yii::App()->request->isAjaxRequest){
            if($_POST["id"]){
                $id = $_POST["id"];
                $model=Cartas::model()->findByPk($id);
                if($model->delete()){
                   	echo CJSON::encode(array('status'=>'success'));
                }else{
                    echo CJSON::encode(array('status'=>'error'));
                }
            }
        }
    }
    public function actionCargarDocumento(){
		$aux = true;
		$model = new AdjuntosRespuesta;
		if(!empty($_POST["id_trazabilidad"])){
			$model->id_trazabilidad = $_POST["id_trazabilidad"];
		}
		if(isset($_POST['AdjuntosRespuesta'])){
			$model->attributes = $_POST['AdjuntosRespuesta'];
			$model->path_web = str_replace("/vol2", "http://".$_SERVER['HTTP_HOST'], $model->archivo);
			$model->path_fisico = $model->archivo;

			if(!$model->save()){
				$aux = false;
			}
		}
		if($aux){
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_adjuntosRespuesta', array('model' => $model), true, true)));
		}else{
			echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_adjuntosRespuesta', array('model' => $model), true, true)));
		}
		Yii::app()->end();
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
    public function actionAdjuntosRespuesta(){
   		if(Yii::App()->request->isAjaxRequest){
   			$id_trazabilidad = $_POST['id_trazabilidad'];
   			$total = AdjuntosRespuesta::model()->countByAttributes(array("id_trazabilidad"=>$id_trazabilidad));

   			if($total > 0){
				$modelAdjuntos = new AdjuntosRespuesta('search');
   				$modelAdjuntos->id_trazabilidad = $id_trazabilidad;

   				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_listaAdjuntos', array('modelAdjuntos' => $modelAdjuntos), true, true)));
   			}else{
				echo CJSON::encode(array('status'=>'error'));
   			}
   		}
   	}
   	public function actionEliminarAdjunto(){
        if(Yii::App()->request->isAjaxRequest){
            if($_POST["id"]){
                $id = $_POST["id"];
                $model = AdjuntosRespuesta::model()->findByPk($id);
                if($model->delete()){
                   	echo CJSON::encode(array('status'=>'success'));
                }else{
                    echo CJSON::encode(array('status'=>'error'));
                }
            }
        }
    }
}

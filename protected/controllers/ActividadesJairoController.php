<?php

class ActividadesJairoController extends Controller
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
				'actions'=>array('create','update','prueba2','index','carta','cargarArchivo','copias','admin','editar','consultaEmail', 'devolver'),
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
		//$fisico = new CartasFisicas;
		//$mail = new CartasMail;
		//$telefono = new TelefonosCartas;
		$aux = "";
		if($_POST["id_trazabilidad"]){
			$id_trazabilidad = $_POST["id_trazabilidad"];
			$flujo=Trazabilidad::model()->findByPk($id_trazabilidad);	
		}
		if($flujo){
			$actividad = ActividadTipologia::model()->findByAttributes(array("id"=>$flujo->actividad));
			switch($actividad->id_actividad){
				/*case "3":
					$model = new Cartas;
					$recepcion = Recepcion::model()->informacionRecepcion($flujo->na);
					$empresa = EmpresaPersona::model()->informacionEmpresa($recepcion->documento);
					$consulta = Cartas::model()->findAllByAttributes(array("na"=>$flujo->na));
					$rows = count($consulta);
					$model->trazabilidad = $id_trazabilidad;
					$model->na = $flujo->na;
					$model->nombre_destinatario = ucwords(strtolower($empresa->razon));
					$tipologia = $recepcion->tipologia;
					//$mail->mail = MailRecepcion::getMail($flujo->na);
					echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('generacionRespuesta', array('model' => $model,'fisico'=>$fisico,'mail'=>$mail,'telefono'=>$telefono,'rows'=>$rows,'tipologia'=>$tipologia), true, true)));
				break;*/
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
		/*if(isset($_POST['Cartas'])){
			$model = new Cartas;
			$model->attributes = $_POST['Cartas'];
			$telefono->attributes = $_POST['TelefonosCartas'];
			$rows = $_POST['rows'];
			$tipologia = $_POST['tipologia'];
			$model->carta = $_POST['Cartas']['area_carta'];
			$model->area_carta = $model->carta;
			$model->principal = "Si";
			if($model->validate()){
				if($model->entrega == "1"){
					$mail->attributes = $_POST['CartasMail'];
					if($mail->validate()){
						if($model->save()){
							$guarda_mail = CartasMail::model()->guardaMail($mail->mail, $model->id);
							if($guarda_mail){
								$trazabilidad = Trazabilidad::model()->findByPk($model->trazabilidad);
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
						}else{
							$aux = false;
						}
					}else{
						$aux = false;
					}
				}elseif($model->entrega == "2"){
					$fisico->attributes = $_POST['CartasFisicas'];
					if($fisico->validate()){
						if($model->save()){		
							$guarda_fisico = CartasFisicas::model()->guardaFisico($model->id,$fisico->firma,$fisico->direccion,$fisico->ciudad);
							if($guarda_fisico){				
								$trazabilidad = Trazabilidad::model()->findByPk($model->trazabilidad);
								if($trazabilidad){
									$actividad = Actividades::model()->cierraActividad($trazabilidad->id);
									if($actividad){
										$abrir_actividad = Actividades::model()->abrirActividad($trazabilidad->na,$actividad,$trazabilidad->id);
										if($abrir_actividad){
											if(!empty($telefono->attributes)){
												$guarda_telefono = TelefonosCartas::model()->guardaTelefono($model->id, $telefono->telefono);
											}
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
						}else{
							$aux = false;
						}
					}else{
						$aux = false;
					}
				}				
			}else{
				$aux = false;
			}
			if($aux){
				$actualizaCarta = Cartas::actualizaCarta($model->na, $model->carta);
				$clasificacion = Cartas::clasificacionCarta($model->na);
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('generacionRespuesta', array('model' => $model,'fisico'=>$fisico,'mail'=>$mail,'telefono'=>$telefono,'rows'=>$rows,'tipologia'=>$tipologia), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('generacionRespuesta', array('model' => $model,'fisico'=>$fisico,'mail'=>$mail,'telefono'=>$telefono,'rows'=>$rows,'tipologia'=>$tipologia), true, true)));
			}
		}*/
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
	// Acciones jairo
	public function actionDevolver(){
		if($_POST["id_trazabilidad"]){
			$id_trazabilidad = $_POST["id_trazabilidad"];
			$flujo=Trazabilidad::model()->findByPk($id_trazabilidad);	
		}
		if($flujo){
			$model = new ObservacionesTrazabilidad;
			$model->id_trazabilidad = $id_trazabilidad;
			$na = Trazabilidad::model()->findByAttributes(array("id"=>$id_trazabilidad));
			$model->na = $na->na;
			$actividades = CHtml::listData($na->actividad0->relaciones1,'desde','desde0.idActividad.actividad');
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('devolucion', array('model' => $model, 'actividades'=>$actividades), true, true)));
		}
		if(isset($_POST['ObservacionesTrazabilidad'])){
			$model = new ObservacionesTrazabilidad;
			$model->attributes = $_POST['ObservacionesTrazabilidad'];
			$model->usuario = Yii::app()->user->usuario;
			if($model->validate()){
				$trazabilidad = Trazabilidad::model()->findByPk($model->id_trazabilidad);
				if($trazabilidad){
					$actividad = Actividades::model()->devolverActividad($trazabilidad->id);
					$model->observacion .= " - Se devuelve de actividad ".ucwords(strtolower($trazabilidad->actividad0->idActividad->actividad))." a la actividad ".Actividades::model()->nombreActividad($_POST['actividad']);
					$model->save();
					if($actividad){
						$reabrir_actividad = Actividades::model()->reabrirActividad($trazabilidad, $_POST['actividad']);
						if($reabrir_actividad){
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
			$na = Trazabilidad::model()->findByAttributes(array("id"=>$_POST['ObservacionesTrazabilidad']['id_trazabilidad']));
			$actividades = CHtml::listData($na->actividad0->relaciones1,'desde','desde0.idActividad.actividad');
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('devolucion', array('model' => $model, 'actividades'=>$actividades), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('devolucion', array('model' => $model, 'actividades'=>$actividades), true, true)));
			}
		}
	}

}

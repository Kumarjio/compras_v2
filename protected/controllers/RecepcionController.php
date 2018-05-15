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
				'actions'=>array('create','update','admin','delete','form','tipologia','razon','punteo','casos','prueba','valida','masiva','uploadMasiva','fechaCliente', 'consultaDocumento','cargarDocumento','upload', 'adjuntosRecepcion','eliminarAdjunto','cargueOrigenComun','ciudades'),
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
		$sucursal = new SucursalRecepcion;
		$polizaEmpresa = new PolizaEmpresa;
		$observacion = new ObservacionesTrazabilidad;
		$empresa = new EmpresaPersona;
		$mail = new MailRecepcion;
		//$adjuntos = new AdjuntosTrazabilidad;
		$adjuntos_recepcion = new AdjuntosRecepcion('search');
		$guardo = true;
		$tipologias = array();
		$ciudades = array();
		if(isset($_POST['Recepcion'])){
			$model->attributes = $_POST['Recepcion'];
			$sucursal->attributes = $_POST['SucursalRecepcion'];
			$polizaEmpresa->attributes = $_POST['PolizaEmpresa'];
			$observacion->attributes = $_POST['ObservacionesTrazabilidad'];
			$empresa->attributes = $_POST['EmpresaPersona'];
			//$adjuntos->attributes = $_POST['AdjuntosRecepcion'];
			$mail->attributes = $_POST['MailRecepcion'];
			//$adjuntos->archivo = CUploadedFile::getInstance($adjuntos,'archivo');
			$model->user_recepcion = Yii::app()->user->usuario;
			$model->fecha_cliente = Recepcion::fechaCliente($model->tipologia);
			$model->fecha_interna = Recepcion::fechaInterna($model->tipologia);
			if(!empty($model->fecha_entrega)){
				$model->fecha_entrega = date('Ymd', strtotime($model->fecha_entrega));
			}
			if(!empty($sucursal->fecha_sucursal)){
				$sucursal->fecha_sucursal = date('Ymd', strtotime($sucursal->fecha_sucursal));
			}
			if($model->validate()){
				if($model->tipo_documento == "1"){
					if($sucursal->validate() && $empresa->validate()){
						$model->na = NULL;
						if ($model->save()) {
							$sucursal->na = $model->na;
							if($sucursal->save()){
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
								$inicia = Recepcion::iniciaRecepcion($model->na, $model->tipologia);
								if(!empty($observacion->observacion)){
									$observacion->na = $model->na;
									$observacion->id_trazabilidad = $inicia;
									$observacion->usuario = Yii::app()->user->usuario;
									$observacion->save();
								}	
								$consulta_adjuntos = AdjuntosRecepcion::model()->findAllByAttributes(array("na"=>$_POST['Recepcion']['na'], "activo"=>true));
								if($inicia){
									if(!empty($consulta_adjuntos)){
										AdjuntosTrazabilidad::guardaAdjuntos($consulta_adjuntos,$inicia,$model->na);
									}
									$actividad = Actividades::model()->cierraActividad($inicia);
									if($actividad){
										$abrir_actividad = Actividades::model()->abrirActividad($model->na,$actividad,$inicia);
										if($abrir_actividad){
											$this->redirect(array('trazabilidad/index/','na' => base64_encode($model->na)));
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
					}else{
						$guardo = false;
					}
				}else{
					if($empresa->validate() && $mail->validate()){
						$model->na = NULL;
						if ($model->save()) {
							$mail->na = $model->na;
							$mail->save();
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
							$inicia = Recepcion::iniciaRecepcion($model->na, $model->tipologia);
							if(!empty($observacion->observacion)){
								$observacion->na = $model->na;
								$observacion->id_trazabilidad = $inicia;
								$observacion->usuario = Yii::app()->user->usuario;
								if(!$observacion->save()){
									print_r($model->getErrors());die;
								}
							}
							$consulta_adjuntos = AdjuntosRecepcion::model()->findAllByAttributes(array("na"=>$_POST['Recepcion']['na'], "activo"=>true));
							if($inicia){
								if(!empty($consulta_adjuntos)){
									AdjuntosTrazabilidad::guardaAdjuntos($consulta_adjuntos,$inicia,$model->na);
								}
								$actividad = Actividades::model()->cierraActividad($inicia);
								if($actividad){
									$abrir_actividad = Actividades::model()->abrirActividad($model->na,$actividad,$inicia);
									if($abrir_actividad){
										$this->redirect(array('trazabilidad/index/','na' => base64_encode($model->na)));
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
		if(empty($model->na)){
			$model->na = Yii::app()->db->createCommand("SELECT nextval('concecutivos_adjuntos_seq')")->queryScalar();
		}
		$this->render('_form',array(
			'model'=>$model,
			'sucursal'=>$sucursal,
			'tipologias'=>$tipologias,
			'poliza'=>$polizaEmpresa,
			'observacion'=>$observacion,
			'empresa'=>$empresa,
			//'adjuntos'=>$adjuntos,
			'mail'=>$mail,
			'rows'=>$rows,
			'adjuntos_recepcion'=>$adjuntos_recepcion,
			'ciudades'=>$ciudades,
		));
	}
	public function actionAdjuntosRecepcion(){
   		if(Yii::App()->request->isAjaxRequest){
   			$na = $_POST['na'];
   			$rows = AdjuntosRecepcion::model()->countByAttributes(array("na"=>$na, "activo"=>true));

   			if($rows > 0){
				$modelAdjuntos = new AdjuntosRecepcion('search');
   				$modelAdjuntos->na = $na;

   				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_adjuntosRecepcion', array('modelAdjuntos' => $modelAdjuntos), true, true)));
   			}else{
				echo CJSON::encode(array('status'=>'error'));
   			}
   		}
   	}
	public function actionTipologia(){
		$area = $_POST['Recepcion']['area'];
		if(!empty($area)){

			$tipologias = CHtml::listData(Tipologias::model()->findAll('area = :area AND activa = :act AND operacion = :ope AND cargue = :cg', array(':area'=>$area, ':act'=>true, ':ope'=>true, ':cg'=>false)),'id','tipologia');

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
	public function actionCiudades(){
		$departamento = $_POST['Recepcion']['departamento'];
		if(!empty($departamento)){

			$ciudades = CHtml::listData(Ciudad::model()->findAll('id_departamento = :departamento', array(':departamento'=>$departamento)),'id_ciudad','nombre_ciudad');
		 	echo CHtml::tag('option',array('value'=>''),'...',true);
			if($ciudades){
				foreach ($ciudades as $valor => $ciudad) {
		 			echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($ciudad),true);
				}
			}	
		}else{
			echo CHtml::tag('option',array('value'=>''),'Seleccione Departamento...',true);
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
		$tipo = $_POST["tipo"];
		if($tipo == 1){
			$consulta = Recepcion::model()->findByAttributes(array("na"=>$data));
			if($consulta){
				$consulta->na = base64_encode($consulta->na);
				echo Yii::app()->createUrl("trazabilidad/index",array('na'=>$consulta->na));
				exit;
			}else{
				die;
			}
		}
		elseif ($tipo == 2) {
			$consulta = Recepcion::model()->countByAttributes(array("documento"=>$data));
			if($consulta){
				$documento = base64_encode($data);
				echo $this->createUrl('consultaDocumento',array('documento'=>$documento));
				//echo Yii::app()->createUrl("consultaDocumento",array('documento'=>$documento));
				die;
			}else{
				die;
			}
		}
	}
	public function actionMasiva(){
		$model = new CargaMasiva;
		$modelOrigen = new CargaMasivaOrigen;
		$modelPcl = new CargaMasivaPcl;
		if(isset($_POST['CargaMasiva'])){
			$model->adjunto = $_POST['CargaMasiva']['adjunto'];
			if($model->validate()){			
				set_include_path(implode(PATH_SEPARATOR, array(
							realpath(Yii::app()->basePath. '/' . 'extensions' . '/' . 'phpexcel' . '/' . 'Classes' . '/'),
							get_include_path(),
               			)
					)
				);
				require_once("PHPExcel/IOFactory.php");
				//Se busca archivo cargado en la carpeta temporal
				$nombreArchivo = $model->adjunto;
				$raiz = '/tmp/'.$nombreArchivo;
				// Cargo la hoja de cálculo
				$objPHPExcel = PHPExcel_IOFactory::load($raiz);
				//Asigno la hoja de calculo activa
				$objPHPExcel->setActiveSheetIndex(0);
				//Obtengo el número de filas del archivo
				$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				//Se obtiene el número máximo de columnas
				$colMax = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				$numCol = PHPExcel_Cell::columnIndexFromString($colMax);
				//$headingsArray contiene las cabeceras de la hoja excel. Los titulos de columnas (Primera fila)
				$headingsArray = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A5:'.$colMax.'5',null, true, true, true);
				$headingsArray = $headingsArray[1];
				if(($numRows > 0) && ($numCol == 19)){
					$cont=0;
					$conterror = 0;
					$log = '<br><br><b>LOG: </b></font><font face="courier new" color="black"><br>';	
					for($i = 6; $i <= $numRows; $i++){
						$cargue = new CargueMasivo;
						$cargue->codigo_barras = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
						$consulta = CargueMasivo::model()->findByAttributes(array("codigo_barras"=>$cargue->codigo_barras));
						if(!$consulta){
							$cargue->asunto = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
							$cargue->fecha_radicacion = trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue());
							$cargue->usuario_cargue = Yii::app()->user->usuario;
							//$cargue->imagen = CargueMasivo::imagen($cargue->codigo_barras);
							$numeros = CargueMasivo::devuelveNumeros($cargue->asunto);
							if($numeros){
								$cargue->renta = $numeros;
							}
							if($cargue->save()){
								$cont++;
						 	}else{
						 		$conterror++;
						 		$log .= "<b>(Fila: ".$i.")</b>";
						 		foreach($cargue->getErrors() as $error){
						 			$log .= $error[0]." ";
						 		}					 		
						 		$log .= "<br>";
						 	}
						}else{
							$conterror++;
						 	$log .= "<b>(Fila: ".$i.")</b>"."Codigo de barras duplicado"." "."<br>";
						}
					}					
					if($cont > 0){
						$mensaje = '<center><i class="glyphicon glyphicon-ok"></i>&nbsp;<b>El archivo "'.$nombreArchivo.'" se ha cargado al sistema:</b></center><br>';
						$mensaje .= '* Se cargaron '.$cont.' registros correctamente.<br>';
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}				
						Yii::app()->user->setFlash('notifica', $mensaje);
					}else{
						//Elimina archivo cargado
						if(file_exists('/tmp/'.$nombreArchivo)){
							unlink('/tmp/'.$nombreArchivo);
						}
						$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
						$mensaje .= '* No se encontró ningun registro válido en el archivo "'.$nombreArchivo.'" para cargar al sistema.<br>';
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}
						Yii::app()->user->setFlash('error', $mensaje);
					}
				}else{
					//Elimina archivo cargado
					if(file_exists('/tmp/'.$nombreArchivo)){
						unlink('/tmp/'.$nombreArchivo);
					}
					$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
					if($numRows <= 5){
						$mensaje .= '* El archivo "'.$nombreArchivo.'" no tiene registros de empleados para ingresar al sistema.<br>';
					}
					if($numCol > 19){
						$mensaje .= '* El archivo cargado al sistema tiene mas columnas de las definidas (19).<br>';
					}
					if($numCol < 19){
						$mensaje .= '* El archivo cargado al sistema tiene menos columnas de las definidas (19).<br>';
					}
					Yii::app()->user->setFlash('error', $mensaje);
				}
			}
		}
		if(isset($_POST['CargaMasivaOrigen'])){
			$modelOrigen->adjunto = $_POST['CargaMasivaOrigen']['adjunto'];
			if($modelOrigen->validate()){			
				set_include_path(implode(PATH_SEPARATOR, array(
							realpath(Yii::app()->basePath. '/' . 'extensions' . '/' . 'phpexcel' . '/' . 'Classes' . '/'),
							get_include_path(),
               			)
					)
				);
				require_once("PHPExcel/IOFactory.php");
				//Se busca archivo cargado en la carpeta temporal
				$nombreArchivo = $modelOrigen->adjunto;
				$raiz = '/tmp/'.$nombreArchivo;
				// Cargo la hoja de cálculo
				$objPHPExcel = PHPExcel_IOFactory::load($raiz);
				//Asigno la hoja de calculo activa
				$objPHPExcel->setActiveSheetIndex(0);
				//Obtengo el número de filas del archivo
				$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				//Se obtiene el número máximo de columnas
				$colMax = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				$numCol = PHPExcel_Cell::columnIndexFromString($colMax);
				//$headingsArray contiene las cabeceras de la hoja excel. Los titulos de columnas (Primera fila)
				$headingsArray = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A1:'.$colMax.'1',null, true, true, true);
				$headingsArray = $headingsArray[1];
				if(($numRows > 0) && ($numCol == 19)){
					$cont=0;
					$conterror = 0;
					$log = '<br><br><b>LOG: </b></font><font face="courier new" color="black"><br>';	
					for($i = 2; $i <= $numRows; $i++){
						$comun = new CargueComun;
						$comun->siniestro = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
						$consulta = CargueComun::model()->findByAttributes(array("siniestro"=>$comun->siniestro));
						if(!$consulta){
							$comun->nombre = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
							$comun->direccion = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
							$comun->telefono = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
							$comun->ciudad = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
							$comun->departamento = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
							$comun->diagnostico = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
							$comun->nombre_empresa = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
							$comun->direccion_empresa = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
							$comun->telefono_empresa = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());
							$comun->ciudad_empresa = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());
							$comun->eps = trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue());
							$comun->direccion_eps = trim($objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue());
							$comun->telefono_eps = trim($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
							$comun->ciudad_eps = trim($objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue());
							$comun->afp = trim($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue());
							$comun->direccion_afp = trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue());
							$comun->telefono_afp = trim($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue());
							$comun->ciudad_afp = trim($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue());
							$comun->usuario_cargue = Yii::app()->user->usuario;
							if($comun->validate()){
								$tipologia = Tipologias::model()->findByAttributes(array("id"=>"23"));
								$ciudad = Ciudad::model()->findByAttributes(array("id_ciudad"=>$comun->ciudad));
								if($ciudad){
									$recepcion = new Recepcion;
									$recepcion->documento = $comun->siniestro;
									$recepcion->area = $tipologia->area;
									$recepcion->tipologia = $tipologia->id;
									$recepcion->departamento = $ciudad->id_departamento;
									$recepcion->ciudad = $ciudad->id_ciudad;
									$recepcion->tipo_documento = "4";
									$recepcion->user_recepcion = $comun->usuario_cargue;
									$recepcion->fecha_entrega = date("Ymd");
									$recepcion->hora_entrega = date("H:m");
									$recepcion->fecha_cliente = Recepcion::fechaCliente($recepcion->tipologia);
									$recepcion->fecha_interna = Recepcion::fechaInterna($recepcion->tipologia);
									if($recepcion->save()){
										$consulta_razon = EmpresaPersona::model()->findByAttributes(array("documento"=>$comun->siniestro));
										if(!$consulta_razon){
											$empresa = new EmpresaPersona;
											$empresa->documento = $recepcion->documento;
											$empresa->razon = $comun->nombre;
											$empresa->documento_identificacion = "9";
											$empresa->save();
										}
										$comun->na = $recepcion->na;
										$comun->save();
										$inicia = Recepcion::iniciaRecepcion($recepcion->na, $recepcion->tipologia);
										if($inicia){
											$actividad = Actividades::model()->cierraActividad($inicia);
											if($actividad){
												$abrir_actividad = Actividades::model()->abrirActividad($recepcion->na,$actividad,$inicia);
												if($abrir_actividad){
													$consulta_traza = Trazabilidad::model()->findByAttributes(array("na"=>$recepcion->na, "estado"=>"1"),array('order'=> 'id DESC'));
													if(!empty($comun->nombre)){
														$destinatario = array(
														    'principal'=>true, 
														    'empresa'=>false,
														    'eps'=>false,
														    'afp'=>false,
														);
														Cartas::cartasComunes($consulta_traza->id, $consulta_traza->na, $destinatario, $comun->id);
													}
													if(!empty($comun->nombre_empresa)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>true,
														    'eps'=>false,
														    'afp'=>false,
														);
														Cartas::cartasComunes($consulta_traza->id, $consulta_traza->na, $destinatario, $comun->id);
													}
													if(!empty($comun->eps)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>false,
														    'eps'=>true,
														    'afp'=>false,
														);
														Cartas::cartasComunes($consulta_traza->id, $consulta_traza->na, $destinatario, $comun->id);
													}
													if(!empty($comun->afp)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>false,
														    'eps'=>false,
														    'afp'=>true,
														);
														Cartas::cartasComunes($consulta_traza->id, $consulta_traza->na, $destinatario, $comun->id);
													}										
													$cierraActividad = Actividades::model()->cierraActividad($consulta_traza->id);
													if($cierraActividad){
														$abrir_actividad = Actividades::model()->abrirActividad($recepcion->na,$cierraActividad,$consulta_traza->id);
													}
												}	
											}
										}
										$cont++;
										$na .= "<b>(Fila: ".$i.")</b>"." Caso generado: <b>".$recepcion->na."</b><br>";
									}else{
										$conterror++;
								 		$log .= "<b>(Fila: ".$i.")</b>";
								 		foreach($recepcion->getErrors() as $error){
								 			$log .= $error[0]." ";
								 		}					 		
								 		$log .= "<br>";
									}
								}else{
									$conterror++;
						 			$log .= "<b>(Fila: ".$i.")</b>"."Codigo de ciudad no valido"." "."<br>";
								}
						 	}else{
						 		$conterror++;
						 		$log .= "<b>(Fila: ".$i.")</b>";
						 		foreach($comun->getErrors() as $error){
						 			$log .= $error[0]." ";
						 		}					 		
						 		$log .= "<br>";
						 	}
						}else{
							$conterror++;
						 	$log .= "<b>(Fila: ".$i.")</b>"."Codigo de siniestro duplicado"." "."<br>";
						}
					}	
					if($cont > 0){
						$mensaje = '<center><i class="glyphicon glyphicon-ok"></i>&nbsp;<b>El archivo "'.$nombreArchivo.'" se ha cargado al sistema:</b></center><br>';
						$mensaje .= '* Se cargaron '.$cont.' registros correctamente.<br>'.$na;					
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}				
						Yii::app()->user->setFlash('notificaComun', $mensaje);
					}else{
						//Elimina archivo cargado
						if(file_exists('/tmp/'.$nombreArchivo)){
							unlink('/tmp/'.$nombreArchivo);
						}
						$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
						$mensaje .= '* No se encontró ningun registro válido en el archivo "'.$nombreArchivo.'" para cargar al sistema.<br>';
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}
						Yii::app()->user->setFlash('errorComun', $mensaje);
					}
				}else{
					//Elimina archivo cargado
					if(file_exists('/tmp/'.$nombreArchivo)){
						unlink('/tmp/'.$nombreArchivo);
					}
					$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
					if($numRows <= 5){
						$mensaje .= '* El archivo "'.$nombreArchivo.'" no tiene registros de empleados para ingresar al sistema.<br>';
					}
					if($numCol > 19){
						$mensaje .= '* El archivo cargado al sistema tiene mas columnas de las definidas (19).<br>';
					}
					if($numCol < 19){
						$mensaje .= '* El archivo cargado al sistema tiene menos columnas de las definidas (19).<br>';
					}
					Yii::app()->user->setFlash('errorComun', $mensaje);
				}
			}
		}
		if(isset($_POST['CargaMasivaPcl'])){
			$modelPcl->adjunto = $_POST['CargaMasivaPcl']['adjunto'];
			if($modelPcl->validate()){			
				set_include_path(implode(PATH_SEPARATOR, array(
							realpath(Yii::app()->basePath. '/' . 'extensions' . '/' . 'phpexcel' . '/' . 'Classes' . '/'),
							get_include_path(),
               			)
					)
				);
				require_once("PHPExcel/IOFactory.php");
				//Se busca archivo cargado en la carpeta temporal
				$nombreArchivo = $modelPcl->adjunto;
				$raiz = '/tmp/'.$nombreArchivo;
				// Cargo la hoja de cálculo
				$objPHPExcel = PHPExcel_IOFactory::load($raiz);
				//Asigno la hoja de calculo activa
				$objPHPExcel->setActiveSheetIndex(0);
				//Obtengo el número de filas del archivo
				$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				//Se obtiene el número máximo de columnas
				$colMax = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				$numCol = PHPExcel_Cell::columnIndexFromString($colMax);
				//$headingsArray contiene las cabeceras de la hoja excel. Los titulos de columnas (Primera fila)
				$headingsArray = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A1:'.$colMax.'1',null, true, true, true);
				$headingsArray = $headingsArray[1];
				if(($numRows > 0) && ($numCol == 23)){
					$cont=0;
					$conterror = 0;
					$log = '<br><br><b>LOG: </b></font><font face="courier new" color="black"><br>';	
					for($i = 2; $i <= $numRows; $i++){
						$pcl = new CarguePcl;
						$pcl->siniestro = trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
						$consulta = CarguePcl::model()->findByAttributes(array("siniestro"=>$pcl->siniestro));
						if(!$consulta){
							$pcl->nombre = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
							$pcl->direccion = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
							$pcl->telefono = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
							$pcl->ciudad = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
							$pcl->departamento = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
							$pcl->porcentaje = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
							$pcl->fecha_estructuracion = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
							$pcl->diagnostico = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
							$pcl->meses = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());
							$pcl->meses_letras = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());
							$pcl->nombre_empresa = trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue());
							$pcl->direccion_empresa = trim($objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue());
							$pcl->telefono_empresa = trim($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
							$pcl->ciudad_empresa = trim($objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue());
							$pcl->eps = trim($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue());
							$pcl->direccion_eps = trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue());
							$pcl->telefono_eps = trim($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue());
							$pcl->ciudad_eps = trim($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue());
							$pcl->afp = trim($objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue());
							$pcl->direccion_afp = trim($objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue());
							$pcl->telefono_afp = trim($objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue());
							$pcl->ciudad_afp = trim($objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue());
							$pcl->usuario_cargue = Yii::app()->user->usuario;
							if($pcl->validate()){
								$tipologia = Tipologias::model()->findByAttributes(array("id"=>"24"));
								$ciudad = Ciudad::model()->findByAttributes(array("id_ciudad"=>$pcl->ciudad));
								if($ciudad){
									$recepcion = new Recepcion;
									$recepcion->documento = $pcl->siniestro;
									$recepcion->area = $tipologia->area;
									$recepcion->tipologia = $tipologia->id;
									$recepcion->departamento = $ciudad->id_departamento;
									$recepcion->ciudad = $ciudad->id_ciudad;
									$recepcion->tipo_documento = "5";
									$recepcion->user_recepcion = $pcl->usuario_cargue;
									$recepcion->fecha_entrega = date("Ymd");
									$recepcion->hora_entrega = date("H:m");
									$recepcion->fecha_cliente = Recepcion::fechaCliente($recepcion->tipologia);
									$recepcion->fecha_interna = Recepcion::fechaInterna($recepcion->tipologia);
									if($recepcion->save()){
										$consulta_razon = EmpresaPersona::model()->findByAttributes(array("documento"=>$pcl->siniestro));
										if(!$consulta_razon){
											$empresa = new EmpresaPersona;
											$empresa->documento = $recepcion->documento;
											$empresa->razon = $pcl->nombre;
											$empresa->documento_identificacion = "9";
											$empresa->save();
										}
										$pcl->na = $recepcion->na;
										$pcl->save();
										$inicia = Recepcion::iniciaRecepcion($recepcion->na, $recepcion->tipologia);
										if($inicia){
											$actividad = Actividades::model()->cierraActividad($inicia);
											if($actividad){
												$abrir_actividad = Actividades::model()->abrirActividad($recepcion->na,$actividad,$inicia);
												if($abrir_actividad){
													$consulta_traza = Trazabilidad::model()->findByAttributes(array("na"=>$recepcion->na, "estado"=>"1"),array('order'=> 'id DESC'));
													if(!empty($pcl->nombre)){
														$destinatario = array(
														    'principal'=>true, 
														    'empresa'=>false,
														    'eps'=>false,
														    'afp'=>false,
														);
														Cartas::cartasPcl($consulta_traza->id, $consulta_traza->na, $destinatario, $pcl->id);
													}
													if(!empty($pcl->nombre_empresa)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>true,
														    'eps'=>false,
														    'afp'=>false,
														);
														Cartas::cartasPcl($consulta_traza->id, $consulta_traza->na, $destinatario, $pcl->id);
													}
													if(!empty($pcl->eps)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>false,
														    'eps'=>true,
														    'afp'=>false,
														);
														Cartas::cartasPcl($consulta_traza->id, $consulta_traza->na, $destinatario, $pcl->id);
													}
													if(!empty($pcl->afp)){
														$destinatario = array(
														    'principal'=>false, 
														    'empresa'=>false,
														    'eps'=>false,
														    'afp'=>true,
														);
														Cartas::cartasPcl($consulta_traza->id, $consulta_traza->na, $destinatario, $pcl->id);
													}										
													$cierraActividad = Actividades::model()->cierraActividad($consulta_traza->id);
													if($cierraActividad){
														$abrir_actividad = Actividades::model()->abrirActividad($recepcion->na,$cierraActividad,$consulta_traza->id);
													}
												}	
											}
										}
										$cont++;
										$na .= "<b>(Fila: ".$i.")</b>"." Caso generado: <b>".$recepcion->na."</b><br>";
									}else{
										$conterror++;
								 		$log .= "<b>(Fila: ".$i.")</b>";
								 		foreach($recepcion->getErrors() as $error){
								 			$log .= $error[0]." ";
								 		}					 		
								 		$log .= "<br>";
									}
								}else{
									$conterror++;
						 			$log .= "<b>(Fila: ".$i.")</b>"."Codigo de ciudad no valido"." "."<br>";
								}
						 	}else{
						 		$conterror++;
						 		$log .= "<b>(Fila: ".$i.")</b>";
						 		foreach($pcl->getErrors() as $error){
						 			$log .= $error[0]." ";
						 		}					 		
						 		$log .= "<br>";
						 	}
						}else{
							$conterror++;
						 	$log .= "<b>(Fila: ".$i.")</b>"."Codigo de siniestro duplicado"." "."<br>";
						}
					}	
					if($cont > 0){
						$mensaje = '<center><i class="glyphicon glyphicon-ok"></i>&nbsp;<b>El archivo "'.$nombreArchivo.'" se ha cargado al sistema:</b></center><br>';
						$mensaje .= '* Se cargaron '.$cont.' registros correctamente.<br>'.$na;
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}				
						Yii::app()->user->setFlash('notificaPcl', $mensaje);
					}else{
						//Elimina archivo cargado
						if(file_exists('/tmp/'.$nombreArchivo)){
							unlink('/tmp/'.$nombreArchivo);
						}
						$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
						$mensaje .= '* No se encontró ningun registro válido en el archivo "'.$nombreArchivo.'" para cargar al sistema.<br>';
						if($conterror >0){
							$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
						}
						Yii::app()->user->setFlash('errorPcl', $mensaje);
					}
				}else{
					//Elimina archivo cargado
					if(file_exists('/tmp/'.$nombreArchivo)){
						unlink('/tmp/'.$nombreArchivo);
					}
					$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
					if($numRows <= 5){
						$mensaje .= '* El archivo "'.$nombreArchivo.'" no tiene registros de empleados para ingresar al sistema.<br>';
					}
					if($numCol > 23){
						$mensaje .= '* El archivo cargado al sistema tiene mas columnas de las definidas (23).<br>';
					}
					if($numCol < 23){
						$mensaje .= '* El archivo cargado al sistema tiene menos columnas de las definidas (23).<br>';
					}
					Yii::app()->user->setFlash('errorPcl', $mensaje);
				}
			}
		}
		$this->render('_masiva', array(			
			'model'  => $model,
			'modelOrigen' => $modelOrigen,
			'modelPcl'=>$modelPcl
		));
	}
	public function actionUploadMasiva(){

		$tempFolder = '/tmp/';

        if(!is_dir($tempFolder))
        	mkdir($tempFolder, 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");
 
		$uploader = new qqFileUploader();
		$uploader->allowedExtensions = array('xls', 'xlsx');
		$uploader->sizeLimit = 2 * 1024 * 1024;
		$result = $uploader->handleUpload($tempFolder);
		$result['filename'] = $uploader->getUploadName();
		
		$uploadedFile = $tempFolder.$result['filename'];

        $result['path'] = $tempFolder.$result['filename'];
        $result = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
   	}
   	public function actionFechaCliente(){
   		if(Yii::App()->request->isAjaxRequest){
   			$aux = true;
   			if(isset($_POST['Recepcion'])){
   				$model=Recepcion::model()->findByPk($_POST['Recepcion']['na']);
				$tipologia=Tipologias::model()->findByPk($model->tipologia);
				$model->area = $tipologia->area;
				$model->attributes = $_POST['Recepcion'];
				if(!$model->save()){
					$aux = false;
				}
   			}else{
   				$na = $_POST['na'];
				$model=Recepcion::model()->findByPk($na);
				$model->fecha_cliente = date("Y/m/d", strtotime($model->fecha_cliente));
   			}
   			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_updateFechaCliente', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_updateFechaCliente', array('model' => $model), true, true)));
			}
   		}
   	}
    public function actionConsultaDocumento(){
    	$documento = base64_decode($_GET["documento"]);
    	$model = new Recepcion('search');
    	$this->render('consulta',array(
			'model'=> $model,
			'documento'=>$documento
		));
    }
    public function actionCargarDocumento(){
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			$model = new AdjuntosRecepcion;
			if(isset($_POST['AdjuntosRecepcion'])){
				$model->attributes = $_POST['AdjuntosRecepcion'];
				$model->path = $model->archivo;
				$model->path = str_replace("/vol2","http://".$_SERVER['HTTP_HOST'],$model->path);
				if(!$model->save()){
					$aux = false;
				}
			}else{
				$na = $_POST["na"];
				$model->na = $na;
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_archivoRecepcion', array('model' => $model), true, true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_archivoRecepcion', array('model' => $model), true, true)));
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
    public function actionEliminarAdjunto()
    {
    	if(Yii::App()->request->isAjaxRequest){
    		if($_POST["id"]){
    			$id = $_POST["id"];
    			$model=AdjuntosRecepcion::model()->findByPk($id);
    			$model->activo = false;
    			if($model->save()){
    				echo $model->na;
    			}else{
    				die;
    			}
    		}
    	}
    }
    public function actionCargueOrigenComun(){
    	if(Yii::App()->request->isAjaxRequest){
			$modelOrigen = new CargaMasivaOrigen;
			if(isset($_POST['CargaMasivaOrigen'])){
				$modelOrigen->adjunto = $_POST['CargaMasivaOrigen'];
				if($modelOrigen->validate()){			
					set_include_path(implode(PATH_SEPARATOR, array(
								realpath(Yii::app()->basePath. '/' . 'extensions' . '/' . 'phpexcel' . '/' . 'Classes' . '/'),
								get_include_path(),
	               			)
						)
					);
					//print_r($modelOrigen->adjunto);
					//die;
					require_once("PHPExcel/IOFactory.php");
					//Se busca archivo cargado en la carpeta temporal
					$nombreArchivo = $modelOrigen->adjunto;
					$raiz = '/tmp/'.$nombreArchivo;
					// Cargo la hoja de cálculo
					$objPHPExcel = PHPExcel_IOFactory::load($raiz);
					//Asigno la hoja de calculo activa
					$objPHPExcel->setActiveSheetIndex(0);
					//Obtengo el número de filas del archivo
					$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
					//Se obtiene el número máximo de columnas
					$colMax = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$numCol = PHPExcel_Cell::columnIndexFromString($colMax);
					//$headingsArray contiene las cabeceras de la hoja excel. Los titulos de columnas (Primera fila)
					$headingsArray = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A5:'.$colMax.'5',null, true, true, true);
					$headingsArray = $headingsArray[1];
					if(($numRows > 0) && ($numCol == 19)){
						$cont=0;
						$conterror = 0;
						$log = '<br><br><b>LOG: </b></font><font face="courier new" color="black"><br>';	
						for($i = 6; $i <= $numRows; $i++){
							$cargue = new CargueMasivo;
							$cargue->codigo_barras = trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
							$consulta = CargueMasivo::model()->findByAttributes(array("codigo_barras"=>$cargue->codigo_barras));
							if(!$consulta){
								$cargue->asunto = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
								$cargue->fecha_radicacion = trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue());
								$cargue->usuario_cargue = Yii::app()->user->usuario;
								//$cargue->imagen = CargueMasivo::imagen($cargue->codigo_barras);
								$numeros = CargueMasivo::devuelveNumeros($cargue->asunto);
								if($numeros){
									$cargue->renta = $numeros;
								}
								if($cargue->save()){
									$cont++;
							 	}else{
							 		$conterror++;
							 		$log .= "<b>(Fila: ".$i.")</b>";
							 		foreach($cargue->getErrors() as $error){
							 			$log .= $error[0]." ";
							 		}					 		
							 		$log .= "<br>";
							 	}
							}else{
								$conterror++;
							 	$log .= "<b>(Fila: ".$i.")</b>"."Codigo de barras duplicado"." "."<br>";
							}
						}					
						if($cont > 0){
							$mensaje = '<center><i class="glyphicon glyphicon-ok"></i>&nbsp;<b>El archivo "'.$nombreArchivo.'" se ha cargado al sistema:</b></center><br>';
							$mensaje .= '* Se cargaron '.$cont.' registros correctamente.<br>';
							if($conterror >0){
								$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
							}				
							Yii::app()->user->setFlash('notifica', $mensaje);
						}else{
							//Elimina archivo cargado
							if(file_exists('/tmp/'.$nombreArchivo)){
								unlink('/tmp/'.$nombreArchivo);
							}
							$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
							$mensaje .= '* No se encontró ningun registro válido en el archivo "'.$nombreArchivo.'" para cargar al sistema.<br>';
							if($conterror >0){
								$mensaje .= '<br><font color="black"><span class="label label-danger">NOTA</span> Durante el proceso de cargue se encontraron <b>'.$conterror.'</b> registro(s) que no pudieron ser cargados al sistema.'.$log.' </font>';
							}
							Yii::app()->user->setFlash('error', $mensaje);
						}
					}else{
						//Elimina archivo cargado
						if(file_exists('/tmp/'.$nombreArchivo)){
							unlink('/tmp/'.$nombreArchivo);
						}
						$mensaje = '<center><b><i class="glyphicon glyphicon-warning-sign"></i> El sistema no pudo cargar el archivo:</b></center><br>';
						if($numRows <= 5){
							$mensaje .= '* El archivo "'.$nombreArchivo.'" no tiene registros de empleados para ingresar al sistema.<br>';
						}
						if($numCol > 18){
							$mensaje .= '* El archivo cargado al sistema tiene mas columnas de las definidas (18).<br>';
						}
						if($numCol < 18){
							$mensaje .= '* El archivo cargado al sistema tiene menos columnas de las definidas (18).<br>';
						}
						Yii::app()->user->setFlash('error', $mensaje);
					}
				}
				//print_r($modelOrigen->adjunto);
				//die;
			}
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_cargueOrigenComun', array('modelOrigen' => $modelOrigen), true, true)));
		}
	}
}
		
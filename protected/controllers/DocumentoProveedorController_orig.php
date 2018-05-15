<?php
set_time_limit(0);
class DocumentoProveedorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/bootstrap';
	public $defaultAction = 'gestion';
	public $model;
	public $menu_izquierdo;


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','campos','admin','view','adjunto','crearContrato','verImagen','crearTemporal',
				'adjuntoDocumento','confidencialidad','anexo','otros','terminacion','gestion','eliminarDocumento','aumentoPrecios',
				'aceptacion','otrosi','poliza','propuesta','enviarJuridico','gestionJuridico','updateJuridico','crearContratoJuridico',
				'crearTemporalJuridico','confidencialidadJuridico','anexoJuridico','otrosjuridico','terminacionJuridico','gestionJuridico',
				'aumentoPreciosJuridico','aceptacionJuridico','otrosiJuridico','polizaJuridico','propuestaJuridico', 'consulta','finalizados',
				'print','crearContratoConsulta',
				'crearTemporalConsulta','confidencialidadConsulta','anexoConsulta','otrosconsulta','terminacionConsulta','gestionConsulta',
				'aumentoPreciosConsulta','aceptacionConsulta','otrosiConsulta','polizaConsulta','propuestaConsulta','datosOrden','addProveedor','deleteProvAdicional'
				),
				'users'=>array('@'),
			),


			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function beforeAction(){
		// Reemplazamos datos con mascara
		if(isset($_POST['DocumentoProveedor'])){
			if(isset($_POST[DocumentoProveedor][valor])) {
			 $_POST[DocumentoProveedor][valor]=str_replace(',','',$_POST[DocumentoProveedor][valor] );
			}
			if(isset($_POST[DocumentoProveedor][cuerpo_contrato])) {
				$_POST[DocumentoProveedor][cuerpo_contrato]=str_replace(',','',$_POST[DocumentoProveedor][cuerpo_contrato] );
			}
			if(isset($_POST[DocumentoProveedor][anexos])) {
				$_POST[DocumentoProveedor][anexos]=str_replace(',','',$_POST[DocumentoProveedor][anexos] );
			}
			if(isset($_POST[DocumentoProveedor][polizas])) {
				$_POST[DocumentoProveedor][polizas]=str_replace(',','',$_POST[DocumentoProveedor][polizas] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pro_anio])) {
				$_POST[DocumentoProveedor][tiempo_pro_anio]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pro_anio] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pro_mes])) {
				$_POST[DocumentoProveedor][tiempo_pro_mes]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pro_mes] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pro_dia])) {
				$_POST[DocumentoProveedor][tiempo_pro_dia]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pro_dia] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pre_anio])) {
				$_POST[DocumentoProveedor][tiempo_pre_anio]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pre_anio] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pre_mes])) {
				$_POST[DocumentoProveedor][tiempo_pre_mes]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pre_mes] );
			}
			if(isset($_POST[DocumentoProveedor][tiempo_pre_dia])) {
				$_POST[DocumentoProveedor][tiempo_pre_dia]=str_replace(',','',$_POST[DocumentoProveedor][tiempo_pre_dia] );
			}
		}
		return true;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
		if(isset($_GET['id_proveedor'])){
			$proveedor=base64_decode($_GET['id_proveedor']);
			$model=new DocumentoProveedor('search_contratos');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['DocumentoProveedor'])){
				$model->attributes=$_GET['DocumentoProveedor'];
			}
			$this->render('view',array(
				'proveedor'=>$proveedor,'model'=>$model
			));

		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel(base64_decode($_GET[id_docpro]));
		if( $model->tipo_documento ==1 || $model->tipo_documento  ==2 ){
			$accion='crearContrato';
		}else if($model->tipo_documento ==3){
			$accion='confidencialidad';
		}else if($model->tipo_documento ==4){
			$accion='terminacion';
		}else if($model->tipo_documento ==5){
			$accion='crearTemporal';
		}else if($model->tipo_documento ==6){
			$accion='otrosi';
		}else if($model->tipo_documento ==7){
			$accion='aumentoPrecios';
		}else if($model->tipo_documento ==8){
			$accion='poliza';
		}else if($model->tipo_documento ==9){
			$accion='anexo';
		}else if($model->tipo_documento ==11){
			$accion='aceptacion';
		}else if($model->tipo_documento ==12){
			$accion='propuesta';
		}else if($model->tipo_documento ==13){
			$accion='otros';
		}
		$this->redirect(array($accion,'id_docpro'=>$_GET[id_docpro]));
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
		//	$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DocumentoProveedor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/listar';
		$model=new DocumentoProveedor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DocumentoProveedor']))
			$model->attributes=$_GET['DocumentoProveedor'];

		$this->model = $model;
		$this->render('admin',array(
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
		$model=DocumentoProveedor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='documento-proveedor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	**/
	public function actionCampos(){
            $tipo_documento= $_POST['tipo_documento'];
            $proveedor= $_POST['proveedor'];
            $model=new DocumentoProveedor;
            $model->proveedor=$proveedor;
            $respuesta[tipo_documento]=$tipo_documento;
            if($tipo_documento==3){
                $respuesta[res]=$this->renderPartial('confidencialidad', array('model'=>$model), true, false);
            }else if($tipo_documento==4){
                    $respuesta[res]=$this->renderPartial('terminacion', array('model'=>$model), true, false);
            }else if($tipo_documento==5){
                    $respuesta[res]=$this->renderPartial('temporal', array('model'=>$model), true, false);
            }else if($tipo_documento==1){
                    $respuesta[res]=$this->renderPartial('oferta_contrato', array('model'=>$model), true, false);
            }else if($tipo_documento==2){
                    $respuesta[res]=$this->renderPartial('oferta_contrato', array('model'=>$model), true, false);
            }else{
                    $respuesta[res]="";
            }
            echo CJSON::encode($respuesta);
	}

	public function actionAdjunto($proveedor,$tipo_documento,$id=null, $jur = false){
		/* $proveedor = $_GET[proveedor];
		$tipo_documento= $_GET[tipo_documento]; */
		$model= new DocumentoProveedor('adjunto_p');
                if($id != null){
                    $model = $model->findByPk (base64_decode($id));
                    $model->estado = 0;
                } 
		$model->proveedor= base64_decode($proveedor);
		$model->tipo_documento=$tipo_documento;
		$model->user_insert=Yii::app()->user->id;
		if(isset($_POST['DocumentoProveedor'])){
			if($model->validate()){
				$model->attributes=$_POST['DocumentoProveedor'];
				$archivo=CUploadedFile::getInstance($model,'path_archivo');
				// obtenemos consecutivo para nombrar el archivo
				$arch_cons= DocumentoProveedor::model()->count('tipo_documento=:td and proveedor =:p',array(':td'=>$tipo_documento, ':p'=>$model->proveedor) );
				$consec_arch= str_pad($arch_cons+1,3,'0',STR_PAD_LEFT);
				$model->orden_doc=$arch_cons+1;
				$ext= substr($archivo->name,strripos($archivo->name,'.'));
				$nombre_archivo= $model->proveedor."-".$tipo_documento."-".$consec_arch."-".date("YmdHis").$ext;
				$ruta=Yii::app()->params['vol_proveedores'].$model->proveedor.'/'.$nombre_archivo;
				$model->path_archivo=$ruta;
				if($archivo->name !=""){
					if( !is_dir(Yii::app()->params['vol_proveedores'].$model->proveedor)){
						mkdir(Yii::app()->params['vol_proveedores'].$model->proveedor);
					}
					if($model->save()){
						$archivo->saveAs($ruta);
						DocumentoProveedorTrazabilidad::insertarTrazabilidad(0,$model->id_docpro);
						if($tipo_documento==1){ //tipo Contrato
                                                    if($_POST[jur])
                                                        $this->redirect(array('gestion'));
                                                    else
							$this->redirect(array('crearContrato','id_docpro'=>base64_encode($model->id_docpro)));
						}
					}
				}
			}
		}
		$this->render('adjunto', array('model'=>$model, 'jur'=>$jur ));
	}

	public function actionCrearContrato(){ 
		$model=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model->setScenario('oferta_contrato');
		$model_detalle=new DocumentoProveedor('search_detalle');
		$model_traza= new DocumentoProveedorTrazabilidad('search');
		$model_traza->unsetAttributes();  // clear any default values
                $proveedores = new Proveedor('search');
		if(isset($_GET['Proveedor']))
			$proveedores->attributes=$_GET['Proveedor'];
		if(isset($_GET['DocumentoProveedorTrazabilidad']))
			$model_traza->attributes=$_GET['DocumentoProveedorTrazabilidad'];
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
			$model->tiempo_proroga = ($_POST['DocumentoProveedor']['tiempo_pro_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pro_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pro_dia']);
			$model->tiempo_preaviso= ($_POST['DocumentoProveedor']['tiempo_pre_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pre_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pre_dia']);
			// conversión de imagenes
			$ext= substr($model->path_archivo,strripos($model->path_archivo,'.'));
			if($ext=='.pdf' and isset($_POST[paginas]) and strlen($_POST[paginas])>0){
				/*$arr_pg= explode(',',$_POST[paginas]);
				$str="[";
				foreach($arr_pg as $dt){
					$ex_dt=explode('-',$dt);
					if ( count($ex_dt)==1 ){
						if($ex_dt[0]>0){
						   $str.="".($ex_dt[0]-1).",";
						}
					}else if( count($ex_dt)==2 ){
						if($ex_dt[0]>0 and $ex_dt[1]> 0){
						   $str.=($ex_dt[0]-1)."-".($ex_dt[1]-1).",";
						}
					}
				}

				$str= substr($str,0,-1)."] ";
				if(strlen($str)>3){
				exec("convert -density 280 -resize 35% -colorspace gray ".$model->path_archivo.$str.$model->path_archivo, $out,$code);
				}*/
                                try {
                                    $pdf = Yii::app()->pdfFactory->getFPDI();
                                    $pagecount = $pdf->setSourceFile($model->path_archivo);
                                    $paginas = $this->cualesPaginas($_POST[paginas]);
                                    if($paginas){
                                        $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                        for ($i = 1; $i <= $pagecount; $i++) {
                                                if($paginas[$i]){
                                                    $new_pdf->AddPage();
                                                    $new_pdf->useTemplate($pdf->importPage($i));

                                                }
                                        }
                                                $new_filename = $model->path_archivo;
                                                $new_pdf->Output($new_filename, "F");
                                    }
                                } catch (Exception $e) {
                                    try {
                                        $carpeta = dirname($model->path_archivo);
                                        exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH  -sOutputFile=".$carpeta."/version14.pdf ".$model->path_archivo);
                                        exec("mv ".$carpeta."/version14.pdf ".$model->path_archivo);
                                        $pdf2 = Yii::app()->pdfFactory->getFPDI();
                                        $pagecount = $pdf2->setSourceFile($model->path_archivo);
                                        $paginas = $this->cualesPaginas($_POST[paginas]);
                                        if($paginas){
                                            $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                            for ($i = 1; $i <= $pagecount; $i++) {
                                                    if($paginas[$i]){
                                                        $new_pdf->AddPage();
                                                        $new_pdf->useTemplate($pdf2->importPage($i));

                                                    }
                                            }
                                                    $new_filename = $model->path_archivo;
                                                    $new_pdf->Output($new_filename, "F");
                                        }
                                    } catch (Exception $exc) {
                                        echo Yii::app()->user->setFlash(' (\'Error al subir imagen: ',  $exc->getMessage(), "\n");
                                    }

                                      
                                }
                                
			}
			// fin conversión de imagenes
                        if($archivo=CUploadedFile::getInstance($model,'archivo_cambio')){
                                $archivo->saveAs($model->path_archivo);
                        }
			if(isset($_POST[yt0])  ){
				$model->setScenario('guardar_sin_enviar');
				if($model->save()){
					$this->redirect(array('gestion'));
				}
			}else if(isset($_POST[yt1])){
					if($model->save()){
						//'url'=>Yii::app()->createUrl("documentoProveedor/", array("id_proveedor" => base64_encode($model->proveedor),"id_docpro"=>$model->id_docpro));
						$this->redirect(array('adjuntoDocumento','id_proveedor'=>base64_encode($model->proveedor),"id_docpro"=>base64_encode($model->id_docpro),"tipo_documento"=>base64_encode($model->tipo_documento)));
					}
			}else if(isset($_POST[yt2]) || isset($_POST[yt3])){
				$model->setScenario('guardar_sin_enviar');
				$model->save();
			}
		}
		exec("identify -format %n ".$model->path_archivo,$out_np);
		$model->cuerpo_contrato=$out_np[0];
		$this->render('oferta_contrato',array('model'=>$model, 'model_detalle'=>$model_detalle,'model_traza'=>$model_traza,'proveedores'=>$proveedores ));
	}
        private function cualesPaginas($texto){
            $paginas = array();
            $texto = explode(',', $texto);
            foreach ($texto as $value) {
                if(is_numeric($value)){
                    $paginas[$value]=true;
                }
                else {
                    $value = explode('-', trim($value));
                    if($value[0] && $value[1]){
                        if($value[1]>$value[0]){
                            $cuantas = $value[1] - $value[0];
                            for($i = $value[0]; $i<=$value[1]; $i++){
                                $paginas[$i]=true;
                            }
                        }
                        else{
                            return false;
                        }
                    }
                    else {
                        return false;
                    }
                }
            } 
            return $paginas;
        }

        public function actionVerImagen(){
		set_time_limit(0);
		$file_path = $_GET['archivo'];
		$content= mime_content_type($file_path);
		header("Content-Type: $content");
		$file = @fopen($file_path,"rb");
		while(!feof($file))
		{
			print(@fread($file, 1024*8));
			ob_flush();
			flush();
		}
		//readfile($file);
	}

	public function actionCrearTemporal(){
		$primera=false;
		if(isset($_GET[id_docpro]) ){
			$id_docpro= base64_decode($_GET[id_docpro]);
			$model=$this->loadModel($id_docpro);
		}else{
			$model=new DocumentoProveedor();
			$model->proveedor=base64_decode($_GET[proveedor]);
			$primera=true;
		}
		$model->setScenario('temporal');

		$model->tipo_documento=5;
		$model_detalle=new DocumentoProveedor('search_detalle');
		$model_traza= new DocumentoProveedorTrazabilidad('search');
		$model_traza->unsetAttributes();  // clear any default values
		if(isset($_GET['DocumentoProveedorTrazabilidad']))
			$model_traza->attributes=$_GET['DocumentoProveedorTrazabilidad'];
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];

			if(isset($_POST[yt0])){
				$model->setScenario('guardar_sin_enviar');
				if($model->save()){
					if($primera){
						DocumentoProveedorTrazabilidad::insertarTrazabilidad(0,$model->id_docpro);
					}
					$this->redirect(array('view','id_proveedor'=>base64_encode($model->proveedor)));
				}
			}else if(isset($_POST[yt1])){
				if($model->save()){
					if($primera){
						DocumentoProveedorTrazabilidad::insertarTrazabilidad(0,$model->id_docpro);
					}
					$this->redirect(array('adjuntoDocumento','id_proveedor'=>base64_encode($model->proveedor),"id_docpro"=>base64_encode($model->id_docpro)));
				}
			}
		}
		$this->render('temporal',array('model'=>$model,'model_detalle'=>$model_detalle,'model_traza'=>$model_traza));
	}

	public function actionAdjuntoDocumento(){

		$proveedor=$_GET[id_proveedor];
		$id_docpro=base64_decode($_GET[id_docpro]);
		$tipo_documento_p=base64_decode($_GET[tipo_documento]);
                $fn = $_GET[fn];
		$model= new DocumentoProveedor('adjunto');
		$model->proveedor= base64_decode($proveedor);
		$model->id_doc_pro_padre=$id_docpro;
		$model->user_insert=Yii::app()->user->id;
		$model_padre=DocumentoProveedor::model()->findByPk($id_docpro);
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
			// se guarda el archivo
			if($model->validate()){
				$archivo=CUploadedFile::getInstance($model,'path_archivo');
				$arch_cons= DocumentoProveedor::model()->count('tipo_documento=:td and proveedor =:p',array(':td'=>$model->tipo_documento, ':p'=>$model->proveedor) );
				$consec_arch= str_pad($arch_cons+1,3,'0',STR_PAD_LEFT);
				$model->orden_doc=$arch_cons+1;
				$ext= substr($archivo->name,strripos($archivo->name,'.'));
				$nombre_archivo= $model->proveedor."-".$model->tipo_documento."-".$consec_arch."-".date("YmdHis").$ext;
				$ruta=Yii::app()->params['vol_proveedores'].$model->proveedor.'/'.$nombre_archivo;
				$model->path_archivo=$ruta;
				if($archivo->name !=""){
					if( !is_dir(Yii::app()->params['vol_proveedores'].$model->proveedor)){
						mkdir(Yii::app()->params['vol_proveedores'].$model->proveedor);
					}
					if($model->save()){
						$archivo->saveAs($ruta);
						if($model->tipo_documento==3){ // acuerdo
							$this->redirect(array('confidencialidad','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}else if($model->tipo_documento==4){ // carta terminación
							$this->redirect(array('terminacion','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==6){ // otro si
							$this->redirect(array('otrosi','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==7){ // aumento de precios
							$this->redirect(array('aumentoPrecios','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==8){ // poliza
							$this->redirect(array('poliza','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==9){ // anexo
							$this->redirect(array('anexo','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==11){ // carta aceptacion
							$this->redirect(array('aceptacion','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==12){ // propuesta comercial
							$this->redirect(array('propuesta','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}elseif($model->tipo_documento==13){ // otros
							$this->redirect(array('otros','id_docpro'=>base64_encode($model->id_docpro),'fn'=>$fn));
						}
					}
				}
			}
		}
		/* Verifica si el contrato se puede enviar a juridico */
		$cerrar=false;
		if($tipo_documento_p==1 or $tipo_documento_p==2 ){
			if($model_padre->estado==0 or $model_padre->estado==3){
				$ct_anexos= DocumentoProveedor::model()->count('id_doc_pro_padre=:p and tipo_documento in (9,3,12) and parte_del_contrato = true',array(':p'=>$model->id_doc_pro_padre));
				$ct_poliza= DocumentoProveedor::model()->findAll('id_doc_pro_padre=:p and tipo_documento=8',array(':p'=>$model->id_doc_pro_padre));
                                foreach ($ct_poliza as $doc) {
                                    if($doc->id_tipo_poliza != '')
                                        $suma_poli += count(explode(',', $doc->id_tipo_poliza));
                                }
				$anexo_ct= ($model_padre->anexos*1);
				$poliza_ct= ($model_padre->polizas*1);
				if( $ct_anexos == $anexo_ct   and  $suma_poli == $poliza_ct ){
						$cerrar=true;
				}
			}
		}else{
			$cerrar=true;
		}
		$this->render('adjuntoDocumento', array('model'=>$model, 'model_padre'=>$model_padre, 'cerrar'=>$cerrar, 'tipo_documento_p'=>$tipo_documento_p, 'fn'=>$fn ));
	}

	public function actionAnexo(){
		$this->cargarFormulario('anexo');
	}

	public function actionOtros(){
		$this->cargarFormulario('otros');
	}

	public function actionAumentoPrecios(){
		$this->cargarFormulario('aumentoprecios');
	}

	public function actionAceptacion(){
		$this->cargarFormulario('aceptacion');
	}

	public function actionPropuesta(){
		$this->cargarFormulario('propuesta');
	}

	public function actionconfidencialidad(){
		$this->cargarFormulario('confidencialidad');
	}

	public function actionTerminacion(){
		$this->cargarFormulario('terminacion');
	}

	public function actionGestion(){
            $model=new DocumentoProveedor('search_contratos');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['DocumentoProveedor'])){
                    $model->attributes=$_GET['DocumentoProveedor'];
            }
            $this->render('gestion',array(
                    'model'=>$model
            ));
	}

	public function actionConsulta(){
            $model=new DocumentoProveedor('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['DocumentoProveedor'])){
                    $model->attributes=$_GET['DocumentoProveedor'];
            }
            $this->render('consulta',array(
                    'model'=>$model
            ));
	}

	public function actionFinalizados(){
            $model=new DocumentoProveedor('search_finalizados');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['DocumentoProveedor'])){
                $model->attributes=$_GET['DocumentoProveedor'];
            }
            $this->render('finalizados',array(
                'model'=>$model
            ));
	}

	public function actionEliminarDocumento(){
            $id_docpro= base64_decode($_GET['id_d']);
            $model= new DocumentoProveedor();
            $model=$model->findByPk($id_docpro);
            if($model->delete()){
                unlink($model->path_archivo);
            }
	}

	public function actionOtrosi(){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario('otrosi');
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
		$model_ant = $model;
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
			$model->tiempo_proroga = ($_POST['DocumentoProveedor']['tiempo_pro_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pro_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pro_dia']);
			$model->tiempo_preaviso= ($_POST['DocumentoProveedor']['tiempo_pre_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pro_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pro_dia']);
			// conversión de imagenes
			$ext= substr($model->path_archivo,strripos($model->path_archivo,'.'));
			if($ext=='.pdf' and isset($_POST[paginas]) and strlen($_POST[paginas])>0){
				/*$arr_pg= explode(',',$_POST[paginas]);
				$str="[";
				foreach($arr_pg as $dt){
					$ex_dt=explode('-',$dt);
					if ( count($ex_dt)==1 ){
						if($ex_dt[0]>0){
						   $str.="".($ex_dt[0]-1).",";
						}
					}else if( count($ex_dt)==2 ){
						if($ex_dt[0]>0 and $ex_dt[1]> 0){
						   $str.=($ex_dt[0]-1)."-".($ex_dt[1]-1).",";
						}
					}
				}

				$str= substr($str,0,-1)."] ";
				if(strlen($str)>3){
				exec("convert -density 280 -resize 35% -colorspace gray ".$model->path_archivo.$str.$model->path_archivo, $out,$code);
				}*/
                                try {
                                    $pdf = Yii::app()->pdfFactory->getFPDI();
                                    $pagecount = $pdf->setSourceFile($model->path_archivo);
                                    $paginas = $this->cualesPaginas($_POST[paginas]);
                                    if($paginas){
                                        $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                        for ($i = 1; $i <= $pagecount; $i++) {
                                                if($paginas[$i]){
                                                    $new_pdf->AddPage();
                                                    $new_pdf->useTemplate($pdf->importPage($i));

                                                }
                                        }
                                                $new_filename = $model->path_archivo;
                                                $new_pdf->Output($new_filename, "F");
                                    }
                                } catch (Exception $e) {
                                    try {
                                        $carpeta = dirname($model->path_archivo);
                                        exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH  -sOutputFile=".$carpeta."/version14.pdf ".$model->path_archivo);
                                        exec("mv ".$carpeta."/version14.pdf ".$model->path_archivo);
                                        $pdf2 = Yii::app()->pdfFactory->getFPDI();
                                        $pagecount = $pdf2->setSourceFile($model->path_archivo);
                                        $paginas = $this->cualesPaginas($_POST[paginas]);
                                        if($paginas){
                                            $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                            for ($i = 1; $i <= $pagecount; $i++) {
                                                    if($paginas[$i]){
                                                        $new_pdf->AddPage();
                                                        $new_pdf->useTemplate($pdf2->importPage($i));

                                                    }
                                            }
                                                    $new_filename = $model->path_archivo;
                                                    $new_pdf->Output($new_filename, "F");
                                        }
                                    } catch (Exception $exc) {
                                        echo Yii::app()->user->setFlash(' (\'Error al subir imagen: ',  $exc->getMessage(), "\n");
                                    }

                                      
                                }
			}
			// fin conversión de imagenes
                        
                        if($archivo=CUploadedFile::getInstance($model,'archivo_cambio')){
                                $archivo->saveAs($model->path_archivo);
                        }
			if(isset($_POST[yt0])  ){
				if($model->save()){
					$observacion = 'Cambio los campos: ';
					$insertar = false;
					if($model_ant->valor != $model->valor && $model->valor != $model_contrato->valor){
						$insertar = true;
						$observacion .= 'valor, ';
					}

					if($model_ant->proroga_automatica != $model->proroga_automatica && $model->proroga_automatica != $model_contrato->proroga_automatica){
						$insertar = true;
						$observacion .= 'proroga automatica, ';
					}

					if($model_ant->tiempo_proroga != $model->tiempo_proroga && $model->tiempo_proroga != $model_contrato->tiempo_proroga){
						$insertar = true;
						$observacion .= 'tiempo proroga, ';
					}

					if($model_ant->tiempo_preaviso != $model->tiempo_preaviso && $model->tiempo_preaviso != $model_contrato->tiempo_preaviso){
						$insertar = true;
						$observacion .= 'tiempo preaviso, ';
					}

					if($insertar){
						$observacion = substr($observacion, 0, 2);
						DocumentoProveedorTrazabilidad::insertarTrazabilidad($model_contrato->estado,base64_decode($model[id_doc_pro_padre]));

					}
					$this->redirect(array('adjuntoDocumento',
						'id_proveedor'=>base64_encode($model->proveedor),
						"id_docpro"=>base64_encode($model->id_doc_pro_padre),
						"tipo_documento"=>base64_encode($tipo_documento_p)
					));
				}
			}else if(isset($_POST[yt1]) || isset($_POST[yt2])){
				$model->setScenario('guardar_sin_enviar');
				$model->save();
			}
		}
		$this->render('otrosi',array(
			'model'=>$model, 'model_contrato'=>$model_contrato,'tipo_documento_p'=>$tipo_documento_p
		));
	}

	public function actionPoliza(){
		$this->cargarFormulario('poliza');
	}

	private function cargarFormulario($vista){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
                $fn=$_GET[fn];
                if($model->id_tipo_poliza != '')
                    $model->id_tipo_poliza = explode(',', substr($model->id_tipo_poliza, 1, -1));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario($vista);
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
                $ct_anexos= DocumentoProveedor::model()->count('id_doc_pro_padre=:p and tipo_documento in (9,3,12) and parte_del_contrato = true',array(':p'=>$model->id_doc_pro_padre));
		if(isset($_POST['DocumentoProveedor']))
		{
                        
			$model->attributes=$_POST['DocumentoProveedor'];
                        if(isset($_POST['DocumentoProveedor']['id_tipo_poliza']))
                            $model->id_tipo_poliza = '{'. $_POST['DocumentoProveedor']['id_tipo_poliza'].'}';
                        
			// conversión de imagenes
			$ext= substr($model->path_archivo,strripos($model->path_archivo,'.'));
			if($ext=='.pdf' and isset($_POST[paginas]) and strlen($_POST[paginas])>0){
				/*$arr_pg= explode(',',$_POST[paginas]);
				$str="[";
				foreach($arr_pg as $dt){
					$ex_dt=explode('-',$dt);
					if ( count($ex_dt)==1 ){
						if($ex_dt[0]>0){
						   $str.="".($ex_dt[0]-1).",";
						}
					}else if( count($ex_dt)==2 ){
						if($ex_dt[0]>0 and $ex_dt[1]> 0){
						   $str.=($ex_dt[0]-1)."-".($ex_dt[1]-1).",";
						}
					}
				}

				$str= substr($str,0,-1)."] ";
				if(strlen($str)>3){
				exec("convert -density 280 -resize 35% -colorspace gray ".$model->path_archivo.$str.$model->path_archivo, $out,$code);
				}*/
                                try {
                                    $pdf = Yii::app()->pdfFactory->getFPDI();
                                    $pagecount = $pdf->setSourceFile($model->path_archivo);
                                    $paginas = $this->cualesPaginas($_POST[paginas]);
                                    if($paginas){
                                        $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                        for ($i = 1; $i <= $pagecount; $i++) {
                                                if($paginas[$i]){
                                                    $new_pdf->AddPage();
                                                    $new_pdf->useTemplate($pdf->importPage($i));

                                                }
                                        }
                                                $new_filename = $model->path_archivo;
                                                $new_pdf->Output($new_filename, "F");
                                    }
                                } catch (Exception $e) {
                                    try {
                                        $carpeta = dirname($model->path_archivo);
                                        exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH  -sOutputFile=".$carpeta."/version14.pdf ".$model->path_archivo);
                                        exec("mv ".$carpeta."/version14.pdf ".$model->path_archivo);
                                        $pdf2 = Yii::app()->pdfFactory->getFPDI();
                                        $pagecount = $pdf2->setSourceFile($model->path_archivo);
                                        $paginas = $this->cualesPaginas($_POST[paginas]);
                                        if($paginas){
                                            $new_pdf = Yii::app()->pdfFactory->getFPDI();
                                            for ($i = 1; $i <= $pagecount; $i++) {
                                                    if($paginas[$i]){
                                                        $new_pdf->AddPage();
                                                        $new_pdf->useTemplate($pdf2->importPage($i));

                                                    }
                                            }
                                                    $new_filename = $model->path_archivo;
                                                    $new_pdf->Output($new_filename, "F");
                                        }
                                    } catch (Exception $exc) {
                                        echo Yii::app()->user->setFlash(' (\'Error al subir imagen: ',  $exc->getMessage(), "\n");
                                    }

                                      
                                }
			}
			// fin conversión de imagenes
                        
                        if($archivo=CUploadedFile::getInstance($model,'archivo_cambio')){
                                $archivo->saveAs($model->path_archivo);
                        }
			if(isset($_POST[yt0])  ){
                            if($model->save()){
                                    $this->redirect(array('adjuntoDocumento',
                                            'id_proveedor'=>base64_encode($model->proveedor),
                                            "id_docpro"=>base64_encode($model->id_doc_pro_padre),
                                            "tipo_documento"=>base64_encode($tipo_documento_p)
                                    ));
                            }
			}else if(isset($_POST[yt1]) || isset($_POST[yt2])){
                            try {
				$model->setScenario('guardar_sin_enviar');
				$model->save();
                            } catch (Exception $ex) {

                            }
			}
		}
		$this->render($vista,array(
			'model'=>$model, 
                        'model_contrato'=>$model_contrato,
                        'tipo_documento_p'=>$tipo_documento_p, 
                        'ct_anexos'=>$ct_anexos, 
                        'fn'=>$fn,
		));
	}

	public function actionEnviarJuridico(){
		$model= $this->loadModel(base64_decode($_GET[id_docpro]));
		$model->estado=1;
		if($model->save()){
			DocumentoProveedorTrazabilidad::insertarTrazabilidad(1,base64_decode($_GET[id_docpro]));
			$this->redirect(array("documentoProveedor/view","id_proveedor"=>base64_encode($model[proveedor])));
		}
	}

	public function actionDatosOrden(){
			$id_orden=$_POST['id_orden'];
			$model= new Orden();
			$model=$model->findByPk($id_orden);
			echo CJSON::encode(array('id_gerencia'=>$model->id_gerencia,'id_jefatura'=>$model->id_jefatura));
	}
        
        public function actionAddProveedor($id_docpro, $nit) {
            
            $docAdicional = new DocumentoProveedorAdicional;
            $docAdicional->proveedor = $nit;
            $docAdicional->id_docpro = $id_docpro;
            $docAdicional->save();
            echo CJSON::encode(array('status'=>'success'));
        }
        
        public function actionDeleteProvAdicional($id) {
            
            $docAdicional =DocumentoProveedorAdicional::model()->findByPk($id);
            $docAdicional->delete();
            echo CJSON::encode(array('status'=>'success'));
        }
	/* funciones para el perfil de juridico */
	public function actionGestionJuridico(){
		$model=new DocumentoProveedor('search_juridico');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DocumentoProveedor'])){
                    $model->attributes=$_GET['DocumentoProveedor'];
		}
		$this->render('gestion_juridico',array('model'=>$model));
	}

	public function actionUpdateJuridico()
	{
            $model=$this->loadModel(base64_decode($_GET[id_docpro]));
            if( $model->tipo_documento ==1 || $model->tipo_documento  ==2 ){
                $accion='crearContratoJuridico';
            }else if($model->tipo_documento ==3){
                $accion='confidencialidadJuridico';
            }else if($model->tipo_documento ==4){
                $accion='terminacionJuridico';
            }else if($model->tipo_documento ==5){
                $accion='crearTemporalJuridico';
            }else if($model->tipo_documento ==6){
                $accion='otrosiJuridico';
            }else if($model->tipo_documento ==7){
                $accion='aumentoPreciosJuridico';
            }else if($model->tipo_documento ==8){
                $accion='polizaJuridico';
            }else if($model->tipo_documento ==9){
                $accion='anexoJuridico';
            }else if($model->tipo_documento ==11){
                $accion='aceptacionJuridico';
            }else if($model->tipo_documento ==12){
                $accion='propuestaJuridico';
            }else if($model->tipo_documento ==13){
                $accion='otrosJuridico';
            }
            $this->redirect(array($accion,'id_docpro'=>$_GET[id_docpro]));
	}

	public function actionCrearContratoJuridico(){
            $model=new DocumentoProveedor();
            $model=$model->findByPk(base64_decode($_GET[id_docpro]));
            $model->setScenario('oferta_contrato');
            $model_detalle=new DocumentoProveedor('search_detalle');
            $model_traza= new DocumentoProveedorTrazabilidad('search');
            $model_estado= new DocumentoProveedorTrazabilidad();
            if(isset($_POST['DocumentoProveedorTrazabilidad']) and ( isset($_POST['yt2']) or isset($_POST['yt1']) ) )
            {
                $model_estado->attributes=$_POST['DocumentoProveedorTrazabilidad'];
                $model->estado=2;
                if(isset($_POST[yt1])){
                    $mod_consec= TipoDocumentos::model()->find('id_tipo_documento=1');
                    $model->estado=2;
                    if($mod_consec->consecutivo >0){
                            $cons=$mod_consec->consecutivo+1;
                    }else{
                            $cons=1;
                    }
                    $mod_consec->consecutivo=$cons;
                    $model->consecutivo_contrato=$cons;
					
                    if($model->save() and $mod_consec->save()){
                            DocumentoProveedorTrazabilidad::insertarTrazabilidad(2,$model->id_docpro,$model_estado->observacion);
							$this->redirect(array('gestionJuridico'));
                    }
                }
                if(isset($_POST['yt2'])){
                    $model->estado=3;
					$model_estado->setScenario('devolver');
					$model_estado->user_insert=Yii::app()->user->id;
					$model_estado->estado=3;
					$model_estado->id_docpro=$model->id_docpro;
                    if($model->save() and $model_estado->save() ){
                            //DocumentoProveedorTrazabilidad::insertarTrazabilidad(3,$model->id_docpro,$model_estado->observacion);
							$this->redirect(array('gestionJuridico'));
                    }
                }
                
            }

            if(isset($_POST['DocumentoProveedor']) and isset($_POST[yt0]))
            {
                    $model->attributes=$_POST['DocumentoProveedor'];
                    $model->tiempo_proroga = ($_POST['DocumentoProveedor']['tiempo_pro_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pro_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pro_dia']);
                    $model->tiempo_preaviso= ($_POST['DocumentoProveedor']['tiempo_pre_anio']*12*30)+($_POST['DocumentoProveedor']['tiempo_pro_mes']*30)+($_POST['DocumentoProveedor']['tiempo_pro_dia']);
                    if(isset($_POST[yt0])){
                            $model->setScenario('guardar_sin_enviar');
                            if($model->save()){
                                    $this->redirect(array('gestionJuridico'));
                            }
                    }
            }

            $this->render('oferta_contrato_juridico',array('model'=>$model, 'model_detalle'=>$model_detalle,'model_traza'=>$model_traza, 'model_estado'=>$model_estado ));
	}

	public function actionCrearTemporalJuridico(){
		$primera=false;
		if(isset($_GET[id_docpro]) ){
			$id_docpro= base64_decode($_GET[id_docpro]);
			$model=$this->loadModel($id_docpro);
		}
		$model->setScenario('temporal');
		$model->tipo_documento=5;
		$model_detalle=new DocumentoProveedor('search_detalle');
		$model_traza= new DocumentoProveedorTrazabilidad('search');
		$model_estado= new DocumentoProveedorTrazabilidad('observacion');
		if(isset($_POST['DocumentoProveedorTrazabilidad']) and ( isset($_POST['yt2']) or isset($_POST['yt1']) ) )
		{
			$model_estado->attributes=$_POST['DocumentoProveedorTrazabilidad'];
			$model->estado=2;
			if(isset($_POST[yt1])){
				$mod_consec= TipoDocumentos::model()->find('id_tipo_documento=1');
				$model->estado=2;
				if($mod_consec->consecutivo >0){
					$cons=$mod_consec->consecutivo+1;
				}else{
					$cons=1;
				}
				$mod_consec->consecutivo=$cons;
				$model->consecutivo_contrato=$cons;
				if($model->save() and $mod_consec->save()){
					DocumentoProveedorTrazabilidad::insertarTrazabilidad(2,$model->id_docpro,$model_estado->observacion);
					$this->redirect(array('gestionJuridico'));
				}

			}
			if(isset($_POST['yt2'])){
				$model->estado=3;
				$model_estado->setScenario('devolver');
				$model_estado->user_insert=Yii::app()->user->id;
				$model_estado->estado=3;
				$model_estado->id_docpro=$model->id_docpro;
				if($model->save() and $model_estado->save() ){
						//DocumentoProveedorTrazabilidad::insertarTrazabilidad(3,$model->id_docpro,$model_estado->observacion);
						$this->redirect(array('gestionJuridico'));
				}
				
			}
		}
		if(isset($_POST['DocumentoProveedor']) and isset($_POST[yt0]))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
			if(isset($_POST[yt0])){
				$model->setScenario('guardar_sin_enviar');
				if($model->save()){
					$this->redirect(array('gestionJuridico'));
				}
			}
		}
		$this->render('temporal_juridico',array('model'=>$model,'model_detalle'=>$model_detalle,'model_traza'=>$model_traza,'model_estado'=>$model_estado));
	}

	private function cargarFormularioJuridico($vista){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
                if($model->id_tipo_poliza != '')
                    $model->id_tipo_poliza = explode(',', substr($model->id_tipo_poliza, 1, -1));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario($vista);
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
		$volver= $tipo_documento_p==1 ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
		if(isset($_POST['DocumentoProveedor']))
		{
                    $model->attributes=$_POST['DocumentoProveedor'];
                        if($model->save()){
                          $this->redirect(array("documentoProveedor/".$volver, "id_docpro"=>base64_encode($model->id_doc_pro_padre)));
                        }
		}
		$this->render($vista."_juridico",array(
                    'model'=>$model, 'model_contrato'=>$model_contrato,'tipo_documento_p'=>$tipo_documento_p
		));
	}

	public function actionOtrosiJuridico(){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario('otrosi');
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
		$volver= $tipo_documento_p==1 ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
				if($model->save()){
					$this->redirect(array("documentoProveedor/".$volver, "id_docpro"=>base64_encode($model->id_doc_pro_padre)
					));
				}
		}
		$this->render('otrosi_juridico',array(
			'model'=>$model, 'model_contrato'=>$model_contrato,'tipo_documento_p'=>$tipo_documento_p
		));
	}

	public function actionPolizaJuridico(){
		$this->cargarFormularioJuridico('poliza');
	}

	public function actionAnexoJuridico(){
		$this->cargarFormularioJuridico('anexo');
	}

	public function actionOtrosJuridico(){
		$this->cargarFormularioJuridico('otros');
	}

	public function actionAumentoPreciosJuridico(){
		$this->cargarFormularioJuridico('aumentoprecios');
	}

	public function actionAceptacionJuridico(){
		$this->cargarFormularioJuridico('aceptacion');
	}

	public function actionconfidencialidadJuridico(){
		$this->cargarFormularioJuridico('confidencialidad');
	}

	public function actionPropuestaJuridico(){
		$this->cargarFormularioJuridico('propuesta');
	}

	public function actionTerminacionJuridico(){
		$this->cargarFormularioJuridico('terminacion');
	}

	/* ------------------------ */

	/* funciones para perfil de consulta */
	public function actionPrint()
	{
		$model=$this->loadModel(base64_decode($_GET[id_docpro]));
		if( $model->tipo_documento ==1 || $model->tipo_documento  ==2 ){
			$accion='crearContratoConsulta';
		}else if($model->tipo_documento ==3){
			$accion='confidencialidadConsulta';
		}else if($model->tipo_documento ==4){
			$accion='terminacionConsulta';
		}else if($model->tipo_documento ==5){
			$accion='crearTemporalConsulta';
		}else if($model->tipo_documento ==6){
			$accion='otrosiConsulta';
		}else if($model->tipo_documento ==7){
			$accion='aumentoPreciosConsulta';
		}else if($model->tipo_documento ==8){
			$accion='polizaConsulta';
		}else if($model->tipo_documento ==9){
			$accion='anexoConsulta';
		}else if($model->tipo_documento ==11){
			$accion='aceptacionConsulta';
		}else if($model->tipo_documento ==12){
			$accion='propuestaConsulta';
		}else if($model->tipo_documento ==13){
			$accion='otrosConsulta';
		}
		$this->redirect(array($accion,'id_docpro'=>$_GET[id_docpro]));
	}


	/* ------------------------ */

	/* funciones para perfil de editar */

	public function actionCrearContratoConsulta(){
		$model=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model->setScenario('oferta_contrato');
		$model_detalle=new DocumentoProveedor('search_detalle');
		$model_traza= new DocumentoProveedorTrazabilidad('search');
		$model_estado= new DocumentoProveedorTrazabilidad('observacion');

		$this->render('oferta_contrato_consulta',array('model'=>$model, 'model_detalle'=>$model_detalle,'model_traza'=>$model_traza, 'model_estado'=>$model_estado ));
	}

		private function cargarFormularioConsulta($vista){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario($vista);
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
		$volver= $tipo_documento_p==1 ? 'crearContratoConsulta' : 'CrearTemporalConsulta';
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
				if($model->save()){
					$this->redirect(array("documentoProveedor/".$volver, "id_docpro"=>base64_encode($model->id_doc_pro_padre)
					));
				}
		}
		$this->render($vista."_consulta",array(
			'model'=>$model, 'model_contrato'=>$model_contrato,'tipo_documento_p'=>$tipo_documento_p
		));
	}

	public function actionOtrosiConsulta(){
		$model=new DocumentoProveedor();
		$model_contrato=new DocumentoProveedor();
		$model=$model->findByPk(base64_decode($_GET[id_docpro]));
		$model_contrato=$model_contrato->findByPk($model[id_doc_pro_padre]);
		$model->setScenario('otrosi');
		$tipo_documento_p=DocumentoProveedor::traerTipoDocumento($model[id_doc_pro_padre]);
		$volver= $tipo_documento_p==1 ? 'crearContratoJuridico' : 'CrearTemporalJuridico';
		if(isset($_POST['DocumentoProveedor']))
		{
			$model->attributes=$_POST['DocumentoProveedor'];
				if($model->save()){
					$this->redirect(array("documentoProveedor/".$volver, "id_docpro"=>base64_encode($model->id_doc_pro_padre)
					));
				}
		}
		$this->render('otrosi_consulta',array(
			'model'=>$model, 'model_contrato'=>$model_contrato,'tipo_documento_p'=>$tipo_documento_p
		));
	}

	public function actionPolizaConsulta(){
		$this->cargarFormularioConsulta('poliza');
	}

	public function actionAnexoConsulta(){
		$this->cargarFormularioConsulta('anexo');
	}
	public function actionOtrosConsulta(){
		$this->cargarFormularioConsulta('otros');
	}

	public function actionAumentoPreciosConsulta(){
		$this->cargarFormularioConsulta('aumentoprecios');
	}

	public function actionAceptacionConsulta(){
		$this->cargarFormularioConsulta('aceptacion');
	}

	public function actionconfidencialidadConsulta(){
		$this->cargarFormularioConsulta('confidencialidad');
	}

	public function actionTerminacionConsulta(){
		$this->cargarFormularioConsulta('terminacion');
	}

	public function actionCrearTemporalConsulta(){
		if(isset($_GET[id_docpro]) ){
			$id_docpro= base64_decode($_GET[id_docpro]);
			$model=$this->loadModel($id_docpro);
		}
		$model->setScenario('temporal');
		$model->tipo_documento=5;
		$model_detalle=new DocumentoProveedor('search_detalle');
		$model_traza= new DocumentoProveedorTrazabilidad('search');
		$model_estado= new DocumentoProveedorTrazabilidad('observacion');
		$this->render('temporal_consulta',array('model'=>$model,'model_detalle'=>$model_detalle,'model_traza'=>$model_traza,'model_estado'=>$model_estado));
	}
	/* ------------------------ */

	/* funciones para perfil de eliminar */

	/* ------------------------ */

}

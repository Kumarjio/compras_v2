<?php
Yii::import('ext.Googl');
class CitaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','search','admin','consultaEspecialista','adjuntarDocs','selectMedico','traerDisponibilidadProcedimiento','cortarUrl','traerDisponibilidadTodos','traerCitasDisponiblesTodos','seleccionarMedico','traerDisponibilidadMedico','traerCitasDisponibles','prueba'),
				'users'=>array('*'),
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
        
        public function actionPrueba() {
            $documentos = Yii::app()->db->createCommand("select dc.id_documento from disponibilidad di 
                                                                                inner join procedimientos p on di.id_procedimiento = p.id_procedimiento
                                                                                inner join documento_procedimiento dp on dp.id_procedimiento = p.id_procedimiento
                                                                                inner join documentos dc on dc.id_documento = dp.id_documento
                                                                        where di.id_disponibilidad = 1 ")->queryAll();
            foreach ($documentos as $key => $value) {
                echo $key .'=>'.$value['id_documento'].'<br>';
            }
        }
        
        public function actionCortarUrl() {
            $url_larga = 'http://ec2-52-91-211-143.compute-1.amazonaws.com/index.php/citas/disponibilidad/create';
            $gle = new Googl();
            $url_corta = $gle->shorten($url_larga, "AIzaSyA6QvU2PdBZJUWQUvPpYhCKVzxdc7IwwdQ");
            Yii::app()->whatsapp->enviaMsgText(array('573217854453'),$url_corta);
            
        }
	private function ajaxyForm($model){
		if(isset($_POST['Cita']))
		{
			
			$model->attributes=$_POST['Cita'];
			if($model->save()){
	            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
			}
		
		}else{
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('ajaxy_form', array('model' => $model), true)));
		}
	}

	public function actionSearch()
	{
		$total = 0;
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_GET['query']) && isset($_GET['query']) != ''){
				$c = new CDbCriteria;
				$c->condition = "nombre like :a";
				$c->params = array(":a" => '%'.$_GET['query'].'%');
				$total = Cita::model()->findAll($c);
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_autocomplete', array('total' => $total), true)));
			}else{
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_autocomplete', array('total' => $total), true)));
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
//                die($id_paciente);
		$model=new Cita;
                $disponibilidad = new Disponibilidad('search');
//		die(print_r($paciente));
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_POST['id_disponibilidad'])){
                             $model->id_disponibilidad =$_POST['id_disponibilidad'];
                             $model->id_paciente = $_POST['paciente'];
                             $model->id_especialidad = $_POST['especialidad'];
                             $model->paso_wf = "swCita/preagendado";
                             $model->save();
                             $dispo = Disponibilidad::model()->findByPk($_POST['id_disponibilidad']);
                             $dispo->estado = 1;
                            
                             if($model->save() && $dispo->save()){
                                 
                                    foreach ($documentos as $key => $value) {
                                        $recepcion_doc = new RecepcionDocumento;
                                        $recepcion_doc->id_cita = $model->id_cita;
                                        $recepcion_doc->id_documento = $value['id_documento'];
                                        $recepcion_doc->save();
                                    }
                                    
                                    $url = Yii::app()->params->urlSitio."index.php/citas/cita/adjuntarDocs/id/".$model->id_cita."/recordar/1";
                                    $gle = new Googl();
                                    $url_corta = $gle->shorten($url, "AIzaSyA6QvU2PdBZJUWQUvPpYhCKVzxdc7IwwdQ");
                                    $paciente = Paciente::model()->findByPk($_POST['paciente']);
                                    $mensaje="Señor(a): ".$paciente->nombre.", su cita ha sido preaprobada para el día: ".date("Y-m-d",strtotime($dispo->fecha))." ".$dispo->inicio. " recuerde que debe adjuntar los documentos necerarios para la aprobacion, si desea hacerlo en este momento ingrese aqui:  ".$url_corta ;
                                    Yii::app()->whatsapp->enviaMsgText(array('57'.$paciente->celular),$mensaje);
                                    $body = $this->renderPartial("_emailview", array('model'=>$model, 'url' => $url_corta),true);
                                    Yii::app()->mailer->enviarCorreo($paciente->correo,"Pre-aprobacion de cita",$body);
                                    $mens="Cita solicitada correctamente.";
                             }
                             else{
                                 die(print_r($model->getErrors()));
                             }
                             //$this->redirect(array('adjuntarDocs','id'=>$model->id_cita, 'recordar'=>true));
                             echo CJSON::encode(array('status'=>'success', 'content' => Yii::app()->createUrl('/citas/cita/adjuntarDocs',array('id'=>$model->id_cita, 'recordar'=>true))));
                             exit;
                        }
		}else{
//                        die ('muere.....' .print_r($_GET));
                        $id_paciente = $_GET['id'];
                        $model->id_paciente = $id_paciente;
                        $paciente = Paciente::model()->findByPk($id_paciente);
//                        die (print_r($paciente));
			if(isset($_POST['Cita']))
			{
				$model->attributes=$_POST['Cita'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id_cita));
			}

			$this->render('create',array(
				'model'=>$model,
                                'paciente'=>$paciente,
                                'disponibilidad'=>$disponibilidad
			));
	    }
		
	}

	public function actionAdjuntarDocs() {
            $model = $this->loadModel($_GET['id']);
            
            $documentos = Yii::app()->db->createCommand("select dc.id_documento from disponibilidad di 
                                                               inner join procedimientos p on di.id_procedimiento = p.id_procedimiento
                                                               inner join documento_procedimiento dp on dp.id_procedimiento = p.id_procedimiento
                                                               inner join documentos dc on dc.id_documento = dp.id_documento
                                                       where di.id_disponibilidad = $model->id_disponibilidad ")->queryAll();
            
            $this->render('adjuntar', array(
                'model'=>$model,
                'documento'=>$documentos,
            ));
        }
        
        public function actionTraerDisponibilidadProcedimiento(){
//            $id_recurso = Recursos::model()->findByAttributes(array('id_relacionado'=>$_POST['id_procedimiento'],'id_tipo_recurso' => 2))->id_recurso;
            $id_procedimiento = $_POST['id_procedimiento'];
            $festivo = new Festivos;
            $fecha_inicial = date('Y-m-d',  strtotime($festivo->sumarDias(date('Y-m-d'), 3)));
            $dias = Yii::app()->db->createCommand("select to_char(fecha,'yyyy-mm-dd') as dia from disponibilidad  where id_procedimiento = '".$id_procedimiento."' and estado = 0 and fecha > '$fecha_inicial' group by fecha")->queryAll();
            $dias_disponibles = array();
            
            foreach ($dias as $dia) {
                array_push($dias_disponibles, $dia['dia']);
            }
            $dias_disponibles = CJSON::encode($dias_disponibles);
            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('calendario', array('model' => $model, 'id_recurso'=>$id_recurso, 'dias_disponibles'=>$dias_disponibles), true)));
        }
        
        public function actionTraerDisponibilidadTodos() {
            $festivo = new Festivos;
            $fecha_inicial = date('Y-m-d',  strtotime($festivo->sumarDias(date('Y-m-d'), 3)));
            $dias = Yii::app()->db->createCommand("select to_char(fecha,'yyyy-mm-dd') as dia from disponibilidad  where id_recurso in (select id_recurso from recursos where id_tipo_recurso = 1) and estado = 0 and fecha > '$fecha_inicial' group by fecha")->queryAll();
            $dias_disponibles = array();
            foreach ($dias as $dia) {
                array_push($dias_disponibles, $dia['dia']);
            }
            $dias_disponibles = CJSON::encode($dias_disponibles);
            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('calendario_todos', array('model' => $model, 'dias_disponibles'=>$dias_disponibles), true)));
        }
        
        public function actionTraerDisponibilidadMedico(){
            $id_recurso= $_POST['id_recurso'];
            $festivo = new Festivos;
            $fecha_inicial = date('Y-m-d',  strtotime($festivo->sumarDias(date('Y-m-d'), 3)));
            $dias = Yii::app()->db->createCommand("select to_char(fecha,'yyyy-mm-dd') as dia from disponibilidad  where id_recurso = '".$id_recurso."' and estado = 0 and fecha > '$fecha_inicial' group by fecha")->queryAll();
            $dias_disponibles = array();
            foreach ($dias as $dia) {
                array_push($dias_disponibles, $dia['dia']);
            }
            $dias_disponibles = CJSON::encode($dias_disponibles);
            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('calendario_medico', array('model' => $model, 'id_recurso'=>$id_recurso, 'dias_disponibles'=>$dias_disponibles), true)));
        }
        
        public function actionTraerCitasDisponiblesTodos(){
            $fecha = $_POST['fecha'];
            $horas = Yii::app()->db->createCommand("select inicio from disponibilidad where id_recurso in (select id_recurso from recursos where id_tipo_recurso = 1) and fecha::text like '%$fecha%' group by 1 order by inicio")->queryAll();
            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('tabla_horas_todos', array('horas' => $horas,'fecha'=>$fecha), true)));
        }
        
        public function actionTraerCitasDisponibles(){
            $fecha = $_POST['fecha'];
            $id_recurso = $_POST['id_recurso'];
            $horas = Yii::app()->db->createCommand("select inicio,id_disponibilidad from disponibilidad where id_recurso = '".$id_recurso."' and fecha::text like '%$fecha%'")->queryAll();

            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('tabla_horas', array('horas' => $horas, 'fecha'=>$fecha), true)));
        }
        
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			if(isset($_POST['Cita']))
			{
				$model->attributes=$_POST['Cita'];
				if($model->save())
					$this->redirect(array('admin'));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
	}
        
        public function actionConsultaEspecialista() {
            $id_especialidad = $_POST['id_especialidad'];
            switch ($id_especialidad) {
                case 1:
                    echo CJSON::encode(array('status'=>'success', 'content' => '43258333 - HERNANDEZ GARZON LEIDY JOHANNA', 'id_recurso'=>1));
                    break;
                case 2:
                    echo CJSON::encode(array('status'=>'success', 'content' => '8263000 - GONZALEZ SOLANO VLADIMIR', 'id_recurso'=>2));
                    break;
                case 3:
                    echo CJSON::encode(array('status'=>'success', 'content' => '32100412 - DAZA VARGAS KARIN JULIETH', 'id_recurso'=>3));
                    break;
                case 4:
                    echo CJSON::encode(array('status'=>'success', 'content' => '5134569 - MORALES CASALLAS DANIEL YEZID', 'id_recurso'=>4));
                    break;
                case 5:
                    echo CJSON::encode(array('status'=>'success', 'content' => '30821333 - SANCHEZ ROMERO SILVIA TERESA', 'id_recurso'=>5));
                    break;

                default:
                    break;
            }
        }
        
        public function actionSelectMedico() {
            $id_procedimiento = $_POST ['Cita']['id_especialidad'] ;
            $festivo = new Festivos;
            $fecha_inicial = date('Y-m-d',  strtotime($festivo->sumarDias(date('Y-m-d'), 3)));
            $lista = CHtml::listData(Yii::app()->db->createCommand("select re.id_recurso, me.id_medico, me.primer_nombre||' '||me.segundo_nombre||' '||me.primer_apellido||' '||me.segundo_apellido as nombre from disponibilidad di 
                                                                            left join procedimientos p on di.id_procedimiento = p.id_procedimiento
                                                                            left join recursos re on re.id_recurso = di.id_recurso and p.id_tipo_prestacion = 1
                                                                            left join medicos me on me.id_medico = re.id_relacionado and re.id_tipo_recurso = 1
                                                                    where p.id_procedimiento = $id_procedimiento  and di.fecha > '$fecha_inicial' group by 1,2,3")->queryAll(), 'id_recurso', 'nombre');

             echo CHtml::tag('option', array('value'=>''), ' Todos los medicos', true);

            foreach ($lista as $valor=>$medico) {
                echo CHtml::tag('option', array('value'=>$valor), CHtml::encode($medico), true);
            }
        }
        
        public function actionSeleccionarMedico() {
            $id_especialidad = $_POST['id_especialidad'];
            $paciente = $_POST['paciente'];
            $hora = $_POST['hora'];
            $fecha = $_POST['fecha'];
            $combo = eregi_replace("[\n|\r|\n\r]", "", CHtml::dropDownList('medico_modal','algo',CHtml::listData(Yii::app()->db->createCommand("select d.id_disponibilidad, m.primer_nombre||' '||m.segundo_nombre||' '||m.primer_apellido||' '||m.segundo_apellido as nombre from disponibilidad as d inner join recursos as r on r.id_recurso = d.id_recurso inner join medicos as m on m.id_medico = r.id_relacionado where fecha::text like '%$fecha%' and inicio = '$hora'")->queryAll(),'id_disponibilidad', 'nombre'),array('class'=>'form-control')));
            $label = CHtml::label('Seleccione el Medico', 'medico', array('class' => 'control-label'));
            echo CJSON::encode(array('combo'=>$combo, 'id_especialidad'=>$id_especialidad, 'paciente'=>$paciente, 'hora'=>$hora, 'fecha'=>$fecha, 'label'=>$label));
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


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cita('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cita']))
			$model->attributes=$_GET['Cita'];

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
		$model=Cita::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}

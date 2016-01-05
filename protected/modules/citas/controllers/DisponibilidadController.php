<?php

class DisponibilidadController extends Controller
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
				'actions'=>array('create','update','delete','search','admin','traerDisponibilidad','traerCitasDisponibles', 'cargaRecurso', 'cargaMaquina', 'cargaProcedimiento', 'tipoProcedimiento'),
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

	private function ajaxyForm($model){
		if(isset($_POST['Disponibilidad']))
		{
			
			$model->attributes=$_POST['Disponibilidad'];
			if($model->save()){
	            echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
			}
		
		}else{
			echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('_form_ajaxy', array('model' => $model), true)));
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
				$total = Disponibilidad::model()->findAll($c);
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
	public function actionCreate(){

		$model=new Disponibilidad;
		$model->scenario = 'creaDisp';
		
		$dias = $this->traerDiasHabiles();
		if(isset($_POST['Disponibilidad'])){
			$model->attributes 	= $_POST['Disponibilidad'];

			if($model->validate()){
				$error = false;

				if(strtotime($model->fecha_inicio) > strtotime($model->fecha_fin)){
					$error = true;
					$mensaje = "La fecha inicial debe ser inferior o igual a la fecha final.";
				}

				if(strtotime($model->hora_inicio) >= strtotime($model->hora_fin)){
					$error = true;
					$mensaje = "La hora inicial debe ser inferior a la hora final.";
				}

				if($error){
					Yii::app()->user->setFlash('error', $mensaje);
				}else{
					$tiempo_cita = 20;
					
					$aux_fecha = strtotime($model->fecha_inicio);
					while($aux_fecha <= strtotime($model->fecha_fin)){

						$diaHabil = $this->validaDia(date("Y-m-d", $aux_fecha));

						if(!$diaHabil){
							$aux_hora = strtotime($model->hora_inicio);	
							$ocupado = 0;
							$citas = 0;
							while($aux_hora < strtotime($model->hora_fin)){
								$nueva_hora = date("H:i",$aux_hora + ($tiempo_cita * 60));	
								//Valida cupo disponible

								if(!empty($model->id_maquina)){
									$horas = Yii::app()->db->createCommand()
								    ->select('id_disponibilidad')
								    ->from('disponibilidad')
								    ->where(' ( id_recurso=:rec or id_maquina=:maq) and fecha=:fecha and (( :hora1 >= inicio AND :hora1 < fin) OR ( :hora2 > inicio  AND :hora2 < fin))', 
								    	array(':rec'=>$model->id_recurso, ':maq'=>$model->id_maquina, ':fecha'=>date("Y-m-d",$aux_fecha), ':hora1'=>date("H:i",$aux_hora), ':hora2'=>$nueva_hora ))
								    ->queryAll();
								}else{
									$horas = Yii::app()->db->createCommand()
								    ->select('id_disponibilidad')
								    ->from('disponibilidad')
								    ->where(' ( id_recurso=:rec ) and fecha=:fecha and (( :hora1 >= inicio AND :hora1 < fin) OR ( :hora2 > inicio  AND :hora2 < fin))', 
								    	array(':rec'=>$model->id_recurso, ':fecha'=>date("Y-m-d",$aux_fecha), ':hora1'=>date("H:i",$aux_hora), ':hora2'=>$nueva_hora ))
								    ->queryAll();
								}
								
								if($horas){
									$ocupado++;
								}else{
									$modelDisp = new Disponibilidad;
									$modelDisp->scenario = 'guarda';
									$modelDisp->fecha = date("Y-m-d", $aux_fecha);
									$modelDisp->inicio = date("H:i", $aux_hora);
									$modelDisp->fin = $nueva_hora;
									$modelDisp->id_recurso = $model->id_recurso;
									$modelDisp->id_procedimiento = $model->id_procedimiento;
									$modelDisp->id_maquina = $model->id_maquina;
									if($modelDisp->save())
										$citas++;
								}
								$aux_hora = strtotime($nueva_hora);
							}
						}					
						$aux_fecha = strtotime('+1 day', $aux_fecha);
					}
					
					if($citas>0){
						$mensaje = "Se ha generado la disponibilidad exitosamente, se crearón ".$citas." cupos de citas.";
						Yii::app()->user->setFlash('exito', $mensaje);
					}else{
						$mensaje = "Al sistema no logró generar disponibilidad para los rangos ingresados, se encontrarón ".$ocupado." cupos cruzados.";
						Yii::app()->user->setFlash('error', $mensaje);
					}
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'dias'=>$dias,
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
		if(Yii::app()->request->isAjaxRequest){
			$this->_ajaxyForm($model);
		}else{
			if(isset($_POST['Disponibilidad']))
			{
				$model->attributes=$_POST['Disponibilidad'];
				if($model->save())
					$this->redirect(array('admin'));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
	}

	public function actionTraerDisponibilidad(){
		$procedimiento 	= $_POST['procedimiento'];
        $id_recurso = $_POST['id_recurso'];
        $maquina 	= $_POST['id_maquina'];

        if(!empty($maquina)){
        	$dias = Yii::app()->db->createCommand("SELECT to_char(fecha,'yyyy-mm-dd') AS dia 
        										FROM disponibilidad  
        										WHERE ( id_procedimiento = '".$procedimiento."' AND id_recurso = '".$id_recurso."' AND id_maquina = '".$maquina."' AND estado = 0 AND fecha > now() )
        										GROUP BY fecha")->queryAll();
        }else{
        	$dias = Yii::app()->db->createCommand("SELECT to_char(fecha,'yyyy-mm-dd') AS dia 
        										FROM disponibilidad  
        										WHERE ( id_procedimiento = '".$procedimiento."' AND id_recurso = '".$id_recurso."' AND estado = 0 AND fecha > now() )
        										GROUP BY fecha")->queryAll();
        }

        $dias_disponibles = array();
        foreach ($dias as $dia) {
            array_push($dias_disponibles, $dia['dia']);
        }
        $dias_disponibles = CJSON::encode($dias_disponibles);
        echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('calendario', array('model' => $model, 'id_recurso'=>$id_recurso, 'dias_disponibles'=>$dias_disponibles), true)));
    }
    
    public function actionTraerCitasDisponibles(){
        $fecha = $_POST['fecha'];
        $id_recurso = $_POST['id_recurso'];
        $horas = Yii::app()->db->createCommand("select inicio,id_disponibilidad from disponibilidad where id_recurso = '".$id_recurso."' and fecha::text like '%$fecha%'")->queryAll();

        echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('tabla_horas', array('horas' => $horas), true)));
    }
        
    public function actionCargaProcedimiento(){
       	//$consulta 	= $_POST['Disponibilidad']['id_tipo_consulta'];
       	$consulta 	= $_POST['id_tipo_consulta'];
       	$proced	= $_POST['proc'];

        if($consulta == "1"){
        	$sql = "SELECT pro.id_procedimiento, esp.nombre_especialidad AS nombre 
        			FROM procedimientos AS pro
        			INNER JOIN especialidad AS esp ON pro.identificador = esp.id_especialidad 
        			WHERE pro.id_tipo_prestacion = '".$consulta."' ORDER BY nombre ASC";

        	$lista = Yii::app()->db->createCommand($sql)->queryAll();
        	$lista = CHtml::listData($lista, 'id_procedimiento','nombre');
        } 
        if($consulta == "2"){
        	$sql = "SELECT pro.id_procedimiento, ayu.nombre_ayuda AS nombre 
        			FROM procedimientos AS pro
        			INNER JOIN ayudas_diagnosticas AS ayu ON pro.identificador = ayu.id_ayuda_diagnostica 
        			WHERE pro.id_tipo_prestacion = '".$consulta."' ORDER BY nombre ASC";

        	$lista = Yii::app()->db->createCommand($sql)->queryAll();
        	$lista = CHtml::listData($lista, 'id_procedimiento','nombre');
        } 

        if(!empty($lista)){
        	echo CHtml::tag('option', array('value'=>""),'Seleccione Procedimiento',true);  
	        foreach ($lista as $valor => $procedimiento){
	        	if($proced == $valor)
	        		echo CHtml::tag('option',array('value'=>$valor, 'selected' => 'selected'),CHtml::encode($procedimiento), true);
	        	else
	        		echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($procedimiento), true);
	        }
	    }else{
	    	echo CHtml::tag('option', array(),'',true); 
	    }
    }

    public function actionCargaRecurso(){
        //$proc 	= $_POST['Disponibilidad']['id_procedimiento'];
        $proc 	= $_POST['id_procedimiento'];
        $recur 	= $_POST['recur'];

        $sqlPro = "SELECT * FROM procedimientos WHERE id_procedimiento = '".$proc."'";
        $procedimiento = Yii::app()->db->createCommand($sqlPro)->queryRow();

        $tipo = $procedimiento['id_tipo_prestacion'];
        $id_tipo = $procedimiento['identificador'];

        if($tipo == "1"){
        	$sql = "SELECT rec.id_recurso, (med.primer_nombre || ' ' || med.segundo_nombre || ' ' || med.primer_apellido || ' ' || med.segundo_apellido) AS nombre 
        			FROM recursos AS rec
        			INNER JOIN medicos AS med ON med.id_medico = rec.id_relacionado
        			INNER JOIN especialidad_recurso AS esp ON esp.id_recurso = rec.id_recurso 
        			WHERE esp.id_especialidad = '".$id_tipo."' ORDER BY nombre ASC";
        	$lista = Yii::app()->db->createCommand($sql)->queryAll();
        	$lista = CHtml::listData($lista, 'id_recurso','nombre');       	
        	echo CHtml::tag('option', array('value'=>""),'Seleccione Médico',true); 
        } 

        if($tipo == "2"){
        	$sql = "SELECT rec.id_recurso, aux.nombre_auxiliar AS nombre 
        			FROM recursos AS rec
        			INNER JOIN auxiliar AS aux ON aux.id_auxiliar = rec.id_relacionado
        			INNER JOIN ayuda_recurso AS ayu ON ayu.id_recurso = rec.id_recurso 
        			WHERE ayu.id_ayuda_diagnostica = '".$id_tipo."' AND rec.id_tipo_recurso = '2'
        			UNION ALL
        			SELECT rec.id_recurso, (med.primer_nombre || ' ' || med.segundo_nombre || ' ' || med.primer_apellido || ' ' || med.segundo_apellido) AS nombre 
        			FROM recursos AS rec
        			INNER JOIN medicos AS med ON med.id_medico = rec.id_relacionado
        			INNER JOIN ayuda_recurso AS ayu ON ayu.id_recurso = rec.id_recurso 
        			WHERE ayu.id_ayuda_diagnostica = '".$id_tipo."' AND rec.id_tipo_recurso = '1'
        			ORDER BY nombre ASC";

        	$lista = Yii::app()->db->createCommand($sql)->queryAll();
        	$lista = CHtml::listData($lista, 'id_recurso','nombre'); 
        	echo CHtml::tag('option', array('value'=>""),'Seleccione Recurso',true); 
        } 

        if(!empty($lista)){ 
	        foreach ($lista as $valor => $recurso){
	        	if($recur == $valor)
	        		echo CHtml::tag('option',array('value'=>$valor, 'selected' => 'selected'),CHtml::encode($recurso), true);
	        	else
	        		echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($recurso), true);
	        }
	    }else{
	    	echo CHtml::tag('option', array(),'',true); 
	    }
    }

    public function actionTipoProcedimiento(){
    	$id_procedimiento = $_POST['id_procedimiento'];

    	$sqlPro = "SELECT * FROM procedimientos WHERE id_procedimiento = '".$id_procedimiento."'";
        $tipo = Yii::app()->db->createCommand($sqlPro)->queryRow();

        echo json_encode($tipo);
    }

    public function actionCargaMaquina(){
       	$examen = $_POST['examen'];
       	$maqui = $_POST['maquina'];

        if(!empty($examen)){
        	$sql = "SELECT maq.id_maquina, maq.nombre_maquina AS nombre 
        			FROM maquina AS maq
        			INNER JOIN ayuda_maquina AS ayu ON ayu.id_maquina = maq.id_maquina 
        			WHERE ayu.id_ayuda_diagnostica = '".$examen."' AND maq.estado = '1'
        			ORDER BY nombre ASC";

        	$lista = Yii::app()->db->createCommand($sql)->queryAll();
        	$lista = CHtml::listData($lista, 'id_maquina','nombre'); 
        	echo CHtml::tag('option', array('value'=>""),'Seleccione Máquina',true); 
        } 

        if(!empty($lista)){ 
	        foreach ($lista as $valor => $maquina){
	        	if($maqui == $valor)
	        		echo CHtml::tag('option',array('value'=>$valor, 'selected' => 'selected'),CHtml::encode($maquina), true);
	        	else
	        		echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($maquina), true);
	        }
	    }else{
	    	echo CHtml::tag('option', array(),'',true); 
	    }
    }
        
	public function actionDelete(){

		if(Yii::app()->request->isPostRequest){
			if(isset($_POST['id_disponibilidad'])){

				$model = Disponibilidad::model()->findByPk($_POST['id_disponibilidad']);

				if($model->delete())
					return "Cupo eliminado!";
				else
					return "No se pudo eliminar el Cupo.";

			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function traerDiasHabiles(){

		$fechaMax = date("Y-m-d", strtotime('+1 year', strtotime(date("Y-m-d"))));
		$festivos = Yii::app()->db->createCommand()
				    ->select('fecha')
				    ->from('festivos')
				    ->where("fecha>=:actual AND fecha<=:fin AND tipo_dia IN ('D','F')", 
				    	array(':actual'=>date("Y-m-d"), ':fin'=>$fechaMax))
				    ->queryAll();

		$dias = array();
        foreach ($festivos as $dia)
            array_push($dias, $dia['fecha']);
        
        $dias = CJSON::encode($dias);
		return $dias;
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Disponibilidad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Disponibilidad']))
			$model->attributes=$_GET['Disponibilidad'];

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
		$model=Disponibilidad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function validaDia($dia){

		$esFestivo = Yii::app()->db->createCommand()
				    ->select('fecha')
				    ->from('festivos')
				    ->where("fecha=:dia AND tipo_dia IN ('D','F')", 
				    	array(':dia'=>$dia))
				    ->queryScalar();

		if($esFestivo)
			return true;
		else
			return false;
	}

}
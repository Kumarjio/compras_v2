<?php

class DefaultController extends Controller
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
	public function accessRules(){

		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('plano','planoEnt'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$this->render('index');
	}

	public function actionPlano(){

		$sql = "SELECT pa.cedula AS documento, pa.id_tipo_documento, pa.primer_apellido, pa.segundo_apellido, pa.primer_nombre,
				pa.segundo_nombre, pa.fecha_nacimiento, pa.id_departamento, pa.id_ciudad, pa.direccion, pa.telefono, pa.sexo, 
				pa.id_estado_civil, pa.correo, pa.id_ocupacion, pa.id_tipo_afiliado, pa.barrio, pa.nombre_acompanante
				FROM pacientes AS pa
				INNER JOIN cita AS ci ON ci.id_paciente = pa.id_paciente
				WHERE ci.fecha_solicitud BETWEEN '".date("Y-m-d")." 00:00:00"."' AND '".date("Y-m-d")." 23:59:59"."'
				AND ci.paso_wf = 'swCita/agendado' ";

		$command = Yii::app()->db->createCommand($sql);
		$data = $command->queryAll();

		$this->render('exportPlano',array('data'=>$data));
	}

	public function actionPlanoEnt(){

		$sql = "SELECT pa.cedula AS documento, en.nit, af.codigo_regimen, pa.id_categoria
				FROM pacientes AS pa
				INNER JOIN cita AS ci ON ci.id_paciente = pa.id_paciente
				LEFT JOIN entidad AS en ON en.id_entidad = pa.id_entidad
				LEFT JOIN tipo_afiliado AS af ON af.id_tipo_afiliado = pa.id_tipo_afiliado
				WHERE ci.fecha_solicitud BETWEEN '".date("Y-m-d")." 00:00:00"."' AND '".date("Y-m-d")." 23:59:59"."' 
				AND ci.paso_wf = 'swCita/agendado' ";

		$command = Yii::app()->db->createCommand($sql);
		$data = $command->queryAll();

		$this->render('exportPlanoEnt',array('data'=>$data));
	}
	
}
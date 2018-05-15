<?php

class InformeGlobalController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	public $defaultAction = 'admin';
	public $model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	
	/*protected function beforeAction($action)
	{	
		parent::beforeAction($action);
        $permiso = Permisos::model()->findByAttributes(array('nombre_accion'=>'AhorroSva/'.$action->id))->codigo;
        if($permiso != ''){
            if(!in_array($permiso,Yii::app()->user->permisos)){
                throw new CHttpException(400,'El usuario no tiene permisos para ejecutar esta acción.');
            }
        }
        else{
        throw new CHttpException(400,'El permiso para ejecutar esta acción aún no está configurado.');
        }
        
		return true;
            
    }*/
        
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','excel','todos','actualizarJefaturas','excelGerencia','excelNegociador'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar';
		$model=new InformeGlobalForm('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['InformeGlobalForm']) || isset($_GET['InformeGlobalForm'])){
			$model->attributes=(empty($_POST['InformeGlobalForm']))? $_GET['InformeGlobalForm'] : $_POST['InformeGlobalForm'] ;
			if($model->tipo_informe == 'N')
				$model->setScenario('negociador');
			elseif ($model->tipo_informe == 'G') {
				$model->setScenario('gerencias');
			}
			if($model->validate()){
				if($model->tipo_informe == 'N'){
					$informe_sva = new AhorroSva;
					$informe_cyc = new AhorroCyc;
					$vista_inform = $this->renderPartial('informe_negociador',array(
						'model'=>$model,
						'informe_cyc'=>$informe_cyc,
						'informe_sva'=>$informe_sva
					), true);
				}
				elseif ($model->tipo_informe == 'G') {
					$informe_gerencia = new InformeGerencias;
					$vista_inform = $this->renderPartial('informe_gerencia',array(
						'model'=>$model,
						'informe_gerencia'=>$informe_gerencia,
					), true);

				}
			}
		}
		$this->render('admin',array(
			'model'=>$model,
			'vista_inform'=>$vista_inform
		));
	}

	public function actionActualizarJefaturas(){
		$gerencias = implode(",", $_POST['InformeGlobalForm']['id_gerencia']);
		$jefaturas = Yii::app()->db->createCommand("select id, nombre as text from jefaturas where id_gerencia in ($gerencias)")->queryAll();
		echo CJSON::encode(array('tags'=>$jefaturas));
		exit;
	}
	
    public function actionExcelGerencia(){

		$model=new InformeGlobalForm;
		$model->unsetAttributes();  // clear any default values
		$model->attributes = $_GET;
		$informe_gerencia = new InformeGerencias('search');
		$this->render('informe_gerencia_excel',array(
			'model'=>$model,
			'informe_gerencia'=>$informe_gerencia,
		));
    }


    public function actionExcelNegociador(){

		$model=new InformeGlobalForm;
		$model->unsetAttributes();  // clear any default values
		$model->attributes = $_GET;
		$informe_sva = new AhorroSva;
		$informe_cyc = new AhorroCyc;
		$this->render('informe_negociador_excel',array(
			'model'=>$model,
			'informe_cyc'=>$informe_cyc,
			'informe_sva'=>$informe_sva
		));
    }

}

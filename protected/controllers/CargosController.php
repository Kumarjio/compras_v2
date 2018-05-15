<?php

class CargosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','create','update','admin','delete', 'selectGerencia', 'selectJefatura'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'actions' => array('index'),
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
		$model=new Cargos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cargos']))
		{
			$model->attributes=$_POST['Cargos'];
			if($model->validate()){
				switch ($model->tipo_cargo) {
					case '1':
						$model->es_jefe = 'Si';
						break;
					case '2':
						$model->es_gerente = 'Si';
						break;
					case '3':
						$model->es_vice = 'Si';
						break;
					default:
						break;
				}
				if($model->save())
					$this->redirect(array('admin'));
			}
		}
		if($model->id_vice != '')
			$gerencias = CHtml::listData(Gerencias::model()->findAll("id_vice = ".$model->id_vice), "id", "nombre");
		else
			$gerencias = CHtml::listData(Gerencias::model()->findAll("id_vice is null "), "id", "nombre");
		if($model->id_gerencia != '')
			$jefaturas = CHtml::listData(Jefaturas::model()->findAll("id_gerencia = ".$model->id_gerencia), "id", "nombre");
		else
			$jefaturas = array();

		$this->render('create',array(
			'model'=>$model,
			'gerencias'=>$gerencias,
			'jefaturas'=>$jefaturas
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

		if($model->es_jefe == "Si")
			$model->tipo_cargo = 1;
		if($model->es_gerente == "Si")
			$model->tipo_cargo = 2;
		if($model->es_jefe == "Si")
			$model->es_vice = 3;

		if(isset($_POST['Cargos']))
		{
			$model->attributes=$_POST['Cargos'];
			if($model->validate()){
				switch ($model->tipo_cargo) {
					case '1':
						$model->es_jefe = 'Si';
						$model->es_gerente = null;
						$model->es_vice = null;
						break;
					case '2':
						$model->es_gerente = 'Si';
						$model->es_jefe = null;
						$model->es_vice = null;
						break;
					case '3':
						$model->es_vice = 'Si';
						$model->es_jefe = null;
						$model->es_gerente = null;
						break;
					default:
						break;
				}
				$model->save();
				$this->redirect(array('admin'));
			}
		}
		if($model->id_vice != '')
			$gerencias = CHtml::listData(Gerencias::model()->findAll("id_vice = ".$model->id_vice), "id", "nombre");
		else
			$gerencias = CHtml::listData(Gerencias::model()->findAll("id_vice is null "), "id", "nombre");
		if($model->id_gerencia != '')
			$jefaturas = CHtml::listData(Jefaturas::model()->findAll("id_gerencia = ".$model->id_gerencia), "id", "nombre");
		else
			$jefaturas = array();

		$this->render('update',array(
			'model'=>$model,
			'gerencias'=>$gerencias,
			'jefaturas'=>$jefaturas
		));
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Cargos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//$this->layout = '//layouts/listar';
		$model=new Cargos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cargos']))
			$model->attributes=$_GET['Cargos'];

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
		$model=Cargos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionSelectGerencia() 
    {		

        $id_vice = $_POST ['Cargos']['id_vice'];
        if($id_vice){
        	$lista = Gerencias::model()->findAll('id_vice = :id_uno',array(':id_uno'=>$id_vice));
        	if(!$lista){
        		$lista = Jefaturas::model()->findAll('id_vice = :id_uno',array(':id_uno'=>$id_vice));
        		$id = 'Cargos_id_jefatura';
        		$id_vacio = 'Cargos_id_gerencia';
        	}
        	else{
        		$id = 'Cargos_id_gerencia';
        		$id_vacio = 'Cargos_id_jefatura';
    		}
        }
        else{
        	$lista = Gerencias::model()->findAll('id_vice is null');
    		$id = 'Cargos_id_gerencia';
    		$id_vacio = 'Cargos_id_jefatura';
        }
        $lista = CHtml::listData($lista, 'id', 'nombre');
        $options = $vacio = CHtml::tag('option',array('value'=>''),CHtml::encode("No Aplica"),true);
        foreach ($lista as $valor => $nombre) {
                $options .= CHtml::tag('option',array('value'=>$valor),CHtml::encode($nombre),true);
        }
        echo CJSON::encode(array('options'=>$options, 'id'=>$id, 'vacio'=>$vacio, 'id_vacio'=>$id_vacio));

    }

	public function actionSelectJefatura() 
    {		

        $id_gerencia = $_POST ['Cargos']['id_gerencia'];
        if($id_gerencia){
        	$lista = Jefaturas::model()->findAll('id_gerencia = :id_uno',array(':id_uno'=>$id_gerencia));
			$lista = CHtml::listData($lista, 'id', 'nombre');
        }
        else
        	$lista = array();

        echo CHtml::tag('option',array('value'=>''),CHtml::encode("No Aplica"),true);
        foreach ($lista as $valor => $nombre) {
                echo CHtml::tag('option',array('value'=>$valor),CHtml::encode($nombre),true);
        }

    }


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cargos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

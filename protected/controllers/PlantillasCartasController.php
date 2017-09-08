<?php

class PlantillasCartasController extends Controller
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
				'actions'=>array('create','update','admin','inhabilitar'),
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
		if(Yii::App()->request->isAjaxRequest){
			$model=new PlantillasCartas;
			$tipologias = new PlantillaTipologia;
			$aux = true;
			if(isset($_POST['PlantillasCartas'])){
				$model->attributes = $_POST['PlantillasCartas'];
				$tipologias->attributes=$_POST['PlantillaTipologia'];
				$model->plantilla = $_POST['html_carta'];
				if($model->validate() && $tipologias->validate()){
					if($model->save()){
						foreach ($tipologias->id_tipologia as $id_tipologia) {
							$PlantillaTipologia = new PlantillaTipologia;
							$PlantillaTipologia->id_plantilla = $model->id;
	        	    		$PlantillaTipologia->id_tipologia = $id_tipologia;
							$PlantillaTipologia->save();
						}
					}else{
						$aux = false;
					}
				}else{
					$aux = false;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('create', array('model' => $model,'tipologias' => $tipologias), true, true)));		
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('create', array('model' => $model,'tipologias' => $tipologias), true, true)));
			}

		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if(Yii::App()->request->isAjaxRequest){
			$aux = true;
			if(isset($_POST['PlantillasCartas'])){
				$model=PlantillasCartas::model()->findByPk($_POST['PlantillasCartas']['id']);
				$tipologias = new PlantillaTipologia;
				$model->attributes = $_POST['PlantillasCartas'];
				$tipologias->attributes=$_POST['PlantillaTipologia'];
				$model->plantilla = $_POST['carta_update'];
				if($model->validate() && $tipologias->validate()){
					if($model->save()){
						$user = PlantillaTipologia::model()->deleteAllByAttributes(array("id_plantilla"=>$model->id));
						foreach ($tipologias->id_tipologia as $id_tipologia) {
							$PlantillaTipologia = new PlantillaTipologia;
							$PlantillaTipologia->id_plantilla = $model->id;
	        	    		$PlantillaTipologia->id_tipologia = $id_tipologia;
							$PlantillaTipologia->save();
						}
					}else{
						$aux = false;
					}
				}else{
					$aux = false;
				}
			}else{
				$id = $_POST["id"];
				$model=$this->loadModel($id);
				$tipologias = new PlantillaTipologia;
				$tipologia = PlantillaTipologia::model()->findAllByAttributes(array("id_plantilla"=>$model->id));
				if($tipologia){
					$valor = array();
					$i = 0;
					foreach ($tipologia as $campo){
		        		$valor[$i] = $campo->id_tipologia;
		        		$i++;
					}
					$tipologias->id_tipologia = $valor;
				}
			}
			if($aux){
				echo CJSON::encode(array('status'=>'success', 'content' => $this->renderPartial('update', array('model' => $model,'tipologias' => $tipologias), true, true)));		
			}else{
				echo CJSON::encode(array('status'=>'error', 'content' => $this->renderPartial('update', array('model' => $model,'tipologias' => $tipologias), true, true)));
			}
		}
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PlantillasCartas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PlantillasCartas('search_detalle');
		$model->unsetAttributes();  // clear any default values
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PlantillasCartas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PlantillasCartas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PlantillasCartas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='plantillas-cartas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionInhabilitar()
	{
		$id = $_POST['id'];
		$model = PlantillasCartas::model()->findByPk($id);
		$model->activa = false;
		if($model->save()){
			die("<h5 align='center'>Plantilla Inhabilitada.</h5>");
		}else{
			die;
		}
	}
}
